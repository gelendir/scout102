<?php
$this->pageTitle=Yii::app()->name . ' - Erreur';
?>

<h1>Erreur <?php echo $code; ?></h2>

<div class="alert-message error">
    <p>
        <?php echo CHtml::encode($message); ?>
    </p>
</div>
