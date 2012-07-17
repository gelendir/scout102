<?php

/**
 * This is the model class for table "T_VERSEMENT".
 *
 * The followings are the available columns in table 'T_VERSEMENT':
 * @property integer $ID_VERSEMENT
 * @property integer $ID_SCOUT
 * @property integer $ID_FAMILLE
 * @property integer $ID_TARIF
 * @property integer $ETAT
 *
 * The followings are the available model relations:
 * @property FAMILLESCOUT $iDENFANT
 * @property FAMILLESCOUT $iDFAMILLE
 * @property TARIF $iDTARIF
 * @property FACTURE[] $fACTUREs
 */
class TarifVersement extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return TarifVersement the static model class
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
        return 'T_VERSEMENT';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_SCOUT, ID_FAMILLE, ID_TARIF, ETAT', 'required'),
            array('ID_VERSEMENT, ID_SCOUT, ID_FAMILLE, ID_TARIF, ETAT', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_VERSEMENT, ID_SCOUT, ID_FAMILLE, ID_TARIF, ETAT', 'safe', 'on'=>'search'),
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
            'famille' => array(self::BELONGS_TO, 'Famille', 'ID_FAMILLE'),
            'tarif' => array(self::BELONGS_TO, 'Tarif', 'ID_TARIF'),
            'factures' => array(self::MANY_MANY, 'Facture', 'VERSEMENT_FACTURE(ID_VERSEMENT, ID_FACTURE)'),
        );
    }

    public function getFamilleScout()
    {

        return FamilleScout::model() ->findByAttributes(
            array(
                'ID_FAMILLE' => $this->ID_FAMILLE,
                'ID_SCOUT' => $this->ID_SCOUT,
            )
        );

    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_VERSEMENT' => 'Id Versement',
            'ID_SCOUT' => 'Id Enfant',
            'ID_FAMILLE' => 'Id Famille',
            'ID_TARIF' => 'Id Tarif',
            'ETAT' => 'Etat',
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

        $criteria->compare('ID_VERSEMENT',$this->ID_VERSEMENT);
        $criteria->compare('ID_SCOUT',$this->ID_SCOUT);
        $criteria->compare('ID_FAMILLE',$this->ID_FAMILLE);
        $criteria->compare('ID_TARIF',$this->ID_TARIF);
        $criteria->compare('ETAT',$this->ETAT);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
