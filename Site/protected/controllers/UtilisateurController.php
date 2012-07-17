<?php

class UtilisateurController extends AdminController
{

    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array_merge( parent::filters(), array(
            'before',
        ) );
    }

    public function filterBefore( $filterChain )
    {
        $filterChain->run();
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionDeactivate($id)
    {
        $model = Adulte::model()->findByPk($id);
        $model->COMPTE_ACTIF = 0;
        $model->save();

        $this->redirect( array('Utilisateur/index' ) );
    }

    public function actionActivate($id)
    {
        $model = Adulte::model()->findByPk($id);
        $model->COMPTE_ACTIF = 1;
        $model->save();

        $this->redirect( array('Utilisateur/index' ) );
    }

    public function actionNew()
    {
        $model = new Adulte();
        $model->genererImplications();

        $famille = new Famille();
        $famille->save();

        $this->render('new',
            array(
                'model' => $model,
                'action' => array( 'Utilisateur/create' ),
                'famille' => $famille,
            )
        );

    }

    public function actionEdit($id)
    {
        $model = Adulte::model()->findByPk($id);
        $famille = Famille::model()->findByPk( $model->idFamille );

        $this->render('edit',
            array(
                'model'=> $model,
                'famille' => $famille,
                'action' => array( 'Utilisateur/update', 'id' => $id ),
            )
        );
    }

    public function actionUpdate($id)
    {

        $demandes = $_POST['Implication']['DEMANDE'];
        $IDTypeImplications = $_POST['Implication']['ID_TYPE_IMPLICATION'];
        $IDImplications = $_POST['Implication']['ID_IMPLICATION'];

        $model=Adulte::model()->findByPk($id);
        $model->scenario = 'ficheAdmin';
        $famille = Famille::model()->findByPk( $model->idFamille );

        if(isset($_POST['Adulte']))
        {

            $accordes = array();
            if( isset( $_POST['accordes'] ) ) {
                $accordes = $_POST['accordes'];
            }

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

                if( in_array( $implication->ID_IMPLICATION, $accordes ) ) {
                    $implication->ACCORDE = 1;
                } else {
                    $implication->ACCORDE = 0;
                }

                $implications[] = $implication;

            }

            $model->implications = $implications;

            $model->attributes = $_POST['Adulte'];
            $model->conf_password = $model->MOT_DE_PASSE;

            if( $_POST['motPasse'] != "" ) {
                $model->MOT_DE_PASSE = $_POST['motPasse'];
                $model->conf_password = $_POST['confirmation'];
            }

            if( $model->validate() ) {

                if( $_POST['motPasse'] != "" ) {
                    $model->encrypterMotDePasse();
                }

                if($model->save())
                {
                    foreach( $implications as $implication )
                    {
                        Util::saveOrThrow( $implication );
                    }

                    $this->logUtilisateur( $model, 'update');
                    $this->redirect(array( 'Utilisateur/index' ));

                }
            }
        }

        $this->render('update', array(
            'model'=>$model,
            'famille' => $famille,
            'action' => array( 'Utilisateur/update', 'id' => $id ),
        ));
    }

    public function actionCreate()
    {
        $model = new Adulte();
        $famille = Famille::model()->findByPk( $_POST['Famille']['ID_FAMILLE'] );

        $demandes = $_POST['Implication']['DEMANDE'];
        $IDTypeImplications = $_POST['Implication']['ID_TYPE_IMPLICATION'];
        $IDImplications = $_POST['Implication']['ID_IMPLICATION'];
        $model->scenario = 'ficheAdmin';

        if(isset($_POST['Adulte']))
        {

            $implications = array();
            for($i = 0 ; $i < count($demandes) ; $i++)
            {
                $demande = $demandes[$i];
                $IDTypeImplication = $IDTypeImplications[$i];
                $IDImplication = $IDImplications[$i];

                $implication = new Implication();
                $implication->DEMANDE = $demande;
                $implication->ID_TYPE_IMPLICATION = $IDTypeImplication;

                $implications[] = $implication;
            }

            $model->implications = $implications;
            $model->attributes = $_POST['Adulte'];
            $model->encrypterMotDePasse();

            if($model->save())
            {
                foreach( $implications as $implication ) 
                {
                    $implication->ID_ADULTE = $model->ID_ADULTE;
                    Util::saveOrThrow( $implication );
                }

                $familleAdulte = new FamilleAdulte;
                $familleAdulte->ID_FAMILLE = $famille->ID_FAMILLE;
                $familleAdulte->ID_ADULTE = $model->ID_ADULTE;
                Util::saveOrThrow( $familleAdulte );
				
				$this->logUtilisateur( $model, 'create');
                $this->redirect(array( 'Utilisateur/index' ));
            }
        }

        $this->render('create', array('model'=>$model, 'famille' => $famille) );
    }
	
	public function logUtilisateur( $utilisateur, $action)
	{
		$adr = "";
		$adr .= $utilisateur->adresse->ADRESSE_RUE . " ";
		$adr .= $utilisateur->adresse->VILLE . " "; 
		$adr .= $utilisateur->adresse->PROVINCE . " ";
		$adr .= $utilisateur->adresse->CODE_POSTAL;
		
		
		$message = Yii::app()->user->nomComplet . " ";
		$message .= $action . " ";
		$message .= "Fiche_utilisateur - ";
		$message .= "Id_adulte='" . $utilisateur->ID_ADULTE . "';";
		$message .= "Prenom='" . $utilisateur->PRENOM . "';";
		$message .= "Nom='" . $utilisateur->NOM . "';";
		$message .= "Nom_utilisateur='" . $utilisateur->NOM_UTILISATEUR . "';";
		$message .= "Mot_de_passe='" . $utilisateur->MOT_DE_PASSE . "';";
		$message .= "Courriel='" . $utilisateur->COURRIEL . "';";
		$message .= "Sexe='" . $utilisateur->SEXE . "';";
		$message .= "No_tel_principal='" . $utilisateur->NO_TEL_PRINCIPAL . "';";
		$message .= "No_tel_secondaire='" . $utilisateur->NO_TEL_SECONDAIRE . "';";
		$message .= "No_tel_autre='" . $utilisateur->NO_TEL_AUTRE . "';";
		$message .= "Emploi='" . $utilisateur->EMPLOI . "';";
		$message .= "Adresse='" . $adr . "';";
		$message .= "Parent='" . $utilisateur->PARENT . "';";
		$message .= "Compte_actif='" . $utilisateur->COMPTE_ACTIF . "';";

	
		Yii::log(
				$message,
				"info",
				"journalisation"
			);
	
	}

}
