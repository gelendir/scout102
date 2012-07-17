SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `ADRESSE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ADRESSE` ;

CREATE  TABLE IF NOT EXISTS `ADRESSE` (
  `ID_ADRESSE` INT(11) NOT NULL AUTO_INCREMENT ,
  `ADRESSE_RUE` VARCHAR(90) NOT NULL ,
  `VILLE` VARCHAR(45) NOT NULL ,
  `PROVINCE` VARCHAR(45) NOT NULL ,
  `CODE_POSTAL` VARCHAR(6) NOT NULL ,
  PRIMARY KEY (`ID_ADRESSE`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Les différentes adresses des personnes' ;


-- -----------------------------------------------------
-- Table `FAMILLE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FAMILLE` ;

CREATE  TABLE IF NOT EXISTS `FAMILLE` (
  `ID_FAMILLE` INT(11) NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`ID_FAMILLE`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ADRESSE_FAMILLE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ADRESSE_FAMILLE` ;

CREATE  TABLE IF NOT EXISTS `ADRESSE_FAMILLE` (
  `ID_ADRESSE` INT(11) NOT NULL ,
  `ID_FAMILLE` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_ADRESSE`, `ID_FAMILLE`) ,
  INDEX `FK2_ADRESSE_ID_ADRESSE` (`ID_ADRESSE` ASC) ,
  INDEX `FK1_ADRESSE_ID_FAMILLE` (`ID_FAMILLE` ASC) ,
  CONSTRAINT `FK1_ADRESSE_ID_FAMILLE`
    FOREIGN KEY (`ID_FAMILLE` )
    REFERENCES `FAMILLE` (`ID_FAMILLE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK2_ADRESSE_ID_ADRESSE`
    FOREIGN KEY (`ID_ADRESSE` )
    REFERENCES `ADRESSE` (`ID_ADRESSE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Les adresses d\'une personnes' ;


-- -----------------------------------------------------
-- Table `ADULTE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ADULTE` ;

CREATE  TABLE IF NOT EXISTS `ADULTE` (
  `ID_ADULTE` INT(11) NOT NULL AUTO_INCREMENT ,
  `PRENOM` VARCHAR(45) NULL DEFAULT NULL ,
  `NOM` VARCHAR(45) NULL DEFAULT NULL ,
  `NOM_UTILISATEUR` VARCHAR(100) NOT NULL ,
  `MOT_DE_PASSE` VARCHAR(256) NOT NULL ,
  `COURRIEL` VARCHAR(100) NULL DEFAULT NULL ,
  `SEXE` CHAR(1) NULL DEFAULT NULL ,
  `NO_TEL_PRINCIPAL` VARCHAR(20) NULL DEFAULT NULL ,
  `NO_TEL_SECONDAIRE` VARCHAR(20) NULL DEFAULT NULL ,
  `NO_TEL_AUTRE` VARCHAR(20) NULL DEFAULT NULL ,
  `EMPLOI` VARCHAR(45) NULL DEFAULT NULL ,
  `ID_ADRESSE_PRINC` INT(11) NULL DEFAULT NULL ,
  `PARENT` TINYINT(1) NULL DEFAULT NULL ,
  `COMPTE_ACTIF` TINYINT(1) NOT NULL DEFAULT '1' ,
  `IMPLICATION_AUTRE` VARCHAR(45) NULL ,
  PRIMARY KEY (`ID_ADULTE`) ,
  INDEX `FK_ADULTE_ID_ADDRESSE` (`ID_ADRESSE_PRINC` ASC) ,
  CONSTRAINT `FK_ADULTE_ID_ADDRESSE`
    FOREIGN KEY (`ID_ADRESSE_PRINC` )
    REFERENCES `ADRESSE` (`ID_ADRESSE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Les informations sur les adultes.' ;


-- -----------------------------------------------------
-- Table `PROGRAMME`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PROGRAMME` ;

CREATE  TABLE IF NOT EXISTS `PROGRAMME` (
  `ID_PROGRAMME` INT(11) NOT NULL AUTO_INCREMENT ,
  `NOM_PROGRAMME` VARCHAR(45) NOT NULL ,
  `AGE_MIN` INT(11) NOT NULL ,
  `AGE_MAX` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_PROGRAMME`) )
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Les différents programmes offert par le groupe scout. (ex: c' ;


-- -----------------------------------------------------
-- Table `UNITE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNITE` ;

CREATE  TABLE IF NOT EXISTS `UNITE` (
  `ID_UNITE` INT(11) NOT NULL AUTO_INCREMENT ,
  `NOM_UNITE` VARCHAR(40) NOT NULL ,
  `DATE_CREATION` DATETIME NOT NULL ,
  `ID_PROGRAMME` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_UNITE`) ,
  INDEX `FK_UNITE_ID_PORGRAMME` (`ID_PROGRAMME` ASC) ,
  CONSTRAINT `FK_UNITE_ID_PORGRAMME`
    FOREIGN KEY (`ID_PROGRAMME` )
    REFERENCES `PROGRAMME` (`ID_PROGRAMME` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Les unités d\'un programme (ex: les castores vaillants, etc.)' ;


-- -----------------------------------------------------
-- Table `ANIMATEUR_UNITE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ANIMATEUR_UNITE` ;

CREATE  TABLE IF NOT EXISTS `ANIMATEUR_UNITE` (
  `ID_ADULTE` INT(11) NOT NULL ,
  `ID_UNITE` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_ADULTE`, `ID_UNITE`) ,
  INDEX `FK1_ANIM_UNITE_ID_UNITE` (`ID_UNITE` ASC) ,
  INDEX `FK2_ANIM_UNITE_ID_ADULTE` (`ID_ADULTE` ASC) ,
  CONSTRAINT `FK1_ANIM_UNITE_ID_UNITE`
    FOREIGN KEY (`ID_UNITE` )
    REFERENCES `UNITE` (`ID_UNITE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK2_ANIM_UNITE_ID_ADULTE`
    FOREIGN KEY (`ID_ADULTE` )
    REFERENCES `ADULTE` (`ID_ADULTE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'La liste des animateurs et le lien avec les unites' ;


-- -----------------------------------------------------
-- Table `SCOUT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SCOUT` ;

CREATE  TABLE IF NOT EXISTS `SCOUT` (
  `ID_SCOUT` INT(11) NOT NULL AUTO_INCREMENT ,
  `PRENOM` VARCHAR(45) NOT NULL ,
  `NOM` VARCHAR(45) NOT NULL ,
  `DATE_NAISSANCE` DATETIME NOT NULL ,
  `SEXE` CHAR(1) NOT NULL ,
  `NO_ASSURANCE_MALADIE` VARCHAR(12) NOT NULL ,
  `DATE_FIN_CARTE_MEDICAL` DATETIME NOT NULL ,
  `PARTICULARITE` VARCHAR(300) NULL DEFAULT NULL ,
  `ID_ADRESSE_PRINC` INT(11) NOT NULL ,
  `CONT_URG_NOM` VARCHAR(45) NOT NULL ,
  `CONT_URG_NO_TEL` VARCHAR(24) NOT NULL ,
  `CONT_URG_LIEN_JEUNE` VARCHAR(45) NOT NULL ,
  `CONT_URG_PRENOM` VARCHAR(45) NOT NULL ,
  `ACTIF` TINYINT(1) NOT NULL DEFAULT '1' ,
  `ANNEE_INSCRIPTION` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_SCOUT`) ,
  INDEX `FK1_SCOUT_ID_ADD` (`ID_ADRESSE_PRINC` ASC) ,
  CONSTRAINT `FK1_SCOUT_ID_ADD`
    FOREIGN KEY (`ID_ADRESSE_PRINC` )
    REFERENCES `ADRESSE` (`ID_ADRESSE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Les informations sur un scout comme son nom, sa date de nais' ;


-- -----------------------------------------------------
-- Table `TYPE_AUTORISATION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `TYPE_AUTORISATION` ;

CREATE  TABLE IF NOT EXISTS `TYPE_AUTORISATION` (
  `ID_TYPE_AUTO` INT(11) NOT NULL AUTO_INCREMENT ,
  `TITRE` VARCHAR(100) NOT NULL ,
  `DESCRIPTION` VARCHAR(300) NOT NULL ,
  PRIMARY KEY (`ID_TYPE_AUTO`) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Le type d\'autorisation (photo, baignade, etc.)' ;


-- -----------------------------------------------------
-- Table `AUTORISATION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AUTORISATION` ;

CREATE  TABLE IF NOT EXISTS `AUTORISATION` (
  `ID_SCOUT` INT(11) NOT NULL ,
  `ID_TYPE_AUTO` INT(11) NOT NULL ,
  `ACCEPTATION` TINYINT(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`ID_SCOUT`, `ID_TYPE_AUTO`) ,
  INDEX `FK1_AUTORISATION_ID_SCOUT` (`ID_SCOUT` ASC) ,
  INDEX `FK2_AUTORISATION_ID_TYPE_AUTO` (`ID_TYPE_AUTO` ASC) ,
  CONSTRAINT `FK1_AUTORISATION_ID_SCOUT`
    FOREIGN KEY (`ID_SCOUT` )
    REFERENCES `SCOUT` (`ID_SCOUT` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK2_AUTORISATION_ID_TYPE_AUTO`
    FOREIGN KEY (`ID_TYPE_AUTO` )
    REFERENCES `TYPE_AUTORISATION` (`ID_TYPE_AUTO` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Les différentes autorisations d\'un scout.' ;


-- -----------------------------------------------------
-- Table `CATEGORIE_CASE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CATEGORIE_CASE` ;

CREATE  TABLE IF NOT EXISTS `CATEGORIE_CASE` (
  `ID_CAT_CASE` INT(11) NOT NULL AUTO_INCREMENT ,
  `NOM` VARCHAR(100) NOT NULL ,
  `DESCRIPTION` VARCHAR(300) NOT NULL ,
  `TYPE_INPUT` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_CAT_CASE`) )
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Les catégories de cases à cocher. (par exemple: état médical' ;


-- -----------------------------------------------------
-- Table `CASE_A_COCHER`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CASE_A_COCHER` ;

CREATE  TABLE IF NOT EXISTS `CASE_A_COCHER` (
  `ID_CASE_A_COCHER` INT(11) NOT NULL AUTO_INCREMENT ,
  `NOM_CASE` VARCHAR(100) NOT NULL ,
  `DESCRIPTION` VARCHAR(300) NOT NULL ,
  `ID_CAT_CASE` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_CASE_A_COCHER`) ,
  INDEX `FK_ID_CAT_CASE` (`ID_CAT_CASE` ASC) ,
  CONSTRAINT `FK_ID_CAT_CASE`
    FOREIGN KEY (`ID_CAT_CASE` )
    REFERENCES `CATEGORIE_CASE` (`ID_CAT_CASE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 83
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Les cases à cocher de la fiche médicale avec leur catégorie.' ;


-- -----------------------------------------------------
-- Table `CATEGORIE_CHAMP_TEXTE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CATEGORIE_CHAMP_TEXTE` ;

CREATE  TABLE IF NOT EXISTS `CATEGORIE_CHAMP_TEXTE` (
  `ID_CAT_CHAMP_TEXTE` INT(11) NOT NULL AUTO_INCREMENT ,
  `TITRE` VARCHAR(100) NOT NULL ,
  `DESCTRIPTION` VARCHAR(300) NOT NULL ,
  PRIMARY KEY (`ID_CAT_CHAMP_TEXTE`) )
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'La catégorie des champs de type entré texte. (par exemple: l' ;


-- -----------------------------------------------------
-- Table `ECOLE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ECOLE` ;

CREATE  TABLE IF NOT EXISTS `ECOLE` (
  `ID_ECOLE` INT(11) NOT NULL AUTO_INCREMENT ,
  `NOM_ECOLE` VARCHAR(90) NOT NULL ,
  PRIMARY KEY (`ID_ECOLE`) )
ENGINE = InnoDB
AUTO_INCREMENT = 46
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ESSAI_MOT_DE_PASSE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ESSAI_MOT_DE_PASSE` ;

CREATE  TABLE IF NOT EXISTS `ESSAI_MOT_DE_PASSE` (
  `ID_ESSAI` INT(11) NOT NULL AUTO_INCREMENT ,
  `DATE_ESSAI` DATETIME NOT NULL ,
  `CLEF` VARCHAR(256) NOT NULL ,
  `ID_ADULTE` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_ESSAI`) ,
  INDEX `FK_ESSAI_MOT_DE_PASSE_1` (`ID_ADULTE` ASC) ,
  CONSTRAINT `FK_ESSAI_MOT_DE_PASSE_1`
    FOREIGN KEY (`ID_ADULTE` )
    REFERENCES `ADULTE` (`ID_ADULTE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Enregistrement des essaies pour récupérer un mot de passe' ;


-- -----------------------------------------------------
-- Table `MODE_PAIEMENT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MODE_PAIEMENT` ;

CREATE  TABLE IF NOT EXISTS `MODE_PAIEMENT` (
  `ID_MODE_PAIEMENT` INT(11) NOT NULL AUTO_INCREMENT ,
  `NOM_MODE` VARCHAR(45) NOT NULL ,
  `DESCRIPTION` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`ID_MODE_PAIEMENT`) )
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `FACTURE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FACTURE` ;

CREATE  TABLE IF NOT EXISTS `FACTURE` (
  `ID_FACTURE` INT(11) NOT NULL AUTO_INCREMENT ,
  `MONTANT` DECIMAL(10,0) NOT NULL ,
  `DATE_FACTURE` DATETIME NOT NULL ,
  `ID_MODE_PAIEMENT` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_FACTURE`) ,
  INDEX `FK1_FACTURE_ID_MODE` (`ID_MODE_PAIEMENT` ASC) ,
  CONSTRAINT `FK1_FACTURE_ID_MODE`
    FOREIGN KEY (`ID_MODE_PAIEMENT` )
    REFERENCES `MODE_PAIEMENT` (`ID_MODE_PAIEMENT` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `FAMILLE_ADULTE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FAMILLE_ADULTE` ;

CREATE  TABLE IF NOT EXISTS `FAMILLE_ADULTE` (
  `ID_FAMILLE` INT(11) NOT NULL ,
  `ID_ADULTE` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_FAMILLE`, `ID_ADULTE`) ,
  INDEX `FK_FAM_ADU_ID_FAMILLE` (`ID_FAMILLE` ASC) ,
  INDEX `FK_FAM_ADU_ID_ADULTE` (`ID_ADULTE` ASC) ,
  CONSTRAINT `FK_FAM_ADU_ID_ADULTE`
    FOREIGN KEY (`ID_ADULTE` )
    REFERENCES `ADULTE` (`ID_ADULTE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_FAM_ADU_ID_FAMILLE`
    FOREIGN KEY (`ID_FAMILLE` )
    REFERENCES `FAMILLE` (`ID_FAMILLE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `FAMILLE_SCOUT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FAMILLE_SCOUT` ;

CREATE  TABLE IF NOT EXISTS `FAMILLE_SCOUT` (
  `ID_FAMILLE` INT(11) NOT NULL ,
  `ID_SCOUT` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_FAMILLE`, `ID_SCOUT`) ,
  INDEX `FK_FAM_SCOUT_ID_SCOUT` (`ID_SCOUT` ASC) ,
  INDEX `FK_FAM_SCOUT_ID_FAMILLE` (`ID_FAMILLE` ASC) ,
  CONSTRAINT `FK_FAM_SCOUT_ID_FAMILLE`
    FOREIGN KEY (`ID_FAMILLE` )
    REFERENCES `FAMILLE` (`ID_FAMILLE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_FAM_SCOUT_ID_SCOUT`
    FOREIGN KEY (`ID_SCOUT` )
    REFERENCES `SCOUT` (`ID_SCOUT` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `FICHE_MEDICALE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FICHE_MEDICALE` ;

CREATE  TABLE IF NOT EXISTS `FICHE_MEDICALE` (
  `ID_FICHE_MEDICALE` INT(11) NOT NULL AUTO_INCREMENT ,
  `DATE_CREATION` DATETIME NOT NULL ,
  `ID_UTIL_CREATION` INT(11) NOT NULL ,
  `DATE_MAJ` DATETIME NOT NULL ,
  `ID_UTIL_MAJ` INT(11) NOT NULL ,
  `ID_SCOUT` INT(11) NOT NULL ,
  `COMMENTAIRES` VARCHAR(300) NULL DEFAULT NULL ,
  `FICHE_CONFIRME` TINYINT(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`ID_FICHE_MEDICALE`) ,
  INDEX `FK1_FICHE_MED_ID_SCOUT` (`ID_SCOUT` ASC) ,
  INDEX `FK2_FICHE_MED_ID_CREAT` (`ID_UTIL_CREATION` ASC) ,
  INDEX `FK3_FICHE_MED_ID_MAJ` (`ID_UTIL_MAJ` ASC) ,
  CONSTRAINT `FK1_FICHE_MED_ID_SCOUT`
    FOREIGN KEY (`ID_SCOUT` )
    REFERENCES `SCOUT` (`ID_SCOUT` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK2_FICHE_MED_ID_CREAT`
    FOREIGN KEY (`ID_UTIL_CREATION` )
    REFERENCES `ADULTE` (`ID_ADULTE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK3_FICHE_MED_ID_MAJ`
    FOREIGN KEY (`ID_UTIL_MAJ` )
    REFERENCES `ADULTE` (`ID_ADULTE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Les informations médicales d\'un scout. ' ;


-- -----------------------------------------------------
-- Table `TYPE_IMPLICATION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `TYPE_IMPLICATION` ;

CREATE  TABLE IF NOT EXISTS `TYPE_IMPLICATION` (
  `ID_TYPE_IMPLICATION` INT(11) NOT NULL AUTO_INCREMENT ,
  `TITRE_IMPLICATION` VARCHAR(45) NOT NULL ,
  `DESCRIPTION` VARCHAR(300) NOT NULL ,
  PRIMARY KEY (`ID_TYPE_IMPLICATION`) )
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Les différentes implcation possibles pour un adulte dans le ' ;


-- -----------------------------------------------------
-- Table `IMPLICATION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `IMPLICATION` ;

CREATE  TABLE IF NOT EXISTS `IMPLICATION` (
  `ID_TYPE_IMPLICATION` INT(11) NOT NULL ,
  `ID_ADULTE` INT(11) NOT NULL ,
  `ACCORDE` TINYINT(1) NOT NULL DEFAULT '0' ,
  `DEMANDE` TINYINT(1) NOT NULL ,
  `ID_IMPLICATION` INT(11) NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`ID_IMPLICATION`) ,
  INDEX `FK1_IMPLICATION_ID_ADULTE` (`ID_ADULTE` ASC) ,
  INDEX `FK2_IMPLICATION_ID_TYPE_IMP` (`ID_TYPE_IMPLICATION` ASC) ,
  CONSTRAINT `FK1_IMPLICATION_ID_ADULTE`
    FOREIGN KEY (`ID_ADULTE` )
    REFERENCES `ADULTE` (`ID_ADULTE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK2_IMPLICATION_ID_TYPE_IMP`
    FOREIGN KEY (`ID_TYPE_IMPLICATION` )
    REFERENCES `TYPE_IMPLICATION` (`ID_TYPE_IMPLICATION` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'La liste des implications d\'un parent dans un scout' ;


-- -----------------------------------------------------
-- Table `ROLE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ROLE` ;

CREATE  TABLE IF NOT EXISTS `ROLE` (
  `ID_ROLE` INT(11) NOT NULL AUTO_INCREMENT ,
  `NOM_ROLE` VARCHAR(45) NOT NULL ,
  `DESCRIPTION` VARCHAR(300) NOT NULL ,
  PRIMARY KEY (`ID_ROLE`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Les différents rôles qu\'un utilisateur peut avoir au sein du' ;


-- -----------------------------------------------------
-- Table `IMPLICATION_ROLE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `IMPLICATION_ROLE` ;

CREATE  TABLE IF NOT EXISTS `IMPLICATION_ROLE` (
  `ID_TYPE_IMPLICATION` INT(11) NOT NULL ,
  `ID_ROLE` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_TYPE_IMPLICATION`, `ID_ROLE`) ,
  INDEX `FK1_IMPL_ROLE_ID_ROLE` (`ID_ROLE` ASC) ,
  INDEX `FK2_IMPL_ROLE_ID_TYPE_IMPL` (`ID_TYPE_IMPLICATION` ASC) ,
  CONSTRAINT `FK1_IMPL_ROLE_ID_ROLE`
    FOREIGN KEY (`ID_ROLE` )
    REFERENCES `ROLE` (`ID_ROLE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK2_IMPL_ROLE_ID_TYPE_IMPL`
    FOREIGN KEY (`ID_TYPE_IMPLICATION` )
    REFERENCES `TYPE_IMPLICATION` (`ID_TYPE_IMPLICATION` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'La liste des roles du système rataché au type d\'implication ' ;


-- -----------------------------------------------------
-- Table `NIVEAU_SCOLAIRE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `NIVEAU_SCOLAIRE` ;

CREATE  TABLE IF NOT EXISTS `NIVEAU_SCOLAIRE` (
  `ID_NIVEAU_SCOLAIRE` INT(11) NOT NULL AUTO_INCREMENT ,
  `DESCRIPTION_NIVEAU` VARCHAR(70) NOT NULL ,
  PRIMARY KEY (`ID_NIVEAU_SCOLAIRE`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Les niveaux scolaires possibles.' ;


-- -----------------------------------------------------
-- Table `NOTIFICATION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `NOTIFICATION` ;

CREATE  TABLE IF NOT EXISTS `NOTIFICATION` (
  `ID_NOTIFICATION` INT(11) NOT NULL AUTO_INCREMENT ,
  `TITRE` VARCHAR(45) NULL DEFAULT NULL ,
  `MESSAGE` TEXT NOT NULL ,
  `DATE_ENVOIE` DATETIME NOT NULL ,
  `LU` TINYINT(1) NOT NULL DEFAULT '0' ,
  `IMPORTANT` TINYINT(1) NOT NULL DEFAULT '0' ,
  `DATE_LU` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`ID_NOTIFICATION`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PAIEMENT_PAYPAL`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PAIEMENT_PAYPAL` ;

CREATE  TABLE IF NOT EXISTS `PAIEMENT_PAYPAL` (
  `ID_PAIEMENT_PAYPAL` INT(11) NOT NULL AUTO_INCREMENT ,
  `ID_PAYEUR` VARCHAR(20) NOT NULL ,
  `DATE_PAIEMENT` DATETIME NOT NULL ,
  `MONTANT` DECIMAL(6,2) NOT NULL ,
  `ID_TRANSACTION` VARCHAR(20) NOT NULL ,
  `ID_FACTURE` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_PAIEMENT_PAYPAL`) ,
  INDEX `FK_PAIEMENT_PAYPAL_FACTURE` (`ID_FACTURE` ASC) ,
  CONSTRAINT `FK_PAIEMENT_PAYPAL_FACTURE`
    FOREIGN KEY (`ID_FACTURE` )
    REFERENCES `FACTURE` (`ID_FACTURE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `RECU_IMPOT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `RECU_IMPOT` ;

CREATE  TABLE IF NOT EXISTS `RECU_IMPOT` (
  `ID_RECU_IMPOT` INT(11) NOT NULL AUTO_INCREMENT ,
  `MONTANT` DECIMAL(10,0) NULL DEFAULT NULL ,
  `ANNEE_IMPOSITION` INT(11) NOT NULL ,
  `DATE_EMISSION` DATETIME NULL DEFAULT NULL ,
  `NO_RECU` INT(11) NOT NULL ,
  `ID_SCOUT` INT(11) NOT NULL ,
  `NOM_PERSONNE` VARCHAR(45) NOT NULL ,
  `COURRIEL_D_ENVOIE` VARCHAR(100) NOT NULL ,
  `ACTIVITE` VARCHAR(45) NULL DEFAULT NULL ,
  `PRENOM_PERSONNE` VARCHAR(45) NOT NULL ,
  `ID_ADRESSE` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_RECU_IMPOT`) ,
  INDEX `FK_RECU_IMPOT_ID_SCOUT` (`ID_SCOUT` ASC) ,
  INDEX `FK_RECU_IMPOT_ID_ADRESSE` (`ID_ADRESSE` ASC) ,
  CONSTRAINT `FK_RECU_IMPOT_ID_ADRESSE`
    FOREIGN KEY (`ID_ADRESSE` )
    REFERENCES `ADRESSE` (`ID_ADRESSE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_RECU_IMPOT_ID_SCOUT`
    FOREIGN KEY (`ID_SCOUT` )
    REFERENCES `SCOUT` (`ID_SCOUT` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'La table contient les reçus d\'impôt ratachés à un scout.' ;


-- -----------------------------------------------------
-- Table `REPONSE_CASE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `REPONSE_CASE` ;

CREATE  TABLE IF NOT EXISTS `REPONSE_CASE` (
  `ID_FICHE_MEDICALE` INT(11) NOT NULL ,
  `ID_CASE_A_COCHER` INT(11) NOT NULL ,
  `REPONSE` TINYINT(1) NOT NULL DEFAULT '0' ,
  `ID_REPONSE_CASE` INT(11) NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`ID_REPONSE_CASE`) ,
  INDEX `FK1_REPONSE_CASE_ID_FICHE` (`ID_FICHE_MEDICALE` ASC) ,
  INDEX `FK2_REPONSE_CASE_ID_CASE` (`ID_CASE_A_COCHER` ASC) ,
  CONSTRAINT `FK1_REPONSE_CASE_ID_FICHE`
    FOREIGN KEY (`ID_FICHE_MEDICALE` )
    REFERENCES `FICHE_MEDICALE` (`ID_FICHE_MEDICALE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK2_REPONSE_CASE_ID_CASE`
    FOREIGN KEY (`ID_CASE_A_COCHER` )
    REFERENCES `CASE_A_COCHER` (`ID_CASE_A_COCHER` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Les réponses au cases à cochés.' ;


-- -----------------------------------------------------
-- Table `ROLE_NOTIFICATION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ROLE_NOTIFICATION` ;

CREATE  TABLE IF NOT EXISTS `ROLE_NOTIFICATION` (
  `ID_ROLE` INT(11) NOT NULL ,
  `ID_NOTIFICATION` INT(11) NOT NULL ,
  `ID_ROLE_NOTIFICATION` INT(11) NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`ID_ROLE_NOTIFICATION`) ,
  INDEX `FK_ROLENOTIF_ID_ROLE` (`ID_ROLE` ASC) ,
  INDEX `FK_ROLENOTIF_ID_NOTIFICATION` (`ID_NOTIFICATION` ASC) ,
  CONSTRAINT `FK_ROLENOTIF_ID_NOTIFICATION`
    FOREIGN KEY (`ID_NOTIFICATION` )
    REFERENCES `NOTIFICATION` (`ID_NOTIFICATION` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ROLENOTIF_ID_ROLE`
    FOREIGN KEY (`ID_ROLE` )
    REFERENCES `ROLE` (`ID_ROLE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `SCOLARITE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SCOLARITE` ;

CREATE  TABLE IF NOT EXISTS `SCOLARITE` (
  `ID_SCOLARITE` INT(11) NOT NULL AUTO_INCREMENT ,
  `ID_SCOUT` INT(11) NOT NULL ,
  `ID_NIVEAU` INT(11) NOT NULL ,
  `NOM_ECOLE` VARCHAR(45) NOT NULL ,
  `NOM_ENSEIGNANT` VARCHAR(90) NOT NULL ,
  PRIMARY KEY (`ID_SCOLARITE`) ,
  UNIQUE INDEX `ID_SCOUT_UNIQUE` (`ID_SCOUT` ASC) ,
  INDEX `FK1_SCOLARITE_ID_SCOUT` (`ID_SCOUT` ASC) ,
  INDEX `FK2_SCOLARITE_ID_NIVEAU` (`ID_NIVEAU` ASC) ,
  CONSTRAINT `FK1_SCOLARITE_ID_SCOUT`
    FOREIGN KEY (`ID_SCOUT` )
    REFERENCES `SCOUT` (`ID_SCOUT` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK2_SCOLARITE_ID_NIVEAU`
    FOREIGN KEY (`ID_NIVEAU` )
    REFERENCES `NIVEAU_SCOLAIRE` (`ID_NIVEAU_SCOLAIRE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Les informations scolaire d\'un scout' ;


-- -----------------------------------------------------
-- Table `SESSION_PAYPAL`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SESSION_PAYPAL` ;

CREATE  TABLE IF NOT EXISTS `SESSION_PAYPAL` (
  `ID_SESSION_PAYPAL` INT(11) NOT NULL AUTO_INCREMENT ,
  `DATE_CREATION` DATETIME NOT NULL ,
  `CLEF_SESSION` VARCHAR(45) NOT NULL ,
  `MONTANT` DECIMAL(6,2) NOT NULL ,
  `ID_ADULTE` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_SESSION_PAYPAL`) ,
  INDEX `FK_SESSION_PAYPAL_ADULTE` (`ID_ADULTE` ASC) ,
  CONSTRAINT `FK_SESSION_PAYPAL_ADULTE`
    FOREIGN KEY (`ID_ADULTE` )
    REFERENCES `ADULTE` (`ID_ADULTE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `TARIF`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `TARIF` ;

CREATE  TABLE IF NOT EXISTS `TARIF` (
  `ID_TARIF` INT(11) NOT NULL AUTO_INCREMENT ,
  `MONTANT` DECIMAL(10,0) NOT NULL ,
  `DATE_VERSEMENT` DATE NOT NULL ,
  `NO_ENFANT` INT(11) NOT NULL ,
  `RABAIS` TINYINT(1) NOT NULL ,
  `TOTAL` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`ID_TARIF`) )
ENGINE = InnoDB
AUTO_INCREMENT = 19
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `TEXTE_FICHE_CHAMP`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `TEXTE_FICHE_CHAMP` ;

CREATE  TABLE IF NOT EXISTS `TEXTE_FICHE_CHAMP` (
  `ID_FICHE_MEDICALE` INT(11) NOT NULL ,
  `ID_CAT_CHAMP_TEXTE` INT(11) NOT NULL ,
  `TEXTE` VARCHAR(400) NOT NULL ,
  `ID_TEXTE_FICHE_CHAMP` INT(11) NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`ID_TEXTE_FICHE_CHAMP`) ,
  INDEX `FK1_TEXTE_FICHE_ID_FICHE_MED` (`ID_FICHE_MEDICALE` ASC) ,
  INDEX `FK2_TEXTE_FICHE_ID_CAT_CHAMP` (`ID_CAT_CHAMP_TEXTE` ASC) ,
  CONSTRAINT `FK1_TEXTE_FICHE_ID_FICHE_MED`
    FOREIGN KEY (`ID_FICHE_MEDICALE` )
    REFERENCES `FICHE_MEDICALE` (`ID_FICHE_MEDICALE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK2_TEXTE_FICHE_ID_CAT_CHAMP`
    FOREIGN KEY (`ID_CAT_CHAMP_TEXTE` )
    REFERENCES `CATEGORIE_CHAMP_TEXTE` (`ID_CAT_CHAMP_TEXTE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'Le texte entré dans les différentes catégories d\'entré texte' ;


-- -----------------------------------------------------
-- Table `T_VERSEMENT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `T_VERSEMENT` ;

CREATE  TABLE IF NOT EXISTS `T_VERSEMENT` (
  `ID_VERSEMENT` INT(11) NOT NULL AUTO_INCREMENT ,
  `ID_SCOUT` INT(11) NOT NULL ,
  `ID_FAMILLE` INT(11) NOT NULL ,
  `ID_TARIF` INT(11) NOT NULL ,
  `ETAT` TINYINT(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`ID_VERSEMENT`) ,
  INDEX `FK1_VERS_FAMSCOU_ID` (`ID_SCOUT` ASC, `ID_FAMILLE` ASC) ,
  INDEX `FK2_VERS_TARIF_ID` (`ID_TARIF` ASC) ,
  CONSTRAINT `FK1_VERS_FAMSCOU_ID`
    FOREIGN KEY (`ID_SCOUT` , `ID_FAMILLE` )
    REFERENCES `FAMILLE_SCOUT` (`ID_SCOUT` , `ID_FAMILLE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK2_VERS_TARIF_ID`
    FOREIGN KEY (`ID_TARIF` )
    REFERENCES `TARIF` (`ID_TARIF` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `UNITE_SCOUT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNITE_SCOUT` ;

CREATE  TABLE IF NOT EXISTS `UNITE_SCOUT` (
  `ID_UNITE` INT(11) NOT NULL ,
  `ID_SCOUT` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_UNITE`, `ID_SCOUT`) ,
  INDEX `FK1_UNITE_SCOUT_ID_UNITE` (`ID_UNITE` ASC) ,
  INDEX `FK2_UNITE_SCOUT_ID_SCOUT` (`ID_SCOUT` ASC) ,
  CONSTRAINT `FK1_UNITE_SCOUT_ID_UNITE`
    FOREIGN KEY (`ID_UNITE` )
    REFERENCES `UNITE` (`ID_UNITE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK2_UNITE_SCOUT_ID_SCOUT`
    FOREIGN KEY (`ID_SCOUT` )
    REFERENCES `SCOUT` (`ID_SCOUT` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'La liste des scouts appartenant aux différentes unitées' ;


-- -----------------------------------------------------
-- Table `VERSEMENT_FACTURE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `VERSEMENT_FACTURE` ;

CREATE  TABLE IF NOT EXISTS `VERSEMENT_FACTURE` (
  `ID_FACTURE` INT(11) NOT NULL ,
  `ID_VERSEMENT` INT(11) NOT NULL ,
  PRIMARY KEY (`ID_FACTURE`, `ID_VERSEMENT`) ,
  INDEX `FK1_VERSFACT_ID_VERS` (`ID_VERSEMENT` ASC) ,
  INDEX `FK2_VERSFACT_ID_FACT` (`ID_FACTURE` ASC) ,
  CONSTRAINT `FK1_VERSFACT_ID_VERS`
    FOREIGN KEY (`ID_VERSEMENT` )
    REFERENCES `T_VERSEMENT` (`ID_VERSEMENT` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK2_VERSFACT_ID_FACT`
    FOREIGN KEY (`ID_FACTURE` )
    REFERENCES `FACTURE` (`ID_FACTURE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `VILLE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `VILLE` ;

CREATE  TABLE IF NOT EXISTS `VILLE` (
  `ID_VILLE` INT(11) NOT NULL AUTO_INCREMENT ,
  `NOM_VILLE` VARCHAR(90) NOT NULL ,
  PRIMARY KEY (`ID_VILLE`) )
ENGINE = InnoDB
AUTO_INCREMENT = 60
DEFAULT CHARACTER SET = utf8;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;