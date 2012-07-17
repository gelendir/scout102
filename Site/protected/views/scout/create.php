<?php $this->renderPartial(
    '_page',
    array(
        'model'=>$model,
        'scolarite'=>$scolarite,
        'ficheMedicale' => $ficheMedicale,
        'famille' => $famille,
        'action' => array( 'Scout/create' ),
    )
); ?>
