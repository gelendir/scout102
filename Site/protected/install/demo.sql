SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

INSERT INTO `FAMILLE` (`ID_FAMILLE`) VALUES
(1),
(2),
(3),
(4);

INSERT INTO `ADRESSE` (`ID_ADRESSE`, `ADRESSE_RUE`, `VILLE`, `PROVINCE`, `CODE_POSTAL`) VALUES
(1, '1 admin', 'Québec', 'QC', 'G1G1G1'),
(2, '555 des sapins', 'Québec', 'QC', 'G1G1G1'),
(3, '444 des grand pins', 'Québec', 'QC', 'G1G1G1'),
(4, '333 des miches', 'Saint-Basile', 'QC', 'G1G1G1'),
(5, '666 du chemin vert', 'Québec', 'QC', 'G1G1G1');

INSERT INTO `ADULTE` (`ID_ADULTE`, `PRENOM`, `NOM`, `NOM_UTILISATEUR`, `MOT_DE_PASSE`, `COURRIEL`, `SEXE`, `NO_TEL_PRINCIPAL`, `NO_TEL_SECONDAIRE`, `NO_TEL_AUTRE`, `EMPLOI`, `ID_ADRESSE_PRINC`, `PARENT`, `COMPTE_ACTIF`, `IMPLICATION_AUTRE`) VALUES
(1, 'Administrateur', 'Principal', 'admin@lucrobi.8m.com', '$1$HY/.ER0.$fQliNwE8/R.0L50vMTxaT.', 'admin@lucrobi.8m.com', 'M', '418-555-5555', '', '', 'Administrateur', 1, 0, 1, ''),
(2, 'Pierre', 'Robichaud', 'pierre@lucrobi.8m.com', '$1$J6/.eY2.$8s6uzsIZstKcFHTrmznhF/', 'pierre@lucrobi.8m.com', 'M', '418-555-5555', '', '', 'Entrepreneur', 2, 1, 1, ''),
(3, 'Lucille', 'Robichaud', 'lucille@lucrobi.8m.com', '$1$iZ1.DU0.$zc4nTvciz7tepQmWQWEUI.', 'lucille@lucrobi.8m.com', 'M', '418-555-5555', '', '', 'Caissière', 4, 1, 1, ''),
(4, 'Paul', 'Gamache', 'paul@lucrobi.8m.com', '$1$pE2.814.$WtqAyC65Oz1OP2um446C4.', 'paul@lucrobi.8m.com', 'M', '418-555-5555', '', '', 'Garagiste', 5, 1, 1, '');

INSERT INTO `FACTURE` (`ID_FACTURE`, `MONTANT`, `DATE_FACTURE`, `ID_MODE_PAIEMENT`) VALUES
(1, 95, '2011-12-08 10:55:00', 1),
(2, 50, '2011-12-08 10:55:07', 1),
(3, 50, '2011-12-08 10:55:14', 1),
(4, 35, '2011-12-08 10:55:22', 1);

INSERT INTO `NOTIFICATION` (`ID_NOTIFICATION`, `TITRE`, `MESSAGE`, `DATE_ENVOIE`, `LU`, `IMPORTANT`, `DATE_LU`) VALUES
(1, 'Fiche medicale modifiee', 'La fiche medicale de Luc Robichaud a ete modifiee par Pierre Robichaud (parent)', '2011-12-08 00:00:00', 0, 0, NULL),
(2, 'Fiche medicale modifiee', 'La fiche de scout(information + fiche medicale) de Émilie Gamache a ete modifiee par Lucille Robichaud (admin)', '2011-12-08 00:00:00', 1, 0, NULL);

INSERT INTO `SCOUT` (`ID_SCOUT`, `PRENOM`, `NOM`, `DATE_NAISSANCE`, `SEXE`, `NO_ASSURANCE_MALADIE`, `DATE_FIN_CARTE_MEDICAL`, `PARTICULARITE`, `ID_ADRESSE_PRINC`, `CONT_URG_NOM`, `CONT_URG_NO_TEL`, `CONT_URG_LIEN_JEUNE`, `CONT_URG_PRENOM`, `ACTIF`, `ANNEE_INSCRIPTION`) VALUES
(1, 'Luc', 'Robichaud', '1997-05-23 00:00:00', 'M', 'ROBL00052399', '2013-01-08 00:00:00', '', 3, 'Robichaud', '418-555-5555', 'Parrin', 'Guy', 1, 2011),
(2, 'Mathieu', 'Robichaud', '2001-04-01 00:00:00', 'M', 'ROBM01040199', '2012-01-08 00:00:00', '', 3, 'Losier', '418-555-5555', 'Parrin', 'Conrad', 1, 2011),
(3, 'Marie-Pier', 'Robichaud', '2002-07-03 00:00:00', 'F', 'ROBM02570399', '2013-01-08 00:00:00', '', 4, 'Losier', '418-555-5555', 'Marraine', 'Nathalie', 1, 2011),
(4, 'Émilie', 'Gamache', '2004-03-02 00:00:00', 'F', 'GAME01530299', '2013-01-08 00:00:00', '', 5, 'James', '418-555-5555', 'Amie de la famille', 'Yolande', 1, 2011);

INSERT INTO `RECU_IMPOT` (`ID_RECU_IMPOT`, `MONTANT`, `ANNEE_IMPOSITION`, `DATE_EMISSION`, `NO_RECU`, `ID_SCOUT`, `NOM_PERSONNE`, `COURRIEL_D_ENVOIE`, `ACTIVITE`, `PRENOM_PERSONNE`, `ID_ADRESSE`) VALUES
(1, 195, 2011, NULL, 1, 1, 'Robichaud', 'admin@lucrobi.8m.com', 'Membre de l''unité des Membre des scouts', 'Pierre', 2),
(2, 175, 2011, NULL, 2, 2, 'Robichaud', 'pierre@lucrobi.8m.com', 'Membre de l''unité des Membre des scouts', 'Pierre', 2),
(3, 195, 2011, NULL, 3, 3, 'Robichaud', 'lucille@lucrobi.8m.com', 'Membre de l''unité des Membre des scouts', 'Lucille', 4),
(4, 195, 2011, NULL, 4, 4, 'Gamache', '', 'Membre de l''unité des Membre des scouts', 'Paul', 5);

INSERT INTO `SCOLARITE` (`ID_SCOLARITE`, `ID_SCOUT`, `ID_NIVEAU`, `NOM_ECOLE`, `NOM_ENSEIGNANT`) VALUES
(1, 1, 5, 'École Saint-Édouard', 'Guy LaFonte'),
(2, 2, 4, 'École Saint-Édouard', 'Étienne Rochette'),
(3, 3, 3, 'École Sainte-Chrétienne', 'Annie Villeneuve'),
(4, 4, 6, 'Académie Sainte-Marie', 'Hector Vachon');

INSERT INTO `FICHE_MEDICALE` (`ID_FICHE_MEDICALE`, `DATE_CREATION`, `ID_UTIL_CREATION`, `DATE_MAJ`, `ID_UTIL_MAJ`, `ID_SCOUT`, `COMMENTAIRES`, `FICHE_CONFIRME`) VALUES
(1, '2011-12-08 10:02:03', 2, '2011-12-08 10:49:01', 2, 1, '', 1),
(2, '2011-12-08 10:08:00', 2, '2011-12-08 10:08:00', 2, 2, '', 1),
(3, '2011-12-08 10:33:30', 3, '2011-12-08 10:33:30', 3, 3, '', 1),
(4, '2011-12-08 10:46:54', 4, '2011-12-08 10:54:22', 3, 4, '', 1);

INSERT INTO `ADRESSE_FAMILLE` (`ID_ADRESSE`, `ID_FAMILLE`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 3),
(5, 4);

INSERT INTO `AUTORISATION` (`ID_SCOUT`, `ID_TYPE_AUTO`, `ACCEPTATION`) VALUES
(1, 1, 1),
(1, 2, 1),
(2, 1, 1),
(2, 2, 0),
(3, 1, 0),
(3, 2, 1),
(4, 1, 1),
(4, 2, 1);

INSERT INTO `REPONSE_CASE` (`ID_FICHE_MEDICALE`, `ID_CASE_A_COCHER`, `REPONSE`, `ID_REPONSE_CASE`) VALUES
(1, 42, 1, 1),
(1, 43, 1, 2),
(1, 44, 0, 3),
(1, 45, 0, 4),
(1, 46, 0, 5),
(1, 47, 0, 6),
(1, 48, 0, 7),
(1, 49, 0, 8),
(1, 50, 0, 9),
(1, 51, 0, 10),
(1, 52, 0, 11),
(1, 53, 0, 12),
(1, 54, 0, 13),
(1, 55, 0, 14),
(1, 56, 0, 15),
(1, 57, 0, 16),
(1, 58, 0, 17),
(1, 59, 0, 18),
(1, 60, 0, 19),
(1, 61, 0, 20),
(1, 62, 0, 21),
(1, 63, 0, 22),
(1, 64, 0, 23),
(1, 65, 0, 24),
(1, 66, 0, 25),
(1, 67, 0, 26),
(1, 68, 0, 27),
(1, 69, 1, 28),
(1, 70, 1, 29),
(1, 71, 0, 30),
(1, 72, 1, 31),
(1, 73, 0, 32),
(1, 74, 0, 33),
(1, 75, 0, 34),
(1, 76, 1, 35),
(1, 77, 1, 36),
(1, 78, 1, 37),
(1, 79, 1, 38),
(1, 80, 1, 39),
(1, 81, 1, 40),
(1, 82, 1, 41),
(2, 42, 0, 42),
(2, 43, 0, 43),
(2, 44, 1, 44),
(2, 45, 0, 45),
(2, 46, 0, 46),
(2, 47, 0, 47),
(2, 48, 0, 48),
(2, 49, 0, 49),
(2, 50, 0, 50),
(2, 51, 0, 51),
(2, 52, 0, 52),
(2, 53, 0, 53),
(2, 54, 0, 54),
(2, 55, 0, 55),
(2, 56, 0, 56),
(2, 57, 0, 57),
(2, 58, 0, 58),
(2, 59, 0, 59),
(2, 60, 0, 60),
(2, 61, 0, 61),
(2, 62, 0, 62),
(2, 63, 0, 63),
(2, 64, 0, 64),
(2, 65, 0, 65),
(2, 66, 0, 66),
(2, 67, 0, 67),
(2, 68, 0, 68),
(2, 69, 1, 69),
(2, 70, 1, 70),
(2, 71, 0, 71),
(2, 72, 0, 72),
(2, 73, 0, 73),
(2, 74, 0, 74),
(2, 75, 0, 75),
(2, 76, 1, 76),
(2, 77, 1, 77),
(2, 78, 1, 78),
(2, 79, 1, 79),
(2, 80, 1, 80),
(2, 81, 1, 81),
(2, 82, 1, 82),
(3, 42, 0, 83),
(3, 43, 0, 84),
(3, 44, 0, 85),
(3, 45, 0, 86),
(3, 46, 0, 87),
(3, 47, 0, 88),
(3, 48, 0, 89),
(3, 49, 0, 90),
(3, 50, 0, 91),
(3, 51, 0, 92),
(3, 52, 0, 93),
(3, 53, 0, 94),
(3, 54, 0, 95),
(3, 55, 0, 96),
(3, 56, 0, 97),
(3, 57, 0, 98),
(3, 58, 0, 99),
(3, 59, 0, 100),
(3, 60, 1, 101),
(3, 61, 0, 102),
(3, 62, 0, 103),
(3, 63, 0, 104),
(3, 64, 0, 105),
(3, 65, 0, 106),
(3, 66, 0, 107),
(3, 67, 0, 108),
(3, 68, 0, 109),
(3, 69, 1, 110),
(3, 70, 1, 111),
(3, 71, 0, 112),
(3, 72, 1, 113),
(3, 73, 0, 114),
(3, 74, 0, 115),
(3, 75, 0, 116),
(3, 76, 1, 117),
(3, 77, 1, 118),
(3, 78, 1, 119),
(3, 79, 1, 120),
(3, 80, 1, 121),
(3, 81, 1, 122),
(3, 82, 1, 123),
(4, 42, 0, 124),
(4, 43, 0, 125),
(4, 44, 0, 126),
(4, 45, 0, 127),
(4, 46, 0, 128),
(4, 47, 0, 129),
(4, 48, 1, 130),
(4, 49, 0, 131),
(4, 50, 0, 132),
(4, 51, 0, 133),
(4, 52, 0, 134),
(4, 53, 0, 135),
(4, 54, 0, 136),
(4, 55, 0, 137),
(4, 56, 0, 138),
(4, 57, 0, 139),
(4, 58, 0, 140),
(4, 59, 0, 141),
(4, 60, 0, 142),
(4, 61, 0, 143),
(4, 62, 0, 144),
(4, 63, 0, 145),
(4, 64, 0, 146),
(4, 65, 0, 147),
(4, 66, 0, 148),
(4, 67, 0, 149),
(4, 68, 0, 150),
(4, 69, 1, 151),
(4, 70, 0, 152),
(4, 71, 0, 153),
(4, 72, 1, 154),
(4, 73, 0, 155),
(4, 74, 1, 156),
(4, 75, 0, 157),
(4, 76, 1, 158),
(4, 77, 1, 159),
(4, 78, 1, 160),
(4, 79, 0, 161),
(4, 80, 0, 162),
(4, 81, 0, 163),
(4, 82, 1, 164);

INSERT INTO `IMPLICATION` (`ID_TYPE_IMPLICATION`, `ID_ADULTE`, `ACCORDE`, `DEMANDE`, `ID_IMPLICATION`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 0, 0, 2),
(3, 1, 0, 0, 3),
(4, 1, 0, 0, 4),
(5, 1, 0, 0, 5),
(6, 1, 1, 1, 6),
(1, 2, 1, 1, 7),
(2, 2, 0, 0, 8),
(3, 2, 0, 0, 9),
(4, 2, 0, 0, 10),
(5, 2, 0, 0, 11),
(6, 2, 0, 0, 12),
(1, 3, 1, 1, 13),
(2, 3, 0, 0, 14),
(3, 3, 0, 1, 15),
(4, 3, 0, 0, 16),
(5, 3, 0, 0, 17),
(6, 3, 0, 0, 18),
(1, 4, 0, 1, 19),
(2, 4, 0, 0, 20),
(3, 4, 0, 0, 21),
(4, 4, 0, 0, 22),
(5, 4, 0, 0, 23),
(6, 4, 0, 0, 24);

INSERT INTO `TEXTE_FICHE_CHAMP` (`ID_FICHE_MEDICALE`, `ID_CAT_CHAMP_TEXTE`, `TEXTE`, `ID_TEXTE_FICHE_CHAMP`) VALUES
(1, 1, '', 1),
(1, 2, '', 2),
(1, 3, '', 3),
(1, 5, '', 4),
(1, 6, '', 5),
(2, 1, '', 6),
(2, 2, '', 7),
(2, 3, 'araignée  ', 8),
(2, 5, '', 9),
(2, 6, '', 10),
(3, 1, '', 11),
(3, 2, 'chats', 12),
(3, 3, 'feu', 13),
(3, 5, '', 14),
(3, 6, '', 15),
(4, 1, '', 16),
(4, 2, '', 17),
(4, 3, '', 18),
(4, 5, '', 19),
(4, 6, '', 20);

INSERT INTO `FAMILLE_ADULTE` (`ID_FAMILLE`, `ID_ADULTE`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

INSERT INTO `FAMILLE_SCOUT` (`ID_FAMILLE`, `ID_SCOUT`) VALUES
(2, 1),
(2, 2),
(3, 3),
(4, 4);

INSERT INTO `T_VERSEMENT` (`ID_VERSEMENT`, `ID_SCOUT`, `ID_FAMILLE`, `ID_TARIF`, `ETAT`) VALUES
(1, 1, 2, 1, 1),
(2, 1, 2, 5, 1),
(3, 1, 2, 6, 1),
(4, 2, 2, 7, 1),
(5, 2, 2, 8, 0),
(6, 2, 2, 9, 0),
(7, 3, 3, 1, 0),
(8, 3, 3, 5, 0),
(9, 3, 3, 6, 0),
(10, 4, 4, 1, 0),
(11, 4, 4, 5, 0),
(12, 4, 4, 6, 0);

INSERT INTO `VERSEMENT_FACTURE` (`ID_FACTURE`, `ID_VERSEMENT`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

INSERT INTO `UNITE` (`ID_UNITE`, `NOM_UNITE`, `DATE_CREATION`, `ID_PROGRAMME`) VALUES
(1, 'Castores valeureux', '2011-12-08 00:00:00', 1),
(2, 'Éclaireurs lumineux', '2011-12-08 00:00:00', 5),
(3, 'Louvetaux solidaire', '2011-12-08 00:00:00', 3),
(4, 'Pionniers inovateurs', '2011-12-08 00:00:00', 7),
(5, 'Hirondelles gracieuses', '2011-12-08 00:00:00', 2);

INSERT INTO `ANIMATEUR_UNITE` (`ID_ADULTE`, `ID_UNITE`) VALUES
(2, 1),
(2, 2),
(4, 3),
(4, 4),
(2, 5);
