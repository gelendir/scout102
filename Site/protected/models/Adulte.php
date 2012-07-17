<?php 
/**
 * This is the model class for table "ADULTE".
 *
 * The followings are the available columns in table 'ADULTE':
 * @property integer $ID_ADULTE
 * @property string $PRENOM
 * @property string $NOM
 * @property string $NOM_UTILISATEUR
 * @property string $MOT_DE_PASSE
 * @property string $COURRIEL
 * @property string $SEXE
 * @property string $NO_TEL_PRINCIPAL
 * @property string $NO_TEL_SECONDAIRE
 * @property string $NO_TEL_AUTRE
 * @property string $EMPLOI
 *
 * The followings are the available model relations:
 * @property Unite[] $unites
 * @property Famille[] $familles
 * @property FicheMedicale[] $ficheMedicales
 * @property TypeImplication[] $typeImplications
 */
class Adulte extends CActiveRecord
{

    private $createFamille = false;

    public $conf_password;
    /**
     * Returns the static model of the specified AR class.
     * @return Adulte the static model class
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
        return 'ADULTE';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('MOT_DE_PASSE, COURRIEL', 'required', 'on' => 'inscription'),
            array('PRENOM, NOM, COURRIEL, MOT_DE_PASSE, SEXE, NO_TEL_PRINCIPAL, EMPLOI', 'required', 'on' => 'install' ),
            array('PRENOM, NOM, EMPLOI, IMPLICATION_AUTRE', 'length', 'max'=>45),
            array('NOM_UTILISATEUR, COURRIEL', 'length', 'max'=>100),
            array('NOM_UTILISATEUR', 'unique' ),
            array('NO_TEL_PRINCIPAL, NO_TEL_SECONDAIRE, NO_TEL_AUTRE', 'length', 'max'=>20),
            array('MOT_DE_PASSE', 'length', 'max' => 256),
            array('SEXE', 'length', 'max'=>1),
            array('PARENT', 'safe'),
            array('conf_password', 'safe'),
            array('MOT_DE_PASSE', 'compare', 'compareAttribute'=>'conf_password', 'on'=>'inscription, reset, ficheAdmin'),
            array('COURRIEL', 'email'),
            array('NOM, PRENOM, NO_TEL_PRINCIPAL, EMPLOI, ID_ADRESSE_PRINC', 'required', 'on' => 'fiche, ficheAdmin'),
            array('NO_TEL_PRINCIPAL, NO_TEL_SECONDAIRE', 'match', 'pattern' => '/^\d{3}-\d{3}-\d{4}$/', 'on' => 'fiche'),
            array('NO_TEL_AUTRE', 'match', 'pattern' => '/^\d{3}-\d{3}-\d{4}( ?#\d+)?$/'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_ADULTE, PRENOM, NOM, NOM_UTILISATEUR, MOT_DE_PASSE, COURRIEL, SEXE, NO_TEL_PRINCIPAL, NO_TEL_SECONDAIRE, NO_TEL_AUTRE, EMPLOI', 'safe', 'on'=>'search'),
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
            'unites' => array(self::MANY_MANY, 'Unite', 'animateur_unite(ID_ADULTE, ID_UNITE)'),
            'familles' => array(self::MANY_MANY, 'Famille',  'FAMILLE_ADULTE(ID_ADULTE, ID_FAMILLE)'),
            'ficheMedicales' => array(self::HAS_MANY, 'FicheMedicale', 'ID_UTIL_CREATION'),
            'implications' => array( self::HAS_MANY, 'Implication', 'ID_ADULTE'),
            'typeImplications' => array(self::MANY_MANY, 'TypeImplication', 'implication(ID_ADULTE, ID_TYPE_IMPLICATION)'),
            'adresse' => array( self::BELONGS_TO, 'Adresse', 'ID_ADRESSE_PRINC' ),
            'familleAdulte' => array( self::HAS_ONE, 'FamilleAdulte', 'ID_ADULTE' ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_ADULTE' => 'Id Adulte',
            'PRENOM' => 'Prénom',
            'NOM' => 'Nom',
            'NOM_UTILISATEUR' => "Nom d'utilisateur",
            'MOT_DE_PASSE' => 'Mot de passe',
            'COURRIEL' => 'Courriel',
            'SEXE' => 'Sexe',
            'NO_TEL_PRINCIPAL' => 'No. Téléphone principal',
            'NO_TEL_SECONDAIRE' => 'No. Téléphone secondaire',
            'NO_TEL_AUTRE' => 'No. Télphone travail',
            'EMPLOI' => 'Emploi',
            'ID_ADRESSE_PRINC' => 'Adresse principale',
        );
    }

    public function attributeMasks() {

        return array(
            'PRENOM' => 'Prénom',
            'NOM' => 'Nom',
            'COURRIEL' => 'john.doe@adresse.com',
            'NO_TEL_PRINCIPAL' => '418-555-1845',
            'NO_TEL_SECONDAIRE' => '418-555-1845',
            'NO_TEL_AUTRE' => '418-555-1845 #1234' ,
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
        $criteria->compare('PRENOM',$this->PRENOM,true);
        $criteria->compare('NOM',$this->NOM,true);
        $criteria->compare('NOM_UTILISATEUR',$this->NOM_UTILISATEUR,true);
        $criteria->compare('MOT_DE_PASSE',$this->MOT_DE_PASSE,true);
        $criteria->compare('COURRIEL',$this->COURRIEL,true);
        $criteria->compare('SEXE',$this->SEXE,true);
        $criteria->compare('NO_TEL_PRINCIPAL',$this->NO_TEL_PRINCIPAL,true);
        $criteria->compare('NO_TEL_SECONDAIRE',$this->NO_TEL_SECONDAIRE,true);
        $criteria->compare('NO_TEL_AUTRE',$this->NO_TEL_AUTRE,true);
        $criteria->compare('EMPLOI',$this->EMPLOI,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function beforeSave()
    {
        if( $this->isNewRecord ) {
            $this->createFamille = true;
        }

        return true;
    }

    public function afterSave() {

        if( $this->createFamille ) {

            $famille = new Famille;
            if( $famille->save() ) {

                $familleAdulte = new FamilleAdulte;
                $familleAdulte->ID_FAMILLE = $famille->ID_FAMILLE;
                $familleAdulte->ID_ADULTE = $this->ID_ADULTE;

                if( !$familleAdulte->save() ) {

                    $this->addErrors( array(
                        'familleAdulte' => $familleAdulte->getErrors()
                    ) );
                    return false;
                }

            } else {

                $this->addErrors( array(
                    'familles' => $famille->getErrors(),
                ) );
                return false;

            }

        }

        return true;

    }

    public function getIdFamille()
    {
        return $this->familles[0]->ID_FAMILLE;
    }

    public function genererImplications() {

        $implications = array();

        foreach( TypeImplication::model()->findAll() as $typeImplication )
        {

            $implication = new Implication;
            $implication->typeImplication = $typeImplication;
            $implications[] = $implication;

        }

        $this->implications = $implications;

    }

    public function implicationDemandes()
    {
        $demandes = array();

        foreach( $this->implications as $implication ) {

            if( $implication->DEMANDE == true ) {
                $demandes[] = $implication;
            }

        }

        return $demandes;

    }

    public function implicationAccordes()
    {
        $accordes = array();

        foreach( $this->implications as $implication ) {

            if( $implication->ACCORDE == true ) {
                $accordes[] = $implication;
            }

        }

        return $accordes;

    }

    public function getNomComplet() {

        return $this->PRENOM . " " . $this->NOM;

    }

    public function encrypterMotDePasse()
    {

        $this->MOT_DE_PASSE = Util::encrypt( $this->MOT_DE_PASSE );
        $this->conf_password = $this->MOT_DE_PASSE;

    }

    public function envoyerCourrielBienvenue()
    {

        $body = Yii::t( 'parent', 'inscriptionConfirmation', array(
            '{username}' => $this->NOM_UTILISATEUR,
        ) );

        $from = Yii::app()->params['adminEmail'];
        $to = $this->COURRIEL;
        $subject = Yii::t( 'parent', 'sujetInscriptionConfirmation' );

        Yii::app()->mail->sendSimple( $from, $to, $subject, $body, 'text/plain');

    }

}
