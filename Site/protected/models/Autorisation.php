<?php

/**
 * This is the model class for table "AUTORISATION".
 *
 * The followings are the available columns in table 'AUTORISATION':
 * @property integer $ID_SCOUT
 * @property integer $ID_TYPE_AUTO
 * @property integer $ACCEPTATION
 */
class Autorisation extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Autorisation the static model class
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
        return 'AUTORISATION';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_SCOUT', 'required'),
            array('ID_SCOUT, ID_TYPE_AUTO, ACCEPTATION', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_SCOUT, ID_TYPE_AUTO, ACCEPTATION', 'safe', 'on'=>'search'),
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
            'typeAutorisation' => array( self::BELONGS_TO, 'TypeAutorisation', 'ID_TYPE_AUTO' ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_SCOUT' => 'Id Scout',
            'ID_TYPE_AUTO' => 'Id Type Auto',
            'ACCEPTATION' => 'Acceptation',
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

        $criteria->compare('ID_SCOUT',$this->ID_SCOUT);
        $criteria->compare('ID_TYPE_AUTO',$this->ID_TYPE_AUTO);
        $criteria->compare('ACCEPTATION',$this->ACCEPTATION);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
