<?php

/**
 * This is the model class for table "TYPE_IMPLICATION".
 *
 * The followings are the available columns in table 'TYPE_IMPLICATION':
 * @property integer $ID_TYPE_IMPLICATION
 * @property string $TITRE_IMPLICATION
 * @property string $DESCRIPTION
 *
 * The followings are the available model relations:
 * @property Adulte[] $adultes
 * @property Role[] $roles
 */
class TypeImplication extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return TypeImplication the static model class
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
        return 'TYPE_IMPLICATION';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('TITRE_IMPLICATION, DESCRIPTION', 'required'),
            array('TITRE_IMPLICATION', 'length', 'max'=>45),
            array('DESCRIPTION', 'length', 'max'=>300),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_TYPE_IMPLICATION, TITRE_IMPLICATION, DESCRIPTION', 'safe', 'on'=>'search'),
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
            'adultes' => array(self::MANY_MANY, 'Adulte', 'implication(ID_TYPE_IMPLICATION, ID_ADULTE)'),
            'roles' => array(self::MANY_MANY, 'Role', 'implication_role(ID_TYPE_IMPLICATION, ID_ROLE)'),
            'implications' => array( self::HAS_MANY, 'Implication', 'ID_TYPE_IMPLICATION' ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_TYPE_IMPLICATION' => 'Id Type Implication',
            'TITRE_IMPLICATION' => 'Titre Implication',
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

        $criteria->compare('ID_TYPE_IMPLICATION',$this->ID_TYPE_IMPLICATION);
        $criteria->compare('TITRE_IMPLICATION',$this->TITRE_IMPLICATION,true);
        $criteria->compare('DESCRIPTION',$this->DESCRIPTION,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
