<?php

/**
 * This is the model class for table "ADRESSE".
 *
 * The followings are the available columns in table 'ADRESSE':
 * @property integer $ID_ADRESSE
 * @property string $ADRESSE_RUE
 * @property string $VILLE
 * @property string $PROVINCE
 * @property string $CODE_POSTAL
 *
 * The followings are the available model relations:
 * @property FAMILLE[] $fAMILLEs
 * @property ADULTE[] $aDULTEs
 * @property SCOUT[] $sCOUTs
 */
class Adresse extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Adresse the static model class
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
        return 'ADRESSE';
    }

    public function getAdresseComplete() {
        return $this->ADRESSE_RUE
            . ', ' . $this->VILLE
            . ', ' . strtoupper( $this->PROVINCE )
            . ', ' . $this->codePostal;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ADRESSE_RUE, VILLE, PROVINCE, codePostal', 'required'),
            array('ADRESSE_RUE', 'length', 'max'=>90),
            array('VILLE, PROVINCE', 'length', 'max'=>45),
            array('CODE_POSTAL', 'length', 'max'=>6),
            array('codePostal', 'match', 'pattern' => '/[g-zG-Z]\d[a-zA-Z] ?\d[a-zA-Z]\d/'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_ADRESSE, ADRESSE_RUE, VILLE, PROVINCE, CODE_POSTAL', 'safe', 'on'=>'search'),
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
            'familles' => array(self::MANY_MANY, 'FAMILLE', 'ADRESSE_FAMILLE(ID_ADRESSE, ID_FAMILLE)'),
            'adultes' => array(self::HAS_MANY, 'ADULTE', 'ID_ADRESSE_PRINC'),
            'scouts' => array(self::HAS_MANY, 'SCOUT', 'ID_ADRESSE_PRINC'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_ADRESSE' => 'Id Adresse',
            'ADRESSE_RUE' => 'Adresse',
            'VILLE' => 'Ville',
            'PROVINCE' => 'Province',
            'CODE_POSTAL' => 'Code postal',
        );
    }

    public function attributeMasks()
    {

        return array(
            'CODE_POSTAL' => 'G1G 1G1'
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

        $criteria->compare('ID_ADRESSE',$this->ID_ADRESSE);
        $criteria->compare('ADRESSE_RUE',$this->ADRESSE_RUE,true);
        $criteria->compare('VILLE',$this->VILLE,true);
        $criteria->compare('PROVINCE',$this->PROVINCE,true);
        $criteria->compare('CODE_POSTAL',$this->CODE_POSTAL,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getCodePostal() 
    {

        return trim( substr( $this->CODE_POSTAL, 0, 3 ) . " " . substr( $this->CODE_POSTAL, 3 ) );

    }

    public function setCodePostal( $codePostal )
    {

        $this->CODE_POSTAL = trim( strtoupper( str_replace( " ", "", $codePostal ) ) );

    }

}
