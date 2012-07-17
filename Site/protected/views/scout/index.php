<h1> <?php echo Yii::t( 'scout', 'listeScout' ) ?> </h1>

<?php echo CHtml::link( Yii::t( 'scout', 'creerScout' ), $this->createUrl( "Scout/new" ) ) ?>

<?php
    
$requete = "
SELECT 
    S.ID_SCOUT AS ID,
    S.PRENOM AS PRENOM,
    S.NOM AS NOM,
    GROUP_CONCAT(DISTINCT CONCAT_WS(' ', A.PRENOM, A.NOM) SEPARATOR ', ') AS PARENTS,
    COALESCE(U.NOM_UNITE, 'AUCUNE') AS UNITES
FROM SCOUT AS S
    LEFT OUTER JOIN
        FAMILLE_SCOUT AS FS
        ON S.ID_SCOUT = FS.ID_SCOUT
            LEFT OUTER JOIN
                FAMILLE AS F
                ON F.ID_FAMILLE = FS.ID_FAMILLE
                    LEFT OUTER JOIN
                        FAMILLE_ADULTE AS FA
                        ON FA.ID_FAMILLE = F.ID_FAMILLE
                            LEFT OUTER JOIN
                                ADULTE AS A
                                ON A.ID_ADULTE = FA.ID_ADULTE
    LEFT OUTER JOIN
        UNITE_SCOUT AS US
        ON US.ID_SCOUT = S.ID_SCOUT
            LEFT OUTER JOIN
                UNITE AS U
                ON U.ID_UNITE = US.ID_UNITE
GROUP BY
    S.ID_SCOUT
";

?>

<?php

    $rows=Yii::app()->db->createCommand($requete)->queryAll();
    $sql=$requete;

    $dataProvider=new CSqlDataProvider($sql, array(
    'totalItemCount'=>count($rows),
    'sort'=>array('attributes'=>array('PRENOM', 'NOM', 'UNITES',),),
    'pagination'=>array('pageSize'=>10,),
    'id' => 'ID',
    'keyField' => 'ID',
    ));

    $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'cssFile'=>'',
    'blankDisplay' => Yii::t( 'scout', 'rienListe' ),
    'emptyText'=> Yii::t( 'scout', 'listeVide' ),
    'nullDisplay' => Yii::t( 'scout', 'aucun' ),
    'columns'=>array(
        'PRENOM::' . Yii::t( 'scout', 'prenom' ),
        'NOM::' . Yii::t( 'scout', 'nom' ),
        'PARENTS::' . Yii::t( 'scout', 'parents' ),
        'UNITES::' . Yii::t( 'scout', 'unite' ),
        array(
            'class'=>'CLinkColumn',
            'header' => Yii::t( 'scout', 'actions' ),
            'label'  => Yii::t( 'scout', 'modifierScout' ),
            'urlExpression'=>'Yii::app()->createUrl("Scout/edit", array("id" => $data["ID"]))',
        ),
    ),
    
));
?>
