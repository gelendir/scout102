<?php

$form = $this->beginWidget('ActiveForm', array(
    'action' => $action,
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
) );

$famille = Famille::model()->findByPk(
    Yii::app()->user->idFamille
);

$adresses = $famille->adresses;

echo $this->renderPartial(
    '//ficheParent/_form',
    array(
        'model'=>$model,
        'form'=>$form,
        'adresses' => $adresses,
    )
);

?>

<div class="row">

    <?php echo CHtml::submitButton( 'Sauvegarder', array( 'class' => 'btn primary' ) ); ?>

</div>

<?php

$this->endWidget();


echo $this->renderPartial(
    "//adresse/window",
    array( 
        'adresse' => new Adresse(),
    )
);

?>
