<?php

class AccueilController extends BaseController
{

    public function filters() {

        return array_merge(
            parent::filters(),
            array(
                'before',
            )
        );

    }

    public function filterBefore( $filterChain ) {

        $this->afficherEtapes = false;
        $this->afficherMenu = false;
        $filterChain->run();

    }

    public function actionIndex()
    {

        $adulte = new Adulte('login');

        $this->render('index', array(
            'action' => array( 'login/login' ),
            'adulte' => $adulte,
        ) );
    }

    public function actionError()
    {

        if( $error = Yii::app()->errorHandler->error ) {

            if( Yii::app()->request->isAjaxRequest ) {
                echo $error['message'];
            } else {
                $this->render( 'error', $error );
            }

        }

    }

}
