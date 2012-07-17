<?php

/**
 * This is the model class for table "TARIF".
 *
 * The followings are the available columns in table 'TARIF':
 * @property integer $ID_TARIF
 * @property string $MONTANT
 * @property string $DATE_VERSEMENT
 * @property integer $NO_ENFANT
 * @property integer $RABAIS
 * @property integer $TOTAL
 *
 * The followings are the available model relations:
 * @property TVERSEMENT[] $tVERSEMENTs
 */
class Tarif extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Tarif the static model class
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
        return 'TARIF';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_TARIF, MONTANT, DATE_VERSEMENT, NO_ENFANT, RABAIS, TOTAL', 'required'),
            array('ID_TARIF, NO_ENFANT, RABAIS, TOTAL', 'numerical', 'integerOnly'=>true),
            array('MONTANT', 'length', 'max'=>10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_TARIF, MONTANT, DATE_VERSEMENT, NO_ENFANT, RABAIS, TOTAL', 'safe', 'on'=>'search'),
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
            'tarifVersements' => array(self::HAS_MANY, 'TVERSEMENT', 'ID_TARIF'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_TARIF' => 'Id Tarif',
            'MONTANT' => 'Montant',
            'DATE_VERSEMENT' => 'Date Versement',
            'NO_ENFANT' => 'No Enfant',
            'RABAIS' => 'Rabais',
            'TOTAL' => 'Total',
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

        $criteria->compare('ID_TARIF',$this->ID_TARIF);
        $criteria->compare('MONTANT',$this->MONTANT,true);
        $criteria->compare('DATE_VERSEMENT',$this->DATE_VERSEMENT,true);
        $criteria->compare('NO_ENFANT',$this->NO_ENFANT);
        $criteria->compare('RABAIS',$this->RABAIS);
        $criteria->compare('TOTAL',$this->TOTAL);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getDateVersement()
    {

        return strtotime( $this->DATE_VERSEMENT );

    }
}
