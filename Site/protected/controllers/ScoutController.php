<?php

class ScoutController extends AdminController
{

    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array_merge( parent::filters(), array(
            'before',
        ) );
    }

    public function filterBefore( $filterChain )
    {
        $filterChain->run();
    }

    public function genererScout() {

        $Scout = new Scout;
        $Scout->genererAutorisations();

        $RecuImpot = new RecuImpot('fiche');
        $Scout->recuImpot = $RecuImpot;
        $RecuImpot->scout = $Scout;

        return $Scout;

    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionNew()
    {
        $this->render( 'new' );
    }

    public function actionCreateFamily()
    {

        $famille = Famille::model()->findByPk( $_POST['idFamille'] );

        $scout = $this->genererScout();

        $ficheMedicale = new FicheMedicale();
        $ficheMedicale->genererCases();
        $ficheMedicale->genererTexte();

        $scolarite = new Scolarite();

        $this->render('createFamily',
            array(
                'model'=>$scout,
                'scolarite'=>$scolarite,
                'ficheMedicale' => $ficheMedicale,
                'famille' => $famille,
            )
        );

    }

    public function actionCreate()
    {

        $scout = $this->genererScout();
        $recuImpot = $scout->recuImpot;

        $ficheMedicale = new FicheMedicale('admin');
        $ficheMedicale->genererCases();
        $ficheMedicale->genererTexte();

        $famille = Famille::model()->findByPk( $_POST['idFamille'] );

        $scolarite = new Scolarite();

        if (
            isset($_POST['Scout'])
            && isset($_POST['RecuImpot'])
            && isset($_POST['FicheMedicale'])
            && isset($_POST['Scolarite'])
        )
        {
            $scout->attributes = $_POST['Scout'];
            $recuImpot->attributes=$_POST['RecuImpot'];
            PostProcessor::creationFicheMedicale( $ficheMedicale, $scolarite );
            PostProcessor::creationAutorisations( $scout );

            $valid = $scout->validate();
            $valid = $recuImpot->validate() && $valid;
            $valid = $ficheMedicale->validate() && $valid;
            $valid = $scolarite->validate() && $valid;

            if( $valid ) {

                Util::saveOrThrow( $scout );

                $recuImpot->ID_SCOUT = $scout->ID_SCOUT;
                $scolarite->ID_SCOUT = $scout->ID_SCOUT;
                $ficheMedicale->ID_SCOUT = $scout->ID_SCOUT;

                Util::saveOrThrow( $recuImpot );
                Util::saveOrThrow( $ficheMedicale );
                Util::saveOrThrow( $scolarite );

                $familleScout = new FamilleScout;
                $familleScout->ID_FAMILLE = Yii::app()->user->idFamille;
                $familleScout->ID_SCOUT = $scout->ID_SCOUT;

                Util::saveOrThrow( $familleScout );

                foreach( $scout->autorisations as $autorisation ) {
                    $autorisation->ID_SCOUT = $scout->ID_SCOUT;
                    Util::saveOrThrow( $autorisation );
                }

                foreach( $ficheMedicale->reponseCases as $reponseCase ) {
                    $reponseCase->ID_FICHE_MEDICALE = $ficheMedicale->ID_FICHE_MEDICALE;
                    Util::saveOrThrow( $reponseCase );
                }

                foreach( $ficheMedicale->texteFicheChamps as $texteFicheChamp ) {
                    $texteFicheChamp->ID_FICHE_MEDICALE = $ficheMedicale->ID_FICHE_MEDICALE;
                    Util::saveOrThrow( $texteFicheChamp );
                }

                $this->logScout($scout, 'create');
                $this->redirect( array( 'Scout/index') );

            }

        }

        $this->render('create',
            array(
                'model'=>$scout,
                'ficheMedicale'=>$ficheMedicale,
                'scolarite'=>$scolarite,
                'famille' => $famille,
                'action' => array( 'Scout/create' ),
            )
        );

    }

    public function actionEdit($id)
    {
        $id = (int)$id;

        $model = Scout::model()->findByPk( $id );

        if( $model === null )
        {
            throw new CHttpException(404, "Ce scout n'existe pas");
        }

        if( $model->ficheMedicale == null ) {
            $model->ficheMedicale = new FicheMedicale('admin');
        }

        $ficheMedicale = $model->ficheMedicale;
        $scolarite = $model->scolarite;
        $famille = Famille::model()->findByPk( $model->idFamille );

        $this->render('edit', array(
            'ficheMedicale'=>$ficheMedicale,
            'scolarite'=>$scolarite,
            'action' => array( 'Scout/update', 'id' => $id ),
            'model'=>$model,
            'famille' => $famille,
        ) );
    }

    public function actionUpdate($id)
    {
        $scout = Scout::model()->findByPk($id);
        if( $scout === null )
        {
            throw new CHttpException(404, "Ce scout n'existe pas");
        }

        $recuImpot = $scout->recuImpot;

        if( $scout->ficheMedicale == null ) {
            $scout->ficheMedicale = new FicheMedicale('admin');
        }

        $ficheMedicale = $scout->ficheMedicale;
        $ficheMedicale->scenario = 'admin';

        $scolarite = $scout->scolarite;
        $famille = Famille::model()->findByPk( $scout->idFamille );

        if (
            isset($_POST['Scout'])
            && isset($_POST['RecuImpot'])
            && isset($_POST['FicheMedicale'])
            && isset($_POST['Scolarite'])
        )
        {

            $scout->attributes = $_POST['Scout'];
            $recuImpot->attributes = $_POST['RecuImpot'];
            PostProcessor::majFicheMedicale( $ficheMedicale, $scolarite );
            PostProcessor::majAutorisations( $scout );

            $valid = $scout->validate();
            $valid = $recuImpot->validate() && $valid;
            $valid = $ficheMedicale->validate() && $valid;
            $valid = $scolarite->validate() && $valid;

            if( $valid ) {

                $ficheMedicale->ID_SCOUT = $scout->ID_SCOUT;

                Util::saveOrThrow( $scout );
                Util::saveOrThrow( $recuImpot );
                Util::saveOrThrow( $scolarite );
                Util::saveOrThrow( $ficheMedicale );

                foreach( $scout->autorisations as $autorisation ) {
                    Util::saveOrThrow( $autorisation );
                }

                foreach( $ficheMedicale->reponseCases as $reponseCase ) {
                    Util::saveOrThrow( $reponseCase );
                }

                foreach( $ficheMedicale->texteFicheChamps as $texteFicheChamp ) {
                    Util::saveOrThrow( $texteFicheChamp );
                }
                $this->logScout($scout, 'update');
                $this->notificationScout( $scout );
                
                $this->redirect( array( 'Scout/index' ) );

            }
        }

        $this->render('update', array(
            'ficheMedicale'=>$ficheMedicale,
            'scolarite'=>$scolarite,
            'action' => array( 'Scout/update', 'id' => $id ),
            'model'=>$scout,
            'famille' => $famille,
        ) );

    }

    public function notificationScout( $scout )
    {

        $notification = new Notification();
        $nom = $scout->nomComplet;
        $notification->TITRE = "Fiche medicale modifiee";
        $notification->MESSAGE = "La fiche de scout(information + fiche medicale) de " . $nom . " a ete modifiee par " . Yii::app()->user->nomComplet . " (admin)";
        $notification->DATE_ENVOIE = DATE('Y-m-d');
        $notification->LU = 0;
        $notification->IMPORTANT = 0;

        $roleNotification = new RoleNotification();
        $roleNotification->ID_ROLE = 1;
        $roleNotification->ID_NOTIFICATION = $notification->ID_NOTIFICATION;

        $notification->save();
        $roleNotification->save();

    }

    public function logScout( $scout, $action)
    {
        $fiche = $scout->ficheMedicale;
        $reponsesEtats = $fiche->reponseCases;
        $strEtat = "";
        $reponsesTextes = $fiche->texteFicheChamps;
        $strTexte = "";

        $adr = "";
        $adr .= $scout->adresse->ADRESSE_RUE . " ";
        $adr .= $scout->adresse->VILLE . " "; 
        $adr .= $scout->adresse->PROVINCE . " ";
        $adr .= $scout->adresse->CODE_POSTAL;

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
        $message .= "fiche_scout - ";
        $message .= "Id_scout=" . $scout->ID_SCOUT . " ";
        $message .= "Prenom=" . $scout->PRENOM . " ";
        $message .= "Nom=" . $scout->NOM . " ";
        $message .= "Date_naissance=" . $scout->DATE_NAISSANCE . " ";
        $message .= "Sexe=" . $scout->SEXE . " ";
        $message .= "No_assurance=" . $scout->NO_ASSURANCE_MALADIE . " ";
        $message .= "Date_fin_carte_medical=" . $scout->DATE_FIN_CARTE_MEDICAL . " ";
        $message .= "Particularite=" . $scout->PARTICULARITE . " ";
        $message .= "Adresse=" . $adr . " ";
        $message .= "Cont_urg_nom=" . $scout->CONT_URG_NOM . " ";
        $message .= "Cont_urg_no_tel=" . $scout->CONT_URG_NO_TEL . " ";
        $message .= "Cont_urg_lien_jeune=" . $scout->CONT_URG_LIEN_JEUNE . " ";
        $message .= "Cont_urg_prenom=" . $scout->CONT_URG_PRENOM . " ";
        $message .= "Actif=" . $scout->ACTIF . " ";
        //
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
