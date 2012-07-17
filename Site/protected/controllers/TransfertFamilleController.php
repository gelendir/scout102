<?php

class TransfertFamilleController extends AdminController
{
    public function actionIndex()
    {
        $this->render('index');
    }
    
    public function actionFaireMAJ()
    {
        $idParent1 = $_POST['parent1']; //parent a changer
        $idParent2 = $_POST['parent2'];
        
        $messageSortie='';
        
        //Obtenir le nom des parents
        $requeteNom1 = "SELECT CONCAT_WS(' ', PRENOM, NOM) AS NOM FROM ADULTE WHERE ID_ADULTE=".$idParent1;
        $requeteNom2 = "SELECT CONCAT_WS(' ', PRENOM, NOM) AS NOM FROM ADULTE WHERE ID_ADULTE=".$idParent2;
        
        $nomParent1=Yii::app()->db->createCommand($requeteNom1)->queryScalar(); //nom du parent à changer
        $nomParent2=Yii::app()->db->createCommand($requeteNom2)->queryScalar();

        //Obtenir les id des deux familles
            $reqFamille1="SELECT ID_FAMILLE FROM FAMILLE_ADULTE WHERE ID_ADULTE=".$idParent1; 
            $reqFamille2="SELECT ID_FAMILLE FROM FAMILLE_ADULTE WHERE ID_ADULTE=".$idParent2;
            
            $idFamille1=Yii::app()->db->createCommand($reqFamille1)->queryScalar();//famille a changer
            $idFamille2=Yii::app()->db->createCommand($reqFamille2)->queryScalar();
        
        //Le nombre d'adulte appartenant à la famille à changer       
        $requeteNbAdulte="SELECT COUNT(*) FROM FAMILLE_ADULTE WHERE ID_FAMILLE=".$idFamille1;
        $nbAdulteVielleFamille=Yii::app()->db->createCommand($requeteNbAdulte)->queryScalar();
        
        if($idParent1==$idParent2)
        {
            //Faire erreur, même parent sélectionné.
            $messageSortie= "Vous avez sélectionné la même personne.";
            $typeMessage="erreur";

        }
        else if($idFamille1==$idFamille2)
        {
            //Faire erreur, appartiennent déjà à la même famille.
            $messageSortie= "Ce parent appartiennent déjà à cette famille.";
            $typeMessage="erreur";
        }
        else if($nbAdulteVielleFamille!=1)
        {
            //Faire erreur, plus d'un parent dans cette famille
            $messageSortie= "Un parent ne peut être transféré si un autre parent est dans la même famille";
            $typeMessage="erreur";
        }
        else
        {
        
            //Requetes de mise a jour des id_familles présentes dans la BD
            $deactiverContrainte = "SET foreign_key_checks = 0";
            $reactiverContrainte = "SET foreign_key_checks = 1";
            $updateFamAdu = "UPDATE FAMILLE_ADULTE SET ID_FAMILLE=".$idFamille2." WHERE ID_FAMILLE=".$idFamille1;
            $updateFamSco = "UPDATE FAMILLE_SCOUT SET ID_FAMILLE=".$idFamille2." WHERE ID_FAMILLE=".$idFamille1;
            $updateAdrFam = "UPDATE ADRESSE_FAMILLE SET ID_FAMILLE=".$idFamille2." WHERE ID_FAMILLE=".$idFamille1;
            $updateVer = "UPDATE T_VERSEMENT SET ID_FAMILLE=".$idFamille2." WHERE ID_FAMILLE=".$idFamille1;


            Yii::app()->db->createCommand($deactiverContrainte)->execute();
            Yii::app()->db->createCommand($updateVer)->execute();
            Yii::app()->db->createCommand($updateAdrFam)->execute();
            Yii::app()->db->createCommand($updateFamSco)->execute();
            Yii::app()->db->createCommand($updateFamAdu)->execute();
            Yii::app()->db->createCommand($reactiverContrainte)->execute();
            
            //Suppression de id_famille dans la table famille
            $delFamille="DELETE FROM FAMILLE WHERE ID_FAMILLE=".$idFamille1;
            Yii::app()->db->createCommand($delFamille)->execute();
            
            $messageSortie= "Le parent: ".$nomParent1." (id_famille: ".$idFamille1.") à été transférer dans la 
                    famille de: ".$nomParent2." (id_famille: ".$idFamille2;
            $typeMessage="reussi";
        }
        
        $this->render('index', array('message'=>$messageSortie, 'type'=>$typeMessage));
    
    }

}
