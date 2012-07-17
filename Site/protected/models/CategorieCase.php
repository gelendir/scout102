<?php

/**
 * This is the model class for table "CATEGORIE_CASE".
 *
 * The followings are the available columns in table 'CATEGORIE_CASE':
 * @property integer $ID_CAT_CASE
 * @property string $NOM
 * @property string $DESCRIPTION
 * @property integer $TYPE_INPUT
 *
 * The followings are the available model relations:
 * @property CaseACocher[] $caseACochers
 */
class CategorieCase extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return CategorieCase the static model class
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
        return 'CATEGORIE_CASE';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('NOM, DESCRIPTION, TYPE_INPUT', 'required'),
            array('TYPE_INPUT', 'numerical', 'integerOnly'=>true),
            array('NOM', 'length', 'max'=>100),
            array('DESCRIPTION', 'length', 'max'=>300),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_CAT_CASE, NOM, DESCRIPTION, TYPE_INPUT', 'safe', 'on'=>'search'),
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
            'caseACochers' => array(self::HAS_MANY, 'CaseACocher', 'ID_CAT_CASE'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_CAT_CASE' => 'Id Cat Case',
            'NOM' => 'Nom',
            'DESCRIPTION' => 'Description',
            'TYPE_INPUT' => 'Type Input',
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

        $criteria->compare('ID_CAT_CASE',$this->ID_CAT_CASE);
        $criteria->compare('NOM',$this->NOM,true);
        $criteria->compare('DESCRIPTION',$this->DESCRIPTION,true);
        $criteria->compare('TYPE_INPUT',$this->TYPE_INPUT);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}