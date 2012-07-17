<?php
$this->breadcrumbs=array(
	'Adultes'=>array('index'),
	$model->ID_ADULTE=>array('view','id'=>$model->ID_ADULTE),
	'Update',
);

$this->menu=array(
	array('label'=>'List Adulte', 'url'=>array('index')),
	array('label'=>'Create Adulte', 'url'=>array('create')),
	array('label'=>'View Adulte', 'url'=>array('view', 'id'=>$model->ID_ADULTE)),
	array('label'=>'Manage Adulte', 'url'=>array('admin')),
);
?>

<h1>Update Adulte <?php echo $model->ID_ADULTE; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>