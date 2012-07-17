<?php 
	foreach($scouts as $scout){
		$NB_PER_ROW = 5;
		$compteur = 0;
		$compteurTexte = 0;
		$ficheMedicale = new FicheMedicale();
		$Scolarite = new Scolarite();		
?>

<?php
	$ficheMedicale = FicheMedicale::model()->find('ID_SCOUT = :id', array(':id'=>$scout->ID_SCOUT));
	$Scolarite = Scolarite::model()->find('ID_SCOUT = :id', array(':id'=>$scout->ID_SCOUT));
?>
<h1>
	Fiche médicale de <?php echo $scout->PRENOM . " " . $scout->NOM; ?>
</h1>

<h2>
	État médical
</h2>

<div class="row">
	<table>
		<?php
			$count = 0;
			$afficher = false;
			$reponseCochees = array();
			
			foreach ($scout->ficheMedicale->getReponsesCases("État médical") as $i => $reponse)
			{
				if($reponse->REPONSE == 1){
					$reponseCochees[] = $reponse;
					$afficher = true;
				}
			}
			
			if($afficher == true)	{
				foreach ($reponseCochees as $i => $reponse)
				{
					if ( $count == 0 ) {
						echo "<tr>";
					}
				?>

				<td>
					<?php echo $reponse->caseACocher->DESCRIPTION; ?>
				</td>

				<?php
					$count++;
					$compteur++;
					if ($count == $NB_PER_ROW)
					{
						echo "</tr>";
						$count = 0;
					}
				}
			} else {
				echo "<p>Aucun état médical particulier</p>";
			}
		?>
	</table>

</div>

<div class="row">
	<?php
		if($ficheMedicale->COMMENTAIRES != null){	
			echo "<p><b>Autre</b></p>";
			echo "<p>" . $ficheMedicale->COMMENTAIRES . "</p>";
		}
	?>
</div>

<div class="row">
<div class="col">
<h2>
	Questions générales
</h2>

<div>
	<?php
		$afficherQ = false;
		$radioButtonCoches1 = array();
		
		foreach ($ficheMedicale->getReponsesCases("Questions générales") as $reponse) {
			if($reponse->REPONSE === "1"){
				$radioButtonCoches1[] = $reponse;
				$afficherQ = true;
			}
		}
	?>
	<?php 
		if($afficherQ == true) { ?>
			<table class="zebra-striped reduced bordered-table">
				<?php
					foreach ($radioButtonCoches1 as $reponse) {
				?>
						<tr>
							<td>
								<?php echo $reponse->caseACocher->DESCRIPTION; ?>
							</td>
						</tr>
				<?php
					$compteur++;
					}
				?>
			</table>
	<?php 
		} else {
			echo "Aucune des réponses n'est à oui.";
		}
	?>
</div>
</div>
<div class="col padding">
<h2>
	Médicaments autorisés (en vente libre)
</h2>
	<?php
		$afficherM = false;
		$radioButtonCoches2 = array();
		
		foreach ($ficheMedicale->getReponsesCases("Médicaments autorisés") as $reponse) {
			if($reponse->REPONSE === "1"){
				$radioButtonCoches2[] = $reponse;
				$afficherM = true;
			}
		}
	?>
	<?php if($afficherM == true){ ?>
			<table class="zebra-striped reduced bordered-table">
				<?php
					foreach ($radioButtonCoches2 as $reponse) {
				?>
						<tr>
							<td>
								<?php echo $reponse->caseACocher->DESCRIPTION; ?>
							</td>
						</tr>
				<?php
					$compteur++;
					}
				?>
			</table>
	<?php } ?>
</div>
</div>

<h2>
	Médicaments sous prescription avec posologie
</h2>

<!-- TODO: find a way to generate all sections -->
<div class="row">

	<?php 
		foreach( $ficheMedicale->getReponseTexte('Médicaments sous posologie') as $reponse ):
			if(isset($reponse->TEXTE)){
				echo "<p>" . $reponse->TEXTE . "</p>";
			} else {
				echo "<p>Aucun médicament sous posologie</p>";
			}
				$compteurTexte++;
		endforeach 
	?>

</div>

<div class="row">
<div class="col">
	<h2>
		Allergies
	</h2>
	<div>
		<?php 
			foreach( $ficheMedicale->getReponseTexte('Peurs et phobies') as $reponse ):
				if(isset($reponse->TEXTE)){
					echo "<p>" . $reponse->TEXTE . "</p>";
				} else {
					echo "<p>Aucune allergie</p>";
				}
					$compteurTexte++;
			endforeach 
		?>
	</div>
</div>

<div class="col padding">
	<h2>
		Peurs et phobies
	</h2>
	<div>
		<?php 
			foreach( $ficheMedicale->getReponseTexte('Médicaments sous posologie') as $reponse ):
				if(isset($reponse->TEXTE)){
					echo "<p>" . $reponse->TEXTE . "</p>";
				} else {
					echo "<p>Aucun médicament sous posologie</p>";
				}
					$compteurTexte++;
			endforeach 
		?>
	</div>
</div>
</div>
	
<div class="row">
<h2>Informations scolaires</h2>
	<div class="col">
		<span class="description">
			Nom de l'école
		</span>

		<div class="field">
			<?php echo $Scolarite->NOM_ECOLE ?>
		</div>

	</div>

	<div class="col padding">
		<span class="description">
			Niveau scolaire
		</span>

		<div class="field">

			<?php echo $Scolarite->niveauScolaire->DESCRIPTION_NIVEAU;?>
		</div>

	</div>

	<div class="col padding">
		<span class="description">
			Nom de l'enseignant
		</span>

		<div class="field">
			<?php echo $Scolarite->NOM_ENSEIGNANT;?>
		</div>
	</div>
</div>

<div class="row">
<div class="col">
	<h2>
		Autres conditions médicale ou particularité
	</h2>
	<div>
		<?php 
			foreach( $ficheMedicale->getReponseTexte('Autres conditions médicales ou particularités') as $reponse ):
				if(isset($reponse->TEXTE)){
					echo "<p>" . $reponse->TEXTE . "</p>";
				} else {
					echo "<p>Aucun médicament sous posologie</p>";
				}
					$compteurTexte++;
			endforeach 
		?>
	</div>
</div>

<div class="col padding">
	<h2>
		Autres activités
	</h2>
	<div class="row">
		<?php 
			foreach( $ficheMedicale->getReponseTexte('Autres activités') as $reponse ):
				if(isset($reponse->TEXTE)){
					echo "<p>" . $reponse->TEXTE . "</p>";
				} else {
					echo "<p>Aucun médicament sous posologie</p>";
				}
					$compteurTexte++;
			endforeach 
		?>
	</div>
</div>
</div>
<hr/>
<div class="page-break"> </div>
<?php } ?>

<script language="JavaScript"> 
if (window.print) {
	document.write('<form><input type=button name="imprimer" class="btn primary" value="Imprimer" onClick="window.print()"></form>');
}
</script>
