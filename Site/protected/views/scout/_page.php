<?php $form=$this->beginWidget('ActiveForm', array('action' => $action)); ?>

<?php
    $adresses = $famille->adresses;
?>

<ul class="tabs">
    <li class="active"><a href="#enfant"><?php echo Yii::t( 'scout', 'ficheEnfant' ) ?></a></li>
    <li><a href="#medicale"><?php echo Yii::t( 'scout', 'ficheMedicale' ) ?></a></li>
</ul>

<div class="pill-content">

    <?php echo CHtml::hiddenField( "idFamille", $famille->ID_FAMILLE ) ?>

    <div id="enfant" class="active">

        <?php $this->renderPartial("//ficheEnfant/_form", array(
            'form' => $form,
            'Scout' => $model,
            'adresses' => $adresses,
        ) ) ?>

    </div>

    <div id="medicale">

        <?php $this->renderPartial("//ficheMedicale/_form", array(
            'form' => $form,
            'ficheMedicale' => $ficheMedicale,
            'Scolarite' => $scolarite,
            'cacherConfirmation' => true,
        ) ) ?>

    </div>

</div>

<?php $this->endWidget() ?>

<?php $this->renderPartial("//adresse/window", array( 'adresse' => new Adresse(), 'idFamille' => $famille->ID_FAMILLE ) ) ?>

<script>
  $(function () {
    $('.tabs').tabs()
  })
</script>

