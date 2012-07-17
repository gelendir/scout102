<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'unite-form',
    'action' => $action,
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
));
?>

<h1>Nouvelle Unité</h1>

<p>Veuillez commencer par sélectionner le type d'unité désiré</p>

<div class="clearfix">
    <label>Type d'unité</label>

    <div class="input">
        <?php
            echo $form->dropDownList($unite, 'ID_PROGRAMME', CHtml::ListData(Programme::model()->findAll(), 'ID_PROGRAMME', 'NOM_PROGRAMME'));
        ?>
    </div>
</div>

<div class="actions well">
    <?php echo CHtml::submitButton( "Passer à la fiche", array( 'class' => 'btn primary' ) ) ?>
</div>

<?php $this->endWidget() ?>
