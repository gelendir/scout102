<?php

class ImpressionFicheController extends AdminController
{
	public function filters() {

        return array(
            'cleanup',
            'before',
        );

    }

    public function filterBefore( $filterChain ) {

        $this->afficherEtapes = false;
        $filterChain->run();

    }

	public function actions()
	{
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	
	public function actionIndex()
	{
		$unite = new Unite;
		$uniteChoisie = new Unite();
		$tempsChoisi = null;
		$afficherTbl = true;
		
		$scouts = array();
		
		if(isset($_POST['temps']))
		{
			$tempsChoisi = $_POST['temps'];	
			$scouts = $this->getScoutsTemps($tempsChoisi);
		}
		else if($_POST['Unite']['NOM_UNITE']) 
		{
			$unite = $_POST['Unite']['NOM_UNITE'];
			$uniteChoisie = Unite::model()->find('ID_UNITE = :unite', array(':unite'=>$unite));			
			$idListe = UniteScout::model()->findAll('ID_UNITE = :unite', array(':unite'=>$uniteChoisie->ID_UNITE));
			
			foreach($idListe as $scout)
			{
				$id= $scout->ID_SCOUT;
				$scouts[] = Scout::model()->findByPk($id);
			}
		}
		
		if($_POST['format'] == 0){
			$this->css[] = 'print.css';
			$this->layout = '//layouts/blank';
			$this->render('imprimerGrand', array('scouts'=>$scouts));				
		} else {
			$this->css[] = 'printPetit.css';
			$this->layout = '//layouts/blank';
			$this->render('imprimerPetit', array('scouts'=>$scouts));
		}
	}
	
	public function getScoutsTemps($nbJours)	
	{
		$requete = "SELECT S.ID_SCOUT FROM SCOUT AS S LEFT OUTER JOIN FICHE_MEDICALE AS FM ON FM.ID_SCOUT = S.ID_SCOUT WHERE FM.DATE_MAJ >= :date";
		$ts = time();
		$temps = $nbJours * (24 * 60 * 60);
		$date = $ts - $temps;
		$date = Util::formatDbDate($date);
		
		$command = Yii::app()->db->createCommand($requete);
		$command->bindParam('date', $date, PDO::PARAM_STR);
		$rows = $command->queryAll();
		
		$scouts = array();
		
		foreach($rows as $row) {
			$scouts[] = Scout::model()->findByPk($row['ID_SCOUT']);
		}
		
		return $scouts;
	}	
}
