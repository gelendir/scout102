<?php
    $adulte = $model;

    $demandes = $adulte->implicationDemandes();
    $accordes = $adulte->implicationAccordes();
?>
<div id="roles" <?php if( isset( $active ) ){ echo 'class="active"'; } ?>>

    <p>
        <span class="label notice"><?php echo Yii::t( 'parent', 'note' ) ?></span>
        <em><?php echo Yii::t( 'parent', 'noteImplications' ) ?></em>
    </p>

    <div class="row">

        <div class="col3 multilist-list">
            <p><?php echo Yii::t( 'parent', 'implicationDemande' ) ?></p>
            <select multiple class="liste" id="demandes" name="demandes[]">
                <?php
                    foreach( $demandes as $implication ) {
                        if( !in_array( $implication, $accordes ) ) {
                            echo '<option value="' . $implication->ID_IMPLICATION . '">' . $implication->typeImplication->TITRE_IMPLICATION . "</option>";
                        }
                    }
                ?>
            </select>
        </div>

        <div class="col3 multilist-buttons">
            <input type="submit" value=">>" id="ajouter" class="btn primary"/>
            <input type="submit" value="<<" id="enlever" class="btn primary"/>
        </div>

        <div class="col3 multilist-list">
            <p><?php echo Yii::t( 'parent', 'implicationAccorde' ) ?></p>
            <select multiple class="liste" id="accordes" name="accordes[]">
                <?php
                    foreach( $accordes as $implication ) {
                        echo '<option value="' . $implication->ID_IMPLICATION . '">' . $implication->typeImplication->TITRE_IMPLICATION . "</option>";
                    }
                ?>
            </select>
        </div>
    </div>

</div>

<script type="text/javascript">
$( function() {

    $("#ajouter").click( function() {
        $("#demandes option:selected").each( function( index, element ) {
            element = $(element);
            $("#accordes").append( element );
        });
        return false;
    });

    $("#enlever").click( function() {
        $("#accordes option:selected").each( function( index, element ) {
            element = $(element);
            $("#demandes").append( element );
        });
        return false;
    });

    $("#enlever").parents("form").submit( function() {
        $("#accordes option").attr("selected", "selected");
    } )

});
</script>
