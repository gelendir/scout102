<?php $form = $this->beginWidget( 'ActiveForm', array(
    'action' => $action,
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
) ) ?>

<h1>Configuration et création de la base de donnée</h1>

<p>Avant d'entrer les informations de connexion, veuillez choisir une des options ci-dessous : </p>

<ul>
    <li>
        <?php echo $form->radioButton( $model, 'createDb', array( 'value' => 1, 'uncheckValue' => null ) ) ?>
        <span>Créer une nouvelle base de données ainsi que les tables</span>
    </li>
    <li>
        <?php echo $form->radioButton( $model, 'createDb', array( 'value' => 0, 'uncheckValue' => null ) ) ?>
        <span>Utiliser une base de données déja existante, créer toutes les tables</span>
    </li>
</ul>

<p>
    <span class="label notice">Note:</span> 
    Si vous sélectionnez la première option, l'utilisateur BD doit avoir les GRANT nécessaires pour créer une base de données.
    Vous pouvez éxécuter la requête SQL ci-dessous pour ajouter le GRANT nécessaire en MySQL: 
</p>

<pre class="prettyprint">
    GRANT CREATE ON nom_de_la_bd.* TO 'utilisateur'@'adresse_ip';
</pre>

    <?php echo $form->errorSummary( $model ) ?>

    <fieldset>

        <?php Bootstrap::inputDiv( $model, "host") ?>
            <label>Hôte</label>

            <div class="input">
                <?php echo $form->textField( $model, "host" ) ?>
                <?php echo $form->error( $model, "host" ) ?>
            </div>
        </div>

        <?php Bootstrap::inputDiv( $model, "port") ?>
            <label>Port</label>

            <div class="input">
                <?php echo $form->textField( $model, "port" ) ?>
                <?php echo $form->error( $model, "port" ) ?>
            </div>
        </div>

        <?php Bootstrap::inputDiv( $model, "dbName") ?>
            <label>Nom de la base de données</label>

            <div class="input">
                <?php echo $form->textField( $model, "dbName" ) ?>
                <?php echo $form->error( $model, "dbName" ) ?>
            </div>
        </div>

        <?php Bootstrap::inputDiv( $model, "username") ?>
            <label>Nom d'utilisateur</label>

            <div class="input">
                <?php echo $form->textField( $model, "username" ) ?>
                <?php echo $form->error( $model, "username" ) ?>
            </div>
        </div>

        <?php Bootstrap::inputDiv( $model, "password") ?>
            <label>Mot de passe</label>

            <div class="input">
                <?php echo $form->passwordField( $model, "password" ) ?>
                <?php echo $form->error( $model, "password" ) ?>
            </div>
        </div>


        <?php Bootstrap::inputDiv( $model, 'demo' ) ?>
            <label>Autres options</label>

            <div class="input">
                <ul class="inputs-list">
                    <li>
                        <label>
                            <?php echo $form->checkBox( $model, 'demo' ) ?>
                            <span><em>Veuillez cocher cette case si vous voulez insérer des données à des fins de démonstration</em></span>
                        </label>
                    </li>
                    <li>
                    </li>
                </ul>
            </div>
        </div>

        <div class="actions">
            <?php echo CHtml::submitButton( "Passer à la prochaine étape", array( 'class' => 'btn primary' ) ) ?>
        </div>

    </fieldset>

    <div class="row


<?php $this->endWidget() ?>
