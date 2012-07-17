
<h1><?php echo Yii::t( 'parent', 'compte' ) ?></h1>

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
            <?php echo CHtml::passwordField('motPasse'); ?> 
        </div>
    </div>

    <?php Bootstrap::inputDiv($model, 'Confirmation' ) ?>
        <?php echo $form->label($model,'Confirmation'); ?>

        <div class="input">
            <?php echo CHtml::passwordField('confirmation'); ?>
        </div>
    </div>

</fieldset>
