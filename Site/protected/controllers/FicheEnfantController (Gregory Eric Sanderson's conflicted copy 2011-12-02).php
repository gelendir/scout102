<?php

class FicheEnfantController extends Controller
{

    public function filters()
    {
        return array_merge( parent::filters(), array(
            'before',
            'verifierAcces + edit, update',
        ) );
    }

    public function filterBefore( $filterChain )
    {
        $this->etape = "ficheEnfant";
        $filterChain->run();
    }

    public function filterVerifierAcces( $filterChain )
    {

        $idEnfant = Yii::app()->request->getParam( "id" );

        $count = Scout::model()->famille(
            Yii::app()->user->idFamille
        )->count();

        if( $count <= 0 ) {
            throw new CHttpException( 403 );
        }

        $filterChain->run();

    }

    public function genererScout() {

        $Scout = new Scout;
        $Scout->genererAutorisations();

        $RecuImpot = new RecuImpot('fiche');
        $Scout->recuImpot = $RecuImpot;
        $RecuImpot->scout = $Scout;

        $modAutorisation = new Autorisation;

        return $Scout;

    }

    public function actionIndex()
    {

        $this->etape = 'accueil';

        $enfants = Scout::model()
            ->famille( Yii::app()->user->idFamille )
            ->findAll();

        $this->render( 'index', array(
            'enfants' => $enfants
        ) );

    }

    public function actionNew()
    {
        $Scout = $this->genererScout();
        $this->render('new', array('Scout' => $Scout));
    }

    public function generateAutorisations( $model )
    {

        //Créer toutes les autorisations qu'un parent doit accepter
        //(Exemple: autorisation prise de photo, autorisation baignade)
        for($i=0; $i<count($_POST["Autorisation"]["ACCEPTATION"]); $i++)
        {

            $idAuto = $_POST["TypeAutorisation"]["ID_TYPE_AUTO"][$i];
            $reponse = $_POST["Autorisation"]["ACCEPTATION"][$i];

            $modAutorisation= new Autorisation;
            $modAutorisation->ACCEPTATION = $reponse;
            $modAutorisation->ID_TYPE_AUTO = $idAuto;
            $modAutorisation->ID_SCOUT = $model->ID_SCOUT;

            $autorisations[] = $modAutorisation;

        }

        $model->autorisations = $autorisations;

    }

    public function updateAutorisations( $model )
    {
        $nbAutorisations = count( $_POST['Autorisation']['ACCEPTATION'] );
        $autorisations = array();

        //Récupérer toutes les autorisations déja assignés à ce scout
        //et mettre les données à jour selon ce que le parent a rempli
        //dans la fiche
        for( $i = 0; $i < $nbAutorisations; $i++ ) 
        {

            $acceptation = $_POST['Autorisation']['ACCEPTATION'][$i];
            $idTypeAutorisation = $_POST["TypeAutorisation"]["ID_TYPE_AUTO"][$i];

            $autorisation = Autorisation::model()->findByAttributes(
                array(
                    'ID_TYPE_AUTO' => $idTypeAutorisation,
                    'ID_SCOUT' => $model->ID_SCOUT,
                )
            );

            if( $autorisation === null ) {
                throw new CHttpException( 400, "Autorisation does not exist");
            }

            $autorisation->ACCEPTATION = $acceptation;

            $autorisations[] = $autorisation;

        }

        $model->autorisations = $autorisations;

    }

    public function actionCreate()
    {

        $Scout = $this->genererScout();

        if (isset($_POST['Scout']) && isset($_POST['RecuImpot']))
        {
            $Scout->attributes = $_POST['Scout'];

            //La fiche scout contient une section sur le reçu d'impôt,
            //ce pourquoi nous créont le recu d'impot en même temps que le scout
            $recuImpot = $Scout->recuImpot;
            $recuImpot->attributes=$_POST['RecuImpot'];
            $recuImpot->validate();

            //générer des autorisations pour ce scout
            $this->generateAutorisations( $Scout );

            if( $Scout->validate() && $recuImpot->validate() )
            {

                //Nous avons besoin de sauver le scout en premier pour pouvoir
                //faire l'association entre le scout et le reçu d'impôt
                Util::saveOrThrow( $Scout );

                $recuImpot->ID_SCOUT = $Scout->ID_SCOUT;
                Util::saveOrThrow( $recuImpot );

                //Si le scout a été sauvegardé, alors nous pouvons créer les autorisations
                foreach( $Scout->autorisations as $autorisation ) {
                    $autorisation->ID_SCOUT = $Scout->ID_SCOUT;
                    $autorisation->save();
                }

                //Création de l'association entre le scout et la famille de son parent
                $familleScout = new FamilleScout;
                $familleScout->ID_FAMILLE = Yii::app()->user->idFamille;
                $familleScout->ID_SCOUT = $Scout->ID_SCOUT;
                $familleScout->save();

                $this->logEnfant( $Scout, 'create');
                $this->redirect(array('FicheMedicale/new', 'idScout' => $Scout->ID_SCOUT));


            }

        }

        //Erreur dans la fiche. Réafficher le formulaire
        $this->render( "create", array( 'Scout' => $Scout ) );
    }

    public function actionEdit( $id )
    {
        $id = (int)$id;

        $Scout = Scout::model()->findByPk( $id );

        if( $Scout === null ) {
            throw new CHttpException(404, "Ce scout n'existe pas");
        }

        $this->render( "edit", array( 'Scout' => $Scout ) );

    }

    public function actionUpdate( $id )
    {
        $id = (int)$id;

        $scout = Scout::model()->findByPk( $id );

        if( $scout === null ) {
            throw new CHttpException(404, "Ce scout n'existe pas");
        }

        $recuImpot = $scout->recuImpot;

        if( isset( $_POST['Scout'] ) && isset( $_POST['RecuImpot'] ) ) {

            $scout->attributes = $_POST['Scout'];
            $recuImpot->attributes = $_POST['RecuImpot'];

            //Mise à jour des autorisations
            $this->updateAutorisations( $scout );

            if( $scout->validate() && $recuImpot->validate() ) {

                //vu que les 2 formulaires sont valides, on peut les sauvegarder
                Util::saveOrThrow( $scout );
                Util::saveOrThrow( $recuImpot );

                //Sauvegarde des autorisations
                foreach( $scout->autorisations as $autorisation ) {
                    $autorisation->save();
                }
                $this->logEnfant( $scout, 'update');
                $this->redirect( array( 'FicheMedicale/edit', 'id' => $scout->ficheMedicale->ID_FICHE_MEDICALE ) );

            }

        }

        //Erreur dans la fiche. Réafficher le formulaire.
        $this->render( "update", array( 'Scout' => $scout ) );

    }

    public function logEnfant( $scout, $action)
    {
        $adr = "";
        $adr .= $scout->adresse->ADRESSE_RUE . " ";
        $adr .= $scout->adresse->VILLE . " ";
        $adr .= $scout->adresse->PROVINCE . " ";
        $adr .= $scout->adresse->CODE_POSTAL;

        $message = Yii::app()->user->nomComplet . " ";
        $message .= $action . " ";
        $message .= "Inscription_enfant - ";
        $message .= "Id_scout='" . $scout->ID_SCOUT. "';";
        $message .= "Prenom='" . $scout->PRENOM . "';";
        $message .= "Nom='" . $scout->NOM . "';";
        $message .= "Date_naissance='" . $scout->DATE_NAISSANCE . "';";
        $message .= "Sexe='" . $scout->SEXE . "';";
        $message .= "No_assurance_mal='" . $scout->NO_ASSURANCE_MALADIE . "';";
        $message .= "Date_fin_carte='" . $scout->DATE_FIN_CARTE_MEDICAL . "';";
        $message .= "particularite='" . $scout->PARTICULARITE . "';";
        $message .= "Adresse='" . $adr . "';";
        $message .= "cont_urg_nom='" . $scout->CONT_URG_NOM . "';";
        $message .= "cont_urg_no_tel='" . $scout->CONT_URG_NO_TEL . "';";
        $message .= "cont_urg_lien_jeune='" . $scout->CONT_URG_LIEN_JEUNE . "';";
        $message .= "cont_urg_prenom='" . $scout->CONT_URG_PRENOM . "';";
        $message .= "actif='" . $scout->ACTIF . "';";

        Yii::log(
                $message,
                "info",
                "journalisation"
            );
    }
}
