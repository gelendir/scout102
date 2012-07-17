<?php

class Bootstrap {

    public static function inputDiv( $model, $attribute ) {

        if( $model->getError( $attribute ) != "" ) {
            echo '<div class="clearfix error">';
        } else {
            echo '<div class="clearfix">';
        }
    }

    public static function checkBoxList( $name, $list, $selected = array(), $htmlOptions = array() ) {

        $html = '<ul class="inputs-list">';


        foreach( $list as $value => $elementName ) {

            $html .= "<li><label>";

            $html .= Chtml::checkBox(
                $name . "[]",
                in_array( $value, $selected ),
                array_merge(
                    array(
                        'value' => $value
                    ),
                    $htmlOptions
                )
            );

            $html .= "<span>" . $elementName . "</span>";

            $html .= "</li></label>";

        }

        $html .= "</ul>";

        return $html;

    }

    public static function errorBox( $errors ) {

        $html = '<div class="alert-message block-message error">';

        $html .= "<ul>";

        foreach( $errors as $error ) {
            $html .= "<li>";
            $html .= $error;
            $html .= "</li>";
        }

        $html .= "</ul></div>";

        return $html;

    }
}

?>
