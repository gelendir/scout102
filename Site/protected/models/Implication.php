<?php

/**
 * This is the model class for table "IMPLICATION".
 *
 * The followings are the available columns in table 'IMPLICATION':
 * @property integer $ID_TYPE_IMPLICATION
 * @property integer $ID_ADULTE
 * @property integer $ACCORDE
 */
class Implication extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Implication the static model class
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
        return 'IMPLICATION';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_TYPE_IMPLICATION, ID_ADULTE', 'required'),
            array('ID_TYPE_IMPLICATION, ID_ADULTE, ACCORDE', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_TYPE_IMPLICATION, ID_ADULTE, ACCORDE', 'safe', 'on'=>'search'),
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
            'typeImplication' => array(self::BELONGS_TO, 'TypeImplication', 'ID_TYPE_IMPLICATION')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_TYPE_IMPLICATION' => 'Id Type Implication',
            'ID_ADULTE' => 'Id Adulte',
            'ACCORDE' => 'Accorde',
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

        $criteria->compare('ID_TYPE_IMPLICATION',$this->ID_TYPE_IMPLICATION);
        $criteria->compare('ID_ADULTE',$this->ID_ADULTE);
        $criteria->compare('ACCORDE',$this->ACCORDE);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
