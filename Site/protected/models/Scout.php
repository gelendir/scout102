<?php

/**
 * This is the model class for table "SCOUT".
 *
 * The followings are the available columns in table 'SCOUT':
 * @property integer $ID_SCOUT
 * @property string $PRENOM
 * @property string $NOM
 * @property string $DATE_NAISSANCE
 * @property string $SEXE
 * @property string $NO_ASSURANCE_MALADIE
 * @property string $DATE_FIN_CARTE_MEDICAL
 * @property string $PARTICULARITE
 * @property integer $ID_ADRESSE_PRINC
 * @property string $CONT_URG_NOM
 * @property string $CONT_URG_NO_TEL
 * @property string $CONT_URG_LIEN_JEUNE
 * @property string $CONT_URG_PRENOM
 */
class Scout extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Scout the static model class
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
        return 'SCOUT';
    }

    public function famille( $idFamille )
    {

        $this->getDbCriteria()->mergeWith(
            array(
                'join' => 'INNER JOIN FAMILLE_SCOUT ON FAMILLE_SCOUT.ID_SCOUT = t.ID_SCOUT',
                'condition' => 'FAMILLE_SCOUT.ID_FAMILLE = :idFamille',
                'params' => array(
                    'idFamille' => $idFamille,
                ),
            )
        );

        return $this;

    }

    public function scopes()
    {


        return array(
        );

    }

    public function defaultScope()
    {

        $alias = $this->getTableAlias(false, false);

        return array(
            'condition' => $alias.'.ACTIF = TRUE',
            'order'     => $alias.'.ID_SCOUT ASC',
        );

    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('PRENOM, NOM, dateNaissance, SEXE, NO_ASSURANCE_MALADIE, dateFinCarteMedicale, ID_ADRESSE_PRINC, CONT_URG_NOM, CONT_URG_NO_TEL, CONT_URG_LIEN_JEUNE, CONT_URG_PRENOM', 'required'),
            array('ID_ADRESSE_PRINC', 'numerical', 'integerOnly'=>true),
            array('PRENOM, NOM, CONT_URG_NOM, CONT_URG_LIEN_JEUNE, CONT_URG_PRENOM', 'length', 'max'=>45),
            array('SEXE', 'length', 'max'=>1),
            array('NO_ASSURANCE_MALADIE', 'length', 'max'=>12),
            array('PARTICULARITE', 'length', 'max'=>300),
            array('CONT_URG_NO_TEL', 'length', 'max'=>20),
            array('dateNaissance', 'date', 'format'=>'dd/mm/yyyy'),
            array('NO_ASSURANCE_MALADIE', 'match', 'pattern'=>'/[A-Z]{4}\d{8}/'),
            array('dateFinCarteMedicale', 'date', 'format'=>'yyyy/mm'),
            array('dateNaissance, dateFinCarteMedicale', 'safe'),
            array('CONT_URG_NO_TEL', 'match', 'pattern'=>'/[0-9]{3}-[0-9]{3}-[0-9]{4}( #[0-9]+)?/'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_SCOUT, PRENOM, NOM, DATE_NAISSANCE, SEXE, NO_ASSURANCE_MALADIE, DATE_FIN_CARTE_MEDICAL, PARTICULARITE, ID_ADRESSE_PRINC, CONT_URG_NOM, CONT_URG_NO_TEL, CONT_URG_LIEN_JEUNE, CONT_URG_PRENOM', 'safe', 'on'=>'search'),
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
            'autorisations' => array( self::HAS_MANY, 'Autorisation', 'ID_SCOUT' ),
            'recuImpot' => array( self::HAS_ONE, 'RecuImpot', 'ID_SCOUT' ),
            'familleScout' => array( self::HAS_ONE, 'FamilleScout', 'ID_SCOUT' ),
            'ficheMedicale' => array( self::HAS_ONE, 'FicheMedicale', 'ID_SCOUT' ),
			'scolarite' => array( self::HAS_ONE, 'Scolarite', 'ID_SCOUT' ),
			'adresse' => array( self::BELONGS_TO, 'Adresse', 'ID_ADRESSE_PRINC' ),
        );
    }

    public function getIdFamille()
    {

        return $this->familleScout->ID_FAMILLE;

    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_SCOUT' => 'Id Scout',
            'PRENOM' => 'Prénom',
            'NOM' => 'Nom',
            'SEXE' => 'Sexe',
            'DATE_NAISSANCE' => 'Date de naissance',
            'dateNaissance' => 'Date de naissance',
            'NO_ASSURANCE_MALADIE' => 'No. Assurance Maladie',
            'DATE_FIN_CARTE_MEDICAL' => "Date d'expiration",
            'dateFinCarteMeidcal' => "Date d'expiration",
            'PARTICULARITE' => 'Particularités',
            'ID_ADRESSE_PRINC' => 'Adresse principale',
            'CONT_URG_NOM' => "Nom du contact d'urgence",
            'CONT_URG_PRENOM' => "Prénom du contact d'urgence",
            'CONT_URG_NO_TEL' => 'No. Téléphone',
            'CONT_URG_LIEN_JEUNE' => 'Lien jeune',
        );
    }

    public function attributeMasks() {

        return array(
            'NOM' => 'Nom',
            'PRENOM' => 'Prénom',
            'CONT_URG_NOM' => 'Nom',
            'CONT_URG_PRENOM' => 'Prénom',
            'CONT_URG_LIEN_JEUNE' => 'Oncle, Marraine, Ami, etc',
            'CONT_URG_NO_TEL' => '418-555-1845 #123',
            'NO_ASSURANCE_MALADIE' => 'ABCD12345678',
            'DATE_FIN_CARTE_MEDICAL' => "2011/01 (date d'expiration)",
            'DATE_NAISSANCE' => '24/02/1990',
            'dateFinCarteMedicale' => "2011/01 (date d'expiration)",
            'dateNaissance' => '24/02/1990',
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

        $criteria->compare('ID_SCOUT',$this->ID_SCOUT);
        $criteria->compare('PRENOM',$this->PRENOM,true); $criteria->compare('NOM',$this->NOM,true);
        $criteria->compare('DATE_NAISSANCE',$this->DATE_NAISSANCE,true);
        $criteria->compare('SEXE',$this->SEXE,true);
        $criteria->compare('NO_ASSURANCE_MALADIE',$this->NO_ASSURANCE_MALADIE,true);
        $criteria->compare('DATE_FIN_CARTE_MEDICAL',$this->DATE_FIN_CARTE_MEDICAL,true);
        $criteria->compare('PARTICULARITE',$this->PARTICULARITE,true);
        $criteria->compare('ID_ADRESSE_PRINC',$this->ID_ADRESSE_PRINC);
        $criteria->compare('CONT_URG_NOM',$this->CONT_URG_NOM,true);
        $criteria->compare('CONT_URG_NO_TEL',$this->CONT_URG_NO_TEL,true);
        $criteria->compare('CONT_URG_LIEN_JEUNE',$this->CONT_URG_LIEN_JEUNE,true);
        $criteria->compare('CONT_URG_PRENOM',$this->CONT_URG_PRENOM,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function beforeSave()
    {

        if( $this->isNewRecord ) {

            $this->ANNEE_INSCRIPTION = (int)date("Y");

        }

        return true;

    }

    public function genererAutorisations()
    {
        $autorisations = array();

        foreach( TypeAutorisation::model()->findAll() as $typeAutorisation )
        {

            $autorisation = new Autorisation;
            $autorisation->typeAutorisation = $typeAutorisation;
            $autorisations[] = $autorisation;
        }

        $this->autorisations = $autorisations;
    }


    public function getNomComplet() {

        return trim( $this->PRENOM . " " . $this->NOM );

    }

    public function getDateNaissance()
    {

        if( $this->DATE_NAISSANCE === null ) {
            return "";
        }

        $dbDate = Util::parseDbDate( $this->DATE_NAISSANCE );
        return Util::formatDate( $dbDate );

    }

    public function setDateNaissance( $dateNaissance )
    {
	

        if( trim( $dateNaissance ) != "" ) {

            $timestamp = Util::parseDate( $dateNaissance );
            $dbDate = Util::formatDbDate( $timestamp );
            $this->DATE_NAISSANCE = $dbDate;
        }
    }

    public function getDateFinCarteMedicale()
    {
        if( $this->DATE_FIN_CARTE_MEDICAL === null ) {
            return "";
        }

        $format = Yii::app()->params['dateFormatMedicalCard'];
        $dbDate = $this->DATE_FIN_CARTE_MEDICAL;

        return Util::formatDate( 
            Util::parseDbDate( $dbDate ),
            $format
        );

    }

    public function setDateFinCarteMedicale( $finCarteMedicale )
    {

        if( trim( $finCarteMedicale ) != "" ) {
            $format = Yii::app()->params['dateFormatMedicalCard'];
            $timestamp = Util::parseDate( $finCarteMedicale, $format );
            $dbDate = Util::formatDbDate( $timestamp );
            $this->DATE_FIN_CARTE_MEDICAL = $dbDate;
        }
    }

    public function getNbScoutsFamille() {

        $nbScouts = $this->model()
            ->with('familleScout')
            ->count(
                "familleScout.ID_FAMILLE = :idFamille",
                array(
                    'idFamille' => $this->familleScout->ID_FAMILLE,
                )
            );

        return $nbScouts;

    }

    private function criteresPourVersements() 
    {

        $critere = TarifVersement::model()
            ->with('tarif')
            ->with('scout');

        return $critere;

    }

    private function paramsPourVersements( $debutSession, $finSession, $autreConditions = array(), $autreValeurs = array() ) 
    {

        $nbScouts = $this->nbScoutsFamille;

        $conditions = array_merge(
            array(
                't.ID_FAMILLE = :idFamille',
                't.ID_SCOUT = :idScout',
                'tarif.DATE_VERSEMENT BETWEEN :debutSession AND :finSession',
                'scout.ACTIF = TRUE',
                'tarif.NO_ENFANT = :nbScouts',
            ),
            $autreConditions
        );

        $sql = implode( " AND ", $conditions );

        return array(
            'condition' => $sql,
            'order' => 'tarif.DATE_VERSEMENT ASC',
            'params' => array_merge(
                array(
                    'idFamille' => $this->familleScout->ID_FAMILLE,
                    'idScout' => $this->ID_SCOUT,
                    'debutSession' => Util::formatDbDate( $debutSession ),
                    'finSession' => Util::formatDbDate( $finSession ),
                    'nbScouts' => $nbScouts,
                ),
                $autreValeurs
            ),
        );

    }

    public function recupererVersements( $debutSession ) {

        $critere = $this->criteresPourVersements();
        $params = $this->paramsPourVersements( $debutSession );

        $versements = $critere->findAll( $params );

        return $versements;

    }

    public function dispoPaiementEnLigne( $debutSession ) {

        $critiere = $this->criteresPourVersements();
        $params = $this->paramsPourVersements(
            $debutSession,
            array(
                't.ETAT = :etat',
            ),
            array(
                'etat' => false,
            )
        );

        $nbVersements = $critiere->count( $params );

        return $nbVersements > 0;

    }

}
