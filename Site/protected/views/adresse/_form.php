<div class="modal-body">

    <?php echo CHtml::errorSummary( $adresse ) ?>

    <fieldset>

        <?php Bootstrap::inputDiv( $adresse, 'ADRESSE_RUE' ) ?>
            <?php echo CHtml::activeLabel( $adresse, 'ADRESSE_RUE' ) ?>

            <div class="input">
                <?php echo CHtml::activeTextField( $adresse, 'ADRESSE_RUE' ) ?>
                <?php echo CHtml::error( $adresse, 'ADRESSE_RUE' ) ?>
            </div>

        </div>

        <?php Bootstrap::inputDiv( $adresse, 'VILLE' ) ?>
            <?php echo CHtml::ActiveLabel( $adresse, 'VILLE' ) ?>


            <div class="input">
                <?php echo CHtml::ActiveTextField( $adresse, 'VILLE', array( 'class' => "autocomplete-ville" ) ) ?>
                <?php echo CHtml::error( $adresse, 'VILLE' ) ?>
            </div>

        </div>

        <?php Bootstrap::inputDiv( $adresse, 'PROVINCE' ) ?>
            <?php echo CHtml::activeLabel( $adresse, 'PROVINCE' ) ?>

            <div class="input">
                <?php echo CHtml::ActiveDropDownList( $adresse, 'PROVINCE',
                    array(
                        'QC' => 'Québec',
                        'ON' => 'Ontario',
                        'MA' => 'Manitoba',
                        'SA' => 'Saskatchewan',
                        'AL' => 'Alberta',
                        'BC' => 'Colombie-Britannique',
                        'YU' => 'Yukon',
                        'NT' => 'Territoires du Nord-Ouest',
                        'NU' => 'Nunavut',
                        'NV' => 'Nouvelle Écosse',
                        'NB' => 'Nouveau Brunswick',
                        'PE' => 'Île du Prince Edouard',
                        'NW' => 'Terre-Neuve et Labrador',
                    ));
                ?>
                <?php echo CHtml::error( $adresse, 'PROVINCE' ) ?>
            </div>

        </div>

        <?php Bootstrap::inputDiv( $adresse, 'codePostal' ) ?>
            <?php echo CHtml::ActiveLabel( $adresse, 'codePostal' ) ?>

            <div class="input">
                <?php echo CHtml::ActiveTextField( $adresse, 'codePostal', array( 'class' => 'small' ) ) ?>
                <span class="mask">(G1G 1G1)</span>
                <?php echo CHtml::error( $adresse, 'codePostal' ) ?>
                <br />
            </div>

        </div>

    </fieldset>

</div>

<script type="text/javascript">
$( function() {

    $(".autocomplete-ville").autocomplete({
        source: "<?php echo $this->createUrl( "adresse/autocomplete" ) ?>",
        minLength: 3
    });

});

</script>
