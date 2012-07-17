<?php

class PostProcessor {

    static public function creationFicheMedicale( $ficheMedicale, $scolarite )
    {

        $ficheMedicale->attributes = $_POST['FicheMedicale'];

        $scolarite->attributes = $_POST['Scolarite'];
        $scolarite->ID_SCOUT = $_POST['FicheMedicale']['ID_SCOUT'];

        $reponseCases = array();

        foreach($_POST['ReponseCase']['REPONSE'] as $i=>$reponseCase){

            if( $reponseCase == "" ) {
                $reponseCase = null;
            }

            $reponse = new ReponseCase();
            $reponse->REPONSE = $reponseCase;
            $reponse->ID_FICHE_MEDICALE = $ficheMedicale->ID_FICHE_MEDICALE;
            $reponse->ID_CASE_A_COCHER = $_POST['ReponseCase']['ID_CASE_A_COCHER'][$i];

            $reponseCases[] = $reponse;

        }

        $reponseTextes = array();

        foreach ($_POST['TEXTE'] as $i=>$reponseTexte) {

            $reponseT = new TexteFicheChamp();
            $reponseT->ID_CAT_CHAMP_TEXTE = $_POST['TexteFicheChamp']['ID_CAT_CHAMP_TEXTE'][$i];
            $reponseT->ID_FICHE_MEDICALE = $ficheMedicale->ID_FICHE_MEDICALE;
            $reponseT->TEXTE = $reponseTexte;

            $reponseTextes[] = $reponseT;
        }

        $ficheMedicale->reponseCases = $reponseCases;
        $ficheMedicale->texteFicheChamps = $reponseTextes;

    }

    static public function majFicheMedicale( $ficheMedicale, $scolarite )
    {

        $ficheMedicale->attributes = $_POST['FicheMedicale'];

        $reponseCases = array();

        foreach($_POST['ReponseCase']['REPONSE'] as $i=>$reponseCase){

            if( $reponseCase == "" ) {
                $reponseCase = null;
            }

            $idCase = $_POST['ReponseCase']['ID_CASE_A_COCHER'][$i];
            $reponse = ReponseCase::model()->find(array('condition'=>'ID_CASE_A_COCHER = :idCase AND ID_FICHE_MEDICALE = :idFiche',
                                                        'params'=>array('idCase'=>$idCase, 'idFiche'=>$ficheMedicale->ID_FICHE_MEDICALE)));
            $reponse->REPONSE = $reponseCase;
            $reponseCases[] = $reponse;
        }

        $responseTextes = array();

        foreach ($_POST['TEXTE'] as $i=>$reponseTexte){

            $idCatChamp = $_POST['TexteFicheChamp']['ID_CAT_CHAMP_TEXTE'][$i];
            $idFicheMedicale = $ficheMedicale->ID_FICHE_MEDICALE;

            $reponseT = TexteFicheChamp::model()->findByAttributes(
                array(
                    'ID_CAT_CHAMP_TEXTE' => $idCatChamp,
                    'ID_FICHE_MEDICALE' => $idFicheMedicale,
                )
            );

            $reponseT->TEXTE = $reponseTexte;

            $reponseTextes[] = $reponseT;
        }

        $ficheMedicale->reponseCases = $reponseCases;
        $ficheMedicale->texteFicheChamps = $reponseTextes;

        $scolarite->attributes = $_POST['Scolarite'];

    }

    static public function creationAutorisations( $scout )
    {


        for($i=0; $i<count($_POST["Autorisation"]["ACCEPTATION"]); $i++)
        {

            $idAuto = $_POST["TypeAutorisation"]["ID_TYPE_AUTO"][$i];
            $reponse = $_POST["Autorisation"]["ACCEPTATION"][$i];

            $modAutorisation= new Autorisation;
            $modAutorisation->ACCEPTATION = $reponse;
            $modAutorisation->ID_TYPE_AUTO = $idAuto;

            $autorisations[] = $modAutorisation;

        }

        $scout->autorisations = $autorisations;

    }

    static public function majAutorisations( $scout )
    {

        $nbAutorisations = count( $_POST['Autorisation']['ACCEPTATION'] );
        $autorisations = array();

        for( $i = 0; $i < $nbAutorisations; $i++ )
        {

            $acceptation = $_POST['Autorisation']['ACCEPTATION'][$i];
            $idTypeAutorisation = $_POST["TypeAutorisation"]["ID_TYPE_AUTO"][$i];

            $autorisation = Autorisation::model()->findByAttributes(
                array(
                    'ID_TYPE_AUTO' => $idTypeAutorisation,
                    'ID_SCOUT' => $scout->ID_SCOUT,
                )
            );

            if( $autorisation === null ) {
                throw new CHttpException( 400, "Autorisation does not exist");
            }

            $autorisation->ACCEPTATION = $acceptation;

            $autorisations[] = $autorisation;

        }

        $scout->autorisations = $autorisations;


    }


}


?>
