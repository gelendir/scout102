<?php $this->renderPartial( '_facture', array(
    'facture' => $facture
) ) ?>

<div class="well actions">

    <?php
        echo CHtml::link(
            Yii::t( 'paiement', 'sendPdf' ),
            array( 'FichePaiement/facturePdf', 'id' => $facture->ID_FACTURE ), 
            array( 'class' => 'btn primary' )
        );
    ?>

    <?php
        echo CHtml::link(
            Yii::t( 'paiement', 'backHome' ),
            array( 'FicheEnfant/index' ),
            array( 'class' => 'btn secondary' )
        );
    ?>

</div>

