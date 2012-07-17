<?php

/**
 * This is the model class for table "MODE_PAIEMENT".
 *
 * The followings are the available columns in table 'MODE_PAIEMENT':
 * @property integer $ID_MODE_PAIEMENT
 * @property string $NOM_MODE
 * @property string $DESCRIPTION
 *
 * The followings are the available model relations:
 * @property FACTURE[] $fACTUREs
 */
class ModePaiement extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return ModePaiement the static model class
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
        return 'MODE_PAIEMENT';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_MODE_PAIEMENT, NOM_MODE, DESCRIPTION', 'required'),
            array('ID_MODE_PAIEMENT', 'numerical', 'integerOnly'=>true),
            array('NOM_MODE, DESCRIPTION', 'length', 'max'=>45),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_MODE_PAIEMENT, NOM_MODE, DESCRIPTION', 'safe', 'on'=>'search'),
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
            'factures' => array(self::HAS_MANY, 'FACTURE', 'ID_MODE_PAIEMENT'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_MODE_PAIEMENT' => 'Id Mode Paiement',
            'NOM_MODE' => 'Nom Mode',
            'DESCRIPTION' => 'Description',
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

        $criteria->compare('ID_MODE_PAIEMENT',$this->ID_MODE_PAIEMENT);
        $criteria->compare('NOM_MODE',$this->NOM_MODE,true);
        $criteria->compare('DESCRIPTION',$this->DESCRIPTION,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
