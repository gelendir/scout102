
<div class="alert-message block-message error">
    <p>
        <?php echo $message ?>
    </p>
</div>

<?php $this->renderPartial("//login/_form", array(
    'action' => $action,
    'adulte' => $adulte,
) )?>
