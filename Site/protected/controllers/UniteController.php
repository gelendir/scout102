<?php

class UniteController extends AdminController
{
    private $typeAction;

    public function actionEdit($id)
    {
        $this->typeAction = "edit";
        $unite = Unite::model()->findByPk($id);

        if( $unite === null ) {
            throw new CHttpException( 404 );
        }

        $this->render('edit', array('unite'=>$unite, 'typeAction'=>$this->typeAction, 'action'=>array('Unite/update', 'idUnite'=>$id)));
    }

    public function actionUpdate($idUnite)
    {
        $this->typeAction = "edit";

        $unite = Unite::model()->findByPk($idUnite);
        if( $unite === null ) {
            throw new CHttpException( 404 );
        }

        if( isset( $_POST['Unite'] ) ) {
            $unite->attributes = $_POST['Unite'];
        }

        if( $unite->save() ) {

            AnimateurUnite::model()->deleteAll('ID_UNITE = :id', array('id'=>$idUnite));

            if(isset($_POST['Aassignes'])){
                $animateurs = $_POST['Aassignes'];
                foreach($animateurs as $i=>$animateur){
                    $animateurUnite = new AnimateurUnite();
                    $animateurUnite->ID_UNITE = $idUnite;
                    $animateurUnite->ID_ADULTE = $_POST['Aassignes'][$i];
                    Util::saveOrThrow( $animateurUnite );
                }
            }

            UniteScout::model()->deleteAll('ID_UNITE = :id', array('id'=>$idUnite));

            if(isset($_POST['Sassignes'])){
                $scouts = $_POST['Sassignes'];
                foreach($scouts as $i=>$scout){
                    $uniteScout = new UniteScout();
                    $uniteScout->ID_UNITE = $idUnite;
                    $uniteScout->ID_SCOUT = $_POST['Sassignes'][$i];
                    Util::saveOrThrow( $uniteScout );
                }
            }

            $this->logUnite( $unite, 'update');
            $this->redirect( array( 'unite/index' ) );

        }

        $this->render('update', array('unite'=>$unite, 'typeAction'=>$this->typeAction, 'action'=>array('unite/update', 'idUnite'=>$idUnite)));
    }

    public function actionIndex()
    {
        $Unites = array();
        $Unites = Unite::model()->findAll();
        $this->render('index', array('Unites'=>$Unites));
    }

    public function actionNew()
    {
        $unite = new Unite();
        //$unite->ID_PROGRAMME = 1;
        $this->typeAction = "new";
        $this->render('new', array('unite'=>$unite, 'typeAction'=>$this->typeAction, 'action'=>array('unite/newUnite')));
    }

    public function actionNewUnite()
    {
        if( isset( $_POST['Unite'] ) ) {

            $unite = new Unite();
            $unite->attributes = $_POST['Unite'];
            $this->typeAction = "new";

            $this->render('newUnite',
                array(
                    'unite' => $unite,
                    'typeAction' => $this->typeAction,
                    'action' => array( 'unite/create' ),
                )
            );

        }

    }

    public function actionCreate()
    {

        $this->typeAction = "edit";
        $unite = new Unite();

        if( isset( $_POST['Unite'] ) ) {

            $unite->attributes = $_POST['Unite'];

            if( $unite->save() ) {

                if(isset($_POST['Aassignes'])){

                    $animateurs = $_POST['Aassignes'];

                    foreach($animateurs as $i=>$animateur){
                        $animateurUnite = new AnimateurUnite();
                        $animateurUnite->ID_UNITE = $unite->ID_UNITE;
                        $animateurUnite->ID_ADULTE = $_POST['Aassignes'][$i];
                        Util::saveOrThrow( $animateurUnite );
                    }
                }

                if(isset($_POST['Sassignes'])) {

                    $scouts = $_POST['Sassignes'];

                    foreach($scouts as $i=>$scout){
                        $uniteScout = new UniteScout();
                        $uniteScout->ID_UNITE = $unite->ID_UNITE;
                        $uniteScout->ID_SCOUT = $_POST['Sassignes'][$i];
                        Util::saveOrThrow( $uniteScout );
                    }

                }

                $this->logUnite( $unite, 'create');
                $this->redirect( array( 'unite/index' ) );

            }

        }

        $this->render('create', array('unite'=>$unite, 'typeAction'=>$this->typeAction, 'action'=>array('unite/create')));
    }

    public function logUnite( $unite, $action)
    {
        //parcourir animateurs
        $anim = "";
        foreach($unite->animateurs as $animateur)
        {
            $anim .= $animateur->PRENOM . " " . $animateur->NOM . ", " ;
        }
        //parcourir scouts
        $sco = "";
        foreach($unite->scouts as $scout)
        {
            $sco .= $scout->PRENOM . " " . $scout->NOM . ", " ;
        }

        $message = Yii::app()->user->nomComplet . " ";
        $message .= $action . " ";
        $message .= "Inscription_parent - ";
        $message .= "Id_unite='" . $unite->ID_UNITE . "';";
        $message .= "Nom_unite='" . $unite->NOM_UNITE . "';";
        $message .= "Date_creation='" . $unite->DATE_CREATION . "';";
        $message .= "Date_creation='" . $unite->DATE_CREATION . "';";
        $message .= "Nom_programme='" . $unite->programme->NOM_PROGRAMME . "';";
        $message .= "Animateurs='" . $anim . "';";
        $message .= "Scouts='" . $sco . "';";

        Yii::log(
            $message,
            "info",
            "journalisation"
        );
    }

}
