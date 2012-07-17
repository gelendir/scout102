<h1>Générateur de liste</h1>
<form name="input" class="form-stacked" action="index.php?r=generateurListe/generer" method="post">
	

<fieldset>
	<div>
		<p>La liste téléchargée n'est pas formatée automatiquement par Excel. Voici les instructions pour utiliser la macro de mise en forme: </p>
		<br />
		<ol>
			<li>Télécharger la macro de mise en forme (<a href="<?php Yii::app()->request->baseUrl; ?>/ressources/MacroMEFListe.xlsm">cliquez ici</a>).</li>
			<li>Ouvrir le fichier de la macro. Le tableur Excel sera vide. </li>
			<li>Activer les macros du fichier. (Dans Excel 2007 et 2010, cliquer sur le bouton "Options..." dans l'avertissement de sécurité, cliquer sur la bulle: "Activer ce contenu" et cliquer sur le bouton "OK")</li>
			<li>Ouvrir le fichier de la liste.</li>
			<li>Pour Excel 2007 et 2010, cliquer sur l'onglet "Affichage".</li>
			<li>Cliquer ensuite sur "Macros" pour afficher les macros</li>
			<li>Dans la fenêtre de Macro sélectionner la macro portant le nom : "MacroMEFListe.xlsm!mise_en_forme"</li>
			<li>Cliquer sur le bouton "Exécuter" pour lancer la macro.</li>
		</ol>
	</div>
	
	<div class="clearfix">
	
		<p>Sélectionnez quels scouts seront sur cette liste</p>
		
		<div class="input">
			<?php 
				$listeUnite = Unite::model()->findAll();
				$listDataUnite = CHtml::listData($listeUnite,'ID_UNITE', 'NOM_UNITE');
				$listDataUnite['tous'] = '--Tous les scouts';
				$listDataUnite['sans'] = '--Sans unité';
				echo CHtml::activeDropDownList($modelUnite, 'NOM_UNITE', $listDataUnite);
			?>
		</div>
	</div>
	
	<h3>Entête de la liste</h3>
	<p>(Le titre et la description sont facultatif)</p>
	<div class="clearfix">
		
		
		<div class="input">
			<p>Titre de la liste</p>
			<input type="text" name="tBoxTitre" />
		</div>		
	</div>
	
	<div class="clearfix">
		<div class="input">
			<p>Description de la liste</p>
			<input type="text" name="tBoxDesc" /> 
		</div>	
	</div>
	
	<div class="actions well">
		<input type="checkbox" name="chkTout" value="1" /> Tout sélectionner
		<input class="btn primary" type="submit" value="Exporter vers Excel" />
	</div>
</fieldset>	

	
	<div class="sectionRapport">
		<h3>Scout</h3>
		<p>Nom et prénom du scout (obligatoire)</p>
		<input type="checkbox" name="chkScSexe" value="1" /> Sexe <br/>
		<input type="checkbox" name="chkScAge" value="1" /> Âge <br/>
		<input type="checkbox" name="chkScDateNaissance" value="1" /> Date de naissance <br/>
		<input type="checkbox" name="chkScAdresse" value="1" /> Adresse principale <br/>
	</div>
	
	<div class="sectionRapport">
		<h3>Parents</h3>
		<input type="checkbox" name="chkPaNom" value="1" /> Nom et prénom <br/>
		<input type="checkbox" name="chkPaLien" value="1" /> Lien (père ou mère) <br/>
		<input type="checkbox" name="chkPaAdresse" value="1" /> Adresse principale <br/>
		<input type="checkbox" name="chkPaNoTel" value="1" /> Numéro de téléphones <br/>
		<input type="checkbox" name="chkPaCourriel" value="1" /> Courriel <br/>
		<input type="checkbox" name="chkPaEmploi" value="1" /> Emploi <br/>
	</div>
	
	<div class="sectionRapport">
		<h3>Contact en cas d'urgence</h3>
		<input type="checkbox" name="chkCoNom" value="1" /> Nom et prénom <br/>
		<input type="checkbox" name="chkCoLien" value="1" /> Lien <br/>
		<input type="checkbox" name="chkCoNoTel" value="1" /> Numéro de téléphone <br/>
	</div class="sectionRapport">
	
	<div class="sectionRapport">
		<h3>Autorisations</h3>
		<input type="checkbox" name="chkAuAuto" value="1" /> Autorisations <br/>
	</div>
	
	<div class="sectionRapport">
		<h3>Informations médicales</h3>
		<input type="checkbox" name="chkIMAllergie" value="1" /> Allergies <br/>
		<input type="checkbox" name="chkIMNoAssu" value="1" /> Numéro d'assurance maladie <br/>
		<input type="checkbox" name="chkIMDateExp" value="1" /> Date d'expiration de la carte d'assurance maladie <br/>
	</div>
	
	<div class="sectionRapport">
		<h3>Informations scolaires</h3>
		<input type="checkbox" name="chkISNiveau" value="1" /> Niveau scolaire <br/>
		<input type="checkbox" name="chkISNomEns" value="1" /> Nom de l'enseignant <br/>
		<input type="checkbox" name="chkISEcole" value="1" /> Nom de l'école <br/>
	</div>
	
	<div class="sectionRapport">
		<h3>Unité</h3>
		<input type="checkbox" name="chkUnNom" value="1" /> Nom de l'unité <br/>
		<input type="checkbox" name="chkUnAnim" value="1" /> Nom de l'animateur <br/>
	</div>
	
	<div class="sectionRapport">
		<h3>Filtre</h3>
		<input type="checkbox" name="chkFiScoutActif" value="1" /> Afficher seulement les scouts actifs <br/>
		<input type="checkbox" name="chkFiParentActif" value="1" /> Afficher seulement les parents actifs <br/>
	</div>
	
	<div class="actions well">
		<input class="btn primary" type="submit" value="Exporter vers Excel" />
	</div>
	
	<div>
		<p>La liste téléchargée n'est pas formatée automatiquement par Excel. Voici les instructions pour utiliser la macro de mise en forme: </p>
		<br />
		<ol>
			<li>Télécharger la macro de mise en forme (<a href="<?php Yii::app()->request->baseUrl; ?>/ressources/MacroMEFListe.xlsm">cliquez ici</a>).</li>
			<li>Ouvrir le fichier de la macro. Le tableur Excel sera vide. </li>
			<li>Activer les macros du fichier. (Dans Excel 2007 et 2010, cliquer sur le bouton "Options..." dans l'avertissement de sécurité, cliquer sur la bulle: "Activer ce contenu" et cliquer sur le bouton "OK")</li>
			<li>Ouvrir le fichier de la liste.</li>
			<li>Pour Excel 2007 et 2010, cliquer sur l'onglet "Affichage".</li>
			<li>Cliquer ensuite sur "Macros" pour afficher les macros</li>
			<li>Dans la fenêtre de Macro sélectionner la macro portant le nom : "MacroMEFListe.xlsm!mise_en_forme"</li>
			<li>Cliquer sur le bouton "Exécuter" pour lancer la macro.</li>
		</ol>
	</div>
	
	
</form>