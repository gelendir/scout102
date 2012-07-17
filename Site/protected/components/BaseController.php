<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class BaseController extends CController
{

    public $css = array();
    public $js = array();
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout='//layouts/main';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu=array();

    public $afficherEtapes = true;
    public $afficherMenu = true;
    public $etape = "";

    public function filters() {

        return array( 'cleanup', 'timeZone' );

    }

    public function filterCleanup( $filterChain ) {

        $cs = Yii::app()->clientScript;
        $cs->scriptMap = array(
            'jquery.js' => false,
            'jquery.min.js' => false,
        );

        CHtml::$errorSummaryCss = "alert-message block-message error";
        CHtml::$errorMessageCss = "help-inline";

        $filterChain->run();
    }

    public function filterTimeZone( $filterChain ){

        date_default_timezone_set(
            Yii::app()->params['timezone']
        );

        $filterChain->run();

    }

}
