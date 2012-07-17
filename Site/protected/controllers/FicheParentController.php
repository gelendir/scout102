<?php

class FicheParentController extends Controller
{

    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array_merge( parent::filters(), array(
            'before',
            'verifierAcces + edit, update',
        ) );
    }

    public function filterBefore( $filterChain ) {

        $this->etape = "ficheParent";
        $filterChain->run();
    }

    public function filterVerifierAcces( $filterChain ) {

        $idAdulte = Yii::app()->request->getParam( "id" );

        if( Yii::app()->user->id != $idAdulte ) {
            throw new CHttpException( 403 );
        }

        $filterChain->run();

    }

    public function actionCreate()
    {
        //On recupere l'ID du nouveau parent par la variable session
        $IDParent = Yii::app()->user->getId();

        $demandes = $_POST['Implication']['DEMANDE'];
        $IDTypeImplications = $_POST['Implication']['ID_TYPE_IMPLICATION'];
        $IDImplications = $_POST['Implication']['ID_IMPLICATION'];

        //Vu que le parent a déja un compte, on récupère la rangée déja crée de la BD
        $model=Adulte::model()->findByPk($IDParent);
        $model->scenario = 'fiche';

        if(isset($_POST['Adulte']))
        {

            //Avant de sauver la fiche, nous devons créer toutes les implications
            $implications = array();
            for($i = 0 ; $i < count($demandes) ; $i++)
            {
                $demande = $demandes[$i];
                $IDTypeImplication = $IDTypeImplications[$i];
                $IDImplication = $IDImplications[$i];

                $implication = new Implication();
                $implication->DEMANDE = $demande;
                $implication->ID_TYPE_IMPLICATION = $IDTypeImplication;
                $implication->ID_ADULTE = $model->ID_ADULTE;

                $implications[] = $implication;
            }

            $model->implications = $implications;

            $model->attributes = $_POST['Adulte'];

            //Si la fiche est valide, alors nous pouvons aussi créer les implications dans la bd
            if($model->save())
            {
                foreach( $implications as $implication )
                {
                    $implication->save();
                }

                $this->logParent($model, 'create');
                //si enregistre dans BD, on redirige vers la prochaine page(fiche enfant)
                $this->redirect(array( 'FicheEnfant/index' ));
            }
        }

        //Erreur dans la fiche. Réafficher le formulaire
        $this->render('create', array('model'=>$model) );
    }

    public function actionEdit($id)
    {

        $model=Adulte::model()->findByPk($id);

        if( $model === null ) {
            throw new CHttpException( 404 );
        }

        $this->render(
            'edit', array(
                'model'=>$model,
                'action'=>array( 'FicheParent/update', 'id'=>$id ),
        ) );
    }

    public function actionNew()
    {
        $model = new Adulte('fiche');
        $model->genererImplications();

        $this->render('new', array('model'=>$model ));
    }

    public function actionUpdate($id)
    {
        $demandes = $_POST['Implication']['DEMANDE'];
        $IDTypeImplications = $_POST['Implication']['ID_TYPE_IMPLICATION'];
        $IDImplications = $_POST['Implication']['ID_IMPLICATION'];

        //Récupération de la fiche de la BD
        $model=Adulte::model()->findByPk($id);
        $model->scenario = 'fiche';

        if(isset($_POST['Adulte']))
        {

            //Avant de sauver la fiche, nous devons créer toutes les implications
            $implications = array();
            for($i = 0 ; $i < count($demandes) ; $i++)
            {
                $demande = $demandes[$i];
                $IDTypeImplication = $IDTypeImplications[$i];
                $IDImplication = $IDImplications[$i];

                //on crée nouvelle implication / On affecte l'implication deja créé
                $implication = Implication::model()->findByPk($IDImplication);
                $implication->DEMANDE = $demande;
                $implication->ID_TYPE_IMPLICATION = $IDTypeImplication;
                $implication->ID_ADULTE = $model->ID_ADULTE;

                $implications[] = $implication;
            }

            $model->implications = $implications;
            $model->attributes = $_POST['Adulte'];

            //Si la fiche est valide, alors nous pouvons aussi créer les implications dans la bd
            if($model->save())
            {
                foreach( $implications as $implication ) {
                    $implication->save();
                }
                $this->logParent($model, 'update');
                //si enregistre dans BD, on redirige vers la prochaine page(fiche enfant)
                $this->redirect(array( 'FicheEnfant/index' ));
            }
        }

        //Erreur dans la fiche. Réafficher le formulaire
        $this->render('update', array(
            'model'=>$model,
            'action'=>array( 'FicheParent/update', 'id'=>$id ),
        ) );
    }

        public function logParent( $parent, $action )
        {
            //Création du message de log pour la fiche parent
            $imp = "";
            foreach($parent->implications as $implicationn)
            {
                $imp .= $implicationn->typeImplication->DESCRIPTION . "[" . $implicationn->DEMANDE ."] ";
            }

            $adr = $parent->adresse->ADRESSE_RUE . " ";
            $adr .= $parent->adresse->VILLE . " ";
            $adr .= $parent->adresse->PROVINCE . " ";
            $adr .= $parent->adresse->CODE_POSTAL;

            $message = Yii::app()->user->nomComplet . " ";
            $message .= $action . " ";
            $message .= "Inscription_parent - ";
            $message .= "Id_adulte='" . $parent->ID_ADULTE . "';";
            $message .= "Prenom='" . $parent->PRENOM . "';";
            $message .= "Nom='" . $parent->NOM . "';";
            $message .= "Nom_utilisateur='" . $parent->NOM_UTILISATEUR . "';";
            $message .= "Mot_de_passe='***';";
            $message .= "Courriel='" . $parent->COURRIEL . "';";
            $message .= "Sexe='" . $parent->SEXE . "';";
            $message .= "No_tel_principal='" . $parent->NO_TEL_PRINCIPAL . "';";
            $message .= "No_tel_secondaire='" . $parent->NO_TEL_SECONDAIRE . "';";
            $message .= "No_tel_autre='" . $parent->NO_TEL_AUTRE . "';";
            $message .= "Emploi='" . $parent->EMPLOI . "';";
            $message .= "Adresse='" . $adr . "';";
            $message .= "Parent='" . $parent->PARENT . "';";
            $message .= "COMPTE_ACTIF='" . $parent->COMPTE_ACTIF . "';";
            $message .= "Implications='" . $imp . "';";

            Yii::log(
                $message,
                "info",
                "journalisation"
            );
        }

}
