 <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id'=>'unite-form',
        'action' => $action,
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
    ));
?>
    <ul class="tabs">
        <li class="active"><a href="#infos"><?php echo Yii::t( 'unite', 'infoGenerales' ) ?></a></li>
        <li><a href="#animateurs"><?php echo Yii::t( 'unite', 'animateurs' ) ?></a></li>
        <li><a href="#scouts"><?php echo Yii::t( 'unite', 'scouts' ) ?></a></li>
    </ul>

    <?php echo $form->errorSummary( $unite ) ?>

    <div class="pill-content">

        <div id="infos" class="active">
            <?php
                if($typeAction === "edit"){
                    $this->renderPartial('//unite/formEdition', array('unite'=>$unite, 'form'=>$form));
                } else {
                    $this->renderPartial('//unite/formCreation', array('unite'=>$unite, 'form'=>$form));
                }
            ?>
        </div>

        <div id="animateurs">

            <?php echo $this->renderPartial('//unite/formAnimateurs', array(
                'unite' => $unite,
                'form'  => $form,
                'typeAction' => $typeAction
            ) ) ?>

        </div>

        <div id="scouts">

            <?php echo $this->renderPartial('//unite/formScout', array(
                'unite' => $unite,
                'form'  => $form,
                'typeAction' => $typeAction
            ) ) ?>

        </div>
    </div>

    <div>
        <?php echo CHtml::submitButton( 'Sauvegarder', array( 'class' => 'btn primary' ) ) ?>
    </div>

    <script>
    $(function () {
    $('.tabs').tabs()
    })
    </script>
    <?php $this->endWidget(); ?>
