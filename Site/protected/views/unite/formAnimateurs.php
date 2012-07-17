<h2><?php echo Yii::t( 'unite', 'animateurs' ) ?></h2>

<div class="row">

    <div class="col3 multilist-list">
        <p><b><?php echo Yii::t( 'unite', 'animateursdispo' ) ?></b></p>
        <select multiple id="Adisponibles" name="Adisponibles[]">
        <?php

            $animateursDispo = $unite->animateurDisponibles();
            $animateurs = $unite->animateurs;
            $idAnimateurs = array();

            foreach( $animateurs as $animateur ) {
                $idAnimateurs[] = $animateur->ID_ADULTE;
            }

            foreach($animateursDispo as $animateur){
                if( !in_array( $animateur->ID_ADULTE, $idAnimateurs ) ) {
                    echo "<option value=\"" . $animateur->ID_ADULTE . "\">" . $animateur->PRENOM . " " . $animateur->NOM . "</option>";
                }
            }
        ?>
        </select>

    </div>

    <div class="col3 multilist-buttons">
        <input id="ajouterA" class="btn primary" type="submit" value=">>" />
        <input id="enleverA" class="btn primary" type="submit" value="<<" />
    </div>

    <div class="col3 multilist-list">
        <p><b><?php echo Yii::t( 'unite', 'animateursAssignes' ) ?></b></p>
        <select multiple id="Aassignes" name="Aassignes[]">
            <?php
            if($typeAction === "edit"){
                $animateurs = $unite->animateurs;
                foreach($animateurs as $animateur){
                    echo "<option value=\"" . $animateur->ID_ADULTE . "\">" . $animateur->PRENOM . " " . $animateur->NOM . "</option>";
                }
            }
            ?>
        </select>
    </div>

</div>

<script type="text/javascript">
    $( function() {

        $("#ajouterA").click( function() {
            $("#Adisponibles option:selected").each( function( index, element ) {
                element = $(element);
                $("#Aassignes").append( element );
            });
            return false;
        });

        $("#enleverA").click( function() {
            $("#Aassignes option:selected").each( function( index, element ) {
                element = $(element);
                $("#Adisponibles").append( element );
            });
            return false;
        });

        $("#unite-form").submit( function() {
            $("#Aassignes option").attr("selected", "selected");
            $("#Adisponibles option").attr("selected", "selected");
        } )

    });
</script>
