<?php

/**
 * This is the model class for table "TYPE_AUTORISATION".
 *
 * The followings are the available columns in table 'TYPE_AUTORISATION':
 * @property integer $ID_TYPE_AUTO
 * @property string $TITRE
 * @property string $DESCRIPTION
 *
 * The followings are the available model relations:
 * @property Scout[] $scouts
 */
class TypeAutorisation extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return TypeAutorisation the static model class
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
        return 'TYPE_AUTORISATION';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('TITRE, DESCRIPTION', 'required'),
            array('TITRE', 'length', 'max'=>100),
            array('DESCRIPTION', 'length', 'max'=>300),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_TYPE_AUTO, TITRE, DESCRIPTION', 'safe', 'on'=>'search'),
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
            'scouts' => array(self::MANY_MANY, 'Scout', 'autorisation(ID_TYPE_AUTO, ID_SCOUT)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_TYPE_AUTO' => 'Id Type Auto',
            'TITRE' => 'Titre',
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

        $criteria->compare('ID_TYPE_AUTO',$this->ID_TYPE_AUTO);
        $criteria->compare('TITRE',$this->TITRE,true);
        $criteria->compare('DESCRIPTION',$this->DESCRIPTION,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}