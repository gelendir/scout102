<?php

/**
 * This is the model class for table "TEXTE_FICHE_CHAMP".
 *
 * The followings are the available columns in table 'TEXTE_FICHE_CHAMP':
 * @property integer $ID_FICHE_MEDICALE
 * @property integer $ID_CAT_CHAMP_TEXTE
 * @property string $TEXTE
 */
class TexteFicheChamp extends CActiveRecord
{
    
    public $TEXTE = "";
    /**
     * Returns the static model of the specified AR class.
     * @return TexteFicheChamp the static model class
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
        return 'TEXTE_FICHE_CHAMP';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_FICHE_MEDICALE, ID_CAT_CHAMP_TEXTE', 'required'),
            array('ID_FICHE_MEDICALE, ID_CAT_CHAMP_TEXTE', 'numerical', 'integerOnly'=>true),
            array('TEXTE', 'length', 'max'=>400),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_FICHE_MEDICALE, ID_CAT_CHAMP_TEXTE, TEXTE', 'safe', 'on'=>'search'),
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
            'categorieChampTexte'=>array(self::BELONGS_TO, 'CategorieChampTexte', 'ID_CAT_CHAMP_TEXTE'),
            'ficheMedicale' => array(self::BELONGS_TO, 'FicheMedicale', 'ID_FICHE_MEDICALE')
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_FICHE_MEDICALE' => 'Id Fiche Medicale',
            'ID_CAT_CHAMP_TEXTE' => 'Id Cat Champ Texte',
            'TEXTE' => 'Texte',
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
        $criteria->compare('ID_CAT_CHAMP_TEXTE',$this->ID_CAT_CHAMP_TEXTE);
        $criteria->compare('TEXTE',$this->TEXTE,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
