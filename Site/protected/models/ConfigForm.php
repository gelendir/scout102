<?php

class ConfigForm extends CFormModel
{

    static public $templateFile = "main.php-template";
    static public $configFile = "main.php";
    static public $configPath = "/config/";

    public $resetPasswordTimeout;
    public $paypalApiUrl;
    public $timezone;
    public $dateFormat;
    public $jsDateFormat;
    public $dateFormatMedicalCard;
    public $formatDate;
    public $formatArgent;
    public $dbUsername;
    public $dbPassword;
    public $dbConnectionString;

    public $adminEmail;
    public $sessionNbJours;
    public $sessionMois;
    public $sessionAnnee;
    public $sessionJour;
    public $paypalPdtKey;
    public $paypalMerchantId;
    public $paypalConnectMode;
    public $adresseEntreprise;
    public $numeroEntreprise;
    public $noRecuEntreprise;
    public $pdfAuthor;

    public $siteName;
    public $smtpHost;
    public $smtpUsername;
    public $smtpPassword;
    public $smtpPort;
    public $smtpEncrypt;
    public $errorEmail;

    public function rules()
    {
        return array(
            array(
                'adminEmail, debutSession, finSession, paypalPdtKey, paypalMerchantId, paypalConnectMode, adresseEntreprise, numeroEntreprise, noRecuEntreprise, pdfAuthor, siteName, smtpHost, smtpPort, smtpEncrypt, errorEmail',
                'required'
            ),
            array(
                'resetPasswordTimeout, paypalApiUrl, timezone, dbUsername, dbPassword, dbConnectionString, dateFormat, jsDateFormat, dateFormatMedicalCard, formatDate, formatArgent',
                'safe',
                'on' => 'predefined',
            ),
            array(
                'finSession', 'ascendingDate',
            ),
            array('paypalConnectMode', 'in', 'range' => array( 'curl', 'socket' ) ),
        );
    }

    public function writeConfigFile()
    {

        $template = file_get_contents( $this->configFolder . self::$templateFile );

        foreach( $this->attributes as $key => $value ) {

            $templatekey = '${' . $key . '}';
            $value = str_replace( "'", '', $value );

            $template = str_replace( $templatekey, $value, $template );

        }

        file_put_contents(
            $this->configFolder . self::$configFile,
            $template
        );

        return true;

    }

    public function adjustPermissions()
    {
        $valid = chmod( $this->configFolder . self::$configFile, 0555 );
        //$valid = chmod( $this->configFolder, 0555 ) && $valid;
        return $valid;
    }

    public function getConfigFolder()
    {
        return Yii::app()->basePath . self::$configPath;
    }

    private function tsDebutSession()
    {
        $jour = $this->sessionJour;
        $mois = $this->sessionMois;
        $annee = $this->sessionAnnee;

        $tsDebutSession = mktime( 0, 0, 0, $mois, $jour, $annee );

        return $tsDebutSession;

    }

    private function tsFinSession()
    {

    }

    public function getDebutSession()
    {

        $tsDebutSession = $this->tsDebutSession();
        return Util::formatDate( $tsDebutSession );

    }

    public function setDebutSession( $debutSession ) {

        $tsDebutSession = Util::parseDate( $debutSession );

        $jour = (int)date("d", $tsDebutSession );
        $mois = (int)date("m", $tsDebutSession );
        $annee = (int)date("Y", $tsDebutSession );

        $this->sessionJour = $jour;
        $this->sessionMois = $mois;
        $this->sessionAnnee = $annee;

    }

    public function getFinSession()
    {

        $tsDebutSession = $this->tsDebutSession();
        $tsFinSession = $tsDebutSession + ( $this->sessionNbJours * 24 * 60 * 60 );

        return Util::formatDate( $tsFinSession );

    }

    public function setFinSession( $finSession )
    {

        $tsDebutSession = $this->tsDebutSession();
        $tsFinSession = Util::parseDate( $finSession );

        $nbJours = (int)( ( $tsFinSession - $tsDebutSession ) / ( 24 * 60 * 60 ) );

        $this->sessionNbJours = $nbJours;

    }

    public function ascendingDate( $attribute, $params ) {

        $tsDebutSession = $this->tsDebutSession();
        $tsFinSession = Util::parseDate( $this->finSession );

        if( $tsFinSession <= $tsDebutSession ) {
            $this->addError( 'finSession', 'La date de fin de session doit être situé après la date de début' );
        }

    }

}




?>
