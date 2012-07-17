<h1><?php echo Yii::t( 'scout', 'accueil' ) ?></h1>

<h2><?php echo Yii::t( 'scout', 'actions' ) ?></h2>

<ul class="actionlist">
    <li>
        <a href="<?php echo $this->createUrl( 'FicheEnfant/new' ) ?>">
            <img src="<?php echo Yii::app()->request->baseUrl . "/images/add.png" ?>" />
            <span><?php echo Yii::t( 'scout', 'ajouterEnfant' ) ?></span>
        </a>
    </li>
    <li>
        <a href="<?php echo $this->createUrl( 'FicheParent/edit', array( 'id' => Yii::app()->user->id ) ) ?>">
            <img src="<?php echo Yii::app()->request->baseUrl . "/images/blue_user.png" ?>" />
            <span><?php echo Yii::t( 'scout', 'modifierProfil' ) ?></span>
        </a>
    </li>
    <?php if( count( $enfants ) > 0 ): ?>
        <li>
            <a href="<?php echo $this->createUrl( 'FichePaiement/index' ) ?>">
                <img src="<?php echo Yii::app()->request->baseUrl . "/images/next.png" ?>" />
                <span><?php echo Yii::t( 'scout', 'procederPaiement' ) ?></span>
            </a>
        </li>
    <?php endif ?>
</ul>

<h2><?php echo Yii::t( 'scout', 'enfantsInscrits' ) ?></h2>

<?php if( count( $enfants ) > 0 ): ?>

    <table class="bordered-table reduced">
        <thead>
            <th colspan="2"><?php echo Yii::t( 'scout', 'enfant' ) ?></th>
            <th colspan="2"><?php echo Yii::t( 'scout', 'actions' ) ?></th>
        </thead>
        <tbody>
            <?php foreach( $enfants as $enfant ): ?>
                <tr>
                    <td>
                        <img src="<?php echo Yii::app()->request->baseUrl . "/images/user.png" ?>" />
                    </td>
                    <td>
                        <?php echo $enfant->nomComplet ?>
                    </td>
                    <td>
                        <?php echo CHtml::link( "Fiche d'inscription", array( 'FicheEnfant/edit', 'id' => $enfant->ID_SCOUT ) ) ?>
                    </td>
                    <td>
                        <?php
                            if( $enfant->ficheMedicale != null ) {
                                echo CHtml::link( "Fiche médicale", array( 'FicheMedicale/edit', 'id' => $enfant->ficheMedicale->ID_FICHE_MEDICALE ) );
                            } else {
                                echo CHtml::link( "Créer fiche médicale", array( 'FicheMedicale/new', 'idScout' => $enfant->ID_SCOUT ) );
                            }
                        ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

<?php else: ?>

    <p><?php echo Yii::t( 'scout', 'aucunEnfant' ) ?></p>

<?php endif ?>

