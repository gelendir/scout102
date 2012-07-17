SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


INSERT INTO `CATEGORIE_CASE` (`ID_CAT_CASE`, `NOM`, `DESCRIPTION`, `TYPE_INPUT`) VALUES
(1, 'État médical', 'état médical', 1),
(2, 'Questions générales', 'questions générales', 1),
(3, 'Médicaments autorisés', 'En vente libre', 2);

INSERT INTO `CASE_A_COCHER` (`ID_CASE_A_COCHER`, `NOM_CASE`, `DESCRIPTION`, `ID_CAT_CASE`) VALUES
(42, 'Asthme', 'Asthme', 1),
(43, 'Diabète', 'Diabète', 1),
(44, 'Incontinence', 'Incontinence', 1),
(45, 'Problèmes neurologiques', 'Problèmes neurologiques', 1),
(46, 'Menstruations', 'Menstruations', 1),
(47, 'Problèmes cutanés', 'Problèmes cutanés', 1),
(48, 'Trouble auditif', 'Trouble auditif', 1),
(49, 'Acc. Vasculaire cérébral', 'Acc. vasculaire cérébral', 1),
(50, 'Épilepsie', 'Épilepsie', 1),
(51, 'Problèmes musculaires', 'Problèmes musculaires', 1),
(52, 'Maux de ventre', 'Maux de ventre', 1),
(53, 'Handicap intellectuel', 'Handicap intellectuel', 1),
(54, 'Problèmes digestifs', 'Problèmes digestifs', 1),
(55, 'Trouble respiratoire', 'Trouble respiratoire', 1),
(56, 'Conjonctivite', 'Conjonctivite', 1),
(57, 'Hypertension artérielle', 'Hypertension artérielle', 1),
(58, 'Malformation cardiaque', 'Malformation cardiaque', 1),
(59, 'Maux de dos', 'Maux de dos', 1),
(60, 'Otites', 'Otites', 1),
(61, 'Hypoglycémie', 'Hypoglycémie', 1),
(62, 'Handicap physique', 'Handicap physique', 1),
(63, 'Convulsions', 'Convulsions', 1),
(64, 'Hyperventilation', 'Hyperventilation', 1),
(65, 'Palpitations cardiaques', 'Palpitations cardiaques', 1),
(66, 'Maux de tête / migraine', 'Maux de tête / Migraine', 1),
(67, 'Perte de conscience', 'Perte de conscience', 1),
(68, 'Saignements de nez', 'Saignements de nez', 1),
(69, 'vaccins', 'Ses VACCINS sont à jour', 2),
(70, 'Lunettes', 'Il porte des LUNETTES', 2),
(71, 'TDAH', 'il a un DÉFICIT D''ATTENTION (TDAH)', 2),
(72, 'Nager', 'il sait NAGER', 2),
(73, 'Épipen', 'il possède un ÉPIPEN', 2),
(74, 'Appareil', 'Il porte un APPAREIL (auditif, dentaire, etc.)', 2),
(75, 'Cauchemars', 'Il fait des CAUCHEMARS ou de l''INSOMNIE', 2),
(76, 'Anti-histaminique', 'Anti-histaminique pour allergies (Benadryl, etc.)', 3),
(77, 'Acétaminophène', 'Acétaminophène (Tylénol, Tempra, etc.)', 3),
(78, 'Ibuprophène', 'Ibuprophène (Advil, Motrin, etc.)', 3),
(79, 'Anti-émétique', 'Anti-émétique (Gravol)', 3),
(80, 'Antibiotique en crème', 'Antibiotique en crème (Polysporin)', 3),
(81, 'Traitement pour piqûres', 'Traitement pour piqûres (AfterBite, Calamine)', 3),
(82, 'Crème pour coups de soleil', 'Crème pour coups de soleil (Aloès)', 3);

INSERT INTO `CATEGORIE_CHAMP_TEXTE` (`ID_CAT_CHAMP_TEXTE`, `TITRE`, `DESCTRIPTION`) VALUES
(1, 'Médicaments sous posologie', 'Médicaments sous posologie'),
(2, 'Allergies', 'allergies'),
(3, 'Peurs et phobies', 'peurs et phobies'),
(4, 'Informations scolaires', 'scolarité'),
(5, 'Autres activités', 'autres activités'),
(6, 'Autres conditions médicales ou particularités', 'conditions autres');

INSERT INTO `ECOLE` (`ID_ECOLE`, `NOM_ECOLE`) VALUES
(1, 'École desBeaux-Prés et de la Pionnière'),
(2, 'École du Bois-Joli et du Bocage'),
(3, 'École de la Châtelaine et de la Place-de-l''Éveil'),
(4, 'École des Feux-Follets, de Saint-Laurent et de Sainte-Famille'),
(5, 'École du Petit-Prince'),
(6, 'École Montagnac'),
(7, 'École Beausoleil'),
(8, 'École des Cimes'),
(9, 'École de la Farandole'),
(10, 'École Marie-Renouard'),
(11, 'École Monseigneur-Robert'),
(12, 'École du Parc'),
(13, 'École de la Primerose'),
(14, 'École aux Quatre-Vents'),
(15, 'École la Ribambelle'),
(16, 'École Saint-Édouard'),
(17, 'École de Saint-Michel'),
(18, 'École Sainte-Chrétienne'),
(19, 'École du Sous-Bois'),
(20, 'École optionnelle Yves-Prévost'),
(21, 'École du Boisé'),
(22, 'École du Bourg-Royal'),
(23, 'École du Cap-Soleil et des Loutres'),
(24, 'École du Châtelet'),
(25, 'École de l''Escalade'),
(26, 'École de l''Escale et du Plateau'),
(27, 'École de la Fourmilière'),
(28, 'École Guillaume-Mathieu'),
(29, 'École Maria-Goretti'),
(30, 'École Chabot et de l''Oasis'),
(31, 'École du Parc-Orléans'),
(32, 'École du Rucher'),
(33, 'École de l''Arc-en-Ciel'),
(34, 'École de la Passerelle'),
(35, 'École du Ruisselet et Notre-Dame-de-Grâce (cap des neiges 1 et 2)'),
(36, 'École du Trivent'),
(37, 'École du Harfang-des-Neiges'),
(38, 'École secondaire du Mont-Sainte-Anne'),
(39, 'Académie Sainte-Marie'),
(40, 'École secondaire de la Courvilloise'),
(41, 'École secondaire Samuel-De Champlain'),
(42, 'École secondaire de la Seignerie'),
(43, 'Polyvalente de Charlesbourg'),
(44, 'École secondaire Saint-Pierre et des Sentiers'),
(45, 'École secondaire Le Sommet');

INSERT INTO `ROLE` (`ID_ROLE`, `NOM_ROLE`, `DESCRIPTION`) VALUES
(1, 'Administrateur', 'Administrateur');

INSERT INTO `TYPE_IMPLICATION` (`ID_TYPE_IMPLICATION`, `TITRE_IMPLICATION`, `DESCRIPTION`) VALUES
(1, 'Animation', 'Animation'),
(2, 'Accompagnement', 'Accompagnement (sorties)'),
(3, 'Cuisine', 'Cuisine (cuistot)'),
(4, 'Gestion/Comptabilité', 'Gestion/Comptabilité'),
(5, 'Couture, costumes', 'Couture, costumes'),
(6, 'Administrateur', 'Administrateur');

INSERT INTO `IMPLICATION_ROLE` (`ID_TYPE_IMPLICATION`, `ID_ROLE`) VALUES
(6, 1);

INSERT INTO `MODE_PAIEMENT` (`ID_MODE_PAIEMENT`, `NOM_MODE`, `DESCRIPTION`) VALUES
(1, 'Argent', 'Argent'),
(2, 'Chèque', 'Chèque'),
(3, 'Paypal', 'Paiement en ligne');

INSERT INTO `PROGRAMME` (`ID_PROGRAMME`, `NOM_PROGRAMME`, `AGE_MIN`, `AGE_MAX`) VALUES
(1, 'Castors', 7, 8),
(2, 'Hirondelles', 7, 8),
(3, 'Louveteaux', 9, 11),
(4, 'Exploratrices', 9, 11),
(5, 'Éclaireurs', 11, 14),
(6, 'Intrépides', 11, 14),
(7, 'Pionniers/Pionnières', 14, 17),
(8, 'Scouts-Ainés', 17, 21);

INSERT INTO `TARIF` (`ID_TARIF`, `MONTANT`, `DATE_VERSEMENT`, `NO_ENFANT`, `RABAIS`, `TOTAL`) VALUES
(1, 95, '2011-10-20', 1, 0, 0),
(2, 75, '2011-10-20', 1, 1, 0),
(3, 195, '2011-10-20', 1, 0, 1),
(4, 175, '2011-10-20', 1, 1, 1),
(5, 50, '2011-12-20', 1, 0, 0),
(6, 50, '2012-02-20', 1, 0, 0),
(7, 35, '2011-10-20', 2, 0, 0),
(8, 70, '2011-12-20', 2, 0, 0),
(9, 70, '2012-02-20', 2, 0, 0),
(10, 175, '2011-10-20', 2, 0, 1),
(11, 70, '2011-10-20', 3, 0, 0),
(12, 50, '2011-12-20', 3, 0, 0),
(13, 35, '2012-02-20', 3, 0, 0),
(14, 155, '2011-10-20', 3, 0, 1),
(15, 50, '2011-10-20', 4, 0, 0),
(16, 80, '2011-12-20', 4, 0, 0),
(17, 25, '2012-02-20', 4, 0, 0),
(18, 155, '2011-12-20', 4, 0, 1);

INSERT INTO `TYPE_AUTORISATION` (`ID_TYPE_AUTO`, `TITRE`, `DESCRIPTION`) VALUES
(1, 'Photogragies', 'J''autorise le 102e Groupe scout des Laurentides et le District de Québec à publier anonymement des photos de mon enfant dans le but de faire la promotion du scoutisme.'),
(2, 'Activités aquatiques', 'J''autorise mon enfant à participer à des activités aquatiques (exemple: baignade, piscine)');

INSERT INTO `VILLE` (`ID_VILLE`, `NOM_VILLE`) VALUES
(1, 'Baie-Saint-Paul'),
(2, 'Baie-Sainte-Catherine'),
(3, 'Beaupré'),
(4, 'Boischatel'),
(5, 'Cap-Santé'),
(6, 'Château-Richer'),
(7, 'Clermont'),
(8, 'Deschambault-Grondines'),
(9, 'Donnacona'),
(10, 'Fossambault-sur-le-Lac'),
(11, 'L''Ancienne-Lorette'),
(12, 'L''Ange-Gardien'),
(13, 'L''Isle-aux-Coudres'),
(14, 'La Malbaie'),
(15, 'Lac-Beauport'),
(16, 'Lac-Delage'),
(17, 'Lac-Saint-Joseph'),
(18, 'Lac-Sergent'),
(19, 'Les Éboulements'),
(20, 'Neuville'),
(21, 'Notre-Dame-des-Anges'),
(22, 'Notre-Dame-des-Monts'),
(23, 'Petite-Rivière-Saint-François'),
(24, 'Pont-Rouge'),
(25, 'Portneuf'),
(26, 'Québec'),
(27, 'Rivière-à-Pierre'),
(28, 'Saint-Aimé-des-Lacs'),
(29, 'Saint-alban'),
(30, 'Saint-Augustin-de-Desmaures'),
(31, 'Saint-Basile'),
(32, 'Saint-Casimir'),
(33, 'Sainte-Ferréol-les-Neiges'),
(34, 'Saint-François-de-l''Île-d''Orléans'),
(35, 'Saint-Gabriel-de-Valcartier'),
(36, 'Saint-Gilbert'),
(37, 'Saint-Hilarion'),
(38, 'Saint-Irénée'),
(39, 'Saint-Jean-de-l''Île-d''Orléans'),
(40, 'Saint-Joachim'),
(41, 'Saint-Laurent-de-l''Île-d''Orléans'),
(42, 'Saint-Léonard-de-Portneuf'),
(43, 'Saint-Louis-de-Gonzague-du-Cap-Tourmente'),
(44, 'Saint-Marc-des-Carrières'),
(45, 'Saint-Pierre-de-l''Île-d''Orléans'),
(46, 'Saint-Raymond'),
(47, 'Saint-Siméon'),
(48, 'Saint-Thuribe'),
(49, 'Saint-Tite-des-Caps'),
(50, 'Saint-Ubalde'),
(51, 'Saint-Urbain'),
(52, 'Saint-Anne-de-Beaupré'),
(53, 'Sainte-Brigitte-de-Laval'),
(54, 'Sainte-Catherine-de-la-Jacques-Cartier'),
(55, 'Sainte-Christine-d''Auvergne'),
(56, 'Sainte-Famille'),
(57, 'Sainte-Pétronille'),
(58, 'Shanon'),
(59, 'Stoneham-et-Tewkesbury');

INSERT INTO NIVEAU_SCOLAIRE
(
    ID_NIVEAU_SCOLAIRE,
    DESCRIPTION_NIVEAU
)
VALUES
(1, '1ère année'),
(2, '2e année'),
(3, '3e année'),
(4, '4e année'),
(5, '5e année'),
(6, '6e année'),
(7, 'Secondaire 1'),
(8, 'Secondaire 2'),
(9, 'Secondaire 3'),
(10, 'Secondaire 4'),
(11, 'Secondaire 5');
-- Insert pour un utilisateur



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
