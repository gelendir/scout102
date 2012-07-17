<?php

/**
 * This is the model class for table "ROLE_NOTIFICATION".
 *
 * The followings are the available columns in table 'ROLE_NOTIFICATION':
 * @property integer $ID_ROLE
 * @property integer $ID_NOTIFICATION
 * @property integer $ID_ROLE_NOTIFICATION
 *
 * The followings are the available model relations:
 * @property Role $iDROLE
 * @property Notification $iDNOTIFICATION
 */
class RoleNotification extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RoleNotification the static model class
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
		return 'ROLE_NOTIFICATION';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_ROLE, ID_NOTIFICATION', 'required'),
			array('ID_ROLE, ID_NOTIFICATION', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID_ROLE, ID_NOTIFICATION, ID_ROLE_NOTIFICATION', 'safe', 'on'=>'search'),
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
			'iDROLE' => array(self::BELONGS_TO, 'Role', 'ID_ROLE'),
			'iDNOTIFICATION' => array(self::BELONGS_TO, 'Notification', 'ID_NOTIFICATION'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_ROLE' => 'Id Role',
			'ID_NOTIFICATION' => 'Id Notification',
			'ID_ROLE_NOTIFICATION' => 'Id Role Notification',
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

		$criteria->compare('ID_ROLE',$this->ID_ROLE);
		$criteria->compare('ID_NOTIFICATION',$this->ID_NOTIFICATION);
		$criteria->compare('ID_ROLE_NOTIFICATION',$this->ID_ROLE_NOTIFICATION);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}