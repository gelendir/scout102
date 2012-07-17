<?php

class FichePaiementController extends Controller
{

    private $famille;

    public function filters() {

        return array_merge( parent::filters(),
            array(
                'before'
            )
        );

    }

    public function filterBefore( $filterChain ) {

        $this->etape = 'fichePaiement';

        $idFamille = Yii::app()->user->idFamille;
        $this->famille = Famille::model()->findByPk( $idFamille );

        $filterChain->run();

    }

    public function getDebutSession()
    {
        return Util::debutSession();
    }

    public function getFinSession()
    {
        return Util::finSession();
    }

    public function genererTableauTarifs() {

        $dateVersements = array();
        $tarifsParEnfant = array();

        $debutSession = Util::formatDbDate( $this->debutSession );
        $finSession = Util::formatDbDate( $this->finSession );

        //Dans la base de données, les tarifs sont stockées sous forme de versements incrémental.
        //(Ex: 1 enfant = 95$, 2 enfants = 95$ + 35$, 3 enfants = 95$ + 35$ + 70$)
        //Par contre le tableau de paiements est sous forme de matrice. Nous avons donc besoin d'effectuer une transformation
        $requete = array(
            'condition' => "TOTAL = :total AND RABAIS = :rabais AND DATE_VERSEMENT BETWEEN :debutSession AND :finSession",
            'order'     => "NO_ENFANT ASC, DATE_VERSEMENT ASC",
            'params'    => array(
                'debutSession' => $debutSession,
                'finSession' => $finSession,
                'total' => false,
                'rabais' => false,
            ),
        );

        $tarifs = Tarif::model()->findAll( $requete );

        foreach( $tarifs as $tarif ) {

            $nbEnfant = $tarif->NO_ENFANT;

            //ce tableau sert à accumuler tout les tarifs pour un même nombre d'enfant.
            //les tarifs sont triés en ordre de date de versement
            if( !array_key_exists( $nbEnfant, $tarifsParEnfant ) ) {
                $tarifsParEnfant[ $nbEnfant ] = array();
            }

            //ce tableau sert à accumuler les dates à afficher dans l'entête du tableau.
            if( !in_array( $tarif->dateVersement, $dateVersements ) ) {
                $dateVersements[] = $tarif->dateVersement;
            }

            $rangee = &$tarifsParEnfant[ $nbEnfant ];

            //Vu que les tarifs sont incrémental, nous avons besoin d'accumuler le taux de chacun
            //à fin d'avoir un prix total pour chaque plage de nombre d'enfants.
            //Cette section additione le montant du tarif courant au total des tarifs pour la même
            //plage d'enfant
            $cumul = 0;
            if( $nbEnfant > 1 ) {

                $position = count( $rangee );
                $cumul = $tarifsParEnfant[ $nbEnfant - 1 ][ $position ];
            }

            $rangee[] = $cumul + $tarif->MONTANT;

        }

        $tableVars = array(
            'dateVersements' => $dateVersements,
            'tarifsParEnfant' => $tarifsParEnfant,
        );

        return $tableVars;

    }

    public function genererTarifVersements()
    {

        $debutSession = $this->debutSession;
        $finSession = $this->finSession;
        //TODO: le 3e paramêtre permet de spécifier si nous devons appliquer le rabais
        //animateur ou pas. il est à faux vu que nous avons pas eu le temps d'implémenter
        //et de tester le rabais animateur dans cette phase du projet
        $this->famille->genererVersements( $debutSession, $finSession, false );

    }

    public function actionIndex()
    {

        $this->genererTarifVersements();

        $tableauTarifs = $this->genererTableauTarifs();

        $scouts = Scout::model()->famille( $this->famille->ID_FAMILLE )->findAll();

        $this->render('index', array(
            'tableauTarifs' => $tableauTarifs,
            'scouts' => $scouts,
            'famille' => $this->famille,
            'debutSession' => $this->debutSession,
            'finSession' => $this->finSession,
        ) );

    }

    public function genererTransactionPaypal( $idTransaction ) {

        $parser = new PaypalParser(
            Yii::app()->params['paypalPdtKey'],
            Yii::app()->params['paypalApiUrl'],
            Yii::app()->params['paypalConnectMode']
        );

        Yii::log(
            "Processing transaction " . $idTransaction . " for user id " . Yii::app()->user->getId(),
            "info",
            "paiement"
        );

        //Le PaypalParser tentera de faire une requête au service Paypal pour récupérer les informations
        //sur la transaction qui vient d'être effectué chez Paypal
        try{
            $transaction = $parser->getTransactionInfo( $idTransaction );
        } catch( PaypalException $e ) {
            Yii::log(
                "Error processing transaction " . $idTransaction . " for user id " . Yii::app()->getId()
                . ". Error: " . $e->getCode() . " - " . $e->getMessage(),
                "error",
                "paiement"
            );
            throw new CHttpException( 500, "Error parsing transaction." . $e->getMessage() );
        }

        //La clé session sert à valider que la transaction paypal qui vient d'être effectué a bel et bien
        //été issu par notre système de paiements. Si la clé session est invalide, alors il y a une possibilité
        //de fraude et nous retournons un code d'erreur pour empêcher d'autres démarches
        $clefSession = $transaction['option_selection1'];

        $count = SessionPaypal::model()->count(
            "ID_ADULTE = :idAdulte AND CLEF_SESSION = :clefSession",
            array(
                'idAdulte' => Yii::app()->user->id,
                'clefSession' => $clefSession,
            )
        );

        if( $count <= 0 ) {
            throw new CHttpException( 500, "transaction session is not in the database" );
        }

        return $transaction;

    }

    public function actionPdt() {

        if( !isset( $_GET['tx'] ) ) {
            throw new CHttpException( 400, "Missing paypal transaction ID" );
        }

        //récupération de la transaction paypal effectué par le parent
        $idTransaction = $_GET['tx'];
        $transaction = $this->genererTransactionPaypal( $idTransaction );

        $montantAPayer = $this->famille->montantPaypal(
            $this->debutSession,
            $this->finSession
        );

        $paiement = PaiementPaypal::creerPaiement( $transaction );

        //validation que le montant payé est le même que le montant envoyé
        if( $paiement->MONTANT != $montantAPayer ) {
            throw new CHttpException( 400, "Payment amount is different from database amount");
        }

        $modePaiement = ModePaiement::model()->findByAttributes(
            array(
                'NOM_MODE' => 'paypal',
            )
        );

        //Nous avons maintenant besoin de créer une facture qui regroupe
        //tout les versements que le parent vient de payer
        $tarifVersements = $this->famille->versementsAPayer( 
            $this->debutSession, 
            $this->finSession 
        );

        $facture = Facture::avecTarifVersements( $tarifVersements );
        $facture->ID_MODE_PAIEMENT = $modePaiement->ID_MODE_PAIEMENT;
        $facture->MONTANT = $montantAPayer;
        Util::saveOrThrow( $facture );

        //Nous gardons aussi une trace de la transaction paypal dans notre base de données
        $paiement->ID_FACTURE = $facture->ID_FACTURE;
        Util::saveOrThrow( $paiement );

        SessionPaypal::model()->deleteAllByAttributes(
            array(
                'ID_ADULTE' => Yii::app()->user->id,
            )
        );

        $this->redirect( array( 'FichePaiement/facture', 'id' => $facture->ID_FACTURE ) );

    }

    public function actionPaypal()
    {

        if( !isset( $_POST['paypal'] ) ) {
            throw new CHttpException( 400, "Payments are not ready" );
        }

        $debutSession = $this->debutSession;
        $finSession = $this->finSession;
        $montant = $this->famille->montantPaypal( $debutSession, $finSession );

        //Validation que le parent a bel et bien des versements à payer
        if( $montant <= 0 ) {
            throw new CHttpException( 400, "No payements necessary" );
        }

        //Validation qu'il n'y a pas déja quelqu'un d'autre qui est en train de payer pour cette famille
        $count = SessionPaypal::model()->count(
            "ID_ADULTE = :idAdulte",
            array(
                'idAdulte' => Yii::app()->user->id,
            )
        );

        if( $count > 0 ) {
            throw new CHttpException( 400, "Payment session for this user already in progress" );
        }

        $nomItemPaypal = $this->nomItemPaypal();

        //Création d'une nouvelle session paypal qui sera utilisé pour valider le paiement à la fin du processus paypal
        $sessionPaypal = new SessionPaypal;
        $sessionPaypal->ID_ADULTE = Yii::app()->user->id;
        $sessionPaypal->MONTANT = $montant;
        $sessionPaypal->genererClef();

        Util::saveOrThrow( $sessionPaypal );

        //Génération d'une clé cryptographique unique qui sera retourné par paypal. Utilisé pour éviter la fraude de transaction
        $clef = $sessionPaypal->CLEF_SESSION;

        $this->render( 'paypal', array(
            'famille' => $this->famille,
            'clef' => $clef,
            'montant' => $montant,
            'nomItemPaypal' => $nomItemPaypal,
        ) );

    }

    private function nomItemPaypal()
    {
        $scouts = $this->famille->scoutsAPayer( $this->debutSession, $this->finSession );

        $nomScouts = array();
        foreach( $scouts as $scout ) {
            $nomScouts[] = CHtml::encode( $scout->nomComplet );
        }

        $nomScouts = implode( ", ", $nomScouts );
        $nomParent = CHtml::encode( Yii::app()->user->nomComplet );

        $nomItemPaypal = Yii::t( 'paiement', 'itemPaypal', array(
            '{scouts}' => $nomScouts,
            '{parent}' => $nomParent,
        ) );

        return $nomItemPaypal;

    }

    private function trouverFacture( $id )
    {

        $facture = Facture::model()
            ->with('versementFactures.versement')
            ->find(
                "t.ID_FACTURE = :idFacture AND versement.ID_FAMILLE = :idFamille",
                array(
                    'idFacture' => $id,
                    'idFamille' => $this->famille->ID_FAMILLE,
                )
            );

        if( $facture === null ) {
            throw new CHttpException( 404 );
        }

        return $facture;

    }

    public function actionFacture( $id )
    {

        $id = (int)$id;
        $facture = $this->trouverFacture( $id );
        $this->render( 'facture', array( 'facture' => $facture ) );

    }

    public function actionFacturePdf( $id )
    {

        $id = (int)$id;
        $facture = $this->trouverFacture( $id );

        $titre = Yii::t( 'paiement', 'titreFacturePdf' );
        $auteur = Yii::app()->params['pdf']['author'];
        $html = $this->renderPartial( '_facture', array( 'facture' => $facture ), true );

        $nomFichier =
            Yii::app()->user->id
            . "_" . date( 'Y-m-d_H-i' )
            . ".pdf";

        $dirPath = Yii::app()->runtimePath . "/paiementFacture";
        if( !file_exists( $dirPath ) ) {
            mkdir( $dirPath );
        }

        $filePath = $dirPath . "/" . $nomFichier;

        $pdf = new PdfGenerator( $titre, $auteur );
        $pdf->addHTMLPage( $html );
        $pdf->closeAndGenerate( $filePath );

        header('Content-Type: application/pdf');
        header('Content-Length: ' . filesize( $filePath ));
        header('Content-Disposition: attachment; filename="' . $nomFichier . '"');
        echo file_get_contents( $filePath );

    }

}
