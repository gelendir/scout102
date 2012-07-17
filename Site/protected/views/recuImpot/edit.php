<?php $form = $this->beginWidget( 'ActiveForm', array(
    'action' => $action
) ) ?>

<h1>Reçu Impôt</h1>

<?php $this->renderPartial("_form", array( 'form' => $form, 'recuImpot' => $recuImpot ) ) ?>

<?php $this->endWidget() ?>
