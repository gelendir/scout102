<?php

/**
 * This is the model class for table "SESSION_PAYPAL".
 *
 * The followings are the available columns in table 'SESSION_PAYPAL':
 * @property integer $ID_SESSION_PAYPAL
 * @property string $DATE_CREATION
 * @property string $CLEF_SESSION
 * @property string $MONTANT
 * @property integer $ID_ADULTE
 *
 * The followings are the available model relations:
 * @property ADULTE $iDADULTE
 */
class SessionPaypal extends CActiveRecord
{

    static private $keyLength = 20;
    /**
     * Returns the static model of the specified AR class.
     * @return SessionPaypal the static model class
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
        return 'SESSION_PAYPAL';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('CLEF_SESSION, MONTANT, ID_ADULTE', 'required'),
            array('ID_ADULTE', 'numerical', 'integerOnly'=>true),
            array('CLEF_SESSION', 'length', 'max'=>45),
            array('MONTANT', 'length', 'max'=>4),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_SESSION_PAYPAL, DATE_CREATION, CLEF_SESSION, MONTANT, ID_ADULTE', 'safe', 'on'=>'search'),
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
            'iDADULTE' => array(self::BELONGS_TO, 'ADULTE', 'ID_ADULTE'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_SESSION_PAYPAL' => 'Id Session Paypal',
            'DATE_CREATION' => 'Date Creation',
            'CLEF_SESSION' => 'Clef Session',
            'MONTANT' => 'Montant',
            'ID_ADULTE' => 'Id Adulte',
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

        $criteria->compare('ID_SESSION_PAYPAL',$this->ID_SESSION_PAYPAL);
        $criteria->compare('DATE_CREATION',$this->DATE_CREATION,true);
        $criteria->compare('CLEF_SESSION',$this->CLEF_SESSION,true);
        $criteria->compare('MONTANT',$this->MONTANT,true);
        $criteria->compare('ID_ADULTE',$this->ID_ADULTE);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function beforeSave()
    {

        if( $this->isNewRecord ) {
            $this->DATE_CREATION = new CDbExpression("NOW()");
        }

        return true;

    }

    public function genererClef()
    {

        $clefBrut = $this->ID_ADULTE . $this->MONTANT . time();

        $clef = Util::encryptKey( $clefBrut . rand() );
        $clef = substr( $clef, 0, self::$keyLength );

        $count = self::model()->count(
            "CLEF_SESSION = :clefSession",
            array(
                'clefSession' => $clef,
            )
        );

        while( $count > 0 ) {

            $clef = Util::encryptKey( $clefBrut . rand() );
            $clef = substr( $clef, 0, self::$keyLength );

            $count = self::model()->count(
                "CLEF_SESSION = :clefSession",
                array(
                    'clefSession' => $clef,
                )
            );

        }

        $this->CLEF_SESSION = $clef;

    }


}
