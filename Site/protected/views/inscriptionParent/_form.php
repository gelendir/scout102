<?php $form = $this->beginWidget('ActiveForm', array(
    'action' => $action,
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
)); ?>

<h1>Inscription</h1>

    <?php CHtml::$errorMessageCss = "help-inline"; ?>

    <p>
        <?php echo Yii::t( 'parent', 'enteteInscription' ) ?>
    </p>

    <?php echo $form->errorSummary($model); ?>

    <fieldset>

        <?php Bootstrap::inputDiv( $model, 'COURRIEL' ) ?>
            <?php echo $form->label($model,"COURRIEL"); ?>

            <div class="input">
                <?php echo $form->textField($model,'COURRIEL') ?>
                <?php echo $form->error($model, 'COURRIEL') ?>
            </div>
        </div>

        <?php Bootstrap::inputDiv( $model, 'MOT_DE_PASSE' ) ?>
            <?php echo $form->label($model,'MOT_DE_PASSE'); ?>

            <div class="input">
                <?php echo $form->passwordField($model,'MOT_DE_PASSE' ) ?>
                <?php echo $form->error($model, 'MOT_DE_PASSE') ?>
            </div>
        </div>

        <?php Bootstrap::inputDiv($model, 'Confirmation' ) ?>
            <?php echo $form->label($model,'Confirmation'); ?>

            <div class="input">
                <?php echo $form->passwordField($model,'conf_password' ) ?>
                <?php echo $form->error($model, 'conf_password' ) ?>
            </div>
        </div>

    </fieldset>

    <?php echo CHtml::submitButton( Yii::t( 'parent', 'save' ), array( 'class' => 'btn primary' ) ); ?>

<?php $this->endWidget(); ?>
