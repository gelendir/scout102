<?php echo CHtml::image( Yii::app()->request->baseUrl . '/images/recuImpotBanner.png' ) ?>

<h1>Reçu aux fins d'impôt sur le revenu <?php echo $recuImpot->ANNEE_IMPOSITION ?></h1>
<h1>Crédit pour la condition physique des enfants</h1>

<h2>102e Groupe Scout des Laurentides</h2>

<b>Adresse d'entreprise:</b>
<span><?php echo Yii::app()->params['adresseEntreprise'] ?></span>
<br />
<br />

<b>Numero d'entreprise:</b>
<span><?php echo Yii::app()->params['numeroEntreprise'] ?></span>
<br />
<br />

<b>Payeur:</b>
<span><?php echo $recuImpot->nomComplet ?></span>
<br />
<br />

<b>Adresse:</b>
<span><?php echo $recuImpot->adresse->adresseComplete ?></span>
<br />
<br />

<b>Montant admissible:</b>
<span><?php echo Util::formatMoney( $recuImpot->MONTANT ) ?></span>
<br />
<br />

<b>Pour l'activité:</b>
<span><?php echo $recuImpot->ACTIVITE ?></span>
<br />
<br />

<b>Nom du participant:</b>
<span><?php echo $recuImpot->scout->nomComplet ?></span>
<br />
<br />

<b>Date de naissance:</b>
<span><?php echo $recuImpot->scout->dateNaissance ?></span>
<br />
<br />

<b>Date:</b>
<span><?php echo Util::formatDate( Util::parseDbDate( $recuImpot->DATE_EMISSION ) ) ?></span>
<br />
<br />

<b>Numéro de reçu:</b>
<span><?php echo $recuImpot->noRecu ?></span>
<br />
<br />

<b>Signature Autorisée:</b>

