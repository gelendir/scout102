<h2><?php echo Yii::t( 'notification', 'accueil' ) ?></h2>

<?php $form=$this->beginWidget('ActiveForm', array('action' => $action)); ?>

<table>
    <thead>
        <th><?php echo Yii::t( 'notification', 'notification' ) ?></th>
        <th><?php echo Yii::t( 'notification', 'date' ) ?></th>
        <th><?php echo Yii::t( 'notification', 'actions' ) ?></th>
    </thead>
    <tbody>
        <?php 
            foreach($notifications as $notification)
            {
                if($notification->LU == 0)
                {
                    if($notification->IMPORTANT == 0)
                    {
                    //Yii::app()->dateFormatter->format('yyyy-MM-dd',datetime);       $notification->DATE_ENVOIE
                        echo "<tr>" ;
                            echo "<td>". $notification->MESSAGE ."</td>";
                            echo "<td>". Yii::app()->dateFormatter->format('yyyy-MM-dd',$notification->DATE_ENVOIE) ."</td>"; ?>
                            <td><?php echo CHtml::link('Lu', array('Notification/read', 'id'=>$notification->ID_NOTIFICATION)); ?></td>
                        </tr>
                        <?php
                    }
                    else //si le message est important, on lui donne le css pour l'afficher en rouge
                    {
                        echo '<span class = "caseRouge">';
                        echo "<tr>" ;
                            echo "<td>". $notification->MESSAGE ."</td>";
                            echo "<td>". Yii::app()->dateFormatter->format('yyyy-MM-dd',$notification->DATE_ENVOIE) ."</td>"; ?>
                            <td><?php echo CHtml::link('Lu', array('Notification/read', 'id'=>$notification->ID_NOTIFICATION)); ?></td>
                        </tr>
                        </span>
                        <?php
                    }
                }
            }
        ?>
    </tbody>
</table>

<?php $this->endWidget(); ?>
