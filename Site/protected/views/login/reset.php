<p>
    <?php echo Yii::t( 'login', 'bannerReset' ) ?>
</p>

<?php $form = $this->beginWidget('ActiveForm', array(
    'action' => $action,
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
)); ?>

<?php echo $form->errorSummary( $adulte ) ?>

<fieldset>

    <?php echo CHtml::hiddenField( "clef", $clef ); ?>

    <?php Bootstrap::inputDiv( $adulte, 'MOT_DE_PASSE' ) ?>
        <?php echo $form->label($adulte,'MOT_DE_PASSE'); ?>

        <div class="input">
            <?php echo $form->passwordField($adulte,'MOT_DE_PASSE' ) ?>
            <?php echo $form->error($adulte, 'MOT_DE_PASSE') ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv($adulte, 'Confirmation' ) ?>
        <?php echo $form->label($adulte,'Confirmation'); ?>

        <div class="input">
            <?php echo $form->passwordField($adulte,'conf_password' ) ?>
            <?php echo $form->error($adulte, 'conf_password' ) ?>
        </div>
    </div>

    <div class="well actions">
        <?php echo CHtml::submitButton( Yii::t( 'login', 'send' ), array( 'class' => 'btn primary' ) ) ?>
    </div>

</fieldset>

<?php $this->endWidget() ?>

