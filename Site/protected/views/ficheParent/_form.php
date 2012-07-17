
    <h1><?php echo Yii::t( 'parent', 'ficheInscription' ) ?></h1>

    <?php echo $form->errorSummary( $model ) ?>

    <h2><?php echo Yii::t( 'parent', 'choixProfil' ) ?></h2>

    <div class="row">

        <div class="field">
            <?php echo $form->dropDownList($model,'PARENT', array(true=>'Parent',false=>'Animateur') ) ?>
        </div>

    </div>

    <h2><?php echo Yii::t( 'parent', 'informationParent' ) ?></h2>

    <div class="row">

        <div class="col2">

            <span class="description"><?php echo Yii::t( 'parent', 'prenomNom' ) ?></span>

            <div class="field">
                <?php echo $form->textField($model,'NOM', array( 'class' => 'medium' ) ) ?>
                <label><?php echo Yii::t( 'parent', 'nom' ) ?></label>
            </div>

            <div class="field">
                <?php echo $form->textField($model,'PRENOM', array( 'class' => 'medium' ) ) ?>
                <label><?php echo Yii::t( 'parent', 'prenom' ) ?></label>
            </div>

        </div>

        <div class="col2">

            <span class="description"><?php echo Yii::t( 'parent', 'sexe' ) ?></span>

            <div class="field">
                <?php echo $form->dropDownList($model,'SEXE', array('M'=>'Homme','F'=>'Femme') ) ?>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col2">

            <span class="description"><?php echo Yii::t( 'parent', 'telPrinc' ) ?></span>

            <div class="field">
                <?php echo $form->textField($model,'NO_TEL_PRINCIPAL') ?>
                <?php echo $form->labelMask($model, 'NO_TEL_PRINCIPAL') ?>
            </div>

        </div>

        <div class="col2">

            <span class="description"><?php echo Yii::t( 'parent', 'telSec' ) ?></span>

            <div class="field">
                <?php echo $form->textField($model,'NO_TEL_SECONDAIRE') ?>
                <?php echo $form->labelMask($model, 'NO_TEL_SECONDAIRE') ?>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col2">

            <span class="description"><?php echo Yii::t( 'parent', 'telTravail' ) ?> </span>

            <div class="field">
                <?php echo $form->textField($model,'NO_TEL_AUTRE') ?>
                <?php echo $form->labelMask($model, 'NO_TEL_AUTRE') ?>
            </div>

        </div>

        <div class="col2">

            <span class="description"><?php echo Yii::t( 'parent', 'emploi' ) ?></span>

            <div class="field">
                <?php echo $form->textField($model,'EMPLOI') ?>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col2">

            <?php echo $this->renderPartial('//adresse/_selectbox', array(
                'model' => $model,
                'field' => 'ID_ADRESSE_PRINC', 
                'adresses' => $adresses,
                'titre' => Yii::t( 'scout', 'adressePrincipal' ),
            ) ) ?>

        </div>

    </div>

    <h2><?php echo Yii::t( 'parent', 'desirImplication' ) ?></h2>

    <div class="row">

    <table class="nolines">

        <?php
            $count = 0;
            foreach ($model->implications as $i => $implication)
            {
                if($count == 0)
                {
                    echo "<tr>";
                }
                ?>
                <td>
                    <?php
                        $options = array();//'uncheckValue' => null
                        if( $implication->DEMANDE == 1 ) {
                            $options['checked'] = true;
                        }
                        echo $form->checkBox( $implication, "DEMANDE[$i]", $options );
                        echo $form->hiddenField($implication, "ID_TYPE_IMPLICATION[$i]", array('value'=>$implication->typeImplication->ID_TYPE_IMPLICATION));
                        echo $form->hiddenField($implication, "ID_IMPLICATION[$i]", array('value'=>$implication->ID_IMPLICATION));
                    ?>
                </td>
                <td>
                    <?php
                        echo $implication->typeImplication->DESCRIPTION;
                    ?>
                </td>
                <?php
                    $count++;
                    if($count == 2)
                    {
                        echo "</tr>";
                        $count = 0;
                    }
            }

        ?>
        <tr>
            <td>
                <input type="checkbox" id="autre" />
            </td>
            <td>
                <?php echo Yii::t( 'parent', 'autre' ) ?>
            </td>
        </tr>

    </table>

    <label class="description"><?php echo Yii::t( 'parent', 'siAutre' ) ?></label>
    <?php echo $form->textField( $model, 'IMPLICATION_AUTRE' ) ?>

    </div>

<script type="text/javascript">

    $( function() {
        $("#Adulte_IMPLICATION_AUTRE").keyup( function(){
            if( $(this).val() == "" ) {
                $("#autre").removeAttr("checked");
            } else {
                $("#autre").attr("checked", "checked");
            }
        });
    });

</script>

