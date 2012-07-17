<?php

class RecuImpotController extends AdminController
{
    public function getDebutSession()
    {

        $mois = Yii::app()->params['sessionMois'];
        $jour = Yii::app()->params['sessionJour'];
        $annee = (int)date('Y');

        if( mktime( 0, 0, 0, $mois, $jour, $annee ) > time() ) {
            $annee -= 1;
        }

        return mktime( 0, 0, 0, $mois, $jour, $annee );

    }

    public function getFinSession()
    {

        $debutSession = $this->debutSession;
        $finSession = $debutSession + Yii::app()->params['sessionNbJours'] * 24 * 60 * 60;

        return $finSession;

    }

    public function actionIndex()
    {

        $recuImpots = RecuImpot::model()->generees()->findAll();

        $this->render('index', array(
            'recuImpots' => $recuImpots,
            'tsDebutSession' => $this->debutSession,
            'tsFinSession' => $this->finSession,
        ) );

    }

    public function actionEdit( $id )
    {
        $id = (int)$id;

        $recuImpot = RecuImpot::model()->findByPk( $id );
        if( $recuImpot === null ) {
            throw new CHttpException( 404 );
        }

        $this->render(
            'edit',
            array(
                'recuImpot' => $recuImpot,
                'action' => array( 'RecuImpot/update', 'id' => $id ),
            )
        );
    }

    public function actionUpdate( $id )
    {

        $id = (int)$id;

        $recuImpot = RecuImpot::model()->findByPk( $id );
        if( $recuImpot === null ) {
            throw new CHttpException( 404 );
        }

        if( isset( $_POST['RecuImpot'] ) ) {

            $recuImpot->attributes = $_POST['RecuImpot'];

            if( $recuImpot->save() ) {

                $this->redirect( array( 'RecuImpot/index' ) );

            }

        }

        $this->render(
            'update',
            array(
                'recuImpot' => $recuImpot,
                'action' => array( 'RecuImpot/update', 'id' => $id ),
            )
        );

    }

    public function actionGenerate()
    {
        $debutSession = $this->debutSession;
        $finSession = $this->finSession;

        //TODO: rabais animateur ?
        foreach( Famille::model()->findAll() as $famille ) {
            $famille->genererVersements( $debutSession, $finSession, false );
        }

        RecuImpot::generer( $this->debutSession, $this->finSession );
        $this->redirect( array( 'RecuImpot/index' ) );
    }

    public function actionShow( $id )
    {

        $id = (int)$id;
        $recuImpot = RecuImpot::model()->findByPk( $id );

        if( $recuImpot === null ) {
            throw new CHttpException( 404 );
        }

        $this->render( '_recuImpot', array(
            'recuImpot' => $recuImpot,
        ) );
    }

    public function actionSend()
    {

        $recusAImprimer = array();

        if( isset( $_POST['RecuImpot'] ) ) {
            foreach( $_POST['RecuImpot'] as $infoRecu ) {

                $recuImpot = RecuImpot::model()->findByPk( $infoRecu['ID_RECU_IMPOT'] );
                $recuImpot->DATE_EMISSION = new CDbExpression("NOW()");
                Util::saveOrThrow( $recuImpot );

                if( isset( $infoRecu['envoyerCourriel'] ) && $infoRecu['envoyerCourriel'] == true ) {
                    $filepath = $this->genererUnPdf( $recuImpot );
                    $this->envoyerCourriel( $recuImpot, $filepath );
                }

                if( isset( $infoRecu['imprimer'] ) && $infoRecu['imprimer'] == true ) {
                    $recusAImprimer[] = $recuImpot;
                }

            }
        }

        if( count( $recusAImprimer ) > 0 ) {

            $batchFile = $this->genererBatchPdf( $recusAImprimer );
            $parts = explode( "/", $batchFile );
            $filename = $parts[ count( $parts ) - 1 ];

            header('Content-Type: application/pdf');
            header('Content-Length: ' . filesize( $batchFile ));
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            echo file_get_contents( $batchFile );
        } else {

            Yii::app()->user->setFlash( 'error', 'Aucun reçu de sélectionné' );
            $this->redirect( array( 'recuImpot/index' ) );
        }


    }

    public function actionResend( $id )
    {

        $id = (int)$id;

        $recuImpot = RecuImpot::model()->findByPk( $id );
        $filepath = $this->genererUnPdf( $recuImpot );
        $this->envoyerCourriel( $recuImpot, $filepath );

        Yii::app()->user->setFlash( 'success', "Le courriel a été envoyé" );

        $this->redirect( array( 'RecuImpot/index' ) );

    }

    private function envoyerCourriel( $recuImpot, $filePathPdf )
    {

        $body = Yii::t( 'recuImpot', 'messageParent' );

        $subject = Yii::t( 'recuImpot', 'sujetMessageParent' );

        $recuImpot->DATE_EMISSION = new CDbExpression("NOW()");
        Util::saveOrThrow( $recuImpot );

        $to = $recuImpot->COURRIEL_D_ENVOIE;
        $from = Yii::app()->params['adminEmail'];

        $message = new YiiMailMessage;
        $message->subject = $subject;
        $message->from = $from;

        $message->setBody( $body, 'text/plain' );
        $message->addTo( $to );
        $message->attach( Swift_Attachment::fromPath( $filePathPdf ) );

        Yii::app()->mail->send( $message );

    }

    private function genererUnPdf( $recuImpot ) {

        $nomScout = $recuImpot->scout->nomComplet;
        $annee = $recuImpot->ANNEE_IMPOSITION;

        $titre = Yii::t( 'recuImpot', 'titrePdf',
            array(
                '{annee}' => $annee,
                '{nomScout}' => $nomScout,
            )
        );

        $nomFichier = $recuImpot->ID_SCOUT
            . "_" . $recuImpot->ANNEE_IMPOSITION
            . "_" . date("Y-m-d")
            . ".pdf";

        $pdf = $this->nouveauPdf( $titre );
        $this->ajouterPagePdf( $recuImpot, $pdf );
        $pathFichier = $this->fermerPdf( $nomFichier, $pdf );

        return $pathFichier;

    }

    private function genererBatchPdf( $recuImpots ) {

        $titre = Yii::t( 'recuImpot', 'titreBatchPdf',
            array(
                '{date}' => date('Y-m-d H:i'),
            )
        );

        $nomFichier = "batch_" . date("Y-m-d_H-i") . ".pdf";

        $pdf = $this->nouveauPdf( $titre );
        foreach( $recuImpots as $recuImpot ) {
            $this->ajouterPagePdf( $recuImpot, $pdf );
        }
        $pathFichier = $this->fermerPdf( $nomFichier, $pdf );

        return $pathFichier;

    }

    private function nouveauPdf( $titre ) {

        $pdf = new PdfGenerator(
            $titre,
            Yii::app()->params['pdf']['author']
        );

        return $pdf;

    }

    private function fermerPdf( $nomFichier, $pdf ) 
    {

        $dirPath = Yii::app()->runtimePath . "/recuImpot";
        if( !file_exists( $dirPath ) ) {
            mkdir( $dirPath );
        }

        $filePath = $dirPath . "/" . $nomFichier;
        $pdf->closeAndGenerate( $filePath );

        return $filePath;

    }

    private function ajouterPagePdf( $recuImpot, $pdf )
    {

        $html = $this->renderPartial( "_recuImpot",
            array( 'recuImpot' => $recuImpot ),
            true
        );

        $pdf->addHTMLPage( $html );

        return $pdf;

    }

}

?>
