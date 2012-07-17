
<h2><?php echo Yii::t( 'parent', 'listeUtilisateur' ) ?></h2>

<p><?php echo CHtml::link( Yii::t( 'parent', 'inscrireUtilisateur' ), array('Utilisateur/new')); ?></p>

<table>
    <thead>
        <th><?php echo Yii::t( 'parent', 'nom' ) ?></th>
        <th><?php echo Yii::t( 'parent', 'role' ) ?></th>
        <th><?php echo Yii::t( 'parent', 'statut' ) ?></th>
        <th colspan="2"><?php echo Yii::t( 'parent', 'actions' ) ?></th>
    </thead>
    <tbody>
            <?php 
            $adultes = Adulte::model()->findAll();
            $implications = Implication::model()->findAll();
            $implications = $adultes;
            foreach($adultes as $adulte)
            {
                $implications = array();
                foreach( $adulte->implications as $implication ) {
                    if( $implication->DEMANDE ) {
                        $implications[] = $implication;
                    }
                }
            ?>
                    <tr>
                    <td>
                    <?php echo $adulte->PRENOM . " " . $adulte->NOM?>
                    </td>
                    <td>
                    <?php
                        $demandes = array();
                        foreach( $implications as $implication ) {
                            $demandes[] = $implication->typeImplication->DESCRIPTION;
                        }
                        echo implode( ", ", $demandes );
                    ?>
                    </td>
                    <td>
                    <?php 
                        $accordes = array();
                        foreach( $implications as $implication ) {
                            if( $implication->ACCORDE ) {
                                $accordes[] = Yii::t( 'parent', 'oui' );
                            } else {
                                $accordes[] = Yii::t( 'parent', 'non' );
                            }
                        }

                        echo implode( ", ", $accordes );
                        ?>
                    </td>
                    <td>
                    <?php echo CHtml::link( Yii::t( 'parent', 'modifier' ), array('Utilisateur/edit', 'id'=>$adulte->ID_ADULTE)); ?>
                    </td>
                    <td><?php
                        if($adulte->COMPTE_ACTIF == 0)
                        {
                            echo CHtml::link( Yii::t( 'parent', 'activer' ), array('Utilisateur/activate', 'id'=>$adulte->ID_ADULTE));
                        }
                        else
                        {
                            echo CHtml::link( Yii::t( 'parent', 'desactiver' ), array('Utilisateur/deactivate', 'id'=>$adulte->ID_ADULTE));
                        }

                        ?></td>
                    </tr>

                <?php
            }
            ?>
        </tr>

    </tbody>
</table>

<script type="text/javascript">

$(function(){
$('#checkbox').click(
function()
    {
        if(document.getElementById("checkbox").checked == true)
        {
            window.location += '&afficher = 1';
        }
        else
        if(document.getElementById("checkbox").checked == false)
        {
            window.location += '&afficher = 0';
        }
        return true;
    }
);
});

</script>
