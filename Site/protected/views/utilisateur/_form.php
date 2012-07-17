
<?php $form = $this->beginWidget('ActiveForm', array(
    'action' => $action,
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'id' => 'utilisateur-form',
)); ?>

    <?php echo $form->hiddenField( $famille, 'ID_FAMILLE' ); ?> 
    <ul class="tabs">
        <li class="active"><a href="#compte"><?php echo Yii::t( 'parent', 'compte' ) ?></a></li>
        <li><a href="#fiche"><?php echo Yii::t( 'parent', 'ficheParent' ) ?></a></li>
        <li><a href="#roles"><?php echo Yii::t( 'parent', 'implications' ) ?></a></li>
    </ul>

    <div class="pill-content">

        <div class="active" id="compte">

            <?php echo $this->renderPartial(
                "_compte",
                array(
                    'model' => $model,
                    'form' => $form,
                )
            ) ?>

        </div>

        <div id="fiche">

            <?php echo $this->renderPartial(
                '//ficheParent/_form',
                array(
                    'model'=>$model,
                    'form'=>$form,
                    'adresses' => $famille->adresses,
            )) ?>

        </div>

        <div id="roles">

            <?php echo $this->renderPartial(
                "_roles",
                array(
                    'model' => $model,
                    'form' => $form,
                )
            ) ?>

        </div>

    </div>

    <div class="row">

        <?php echo CHtml::submitButton( 'Sauvegarder', array( 'class' => 'btn primary' ) ); ?>

    </div>

<?php $this->endWidget() ?>

<?php $this->renderPartial("//adresse/window", array( 'adresse' => new Adresse(), 'idFamille' => $famille->ID_FAMILLE ) ) ?>

<script type="text/javascript">
    $( function() {
        $('.tabs').tabs();
    });
</script>

