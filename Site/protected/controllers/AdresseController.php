<?php

class AdresseController extends Controller
{
	public function actionCreateAjax()
    {

        if( isset( $_POST['Adresse'] ) ) {

            $adresse = new Adresse;
            $adresse->attributes = $_POST['Adresse'];

        }

        $idFamille = Yii::app()->user->idFamille;

        //Si idFamille est dans le POST,
        //alors ça veut dire qu'un administrateur veut ajouter
        //une adresse. Nous devons donc vérifier s'il a le droit
        //d'ajouter une adresse
        if( isset( $_POST['idFamille'] ) ) {

            if( !Yii::app()->user->isAllowedAdmin ) {
                throw new CHttpException( 403 );
            }

            $idFamille = (int)$_POST['idFamille'];

        }

        //Le seul cas prévu pour l'instant est l'ajout par AJAX
        if( Yii::app()->getRequest()->getIsAjaxRequest() ) {

            if( $adresse->validate() ) {

                $adresse->save();

                //créer l'association entre la famille et l'adresse
                //pour que l'adresse soit disponible aux autres membres de la famille
                $familleAdresse = new FamilleAdresse();
                $familleAdresse->ID_ADRESSE = $adresse->ID_ADRESSE;
                $familleAdresse->ID_FAMILLE = $idFamille;

                $familleAdresse->save();

                $params = array(
                    'adresse' => $adresse,
                );

                if( isset( $_POST['selector'] ) ) {
                    $params['selector'] = $_POST['selector'];
                }

                $this->renderPartial('success', $params );

            } else {

                //Erreur dans l'adresse. Réafficher le formulaire
                $this->renderPartial('_form', array( 'adresse' => $adresse ) );

            }
        }

    }

    public function actionDeleteAjax() {

        $id = (int)$_POST['id'];

        if( $id > 0 ) {

            //Une adresse ne peut seulement être supprimée
            //si elle n'est pas utilisé par un autre membre de la famille.
            //Vérifions le nombre d'adultes et de scouts qui utilisent l'adresse.
            $count = Scout::model()->count(
                "ID_ADRESSE_PRINC = :idAdresse",
                array(
                    'idAdresse' => $id,
                )
            );

            $count += Adulte::model()->count(
                "ID_ADRESSE_PRINC = :idAdresse",
                array(
                    'idAdresse' => $id,
                )
            );

            if( $count > 0 ) {

                $this->renderPartial('error', array(
                    'message' => Yii::t( 'adresse', 'cannotDelete' ),
                ) );

            } else {

                FamilleAdresse::model()->deleteAll(
                    "ID_ADRESSE = :idAdresse AND ID_FAMILLE = :idFamille",
                    array(
                        'idFamille' => Yii::app()->user->idFamille,
                        'idAdresse' => $id,
                    )
                );

                Adresse::model()->deleteByPk( $id );

                $params = array('idAdresse' => $id);

                if( isset( $_POST['selector'] ) ) {
                    $params['selector'] = $_POST['selector'];
                }

                $this->renderPartial('delete', $params );

            }
        }
    }

    public function actionAutocomplete( $term )
    {

        if( trim( $term ) == "" ) {
            return;
        }

        $command = Yii::app()->db->createCommand()
            ->select(  array(
                'ID_VILLE AS id',
                'NOM_VILLE AS label',
                'NOM_VILLE AS value',
            ) )
            ->from( 'VILLE' )
            ->where(
                "LOWER( NOM_VILLE ) LIKE LOWER( :term )",
                array(
                    'term' => '%' . $term . '%',
                )
            )
            ->order( 'NOM_VILLE' );

        $rows = $command->queryAll();

        if( Yii::app()->request->isAjaxRequest ) {

            echo CJSON::encode( $rows );

        }

    }

}
