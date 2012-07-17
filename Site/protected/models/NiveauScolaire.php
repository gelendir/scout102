<?php

/**
 * This is the model class for table "NIVEAU_SCOLAIRE".
 *
 * The followings are the available columns in table 'NIVEAU_SCOLAIRE':
 * @property integer $ID_NIVEAU_SCOLAIRE
 * @property string $DESCRIPTION_NIVEAU
 *
 * The followings are the available model relations:
 * @property SCOLARITE[] $sCOLARITEs
 */
class NiveauScolaire extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return NiveauScolaire the static model class
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
		return 'NIVEAU_SCOLAIRE';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_NIVEAU_SCOLAIRE, DESCRIPTION_NIVEAU', 'required'),
			array('ID_NIVEAU_SCOLAIRE', 'numerical', 'integerOnly'=>true),
			array('DESCRIPTION_NIVEAU', 'length', 'max'=>70),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID_NIVEAU_SCOLAIRE, DESCRIPTION_NIVEAU', 'safe', 'on'=>'search'),
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
			'sCOLARITEs' => array(self::HAS_MANY, 'SCOLARITE', 'ID_NIVEAU'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_NIVEAU_SCOLAIRE' => 'Id Niveau Scolaire',
			'DESCRIPTION_NIVEAU' => 'Description Niveau',
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

		$criteria->compare('ID_NIVEAU_SCOLAIRE',$this->ID_NIVEAU_SCOLAIRE);
		$criteria->compare('DESCRIPTION_NIVEAU',$this->DESCRIPTION_NIVEAU,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}