<?php

class Util 
{

    static public function encrypt( $password ) 
    {

        return crypt( $password );

    }

    static public function validatePassword( $entered, $encrypted )
    {

        return ( crypt( $entered, $encrypted ) == $encrypted );

    }

    static public function parseDate( $date, $format = null ) 
    {

        if( $format === null ) {
            $format = Yii::app()->params['dateFormat'];
        }

        $timestamp = CDateTimeParser::parse( $date, $format );
        return $timestamp;

    }

    static public function formatDate( $timestamp, $format = null )
    {

        if( $format === null ) {
            $format = Yii::app()->params['dateFormat'];
        }

        $dateFormatter = new CDateFormatter( Yii::app()->language );
        $date = $dateFormatter->format( $format, $timestamp );
        return $date;

    }

    static public function formatDbDate( $timestamp ) 
    {

        return date( 'Y-m-d H:i:s', $timestamp );

    }

    static public function parseDbDate( $date )
    {

        return strtotime( $date );

    }

    static public function formatMoney( $amount, $format = null )
    {

        if( $format === null ) {
            $format = Yii::app()->params['formatArgent'];
        }

        return sprintf( $format, $amount );

    }

    static public function encryptKey( $key )
    {

        return hash( "sha256", hash( "sha256", hash( "sha256", $key ) ) );

    }

    static public function flattenArray( $array, $parent = array() )
    {

        foreach( $array as $key => $value ) {

            if( is_array( $value ) ) {

                $parent = self::flattenArray( $value, $parent );

            } else if( $value ) {

                $parent[] = $value;

            }

        }

        return $parent;

    }

    static public function saveOrThrow( $model ) {

        if( !$model->save() ) {

            $errors = self::flattenArray( $model->getErrors() );

            throw new CHttpException( 
                500,
                "Error saving table " . $model->tableName() . ": " . implode( ", ", $errors )
            );

        }

    }

    static public function debutSession()
    {

        $mois = Yii::app()->params['sessionMois'];
        $jour = Yii::app()->params['sessionJour'];
        $annee = (int)date('Y');

        if( mktime( 0, 0, 0, $mois, $jour, $annee ) > time() ) {
            $annee -= 1;
        }

        return mktime( 0, 0, 0, $mois, $jour, $annee );

    }

    static public function finSession()
    {

        $debutSession = self::debutSession();
        $finSession = $debutSession + Yii::app()->params['sessionNbJours'] * 24 * 60 * 60;

        return $finSession;

    }

}

?>
