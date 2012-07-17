<?php

/**
 * This is the model class for table "CASE_A_COCHER".
 *
 * The followings are the available columns in table 'CASE_A_COCHER':
 * @property integer $ID_CASE_A_COCHER
 * @property string $NOM_CASE
 * @property string $DESCRIPTION
 * @property integer $ID_CAT_CASE
 *
 * The followings are the available model relations:
 * @property CategorieCase $iDCATCASE
 * @property FicheMedicale[] $ficheMedicales
 */
class CaseACocher extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return CaseACocher the static model class
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
        return 'CASE_A_COCHER';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('NOM_CASE, DESCRIPTION, ID_CAT_CASE', 'required'),
            array('ID_CAT_CASE', 'numerical', 'integerOnly'=>true),
            array('NOM_CASE', 'length', 'max'=>100),
            array('DESCRIPTION', 'length', 'max'=>300),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_CASE_A_COCHER, NOM_CASE, DESCRIPTION, ID_CAT_CASE', 'safe', 'on'=>'search'),
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
            'categorieCase' => array(self::BELONGS_TO, 'CategorieCase', 'ID_CAT_CASE'),
            'ficheMedicales' => array(self::MANY_MANY, 'FicheMedicale', 'reponse_case(ID_CASE_A_COCHER, ID_FICHE_MEDICALE)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_CASE_A_COCHER' => 'Id Case A Cocher',
            'NOM_CASE' => 'Nom Case',
            'DESCRIPTION' => 'Description',
            'ID_CAT_CASE' => 'Id Cat Case',
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

        $criteria->compare('ID_CASE_A_COCHER',$this->ID_CASE_A_COCHER);
        $criteria->compare('NOM_CASE',$this->NOM_CASE,true);
        $criteria->compare('DESCRIPTION',$this->DESCRIPTION,true);
        $criteria->compare('ID_CAT_CASE',$this->ID_CAT_CASE);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}