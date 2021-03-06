<?php
/* @var $this VenueController */
/* @var $model Venue */

$this->breadcrumbs=array(
	'Venues'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Venue', 'url'=>array('index')),
	array('label'=>'Create Venue', 'url'=>array('create')),
	array('label'=>'Update Venue', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Venue', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Venue', 'url'=>array('admin')),
);
?>

<h1>View Venue #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'venueName',
		'addressID',
	),
)); ?>
