<?php

class Controller extends BaseController 
{

    public function filters()
    {

        return array_merge(
            parent::filters(),
            array(
                'authenticated',
            )
        );

    }

    public function filterAuthenticated( $filterChain ) {

        if( Yii::app()->user->isGuest ) {

            $this->redirect( array( 'accueil/index' ) );

        }

        $filterChain->run();

    }

}

?>
