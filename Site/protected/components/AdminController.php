<?php

class AdminController extends BaseController 
{

    public $layout = "//layouts/admin";

    public function filters()
    {

        return array_merge(
            parent::filters(),
            array(
                'authenticated',
                'menu',
            )
        );

    }

    public function filterAuthenticated( $filterChain ) {

        $user = Yii::app()->user;


        if( $user->isGuest ) {

            $this->redirect( array( 'accueil/index' ) );

        }

        if( !$user->isAllowedAdmin ) {

            $this->redirect( array( 'accueil/index' ) );

        }

        $filterChain->run();

    }

    public function filterMenu( $filterChain ) {

        $this->menu = array(
            array( 'Notifications',     'Notification/index',       array() ),
            array( 'Utilisateurs',      'Utilisateur/index',        array() ),
            array( 'Scouts',            'Scout/index',              array() ),
            array( 'Unités',            'Unite/index',              array() ),
            array( 'Familles', 'TransfertFamille/index',            array() ),
            array( 'Paiements',   'PaiementManuel/index',           array() ),
            array( 'Listes',  'GenerateurListe/index',              array() ),
            array( "Reçus d'impôts",      'RecuImpot/index',        array() ),
            array( 'Fiches médicales',  'GenerationFiche/index',    array() ),
            array( 'Section parent',    'FicheEnfant/index',        array() ),
            array( "Déconnexion",       'login/logout',             array() ),
        );

        $filterChain->run();

    }

}

?>
