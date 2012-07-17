<?php $this->renderPartial("//adresse/_form", array( 'adresse' => new Adresse() ) ) ?>
<script type="text/javascript">
    $( function() {

        <?php if( isset( $selector ) ): ?>
            var selector = "<?php echo $selector ?>";
        <?php else: ?>
            var selector = ".adress-selectbox";
        <?php endif ?>

        $(selector).find("select").append(
            $("<option></option>").
            attr("value", "<?php echo $adresse->ID_ADRESSE ?>").
            text("<?php echo $adresse->adresseComplete ?>")
        );

        $("#adresse-modal").modal('hide');

    });
</script>
