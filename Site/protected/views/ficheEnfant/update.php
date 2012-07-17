<?php echo $this->renderPartial(
    '_page',
    array(
        'action' => array( 'FicheEnfant/update', 'id' => $Scout->ID_SCOUT ),
        'Scout' => $Scout,
    )
) ?>
