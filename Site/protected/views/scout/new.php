<?php $form = $this->beginWidget('ActiveForm',
    array(
        'action' => array( 'Scout/createFamily' )
    )
);
?>

<?php 
    if( isset( $errors ) ) {
        echo Bootstrap::errorBox( $errors );
    }
?>

<ul class="tabs">
    <li class="active"><a href="#famille">Famille</a></li>
    <li><a href="#fiche">Fiche scout</a></li>
    <li><a href="#fichemedicale">Fiche medicale</a></li>
</ul>

<p>Veuillez sélectionner la famille pour cet enfant avant de créer la fiche</p>

<div class="pill-content">

    <div id="famille" class="active">
        <?php echo CHtml::dropDownList( "idFamille", "",
            CHtml::listData( Famille::model()->findAll(), "ID_FAMILLE", "adultesFamille" )
        ) ?>
    </div>

</div>

<div class="row">
    <?php echo Chtml::submitButton("Procéder à l'inscription", array( 'class' => 'btn primary') ) ?>
</div>

<?php $this->endWidget() ?>
