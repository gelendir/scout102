<form action="/?r=impressionFiche/index" method="POST">

<h1>Génération des fiches médicales</h1>

<p>Vous pouvez choisir une unité pour imprimer toutes les fiches des scouts de celle-ci</p>
<div id="params">
	<?php 
		$listeUnite = Unite::model()->findAll();
		$listDataUnite = CHtml::listData($listeUnite,'ID_UNITE', 'NOM_UNITE');
		array_unshift($listDataUnite, "");
		$id = "unites";
		echo CHtml::activeDropDownList($unite , 'NOM_UNITE', $listDataUnite, array('id'=>$id));
	?>

	<p style="padding-top: 5px;">Vous pouvez choisir les scouts qui ont eu une modification à leur fiche médicale depuis le nombre de jour(s) choisi(s) ci-dessous.</p>

	<select id="temps" name="temps">
		<option value="0" selected="selected"></option>
		<option value="1">1 jour</option>
		<option value="3">3 jours</option>
		<option value="7">7 jours</option>
		<option value="14">14 jours</option>
		<option value="30">30 jours</option>
	</select>	

	<p style="padding-top: 5px;">Choisissez le format souhaité pour l'impression</p>

	<select id="format" name="format">
		<option value="0" selected="selected">Pleine page</option>
		<option value="1">Format de poche</option>
	</select>	

	<div style="padding-top: 10px;">
		<?php echo CHtml::submitButton( 'Imprimer', array( 'class' => 'btn primary' ) ) ?>
	</div>
</div>
</form>

<script type="text/javascript">

	function disableIfNeeded( list, opposing ) {

		var selected = $(list).find("option:selected");
		var first = $(list).find("option:first");

		if( selected.val() != first.val() ) {
			opposing.attr("disabled", "disabled");
		} else if( opposing.is(":disabled") ) {
			opposing.removeAttr("disabled");
		}

	}

	$( function() {

		$("#unites").change( function() {
			disableIfNeeded( $("#unites"), $("#temps") );
		});

		$("#temps").change( function() {
			disableIfNeeded( $("#temps"), $("#unites") );
		});

	});

</script>
