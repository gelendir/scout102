<?php
$this->breadcrumbs=array(
	'Adultes'=>array('index'),
	$model->ID_ADULTE,
);

$this->menu=array(
	array('label'=>'List Adulte', 'url'=>array('index')),
	array('label'=>'Create Adulte', 'url'=>array('create')),
	array('label'=>'Update Adulte', 'url'=>array('update', 'id'=>$model->ID_ADULTE)),
	array('label'=>'Delete Adulte', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ID_ADULTE),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Adulte', 'url'=>array('admin')),
);
?>

<h1>View Adulte #<?php echo $model->ID_ADULTE; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ID_ADULTE',
		'PRENOM',
		'NOM',
		'NOM_UTILISATEUR',
		'MOT_DE_PASSE',
		'COURRIEL',
		'SEXE',
		'NO_TEL_PRINCIPAL',
		'NO_TEL_SECONDAIRE',
		'NO_TEL_AUTRE',
		'EMPLOI',
	),
)); ?>
