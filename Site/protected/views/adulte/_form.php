<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'adulte-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'PRENOM'); ?>
		<?php echo $form->textField($model,'PRENOM',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'PRENOM'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'NOM'); ?>
		<?php echo $form->textField($model,'NOM',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'NOM'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'NOM_UTILISATEUR'); ?>
		<?php echo $form->textField($model,'NOM_UTILISATEUR',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'NOM_UTILISATEUR'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'MOT_DE_PASSE'); ?>
		<?php echo $form->textField($model,'MOT_DE_PASSE',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'MOT_DE_PASSE'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'COURRIEL'); ?>
		<?php echo $form->textField($model,'COURRIEL',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'COURRIEL'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SEXE'); ?>
		<?php echo $form->textField($model,'SEXE',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'SEXE'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'NO_TEL_PRINCIPAL'); ?>
		<?php echo $form->textField($model,'NO_TEL_PRINCIPAL',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'NO_TEL_PRINCIPAL'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'NO_TEL_SECONDAIRE'); ?>
		<?php echo $form->textField($model,'NO_TEL_SECONDAIRE',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'NO_TEL_SECONDAIRE'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'NO_TEL_AUTRE'); ?>
		<?php echo $form->textField($model,'NO_TEL_AUTRE',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'NO_TEL_AUTRE'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'EMPLOI'); ?>
		<?php echo $form->textField($model,'EMPLOI',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'EMPLOI'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->