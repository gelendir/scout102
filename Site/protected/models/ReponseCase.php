<?php

/**
 * This is the model class for table "REPONSE_CASE".
 *
 * The followings are the available columns in table 'REPONSE_CASE':
 * @property integer $ID_FICHE_MEDICALE
 * @property integer $ID_CASE_A_COCHER
 * @property integer $REPONSE
 */
class ReponseCase extends CActiveRecord
{
    public $REPONSE = null;
    /**
     * Returns the static model of the specified AR class.
     * @return ReponseCase the static model class
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
        return 'REPONSE_CASE';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_FICHE_MEDICALE, ID_CASE_A_COCHER', 'required'),
            array('ID_FICHE_MEDICALE, ID_CASE_A_COCHER, REPONSE', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_FICHE_MEDICALE, ID_CASE_A_COCHER, REPONSE', 'safe', 'on'=>'search'),
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
            'caseACocher'=>array(self::BELONGS_TO, 'CaseACocher', 'ID_CASE_A_COCHER'),
            'ficheMedicale'=>array(self::BELONGS_TO, 'FicheMedicale', 'ID_FICHE_MEDICALE')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_FICHE_MEDICALE' => 'Id Fiche Medicale',
            'ID_CASE_A_COCHER' => 'Id Case A Cocher',
            'REPONSE' => 'Reponse',
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

        $criteria->compare('ID_FICHE_MEDICALE',$this->ID_FICHE_MEDICALE);
        $criteria->compare('ID_CASE_A_COCHER',$this->ID_CASE_A_COCHER);
        $criteria->compare('REPONSE',$this->REPONSE);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}