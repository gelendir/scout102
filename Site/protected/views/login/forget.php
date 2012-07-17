<p>
    <?php echo Yii::t( 'login', 'bannerForgetPassword' ) ?>
</p>

<?php echo CHtml::beginForm( array('login/confirmForget') ) ?>

    <fieldset>

        <div class="clearfix">
            <?php echo CHtml::label( Yii::t( 'login', 'email' ), "email" ) ?>

            <div class="input">
                <?php echo CHtml::textField( "email" ) ?>
            </div>
        </div>

        <div class="actions">
            <?php echo CHtml::submitButton( Yii::t( 'login', 'send' ), array( 'class' => 'btn primary' ) ) ?>
        </div>

    </fieldset>

<?php echo Chtml::endForm() ?>
