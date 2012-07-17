<?php echo CHtml::image( Yii::app()->request->baseUrl . '/images/logo_recu.png' ) ?>

<h1><?php echo Yii::t( 'paiement', 'recuFacture' ) ?></h1>

<b><?php echo Yii::t( 'paiement', 'idFacture' ) ?></b>
<span>
    <?php echo $facture->ID_FACTURE ?>
</span>
<br />
<br />

<b><?php echo Yii::t( 'paiement', 'idPaiement' ) ?></b>
<span>
    <?php echo $facture->paiementPaypal->ID_TRANSACTION ?>
</span>
<br />
<br />

<b><?php echo Yii::t( 'paiement', 'idScout' ) ?></b>
<ul>
    <?php foreach( $facture->scouts as $scout ): ?>
        <li><?php echo $scout->nomComplet ?></li>
    <?php endforeach ?>
</ul>
<br />
<br />

<b><?php echo Yii::t( 'paiement', 'date' ) ?></b>
<span>
    <?php echo Util::formatDate( Util::parseDbDate( $facture->DATE_FACTURE ) ) ?>
</span>
<br />
<br />

<b><?php echo Yii::t( 'paiement', 'dateVersement' ) ?></b>
<ul>
    <?php foreach( $facture->dateVersements as $dateVersement ): ?>
        <li><?php echo Util::formatDate( $dateVersement ) ?></li>
    <?php endforeach ?>
</ul>
<br />
<br />

<b><?php echo Yii::t( 'paiement', 'modePaiement' ) ?></b>
<span>
    <?php echo $facture->modePaiement->DESCRIPTION ?>
</span>
<br />
<br />

<b><?php echo Yii::t( 'paiement', 'montant' ) ?></b>
<span>
    <?php echo Util::formatMoney( $facture->MONTANT ) ?>
</span>
<br />
<br />
