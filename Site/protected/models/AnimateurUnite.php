<?php

/**
 * This is the model class for table "ANIMATEUR_UNITE".
 *
 * The followings are the available columns in table 'ANIMATEUR_UNITE':
 * @property integer $ID_ADULTE
 * @property integer $ID_UNITE
 */
class AnimateurUnite extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AnimateurUnite the static model class
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
		return 'ANIMATEUR_UNITE';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_ADULTE, ID_UNITE', 'required'),
			array('ID_ADULTE, ID_UNITE', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID_ADULTE, ID_UNITE', 'safe', 'on'=>'search'),
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
			'adulte'=>array(self::BELONGS_TO, 'Adulte', 'ID_ADULTE'),
			'unite'=>array(self::BELONGS_TO, 'Unite', 'ID_UNITE'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_ADULTE' => 'Id Adulte',
			'ID_UNITE' => 'Id Unite',
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

		$criteria->compare('ID_ADULTE',$this->ID_ADULTE);
		$criteria->compare('ID_UNITE',$this->ID_UNITE);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}