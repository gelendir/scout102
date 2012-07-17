<?php

/**
 * This is the model class for table "FAMILLE_ADULTE".
 *
 * The followings are the available columns in table 'FAMILLE_ADULTE':
 * @property integer $ID_FAMILLE
 * @property integer $ID_ADULTE
 */
class FamilleAdulte extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FamilleAdulte the static model class
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
		return 'FAMILLE_ADULTE';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_FAMILLE, ID_ADULTE', 'required'),
			array('ID_FAMILLE, ID_ADULTE', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID_FAMILLE, ID_ADULTE', 'safe', 'on'=>'search'),
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
            'famille' => array( self::BELONGS_TO, 'Famille', 'ID_FAMILLE' ),
            'adulte' => array( self::BELONGS_TO, 'Adulte', 'ID_ADULTE' ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_FAMILLE' => 'Id Famille',
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

		$criteria->compare('ID_FAMILLE',$this->ID_FAMILLE);
		$criteria->compare('ID_ADULTE',$this->ID_ADULTE);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
