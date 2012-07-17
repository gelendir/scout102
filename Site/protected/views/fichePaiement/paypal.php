<h1><?php echo Yii::t( 'paiement', 'confPaiement' ) ?></h1>

<p><?php echo Yii::t( 'paiement', 'veuillezBouton' ) ?></p>

<form action="<?php echo Yii::app()->params['paypalApiUrl'] ?>" method="post" class="paypal">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="<?php echo Yii::app()->params['paypalMerchantId'] ?>">
    <input type="hidden" name="lc" value="CA">
    <input type="hidden" name="item_name" value="<?php echo $nomItemPaypal ?>">
    <input type="hidden" name="amount" value="<?php echo $montant ?>">
    <input type="hidden" name="button_subtype" value="services">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="no_shipping" value="2">
    <input type="hidden" name="rm" value="1">
    <input type="hidden" name="on0" value="clefSession">
    <input type="hidden" name="os0" value="<?php echo $clef ?>">
    <input type="hidden" name="cancel_return" value="<?php echo $this->createAbsoluteUrl( 'FichePaiement/cancel' ) ?>">
    <input type="hidden" name="currency_code" value="CAD">
    <input type="hidden" name="bn" value="PP-BuyNowBF:btn_paynowCC_LG.gif:NonHosted">
    <input type="image" src="https://www.paypal.com/fr_CA/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
    <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

