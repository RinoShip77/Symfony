-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 13, 2023 at 01:50 PM
-- Server version: 8.1.0
-- PHP Version: 8.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `electrolib_electrolib`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
CREATE TABLE IF NOT EXISTS `authors` (
  `idAuthor` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`idAuthor`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`idAuthor`, `firstName`, `lastName`) VALUES
(1, 'Charles', 'Dickens'),
(2, 'Antoine', 'de Saint-Exupéry'),
(3, 'J.R.R', 'Tolkien'),
(4, 'Agatha', 'Christie'),
(5, 'Cao', 'xuequin'),
(6, 'Dan', 'Brown'),
(7, 'Paulo', 'Coelho'),
(8, 'J.D.', 'Salinger'),
(9, 'Gabriel', 'Garcia marquez'),
(10, 'Vladimir', 'Nabokov'),
(11, 'Johanna', 'Spyri'),
(12, 'Benjamin', 'Spock'),
(13, 'Lucy', 'Maud Montgomery'),
(14, 'Anna', 'Sewell'),
(15, 'Albert', 'Camus'),
(16, 'Victor', 'Hugo'),
(17, 'Alexandre', 'Dumas'),
(18, 'Jean-Paul', 'Sartre'),
(19, 'Charles', 'Beaudelaire'),
(20, 'Jules', 'Verne'),
(21, 'Michel', 'Tremblay'),
(22, 'Réjean', 'Duchrame'),
(23, 'Anne', 'Hébert'),
(24, 'Gabrielle', 'Roy'),
(25, 'Kim', 'Thuy'),
(26, 'gaétan', 'Soucy'),
(27, 'Robert', 'James Waller'),
(28, 'eiichiro', 'oda'),
(29, 'inio', 'asano');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `idBook` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publishedDate` datetime NOT NULL,
  `originalLanguage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isRecommended` tinyint(1) NOT NULL,
  `idGenre` int NOT NULL,
  `idAuthor` int NOT NULL,
  `idStatus` int NOT NULL,
  PRIMARY KEY (`idBook`),
  KEY `IDX_4A1B2A92949470E5` (`idGenre`),
  KEY `IDX_4A1B2A92DEBE7052` (`idAuthor`),
  KEY `IDX_4A1B2A921811CD86` (`idStatus`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`idBook`, `title`, `description`, `isbn`, `cover`, `publishedDate`, `originalLanguage`, `isRecommended`, `idGenre`, `idAuthor`, `idStatus`) VALUES
(1, 'L\'Avalée des avalés', 'Les enfants en mènent large. Ils peuvent dire pis qu\'aimer, pis que pendre. Ils ont tous les droits Entre vingt et vingt-trois ans (l\'âge de ce roman), on a toutes les lois, toutes en même temps. Si on est doué, on les apprend. Si on est pas content, on se déprend, en se souvenant, en imaginant.', '9782070373932', '/', '1982-06-02 00:00:00', 'Français', 0, 13, 22, 2),
(2, 'Les Fous de Bassan', 'Griffin Creek, un village du Québec, situé là où le fleuve devient immense comme la mer.C\'est un lieu étrange et presque hors du monde. Un soir de l\'été 1936, Olivia et Nora, deux adolescentes enviées ou désirées pour leur beauté, disparaissent près du rivage.', '9782020336482', '/', '1998-03-19 00:00:00', 'Français', 0, 13, 23, 1),
(3, 'Kamouraska', 'Au milieu du XIXe siècle, dans la ville de Québec, une femme veille son mari qui va mourir.Elle n\'est là qu\'en apparence car elle revit, instant par instant, fragment par fragment, sa propre histoire. Une histoire de fureur et de neige, une histoire d\'amour éperdu', '9782020314299', '/', '1997-04-14 00:00:00', 'Français', 0, 13, 23, 1),
(4, 'L\'hiver de force', 'Le voyage immobile de deux amants, Nicole et André, dans un appartement de Montréal, grâce à des véhicules qui ont pour noms télévision, alcool, herbe, acide..', '9782070376223', '/', '1985-01-02 00:00:00', 'Français', 0, 13, 22, 1),
(5, 'Bonheur d\'occasion', 'Dans le quartier montréalais de Saint-Henri, un peuple d\'ouvriers et de petits employés canadiens-français est désespérement en quête de bonheur. Florentine croit avoir trouvé le sien dans l\'amour ; Rose-Anna le cherche dans le bien-être de sa famille ; Azarius fuit dans le rêve ; Emmanuel s\'enrole ; Jean entreprend son ascension sociale. Chacun, à sa manière, invente sa propre voie de salut et chacun, à sa manière, échoue. Mais leur sort est en même temps celui de million d\'autres, non seulement à Montréal mais partout ailleurs, dans un monde en proie à la guerre.', '9782764606995', '/', '2009-08-19 00:00:00', 'Français', 0, 13, 24, 1),
(6, 'La grosse femme d\'à côté est enceinte', 'Au cœur du Plateau Mont-Royal, ce quartier populaire de Montréal qui prend des allures de véritable microcosme social, une femme de quarante-deux ans, enceinte de sept mois, devient le centre d\'un monde réaliste et fantasmagorique. Dans la journée du samedi 2 mai 1942, alors que tourbillonnent émotions et drames de la vie privée, le romancier met en place, avec un grand bonheur d\'écriture, les acteurs du premier tome du puissant cycle romanesque des Chroniques du Plateau Mont-Royal.', '9782742706372', '/', '2011-10-31 00:00:00', 'Français', 0, 19, 21, 1),
(7, 'La petite fille qui aimait trop les allumettes', 'Nous avons dû prendre l\'univers en main mon frère et moi car un matin un peu avant l\'aube papa rendit l\'âme sans crier gare. Sa dépouille crispée dans une douleur dont il ne restait plus que l\'écorce, ses décrets si subitement tombés en poussière, tout ça gisait dans la chambre de l\'étage où papa nous commandait tout, la veille encore', '9782764600238', '/', '2000-02-01 00:00:00', 'Français', 0, 13, 26, 1),
(8, 'La détresse et l\'enchantement', 'Ce livre retrace les années de formation de G. Roy, depuis son enfance manitobaine jusqu\'à son retour d\'Europe à la fin de la Deuxième Guerre mondiale, c\'est-à-dire 3 ou 4 ans avant qu\'elle commence à écrire Bonheur d\'occasion', '9782890527683', '/', '1996-08-07 00:00:00', 'Français', 0, 13, 24, 1),
(9, 'Le petit Prince', 'Le Petit Prince est une œuvre de langue française, la plus connue d\'Antoine de Saint-Exupéry. Publié en 1943 à New York simultanément à sa traduction anglaise, c\'est une œuvre poétique et philosophique sous l\'apparence d\'un conte pour enfants.', '9783140464079', '/', '1943-04-06 00:00:00', 'Français', 0, 16, 2, 1),
(10, 'l\'étranger', 'L\'Étranger, est le premier roman publié d\'Albert Camus, paru en 1942. Les premières esquisses datent de 1938, mais le roman ne prend vraiment forme que dans les premiers mois de 1940 et sera travaillé par Camus jusqu’en 1941.', '9782070360024', '/', '1942-05-19 00:00:00', 'Français', 0, 13, 15, 2),
(11, 'La peste', 'Naturellement, vous savez ce que c\'est, Rieux ? - J\'attends le résultat des analyses. - Moi, je le sais. Et je n\'ai pas besoin d\'analyses. J\'ai fait une partie de ma carrière en Chine, et j\'ai vu quelques cas à Paris, il y a une vingtaine d\'années. Seulement, on n\'a pas osé leur donner un nom, sur le moment... Et puis, comme disait un confrère : \"C\'est impossible, tout le monde sait qu\'elle a disparu de l\'Occident.\" Oui, tout le monde le savait, sauf les morts. Allons, Rieux, vous savez aussi bien que moi ce que c\'est... - Oui, Castel, dit-il, c\'est à peine croyable. Mais il semble bien que ce soit la peste.', '9782070360420', '/', '1947-06-10 00:00:00', 'Français', 0, 13, 15, 2),
(12, 'Les misérables', '1815, Jean Valjean, libéré du bagne, est accueilli par Mgr Myriel. L\'évêque de Digne l\'engage sur la voie du bien. Sous le nom de monsieur Madeleine, il s\'établit à Montreuil-sur-Mer. Fantine travaille dans ses ateliers pour nourrir Cosette, restée en pension à Montfermeil, chez les Thénardier. Mais Valjean n\'est pas quitte envers la justice, qui le traque en la personne de Javert.', '9782072730672', '/', '2017-08-21 00:00:00', 'Français', 0, 17, 16, 1),
(13, 'Le Compte de Monte-Cristo', '1815. Accusé de bonapartisme, Edmond Dantès est emprisonné au château d\'If, victime de deux rivaux, Fernand et Danglars, et de Villefort, un magistrat ambitieux. Grâce à l\'amitié de l\'abbé Faria, il s\'évade et peut alors assouvir sa vengeance. Texte intégral.', '9782072895647', '/', '2020-12-08 00:00:00', 'Français', 0, 13, 17, 1),
(14, 'nausée', 'Donc j\'étais tout à l\'heure au Jardin public. La racine du marronnier s\'enfonçait dans la terre, juste au-dessous de mon banc. Je ne me rappelais plus que c\'était une racine. Les mots s\'étaient évanouis et, avec eux, la signification des choses, leurs modes d\'emploi, les faibles repères que les hommes ont tracés à leur surface. J\'étais assis, un peu voûté, la tête basse, seul en face de cette masse noire et noueuse entièrement brute et qui me faisait peur. Et puis j\'ai eu cette illumination.', '9782070368051', '/', '2002-06-20 00:00:00', 'Français', 0, 13, 18, 2),
(15, 'Le Conte de deux villes', '1775. Après une longue détention à la Bastille, le Dr Manette part retrouver sa fille, Lucie, à Londres. C\'est également dans cette ville que vivent Charles Danay, un aristocrate français en exil, et Sydney Carton, un brillant avocat, tous deux fous d\'amour pour cette dernière. Sur fond de Révolution française, ces personnages sont bientôt plongés dans les tumultes de l\'histoire.', '9782377353873', '/', '2020-02-12 00:00:00', 'Anglais', 0, 1, 1, 1),
(16, 'Le Seigneur des anneaux', 'Une contrée paisible où vivent les Hobbits. Un anneau magique à la puissance infinie. Sauron, son créateur, prêt à dévaster le monde entier pour récupérer son bien. Frodon, jeune Hobbit, détenteur de l\'Anneau malgré lui. Gandalt, le Magicien, venu avertir Frodon du danger. Et voilà déjà les Cavaliers Noirs qui approchent.... C\'est ainsi que tout commence en Terre du Milieu entre le Comté et Mordor. C\'est ainsi que la plus grande légende est née..', '9782266286268', '/', '2018-10-29 00:00:00', 'Anglais', 0, 2, 3, 1),
(17, 'Ils étaient dix', 'Les dix invités sont arrivés sur l\'île du Nègre, mais rien ne semble normal : leur hôte est absent et quelqu\'un a déposé dans leur chambre une comptine intitulée Les dix petits Nègres. Tout bascule quand une voix accuse chacun des invités d\'un crime.', '9782253241782', '/', '2020-09-28 00:00:00', 'Anglais', 0, 6, 4, 1),
(18, 'Le Hobbit', 'Bilbo Sacquet, paisible et respectable petit hobbit aux pieds laineux, boit le thé avec le magicien Gandalf, accompagné de treize nains barbus. Cette invitation se révèle être une folle imprudence. Prologue du Seigneur des anneaux.', '9782253183822', '/', '2015-06-03 00:00:00', 'Anglais', 0, 4, 3, 2),
(19, ' Da vinci code', 'Professeur à Harvard et spécialiste de symbologie, Robert Langdon est appelé d\'urgence au Louvre : la police vient de retrouver le cadavre du conservateur, Jacques Saunière, au milieu de la Grande Galerie avec à ses côtés un message codé. Une enquête qui le conduit à la découverte d\'une très ancienne société secrète.', '9782253001171', '/', '2014-06-04 00:00:00', 'Français', 0, 6, 6, 1),
(20, ' L\'Alchimiste', 'Le récit de la quête de Santiago, un jeune berger andalou qui part à la recherche d\'un trésor enfoui au pied des pyramides. Dans le désert, initié par l\'alchimiste, il apprend à écouter son coeur, à lire les signes du destin et à aller au bout de son rêve.', '9782290258064', '/', '2021-04-20 00:00:00', 'portugais', 0, 2, 7, 2),
(21, 'The Catcher in the rye', 'The hero-narrator of THE CATCHER IN THE RYE is an ancient child of sixteen, a native New Yorker named Holden Caulfield. Through circumstances that tend to preclude adult, secondhand description, he leaves his prep school in Pennsylvania and goes underground in New York City for three days.', '9780316769488', '/', '1991-05-01 00:00:00', 'Anglais', 0, 10, 8, 1),
(22, 'The Bridges of Madison County', 'If you\'ve ever experienced the one true love of your life, a love that for some reason could never be, you will understand why readers all over the world are so moved by this small, unknown first novel that they became a publishing phen… ', '9780446516525', '/', '1991-04-13 00:00:00', 'Anglais', 0, 11, 27, 1),
(23, 'Cent ans de solitude', 'Une épopée vaste et multiple, un mythe haut en couleur plein de rêve et de réel. Histoire à la fois minutieuse et délirante d\'une dynastie : la fondation , par l\'ancêtre, d\'un village sud-américain isolé du reste du monde', '9782020238113', '/', '1995-03-13 00:00:00', 'espagnol', 0, 12, 9, 1),
(24, 'lolita', 'Actor James Mason masterfully reads the witty, poetic prose as his rolling British tongue humorously renders Nabokov\'s characters and settings in colorful three-dimension. Originally a tough sell to publishers because of its racy theme, Vladimir Nabokov\'s Lolita is now recognized as a twentieth-century classic. The story of a middle-aged man\'s overpowering desire for his pubescent step-daughter, Lolita somehow transcends its own eroticism and is, finally, one of the greatest love stories of all time.', '9780679723165', '/', '2009-07-21 00:00:00', 'Anglais', 1, 13, 10, 2),
(25, 'heidi', 'classic children books, perfect for your child please buy 10 out 10 book readers recommend this book it is the best book, better then the face book', '9780147514028', '/', '2014-08-28 00:00:00', 'Anglais', 0, 15, 11, 1),
(26, 'Anne de la maison aux pignons verts', 'Anne, une petite orpheline rousse à l’imagination débordante, est envoyée par erreur chez les Cuthbert, qui attendaient plutôt un garçon. Impulsive, volubile et gaffeuse, mais surtout brillante, optimiste et généreuse, Anne réussira-t-elle à gagner leur cœur?', '9782764449981', '/', '2023-05-15 00:00:00', 'Anglais', 0, 15, 13, 1),
(27, 'one piece vol 1', 'Luffy, un garçon espiègle, rêve de devenir le roi des pirates en trouvant le One Piece, un fabuleux trésor. Il a avalé par mégarde un fruit démoniaque qui l\'a transformé en homme-caoutchouc. Depuis il est capable de contorsionner son corps élastique mais il a perdu la faculté de nager. Avec l\'aide de ses amis, il va devoir affronter de redoutables pirates.', '9782723488525', '/', '2013-08-23 00:00:00', 'japonais', 0, 20, 28, 1),
(28, 'Bonne nuit punpun vol 1', 'Partis à la recherche du trésor de la cassette vidéo Punpun, Aiko et leurs camarades se retrouvent dans une usine désaffectée. Ils vont en être quittes pour quelques bonnes frayeurs.', '9782505014133', '/', '2012-03-05 00:00:00', 'japonais', 0, 20, 29, 1),
(29, 'Bonne nuit punpun vol 2', 'Le quotidien de Punpun est bouleversé le jour où son père blesse sa mère, lors d\'une violente dispute.', '9782505014140', '/', '2012-03-05 00:00:00', 'japonais', 0, 20, 29, 1),
(30, 'Bonne nuit punpun vol 3', 'Punpun est un enfant meurtri par une violente dispute durant laquelle son père a blessé sa mère.', '9782505014539', '/', '2012-05-04 00:00:00', 'japonais', 0, 20, 29, 1),
(31, 'one piece vol 2', 'Lufy, un garçon espiègle, rêve de devenir le roi des pirates en trouvant le One Piece, un fabuleux trésor. Il a avalé par mégarde un fruit démoniaque qui l\'a transformé en homme-caoutchouc. Depuis il est capable de contorsionner son corps élastique mais il a perdu la faculté de nager. Avec l\'aide de ses amis, il va devoir affronter de redoutables pirates.', '9782723489898', '/', '2013-08-23 00:00:00', 'japonais', 0, 20, 28, 1);

-- --------------------------------------------------------

--
-- Table structure for table `borrows`
--

DROP TABLE IF EXISTS `borrows`;
CREATE TABLE IF NOT EXISTS `borrows` (
  `idBorrow` int NOT NULL AUTO_INCREMENT,
  `borrowedDate` datetime NOT NULL,
  `dueDate` datetime NOT NULL,
  `returnedDate` datetime DEFAULT NULL,
  `idUser` int NOT NULL,
  `idBook` int NOT NULL,
  PRIMARY KEY (`idBorrow`),
  KEY `IDX_D03AA72FFE6E88D7` (`idUser`),
  KEY `IDX_D03AA72FB818FDAF` (`idBook`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrows`
--

INSERT INTO `borrows` (`idBorrow`, `borrowedDate`, `dueDate`, `returnedDate`, `idUser`, `idBook`) VALUES
(21, '2023-11-12 19:22:35', '2024-01-26 19:22:35', NULL, 1, 18),
(22, '2023-11-12 19:22:40', '2023-12-26 19:22:40', NULL, 1, 10),
(23, '2023-10-12 19:22:45', '2023-10-26 19:22:45', NULL, 1, 1),
(24, '2023-11-12 19:22:51', '2023-11-26 19:22:51', NULL, 1, 11),
(25, '2023-11-12 19:22:55', '2023-11-26 19:22:55', NULL, 1, 14),
(26, '2023-11-12 19:23:00', '2023-11-26 19:23:00', NULL, 1, 24),
(27, '2023-11-12 19:23:04', '2023-11-26 19:23:04', '2023-11-12 20:16:24', 1, 25),
(28, '2023-11-12 21:36:51', '2023-11-26 21:36:51', NULL, 1, 20);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `idComment` int NOT NULL AUTO_INCREMENT,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idUser` int NOT NULL,
  `isFixed` tinyint(1) NOT NULL,
  PRIMARY KEY (`idComment`),
  KEY `IDX_9474526CFE6E88D7` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`idComment`, `reason`, `content`, `idUser`, `isFixed`) VALUES
(2, 'Erreur liée à mon compte', 'test', 1, 0),
(3, 'Problème avec un emprunt', 'test', 1, 0),
(4, 'Problème avec un paiement', 'derniertest', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

DROP TABLE IF EXISTS `evaluations`;
CREATE TABLE IF NOT EXISTS `evaluations` (
  `idEvaluation` int NOT NULL AUTO_INCREMENT,
  `score` int NOT NULL,
  `idUser` int NOT NULL,
  `idBook` int NOT NULL,
  PRIMARY KEY (`idEvaluation`),
  KEY `IDX_3B72691DFE6E88D7` (`idUser`),
  KEY `IDX_3B72691DB818FDAF` (`idBook`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE IF NOT EXISTS `favorites` (
  `idFavorite` int NOT NULL AUTO_INCREMENT,
  `favoriteDate` datetime NOT NULL,
  `idUser` int NOT NULL,
  `idBook` int NOT NULL,
  PRIMARY KEY (`idFavorite`),
  KEY `IDX_E46960F5FE6E88D7` (`idUser`),
  KEY `IDX_E46960F5B818FDAF` (`idBook`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE IF NOT EXISTS `genres` (
  `idGenre` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`idGenre`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`idGenre`, `name`) VALUES
(1, 'Fiction Historique'),
(2, 'Fantaisie'),
(3, 'Haute fantaisie'),
(4, 'Aventure'),
(5, 'Fiction pour enfant'),
(6, 'Mystère'),
(7, 'Saga familliale'),
(8, 'Enquète policière'),
(9, 'Thriller'),
(10, 'récit initiatique'),
(11, 'Romance'),
(12, 'Réalisme magique'),
(13, 'roman'),
(14, 'Manuel'),
(15, 'Livre pour enfant'),
(16, 'littérature pour enfant'),
(17, 'Tragédie'),
(18, 'poésie'),
(19, 'Comédie'),
(20, 'manga');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `idReservation` int NOT NULL AUTO_INCREMENT,
  `reservationDate` datetime NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `idUser` int NOT NULL,
  `idBook` int NOT NULL,
  PRIMARY KEY (`idReservation`),
  KEY `IDX_4DA239FE6E88D7` (`idUser`),
  KEY `IDX_4DA239B818FDAF` (`idBook`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`idReservation`, `reservationDate`, `isActive`, `idUser`, `idBook`) VALUES
(1, '2023-11-12 12:57:37', 0, 3, 17),
(2, '2023-11-12 12:57:37', 0, 3, 20),
(3, '2023-11-12 12:58:40', 0, 3, 16),
(4, '2023-11-12 12:58:40', 0, 3, 19),
(5, '2023-11-12 12:58:40', 0, 3, 21),
(6, '2023-11-12 12:58:40', 0, 3, 2),
(7, '2023-11-12 13:00:06', 0, 1, 8),
(8, '2023-11-12 19:16:12', 0, 1, 5),
(9, '2023-11-12 13:04:36', 0, 1, 5),
(10, '2023-11-12 13:04:36', 0, 1, 8),
(11, '2023-11-12 13:06:29', 0, 3, 24),
(12, '2023-11-12 13:06:29', 0, 1, 11),
(13, '2023-11-12 21:38:59', 1, 3, 1),
(14, '2023-11-12 21:38:59', 1, 3, 10),
(15, '2023-11-12 21:38:59', 1, 3, 18),
(18, '2023-11-12 21:39:45', 1, 3, 5),
(19, '2023-11-12 21:39:45', 1, 1, 25);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `idStatus` int NOT NULL AUTO_INCREMENT,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`idStatus`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`idStatus`, `status`) VALUES
(1, 'Disponible'),
(2, 'Emprunté'),
(3, 'Réservé'),
(4, 'Perdu'),
(5, 'Supprimé');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `memberNumber` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registrationDate` datetime NOT NULL,
  `firstName` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profilePicture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phoneNumber` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postalCode` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fees` int NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `UNIQ_1483A5E97925630D` (`memberNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUser`, `memberNumber`, `email`, `registrationDate`, `firstName`, `lastName`, `profilePicture`, `address`, `phoneNumber`, `postalCode`, `roles`, `password`, `fees`) VALUES
(1, '80379801', 'vincent@test.com', '2023-11-08 14:48:28', 'vincent', 'lavoie-whitlock', NULL, '751 rue des testeurs quebec', '450 450 4550', 'j5r1b6', '[\"ROLE_USER\"]', 'password', 6),
(2, '98631907', 'Admin@electrolib.com', '2023-11-08 14:48:28', 'admin', 'mechant', NULL, '485 rue des admins quebec', '450 450 4500', 'h9s1n4', '[\"ROLE_ADMIN\"]', 'password', 0),
(3, '60492256', 'nicola@gmail.com', '2023-11-12 12:56:37', 'Nicola', 'Labelle', '/', '123, rue Barrée', '5555555555', 'A0A0A0', '[\"ROLE_USER\"]', 'password', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `FK_4A1B2A921811CD86` FOREIGN KEY (`idStatus`) REFERENCES `status` (`idStatus`),
  ADD CONSTRAINT `FK_4A1B2A92949470E5` FOREIGN KEY (`idGenre`) REFERENCES `genres` (`idGenre`),
  ADD CONSTRAINT `FK_4A1B2A92DEBE7052` FOREIGN KEY (`idAuthor`) REFERENCES `authors` (`idAuthor`);

--
-- Constraints for table `borrows`
--
ALTER TABLE `borrows`
  ADD CONSTRAINT `FK_D03AA72FB818FDAF` FOREIGN KEY (`idBook`) REFERENCES `books` (`idBook`),
  ADD CONSTRAINT `FK_D03AA72FFE6E88D7` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CFE6E88D7` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Constraints for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `FK_3B72691DB818FDAF` FOREIGN KEY (`idBook`) REFERENCES `books` (`idBook`),
  ADD CONSTRAINT `FK_3B72691DFE6E88D7` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `FK_E46960F5B818FDAF` FOREIGN KEY (`idBook`) REFERENCES `books` (`idBook`),
  ADD CONSTRAINT `FK_E46960F5FE6E88D7` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `FK_4DA239B818FDAF` FOREIGN KEY (`idBook`) REFERENCES `books` (`idBook`),
  ADD CONSTRAINT `FK_4DA239FE6E88D7` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
