<?php $this->renderPartial(
	'//utilisateur/_form', 
	array(
		'model'=>$model, 
        'action'=>$action,
        'famille' => $famille,
	)
) ?>
