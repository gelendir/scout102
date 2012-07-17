<div id="adresse-modal" class="modal hide fade in">

    <?php echo CHtml::beginForm( array('adresse/createAjax') ) ?>

    <div class="modal-header">
        <a class="close" href="#">x</a>
        <h3>Ajout d'adresse</h3>
    </div>
    
    <?php echo $this->renderPartial("//adresse/_form", array( 'adresse' => $adresse ) ) ?>

    <div class="modal-footer">
        <a id="modal-close" class="btn secondary" href="#">Annuler</a>
        <a id="modal-ajouter" class="btn primary" href="#">Ajouter</a>
    </div>

    <?php echo CHtml::endForm() ?>
</div>

<script type="text/javascript">
    $( function() {

        $('#adresse-modal').modal({
            backdrop: 'static',
        });

        $("#modal-close").click( function() {
            $("#adresse-modal").modal('hide');
            return false;
        });

        $(".adresse-ajouter").click( function() {
            $('#adresse-modal').modal('show');
            return false;
        });

        $('.adresse-retirer').click( function() {

            var list = $(this).parents(".adress-selectbox").find("select");
            var adresseId = list.find("option:selected").val();

            var data = {
                id: adresseId
                <?php if( isset( $selector ) ): ?>
                ,selector: "<?php echo $selector ?>"
                <?php endif ?>
            };

            $.ajax({
                type: 'POST',
                url: "<?php echo $this->createUrl( 'adresse/deleteAjax' ) ?>",
                data: data,
                success: function( response ) {
                    eval( response );
                }
            });

            return false;
        });

       $('#modal-ajouter').unbind("click").click( function(e) {

           var data = $(this).parents("form").serializeArray();
            <?php if( isset( $selector ) ): ?>
                data.push({name: "selector", value: "<?php echo $selector ?>"});
            <?php endif ?>

            <?php if( isset( $idFamille ) ): ?>
               data.push({name: "idFamille", value: <?php echo $idFamille ?>});
            <?php endif ?>

            console.debug( data );

            $.ajax({
                type: 'POST',
                url: "<?php echo $this->createUrl( 'adresse/createAjax' ) ?>",
                data: $.param( data ),
                success: function(html) {
                    $(".modal-body").replaceWith( html );
                },
            });
            return false;
       });

    });
</script>

