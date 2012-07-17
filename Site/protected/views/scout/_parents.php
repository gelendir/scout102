<div id="parents"<?php if( isset( $active ) ){ echo 'class="active"'; } ?>>

    <div class="row">

        <div class="col3">
            <p>Parents</p>
            <select multiple class="liste" id="disponible" name="disponible[]">
                <?php
                    $parents = Adulte::model()->findAll();
                    foreach($parents as $parent)
                    {
                        if( !in_array( $parent, $parentSelection ) ) {
                            echo '<option value="' . $parent->ID_ADULTE . '">' . $parent->nomComplet . "</option>";
                        }
                    }
                ?>
            </select>
        </div>

        <div class="arrows">
            <input type="submit" value=">>" id="ajouter"/>
            <input type="submit" value="<<" id="enlever"/>
        </div>

        <div class="col3">
            <p>Assignés</p>
            <select multiple class="liste" id="assignes" name="assignes[]">
                <?php
                    foreach( $parentSelection as $parent ) {
                        echo '<option value="' . $parent->ID_ADULTE . '">' . $parent->nomComplet . "</option>";
                    }
                ?>
            </select>
        </div>
    </div>

</div>
<script type="text/javascript">
$( function() {

    $("#ajouter").click( function() {
        $("#disponible option:selected").each( function( index, element ) {
            element = $(element);
            $("#assignes").append( element );
        });
        return false;
    });

    $("#enlever").click( function() {
        $("#assignes option:selected").each( function( index, element ) {
            element = $(element);
            $("#disponible").append( element );
        });
        return false;
    });

    $("#enlever").parents("form").submit( function() {
        $("#assignes option").attr("selected", "selected");
    } )

});
</script>
