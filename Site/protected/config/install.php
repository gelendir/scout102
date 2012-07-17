<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
//

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Installeur',
    'defaultController' => 'Install',

    // preloading 'log' component
    'preload'=>array('log'),

    'language' => 'fr',

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        //'ext.tcpdf.ETcPdf',
    ),

    'modules'=>array(
    ),

    // application components
    'components'=>array(
        'errorHandler'=>array(
            'errorAction'=>'install/error',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
    ),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'webmaster@scouts2011.clients.libeo.com',
        'dateFormat' => 'dd/MM/yyyy',
        'jsDateFormat' => "dd/mm/yy",
        'defaultConfig' => array(
            'siteName' => "P.A.I.N.S",
            'smtpHost' => 'localhost',
            'smtpPort' => 25,
            'smtpEncrypt' => 0,
            'errorEmail' => 'error@102e.org',
            'adminEmail'=>'webmaster@102e.org',
            'dateFormat' => 'dd/MM/yyyy',
            'jsDateFormat' => 'dd/mm/yy',
            'dateFormatMedicalCard' => 'yyyy/MM',
            'resetPasswordTimeout' => 3600,
            'formatDate' => 'd M Y',
            'formatArgent' => '%d $',
            //'sessionNbJours' => 364,
            //'sessionMois' => 9,
            //'sessionJour' => 1,
            //'paypalPdtKey' => 'gmBxc4p-4ZEa4cqASWp77-X6XNxZQP31rovhKYkoQjlWFjFNHh4ajzaH_xW',
            //'paypalMerchantId' => 'EDBP2CQ5JPZQS',
            'paypalApiUrl' => 'https://www.paypal.com/cgi-bin/webscr',
            'paypalConnectMode' => 'curl',
            'timezone' => 'America/Montreal',
            'adresseEntreprise' => "455 rue des Conventines, Québec (Québec), G3G 1J9",
            'numeroEntreprise' => "895698467985769",
            'noRecuEntreprise' => "R1",
            'pdfAuthor' => "102e Scouts des laurentides",
        ),
    ),
);

