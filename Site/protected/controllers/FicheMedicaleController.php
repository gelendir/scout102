<?php

class FicheMedicaleController extends Controller
{
    public function filters()
    {
        return array_merge(
            parent::filters(),
            array(
                'before',
                'verifierAcces + edit, update',
            )
        );
    }

    public function filterBefore( $filterChain )
    {
        $this->etape = "ficheMedicale";
        $filterChain->run();
    }

    public function filterVerifierAcces( $filterChain )
    {

        $idFicheMedicale = Yii::app()->request->getParam( "id" );

        $count = FicheMedicale::model()
            ->with('scout.familleScout')
            ->count(
                "familleScout.ID_FAMILLE = :idFamille AND t.ID_FICHE_MEDICALE = :idFiche",
                array(
                    'idFamille' => Yii::app()->user->idFamille,
                    'idFiche' => $idFicheMedicale,
                )
            );

        if( $count <= 0 ) {
            throw new CHttpException( 403 );
        }

        $filterChain->run();

    }

    public function actionCreate()
    {

        //Fiche médicale
        $ficheMedicale = new FicheMedicale('fiche');

        //Scolarité
        $scolarite = new Scolarite('fiche');

        if(isset($_POST['FicheMedicale'])){

            PostProcessor::creationFicheMedicale( $ficheMedicale, $scolarite );

            $ficheMedicale->validate();
            $scolarite->validate();

            if( $ficheMedicale->validate() && $scolarite->validate() ) {

                Util::saveOrThrow( $ficheMedicale );
                Util::saveOrThrow( $scolarite );

                foreach( $ficheMedicale->reponseCases as $reponseCase ) {
                    $reponseCase->ID_FICHE_MEDICALE = $ficheMedicale->ID_FICHE_MEDICALE;
                    Util::saveOrThrow( $reponseCase );
                }

                foreach( $ficheMedicale->texteFicheChamps as $texteFiche ) {
                    $texteFiche->ID_FICHE_MEDICALE = $ficheMedicale->ID_FICHE_MEDICALE;
                    Util::saveOrThrow( $texteFiche );
                }

                $this->logFicheMedicale( $ficheMedicale, 'create');
                $this->redirect( array( 'FicheEnfant/index' ) );

            }

        }

        $this->render('create', array('ficheMedicale'=>$ficheMedicale, 'Scolarite'=>$scolarite));
    }

    public function actionEdit( $id )
    {
        $fiche = FicheMedicale::model()->findByPk( $id );

        if( $fiche === null ) {
            throw new CHttpException( 404 );
        }

        $scolarite = Scolarite::model()->findByAttributes(
            array(
                'ID_SCOUT' => $fiche->ID_SCOUT,
            )
        );

        $this->render('edit', array('ficheMedicale'=>$fiche, 'Scolarite'=>$scolarite, 'action'=>
                              array('ficheMedicale/update', 'id'=>$fiche->ID_FICHE_MEDICALE)));
    }

    public function actionNew( $idScout )
    {

        $idScout = (int)$idScout;
        $scout = Scout::model()->findByPk( $idScout );

        if( $scout === null ) {
            throw new CHttpException( 404, "Scout does not exist" );
        }

        $ficheMedicale = new FicheMedicale;
        $ficheMedicale->genererCases();
        $ficheMedicale->genererTexte();
        $ficheMedicale->ID_SCOUT = $idScout;

        //Informations scolaires
        $Scolarite = new Scolarite();

        $this->render('new', array('Scolarite'=>$Scolarite,
                                   'ficheMedicale' => $ficheMedicale));
    }

    public function actionUpdate( $id )
    {
        $ficheMedicale = FicheMedicale::model()->findByPk( $id );
        $ficheMedicale->scenario = 'fiche';

        $scolarite = Scolarite::model()->findByAttributes(
            array(
                'ID_SCOUT' => $ficheMedicale->ID_SCOUT,
            )
        );
        $scolarite->scenario = 'fiche';

        if(isset($_POST['FicheMedicale'])){

            PostProcessor::majFicheMedicale( $ficheMedicale, $scolarite );

            $ficheMedicale->validate();
            $scolarite->validate();

            if( $ficheMedicale->validate() && $scolarite->validate() ) {

                Util::saveOrThrow( $ficheMedicale );
                Util::saveOrThrow( $scolarite );

                foreach( $ficheMedicale->reponseCases as $reponseCase ) {
                    Util::saveOrThrow( $reponseCase );
                }

                foreach( $ficheMedicale->texteFicheChamps as $texteFicheChamp ) {
                    Util::saveOrThrow( $texteFicheChamp );
                }

                $this->logFicheMedicale( $ficheMedicale, 'update');
                $this->notification( $ficheMedicale );

                $this->redirect( array( 'FicheEnfant/index' ) );

            }
        }

        $this->render('update', array('ficheMedicale'=>$ficheMedicale,
                                        'scolarite'=>$scolarite,
                                        'action' => array( 'FicheMedicale/update', 'id' => $ficheMedicale->ID_FICHE_MEDICALE ),
                                        ));
    }

    public function actionAutocomplete( $term )
    {
        if( trim( $term ) == "" ) {
            return;
        }

        $command = Yii::app()->db->createCommand()
            ->select(  array(
                'ID_ECOLE AS id',
                'NOM_ECOLE AS label',
                'NOM_ECOLE AS value',
            ) )
            ->from( 'ECOLE' )
            ->where(
                "LOWER( NOM_ECOLE ) LIKE LOWER( :term )",
                array(
                    'term' => '%' . $term . '%',
                )
            )
            ->order( 'NOM_ECOLE' );

        $rows = $command->queryAll();

        if( Yii::app()->request->isAjaxRequest ) {

            echo CJSON::encode( $rows );

        }

    }

    private function notification( $ficheMedicale ) 
    {

        $notification = new Notification();
        $nom = Scout::model()->findByAttributes(array('ID_SCOUT' => $ficheMedicale->ID_SCOUT,));
        $notification->TITRE = "Fiche medicale modifiee";
        $notification->MESSAGE = "La fiche medicale de " . $nom->PRENOM . " " . $nom->NOM . " a ete modifiee par " . Yii::app()->user->nomComplet . " (parent)";
        $notification->DATE_ENVOIE = DATE('Y-m-d');
        $notification->LU = 0;
        $notification->IMPORTANT = 0;

        $roleNotification = new RoleNotification();
        $roleNotification->ID_ROLE = 1;
        $roleNotification->ID_NOTIFICATION = $notification->ID_NOTIFICATION;

        $notification->save();
        $roleNotification->save();

    }

    public function logFicheMedicale( $fiche, $action)
    {
        $reponsesEtats = $fiche->reponseCases;
        $strEtat = "";
        $reponsesTextes = $fiche->texteFicheChamps;
        $strTexte = "";

        foreach($reponsesEtats as $reponseEtat)
        {
            $strEtat .= $reponseEtat->caseACocher->DESCRIPTION . "=";
            $strEtat .= "[" . $reponseEtat->REPONSE . "] ";
        }

        foreach($reponsesTextes as $reponseTexte)
        {
            $strTexte .= $reponseTexte->categorieChampTexte->DESCTRIPTION . "=";
            $strTexte .= "[" . $reponseTexte->TEXTE . "] ";
        }

        $message = Yii::app()->user->nomComplet . " ";
        $message .= $action . " ";
        $message .= "fiche_medicale - ";
        $message .= "Id_scout='" . $fiche->scout->ID_SCOUT . "';";
        $message .= "Id_nom='" . $fiche->scout->NOM . "';";
        $message .= "Id_prenom='" . $fiche->scout->PRENOM . "';";
        $message .= "Fiche_confirme='" . $fiche->FICHE_CONFIRME . "';";
        $message .= "Date_creation='" . $fiche->DATE_CREATION . "';";
        $message .= "Date_MAJ='" . $fiche->DATE_MAJ . "';";
        $message .= "Reponse_etat='" . $strEtat . "';";
        $message .= "Reponse_texte='" . $strTexte . "';";

        Yii::log(
                $message,
                "info",
                "journalisation"
            );
    }
}
