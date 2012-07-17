<?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => $action,
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
    )); 

    echo $this->renderPartial('//ficheMedicale/_form', 
        array(
                'ficheMedicale' => $ficheMedicale,
                'Scolarite' => $Scolarite,
                'form' => $form,
        )
    );

    $this->endWidget();
?>

