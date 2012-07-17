<h1><?php echo Yii::t( 'paiement', 'paiements' ) ?></h1>

<h2><?php echo Yii::t( 'paiement', 'tableau' ) ?></h2>

<?php
    $formatDate = Yii::app()->params['formatDate'];
    $formatArgent = Yii::app()->params['formatArgent'];
?>

<table class="bordered-table zebra-striped reduced">
    <thead>
        <th><?php echo Yii::t( 'paiement', 'nbEnfDate' ) ?></th>
        <?php foreach( $tableauTarifs['dateVersements'] as $date ): ?>
            <th>
                <?php echo date( $formatDate, $date ) ?> 
            </th>
        <?php endforeach ?>
    </thead>
    <tbody>
        <?php foreach( $tableauTarifs['tarifsParEnfant'] as $nbEnfant => $tarifs ): ?>
            <tr>
                <td>
                    <?php echo $nbEnfant ?> enfant(s)
                    <?php
                        $total = 0;
                        foreach( $tarifs as $tarif ) {
                            $total += $tarif;
                        }
                        echo sprintf( "(" . $formatArgent . ")" , $total );
                    ?>
                </td>
                <?php foreach( $tarifs as $tarif ): ?>
                    <td>
                        <?php echo sprintf( $formatArgent, $tarif ) ?>
                    </td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<p><?php echo Yii::t( 'paiement', 'inscritEnCours' ) ?></p>

<ul>
<?php foreach( $scouts as $scout ): ?>
    <li>
        <?php echo $scout->nomComplet ?>
    </li>
<?php endforeach ?>
</ul>

<h2><?php echo Yii::t( 'paiement', 'paypal' ) ?></h2>

<p><?php echo Yii::t( 'paiement', 'resumePaypal' ) ?></p>

<?php

    $totalPaypal = $famille->totalPaypal( $debutSession, $finSession );
    $soldePaypal = $famille->soldePaypal( $debutSession, $finSession );
    $montantPaypal = $totalPaypal - $soldePaypal;

?>

<table class="bordered-table zebra-striped reduced">
    <thead>
        <th>
            <?php echo Yii::t( 'paiement', 'nbEnfants' ) ?>
        </th>
        <th>
            <?php echo Yii::t( 'paiement', 'tarif' ) ?>
        </th>
        <th>
            <?php echo Yii::t( 'paiement', 'montantPaye' ) ?>
        </th>
        <th>
            <?php echo Yii::t( 'paiement', 'solde' ) ?>
        </th>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo count( $scouts ) ?>
            </td>
            <td>
                <?php echo sprintf( $formatArgent, $totalPaypal ) ?>
            </td>
            <td>
                <?php echo sprintf( $formatArgent, $soldePaypal ) ?>
            </td>
            <td>
                <?php echo sprintf( $formatArgent, $montantPaypal ) ?>
            </td>
        </tr>
    </tbody>
</table>

<?php 

    $form = $this->beginWidget('ActiveForm', array(
        'action' =>array('FichePaiement/paypal'),
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
    ));

?>

<div class="well actions">
    <?php echo CHtml::submitButton( Yii::t( 'paiement', 'btnPayer' ), array( 'name' => 'paypal', 'class' => 'btn primary') ); ?>
</div>

<?php $this->endWidget() ?>

