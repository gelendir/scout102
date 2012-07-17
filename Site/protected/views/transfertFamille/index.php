<h1>Assignation de famille</h1>


<?php 
    if(isset($message))
    {
        if(isset($type))
        {
            if($type == 'erreur')
            {
                echo '<div class="alert-message block-message error">';
            }
            elseif($type == 'reussi')
            {
                echo '<div class="alert-message block-message success">';
            }
            else
            {
                echo '<div class="alert-message block-message warning">';
            }
            echo "<p>" . $message . "</p></div>";
        }
    }
 ?>

<form name="input" class="form-stacked" action="<?php echo $this->createUrl("TransfertFamille/FaireMAJ")?>" method="post">

<fieldset>

    <div class="clearfix">
        <p>Je veux que ce parent : </p> 
        
        <div class="input">
        <?php 
                $listeParent1 = Adulte::model()->findAll();
                $listDataParent1 = CHtml::listData($listeParent1,'ID_ADULTE', 'nomComplet');
                echo CHtml::dropDownList('parent1', '',$listDataParent1);
        ?>
        </div>
    </div>

    <div class="clearfix">
        <p>Fasse parti de la famille de ce parent : </p>
        
        <div class="input">
            <?php 
                    $listeParent2 = Adulte::model()->findAll();
                    $listDataParent2 = CHtml::listData($listeParent2,'ID_ADULTE', 'nomComplet');
                    echo CHtml::dropDownList('parent2', '', $listDataParent2);
            ?>
        </div>
    </div>

</fieldset>

<div class="actions well">
    <input class="btn primary" type="submit" value="Assigner" />
</div>

</form>

<hr />
<div>
    <p>Mise en garde: Les enfants et les adresses appartenant à la même famille que le parent transferé seront aussi transferé.</p>
    
    <p>Mise en situation: </p> 
    
    <ol>
        <li>Pauline inscrit ses 2 enfants et veux que leur père, Paul, puisse accèder au deux enfant.</li>
            <ul>
                <li>Pauline crée sont compte utilisateur et inscrit ses 2 enfants dans le système. </li>
                <li>Paul crée un compte utilisateur comme Pauline, mais n'inscrit pas d'enfant. </li>
                <li>Faite le transfert de famille en sélectionnant Paul en premier et Pauline en deuxième</li>
            </ul>
        </li>
        <li>Yvette inscrit ses 2 enfants. Guy à déjà un enfant dans le système. Guy et Yvette veulent partager leurs enfants. </li>
            <ul>
                <li>Faite le transfert de famille en sélectionnant soit Yvette ou Guy en premier et l'autre en deuxième.</li>
            </ul>
        </li>
    </ol>
    
</div>

