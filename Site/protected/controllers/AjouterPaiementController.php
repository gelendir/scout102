<?php

class AjouterPaiementController extends AdminController
{
    private $requete = "SELECT V.ID_VERSEMENT AS 'Id_versement', CONCAT_WS(' ', S.PRENOM, S.NOM) AS 'Nom_du_scout', GROUP_CONCAT(DISTINCT CONCAT_WS(' ', A.PRENOM, A.NOM) SEPARATOR ', ') AS 'Nom_parents',
                        T.MONTANT AS 'Montant_versement', T.DATE_VERSEMENT AS 'Date_versement', FACT.ID_FACTURE AS 'Id_facture', MP.NOM_MODE AS 'Mode_paiement' FROM SCOUT AS S LEFT OUTER JOIN
                        FAMILLE_SCOUT AS FS ON FS.ID_SCOUT = S.ID_SCOUT LEFT OUTER JOIN FAMILLE AS F ON F.ID_FAMILLE = FS.ID_FAMILLE LEFT OUTER JOIN FAMILLE_ADULTE AS FA ON FA.ID_FAMILLE = F.ID_FAMILLE
                        LEFT OUTER JOIN ADULTE AS A ON A.ID_ADULTE = FA.ID_ADULTE LEFT OUTER JOIN T_VERSEMENT AS V ON V.ID_SCOUT = FS.ID_SCOUT AND V.ID_FAMILLE = FS.ID_FAMILLE LEFT OUTER JOIN
                        TARIF AS T ON T.ID_TARIF = V.ID_TARIF LEFT OUTER JOIN VERSEMENT_FACTURE AS VF ON VF.ID_VERSEMENT = V.ID_VERSEMENT LEFT OUTER JOIN FACTURE AS FACT ON FACT.ID_FACTURE = VF.ID_FACTURE
                        LEFT OUTER JOIN MODE_PAIEMENT AS MP ON MP.ID_MODE_PAIEMENT = FACT.ID_MODE_PAIEMENT WHERE V.ID_VERSEMENT = :id GROUP BY S.ID_SCOUT, V.ID_VERSEMENT" ;

    
    public function actionIndex($id)
    {
        $command = Yii::app()->db->createCommand($this->requete);
        $command->bindParam('id', $id, PDO::PARAM_STR);
        $rows = $command->queryAll();
        $versement = TarifVersement::model()->findByPk($id);
        
        $this->render('index', array('id'=>$id, 'rows'=>$rows, 'versement'=>$versement));
    }
    
    public function actionAjouter()
    {
        $id = $_POST['idVersement'];
        
        $command = Yii::app()->db->createCommand($this->requete);
        $command->bindParam('id', $id, PDO::PARAM_STR);
        $rows = $command->queryAll();
        
        $versement = TarifVersement::model()->findByPk($rows[0]['Id_versement']);
        $modePaiement = $_POST['ID_MODE_PAIEMENT'];
            
        $facture = Facture::avecTarifVersements( array($versement) );
        $facture->ID_MODE_PAIEMENT = $modePaiement;
        $facture->MONTANT = $rows[0]['Montant_versement'];

        Util::saveOrThrow( $facture );

        Yii::app()->user->setFlash( 'success', Yii::t( 'paiement', 'ajoutSucces' ) );
        $this->redirect( array( 'PaiementManuel/index' ) );

        //$this->render('index', array('id'=>$id, 'rows'=>$rows, 'versement'=>$versement));
    }
}

?>
