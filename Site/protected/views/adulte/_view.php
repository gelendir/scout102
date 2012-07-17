<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_ADULTE')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_ADULTE), array('view', 'id'=>$data->ID_ADULTE)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PRENOM')); ?>:</b>
	<?php echo CHtml::encode($data->PRENOM); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM')); ?>:</b>
	<?php echo CHtml::encode($data->NOM); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_UTILISATEUR')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_UTILISATEUR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MOT_DE_PASSE')); ?>:</b>
	<?php echo CHtml::encode($data->MOT_DE_PASSE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('COURRIEL')); ?>:</b>
	<?php echo CHtml::encode($data->COURRIEL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SEXE')); ?>:</b>
	<?php echo CHtml::encode($data->SEXE); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('NO_TEL_PRINCIPAL')); ?>:</b>
	<?php echo CHtml::encode($data->NO_TEL_PRINCIPAL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NO_TEL_SECONDAIRE')); ?>:</b>
	<?php echo CHtml::encode($data->NO_TEL_SECONDAIRE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NO_TEL_AUTRE')); ?>:</b>
	<?php echo CHtml::encode($data->NO_TEL_AUTRE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('EMPLOI')); ?>:</b>
	<?php echo CHtml::encode($data->EMPLOI); ?>
	<br />

	*/ ?>

</div>