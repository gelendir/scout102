<?php

/**
 * This is the model class for table "PAIEMENT_PAYPAL".
 *
 * The followings are the available columns in table 'PAIEMENT_PAYPAL':
 * @property integer $ID_PAIEMENT_PAYPAL
 * @property string $ID_PAYEUR
 * @property string $DATE_PAIEMENT
 * @property string $MONTANT
 * @property string $ID_TRANSACTION
 * @property integer $ID_FACTURE
 *
 * The followings are the available model relations:
 * @property FACTURE $iDFACTURE
 */
class PaiementPaypal extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return PaiementPaypal the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function creerPaiement( $transaction ) {

        $timestamp = strtotime( $transaction['payment_date'] );
        $dbDate = Util::formatDbDate( $timestamp );

        $paiement = new PaiementPaypal;
        $paiement->ID_PAYEUR = $transaction['payer_id'];
        $paiement->DATE_PAIEMENT = $dbDate;
        $paiement->MONTANT = $transaction['mc_gross'];
        $paiement->ID_TRANSACTION = $transaction['txn_id'];

        return $paiement;

    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'PAIEMENT_PAYPAL';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_PAYEUR, DATE_PAIEMENT, MONTANT, ID_TRANSACTION, ID_FACTURE', 'required'),
            array('ID_FACTURE', 'numerical', 'integerOnly'=>true),
            array('ID_PAYEUR, ID_TRANSACTION', 'length', 'max'=>20),
            array('MONTANT', 'length', 'max'=>6),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_PAIEMENT_PAYPAL, ID_PAYEUR, DATE_PAIEMENT, MONTANT, ID_TRANSACTION, ID_FACTURE', 'safe', 'on'=>'search'),
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
            'iDFACTURE' => array(self::BELONGS_TO, 'FACTURE', 'ID_FACTURE'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_PAIEMENT_PAYPAL' => 'Id Paiement Paypal',
            'ID_PAYEUR' => 'Id Payeur',
            'DATE_PAIEMENT' => 'Date Paiement',
            'MONTANT' => 'Montant',
            'ID_TRANSACTION' => 'Id Transaction',
            'ID_FACTURE' => 'Id Facture',
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

        $criteria->compare('ID_PAIEMENT_PAYPAL',$this->ID_PAIEMENT_PAYPAL);
        $criteria->compare('ID_PAYEUR',$this->ID_PAYEUR,true);
        $criteria->compare('DATE_PAIEMENT',$this->DATE_PAIEMENT,true);
        $criteria->compare('MONTANT',$this->MONTANT,true);
        $criteria->compare('ID_TRANSACTION',$this->ID_TRANSACTION,true);
        $criteria->compare('ID_FACTURE',$this->ID_FACTURE);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
