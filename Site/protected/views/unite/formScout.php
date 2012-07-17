<h2><?php echo Yii::t( 'unite', 'scouts' ) ?></h2>

<div class="row">

    <?php if( isset( $unite->programme ) ): ?>
        <p><?php echo "Type d'unité sélectionnée : " . $unite->programme->NOM_PROGRAMME;?></p>
    <?php endif ?>

    <div class="col3 multilist-list">

        <p><b><?php echo Yii::t( 'unite', 'scoutsDispo' ) ?></b></p>
        <select multiple id="Sdisponibles" name="Sdisponibles[]">
        <?php
            foreach($unite->scoutsDisponibles() as $scout) {
                if( !in_array( $scout, $unite->scouts ) ) {
                    echo "<option value=\"" . $scout->ID_SCOUT . "\">" . $scout->PRENOM . " " . $scout->NOM . "</option>";
                }
            }
        ?>
        </select>

    </div>

    <div class="col3 multilist-buttons">

        <input id="ajouterS" class="btn primary" type="submit" value=">>" />
        <input id="enleverS" class="btn primary" type="submit" value="<<" />

    </div>

    <div class="col3 multilist-list">

        <p><b><?php echo Yii::t( 'unite', 'scoutsAssignes' ) ?></b></p>

        <select multiple id="Sassignes" name="Sassignes[]">
            <?php
            if($typeAction === "edit"){
                $scouts = $unite->scouts;
                foreach($scouts as $scout){
                    echo "<option value=\"" . $scout->ID_SCOUT . "\">" . $scout->PRENOM . " " . $scout->NOM . "</option>";
                }
            }
            ?>
        </select>

    </div>

</div>

<script type="text/javascript">
$( function() {

    $("#ajouterS").click( function() {
        $("#Sdisponibles option:selected").each( function( index, element ) {
            element = $(element);
            $("#Sassignes").append( element );
        });
        return false;
    });

    $("#enleverS").click( function() {
        $("#Sassignes option:selected").each( function( index, element ) {
            element = $(element);
            $("#Sdisponibles").append( element );
        });
        return false;
    });

    $("#unite-form").submit( function() {
        $("#Sassignes option").attr("selected", "selected");
        $("#Sdisponibles option").attr("selected", "selected");
    })

});
</script>

