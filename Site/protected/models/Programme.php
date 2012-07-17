<?php

/**
 * This is the model class for table "PROGRAMME".
 *
 * The followings are the available columns in table 'PROGRAMME':
 * @property integer $ID_PROGRAMME
 * @property string $NOM_PROGRAMME
 * @property integer $AGE_MIN
 * @property integer $AGE_MAX
 *
 * The followings are the available model relations:
 * @property Unite[] $unites
 */
class Programme extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Programme the static model class
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
		return 'PROGRAMME';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('NOM_PROGRAMME, AGE_MIN, AGE_MAX', 'required'),
			array('AGE_MIN, AGE_MAX', 'numerical', 'integerOnly'=>true),
			array('NOM_PROGRAMME', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID_PROGRAMME, NOM_PROGRAMME, AGE_MIN, AGE_MAX', 'safe', 'on'=>'search'),
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
			'unites' => array(self::MANY_MANY, 'Unite', 'UNITE_PROGRAMME(ID_PROGRAMME, ID_UNITE)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_PROGRAMME' => 'Id Programme',
			'NOM_PROGRAMME' => 'Nom Programme',
			'AGE_MIN' => 'Age Min',
			'AGE_MAX' => 'Age Max',
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

		$criteria->compare('ID_PROGRAMME',$this->ID_PROGRAMME);
		$criteria->compare('NOM_PROGRAMME',$this->NOM_PROGRAMME,true);
		$criteria->compare('AGE_MIN',$this->AGE_MIN);
		$criteria->compare('AGE_MAX',$this->AGE_MAX);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}