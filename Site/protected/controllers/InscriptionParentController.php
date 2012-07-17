<?php

class InscriptionParentController extends BaseController
{

    public function filters() {

        return array_merge( parent::filters(),
            array(
                'before'
            )
        );
    }

    public function filterBefore( $filterChain ) {

        $this->afficherEtapes = false;
        $this->afficherMenu = false;
        $filterChain->run();

    }

    public function actionCreate()
    {

        $model = new Adulte('inscription');

        if( isset( $_POST['Adulte'] ) )
        {

            //Pour l'instant, l'adresse courriel sert de nom
            //d'utilisateur pour l'utilisateur. Ceci pourrait
            //changer dans une prochaine version du projet
            $model->attributes = $_POST['Adulte'];
            $model->NOM_UTILISATEUR = $model->COURRIEL;

            if($model->validate())
            {

                //encryption du mot de passe juste avant de l'ajouter dans la bd
                $model->encrypterMotDePasse();
                if( $model->save() ) {

                    $this->logParent($model, 'create');
                    $model->envoyerCourrielBienvenue();

                    //L'utilisateur est maintenant crée.
                    //Procédons à l'authentifcation de l'utilisateur (login)
                    //et redirigeons le vers la page d'accueil
                    $identity = new UserIdentity(
                        $model->NOM_UTILISATEUR,
                        $_POST['Adulte']['MOT_DE_PASSE']
                    );

                    if( $identity->authenticate() ) {

                        Yii::app()->user->login( $identity );
                        $this->redirect(array('FicheParent/new'));

                    }

                }
            }

        }

        //Erreur lors de la création. Réafficher le formulaire
        $this->render('create', array('model'=>$model));

    }

    public function actionEdit()
    {
        $this->render('edit');
    }

    public function actionNew()
    {
        $model = new Adulte('inscription');
        $this->render('new', array('model'=>$model));
    }

    public function actionUpdate()
    {
        $this->render('update');
    }

    public function logParent( $parent, $action )
    {

            //Création et ajout du log de création de parent
            $imp = "";
            foreach($parent->implications as $implicationn)
            {
                $imp .= $implicationn->typeImplication->DESCRIPTION . $implicationn->DEMANDE;
            }

            $message = $action . " ";
            $message .= "Inscription_parent - ";
            $message .= "Id_adulte='" . $parent->ID_ADULTE . "';";
            $message .= "Prenom='" . $parent->PRENOM . "';";
            $message .= "Nom='" . $parent->NOM . "';";
            $message .= "Nom_utilisateur='" . $parent->NOM_UTILISATEUR . "';";
            $message .= "Mot_de_passe='***';";
            $message .= "Courriel='" . $parent->COURRIEL . "';";
            $message .= "Sexe='" . $parent->SEXE . "';";
            $message .= "No_tel_principal='" . $parent->NO_TEL_PRINCIPAL . "';";
            $message .= "No_tel_secondaire='" . $parent->NO_TEL_SECONDAIRE . "';";
            $message .= "No_tel_autre='" . $parent->NO_TEL_AUTRE . "';";
            $message .= "Emploi='" . $parent->EMPLOI . "';";
            $message .= "Adresse='" . "" . "';";
            $message .= "Parent='" . $parent->PARENT . "';";
            $message .= "COMPTE_ACTIF='" . $parent->COMPTE_ACTIF . "';";
            $message .= "Implications='" . $imp . "';";

            Yii::log(
                $message,
                "info",
                "journalisation"
            );
    }
}
