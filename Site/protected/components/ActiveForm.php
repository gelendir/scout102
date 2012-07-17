<?php

class ActiveForm extends CActiveForm {

    public $errorMessageCssClass = 'help-inline';


    public function labelText( $model, $attribute ) {
        $labels = $model->attributeLabels();
        return $labels[$attribute];
    }

    public function mask( $model, $attribute ) {
        $masks = $model->attributeMasks();
        return $masks[$attribute];
    }

    public function labelMask( $model, $attribute, array $htmlOptions = array() ) {
        $htmlOptions['label'] = $this->mask( $model, $attribute );
        return parent::label( $model, $attribute, $htmlOptions );
    }

}

?>
