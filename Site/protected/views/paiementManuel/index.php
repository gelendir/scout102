<h1><?php echo Yii::t( 'paiement', 'paiements' ) ?></h1>

<p>
    <?php echo Yii::t( 'paiement', 'description' ) ?>
</p>

<div>

    <?php

    $requete = "SELECT
                    V.ID_VERSEMENT AS 'Id_versement',
                    CONCAT_WS(' ', S.PRENOM, S.NOM) AS 'Nom_du_scout',
                    GROUP_CONCAT(DISTINCT CONCAT_WS(' ', A.PRENOM, A.NOM) SEPARATOR ', ') AS 'Nom_parents',
                    CONCAT( T.MONTANT, ' $' ) AS 'Montant_versement',
                    T.DATE_VERSEMENT AS 'Date_versement',
                    T.NO_ENFANT AS 'No_enfant',
                    FACT.ID_FACTURE AS 'Id_facture',
                    FACT.MONTANT AS 'Montant_facture',
                    FACT.DATE_FACTURE AS 'Date_facturation',
                    MP.NOM_MODE AS 'Mode_paiement',
                    IF(V.ETAT = 1, 'Payé', 'Non payé') AS 'Etat'
                FROM
                    SCOUT AS S
                        LEFT OUTER JOIN
                            FAMILLE_SCOUT AS FS
                            ON FS.ID_SCOUT = S.ID_SCOUT
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
                                    T_VERSEMENT AS V
                                    ON V.ID_SCOUT = FS.ID_SCOUT AND V.ID_FAMILLE = FS.ID_FAMILLE
                                        LEFT OUTER JOIN
                                            TARIF AS T
                                            ON T.ID_TARIF = V.ID_TARIF
                                                LEFT OUTER JOIN
                                                    VERSEMENT_FACTURE AS VF
                                                    ON VF.ID_VERSEMENT = V.ID_VERSEMENT
                                                        LEFT OUTER JOIN
                                                            FACTURE AS FACT
                                                            ON FACT.ID_FACTURE = VF.ID_FACTURE
                                                                LEFT OUTER JOIN
                                                                    MODE_PAIEMENT AS MP
                                                                    ON MP.ID_MODE_PAIEMENT = FACT.ID_MODE_PAIEMENT
                GROUP BY
                    S.ID_SCOUT,
                    V.ID_VERSEMENT";
                    
    $rows=Yii::app()->db->createCommand($requete)->queryAll();
    $sql=$requete;
    
    $dataProvider=new CSqlDataProvider($sql, 
                    array(  'totalItemCount'=>count($rows),
                            'sort'=>array('attributes'=>array(  'Id_versement',
                                                                'Etat',
                                                                'Nom_du_scout',
                                                                'Nom_parents',
                                                                'Montant_versement',
                                                                'Date_versement',
                                                                'No_enfant',
                                                                'Id_facture',
                                                                'Montant_facture',
                                                                'Date_facturation',
                                                                'Mode_paiement',
                                                                ),
                                        ),
                            'pagination'=>array('pageSize'=>10,),
                            'id' => 'Id_Versement',
                            'keyField' => 'Id_versement',
                        )
                );
    

    
    $this->widget('zii.widgets.grid.CGridView', 
                array(
                        'dataProvider'=>$dataProvider,
                        'cssFile'=>'',
                        'blankDisplay'=>'Impossible de générer la liste, veuillez rafraichir ou réessayer plus tard.',
                        'emptyText'=>'La liste est vide',
                        'nullDisplay'=>'(aucun)',
                        'columns'=>array(
                                        'Id_versement::' . Yii::t( 'paiement', 'noPaiement' ),
                                        'Etat::' . Yii::t( 'paiement', 'etatVersement' ),
                                        'Nom_du_scout::' . Yii::t( 'paiement', 'nomScout' ),
                                        'Nom_parents::' . Yii::t( 'paiement', 'nomParent' ),
                                        'Montant_versement::' . Yii::t( 'paiement', 'montantVersement' ),
                                        'Date_versement::' . Yii::t( 'paiement', 'dateVersement' ),
                                        array(
                                                'class'=>'CLinkColumn',
                                                'header' => Yii::t( 'paiement', 'actions' ),
                                                'labelExpression'=>'"Visualiser"',
                                                'urlExpression'=>'"index.php?r=ajouterPaiement/index&id=".$data["Id_versement"]',
                                            ),
                                        ),
                    )
    
                    
                );
?>




</div>
