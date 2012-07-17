<?php $form=$this->beginWidget('ActiveForm', array('action' => $action)); ?>

    <?php
            $adresses = $famille->adresses;
            
    ?>
    
    <ul class="tabs">
	<li class="active"><a href="#enfant"><?php echo Yii::t( 'scout', 'inscriptionEnfant' ) ?></a></li>
 	<li><a href="#medicale"><?php echo Yii::t( 'scout', 'ficheMedicale' ) ?></a></li>
</ul>
 
<div class="pill-content">

<script>
  $(function () {
    $('.tabs').tabs()
  })
</script>

<div id="enfant" class="active">
<h1>Inscription Enfant</h1>
    <div class="row">

        <div class="col2">

            <span class="description">
               <?php echo Yii::t('scout', 'nomPrenom') ?>
            </span>

            <div class="field">
                <?php echo $form->textField($model,'NOM', array('class' => 'medium') ) ?>
                <?php echo $form->labelMask($model,'NOM'); ?>
            </div>

            <div class="field">
                <?php echo $form->textField($model,'PRENOM', array( 'class' => 'medium') ) ?>
                <?php echo $form->labelMask($model,'PRENOM'); ?>
            </div>
        </div>

        <div class="col2">

            <span class="description">
                Sexe
            </span>

            <div class="field">
                <?php echo $form->DropDownList($model,'SEXE', array('H'=>'Garçon', 'F'=>'Fille')) ?>
                <?php echo $form->label($model,'SEXE'); ?>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col2">

            <span class="description">
                Date de naissance (*)
            </span>

            <div class="field">
                <?php echo $form->textField($model,'dateNaissance', array( 'class' => 'medium' ) ) ?>
                <?php echo $form->labelMask($model,'dateNaissance'); ?>
            </div>

        </div>

        <div class="col2">

            <span class="description">
                Numéro d'assurance maladie (*)
            </span>

            <div class="field">
                <?php echo $form->textField($model,'NO_ASSURANCE_MALADIE', array( 'class' => 'medium' ) ) ?>
                <?php echo $form->labelMask($model,'NO_ASSURANCE_MALADIE'); ?>
            </div>

            <div class="field">
                <?php echo $form->textField($model,'dateFinCarteMedicale', array( 'class' => 'small') ) ?>
                <?php echo $form->labelMask($model,'dateFinCarteMedicale' ); ?>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col2">

            <?php echo $this->renderPartial('//adresse/_selectbox', array(
                'model' => $model,
                'field' => 'ID_ADRESSE_PRINC',
                'adresses' => $adresses,
            ) ) ?>

        </div>

    </div>

    <h2> Section reçu d'impôt </h2>
    <?php $RecuImpot = $model->recuImpot; ?>

    <div class="row">

        <div class="col2">

                <span class="description">Nom et prénom (*)</span>
                
                <div class="field">
                    <?php echo $form->textField($RecuImpot,'NOM_PERSONNE', array('class' => 'medium') ) ?>
                    <?php echo $form->labelMask($RecuImpot,'NOM_PERSONNE'); ?>
                </div>

                <div class="field">
                    <?php echo $form->textField($RecuImpot,'PRENOM_PERSONNE', array( 'class' => 'medium') ) ?>
                    <?php echo $form->labelMask($RecuImpot,'PRENOM_PERSONNE'); ?>
                </div>
                
        </div>
        <div class="col2">
        
                <span class="description">Courriel</span>
                
                <div class="field">
                    <?php echo $form->textField($RecuImpot,'COURRIEL_D_ENVOIE' ) ?>
                    <?php echo $form->labelMask($RecuImpot,'COURRIEL_D_ENVOIE'); ?>
                </div>

        </div>
    
    </div>
    

    <h2> Section contact en cas d'urgence </h2>
    
    <div class="row">

        <div class="col2">
        
                <span class="description">Nom et prénom (*)</span>
                
                <div class="field">
                    <?php echo $form->textField($model,'CONT_URG_NOM', array( 'class' => 'medium') ) ?>
                    <?php echo $form->labelMask($model,'CONT_URG_NOM' ); ?>
                </div>
                
                <div class="field">
                    <?php echo $form->textField($model,'CONT_URG_PRENOM', array( 'class' => 'medium') ) ?>
                    <?php echo $form->labelMask($model,'CONT_URG_PRENOM' ); ?>
                </div>

        </div>

        <div class="col2">

                <span class="description">Téléphone (*)</span>

                <div class="field">
                    <?php echo $form->textField($model,'CONT_URG_NO_TEL', array( 'class' => 'medium') ) ?>
                    <?php echo $form->labelMask($model,'CONT_URG_NO_TEL' ); ?>
                </div>
        </div>
        
        <div class="col2">

            <span class="description">Lien avec le jeune(*)</span>

            <div class="field">
                    <?php echo $form->textField($model,'CONT_URG_LIEN_JEUNE', array( 'class' => 'medium') ) ?>
                    <?php echo $form->labelMask($model,'CONT_URG_LIEN_JEUNE' ); ?>
                </div>

        </div>
    
    </div>

    <h2> Autres </h2>
    <div class="row">

        <div class="col2">

            <span class="description">Particularité de votre jeune</span>

            <div class="field">
                <?php echo $form->textArea($model,'PARTICULARITE', array('class' => 'xlarge', 'rows' => '7') ) ?>
            </div>

        </div>

        

    </div>

    <h2>Section des autorisations</h2>

        <?php foreach( $model->autorisations as $i=>$autorisation ): ?>

            <div class="row">

                <p>
                    <?php echo $autorisation->typeAutorisation->DESCRIPTION ?>
                </p>

                <?php echo $form->checkBox( $autorisation, "ACCEPTATION[$i]", array(
                    'checked' => $autorisation->ACCEPTATION
                ) ) ?>
                <?php echo $form->hiddenField($autorisation->typeAutorisation, "ID_TYPE_AUTO[$i]",array('value' => $autorisation->typeAutorisation->ID_TYPE_AUTO))?>
                <span>J'accepte</span>

            </div>

        <?php endforeach ?>

    <div class="row">

        <?php echo CHtml::submitButton('Sauvegarder', array( 'class' => 'btn primary' ) ) ?>

    </div>
</div>

<div id="medicale">

<?php 

    $NB_PER_ROW = 4;
    $compteur = 0;
    $compteurTexte = 0;


?>

    <h1>
        Fiche médicale
        <?php echo $form->hiddenField($ficheMedicale, 'ID_SCOUT') ?>
    </h1>

    <p>
        Si vous ne pouvez complétér la fiche, cliquez sur "Sauvegarder" au bas de la page
        sans cocher la case "Je comprends et j'accepte".
    </p>

    <h2>
        État médical
    </h2>

    <div class="row">

        <p>Cochez les éléments applicables.</p>

        <table>
            <?php
                $count = 0;
                foreach ($ficheMedicale->getReponsesCases("État médical") as $i => $reponse)
                {
                    
                    if ( $count == 0 ) {
                        echo "<tr>";
                    }
            ?>

            <td>
                <?php $option = array('value'=>1);
                if($reponse->REPONSE == 1){
                    $option['checked'] = true;
                } 
                echo CHtml::activeCheckbox($reponse, "REPONSE[$compteur]", $option);?>
            </td>

            <td>
                <?php echo $reponse->caseACocher->DESCRIPTION;
                      echo $form->hiddenField($reponse, "ID_CASE_A_COCHER[$compteur]", array('value'=>$reponse->caseACocher->ID_CASE_A_COCHER));
                ?>
            </td>

            <?php
                $count++;
                $compteur++;
                if ($count == $NB_PER_ROW)
                {
                    echo "</tr>";
                    $count = 0;
                }
            }
            ?>
        </table>

    </div>

    <div class="row">

        <p>Autre (Veuillez entrer un état par ligne)</p>

        <?php echo $form->textArea( $ficheMedicale, 'COMMENTAIRES', array( 'class' => 'xlarge', 'rows' => '7' ))?>

    </div>

    <h2>
        Questions générales
    </h2>

    <div class="row">
        <p>
            Sélectionner si oui ou non les informations sont applicables à votre enfant.
        </p>
        <table class="zebra-striped">
            <thead>
                <th width="350px">
                </th>
                <th>
                    Oui
                </th>
                <th>
                    Non
                </th>
            </thead>
            <?php
                foreach ($ficheMedicale->getReponsesCases("Questions générales") as $reponse) {

            ?>
                    <tr>
                        <td>
                            <?php echo $reponse->caseACocher->DESCRIPTION; 
                                  echo $form->hiddenField($reponse, "ID_CASE_A_COCHER[$compteur]", array('value'=>$reponse->caseACocher->ID_CASE_A_COCHER));
                            ?>
                        </td>
                        <td>
                        
                            <?php  
                                $options = array('uncheckValue' => null, 'value' => 1);
                                if( $reponse->REPONSE === "1" ) {
                                    $options['checked'] = true;
                                }
                                ?>
                                <input type="radio" value="1" name="ReponseCase[REPONSE][<?php echo $compteur ?>]" <?php if( $reponse->REPONSE === "1" ) { echo 'checked="checked"'; } ?> />
                                
                                <?php //echo $form->radioButton( $reponse, "REPONSE[$compteur]", $options ); ?>
                        </td>
                        <td>
                            <?php
                                $options = array('uncheckValue' => null, 'value' => 0);
                                if( $reponse->REPONSE === "0" ) {
                                    $options['checked'] = true;
                                }
                                //echo $form->radioButton( $reponse, "REPONSE[$compteur]", $options );
                            ?>
                            <input type="radio" value="0" name="ReponseCase[REPONSE][<?php echo $compteur ?>]" <?php if( $reponse->REPONSE === "0" ) { echo 'checked="checked"'; } ?> />
                                
                        </td>
                    </tr>
            <?php
                $compteur++;
                }
            ?>
        </table>
    </div>

    <h2>
        Médicaments autorisés (en vente libre)
    </h2>

    <div class="row">

        <p>
            Sélectionner si oui ou non ces médicaments tablette sont autorisés pour votre enfant.
        </p>

        <table class="zebra-striped">
            <thead>
                <th width="350px">
                    Médicament
                </th>
                <th>
                    Oui
                </th>
                <th>
                    Non
                </th>
            </thead>
            <?php
                foreach ($ficheMedicale->getReponsesCases("Médicaments autorisés") as $reponse) {
          
            ?>
                    <tr>
                        <td>
                            <?php echo $reponse->caseACocher->DESCRIPTION; 
                                  echo $form->hiddenField($reponse, "ID_CASE_A_COCHER[$compteur]", array('value'=>$reponse->caseACocher->ID_CASE_A_COCHER));
                            ?>
                        </td>
                        <td>
                        
                            <?php  
                                $options = array('uncheckValue' => null, 'value' => 1);
                                if( $reponse->REPONSE === "1" ) {
                                    $options['checked'] = true;
                                }
                                ?>
                                <input type="radio" value="1" name="ReponseCase[REPONSE][<?php echo $compteur ?>]" <?php if( $reponse->REPONSE === "1" ) { echo 'checked="checked"'; } ?> />
                                
                                <?php //echo $form->radioButton( $reponse, "REPONSE[$compteur]", $options ); ?>
                        </td>
                        <td>
                            <?php
                                $options = array('uncheckValue' => null, 'value' => 0);
                                if( $reponse->REPONSE === "0" ) {
                                    $options['checked'] = true;
                                }
                                //echo $form->radioButton( $reponse, "REPONSE[$compteur]", $options );
                            ?>
                            <input type="radio" value="0" name="ReponseCase[REPONSE][<?php echo $compteur ?>]" <?php if( $reponse->REPONSE === "0" ) { echo 'checked="checked"'; } ?> />
                                
                        </td>
                    </tr>
            <?php
                $compteur++;
                }
            ?>
        </table>

    </div>

    <h2>
        Médicaments sous prescription avec posologie
    </h2>

    <!-- TODO: find a way to generate all sections -->
    <div class="row">

        <p>
            Indiquez TOUS les médicaments sous prescription que votre jeune doit prendre et
            la posologie.
        </p>

        <p>
            (entrez un médicament par ligne et la posologie )
        </p>

        <?php foreach( $ficheMedicale->getReponseTexte('Médicaments sous posologie') as $reponse ): ?>
                <?php 
                echo CHtml::textArea("TEXTE[$compteurTexte]", $reponse->TEXTE); 
                echo $form->hiddenField($reponse, "ID_CAT_CHAMP_TEXTE[$compteurTexte]", array('value'=>$reponse->categorieChampTexte->ID_CAT_CHAMP_TEXTE));
                $compteurTexte++;
                ?>            
        <?php endforeach ?>

    </div>

    <h3>
        Allergies
    </h3>

    <div class="row">

        <p>
            Indiquez TOUTES les allergies de votre jeune
        </p>

        <p>
             (une allergie par ligne)
        </p>

        <?php foreach( $ficheMedicale->getReponseTexte('Allergies') as $reponse ): ?>
               <?php             
               echo CHtml::textArea("TEXTE[$compteurTexte]", $reponse->TEXTE) ;
               echo $form->hiddenField($reponse, "ID_CAT_CHAMP_TEXTE[$compteurTexte]", array('value'=>$reponse->categorieChampTexte->ID_CAT_CHAMP_TEXTE));
               $compteurTexte++;
               ?>
        <?php endforeach ?>

    </div>

    <h2>
        Peurs et phobies
    </h2>

    <div class="row">

        <p>
            Indiquez les peurs et phobies de votre jeune
        </p>

        <p>
        (entrez une peur ou une phobie par ligne)
        </p>

        <?php foreach( $ficheMedicale->getReponseTexte('Peurs et phobies') as $reponse ): ?>
                <?php 
                echo CHtml::textArea("TEXTE[$compteurTexte]", $reponse->TEXTE);
                echo $form->hiddenField($reponse, "ID_CAT_CHAMP_TEXTE[$compteurTexte]", array('value'=>$reponse->categorieChampTexte->ID_CAT_CHAMP_TEXTE));
                $compteurTexte++;
                ?>
        <?php endforeach ?>

    </div>

    <h2>Informations scolaires</h2>

    <div class="row">

        <div class="col3">

            <span class="description">
                Nom de l'école
            </span>

            <div class="field">
                <?php echo $form->textField($scolarite, "NOM_ECOLE" ) ?>
                <?php echo $form->label($scolarite, "NOM_ECOLE" ) ?>
            </div>

        </div>

        <div class="col3">

            <span class="description">
                Niveau scolaire
            </span>

            <div class="field">

                <?php echo $form->dropDownList($scolarite, "ID_NIVEAU", array(
                    1=>'1ère année',
                    2=>'2e année',
                    3=>'3e année',
                    4=>'4e année',
                    5=>'5e année',
                    6=>'6e année',
                    7=>'Secondaire 1',
                    8=>'Secondaire 2',
                    9=>'Secondaire 3',
                    10=>'Secondaire 4',
                    11=>'Secondaire 5'));
                ?>

                <?php echo $form->label($scolarite, "ID_NIVEAU" ) ?>

            </div>

        </div>

        <div class="col3">

            <span class="description">
                Nom de l'enseignant
            </span>

            <div class="field">

                <?php echo $form->textField($scolarite, "NOM_ENSEIGNANT");?>
                <?php echo $form->label($scolarite, "NOM_ENSEIGNANT") ?>

            </div>

        </div>

    </div>

    <h2>
        Autres activités
    </h2>

    <div class="row">

        <p>
            Indiquez les autres activités, loisirs ou sports de votre jeune
        </p>

        <p>
            (entrez une activité par ligne)
        </p>

        <?php 
            foreach( $ficheMedicale->getReponseTexte('Autres activités') as $reponse){
                echo CHtml::textArea("TEXTE[$compteurTexte]", $reponse->TEXTE);
                echo $form->hiddenField($reponse, "ID_CAT_CHAMP_TEXTE[$compteurTexte]", array('value'=>$reponse->categorieChampTexte->ID_CAT_CHAMP_TEXTE));
                $compteurTexte++;
            }
        ?>

    </div>

    <h2>
        Autres conditions médicale ou particularité
    </h2>

    <div class="row">

        <p>
            (entrez une activité par ligne)
        </p>

        <?php
            foreach( $ficheMedicale->getReponseTexte('Autres conditions médicales ou particularités') as $reponse){
                echo CHtml::textArea("TEXTE[$compteurTexte]", $reponse->TEXTE);
                echo $form->hiddenField($reponse, "ID_CAT_CHAMP_TEXTE[$compteurTexte]", array('value'=>$reponse->categorieChampTexte->ID_CAT_CHAMP_TEXTE));
                $compteurTexte++;
            }
        ?>
    </div>

    <p>
        Si vous ne pouvez compléter la fiche, cliquez sur "Sauvegarder" au bas de la page
        sans cocher la case "Je comprends et j'accepte".
    </p>

    <h2>
        Confirmation et attestation
    </h2>

    <div class="row">

        <p>
            J'atteste que les informations entrées sur ce formulaire sont correctes et j'autorise
            l'accès à ces informations au personnel qui s'occupe de mon jeune.
        </p>

        <?php
            echo $form->checkBox($ficheMedicale, "FICHE_CONFIRME"); 
        ?>
        
        <span>Je comprends et j'accepte</span>

    </div>

    <div class="row">

        <p>
            Confirmer avec votre mot de passe
        </p>

        <input type="password" />

    </div>

    <div class="row">

        <?php echo CHtml::submitButton( 'Sauvegarder', array( 'class' => 'btn primary' ) ) ?>

    </div>

<?php $this->endWidget(); ?>

</div>


<?php $this->renderPartial("//adresse/window", array( 'adresse' => new Adresse(), 'selector' => "#Scout_ID_ADRESSE_PRINC" ) ) ?>

<script type="text/javascript"> 

    $(document).ready(function() {

        $("#Scout_dateNaissance").datepicker({
            dateFormat: "dd/mm/yy"
        });

    });

</script>
