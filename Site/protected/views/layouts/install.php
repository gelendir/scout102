<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="fr" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-1.4.0.min.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/install.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui-lightness/jquery-ui-1.8.16.custom.css" media="screen" />
    <?php foreach( $this->css as $css_file ): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . '/css/' . $css_file ?>" />
    <?php endforeach ?>

    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->

    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-modal-1.4.0.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-tabs-1.4.0.js"></script>
    <?php foreach( $this->js as $js_file ): ?>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/" . $js_file ?>"></script>
    <?php endforeach ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>

    <div class="container">

        <div class="content">

        <ul class="breadcrumb">

            <?php
                $last = $this->breadcrumb[ count( $this->breadcrumb ) - 1 ][0];
                foreach( $this->breadcrumb as $etape ):
                    $nomEtape = $etape[0];
                    $labelEtape = $etape[1];
                    $action = $etape[2];
                    $options = $etape[3];
            ?>

                <li
                    <?php if ( $nomEtape == $this->etape ) { echo 'class="active"'; } ?>
                >

                    <a href="<?php echo $this->createUrl( $action, $options ) ?>">
                        <?php echo $labelEtape ?>
                    </a>

                    <?php if( $nomEtape != $last ): ?>
                        <span class="divider"> → </span>
                    <?php endif ?>

                </li>

            <?php endforeach ?>

        </ul>

            <?php foreach( Yii::app()->user->getFlashes('success') as $key => $message ): ?>
                <div class="alert-message block-message success">
                    <p><?php echo $message ?></p>
                </div>
            <?php endforeach ?>

            <?php foreach( Yii::app()->user->getFlashes('warning') as $key => $message ): ?>
                <div class="alert-message block-message warning">
                    <p><?php echo $message ?></p>
                </div>
            <?php endforeach ?>

            <?php foreach( Yii::app()->user->getFlashes('error') as $key => $message ): ?>
                <div class="alert-message block-message error">
                    <p><?php echo $message ?></p>
                </div>
            <?php endforeach ?>

            <?php echo $content; ?>

        </div>

    </div>

</body>
</html>
