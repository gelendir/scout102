<?php 

echo $this->renderPartial(
    "_page",
    array(
        'action' => array( 'FicheParent/create' ),
        'model' => $model,
    )
);

?>
