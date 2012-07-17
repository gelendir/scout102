
<span class="description"><?php echo $titre ?></span>

<div class="adress-selectbox">

    <?php 

    echo CHtml::activeDropDownList(
        $model,
        $field,
        CHtml::listData( $adresses, 'ID_ADRESSE', 'adresseComplete' ),
        array(
            'size' => 4,
            'class' => 'addresslist',
        )
    ) ?>

    <div class="addremove">
        <a class="adresse-ajouter btn info" href="#">+</a><br />
        <a class="adresse-retirer btn danger" href="#">-</a>
    </div>

</div>
