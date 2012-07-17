<?php

class GenerateurListeController extends Controller
{
	public function actionIndex()
	{
		$modelUnite = new Unite;
		$this->render('index', array('modelUnite'=>$modelUnite));
	}
	
	public function actionGenerer()
	{
		
		$idUniteSel = $_POST['Unite']['NOM_UNITE'];
		$titreListe = $_POST['tBoxTitre'];
		$descriptionListe = $_POST['tBoxDesc'];
		
		$chkScSexe = False;
		$chkScAge = False;
		$chkScDateNaissance = False;
		$chkScAdresse = False;
		$chkPaNom = False;
		$chkPaLien = False;
		$chkPaAdresse = False;
		$chkPaNoTel = False;
		$chkPaCourriel = False;
		$chkPaEmploi = False;
		$chkCoNom = False;
		$chkCoLien = False;
		$chkCoNoTel = False;
		$chkAuAuto = False;
		$chkIMAllergie = False;
		$chkIMNoAssu = False;
		$chkIMDateExp = False;
		$chkISNiveau = False;
		$chkISNomEns = False;
		$chkISEcole = False;
		$chkUnNom = False;
		$chkUnAnim = False;
		$chkFiScoutActif = False;
		$chkFiParentActif = False;
		
		
		
		
		//Scout
		//toujours afficher le nom du scout
			
		if(isset($_POST['chkScSexe'])){$chkScSexe = True;}
		if(isset($_POST['chkScAge'])){$chkScAge = True;}
		if(isset($_POST['chkScDateNaissance'])){$chkScDateNaissance = True;}
		if(isset($_POST['chkScAdresse'])){$chkScAdresse = True;}
		
		//Parents
		if(isset($_POST['chkPaNom'])){$chkPaNom = True;}
		if(isset($_POST['chkPaLien'])){$chkPaLien = True;}
		if(isset($_POST['chkPaAdresse'])){$chkPaAdresse = True;}
		if(isset($_POST['chkPaNoTel'])){$chkPaNoTel = True;}
		if(isset($_POST['chkPaCourriel'])){$chkPaCourriel = True;}
		if(isset($_POST['chkPaEmploi'])){$chkPaEmploi = True;}
		
		//Contacts urgence
		if(isset($_POST['chkCoNom'])){$chkCoNom = True;}
		if(isset($_POST['chkCoLien'])){$chkCoLien = True;}
		if(isset($_POST['chkCoNoTel'])){$chkCoNoTel = True;}
		
		//Autorisation
		if(isset($_POST['chkAuAuto'])){$chkAuAuto = True;}
		
		//Informations médicales
		if(isset($_POST['chkIMAllergie'])){$chkIMAllergie = True;}
		if(isset($_POST['chkIMNoAssu'])){$chkIMNoAssu = True;}
		if(isset($_POST['chkIMDateExp'])){$chkIMDateExp = True;}
		
		//Informations scolaires
		if(isset($_POST['chkISNiveau'])){$chkISNiveau = True;}
		if(isset($_POST['chkISNomEns'])){$chkISNomEns = True;}
		if(isset($_POST['chkISEcole'])){$chkISEcole = True;}
		
		//Unité
		if(isset($_POST['chkUnNom'])){$chkUnNom = True;}
		if(isset($_POST['chkUnAnim'])){$chkUnAnim = True;}
		
		//Filtre
		if(isset($_POST['chkFiScoutActif'])){$chkFiScoutActif = True;}
		if(isset($_POST['chkFiParentActif'])){$chkFiParentActif = True;}
		
		//----------------------------------------------------
		
		$rDebutSelect = " , GROUP_CONCAT(DISTINCT CONCAT_WS(';' ";
		$rFinSelect = " ) SEPARATOR '*')";
		
		// Requete master
		$rSelect = "SELECT
						S.NOM AS 'Nom',
						S.PRENOM AS 'Prenom'";
	
		//Partie de requete pour chaque sélection
		//Scout
		$rScoutSexe = " S.SEXE AS 'Sexe'";
		$rScoutAge = " DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(S.DATE_NAISSANCE, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(S.DATE_NAISSANCE, '00-%m-%d')) AS 'Âge'";
		$rScoutDateNais = " S.DATE_NAISSANCE AS 'Date de naissance'";
		$rScoutAdresse = " CONCAT_WS(' ', ADRE.ADRESSE_RUE, ADRE.VILLE, ADRE.PROVINCE, ADRE.CODE_POSTAL) AS 'Adresse'";
		
		//Parents
		$rParentNom = " CONCAT_WS(' ', ADU_FAM.PRENOM, ADU_FAM.NOM)";
		$rParentSexe = " ADU_FAM.SEXE";
		$rParentAdr = " CONCAT_WS(' ', ADR_ADU.ADRESSE_RUE, ADR_ADU.VILLE, ADR_ADU.PROVINCE, ADR_ADU.CODE_POSTAL)";
		$rParentNoTel = " CONCAT_WS(' ', ADU_FAM.NO_TEL_PRINCIPAL, ADU_FAM.NO_TEL_SECONDAIRE, ADU_FAM.NO_TEL_AUTRE)";
		$rParentCourr = " ADU_FAM.COURRIEL";
		$rParentEmploi = " ADU_FAM.EMPLOI";
		$rParentFin = " AS 'INFO_PARENT'";
		
		//Contacte urgence
		$rUrgNom = " CONCAT_WS(' ', S.CONT_URG_PRENOM, S.CONT_URG_NOM) AS 'Nom contact urgence'";
		$rUrgLien = " S.CONT_URG_LIEN_JEUNE as 'Lien du contact'";
		$rUrgNoTel = " S.CONT_URG_NO_TEL as 'Numéro du contact";
		
		//Autorisation
		
		$rAutoTitre = " CONCAT(TAUT.TITRE, ':', (IF AUT.ACCEPTATION = 0 THEN 'NON' ELSE 'OUI')) AS 'Autorisation'";
		
		//Information médicale
		$rInfMedAller = " TFC.TEXTE AS 'Allergies'";
		$rInfMedCarte = " S.NO_ASSURANCE_MALADIE AS 'No assurance maladie'";
		$rInfDatCarte = " S.DATE_FIN_CARTE_MEDICAL AS 'Date d'expiration'";
		
		//Information scolaire
		$rInfScoNiv = " NIV_SCO.DESCRIPTION_NIVEAU AS 'Niveau scolaire'";
		$rInfScoPro = " SCO.NOM_ENSEIGNANT AS 'Nom enseignant'";
		$rInfScoEco = " SCO.NOM_ECOLE AS 'Nom école'";
		
		//Unite
		$rUniNom = " U.NOM_UNITE AS 'Nom unité'";
		$rUniAni = " CONCAT_WS(' ', ADU_ANI.PRENOM, ADU_ANI.NOM) AS 'Nom animateur'";
		
		
		//Partie de requete pour les join
		$rJoin = " FROM SCOUT AS S ";
		
		//Adresse
		$rFAdresse = " LEFT OUTER JOIN 
							ADRESSE AS ADRE
							ON S.ID_ADRESSE_PRINC = ADRE.ID_ADRESSE ";
		
		//Unite
		$rFUnit = " LEFT OUTER JOIN
						UNITE_SCOUT AS US
						ON US.ID_SCOUT = S.ID_SCOUT
							LEFT OUTER JOIN
								UNITE AS U
								ON U.ID_UNITE = US.ID_UNITE
									LEFT OUTER JOIN
										ANIMATEUR_UNITE AS ANI_UNI
										ON ANI_UNI.ID_UNITE = U.ID_UNITE
											LEFT OUTER JOIN
												ADULTE AS ADU_ANI
												ON ADU_ANI.ID_ADULTE = ANI_UNI.ID_ADULTE ";
		
		//Information scolaire
		$rFSco = " LEFT OUTER JOIN
						SCOLARITE AS SCO
						ON SCO.ID_SCOUT = S.ID_SCOUT
							LEFT OUTER JOIN 
								NIVEAU_SCOLAIRE AS NIV_SCO
								ON NIV_SCO.ID_NIVEAU_SCOLAIRE = SCO.ID_NIVEAU ";
		
		$requeteIdAllergie = "SELECT ID_CAT_CHAMP_TEXTE FROM CATEGORIE_CHAMP_TEXTE WHERE TITRE = 'Allergies'";
		//exécuter la requete et placer le id dans la variable $id_cat_allergie
		$id_cat_allergie = Yii::app()->db->createCommand($requeteIdAllergie)->queryScalar();
		
		
		//Information médicale pour les allergies
		$rFAllergie = " LEFT OUTER JOIN
							FICHE_MEDICALE AS FICH_MED
							ON FICH_MED.ID_SCOUT = S.ID_SCOUT
								LEFT OUTER JOIN 
									TEXTE_FICHE_CHAMP AS TFC
									ON TFC.ID_FICHE_MEDICALE = FICH_MED.ID_FICHE_MEDICALE
										LEFT OUTER JOIN
											CATEGORIE_CHAMP_TEXTE AS CCT
											ON CCT.ID_CAT_CHAMP_TEXTE = TFC.ID_CAT_CHAMP_TEXTE AND
											CCT.ID_CAT_CHAMP_TEXTE = ".$id_cat_allergie;
				
		//Autorisation
		$rFAuto = " LEFT OUTER JOIN
						AUTORISATION AS AUT
						ON AUT.ID_SCOUT = S.ID_SCOUT
							LEFT OUTER JOIN
								TYPE_AUTORISATION AS TAUT
								ON TAUT.ID_TYPE_AUTO = AUT.ID_TYPE_AUTO ";  
		
		//Parents
		$rFParent = " LEFT OUTER JOIN
						FAMILLE_SCOUT AS FAM_SCO
						ON FAM_SCO.ID_SCOUT = S.ID_SCOUT
							LEFT OUTER JOIN
								FAMILLE AS FAM
								ON FAM.ID_FAMILLE = FAM_SCO.ID_FAMILLE
									LEFT OUTER JOIN
										FAMILLE_ADULTE AS FAM_ADU
										ON FAM_ADU.ID_FAMILLE = FAM.ID_FAMILLE
											LEFT OUTER JOIN
												ADULTE AS ADU_FAM
												ON ADU_FAM.ID_ADULTE = FAM_ADU.ID_ADULTE
													LEFT OUTER JOIN
														ADRESSE AS ADR_ADU
														ON ADR_ADU.ID_ADRESSE = ADU_FAM.ID_ADRESSE_PRINC ";
				
		
		//Partie du where (filtre)
		$requeteWHERE = " WHERE ";
		
		//Conditions scout actif
		$rWActif = " S.ACTIF = 1 ";
		//Conditions parent actif
		$rWParentAct = " ADU_FAM.COMPTE_ACTIF = 1 ";
		//Condition unite sélectionné
		if ($idUniteSel != "tous" || $idUniteSel != "sans")
		{
			$rWUnite = " U.ID_UNITE = ".$idUniteSel;
		}
		
		//Group by
		$rGroupBy = " GROUP BY S.ID_SCOUT";
		
		//-----------------------------------------------------------------------------------
		//Faire la série de if pour construire la requete
		//-----------------------------------------------------------------------------------
		
		$jAdresse = False;
		$jParent = False;
		$jAuto = False;
		$jInfMed = False;
		$jInfSco = False;
		$jUnite = False;
		
		
		$requeteFinale = $rSelect;
		
		//Scout
		
		if($chkScSexe == True)
		{
			$requeteFinale.=', ';
			$requeteFinale.=$rScoutSexe;
		}
		if($chkScAge == True)
		{
			$requeteFinale.=', ';
			$requeteFinale.=$rScoutAge;
		}
		if($chkScDateNaissance == True)
		{
			$requeteFinale.=', '; 
			$requeteFinale.=$rScoutDateNais; 
		}
		if($chkScAdresse == True)
		{
			$requeteFinale.=', ';
			$requeteFinale.=$rScoutAdresse;
			
			$jAdresse = True;
		}
		$requeteFinale.=$rFinSelect;
		$requeteFinale.=$rScoutFin;
		
		//Parents
		if($chkPaNom == True || $chkPaLien == True || $chkPaAdresse == True || $chkPaNoTel == True || $chkPaCourriel == True || $chkPaEmploi == True)
		{
			$jParent = True;
			
			$requeteFinale.=$rDebutSelect;
			
			if($chkPaNom == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rParentNom;
			}
			if($chkPaLien == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rParentSexe;
			}
			if($chkPaAdresse == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rParentAdr;
			}
			if($chkPaNoTel == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rParentNoTel;
			}
			if($chkPaCourriel == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rParentCourr;
			}
			if($chkPaEmploi == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rParentEmploi;
			}
			
			$requeteFinale.=$rFinSelect;
			$requeteFinale.=$rParentFin;
		}
		

		//Contacts urgence
		if ($chkCoNom == True || $chkCoLien == True || $chkCoNoTel == True)
		{
			$requeteFinale.=$rDebutSelect;
		
			if($chkCoNom == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rUrgNom;
			}
			if($chkCoLien == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rUrgLien;
			}
			if($chkCoNoTel == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rUrgNoTel;
			}
		
			$requeteFinale.=$rFinSelect;
			$requeteFinale.=$rUrgFin;
		}
		
		//Autorisation
		if($chkAuAuto == True)
		{	
			$jAuto = True;
			
			$requeteFinale.=$rDebutSelect;
			$requeteFinale.=', ';			
			$requeteFinale.=$rAutoValeur;
			$requeteFinale.=', ';			
			$requeteFinale.=$rAutoTitre; 
			$requeteFinale.=$rFinSelect; 
			$requeteFinale.=$rAutoFin;
		}
		
		//Informations médicales
		if($chkIMAllergie == True || $chkIMNoAssu == True || $chkIMDateExp == True)
		{
			$requeteFinale.=$rDebutSelect;
			
			if($chkIMAllergie == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rInfMedAller;
				$jInfMed = True;
			}
			if($chkIMNoAssu == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rInfMedCarte;
			}
			if($chkIMDateExp == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rInfDatCarte;
			}
			
			$requeteFinale.=$rFinSelect; 
			$requeteFinale.=$rInfMedFin;
		}
		
		//Informations scolaires
		if($chkISNiveau == True || $chkISNomEns == True || $chkISEcole == True)
		{
			$jInfSco = True;
			
			$requeteFinale.=$rDebutSelect;
		
			if($chkISNiveau == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rInfScoNiv;
			}
			if($chkISNomEns == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rInfScoPro;
			}
			if($chkISEcole == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rInfScoEco;
			}
		
			$requeteFinale.=$rFinSelect; 
			$requeteFinale.=$rInfScoFin;
		}
		//Unité
		if($chkUnNom == True || $chkUnAnim == True)
		{
			$jUnite = True;
			
			$requeteFinale.=$rDebutSelect;
			
			if($chkUnNom == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rUniNom;
			}
			if($chkUnAnim == True)
			{
				$requeteFinale.=', ';
				$requeteFinale.=$rUniAni;
			}
			
			$requeteFinale.=$rFinSelect; 
			$requeteFinale.=$rUniFin;
		}
		
		//JOIN
		
	
		$requeteFinale.=$rJoin;
		
		//Adresse
		if($jAdresse==True)
		{
			$requeteFinale.=$rFAdresse;
		}
		
		//Unite
		if($jUnite==True || $idUniteSel != "tous" || $idUniteSel != "sans")
		{
			$requeteFinale.=$rFUnit;
		}
		
		//Information scolaire
		if($jInfSco==True)
		{
			$requeteFinale.=$rFSco;
		}
		
		//Information médicale pour les allergies
		if($jInfMed==True)
		{
			$requeteFinale.=$rFAllergie;
		}
				
		//Autorisation
		if($jAuto==True)
		{
			$requeteFinale.=$rFAuto;  
		}
		
		//Parents
		if($jParent==True)
		{
			$requeteFinale.=$rFParent;
		}
				
		
		//Partie du where (filtre)
		if($chkFiScoutActif==True || $chkFiParentActif == True)
		{
			$requeteFinale.=$requeteWHERE;
			
			//Condition unite sélectionné
			if ($idUniteSel != "tous" || $idUniteSel != "sans")
			{
				$requeteFinale.=$rWUnite;
				
				if($chkFiScoutActif==True || $chkFiParentActif == True)
				{
					$requeteFinale.=" AND ";
				}
			}
			
			//Conditions scout actif
			if($chkFiScoutActif==True)
			{
				$requeteFinale.=$rWActif;
				
				if($chkFiParentActif == True)
				{
					$requeteFinale.=" AND ";
				}
			}
			
			//Conditions parent actif
			if($chkFiParentActif == True)
			{
				$requeteFinale.=$rWParentAct;
			}
			
			
		}
		
		//Partie du group by
		$requeteFinale.=$rGroupBy;
		
		
		print_r($requeteFinale);
		die();
		
		
		//-------------------------------------------------------------------
		//
		// Générer le Excel
		//
		//-------------------------------------------------------------------
		
		$data=Yii::app()->db->createCommand($requeteFinale)->queryAll();

		header("Content-Type: text/plain");
		$flag = false;
		
		function cleanData(&$str)
		{
			$str = preg_replace("/\t/", "\\t", $str);
			$str = preg_replace("/\r?\n/", "\\n", $str);
			if(strstr($str,'"')) $str = '"'.str_replace('"','""', $str) . '"';
		}
		
		$filename = "liste_" . date('Ymd') . ".xls";
		
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel");
		
		foreach($data as $row)
		{
			if(!$flag)
			{
				//display field/column names as first row
				echo implode("\t", array_keys($row)) . "\r\n";
				$flag = true;
			}
			array_walk($row, 'cleanData');
			foreach( $row as &$value ) {
				if( $value === null ) {
					$value = "";
				}
			}
			echo implode("\t", array_values($row)) . "\r\n";
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	}
	public function actionGenereListe()
	{
		
		
		
		
		
		
		/*
		$individusSelectionne = $_POST['selecteurIndividus'];
		$filtreScout = $_POST['chkFiltreScout'];
		$filtreUnite = $_POST['chkFiltreUnite'];
		$anneeSelecitonne = $_POST['listeAnnee'];
		

		if($individusSelectionne=='tous')
		{
			$condition = '';
		}
		else if($individusSelectionne=='pasUnite')
		{
		}
		else if(is_numeric($individusSelectionne))
		{
		}
		$requete = 'SELECT 
						S.NOM, 
						S.PRENOM
					FROM 
						SCOUT AS S 
						JOIN UNITE_SCOUT AS US
						ON US.ID_SCOUT = S.ID_SCOUT
							JOIN UNITE AS U
							ON US.ID_UNITE = U.ID_UNITE
					WHERE
						'.$condition.'
					ORDER BY
						S.NOM,
						S.PRENOM';
		
		*/
		
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}