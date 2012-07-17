<?php

class LoginController extends BaseController
{

    public function filters() {

        return array(
            'cleanup',
            'before',
            'cleanKeys',
        );

    }

    public function filterBefore( $filterChain ) {

        $this->afficherEtapes = false;
        $this->afficherMenu = false;
        $filterChain->run();

    }

    public function filterCleanKeys( $filterChain ) {

        //Supprimer de la BD tout les essais de mot de passe fait il y a plus d'une heure
        $secondes = Yii::app()->params['resetPasswordTimeout'];

        EssaiMotPasse::model()->deleteAll(
            "DATE_ESSAI + INTERVAL :secondes SECOND < NOW()",
            array(
                'secondes' => $secondes,
            )
        );

        $filterChain->run();

    }

    public function actionReset( $clef )
    {


        //trouver la session utilisé pour faire une demande de mot de passe
        $essai = EssaiMotPasse::model()->findByAttributes(
            array(
                'CLEF' => $clef,
            )
        );

        if( $essai !== null ) {

            $this->render( 'reset', array(
                'clef' => $clef,
                'adulte' => new Adulte('login'),
                'action' => array( 'login/confirmReset' ),
            ) );

        } else {

            throw new CHttpException( 404, Yii::t( 'login', 'keyInvalid' ) );

        }

    }

    public function actionConfirmReset()
    {

        if( !( isset( $_POST['clef'] ) && isset( $_POST['Adulte'] ) ) ) {

            throw new CHttpException( 400, Yii::t( 'login', 'invalidKey' ) );

        }

        //trouver la session utilisé pour faire une demande de mot de passe
        $clef = $_POST['clef'];

        $essai = EssaiMotPasse::model()->findByAttributes(
            array(
                'CLEF' => $clef,
            )
        );

        if( $essai === null ) {

            throw new CHttpException( 400, Yii::t( 'login', 'invalidKey' ) );

        }

        //La session a été récupéré. Mettre à jour le mot de passe de l'utilisateur
        //et sauver dans la bd
        $adulte = Adulte::model()->findByPk( $essai->ID_ADULTE );
        $adulte->scenario = 'reset';
        $adulte->attributes = $_POST['Adulte'];


        if( $adulte->validate() ) {

            $adulte->encrypterMotDePasse();
            Util::saveOrThrow( $adulte );

            $essai->delete();

            $this->render( 'confirmreset' );

        } else {

            $this->render( 'reset', array(
                'clef' => $clef,
                'adulte' => $adulte,
                'action' => array( 'login/confirmReset' ),
            ) );

        }

    }

    public function actionForget()
    {

        $this->render( 'forget', array(
        ));

    }

    public function actionConfirmForget()
    {

        if( !isset( $_POST['email'] ) ) {

            $this->redirect( 'login/forget' );

        }

        $adulte = Adulte::model()->findByAttributes(
            array(
                'NOM_UTILISATEUR' => $_POST['email'],
            )
        );

        //Si l'adresse courriel rentré pour une récupération de mot de passe
        //existe bel et bien dans la BD, envoyer un courriel à l'utilisateur
        if( $adulte !== null ) {

            EssaiMotPasse::model()->deleteAllByAttributes(
                array(
                    'ID_ADULTE' => $adulte->ID_ADULTE,
                )
            );

            $oubli = new EssaiMotPasse();
            $oubli->ID_ADULTE = $adulte->ID_ADULTE;
            $oubli->genererClef();

            if( $oubli->save() ) {

                $oubli->envoyerCourriel();

            }
        }

        //Peu importe si l'adresse courriel a été retrouvé dans la bd ou pas,
        //nous affichons un message de confirmation à fin de prévenir des gens
        //malhonnêtes d'essayer de deviner l'adresse courriel d'un utilisateur
        $this->render( 'confirmforget' );

    }


    public function actionLogin()
    {

        //Si l'utilisateur est déja authentifié, le rediriger vers
        //la page d'accueil
        if( !Yii::app()->user->isGuest ) {
            $this->redirect( array( 'FicheEnfant/index' ) );
        }

        $adulte = new Adulte('login');

        if( isset( $_POST['Adulte'] ) ) {

            $adulte->attributes = $_POST['Adulte'];

            //Authentification de l'utilisateur avec les mécanismes d'authentification de Yii
            $identity = new UserIdentity( $adulte->NOM_UTILISATEUR, $adulte->MOT_DE_PASSE );

            if( $identity->authenticate() ) {

                Yii::app()->user->login( $identity );
                $this->redirect( array( 'FicheEnfant/index' ) );

            }

        }

        //Erreur d'authentification. Réafficher le formulaire
        $this->render( 'invalid', array(
            'message'   => Yii::t('login', 'invalid'),
            'action'    => array( 'login/login' ),
            'adulte'    => $adulte,
        ) );

    }

    public function actionLogout()
    {

        Yii::app()->user->logout();

        $this->redirect(  array( 'accueil/index' ) );

    }

}
