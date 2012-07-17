<?php

/**
 * This is the model class for table "UNITE".
 *
 * The followings are the available columns in table 'UNITE':
 * @property integer $ID_UNITE
 * @property string $NOM_UNITE
 * @property string $DATE_CREATION
 *
 * The followings are the available model relations:
 * @property ADULTE[] $aDULTEs
 * @property PROGRAMME[] $pROGRAMMEs
 * @property SCOUT[] $sCOUTs
 */
class Unite extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Unite the static model class
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
        return 'UNITE';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('NOM_UNITE, ID_PROGRAMME', 'required'),
            array('NOM_UNITE', 'length', 'max'=>40),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_UNITE, ID_PROGRAMME, NOM_UNITE, DATE_CREATION', 'safe', 'on'=>'search'),
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
            'animateurs' => array(self::MANY_MANY, 'Adulte', 'ANIMATEUR_UNITE(ID_UNITE, ID_ADULTE)'),
            'programme' => array(self::BELONGS_TO, 'Programme', 'ID_PROGRAMME'),
            'scouts' => array(self::MANY_MANY, 'Scout', 'UNITE_SCOUT(ID_UNITE, ID_SCOUT)'),
            'uniteScouts' => array( self::HAS_MANY, 'UniteScout', 'ID_UNITE' ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_UNITE' => 'Id Unité',
            'NOM_UNITE' => 'Nom Unité',
            'DATE_CREATION' => 'Date Création',
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
        $criteria->compare('NOM_UNITE',$this->NOM_UNITE,true);
        $criteria->compare('DATE_CREATION',$this->DATE_CREATION,true);

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

    public function getNbScouts()
    {

        return UniteScout::model()->count(
            "ID_UNITE = :idUnite",
            array(
                'idUnite' => $this->ID_UNITE,
            )
        );

    }

    public function getAnnee()
    {
        return date("Y", Util::parseDbDate( $this->DATE_CREATION ) );
    }

    public function scoutsDisponibles()
    {

        $condition = 'ID_SCOUT NOT IN (SELECT ID_SCOUT FROM UNITE_SCOUT)';
        $params = array();

        if( isset( $this->programme ) ) {

            $tsDateMin = time() - ( $this->programme->AGE_MIN - 1 ) * 365 * 24 * 60 * 60;
            $tsDateMax = time() - ( $this->programme->AGE_MAX + 1 ) * 365 * 24 * 60 * 60;

            $dateMin = Util::formatDbDate( $tsDateMin );
            $dateMax = Util::formatDbDate( $tsDateMax );

            $condition .= " AND DATE_NAISSANCE BETWEEN :dateMax AND :dateMin";
            $params['dateMin'] = $dateMin;
            $params['dateMax'] = $dateMax;

        }

        $scouts = Scout::model()->findAll( $condition, $params );

        return $scouts;

    }

    public function animateurDisponibles()
    {

        $nomImplAnimateur = "Animation";

        $sql = "t.ID_ADULTE IN (
                SELECT ADULTE.ID_ADULTE
                FROM ADULTE
                JOIN IMPLICATION ON IMPLICATION.ID_ADULTE = ADULTE.ID_ADULTE
                JOIN TYPE_IMPLICATION ON TYPE_IMPLICATION.ID_TYPE_IMPLICATION = IMPLICATION.ID_TYPE_IMPLICATION
                WHERE TYPE_IMPLICATION.TITRE_IMPLICATION = :animateur
                AND IMPLICATION.ACCORDE = TRUE
            )
            ";

        $params = array(
            'animateur' => $nomImplAnimateur,
        );

        $animateurs = Adulte::model()
            ->findAll( $sql, $params );

        return $animateurs;
    }

}
