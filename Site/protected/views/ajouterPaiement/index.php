<h1><?php echo Yii::t( 'paiement', 'ajoutVersement' ) ?></h1>

<form action="/?r=ajouterPaiement/ajouter" method="POST">

    <div id="informations">

        <input type="hidden" name="idVersement" value="<?php echo $id ?>" />

        <p id="scout"><b><?php echo Yii::t( 'paiement', 'nomScout' ) ?></b></p>
        <?php echo $rows[0]['Nom_du_scout']; ?> </br>
        <p id="scout" style="padding-top: 10px;"><b><?php echo Yii::t( 'paiement', 'nomParents' ) ?></b></p>
        <?php echo $rows[0]['Nom_parents']; ?>  </br>
        <p id="scout" style="padding-top: 10px;"><b><?php echo Yii::t( 'paiement', 'noFacture' ) ?></b></p>
        <?php 
            if($rows[0]['Id_facture'] != ""){
                echo $rows[0]['Id_facture']; 
            } else {
                echo "Il n'y a pas de facture d'associée à ce versement à l'heure actuelle.";
            }
        ?>  </br>
        <p id="scout" style="padding-top: 10px;"><b><?php echo Yii::t( 'paiement', 'noVersement' ) ?></b></p>
        <?php
            if($rows[0]['Id_versement'] == 1){
                echo $rows[0]['Id_versement'] . "er versement"; 
            } else {
                echo $rows[0]['Id_versement'] . "ème versement";
            }

        ?>
        </br>
        <p id="scout" style="padding-top: 10px;"><b><?php echo Yii::t( 'paiement', 'dateVersement' ) ?></b></p>
        <?php echo $rows[0]['Date_versement']; ?></br>
        <p id="scout" style="padding-top: 10px;"><b><?php echo Yii::t( 'paiement', 'montantPaye' ) ?></b></p>
        <?php echo $rows[0]['Montant_versement'] . " $"; ?> </br>       
        <p id="scout" style="padding-top: 10px;"><b><?php echo Yii::t( 'paiement', 'modePaiement' ) ?></b></p>

    </div>

        <?php 
            if($versement->ETAT == 0){
                $modePaiement = ModePaiement::model()->findAll();
                $modelPaiement = new ModePaiement;
                $listDataUnite = CHtml::listData($modePaiement,'ID_MODE_PAIEMENT', 'NOM_MODE');
                echo CHtml::dropDownList('ID_MODE_PAIEMENT' , '', $listDataUnite);
        ?>

    <div style="padding-top: 15px;">
        <input type="button" class="btn primary" value="Retour à la liste" onClick="parent.location='/?r=paiementManuel/index'" />
        <?php echo CHtml::submitButton( 'Ajouter le versement', array( 'class' => 'btn primary' )); ?>
    </div>

    <?php 
        } else {
            echo $rows[0]['Mode_paiement'];
    ?>


   <div style="padding-top: 15px;">
        <input type="button" class="btn primary" value="Retour à la liste" onClick="parent.location='/?r=paiementManuel/index'" />
    </div>

    <?php
        }
    ?>
</form>
