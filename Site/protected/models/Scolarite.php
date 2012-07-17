<?php

/**
 * This is the model class for table "SCOLARITE".
 *
 * The followings are the available columns in table 'SCOLARITE':
 * @property integer $ID_SCOLARITE
 * @property integer $ID_SCOUT
 * @property integer $ID_NIVEAU
 * @property string $NOM_ECOLE
 * @property string $NOM_ENSEIGNANT
 *
 * The followings are the available model relations:
 * @property Scout $iDSCOUT
 * @property NiveauScolaire $iDNIVEAU
 */
class Scolarite extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Scolarite the static model class
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
        return 'SCOLARITE';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_SCOUT', 'required', 'on' => 'fiche'),
            array('ID_NIVEAU, NOM_ECOLE, NOM_ENSEIGNANT', 'required'),
            array('ID_SCOUT, ID_NIVEAU', 'numerical', 'integerOnly'=>true),
            array('NOM_ECOLE', 'length', 'max'=>45),
            array('NOM_ENSEIGNANT', 'length', 'max'=>90),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_SCOLARITE, ID_SCOUT, ID_NIVEAU, NOM_ECOLE, NOM_ENSEIGNANT', 'safe', 'on'=>'search'),
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
            'scout' => array(self::BELONGS_TO, 'Scout', 'ID_SCOUT'),
            'niveauScolaire' => array(self::BELONGS_TO, 'NiveauScolaire', 'ID_NIVEAU'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_SCOLARITE' => 'Id Scolarite',
            'ID_SCOUT' => 'Id Scout',
            'ID_NIVEAU' => 'Id Niveau',
            'NOM_ECOLE' => 'Nom Ecole',
            'NOM_ENSEIGNANT' => 'Nom Enseignant',
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

        $criteria->compare('ID_SCOLARITE',$this->ID_SCOLARITE);
        $criteria->compare('ID_SCOUT',$this->ID_SCOUT);
        $criteria->compare('ID_NIVEAU',$this->ID_NIVEAU);
        $criteria->compare('NOM_ECOLE',$this->NOM_ECOLE,true);
        $criteria->compare('NOM_ENSEIGNANT',$this->NOM_ENSEIGNANT,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
