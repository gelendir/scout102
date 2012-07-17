<?php

/**
 * This is the model class for table "CATEGORIE_CHAMP_TEXTE".
 *
 * The followings are the available columns in table 'CATEGORIE_CHAMP_TEXTE':
 * @property integer $ID_CAT_CHAMP_TEXTE
 * @property string $TITRE
 * @property string $DESCTRIPTION
 *
 * The followings are the available model relations:
 * @property FicheMedicale[] $ficheMedicales
 */
class CategorieChampTexte extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return CategorieChampTexte the static model class
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
        return 'CATEGORIE_CHAMP_TEXTE';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('TITRE, DESCTRIPTION', 'required'),
            array('TITRE', 'length', 'max'=>100),
            array('DESCTRIPTION', 'length', 'max'=>300),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_CAT_CHAMP_TEXTE, TITRE, DESCTRIPTION', 'safe', 'on'=>'search'),
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
            'ficheMedicales' => array(self::MANY_MANY, 'FicheMedicale', 'texte_fiche_champ(ID_CAT_CHAMP_TEXTE, ID_FICHE_MEDICALE)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_CAT_CHAMP_TEXTE' => 'Id Cat Champ Texte',
            'TITRE' => 'Titre',
            'DESCTRIPTION' => 'Desctription',
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

        $criteria->compare('ID_CAT_CHAMP_TEXTE',$this->ID_CAT_CHAMP_TEXTE);
        $criteria->compare('TITRE',$this->TITRE,true);
        $criteria->compare('DESCTRIPTION',$this->DESCTRIPTION,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}