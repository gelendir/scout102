<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="fr" />
	
    <?php foreach( $this->css as $css_file ): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . '/css/' . $css_file ?>" />
    <?php endforeach ?>

    <?php foreach( $this->js as $js_file ): ?>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/" . $js_file ?>"></script>
    <?php endforeach ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>
   <?php echo $content; ?>
</body>
</html>
