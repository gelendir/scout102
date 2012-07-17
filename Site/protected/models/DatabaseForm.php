<?php

class DatabaseForm extends CFormModel
{

    private static $databaseSchema = "schema.sql";
    private static $basicData = "base.sql";
    private static $demoData = "demo.sql";

    public $host = "localhost";
    public $port = 3306;
    public $demo = false;
    public $dbName;
    public $createDb = false;
    public $username;
    public $password;

    public function rules()
    {
        return array(
            array('host, username, password, dbName, createDb', 'required'),
            array('demo, createDb', 'safe'),
            array('port', 'numerical', 'min' => 1),
            array('host', 'checkConnection' ),
        );

    }

    public function installProcedure()
    {

        try{

            if( $this->createDb ) {
                $this->createDatabase();
            }

            $this->createTables();
            $this->insertBasicData();

            if( $this->demo ) {
                $this->insertDemoData();
            }

        } catch( CDbException $e ) {

            $this->addError( "connection", "Une erreur est survenue lors de la création de la base de données. Message d'erreur: " . $e->getMessage() );
            return false;

        }

        return true;

    }

    public function createDatabase()
    {

        $dbName = str_replace( "`", "", $this->dbName );
        $sql = "CREATE DATABASE `" . $dbName . "` CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;";

        $command = $this->createDbConnection()->createCommand( $sql );
        $command->execute();

        $this->createDb = false;

    }

    public function createTables()
    {

        $schemafile = $this->installFolder . self::$databaseSchema;
        $this->executeSqlFile( $schemafile );

    }

    public function insertBasicData()
    {

        $datafile = $this->installFolder . self::$basicData;
        $this->executeSqlFile( $datafile );

    }

    public function insertDemoData()
    {

        $datafile =  $this->installFolder . self::$demoData;
        $this->executeSqlFile( $datafile );

    }

    public function checkConnection( $attribute, $params )
    {

        try {
            $connection = $this->createDbConnection();
        } catch( CDbException $e ) {
            $this->addError( "connection", "Une erreur est survenue lors de la connection à la base de données. Message d'erreur: " . $e->getMessage() );
        }

    }

    public function getDbConnectionString()
    {

        $dsn = "mysql:host=" . $this->host
            . ";port=" . $this->port;

        if( !$this->createDb ) {
            $dsn .= ";dbname=" . $this->dbName;
        }

        return $dsn;

    }

    public function createDbConnection()
    {

        $dsn = $this->dbConnectionString;

        $connection = new CDbConnection(
            $dsn,
            $this->username,
            $this->password
        );

        $connection->active = true;

        return $connection;

    }

    private function executeSqlFile( $filepath )
    {

        $connection = $this->createDbConnection();

        $file = fopen( $filepath, 'r' );
        while( $line = $this->accumulateSqlLine( $file ) ) {

            $connection->createCommand( $line )->execute();

        }

        fclose( $file );

    }

    private function accumulateSqlLine( $file_handle ) {

        $regex = '/;$/';

        $line = "";
        $sql = "";

        while( !preg_match( $regex, $line ) && !feof( $file_handle ) ) {
            $line = fgets( $file_handle );
            $sql .= $line;
        }

        return $sql;

    }

    public function getInstallFolder()
    {
        return Yii::app()->basePath . "/install/";
    }



}

?>
