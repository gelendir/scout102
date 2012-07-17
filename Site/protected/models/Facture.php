<?php

/**
 * This is the model class for table "FACTURE".
 *
 * The followings are the available columns in table 'FACTURE':
 * @property integer $ID_FACTURE
 * @property string $MONTANT
 * @property string $DATE_FACTURE
 * @property integer $ID_MODE_PAIEMENT
 *
 * The followings are the available model relations:
 * @property MODEPAIEMENT $iDMODEPAIEMENT
 * @property TVERSEMENT[] $tVERSEMENTs
 */
class Facture extends CActiveRecord
{

    private $sauverVersementFactures = false;

    /**
     * Returns the static model of the specified AR class.
     * @return Facture the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function avecTarifVersements( $tarifVersements )
    {

        $versementFactures = array();

        foreach( $tarifVersements as $tarifVersement ) {

            $versementFacture = new VersementFacture;
            $versementFacture->ID_VERSEMENT = $tarifVersement->ID_VERSEMENT;
            $versementFactures[] = $versementFacture;

        }

        $facture = new Facture;
        $facture->versementFactures = $versementFactures;

        return $facture;

    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'FACTURE';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('MONTANT, ID_MODE_PAIEMENT', 'required'),
            array('ID_FACTURE, ID_MODE_PAIEMENT', 'numerical', 'integerOnly'=>true),
            array('MONTANT', 'length', 'max'=>10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_FACTURE, MONTANT, DATE_FACTURE, ID_MODE_PAIEMENT', 'safe', 'on'=>'search'),
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
            'modePaiement' => array(self::BELONGS_TO, 'ModePaiement', 'ID_MODE_PAIEMENT'),
            'tarifVersements' => array(self::MANY_MANY, 'TarifVersement', 'VERSEMENT_FACTURE(ID_FACTURE, ID_VERSEMENT)'),
            'versementFactures' => array( self::HAS_MANY, 'VersementFacture', 'ID_FACTURE'),
            'paiementPaypal' => array( self::HAS_ONE, 'PaiementPaypal', 'ID_FACTURE' ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_FACTURE' => 'Id Facture',
            'MONTANT' => 'Montant',
            'DATE_FACTURE' => 'Date Facture',
            'ID_MODE_PAIEMENT' => 'Id Mode Paiement',
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

        $criteria->compare('ID_FACTURE',$this->ID_FACTURE);
        $criteria->compare('MONTANT',$this->MONTANT,true);
        $criteria->compare('DATE_FACTURE',$this->DATE_FACTURE,true);
        $criteria->compare('ID_MODE_PAIEMENT',$this->ID_MODE_PAIEMENT);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    protected function beforeSave()
    {

        if( $this->isNewRecord ) {
            $this->DATE_FACTURE = new CDbExpression("NOW()");
            $this->sauverVersementFactures = true;
        }

        return true;

    }

    protected function afterSave()
    {

        if( $this->sauverVersementFactures ) {
            foreach( $this->versementFactures as $versementFacture ) {

                $versementFacture->ID_FACTURE = $this->ID_FACTURE;

                if( $versementFacture->save() ) {
                    $versementFacture->versement->ETAT = true;
                    $versementFacture->versement->save();
                }

            }
        }

        return true;

    }

    public function getScouts()
    {

        $scouts = array();
        foreach( $this->versementFactures as $versementFacture ) {

            $scout = $versementFacture->versement->scout;
            if( !in_array( $scout, $scouts ) ) {
                $scouts[] = $scout;
            }

        }

        return $scouts;

    }

    public function getDateVersements()
    {

        $dateVersements = array();

        foreach( $this->versementFactures as $versementFacture ) {

            $dbDate = $versementFacture->versement->tarif->DATE_VERSEMENT;
            $timestamp = Util::parseDbDate( $dbDate );

            if( !in_array( $timestamp, $dateVersements ) ) {
                $dateVersements[] = $timestamp;
            }

        }

        sort( $dateVersements );

        return $dateVersements;

    }

}
