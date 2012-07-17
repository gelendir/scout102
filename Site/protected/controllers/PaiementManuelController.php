<?php

class PaiementManuelController extends AdminController
{

    public function actionIndex()
    {
        $debutSession = Util::debutSession();
        $finSession = Util::finSession();

        //TODO: rabais animateur ?
        foreach( Famille::model()->findAll() as $famille ) {
            $famille->genererVersements( $debutSession, $finSession, false );
        }

        $this->render('index');
    }

}
