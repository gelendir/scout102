<?php

/**
 * This is the model class for table "FICHE_MEDICALE".
 *
 * The followings are the available columns in table 'FICHE_MEDICALE':
 * @property integer $ID_FICHE_MEDICALE
 * @property string $DATE_CREATION
 * @property integer $ID_UTIL_CREATION
 * @property string $DATE_MAJ
 * @property integer $ID_UTIL_MAJ
 * @property integer $ID_SCOUT
 * @property string $COMMENTAIRES
 * @property integer $FICHE_CONFIRME
 *
 * The followings are the available model relations:
 * @property Scout $iDSCOUT
 * @property Adulte $iDUTILCREATION
 * @property CaseACocher[] $caseACochers
 * @property CategorieChampTexte[] $categorieChampTextes
 */
class FicheMedicale extends CActiveRecord
{

    public $motDePasse;

    /**
     * Returns the static model of the specified AR class.
     * @return FicheMedicale the static model class
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
        return 'FICHE_MEDICALE';
    }
    
    public function genererCases() {
        $cases = array();
        foreach( CaseACocher::model()->findAll() as $caseACocher ) {
            
            $reponseCase = new ReponseCase();
            $reponseCase->caseACocher = $caseACocher;
            $reponseCase->ficheMedicale = $this;
            $cases[] = $reponseCase;
            
        }
        $this->reponseCases = $cases;
        
    }
    
    public function genererTexte() {
        $texte = array();
        foreach( CategorieChampTexte::model()->findAll() as $textArea ) {
            
            $reponseText = new TexteFicheChamp();
            $reponseText->categorieChampTexte = $textArea;
            $reponseText->ficheMedicale = $this;
            $texte[] = $reponseText;
            
        }
        
        $this->texteFicheChamps = $texte;
    }
    
    public function getReponsesCases( $categorie ) {
        
        $cases = array();
        
        foreach( $this->reponseCases as $reponseCase ) {
            
            if( $reponseCase->caseACocher->categorieCase->NOM == $categorie ) {
                
                $cases[] = $reponseCase;
                
            }
            
        }
        
        return $cases;
        
    }
    
    public function getReponseTexte( $categorie ) {
        
        $textes = array();
        
        foreach( $this->texteFicheChamps as $reponseTexte ) {
            
            if( $reponseTexte->categorieChampTexte->TITRE == $categorie ) {
                
                $textes[] = $reponseTexte;
                
            }
            
        }
        
        return $textes;
        
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_SCOUT', 'required', 'on' => 'fiche'),
            array('ID_UTIL_CREATION, ID_UTIL_MAJ, ID_SCOUT, FICHE_CONFIRME', 'numerical', 'integerOnly'=>true),
            array('COMMENTAIRES', 'length', 'max'=>300),
            array('motDePasse', 'safe'),
            array('motDePasse', 'validerMotDePasse', 'on' => 'fiche'),
            array('reponseCases', 'validerOuiNon'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID_FICHE_MEDICALE, DATE_CREATION, ID_UTIL_CREATION, DATE_MAJ, ID_UTIL_MAJ, ID_SCOUT, COMMENTAIRES, FICHE_CONFIRME', 'safe', 'on'=>'search'),
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
            'scout' => array(self::BELONGS_TO, 'Scout', 'ID_SCOUT'),
            'adulte' => array(self::BELONGS_TO, 'Adulte', 'ID_UTIL_CREATION'),
            'caseACochers' => array(self::MANY_MANY, 'CaseACocher', 'reponse_case(ID_FICHE_MEDICALE, ID_CASE_A_COCHER)'),
            'categorieChampTextes' => array(self::MANY_MANY, 'CategorieChampTexte', 'texte_fiche_champ(ID_FICHE_MEDICALE, ID_CAT_CHAMP_TEXTE)'),
            'reponseCases' => array( self::HAS_MANY, 'ReponseCase', 'ID_FICHE_MEDICALE' ),
            'texteFicheChamps' => array(self::HAS_MANY, 'TexteFicheChamp', 'ID_FICHE_MEDICALE')
        );
    }

    public function validerOuiNon( $param, $attributes )
    {
        $allChecked = true;

        foreach( $this->reponseCases as $reponseCase ) {
            if( $reponseCase->REPONSE === null ) {
                $allChecked = false;
            }
        }

        if( !$allChecked ) {
            $this->addError( "reponseCases", "Veuillez Sélectionner soit oui ou non pour toutes les questions" );
        }

    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID_FICHE_MEDICALE' => 'Id Fiche Medicale',
            'DATE_CREATION' => 'Date Creation',
            'ID_UTIL_CREATION' => 'Id Util Creation',
            'DATE_MAJ' => 'Date Maj',
            'ID_UTIL_MAJ' => 'Id Util Maj',
            'ID_SCOUT' => 'Id Scout',
            'COMMENTAIRES' => 'Commentaires',
            'FICHE_CONFIRME' => 'Fiche Confirme',
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

        $criteria->compare('ID_FICHE_MEDICALE',$this->ID_FICHE_MEDICALE);
        $criteria->compare('DATE_CREATION',$this->DATE_CREATION,true);
        $criteria->compare('ID_UTIL_CREATION',$this->ID_UTIL_CREATION);
        $criteria->compare('DATE_MAJ',$this->DATE_MAJ,true);
        $criteria->compare('ID_UTIL_MAJ',$this->ID_UTIL_MAJ);
        $criteria->compare('ID_SCOUT',$this->ID_SCOUT);
        $criteria->compare('COMMENTAIRES',$this->COMMENTAIRES,true);
        $criteria->compare('FICHE_CONFIRME',$this->FICHE_CONFIRME);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    protected function beforeSave()
    {

        if( $this->isNewRecord ) {
            $this->DATE_CREATION = new CDbExpression("NOW()");
            $this->ID_UTIL_CREATION = Yii::app()->user->id;
        }

        $this->DATE_MAJ = new CDbExpression("NOW()");
        $this->ID_UTIL_MAJ = Yii::app()->user->id;

        return true;

    }

    public function validerMotDePasse( $attribute, $params ) {

        if( $this->FICHE_CONFIRME == true ) {

            $adulte = Adulte::model()->findByPk( Yii::app()->user->id );

            $motDePasseCrypt = $adulte->MOT_DE_PASSE;

            if( !Util::validatePassword( $this->motDePasse, $motDePasseCrypt ) ) {
                $this->addError( 'motDePasse', "Le mot de passe n'est pas valide" );
            }

        }

    }
}
