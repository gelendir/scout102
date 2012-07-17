<?php $form = $this->beginWidget( 'ActiveForm', array( 'action' => $action ) ) ?>

    <fieldset>

        <div class="clearfix">
            <?php echo $form->label( $adulte, 'NOM_UTILISATEUR' ); ?>

            <div class="input">
                <?php echo $form->textField( $adulte, 'NOM_UTILISATEUR' ); ?>
            </div>
        </div>

        <div class="clearfix">
            <?php echo $form->label( $adulte, 'MOT_DE_PASSE' ); ?>

            <div class="input">
                <?php echo $form->passwordField( $adulte, 'MOT_DE_PASSE' ); ?>
            </div>
        </div>

        <div class="well actions">
            <?php echo CHtml::submitButton("Se connecter", array( 'class' => 'btn primary') ) ?>
        </div>

    </fieldset>

<?php $this->endWidget() ?>

<?php echo CHtml::link( Yii::t( 'login', 'forgotPassword' ), array( 'login/forget' ) ) ?>
<br />
<?php echo CHtml::link( Yii::t( 'login', 'createAccount' ), array( 'InscriptionParent/new' ) ) ?>
