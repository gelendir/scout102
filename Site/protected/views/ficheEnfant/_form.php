<h1>
    <?php 
        echo Yii::t( 'scout', 'inscriptionEnfant' );
        if( $Scout->nomComplet != "" ) {
            echo " : " . $Scout->nomComplet;
        }
    ?>
</h1>

    <?php
            echo $form->errorSummary($Scout);
            echo $form->errorSummary($Scout->recuImpot);
    ?>

    <div class="row">

        <div class="col2">

            <span class="description">
                <?php echo Yii::t( 'scout', 'nomPrenom' ) ?>
            </span>

            <div class="field">
                <?php echo $form->textField($Scout,'NOM', array('class' => 'medium') ) ?>
                <label><?php echo Yii::t( 'scout', 'nom' ) ?></label>
            </div>

            <div class="field">
                <?php echo $form->textField($Scout,'PRENOM', array( 'class' => 'medium') ) ?>
                <label><?php echo Yii::t( 'scout', 'prenom' ) ?></label>
            </div>
        </div>

        <div class="col2">

            <span class="description">
                <?php echo Yii::t( 'scout', 'sexe' ) ?>
            </span>

            <div class="field">
            <?php echo $form->DropDownList($Scout,'SEXE', array('M'=>'Garçon', 'F'=>'Fille')) ?>
        </div>

    </div>

</div>

<div class="row">

    <div class="col2">

        <span class="description">
            <?php echo Yii::t( 'scout', 'dateNaissance' ) ?>
        </span>

        <div class="field">
            <?php echo $form->textField($Scout,'dateNaissance', array( 'class' => 'medium' ) ) ?>
            <?php echo $form->labelMask($Scout,'dateNaissance'); ?>
        </div>

    </div>

    <div class="col2">

        <span class="description">
            <?php echo Yii::t( 'scout', 'assMal' ) ?>
        </span>

        <div class="field">
            <?php echo $form->textField($Scout,'NO_ASSURANCE_MALADIE', array( 'class' => 'medium' ) ) ?>
            <?php echo $form->labelMask($Scout,'NO_ASSURANCE_MALADIE'); ?>
        </div>

        <div class="field">
            <?php echo $form->textField($Scout,'dateFinCarteMedicale', array( 'class' => 'small') ) ?>
            <?php echo $form->labelMask($Scout,'dateFinCarteMedicale' ); ?>
        </div>

    </div>

</div>

<div class="row">

    <div class="col2">

        <?php echo $this->renderPartial('//adresse/_selectbox', array(
            'model' => $Scout,
            'field' => 'ID_ADRESSE_PRINC',
            'adresses' => $adresses,
            'titre' => Yii::t( 'scout', 'adressePrincipal' ),
        ) ) ?>

    </div>

</div>

<h2><?php echo Yii::t( 'scout', 'sectionImpot' ) ?></h2>
<?php $RecuImpot = $Scout->recuImpot; ?>

<p>
    <span class="label warning"><?php echo Yii::t( 'scout', 'note' ) ?></span>&nbsp;
    <em><?php echo Yii::t( 'scout', 'explicationRecuImpot' ) ?></em>
</p>

<div class="row">

    <div class="col2">

            <span class="description"><?php echo Yii::t( 'scout', 'nomPrenom' ) ?></span>

            <div class="field">
                <?php echo $form->textField($RecuImpot,'NOM_PERSONNE', array('class' => 'medium') ) ?>
                <label><?php echo Yii::t( 'scout', 'nom' ) ?></label>
            </div>

            <div class="field">
                <?php echo $form->textField($RecuImpot,'PRENOM_PERSONNE', array( 'class' => 'medium') ) ?>
                <label><?php echo Yii::t( 'scout', 'prenom' ) ?></label>
            </div>

    </div>
    <div class="col2">

            <span class="description"><?php echo Yii::t( 'scout', 'courriel' ) ?></span> 
            <div class="field">
                <?php echo $form->textField($RecuImpot,'COURRIEL_D_ENVOIE' ) ?>
                <?php echo $form->labelMask($RecuImpot,'COURRIEL_D_ENVOIE'); ?>
            </div>

    </div>

</div>

<div class="row">

    <div class="col2">

        <?php echo $this->renderPartial("//adresse/_selectbox", array(
            'model' => $RecuImpot,
            'field' => 'ID_ADRESSE',
            'adresses' => $adresses,
            'titre' => Yii::t( 'scout', 'adresseRecu' ),
        ) ) ?>

    </div>

</div>

<h2> <?php echo Yii::t( 'scout', 'sectionContact' ) ?> </h2>

<div class="row">

    <div class="col2">
    
            <span class="description"><?php echo Yii::t( 'scout', 'nomPrenom' ) ?></span>
            
            <div class="field">
                <?php echo $form->textField($Scout,'CONT_URG_NOM', array( 'class' => 'medium') ) ?>
                <label><?php echo Yii::t( 'scout', 'nom' ) ?></label>
            </div>
            
            <div class="field">
                <?php echo $form->textField($Scout,'CONT_URG_PRENOM', array( 'class' => 'medium') ) ?>
                <label><?php echo Yii::t( 'scout', 'prenom' ) ?></label>
            </div>

    </div>

    <div class="col2">

            <span class="description"><?php echo Yii::t( 'scout', 'tel' ) ?></span>

            <div class="field">
                <?php echo $form->textField($Scout,'CONT_URG_NO_TEL', array( 'class' => 'medium') ) ?>
                <?php echo $form->labelMask($Scout,'CONT_URG_NO_TEL' ); ?>
            </div>
    </div>

</div>
<div class="row">
    
    <div class="col2">

        <span class="description"><?php echo Yii::t( 'scout', 'lienJeune' ) ?></span>

        <div class="field">
                <?php echo $form->textField($Scout,'CONT_URG_LIEN_JEUNE', array( 'class' => 'medium') ) ?>
                    <label><?php echo Yii::t( 'scout', 'exempleLienJeune' ) ?></label>
                </div>

        </div>
    
    </div>

    <h2><?php echo Yii::t( 'scout', 'autre' ) ?></h2>
    <div class="row">

        <div class="col2">

            <span class="description"><?php echo Yii::t( 'scout', 'particularite' ) ?></span>

            <div class="field">
                <?php echo $form->textArea($Scout,'PARTICULARITE', array() ) ?>
            </div>

        </div>

        

    </div>

    <h2><?php echo Yii::t( 'scout', 'sectionAut' ) ?></h2>

        <?php foreach( $Scout->autorisations as $i=>$autorisation ): ?>

            <div class="row">

                <p>
                    <?php echo $autorisation->typeAutorisation->DESCRIPTION ?>
                </p>

                <?php echo $form->checkBox( $autorisation, "ACCEPTATION[$i]", array(
                    'checked' => $autorisation->ACCEPTATION
                ) ) ?>
                <?php echo $form->hiddenField($autorisation->typeAutorisation, "ID_TYPE_AUTO[$i]",array('value' => $autorisation->typeAutorisation->ID_TYPE_AUTO))?>
                <span><?php echo Yii::t( 'scout', 'accepte' ) ?></span>

            </div>

        <?php endforeach ?>

    <div class="row">

        <?php echo CHtml::submitButton('Sauvegarder', array( 'class' => 'btn primary' ) ) ?>

    </div>

<script type="text/javascript"> 

    $(document).ready(function() {

        $("#Scout_dateNaissance").datepicker({
            dateFormat: "<?php echo Yii::app()->params['jsDateFormat'] ?>",
            changeMonth: true,
            changeYear: true,
            yearRange: '-30:+0',
            showOptions: {
                direction: 'up'
            }
        });

    });

</script>
