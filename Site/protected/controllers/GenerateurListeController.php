<?php

class GenerateurListeController extends AdminController
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
		
		
		
		if(isset($_POST['chkTout']))
		{
			$chkScSexe = True;
			$chkScAge = True;
			$chkScDateNaissance = True;
			$chkScAdresse = True;
			$chkPaNom = True;
			$chkPaLien = True;
			$chkPaAdresse = True;
			$chkPaNoTel = True;
			$chkPaCourriel = True;
			$chkPaEmploi = True;
			$chkCoNom = True;
			$chkCoLien = True;
			$chkCoNoTel = True;
			$chkAuAuto = True;
			$chkIMAllergie = True;
			$chkIMNoAssu = True;
			$chkIMDateExp = True;
			$chkISNiveau = True;
			$chkISNomEns = True;
			$chkISEcole = True;
			$chkUnNom = True;
			$chkUnAnim = True;
			$chkFiScoutActif = True;
			$chkFiParentActif = True;
		}
		else
		{
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
		}
		//----------------------------------------------------
		
		$rDebutSelect = " , GROUP_CONCAT(DISTINCT CONCAT_WS('*' ";
		$rFinSelect = " ) SEPARATOR '***')";
		
		// Requete master
		$rSelect = "SELECT
						S.NOM AS 'Nom',
						S.PRENOM AS 'Prénom'";
	
		//Partie de requete pour chaque sélection
		//Scout
		$rScoutSexe = " S.SEXE AS 'Sexe'";
		$rScoutAge = " DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(S.DATE_NAISSANCE, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(S.DATE_NAISSANCE, '00-%m-%d')) AS 'Âge'";
		$rScoutDateNais = " S.DATE_NAISSANCE AS 'Date de naissance'";
		$rScoutAdresse = " CONCAT_WS(' ', ADRE.ADRESSE_RUE, ADRE.VILLE, ADRE.PROVINCE, ADRE.CODE_POSTAL) AS 'Adresse du scout'";
		
		//Parents
		$rParentNom = " CONCAT_WS(' ', ADU_FAM.PRENOM, ADU_FAM.NOM)";
		$rParentSexe = " ADU_FAM.SEXE";
		$rParentAdr = " CONCAT_WS(' ', ADR_ADU.ADRESSE_RUE, ADR_ADU.VILLE, ADR_ADU.PROVINCE, ADR_ADU.CODE_POSTAL)";
		$rParentNoTel = " CONCAT_WS(' ', ADU_FAM.NO_TEL_PRINCIPAL, ADU_FAM.NO_TEL_SECONDAIRE, ADU_FAM.NO_TEL_AUTRE)";
		$rParentCourr = " ADU_FAM.COURRIEL";
		$rParentEmploi = " ADU_FAM.EMPLOI";
		$rParentFin = " AS 'Information du/des parents'";
		
		//Contacte urgence
		$rUrgNom = " CONCAT_WS(' ', S.CONT_URG_PRENOM, S.CONT_URG_NOM) AS 'Nom du contact en cas d''urgence'";
		$rUrgLien = " S.CONT_URG_LIEN_JEUNE as 'Lien avec le contact'";
		$rUrgNoTel = " S.CONT_URG_NO_TEL as 'Numéro du contact'";
		
		//Autorisation
		
		$rAuto = " GROUP_CONCAT(DISTINCT CONCAT_WS('-', TAUT.TITRE, IF(AUT.ACCEPTATION = 0, 'OUI', 'NON')) SEPARATOR '***') AS 'Autorisation'";
		
		//Information médicale
		$rInfMedAller = " TFC.TEXTE AS 'Allergies'";
		$rInfMedCarte = " S.NO_ASSURANCE_MALADIE AS 'No assurance maladie'";
		$rInfDatCarte = " S.DATE_FIN_CARTE_MEDICAL AS 'Date d''expiration'";
		
		//Information scolaire
		$rInfScoNiv = " NIV_SCO.DESCRIPTION_NIVEAU AS 'Niveau scolaire'";
		$rInfScoPro = " SCO.NOM_ENSEIGNANT AS 'Nom enseignant'";
		$rInfScoEco = " SCO.NOM_ECOLE AS 'Nom école'";
		
		//Unite
		$rUniNom = " U.NOM_UNITE AS 'Nom unite'";
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
		
		}
		
		//Autorisation
		if($chkAuAuto == True)
		{	
			$jAuto = True;
			
			$requeteFinale.=', ';			
			$requeteFinale.=$rAuto;
		}
		
		//Informations médicales
		if($chkIMAllergie == True || $chkIMNoAssu == True || $chkIMDateExp == True)
		{
			
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
		}
		
		//Informations scolaires
		if($chkISNiveau == True || $chkISNomEns == True || $chkISEcole == True)
		{
			$jInfSco = True;
		
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
		
		}
		//Unité
		if($chkUnNom == True || $chkUnAnim == True)
		{
			$jUnite = True;
			
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
			if ($idUniteSel != "tous" && $idUniteSel != "sans")
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
	
		
		//-------------------------------------------------------------------
		//
		// Générer le Excel
		//
		//-------------------------------------------------------------------
			
		$data=Yii::app()->db->createCommand($requeteFinale)->queryAll();
		
		$dataProvider=new CSqlDataProvider($requeteFinale);
		
		$arrayData = $dataProvider->getData();;
		$filename = "liste_" . date('Ymd') . ".csv";
		//$filename = "liste_" . date('Ymd') . ".xls";
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: text/csv");
		//header("Content-Type: application/vnd.ms-excel");
		
		$handle = fopen("php://output","w");		

		fputcsv($handle, array("0"=>$titreListe));
		fputcsv($handle, array("0"=>'Description : ',"1"=>$descriptionListe));
		fputcsv($handle, array("0"=>'Liste généré le : ',"1"=>date('j/m/Y à H:i:s')));
		
		if($idUniteSel == 'tous' || $idUniteSel == 'sans')
		{
			fputcsv($handle, array("0"=>'Liste générée pour : ', "1"=>'Tous les scouts'));
		}
		else
		{
			$listeUnite = Unite::model()->findByPk($idUniteSel);
			
			fputcsv($handle, array("0"=>"Liste générée pour l'unité: ","1"=>$listeUnite['NOM_UNITE']));
		}
		
		
		foreach(array_keys($arrayData[0]) as $cle=>$valeur)
		{
			$nomColonnes[]=$valeur;
		}
	
		fputcsv($handle, $nomColonnes);
		
		foreach($arrayData as $scout)
		{
			fputcsv($handle, $scout);
		}
		
		fclose($handle);
		
	}
	public function actionGenereListe()
	{
		
	}
}
