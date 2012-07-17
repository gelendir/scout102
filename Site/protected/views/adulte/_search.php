<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_ADULTE'); ?>
		<?php echo $form->textField($model,'ID_ADULTE'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PRENOM'); ?>
		<?php echo $form->textField($model,'PRENOM',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM'); ?>
		<?php echo $form->textField($model,'NOM',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_UTILISATEUR'); ?>
		<?php echo $form->textField($model,'NOM_UTILISATEUR',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MOT_DE_PASSE'); ?>
		<?php echo $form->textField($model,'MOT_DE_PASSE',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'COURRIEL'); ?>
		<?php echo $form->textField($model,'COURRIEL',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SEXE'); ?>
		<?php echo $form->textField($model,'SEXE',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NO_TEL_PRINCIPAL'); ?>
		<?php echo $form->textField($model,'NO_TEL_PRINCIPAL',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NO_TEL_SECONDAIRE'); ?>
		<?php echo $form->textField($model,'NO_TEL_SECONDAIRE',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NO_TEL_AUTRE'); ?>
		<?php echo $form->textField($model,'NO_TEL_AUTRE',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'EMPLOI'); ?>
		<?php echo $form->textField($model,'EMPLOI',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->