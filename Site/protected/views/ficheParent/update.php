<?php 

echo $this->renderPartial(
    "_page",
    array(
        'action' => $action,
        'model' => $model,
    )
);

?>
