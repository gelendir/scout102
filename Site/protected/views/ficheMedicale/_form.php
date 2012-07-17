<?php 

    $NB_PER_ROW = 4;
    $compteur = 0;
    $compteurTexte = 0;

?>

    <?php echo $form->errorSummary( $ficheMedicale ) ?>
    <?php echo $form->errorSummary( $Scolarite ) ?>

    <h1>
        <?php echo Yii::t( 'ficheMedicale', 'ficheMed' ) ?>
        <?php if( $ficheMedicale->scout != null ) {
            echo " : " . $ficheMedicale->scout->nomComplet;
        } ?>
        <?php echo $form->hiddenField($ficheMedicale, 'ID_SCOUT') ?>
    </h1>

    <p>
       <?php echo Yii::t( 'ficheMedicale', 'messInfo' ) ?>
    </p>

    <h2>
        <?php echo Yii::t( 'ficheMedicale', 'etatMed' ) ?>
    </h2>

    <div class="row">

        <p><?php echo Yii::t( 'ficheMedicale', 'cochezEl' ) ?></p>

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

        <p><?php echo Yii::t( 'ficheMedicale', 'autreEtat' ) ?></p>

        <?php echo $form->textArea( $ficheMedicale, 'COMMENTAIRES', array( 'class' => 'xlarge', 'rows' => '7' ))?>

    </div>

    <h2>
        <?php echo Yii::t( 'ficheMedicale', 'questionsG' ) ?>
    </h2>

    <div class="row">
        <p>
        	<?php echo Yii::t( 'ficheMedicale', 'selectionQ' ) ?>
        </p>
		<table class="zebra-striped reduced bordered-table">
            <thead>
                <th width="350px">
                    <?php echo Yii::t( 'ficheMedicale', 'question' ) ?>
                </th>
                <th>
                    <?php echo Yii::t( 'ficheMedicale', 'oui' ) ?>
                </th>
                <th>
                    <?php echo Yii::t( 'ficheMedicale', 'non' ) ?>
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
                                <input type="hidden" value="" name="ReponseCase[REPONSE][<?php echo $compteur ?>]" />
                        		<input type="radio" value="1" name="ReponseCase[REPONSE][<?php echo $compteur ?>]" <?php if( $reponse->REPONSE === "1" ) { echo 'checked="checked"'; } ?> />
                        </td>
                        <td>
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
        <?php echo Yii::t( 'ficheMedicale', 'medAut' ) ?>
    </h2>

    <div class="row">

        <p>
            <?php echo Yii::t( 'ficheMedicale', 'selectionM' ) ?>
        </p>
		


        <table class="zebra-striped reduced bordered-table">
            <thead>

                <th width="350px">
                    <?php echo Yii::t( 'ficheMedicale', 'med' ) ?>
                </th>
                <th>
                    <?php echo Yii::t( 'ficheMedicale', 'oui' ) ?>
                </th>
                <th>
                    <?php echo Yii::t( 'ficheMedicale', 'non' ) ?>
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
                                <input type="hidden" value="" name="ReponseCase[REPONSE][<?php echo $compteur ?>]" />
                        		<input type="radio" value="1" name="ReponseCase[REPONSE][<?php echo $compteur ?>]" <?php if( $reponse->REPONSE === "1" ) { echo 'checked="checked"'; } ?> />
                        </td>
                        <td>
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
        <?php echo Yii::t( 'ficheMedicale', 'medPres' ) ?>
    </h2>

    <!-- TODO: find a way to generate all sections -->
    <div class="row">

        <p>
            <?php echo Yii::t( 'ficheMedicale', 'indiquezMed' ) ?>
        </p>

        <p>
            <?php echo Yii::t( 'ficheMedicale', 'entrezMed' ) ?>
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
        <?php echo Yii::t( 'ficheMedicale', 'allergies' ) ?>
    </h3>

    <div class="row">

        <p>
            <?php echo Yii::t( 'ficheMedicale', 'indiquezAll' ) ?>
        </p>

        <p>
             <?php echo Yii::t( 'ficheMedicale', 'entrezAll' ) ?>
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
        <?php echo Yii::t( 'ficheMedicale', 'peursPhobies' ) ?>
    </h2>

    <div class="row">

        <p>
            <?php echo Yii::t( 'ficheMedicale', 'indiquezPeur' ) ?>
        </p>

        <p>
        <?php echo Yii::t( 'ficheMedicale', 'entrezPeur' ) ?>
        </p>

        <?php foreach( $ficheMedicale->getReponseTexte('Peurs et phobies') as $reponse ): ?>
	            <?php 
	            echo CHtml::textArea("TEXTE[$compteurTexte]", $reponse->TEXTE);
	            echo $form->hiddenField($reponse, "ID_CAT_CHAMP_TEXTE[$compteurTexte]", array('value'=>$reponse->categorieChampTexte->ID_CAT_CHAMP_TEXTE));
				$compteurTexte++;
	            ?>
        <?php endforeach ?>

    </div>

    <h2><?php echo Yii::t( 'ficheMedicale', 'infoScolaire' ) ?></h2>

    <div class="row">

        <div class="col3">

            <span class="description">
                <?php echo Yii::t( 'ficheMedicale', 'nomEcole' ) ?>
            </span>

            <div class="field">
                <?php echo $form->textField($Scolarite, "NOM_ECOLE", array( 'class' => 'autocomplete-ecole' ) ) ?>
            </div>

        </div>

        <div class="col3">

            <span class="description">
                <?php echo Yii::t( 'ficheMedicale', 'nivScol' ) ?>
            </span>

            <div class="field">

                <?php echo $form->dropDownList($Scolarite, "ID_NIVEAU",
                    CHtml::listData(
                        NiveauScolaire::model()->findAll(),
                        'ID_NIVEAU_SCOLAIRE',
                        'DESCRIPTION_NIVEAU'
                    )
                ); ?>


            </div>

        </div>

        <div class="col3">

            <span class="description">
                <?php echo Yii::t( 'ficheMedicale', 'nomEns' ) ?>
            </span>

            <div class="field">

                <?php echo $form->textField($Scolarite, "NOM_ENSEIGNANT");?>

            </div>

        </div>

    </div>

    <h2>
       <?php echo Yii::t( 'ficheMedicale', 'autreAct' ) ?>
    </h2>

    <div class="row">

        <p>
            <?php echo Yii::t( 'ficheMedicale', 'indiquezAct' ) ?>
        </p>

        <p>
            <?php echo Yii::t( 'ficheMedicale', 'entrezAct' ) ?>
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
        <?php echo Yii::t( 'ficheMedicale', 'autreCond' ) ?>
    </h2>

    <div class="row">

        <p>
            <?php echo Yii::t( 'ficheMedicale', 'entrezCond' ) ?>
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
        <?php echo Yii::t( 'ficheMedicale', 'messInfoFin' ) ?>
    </p>

    <?php if( !( isset( $cacherConfirmation ) && $cacherConfirmation == true ) ): ?>

        <h2>
            <?php echo Yii::t( 'ficheMedicale', 'confAtt' ) ?>
        </h2>

        <div class="row">

            <p>
                <?php echo Yii::t( 'ficheMedicale', 'atteste' ) ?>
            </p>

            <?php
                echo $form->checkBox($ficheMedicale, "FICHE_CONFIRME");
            ?>

            <span><?php echo Yii::t( 'ficheMedicale', 'compAcc' ) ?></span>

        </div>

        <div class="row">

            <p>
                <?php echo Yii::t( 'ficheMedicale', 'confMotPasse' ) ?>
            </p>

            <?php echo $form->passwordField( $ficheMedicale, 'motDePasse' ) ?>

        </div>

    <?php endif ?>

    <div class="row">

        <?php echo CHtml::submitButton( 'Sauvegarder', array( 'class' => 'btn primary' ) ) ?>

    </div>

<script type="text/javascript">
$( function() {

    $(".autocomplete-ecole").autocomplete({
        source: "<?php echo $this->createUrl( "ficheMedicale/autocomplete" ) ?>",
        minLength: 3
    });

});
</script>

<?php if( !( isset( $cacherConfirmation ) && $cacherConfirmation == true ) ): ?>

    <script type="text/javascript">
        $( function() {
            $("#FicheMedicale_FICHE_CONFIRME").parents("form").submit( function() {
                if( !$("#FicheMedicale_FICHE_CONFIRME").is(":checked") ) {
                    var answer = confirm("Attention: vous n'avez pas confirmé l'attestation de ce formulaire. Voulez-vous vraiment sauvegarder ?");
                    return answer;
                }

                return true;
            });
        });
    </script>

<?php endif ?>
