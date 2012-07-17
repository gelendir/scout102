<?php

$famille = Famille::model()->findByPk(
    Yii::app()->user->idFamille
);

$adresses = $famille->adresses;

?>

<?php $form=$this->beginWidget('ActiveForm', array('action' => $action)); ?>

<?php $this->renderPartial(
    "_form", array(
        'form' => $form,
        'Scout' => $Scout,
        'adresses' => $adresses,
) ) ?>

<?php $this->endWidget() ?>

<?php $this->renderPartial("//adresse/window", array( 'adresse' => new Adresse() ) ) ?>
