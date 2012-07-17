<h1><?php echo Yii::t( 'unite', 'listeUnite' ) ?></h1>

<?php echo CHtml::link( Yii::t( 'unite', 'ajouterUnite' ), array( 'unite/new' ) ) ?>

<?php

    $dataProvider = new CArrayDataProvider( $Unites,
        array(
            'totalItemCount' => count( $Unites ),
            'sort' => array(
                'attributes' => array( 'NOM_UNITE', 'nbScouts', 'annee' )
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
            'id' => 'ID_UNITE',
            'keyField' => 'ID_UNITE'
        )
    );

    $this->widget('zii.widgets.grid.CGridView',
        array(
            'dataProvider' => $dataProvider,
            'cssFile' => '',
            'columns' => array(
                'NOM_UNITE::' . Yii::t( 'unite', 'nomUnite' ),
                'nbScouts::' . Yii::t( 'unite', 'nbScouts' ),
                'annee::' . Yii::t( 'unite', 'annee' ),
                array(
                    'class' => 'CLinkColumn',
                    'header' => Yii::t( 'unite', 'actions' ),
                    'label' => Yii::t( 'unite', 'editer' ),
                    'urlExpression' => 'Yii::app()->createUrl("Unite/edit", array("id"=>$data->ID_UNITE))',
                ),
                array(
                    'class' => 'CLinkColumn',
                    'header' => "",
                    'label' => Yii::t( 'unite', 'archiver' ),
                    'urlExpression' => '"#"',
                ),
            )
        )
    );

?>
