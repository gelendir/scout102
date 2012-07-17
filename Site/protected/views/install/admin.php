<h1>Compte Administrateur</h1>

<p>Veuillez remplir le formulaire ci-dessous pour créer le compte administrateur du système</p>

<?php $form = $this->beginWidget( 'ActiveForm', array(
    'action' => $action,
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'htmlOptions' => array(
        //'class' => 'form-stacked',
    ),
) ) ?>

<?php echo $form->errorSummary( $model ) ?>
<?php echo $form->errorSummary( $adresse ) ?>

<fieldset>

    <h2>Utilisateur</h2>

    <?php Bootstrap::inputDiv( $model, "COURRIEL") ?>
        <label>Adresse courriel</label>

        <div class="input">
            <?php echo $form->textField( $model, "COURRIEL" ) ?>
            <?php echo $form->error( $model, "COURRIEL" ) ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv( $model, "NOM") ?>
        <label>Nom</label>

        <div class="input">
            <?php echo $form->textField( $model, "NOM" ) ?>
            <?php echo $form->error( $model, "NOM" ) ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv( $model, "PRENOM") ?>
        <label>Prénom</label>

        <div class="input">
            <?php echo $form->textField( $model, "PRENOM" ) ?>
            <?php echo $form->error( $model, "PRENOM" ) ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv( $model, "EMPLOI") ?>
        <label>Emploi</label>

        <div class="input">
            <?php echo $form->textField( $model, "EMPLOI" ) ?>
            <?php echo $form->error( $model, "EMPLOI" ) ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv( $model, "MOT_DE_PASSE") ?>
        <label>Mot de passe</label>

        <div class="input">
            <?php echo $form->passwordField( $model, "MOT_DE_PASSE", array( 'class' => 'medium' ) ) ?>
            <?php echo $form->error( $model, "MOT_DE_PASSE" ) ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv( $model, "conf_password") ?>
        <label>Confirmer mot de passe</label>

        <div class="input">
            <?php echo $form->passwordField( $model, "conf_password", array( 'class' => 'medium' ) ) ?>
            <?php echo $form->error( $model, "conf_password" ) ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv( $model, "NO_TEL_PRINCIPAL") ?>
        <label>Numéro de téléphone</label>

        <div class="input">
            <?php echo $form->textField( $model, "NO_TEL_PRINCIPAL", array( 'class' => 'small' ) ) ?>
            <span class="mask">Ex: 418-123-4567</span>
            <?php echo $form->error( $model, "NO_TEL_PRINCIPAL" ) ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv( $model, "SEXE" ) ?>
        <label>Sexe</label>

        <div class="input">
            <?php echo $form->dropDownList($model,'SEXE', array('M'=>'Homme','F'=>'Femme'), array( 'class' => 'small' ) ) ?>
            <?php echo $form->error( $model, "SEXE" ) ?>
        </div>
    </div>

    <h2>Adresse</h2>

    <?php Bootstrap::inputDiv( $adresse, "ADRESSE_RUE") ?>
        <label>Adresse</label>

        <div class="input">
            <?php echo $form->textField( $adresse, "ADRESSE_RUE" ) ?>
            <?php echo $form->error( $adresse, "ADRESSE_RUE" ) ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv( $adresse, "VILLE") ?>
        <label>Ville</label>

        <div class="input">
            <?php echo $form->textField( $adresse, "VILLE" ) ?>
            <?php echo $form->error( $adresse, "VILLE" ) ?>
        </div>
    </div>

    <?php Bootstrap::inputDiv( $adresse, 'PROVINCE' ) ?>
        <?php echo CHtml::activeLabel( $adresse, 'PROVINCE' ) ?>

        <div class="input">
            <?php echo CHtml::ActiveDropDownList( $adresse, 'PROVINCE',
                array(
                    'QC' => 'Québec',
                    'ON' => 'Ontario',
                    'MA' => 'Manitoba',
                    'SA' => 'Saskatchewan',
                    'AL' => 'Alberta',
                    'BC' => 'Colombie-Britannique',
                    'YU' => 'Yukon',
                    'NT' => 'Territoires du Nord-Ouest',
                    'NU' => 'Nunavut',
                    'NV' => 'Nouvelle Écosse',
                    'NB' => 'Nouveau Brunswick',
                    'PE' => 'Île du Prince Edouard',
                    'NW' => 'Terre-Neuve et Labrador',
                ));
            ?>
            <?php echo CHtml::error( $adresse, 'PROVINCE' ) ?>
        </div>

    </div>

    <?php Bootstrap::inputDiv( $adresse, 'codePostal' ) ?>
        <?php echo CHtml::ActiveLabel( $adresse, 'codePostal' ) ?>

        <div class="input">
            <?php echo CHtml::ActiveTextField( $adresse, 'codePostal', array( 'class' => 'small' ) ) ?>
            <span class="mask">(G1G 1G1)</span>
            <?php echo CHtml::error( $adresse, 'codePostal' ) ?>
            <br />
        </div>

    </div>

    <div class="well actions">
        <?php echo CHtml::submitButton("Procédér à la prochaine étape", array( 'class' => 'btn primary' ) ) ?>
    </div>

</fieldset>

<?php $this->endWidget() ?>

<script type="text/javascript">
$( function() {

    $("#Adresse_VILLE").autocomplete({
        source: "<?php echo $this->createUrl( "install/autocomplete" ) ?>",
        minLength: 3
    });

});
