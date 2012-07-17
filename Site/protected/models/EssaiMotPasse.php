<?php

/**
 * This is the model class for table "ESSAI_MOT_DE_PASSE".
 *
 * The followings are the available columns in table 'ESSAI_MOT_DE_PASSE':
 * @property integer $ID_ESSAI
 * @property string $DATE_ESSSAI
 * @property string $CLEF
 * @property integer $ID_ADULTE
 *
 * The followings are the available model relations:
 * @property ADULTE $iDADULTE
 */
class EssaiMotPasse extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return EssaiMotPasse the static model class
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
        return 'ESSAI_MOT_DE_PASSE';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('CLEF, ID_ADULTE', 'required'),
            array('ID_ADULTE', 'numerical', 'integerOnly'=>true),
            array('CLEF', 'length', 'max'=>256),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_ESSAI, DATE_ESSSAI, CLEF, ID_ADULTE', 'safe', 'on'=>'search'),
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
            'adulte' => array(self::BELONGS_TO, 'ADULTE', 'ID_ADULTE'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_ESSAI' => 'Id Essai',
            'DATE_ESSSAI' => 'Date Esssai',
            'CLEF' => 'Clef',
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

        $criteria->compare('ID_ESSAI',$this->ID_ESSAI);
        $criteria->compare('DATE_ESSSAI',$this->DATE_ESSSAI,true);
        $criteria->compare('CLEF',$this->CLEF,true);
        $criteria->compare('ID_ADULTE',$this->ID_ADULTE);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function beforeSave() {

        if( $this->isNewRecord ) {
            $this->DATE_ESSAI = new CDbExpression("NOW()");
        }

        return true;

    }

    public function genererClef()
    {

        $clefBrut = $this->ID_ESSAI . $this->ID_ADULTE . time() . rand();
        $clef = hash( "sha256",
            hash( "sha256",
                hash( "sha256", $clefBrut )
            )
        );

        $this->CLEF = $clef;

        return $clef;

    }

    public function envoyerCourriel()
    {

        $body = Yii::t( 'login', 'emailForget', array(
            '{url}' => Yii::app()->createAbsoluteUrl( 'login/reset', array( 'clef' => $this->CLEF ) ),
        ) );

        $from = Yii::app()->params['adminEmail'];
        $to = $this->adulte->COURRIEL;
        $subject = Yii::t( 'login', 'emailSubject' );

        Yii::app()->mail->sendSimple( $from, $to, $subject, $body, 'text/plain');

    }



}
