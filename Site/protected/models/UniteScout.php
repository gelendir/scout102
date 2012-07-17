<?php

/**
 * This is the model class for table "UNITE_SCOUT".
 *
 * The followings are the available columns in table 'UNITE_SCOUT':
 * @property integer $ID_UNITE
 * @property integer $ID_SCOUT
 */
class UniteScout extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UniteScout the static model class
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
		return 'UNITE_SCOUT';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_UNITE, ID_SCOUT', 'required'),
			array('ID_UNITE, ID_SCOUT', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID_UNITE, ID_SCOUT', 'safe', 'on'=>'search'),
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
			'scout'=>array(self::BELONGS_TO, 'Scout', 'ID_SCOUT'),
			'unite'=>array(self::BELONGS_TO, 'Unite', 'ID_UNITE'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_UNITE' => 'Id Unite',
			'ID_SCOUT' => 'Id Scout',
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

		$criteria->compare('ID_UNITE',$this->ID_UNITE);
		$criteria->compare('ID_SCOUT',$this->ID_SCOUT);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}