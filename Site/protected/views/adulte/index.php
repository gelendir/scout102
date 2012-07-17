<?php
$this->breadcrumbs=array(
	'Adultes',
);

$this->menu=array(
	array('label'=>'Create Adulte', 'url'=>array('create')),
	array('label'=>'Manage Adulte', 'url'=>array('admin')),
);
?>

<h1>Adultes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
