<?php

/**
 * This is the model class for table "VERSEMENT_FACTURE".
 *
 * The followings are the available columns in table 'VERSEMENT_FACTURE':
 * @property integer $ID_FACTURE
 * @property integer $ID_VERSEMENT
 */
class VersementFacture extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return VersementFacture the static model class
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
        return 'VERSEMENT_FACTURE';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_FACTURE, ID_VERSEMENT', 'required'),
            array('ID_FACTURE, ID_VERSEMENT', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_FACTURE, ID_VERSEMENT', 'safe', 'on'=>'search'),
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
            'facture' => array( self::BELONGS_TO, 'Facture', 'ID_FACTURE' ),
            'versement' => array( self::BELONGS_TO, 'TarifVersement', 'ID_VERSEMENT' ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_FACTURE' => 'Id Facture',
            'ID_VERSEMENT' => 'Id Versement',
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
        $criteria->compare('ID_VERSEMENT',$this->ID_VERSEMENT);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
