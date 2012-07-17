<?php foreach( $recuImpots as $recuImpot ): ?>
    <?php $this->renderPartial("_recuImpot", array( 'recuImpot' => $recuImpot ) ) ?>
    <hr />
<?php endforeach ?>
