<h1>Installation terminé</h1>

<p>
    L'installation est maintenant terminé !
    À fin de sécuriser votre nouveau site web,
    nous vous conseillons de supprimer le fichier install.php dans le dossier racine de votre site web. 
    Vous pouvez maintenant accèder à la page d'accueil au lien suivant :
<?php
        $url = "http://" . $_SERVER['HTTP_HOST'] . Yii::app()->request->baseUrl;
        echo CHtml::link( $url, $url );
    ?>

</p>
