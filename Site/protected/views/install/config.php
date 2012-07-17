<?php $form = $this->beginWidget( 'ActiveForm', array(
    'action' => $action,
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'htmlOptions' => array(
        'class' => 'form-stacked',
    ),
) ) ?>

<style type="text/css">

    .clearfix {
        padding-bottom: 10px;
    }

</style>

<h1>Configuration des paramètres systèmes</h1>

<p>Veuillez remplir ou changer les paramètres systèmes ci-dessous selon vos besoins</p>

<?php echo $form->errorSummary( $model ) ?>

<div class="row">

    <div class="span7">

        <fieldset>

            <h2>Infos générales</h2>

            <?php Bootstrap::inputDiv( $model, "siteName") ?>
                <label>Nom du site web</label>

                <div class="input">
                    <?php echo $form->textField( $model, "siteName" ) ?>
                    <?php echo $form->error( $model, "siteName" ) ?>
                </div>
            </div>

            <?php Bootstrap::inputDiv( $model, "debutSession") ?>
                <label>Date de début de saison pour les scouts</label>

                <div class="input">
                    <?php echo $form->textField( $model, "debutSession", array( 'class' => 'small' ) ) ?>
                    <span class="mask">Ex: 28/02/2011</span>
                    <?php echo $form->error( $model, "debutSession" ) ?>
                </div>
            </div>

            <?php Bootstrap::inputDiv( $model, "finSession" ) ?>
                <label>Date de fin de saison pour les scouts</label>

                <div class="input">
                    <?php echo $form->textField( $model, "finSession", array( 'class' => 'small' ) ) ?>
                    <span class="mask">Ex: 28/02/2011</span>
                    <?php echo $form->error( $model, "finSession" ) ?>
                </div>
            </div>

        </fieldset>

    </div>

    <div class="span7">

        <fieldset>

            <h2>Paypal</h2>

            <?php Bootstrap::inputDiv( $model, "paypalPdtKey") ?>
                <label>Clé PDT Paypal</label>

                <div class="input">
                    <?php echo $form->textField( $model, "paypalPdtKey" ) ?>
                    <?php echo $form->error( $model, "paypalPdtKey" ) ?>
                </div>
            </div>

            <?php Bootstrap::inputDiv( $model, "paypalMerchantId") ?>
                <label>ID de marchand Paypal (Paypal Merchant ID)</label>

                <div class="input">
                    <?php echo $form->textField( $model, "paypalMerchantId" ) ?>
                    <?php echo $form->error( $model, "paypalMerchantId" ) ?>
                </div>
            </div>

            <?php Bootstrap::inputDiv( $model, "paypalConnectMode") ?>
                <label>Mode de connexion au système paypal</label>

                <div class="input">
                    <?php echo $form->dropDownList( $model, "paypalConnectMode", array(
                        'curl' => "cURL",
                        'socket' => 'Socket',
                    ) ) ?>
                    <?php echo $form->error( $model, "paypalConnectMode" ) ?>
                </div>
            </div>

        </fieldset>

    </div>


</div>

<div class="row">
    <div class="span7">

        <fieldset>

            <h2>Courriel</h2>

            <?php Bootstrap::inputDiv( $model, "smtpHost" ) ?>
                <label>Adresse du serveur de courriel SMTP</label>

                <div class="input">
                    <?php echo $form->textField( $model, "smtpHost" ) ?>
                    <?php echo $form->error( $model, "smtpHost" ) ?>
                </div>
            </div>

            <?php Bootstrap::inputDiv( $model, "smtpPort" ) ?>
                <label>Port du serveur SMTP</label>

                <div class="input">
                    <?php echo $form->textField( $model, "smtpPort" ) ?>
                    <?php echo $form->error( $model, "smtpPort" ) ?>
                </div>
            </div>

            <?php Bootstrap::inputDiv( $model, "smtpUsername" ) ?>
                <label>Nom d'utilisateur SMTP</label>

                <div class="input">
                    <?php echo $form->textField( $model, "smtpUsername" ) ?>
                    <?php echo $form->error( $model, "smtpUsername" ) ?>
                </div>
            </div>

            <?php Bootstrap::inputDiv( $model, "smtpPassword" ) ?>
                <label>Mot de passe SMTP</label>

                <div class="input">
                    <?php echo $form->passwordField( $model, "smtpPassword" ) ?>
                    <?php echo $form->error( $model, "smtpPassword" ) ?>
                </div>
            </div>

            <?php Bootstrap::inputDiv( $model, "smtpEncrypt" ) ?>
                <label>Est-ce que le serveur SMTP utilise une connexion encryptée ?</label>

                <div class="input">
                    <?php echo $form->dropDownList( $model, "smtpEncrypt", array(
                        0 => "Oui",
                        1 => "Non",
                    ) ) ?>
                    <?php echo $form->error( $model, "smtpEncrypt" ) ?>
                </div>
            </div>

            <?php Bootstrap::inputDiv( $model, "adminEmail") ?>
                <label>Adresse courriel du système</label>

                <div class="input">
                    <?php echo $form->textField( $model, "adminEmail" ) ?>
                    <?php echo $form->error( $model, "adminEmail" ) ?>
                </div>
            </div>

            <?php Bootstrap::inputDiv( $model, "errorEmail" ) ?>
                <label>Adresse courriel qui recevera les messages d'erreurs du système</label>

                <div class="input">
                    <?php echo $form->textField( $model, "errorEmail" ) ?>
                    <?php echo $form->error( $model, "errorEmail" ) ?>
                </div>
            </div>

        </fieldset>

    </div>

    <div class="span7">

        <fieldset>

            <h2>Reçus d'impôts</h2>

            <?php Bootstrap::inputDiv( $model, "adresseEntreprise") ?>
                <label>Adresse de l'entreprise qui apparaîtra sur les reçus d'impôts</label>

                <div class="input">
                    <?php echo $form->textField( $model, "adresseEntreprise", array( 'class' => 'span7' ) ) ?>
                    <?php echo $form->error( $model, "adresseEntreprise" ) ?>
                </div>
            </div>

            <?php Bootstrap::inputDiv( $model, "numéroEntreprise") ?>
                <label>Numéro d'entreprise</label>

                <div class="input">
                    <?php echo $form->textField( $model, "numeroEntreprise" ) ?>
                    <?php echo $form->error( $model, "numeroEntreprise" ) ?>
                </div>
            </div>

            <?php Bootstrap::inputDiv( $model, "noRecuEntreprise" ) ?>
                <label>Préfixe qui apparaîtra dans le numéro du reçu d'impôt</label>

                <div class="input">
                    <?php echo $form->textField( $model, "noRecuEntreprise" ) ?>
                    <?php echo $form->error( $model, "noRecuEntreprise" ) ?>
                </div>
            </div>

            <?php Bootstrap::inputDiv( $model, "pdfAuthor" ) ?>
                <label>Nom de l'auteur qui apparaîtra dans les PDFs</label>

                <div class="input">
                    <?php echo $form->textField( $model, "pdfAuthor" ) ?>
                    <?php echo $form->error( $model, "pdfAuthor" ) ?>
                </div>
            </div>


        </fieldset>
    </div>

</div>

<div class="well actions">
    <?php echo CHtml::submitButton( "Passer à la prochaine étape", array( 'class' => 'btn primary' ) ) ?>
</div>


<?php $this->endWidget() ?>

<script type="text/javascript">

$( function() {

    $("#ConfigForm_debutSession").datepicker({
        dateFormat: "<?php echo Yii::app()->params['jsDateFormat'] ?>",
    });

    $("#ConfigForm_finSession").datepicker({
        dateFormat: "<?php echo Yii::app()->params['jsDateFormat'] ?>",
    });

});

</script>

