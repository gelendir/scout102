<?php

/**
 * This is the model class for table "RECU_IMPOT".
 *
 * The followings are the available columns in table 'RECU_IMPOT':
 * @property integer $ID_RECU_IMPOT
 * @property string $MONTANT
 * @property integer $ANNEE_IMPOSITION
 * @property string $DATE_EMISSION
 * @property integer $NO_RECU
 * @property integer $ID_SCOUT
 * @property string $NOM_PERSONNE
 * @property string $COURRIEL_D_ENVOIE
 * @property string $ACTIVITE
 * @property string $PRENOM_PERSONNE
 *
 * The followings are the available model relations:
 * @property Scout $iDSCOUT
 */
class RecuImpot extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return RecuImpot the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function scopes() 
    {

        $alias = $this->getTableAlias(false, false);

        return array(
            'generees' => array(
                'condition' => "$alias.MONTANT IS NOT NULL",
            ),
        );

    }

    public static function dernierNoRecu()
    {

        $command = Yii::app()->db->createCommand()
            ->select(
                array(
                    'MAX( recuImpot.NO_RECU ) as dernierNoRecu',
                ) )
            ->from( 'RECU_IMPOT AS recuImpot' );

        $dernierNoRecu = $command->queryScalar();

        return $dernierNoRecu;

    }

    public static function generer( $tsDebutSession, $tsFinSession )
    {

        $annee = (int)date('Y', $tsDebutSession );
        $noRecu = self::dernierNoRecu() + 1;

        $recuImpots = RecuImpot::model()->findAll(
            "ANNEE_IMPOSITION = :annee
            AND MONTANT IS NULL
            AND DATE_EMISSION IS NULL
            ",
            array(
                'annee' => $annee,
            )
        );

        foreach( $recuImpots as $recuImpot ) {

            $unite = Unite::model()
                ->with('uniteScouts')
                ->find( array(
                    'condition' => "uniteScouts.ID_SCOUT = :idScout",
                    'order' => "t.DATE_CREATION DESC",
                    'params' => array(
                        'idScout' => $recuImpot->ID_SCOUT,
                    )
                ) );

            if( $unite !== null ) {
                $nomTypeUnite = $unite->programme->NOM_PROGRAMME;
            } else {
                $nomTypeUnite = Yii::t( 'recuImpot', 'nomActiviteDefaut' );
            }

            $info = $recuImpot->infoRecuImpot( $tsDebutSession, $tsFinSession );

            $montant = $info['total'];

            $activite = Yii::t( 'recuImpot', 'recuImpotActivite', array(
                '{unite}' => $nomTypeUnite,
            ) );

            $recuImpot->MONTANT = $montant;
            $recuImpot->NO_RECU = $noRecu;
            $recuImpot->ACTIVITE = $activite;

            Util::saveOrThrow( $recuImpot );
            $noRecu += 1;

        }

    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'RECU_IMPOT';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_SCOUT, ID_ADRESSE, NOM_PERSONNE, PRENOM_PERSONNE, ID_ADRESSE', 'required', 'on' => 'recu'),
            array('NOM_PERSONNE, PRENOM_PERSONNE, ID_ADRESSE', 'required', 'on' => 'fiche'),
            array('ANNEE_IMPOSITION, NO_RECU, ID_SCOUT', 'numerical', 'integerOnly'=>true),
            array('MONTANT', 'length', 'max'=>10),
            array('NOM_PERSONNE, ACTIVITE, PRENOM_PERSONNE', 'length', 'max'=>45),
            array('COURRIEL_D_ENVOIE', 'length', 'max'=>100),
            array('COURRIEL_D_ENVOIE', 'email' ),
            array('DATE_EMISSION, ID_ADRESSE', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_RECU_IMPOT, MONTANT, ANNEE_IMPOSITION, DATE_EMISSION, NO_RECU, ID_SCOUT, NOM_PERSONNE, COURRIEL_D_ENVOIE, ACTIVITE, PRENOM_PERSONNE', 'safe', 'on'=>'search'),
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
            'scout' => array(self::BELONGS_TO, 'Scout', 'ID_SCOUT'),
            'adresse' => array( self::BELONGS_TO, 'Adresse', 'ID_ADRESSE' ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_RECU_IMPOT' => 'Id Recu Impot',
            'MONTANT' => 'Montant',
            'ANNEE_IMPOSITION' => "Année d'imposition",
            'DATE_EMISSION' => "Date d'émission",
            'NO_RECU' => 'No Reçu',
            'ID_SCOUT' => 'Id Scout',
            'NOM_PERSONNE' => 'Nom reçu impôt',
            'COURRIEL_D_ENVOIE' => 'Courriel reçu impot',
            'ACTIVITE' => 'Activité',
            'PRENOM_PERSONNE' => 'Prénom reçu impôt',
        );
    }

    public function attributeMasks()
    {
        return array(
            'NOM_PERSONNE' => 'Nom',
            'PRENOM_PERSONNE' => 'Prénom',
            'COURRIEL_D_ENVOIE' => 'john.doe@exemple.com',
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

        $criteria->compare('ID_RECU_IMPOT',$this->ID_RECU_IMPOT);
        $criteria->compare('MONTANT',$this->MONTANT,true);
        $criteria->compare('ANNEE_IMPOSITION',$this->ANNEE_IMPOSITION);
        $criteria->compare('DATE_EMISSION',$this->DATE_EMISSION,true);
        $criteria->compare('NO_RECU',$this->NO_RECU);
        $criteria->compare('ID_SCOUT',$this->ID_SCOUT);
        $criteria->compare('NOM_PERSONNE',$this->NOM_PERSONNE,true);
        $criteria->compare('COURRIEL_D_ENVOIE',$this->COURRIEL_D_ENVOIE,true);
        $criteria->compare('ACTIVITE',$this->ACTIVITE,true);
        $criteria->compare('PRENOM_PERSONNE',$this->PRENOM_PERSONNE,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getIsEnvoiCourriel() {

        return( $this->COURRIEL_D_ENVOIE !== null && $this->COURRIEL_D_ENVOIE != "" );

    }

    public function infoRecuImpot( $tsDebutSession, $tsFinSession ) {

        $debutSession = Util::formatDbDate( $tsDebutSession );
        $finSession = Util::formatDbDate( $tsFinSession );

        $command = Yii::app()->db->createCommand()
            ->select(
                array(
                    'SUM( tarif.MONTANT )           AS total',
                    'MIN( tarifVersement.ETAT )     AS etatPaiement',
                    'tarifVersement.ID_SCOUT        AS idScout',
                ) )
            ->from( 'T_VERSEMENT tarifVersement' )
            ->join( 'TARIF tarif', 'tarif.ID_TARIF = tarifVersement.ID_TARIF' )
            ->where(
                "tarif.DATE_VERSEMENT BETWEEN :debutSession AND :finSession
                AND tarifVersement.ID_SCOUT = :idScout",
                array(
                    'debutSession' => $debutSession,
                    'finSession'   => $finSession,
                    'idScout'      => $this->ID_SCOUT,
                ) )
            ->group( 'tarifVersement.ID_SCOUT' );


        return $command->queryRow();

    }

    public function beforeSave()
    {

        if( $this->isNewRecord &&
            ( $this->ANNEE_IMPOSITION == 0 || $this->ANNEE_IMPOSITION === null )
        )
        {
            $this->ANNEE_IMPOSITION = (int)date("Y");
        }

        return true;

    }

    public function getNomComplet()
    {
        return $this->PRENOM_PERSONNE . " " . $this->NOM_PERSONNE;
    }

    public function getNoRecu()
    {

        $noRecu =
            Yii::app()->params['noRecuEntreprise']
            . " " . $this->ANNEE_IMPOSITION
            . " " . sprintf( "%04d", $this->NO_RECU );

        return $noRecu;

    }

    public function getDejaEnvoye()
    {
        return ( !( $this->DATE_EMISSION == null ) );
    }

}
