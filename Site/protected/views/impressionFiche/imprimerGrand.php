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
<div>
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
			
			foreach ($scout->ficheMedicale->getReponsesCases("État médical") as $i => $reponse)
			{
				if($reponse->REPONSE == 1){
					$afficher = true;
				}
			}
			
			if($afficher == true)	{
				foreach ($scout->ficheMedicale->getReponsesCases("État médical") as $i => $reponse)
				{
					if ( $count == 0 ) {
						echo "<tr>";
					}
				?>

				<td>
					<?php $option = array('value'=>1);
					if($reponse->REPONSE == 1){
						$option['checked'] = true;
					} 
					echo CHtml::activeCheckbox($reponse, "REPONSE[$compteur]", $option);?>
				</td>

				<td>
					<?php echo $reponse->caseACocher->DESCRIPTION;
					?>
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
	<table>
		<thead>
			<th>
				Question
			</th>
			<th>
				Oui
			</th>
			<th>
				Non
			</th>
		</thead>
		<?php
			foreach ($ficheMedicale->getReponsesCases("Questions générales") as $reponse) {

		?>
			<tr>
				<td>
					<?php echo $reponse->caseACocher->DESCRIPTION; 
					?>
				</td>
				<td>
				
					<?php  
						$options = array('uncheckValue' => null, 'value' => 1);
						if( $reponse->REPONSE === "1" ) {
							$options['checked'] = true;
						}
						?>
						<input type="radio" value="1" name="ReponseCase[REPONSE][<?php echo $compteur ?>][<?php echo $scout->ID_SCOUT ?>]" <?php if( $reponse->REPONSE === "1" ) { echo 'checked="checked"'; } ?> />
						
				</td>
				<td>
					<?php
						$options = array('uncheckValue' => null, 'value' => 0);
						if( $reponse->REPONSE === "0" ) {
							$options['checked'] = true;
						}
					?>
					<input type="radio" value="0" name="ReponseCase[REPONSE][<?php echo $compteur ?>][<?php echo $scout->ID_SCOUT ?>]" <?php if( $reponse->REPONSE === "0" ) { echo 'checked="checked"'; } ?> />
						
				</td>
			</tr>
		<?php
			$compteur++;
			}
		?>
	</table>
</div>

<div class="col padding">
	<h2>
		Médicaments autorisés
	</h2>
	<table>
		<thead>
			<th>
				Médicament
			</th>
			<th>
				Oui
			</th>
			<th>
				Non
			</th>
		</thead>
		<?php
			foreach ($ficheMedicale->getReponsesCases("Médicaments autorisés") as $reponse) {
	  
		?>
				<tr>
					<td>
						<?php echo $reponse->caseACocher->DESCRIPTION; 
						?>
					</td>
					<td>
					
						<?php  
							$options = array('uncheckValue' => null, 'value' => 1);
							if( $reponse->REPONSE === "1" ) {
								$options['checked'] = true;
							}
							?>
							<input type="radio" value="1" name="ReponseCase[REPONSE][<?php echo $compteur ?>][<?php echo $scout->ID_SCOUT ?>]" <?php if( $reponse->REPONSE === "1" ) { echo 'checked="checked"'; } ?> />
					</td>
					<td>
						<?php
							$options = array('uncheckValue' => null, 'value' => 0);
							if( $reponse->REPONSE === "0" ) {
								$options['checked'] = true;
							}
						?>
						<input type="radio" value="0" name="ReponseCase[REPONSE][<?php echo $compteur ?>][<?php echo $scout->ID_SCOUT ?>]" <?php if( $reponse->REPONSE === "0" ) { echo 'checked="checked"'; } ?> />
							
					</td>
				</tr>
		<?php
			$compteur++;
			}
		?>
	</table>
</div>
</div>

<div class="row">
<div class="col">
	<h2>
		Médicaments sous prescription avec posologie
	</h2>
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

<div class="row">
<div class="col">
	<h2>
		Allergies
	</h2>
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

<div class="col padding">
<h2>
	Peurs et phobies
</h2>
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

<div class="row">
<div class="col">
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
	<div>
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
</div>
<div class="page-break"> </div>
<hr/>
<?php } ?>

<script language="JavaScript"> 
if (window.print) {
	document.write('<form><input type=button name="imprimer" class="btn primary" value="Imprimer" onClick="window.print()"></form>');
}
</script>
