<?php

/**
 * This is the model class for table "NOTIFICATION".
 *
 * The followings are the available columns in table 'NOTIFICATION':
 * @property integer $ID_NOTIFICATION
 * @property string $TITRE
 * @property string $MESSAGE
 * @property string $DATE_ENVOIE
 * @property integer $LU
 * @property integer $IMPORTANT
 * @property string $DATE_LU
 *
 * The followings are the available model relations:
 * @property RoleNotification[] $roleNotifications
 */
class Notification extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Notification the static model class
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
		return 'NOTIFICATION';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('LU, IMPORTANT', 'numerical', 'integerOnly'=>true),
			array('TITRE', 'length', 'max'=>45),
			array('MESSAGE, DATE_ENVOIE, DATE_LU', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID_NOTIFICATION, TITRE, MESSAGE, DATE_ENVOIE, LU, IMPORTANT, DATE_LU', 'safe', 'on'=>'search'),
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
			'roleNotifications' => array(self::HAS_MANY, 'RoleNotification', 'ID_NOTIFICATION'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_NOTIFICATION' => 'Id Notification',
			'TITRE' => 'Titre',
			'MESSAGE' => 'Message',
			'DATE_ENVOIE' => 'Date Envoie',
			'LU' => 'Lu',
			'IMPORTANT' => 'Important',
			'DATE_LU' => 'Date Lu',
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

		$criteria->compare('ID_NOTIFICATION',$this->ID_NOTIFICATION);
		$criteria->compare('TITRE',$this->TITRE,true);
		$criteria->compare('MESSAGE',$this->MESSAGE,true);
		$criteria->compare('DATE_ENVOIE',$this->DATE_ENVOIE,true);
		$criteria->compare('LU',$this->LU);
		$criteria->compare('IMPORTANT',$this->IMPORTANT);
		$criteria->compare('DATE_LU',$this->DATE_LU,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}