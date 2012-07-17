<h1>Génération des reçus d'impôts</h1>

<h2>Actions</h2>

<?php echo CHtml::link( Yii::t( 'recuImpot', 'preparerManquant' ), array( 'RecuImpot/generate' ), array( 'class' => 'btn primary' ) ) ?>

<?php echo CHtml::beginForm( array( 'RecuImpot/send' ) ) ?>

<h2>Reçus</h2>

<table class="bordered-table">
    <thead>
        <th><?php echo Yii::t( 'recuImpot' ,'nomScout' ) ?></th>
        <th><?php echo Yii::t( 'recuImpot', 'montant' ) ?></th>
        <th><?php echo Yii::t( 'recuImpot', 'etat' ) ?></th>
        <th><?php echo Yii::t( 'recuImpot', 'envoiCourriel' ) ?></th>
        <th><?php echo Yii::t( 'recuImpot', 'envoye' ) ?></th>
        <th><?php echo Yii::t( 'recuImpot', 'imprimer' ) ?></th>
        <th colspan="3"><?php echo Yii::t( 'recuImpot', 'actions' ) ?></th>
    </thead>
    <tbody>
    <?php foreach( $recuImpots as $i => $recuImpot ): ?>
        <?php
            $info = $recuImpot->infoRecuImpot( $tsDebutSession, $tsFinSession );
        ?>
        <tr
            <?php if( $info['etatPaiement'] == false ){ echo 'class="alert-message block-message error"'; } ?>
        >
            <td>
                <?php echo $recuImpot->scout->nomComplet ?>
            </td>
            <td>
                <?php echo Util::formatMoney( $recuImpot->MONTANT ) ?>
            </td>
            <td>
                <?php
                    if( $info['etatPaiement'] == true ) {
                        echo Yii::t( 'recuImpot', 'paye' );
                    } else {
                        echo Yii::t( 'recuImpot', 'nonPaye' );
                    }
                ?>
            </td>
            <td>
                <?php if( $recuImpot->isEnvoiCourriel ): ?>
                    <span class="label success">
                        <?php echo Yii::t( 'recuImpot', 'oui' ) ?>
                    </span>
                    <?php echo CHtml::hiddenField( "RecuImpot[$i][ID_RECU_IMPOT]", $recuImpot->ID_RECU_IMPOT ) ?>
                    <?php echo Chtml::checkBox( "RecuImpot[$i][envoyerCourriel]", ($recuImpot->isEnvoiCourriel && !$recuImpot->dejaEnvoye), array( 'disabled' => ( !$info['etatPaiement'] ) ) ) ?>
                <?php else: ?>
                    <span class="label important">
                        <?php echo Yii::t( 'recuImpot', 'non' ) ?>
                    </span>
                <?php endif ?>
            </td>
            <td>
                <?php
                if( $recuImpot->DATE_EMISSION == null ) {
                    echo Yii::t( 'recuImpot', 'non' );
                } else {
                    echo Yii::t( 'recuImpot', 'oui' );
                }
                ?>
            </td>
            <td>
                <?php echo CHtml::checkBox( "RecuImpot[$i][imprimer]", (!$recuImpot->isEnvoiCourriel && !$recuImpot->dejaEnvoye), array( 'disabled' => ( !$info['etatPaiement'] ) ) ) ?>
            </td>
            <td>
                <?php echo CHtml::link( Yii::t( 'recuImpot', 'modifier' ), array( 'RecuImpot/edit', 'id' => $recuImpot->ID_RECU_IMPOT ) ) ?>
            </td>
            <td>
                <?php echo CHtml::link( Yii::t( 'recuImpot', 'consulter' ), array( 'RecuImpot/show', 'id' => $recuImpot->ID_RECU_IMPOT ) ) ?>
            </td>
            <td>
                <?php if( $recuImpot->isEnvoiCourriel ) {
                    echo CHtml::link( Yii::t( 'recuImpot', 'retransmettre' ), array( 'RecuImpot/resend', 'id' => $recuImpot->ID_RECU_IMPOT ) );
                }
                ?>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<div class="actions well">
    <?php echo CHtml::submitButton( Yii::t( 'recuImpot', 'envoyerRecu' ), array( 'class' => 'btn primary' ) ) ?>
</div>

<?php echo CHtml::endForm() ?>
