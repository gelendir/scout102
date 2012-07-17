<?php
$this->breadcrumbs=array(
	'Adultes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Adulte', 'url'=>array('index')),
	array('label'=>'Manage Adulte', 'url'=>array('admin')),
);
?>

<h1>Create Adulte</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>