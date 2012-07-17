<?php CHtml::$errorMessageCss = "help-inline"; ?>
<?php echo $form->errorSummary($recuImpot); ?>

<fieldset>

    <div class="clearfix">
        <label>Nom du scout</label>

        <div class="input">
            <?php echo $recuImpot->scout->nomComplet ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv( $recuImpot, 'NO_RECU' ) ?>
        <?php echo $form->label( $recuImpot, 'NO_RECU' ) ?>

        <div class="input">
            <?php echo $form->textField($recuImpot, 'NO_RECU') ?>
            <?php echo $form->error($recuImpot, 'NO_RECU') ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv( $recuImpot, 'MONTANT' ) ?>
        <?php echo $form->label( $recuImpot, 'MONTANT' ) ?>

        <div class="input">
            <?php echo $form->textField($recuImpot, 'MONTANT') ?>
            <?php echo $form->error($recuImpot, 'MONTANT') ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv( $recuImpot, 'PRENOM_PERSONNE' ) ?>
        <?php echo $form->label( $recuImpot, 'PRENOM_PERSONNE' ) ?>

        <div class="input">
            <?php echo $form->textField($recuImpot, 'PRENOM_PERSONNE') ?>
            <?php echo $form->error($recuImpot, 'PRENOM_PERSONNE') ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv( $recuImpot, 'NOM_PERSONNE' ) ?>
        <?php echo $form->label( $recuImpot, 'NOM_PERSONNE' ) ?>

        <div class="input">
            <?php echo $form->textField($recuImpot, 'NOM_PERSONNE') ?>
            <?php echo $form->error($recuImpot, 'NOM_PERSONNE') ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv( $recuImpot, 'COURRIEL_D_ENVOIE' ) ?>
        <?php echo $form->label( $recuImpot, 'COURRIEL_D_ENVOIE' ) ?>

        <div class="input">
            <?php echo $form->textField($recuImpot, 'COURRIEL_D_ENVOIE') ?>
            <?php echo $form->error($recuImpot, 'COURRIEL_D_ENVOIE') ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv( $recuImpot, 'ACTIVITE' ) ?>
        <?php echo $form->label( $recuImpot, 'ACTIVITE' ) ?>

        <div class="input">
            <?php echo $form->textField($recuImpot, 'ACTIVITE') ?>
            <?php echo $form->error($recuImpot, 'ACTIVITE') ?>
        </div>
    </div>

</fieldset>

<div class="actions well">
    <?php echo CHtml::submitButton( "Sauvegarder", array( 'class' => 'btn primary' ) ) ?>
</div>
