<?php

class InstallController extends CController
{

    public $layout = '//layouts/install';
    public $css = array();
    public $js = array();
    public $breadcrumb = array();
    public $etape = "";

    public function filters()
    {
        return array(
            'checkInstallScript',
            'setup',
            'breadCrumb',
        );

    }

    public function filterCheckInstallScript( $filterChain )
    {

        $path = YiiBase::getPathOfAlias( 'webroot' ) . "/" . "install.php";
        if( !file_exists( $path ) ) {
            throw new CHttpException( 403, "Install script does not exist" );
        }

        $filterChain->run();

    }

    public function filterSetup( $filterChain )
    {

        CHtml::$errorSummaryCss = "alert-message block-message error";
        CHtml::$errorMessageCss = "help-inline";

        $filterChain->run();

    }

    public function filterBreadcrumb( $filterChain )
    {
        $this->breadcrumb = array(
            array('index',      'Accueil',                    'install/index',    array() ),
            array('configDb',   'Configuration BD',           'install/configdb', array() ),
            array('config',     'Configuration système',      'install/config',   array() ),
            array('admin',      'Compte administrateur',      'install/admin',    array() ),
        );

        $filterChain->run();
    }

    public function actionError()
    {

        if( $error = Yii::app()->errorHandler->error ) {

            if( Yii::app()->request->isAjaxRequest ) {
                echo $error['message'];
            } else {
                $this->render( 'error', $error );
            }

        }

    }

    public function actionIndex()
    {
        $this->etape = "index";

        Yii::app()->session->clear();

        $this->render('index');
    }

    public function actionConfigDb()
    {

        $model = new DatabaseForm;

        $this->etape = "configDb";

        $this->render(
            'configdb',
            array(
                'model' => $model,
                'action' => array( 'install/configdbsave' ),
            )
        );

    }

    public function actionConfigDbSave()
    {

        $this->etape = "configDb";

        if( isset( $_POST['DatabaseForm'] ) ) {

            $model = new DatabaseForm;
            $model->attributes = $_POST['DatabaseForm'];

            $config = Yii::app()->session['install'];

            if( $model->validate() ) {

                if( $model->installProcedure() ) {

                    $dbConfig = array(
                        'dbUsername' => $model->username,
                        'dbPassword' => $model->password,
                        'dbConnectionString' => $model->dbConnectionString,
                    );

                    $config['database'] = $dbConfig;

                    Yii::app()->session['install'] = $config;

                    $this->redirect( array( 'install/config' ) );

                }

            }

        }

        $this->render(
            'configdb',
            array(
                'model' => $model,
                'action' => array( 'install/configdbsave' ),
            )
        );

    }

    public function actionConfig()
    {
        $this->etape = "config";

        $model = new ConfigForm;
        $model->attributes = Yii::app()->params['defaultConfig'];

        $this->render( 'config', array( 'model' => $model, 'action' => array( 'install/configsave' ) ) );
    }

    public function actionConfigSave()
    {

        $this->etape = "config";

        $model = new ConfigForm('predefined');
        $model->attributes = Yii::app()->params['defaultConfig'];
        $model->attributes = Yii::app()->session['install']['database'];

        if( isset( $_POST['ConfigForm'] ) ) {

            $model->attributes = $_POST['ConfigForm'];

            if( $model->validate() && $model->writeConfigFile() ) {

                if( !$model->adjustPermissions() ) {

                    $msg = "Le système n'a pas pu changer les permissions d'accès sur le fichier de configuration.
                    À fin de sécuriser votre site web, veuillez changer les permissions sur le dossier protected/config/
                    pour qu'il soit en mode lecture seulement (chmod 755)";

                    Yii::app()->setFlash( 'warning', $msg );

                }

                $this->redirect( array( 'install/admin' ) );

            }

        }

        $this->render( 'config', array( 'model' => $model, 'action' => array( 'install/configsave' ) ) );

    }

    public function actionAdmin()
    {

        $this->etape = "admin";

        $connection = $this->dbConnection;

        $model = new Adulte();
        $adresse = new Adresse();

        $this->render( 'admin', array(
            'model' => $model,
            'adresse' => $adresse,
            'action' => array( 'install/adminsave' ),
        ) );

    }

    public function actionAdminSave()
    {

        $connection = $this->dbConnection;

        $this->etape = "admin";

        $model = new Adulte('install');
        $adresse = new Adresse();

        if( isset( $_POST['Adulte'] ) && isset( $_POST['Adresse'] ) ) {

            $model->attributes = $_POST['Adulte'];
            $adresse->attributes = $_POST['Adresse'];

            $model->validate();
            $adresse->validate();

            if( $model->validate() && $adresse->validate() ) {

                Util::saveOrThrow( $adresse );

                $famille = new Famille();
                Util::saveOrThrow( $famille );

                $familleAdresse = new FamilleAdresse();
                $familleAdresse->ID_ADRESSE = $adresse->ID_ADRESSE;
                $familleAdresse->ID_FAMILLE = $famille->ID_FAMILLE;
                Util::saveOrThrow( $familleAdresse );

                $model->genererImplications();

                foreach( $model->implications as $implication ) {
                    if( $implication->typeImplication->TITRE_IMPLICATION == "Administrateur" ) {
                        $implication->DEMANDE = 1;
                        $implication->ACCORDE = 1;
                    }
                }

                $model->ID_ADRESSE_PRINC = $adresse->ID_ADRESSE;
                $model->NOM_UTILISATEUR = $model->COURRIEL;
                $model->PARENT = 0;
                $model->encrypterMotDePasse();
                Util::saveOrThrow( $model );

                foreach( $model->implications as $implication ) {
                    $implication->ID_ADULTE = $model->ID_ADULTE;
                    $implication->ID_TYPE_IMPLICATION = $implication->typeImplication->ID_TYPE_IMPLICATION;
                    Util::saveOrThrow( $implication );
                }

                $familleAdulte = new FamilleAdulte();
                $familleAdulte->ID_FAMILLE = $famille->ID_FAMILLE;
                $familleAdulte->ID_ADULTE = $model->ID_ADULTE;
                Util::saveOrThrow( $familleAdulte );

                $this->redirect( array( 'install/end' ) );

            }

        }

        $this->render( 'admin', array(
            'model' => $model,
            'adresse' => $adresse,
            'action' => array( 'install/adminsave' ),
        ) );

    }

    public function actionEnd()
    {

        $this->etape = "end";

        $this->render( 'end' );

    }

    private function prepareSession()
    {

        if( !isset( Yii::app()->session['install'] ) ) {
            Yii:app()->session['install'] = array();
        }

    }

    protected function getDbConnection()
    {

        $connection = new CDbConnection(
            Yii::app()->session['install']['database']['dbConnectionString'],
            Yii::app()->session['install']['database']['dbUsername'],
            Yii::app()->session['install']['database']['dbPassword']
        );

        $connection->active = true;

        Yii::app()->setComponent( 'db', $connection );

        return $connection;

    }

}
