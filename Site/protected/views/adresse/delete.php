<?php if( isset( $selector ) ): ?>
    var selector = "<?php echo $selector ?>";
<?php else: ?>
    var selector = ".adress-selectbox";
<?php endif ?>

var idAdresse = "<?php echo $idAdresse ?>";

$(selector).find("option[value=" + idAdresse + "]").remove();
