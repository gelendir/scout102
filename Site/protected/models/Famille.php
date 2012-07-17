<?php

/**
 * This is the model class for table "FAMILLE".
 *
 * The followings are the available columns in table 'FAMILLE':
 * @property integer $ID_FAMILLE
 *
 * The followings are the available model relations:
 * @property ADRESSE[] $aDRESSEs
 * @property MODEPAIEMENT $iDMODEPAIEMENT
 * @property ADULTE[] $aDULTEs
 * @property SCOUT[] $sCOUTs
 * @property VERSEMENTAFAIRE[] $vERSEMENTAFAIREs
 */
class Famille extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Famille the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'FAMILLE';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_FAMILLE', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'adresses' => array(self::MANY_MANY, 'Adresse', 'ADRESSE_FAMILLE(ID_FAMILLE, ID_ADRESSE)'),
            'adultes' => array(self::MANY_MANY, 'Adulte', 'FAMILLE_ADULTE(ID_FAMILLE, ID_ADULTE)'),
            'scouts' => array(self::MANY_MANY, 'Scout', 'FAMILLE_SCOUT(ID_FAMILLE, ID_SCOUT)'),
            'versements' => array(self::HAS_MANY, 'Versement', 'ID_FAMILLE'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_FAMILLE' => 'Id Famille',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('ID_FAMILLE',$this->ID_FAMILLE);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function soldePaypal( $tsDebutSession, $tsFinSession ) {

        $debutSession = Util::formatDbDate( $tsDebutSession );
        $finSession = Util::formatDbDate( $tsFinSession );

        $command = Yii::app()->db->createCommand()
            ->select(
                array(
                    'COALESCE( SUM( tarif.MONTANT ), 0 )    AS total',
                    'famille.ID_FAMILLE                     AS idFamille',
                ) )
            ->from( 'FAMILLE famille' )
            ->join( 'FAMILLE_SCOUT familleScout', 
                'famille.ID_FAMILLE = familleScout.ID_FAMILLE' )
            ->join( 'SCOUT scout',
                "familleScout.ID_SCOUT = scout.ID_SCOUT" )
            ->join( 'T_VERSEMENT versement', 
                "versement.ID_FAMILLE = familleScout.ID_FAMILLE
                 AND versement.ID_SCOUT = familleScout.ID_SCOUT" )
            ->join( 'TARIF tarif', 'versement.ID_TARIF = tarif.ID_TARIF' ) 
            ->join( 'VERSEMENT_FACTURE versementFacture',
                "versementFacture.ID_VERSEMENT = versement.ID_VERSEMENT" )
            ->join( 'FACTURE facture',
                "versementFacture.ID_FACTURE = facture.ID_FACTURE" )
            ->where(
                "famille.ID_FAMILLE = :idFamille
                 AND tarif.DATE_VERSEMENT BETWEEN :debutSession AND :finSession
                 AND scout.ACTIF = :actif",
                array(
                    'idFamille'     => $this->ID_FAMILLE,
                    'debutSession'  => $debutSession,
                    'finSession'    => $finSession,
                    'actif'         => true,
                ) )
            ->group( "famille.ID_FAMILLE" );


        $solde = (int)$command->queryScalar();

        return $solde;

    }

    public function totalPaypal( $tsDebutSession, $tsFinSession ) {

        $debutSession = Util::formatDbDate( $tsDebutSession );
        $finSession = Util::formatDbDate( $tsFinSession );

        $command = Yii::app()->db->createCommand()
            ->select(
                array(
                    'SUM( tarif.MONTANT )       AS total',
                    'famille.ID_FAMILLE         as idFamille',
                ) )
            ->from( 'FAMILLE famille' )
            ->join( 'FAMILLE_SCOUT familleScout', 
                'famille.ID_FAMILLE = familleScout.ID_FAMILLE' )
            ->join( 'SCOUT scout',
                "familleScout.ID_SCOUT = scout.ID_SCOUT" )
            ->join( 'T_VERSEMENT versement', 
                "versement.ID_FAMILLE = familleScout.ID_FAMILLE
                 AND versement.ID_SCOUT = familleScout.ID_SCOUT" )
            ->join( 'TARIF tarif', 'versement.ID_TARIF = tarif.ID_TARIF' ) 
            ->where(
                "famille.ID_FAMILLE = :idFamille
                 AND tarif.DATE_VERSEMENT BETWEEN :debutSession AND :finSession
                 AND scout.ACTIF = :actif",
                array(
                    'idFamille'     => $this->ID_FAMILLE,
                    'debutSession'  => $debutSession,
                    'finSession'    => $finSession,
                    'actif'         => true,
                ) )
            ->group( "famille.ID_FAMILLE" );

        $total = (int)$command->queryScalar();

        return $total;

    }

    public function montantPaypal( $tsDebutSession, $tsFinSession ) {

        $total = $this->totalPaypal( $tsDebutSession, $tsFinSession );
        $solde = $this->soldePaypal( $tsDebutSession, $tsFinSession );

        $montant = $total - $solde;

        return $montant;

    }

    private function trouverTarifs( $debutSession, $finSession, $noScout, $rabais )
    {

        $idFamille = $this->ID_FAMILLE;

        $query = "DATE_VERSEMENT BETWEEN :debutSession AND :finSession
                AND TOTAL = FALSE
                AND RABAIS = :rabais
                AND NO_ENFANT = :noScout
                AND ID_TARIF NOT IN (
                    SELECT ID_TARIF FROM T_VERSEMENT WHERE ID_FAMILLE = :idFamille
                ) ";

        $params = array(
            'idFamille'     => $idFamille,
            'debutSession'  => $debutSession,
            'finSession'    => $finSession,
            'noScout'       => $noScout,
            'rabais'        => false,
        );

        $tarifs = array();

        if( $rabais ) {

            $tarifs = Tarif::model()->findAll(
                $query,
                array_merge( $params, array('rabais' => true) )
            );

            $idRabais = array();
            foreach( $tarifs as $tarifRabais ) {
                $idRabais[] = $tarifRabais->ID_TARIF;
            }

            $query .= "AND ID_TARIF NOT IN (" . implode( ",", $idRabais ) . ") ";

        }

        $tarifs = array_merge(
            $tarifs,
            Tarif::model()->findAll( $query, $params )
        );

        return $tarifs;

    }

    private function trouverScouts( $debutSession, $finSession )
    {

        $idFamille = $this->ID_FAMILLE;

        $scoutsExistant = Scout::model()
            ->with('familleScout.versements.tarif')
            ->findAll(
                "tarif.DATE_VERSEMENT BETWEEN :debutSession and :finSession",
                array(
                    'debutSession'  => $debutSession,
                    'finSession'    => $finSession,
                )
            );

        $idScouts = array();
        foreach( $scoutsExistant as $existant ) {
            $idScouts[] = $existant->ID_SCOUT;
        }

        $sql = "";

        if( count( $idScouts ) > 0 ) {
            $sql .= "t.ID_SCOUT NOT IN (" . implode( ", ", $idScouts ) . ")";
        }

        $scouts = Scout::model()
            ->famille( $idFamille )
            ->findAll( $sql );

        return $scouts;

    }

    public function scoutsAPayer( $tsDebutSession, $tsFinSession )
    {

        $debutSession = Util::formatDbDate( $tsDebutSession );
        $finSession = Util::formatDbDate( $tsFinSession );

        $scouts = Scout::model()
            ->with('familleScout.versements.tarif')
            ->findAll(
                "tarif.DATE_VERSEMENT BETWEEN :debutSession and :finSession
                AND versements.ETAT = :etat
                AND familleScout.ID_FAMILLE = :idFamille",
                array(
                    'debutSession'  => $debutSession,
                    'finSession'    => $finSession,
                    'etat' => false,
                    'idFamille' => $this->ID_FAMILLE,
                )
            );

        return $scouts;

    }

    public function genererVersements( $tsDebutSession, $tsFinSession, $rabais = false )
    {
        $debutSession = Util::formatDbDate( $tsDebutSession );
        $finSession = Util::formatDbDate( $tsFinSession );

        $scouts = $this->trouverScouts( $debutSession, $finSession );

        $nbScoutsTotal = Scout::model()->famille( $this->ID_FAMILLE )->count();

        $noScout = $nbScoutsTotal - count( $scouts ) + 1;

        foreach( $scouts as $scout ) {

            $tarifs = $this->trouverTarifs( $debutSession, $finSession, $noScout, $rabais );

            foreach( $tarifs as $tarif ) {

                $tarifVersement = new TarifVersement;
                $tarifVersement->ID_SCOUT = $scout->ID_SCOUT;
                $tarifVersement->ID_TARIF = $tarif->ID_TARIF;
                $tarifVersement->ID_FAMILLE = $this->ID_FAMILLE;
                $tarifVersement->ETAT = 0;
                $tarifVersement->save();

            }

            $noScout += 1;

        }

    }

    public function versementsAPayer( $tsDebutSession, $tsFinSession )
    {

        $debutSession = Util::formatDbDate( $tsDebutSession );
        $finSession = Util::formatDbDate( $tsFinSession );

        $scoutsActifs = $this->scouts;

        $idScouts = array();
        foreach( $scoutsActifs as $scout ) {
            $idScouts[] = $scout->ID_SCOUT;
        }

        $tarifVersements = TarifVersement::model()
            ->with('tarif')
            ->findAll(
                "tarif.DATE_VERSEMENT BETWEEN :debutSession AND :finSession
                AND t.ETAT = :etat 
                AND t.ID_FAMILLE = :idFamille
                AND t.ID_SCOUT IN (" . implode( ",", $idScouts ) . ")",
                array(
                    'debutSession' => $debutSession,
                    'finSession' => $finSession,
                    'etat' => false,
                    'idFamille' => $this->ID_FAMILLE,
                )
            );

        return $tarifVersements;

    }

    public function getAdultesFamille()
    {

        $nomAdultes = array();

        foreach( $this->adultes as $adulte ) {
            $nomAdultes[] = $adulte->nomComplet;
        }

        return implode( ", ", $nomAdultes );

    }

}
