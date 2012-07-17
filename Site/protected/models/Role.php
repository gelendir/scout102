<?php

/**
 * This is the model class for table "ROLE".
 *
 * The followings are the available columns in table 'ROLE':
 * @property integer $ID_ROLE
 * @property string $NOM_ROLE
 * @property string $DESCRIPTION
 *
 * The followings are the available model relations:
 * @property TYPEIMPLICATION[] $tYPEIMPLICATIONs
 */
class Role extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Role the static model class
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
        return 'ROLE';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('NOM_ROLE, DESCRIPTION', 'required'),
            array('NOM_ROLE', 'length', 'max'=>45),
            array('DESCRIPTION', 'length', 'max'=>300),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_ROLE, NOM_ROLE, DESCRIPTION', 'safe', 'on'=>'search'),
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
            'typeImplications' => array(self::MANY_MANY, 'TypeImplication', 'IMPLICATION_ROLE(ID_ROLE, ID_TYPE_IMPLICATION)'),
            'implicationRoles' => array( self::HAS_MANY, 'ImplicationRole', 'ID_ROLE' ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_ROLE' => 'Id Role',
            'NOM_ROLE' => 'Nom Role',
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

        $criteria->compare('ID_ROLE',$this->ID_ROLE);
        $criteria->compare('NOM_ROLE',$this->NOM_ROLE,true);
        $criteria->compare('DESCRIPTION',$this->DESCRIPTION,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
