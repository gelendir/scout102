<h2>Info général</h2>

<fieldset>

    <div class="clearfix">
        <label>Nom de L'unité</label>
        <div class="input">
            <?php echo $form->textField($unite, 'NOM_UNITE'); ?>
        </div>
    </div>

    <div class="clearfix">
        <label>Type d'unité</label>
        <div class="input">
            <?php
                echo $form->dropDownList($unite, 'ID_PROGRAMME', CHtml::ListData(Programme::model()->findAll(), 'ID_PROGRAMME', 'NOM_PROGRAMME'));
            ?>
        </div>
    </div>

</fieldset>
