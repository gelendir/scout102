<?php

class GenerationFicheController extends AdminController
{

    public function filters() {

        return array_merge(
            parent::filters(),
            array(
                'before'
            )
         );

    }

    public function filterBefore( $filterChain ) {

        $filterChain->run();

    }

	public function actions()
	{
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	
	public function actionIndex()
	{
		$unite = new Unite;
		
		$this->render('index', array('unite'=>$unite));
	}
}
