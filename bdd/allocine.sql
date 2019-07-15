-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 15 juil. 2019 à 13:20
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `allocine`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualite`
--

DROP TABLE IF EXISTS `actualite`;
CREATE TABLE IF NOT EXISTS `actualite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referencement_id` int(11) DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `debut` datetime NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resume` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL,
  `poid` int(11) NOT NULL,
  `avant` tinyint(1) NOT NULL,
  `langue` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_54928197989D9B62` (`slug`),
  UNIQUE KEY `UNIQ_549281979039D8F0` (`referencement_id`),
  KEY `IDX_54928197BCF5E72D` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `actualite`
--

INSERT INTO `actualite` (`id`, `referencement_id`, `categorie_id`, `created`, `changed`, `debut`, `titre`, `slug`, `resume`, `contenu`, `image`, `isActive`, `poid`, `avant`, `langue`) VALUES
(1, 13, NULL, '2019-07-15 12:34:37', '2019-07-15 12:34:43', '2019-07-10 00:00:00', 'Le Lorem Ipsum est simplement du faux texte employé dans la compos', 'le-lorem-ipsum-est-simplement-du-faux-texte-employe-dans-la-compos', 'Le Lorem Ipsum est simplement du faux texte employé dans la compos', '<p>Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la bureautique informatique, sans que son contenu n\'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset conte</p>', '392576-jpg-r-1920-1080-f-jpg-q-x-xxyxx.jpg', 1, 1, 0, 'fr');

-- --------------------------------------------------------

--
-- Structure de la table `actualite_categorie`
--

DROP TABLE IF EXISTS `actualite_categorie`;
CREATE TABLE IF NOT EXISTS `actualite_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `langue` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie_film`
--

DROP TABLE IF EXISTS `categorie_film`;
CREATE TABLE IF NOT EXISTS `categorie_film` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie_film`
--

INSERT INTO `categorie_film` (`id`, `created`, `changed`, `titre`) VALUES
(1, '2019-06-13 15:31:46', NULL, 'Polar'),
(2, '2019-06-13 15:31:46', NULL, 'Drame'),
(3, '2019-06-13 15:31:46', NULL, 'Thriller'),
(4, '2019-06-13 15:31:46', NULL, 'Comédie'),
(5, '2019-06-13 15:31:46', NULL, 'Fantastique'),
(6, '2019-06-13 15:31:46', NULL, 'SF');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `film_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `rating` int(11) NOT NULL,
  `commentaire` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_67F068BC567F5183` (`film_id`),
  KEY `IDX_67F068BCA76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `objet_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `langue` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4C62E638F520CF5A` (`objet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contact_objet`
--

DROP TABLE IF EXISTS `contact_objet`;
CREATE TABLE IF NOT EXISTS `contact_objet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `langue` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

DROP TABLE IF EXISTS `evenement`;
CREATE TABLE IF NOT EXISTS `evenement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referencement_id` int(11) DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `debut` datetime NOT NULL,
  `fin` datetime NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resume` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL,
  `avant` tinyint(1) NOT NULL,
  `langue` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B26681E989D9B62` (`slug`),
  UNIQUE KEY `UNIQ_B26681E9039D8F0` (`referencement_id`),
  KEY `IDX_B26681EBCF5E72D` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `evenement`
--

INSERT INTO `evenement` (`id`, `referencement_id`, `categorie_id`, `created`, `changed`, `debut`, `fin`, `titre`, `slug`, `resume`, `contenu`, `image`, `isActive`, `avant`, `langue`) VALUES
(1, 11, 1, '2019-07-15 11:58:43', '2019-07-15 12:03:24', '2019-07-15 10:10:00', '2019-07-16 12:00:00', 'Le Lorem Ipsum est simplement du', 'le-lorem-ipsum-est-simplement-du', 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte', '<p>Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte</p>', '392576-jpg-r-1920-1080-f-jpg-q-x-xxyxx.jpg', 1, 0, 'fr'),
(2, 12, NULL, '2019-07-15 12:06:15', NULL, '2019-07-11 04:00:00', '2019-07-18 08:00:00', 'psum sur un texte générique', 'psum-sur-un-texte-generique', 'psum sur un texte générique', '<p>psum sur un texte générique comme \'Du texte. Du texte. Du texte.\' est qu\'il possède une distribution de lettres plus ou moins normale</p>', 'the-social-network.jpg', 1, 0, 'fr');

-- --------------------------------------------------------

--
-- Structure de la table `evenement_categorie`
--

DROP TABLE IF EXISTS `evenement_categorie`;
CREATE TABLE IF NOT EXISTS `evenement_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `langue` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `evenement_categorie`
--

INSERT INTO `evenement_categorie` (`id`, `created`, `changed`, `nom`, `langue`) VALUES
(1, '2019-07-15 12:01:55', NULL, 'Catégorie 1', 'fr');

-- --------------------------------------------------------

--
-- Structure de la table `film`
--

DROP TABLE IF EXISTS `film`;
CREATE TABLE IF NOT EXISTS `film` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) DEFAULT NULL,
  `referencement_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datedesortie` datetime NOT NULL,
  `synopsis` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ba` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL,
  `langue` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `souscategorie_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8244BE22989D9B62` (`slug`),
  UNIQUE KEY `UNIQ_8244BE229039D8F0` (`referencement_id`),
  KEY `IDX_8244BE22BCF5E72D` (`categorie_id`),
  KEY `IDX_8244BE22A27126E0` (`souscategorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `film`
--

INSERT INTO `film` (`id`, `categorie_id`, `referencement_id`, `created`, `changed`, `titre`, `slug`, `datedesortie`, `synopsis`, `ba`, `image`, `isActive`, `langue`, `souscategorie_id`) VALUES
(1, 3, 6, '2019-06-13 15:46:06', '2019-06-24 15:04:08', 'The social network', 'the-social-network', '2018-05-18 00:00:00', 'Une soirée bien arrosée d\'octobre 2003, Mark Zuckerberg, un étudiant qui vient de se faire plaquer par sa petite amie, pirate le système informatique de l\'Université de Harvard pour créer un site, une base de données de toutes les filles du campus. Il affiche côte à côte deux photos et demande à l\'utilisateur de voter pour la plus canon. Il baptise le site Facemash. Le succès est instantané : l\'information se diffuse à la vitesse de l\'éclair et le site devient viral, détruisant tout le système de Harvard et générant une controverse sur le campus à cause de sa misogynie. Mark est accusé d\'avoir violé intentionnellement la sécurité, les droits de reproduction et le respect de la vie privée. C\'est pourtant à ce moment qu\'est né ce qui deviendra Facebook. Peu après, Mark crée thefacebook.com, qui se répand comme une trainée de poudre d\'un écran à l\'autre d\'abord à Harvard, puis s\'ouvre aux principales universités des États-Unis, de l\'Ivy League à Silicon Valley, avant de gagner le monde entier...\r\nCette invention révolutionnaire engendre des conflits passionnés. Quels ont été les faits exacts, qui peut réellement revendiquer la paternité du réseau social planétaire ? Ce qui s\'est imposé comme l\'une des idées phares du XXIe siècle va faire exploser l\'amitié de ses pionniers et déclencher des affrontements aux enjeux colossaux...', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/lB95KLmpLR4\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 'the-social-network-affiche_5d026fbe7eb7e.jpg', 1, 'fr', 7),
(2, 2, 7, '2019-06-13 15:52:58', '2019-06-24 14:23:32', 'Fight club', 'fight-club', '2018-11-06 00:00:00', 'Le narrateur, sans identité précise, vit seul, travaille seul, dort seul, mange seul ses plateaux-repas pour une personne comme beaucoup d\'autres personnes seules qui connaissent la misère humaine, morale et sexuelle. C\'est pourquoi il va devenir membre du Fight club, un lieu clandestin ou il va pouvoir retrouver sa virilité, l\'échange et la communication. Ce club est dirigé par Tyler Durden, une sorte d\'anarchiste entre gourou et philosophe qui prêche l\'amour de son prochain.', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/N9_xlIN80rM\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 'cabf29edce43eeae5ba63f4cbac420e1_5d0277ef5bd48.jpg', 1, 'fr', 3),
(3, 2, 8, '2019-06-13 15:53:58', '2019-06-25 15:19:52', 'Matrix', 'matrix', '2018-09-05 00:00:00', 'Programmeur anonyme dans un service administratif le jour, Thomas Anderson devient Neo la nuit venue. Sous ce pseudonyme, il est l\'un des pirates les plus recherchés du cyber-espace. A cheval entre deux mondes, Neo est assailli par d\'étranges songes et des messages cryptés provenant d\'un certain Morpheus. Celui-ci l\'exhorte à aller au-delà des apparences et à trouver la réponse à la question qui hante constamment ses pensées : qu\'est-ce que la Matrice ? Nul ne le sait, et aucun homme n\'est encore parvenu à en percer les defenses. Mais Morpheus est persuadé que Neo est l\'Elu, le libérateur mythique de l\'humanité annoncé selon la prophétie. Ensemble, ils se lancent dans une lutte sans retour contre la Matrice et ses terribles agents...', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/8xx91zoASLY\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '043449-af_5d123b9767726.jpg', 1, 'fr', 4);

-- --------------------------------------------------------

--
-- Structure de la table `film_acteur`
--

DROP TABLE IF EXISTS `film_acteur`;
CREATE TABLE IF NOT EXISTS `film_acteur` (
  `film_id` int(11) NOT NULL,
  `personne_id` int(11) NOT NULL,
  PRIMARY KEY (`film_id`,`personne_id`),
  KEY `IDX_8108EE68567F5183` (`film_id`),
  KEY `IDX_8108EE68A21BD112` (`personne_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `film_acteur`
--

INSERT INTO `film_acteur` (`film_id`, `personne_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 4),
(3, 2);

-- --------------------------------------------------------

--
-- Structure de la table `film_realisateur`
--

DROP TABLE IF EXISTS `film_realisateur`;
CREATE TABLE IF NOT EXISTS `film_realisateur` (
  `film_id` int(11) NOT NULL,
  `personne_id` int(11) NOT NULL,
  PRIMARY KEY (`film_id`,`personne_id`),
  KEY `IDX_3F2B13F1567F5183` (`film_id`),
  KEY `IDX_3F2B13F1A21BD112` (`personne_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `film_realisateur`
--

INSERT INTO `film_realisateur` (`film_id`, `personne_id`) VALUES
(1, 2),
(2, 2),
(3, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Structure de la table `galerieimage`
--

DROP TABLE IF EXISTS `galerieimage`;
CREATE TABLE IF NOT EXISTS `galerieimage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) DEFAULT NULL,
  `referencement_id` int(11) DEFAULT NULL,
  `filmgalerie_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resume` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL,
  `poid` int(11) NOT NULL,
  `langue` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C017D875989D9B62` (`slug`),
  UNIQUE KEY `UNIQ_C017D8759039D8F0` (`referencement_id`),
  UNIQUE KEY `UNIQ_C017D875FB0369E5` (`filmgalerie_id`),
  KEY `IDX_C017D875BCF5E72D` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `galerieimage`
--

INSERT INTO `galerieimage` (`id`, `categorie_id`, `referencement_id`, `filmgalerie_id`, `created`, `changed`, `titre`, `slug`, `resume`, `contenu`, `image`, `isActive`, `poid`, `langue`) VALUES
(1, NULL, 9, 2, '2019-06-13 15:55:07', '2019-06-13 15:56:24', 'Fight club', 'fight-club', 'Fight club', '<p>Fight club</p>', '392576-jpg-r-1920-1080-f-jpg-q-x-xxyxx_5d027228aee9b.jpg', 1, 1, 'fr'),
(2, NULL, 10, 3, '2019-06-13 15:58:36', NULL, 'Matrix', 'matrix', 'Matrix', '<p>Matrix</p>', '043449-ph4-jpg-r-1920-1080-f-jpg-q-x-xxyxx_5d0272ad0a868.jpg', 1, 1, 'fr');

-- --------------------------------------------------------

--
-- Structure de la table `galerieimage_categorie`
--

DROP TABLE IF EXISTS `galerieimage_categorie`;
CREATE TABLE IF NOT EXISTS `galerieimage_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `langue` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `galerieimage_image`
--

DROP TABLE IF EXISTS `galerieimage_image`;
CREATE TABLE IF NOT EXISTS `galerieimage_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `galerie_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL,
  `poid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F10EB94F825396CB` (`galerie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `galerieimage_image`
--

INSERT INTO `galerieimage_image` (`id`, `galerie_id`, `created`, `changed`, `titre`, `image`, `isActive`, `poid`) VALUES
(1, 1, '2019-06-13 15:55:30', NULL, 'dsds', '389295-jpg-r-1920-1080-f-jpg-q-x-xxyxx_5d0271f2ed385.jpg', 1, 1),
(2, 1, '2019-06-13 15:55:43', '2019-06-13 15:55:52', 'qds', '390857-jpg-r-1920-1080-f-jpg-q-x-xxyxx_5d02720853761.jpg', 1, 1),
(3, 1, '2019-06-13 15:55:59', NULL, 'dsqds', '392576-jpg-r-1920-1080-f-jpg-q-x-xxyxx_5d02720f1aa76.jpg', 1, 1),
(4, 2, '2019-06-13 15:58:44', NULL, 'sdd', '043449-ph4-jpg-r-1920-1080-f-jpg-q-x-xxyxx_5d0272b4bba9a.jpg', 1, 1),
(5, 2, '2019-06-13 15:58:49', NULL, 'dqsd', '043449-ph5-jpg-r-1920-1080-f-jpg-q-x-xxyxx_5d0272ba11b87.jpg', 1, 1),
(6, 2, '2019-06-13 15:58:55', NULL, 'dsqdq', '18608817-jpg-r-1920-1080-f-jpg-q-x-xxyxx_5d0272bf80280.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `langue`
--

DROP TABLE IF EXISTS `langue`;
CREATE TABLE IF NOT EXISTS `langue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `langue`
--

INSERT INTO `langue` (`id`, `created`, `changed`, `nom`, `code`) VALUES
(1, '2019-06-13 15:31:46', NULL, 'Français', 'fr');

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lien` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `destination` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `parent` int(11) NOT NULL,
  `poid` int(11) NOT NULL,
  `langue` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `menu`
--

INSERT INTO `menu` (`id`, `created`, `changed`, `titre`, `lien`, `destination`, `isActive`, `parent`, `poid`, `langue`) VALUES
(1, '2019-06-13 15:35:57', NULL, 'Accueil', '#', 1, 1, 0, 1, 'fr'),
(2, '2019-06-13 15:36:06', '2019-07-15 12:41:30', 'Contact', 'contact', 1, 1, 0, 6, 'fr'),
(3, '2019-06-25 15:09:11', '2019-07-15 12:41:30', 'Galerie', 'diaporamas', 1, 1, 0, 3, 'fr'),
(4, '2019-07-15 12:04:30', '2019-07-15 12:41:41', 'Evenemenets', 'evenements', 1, 1, 0, 4, 'fr'),
(5, '2019-07-15 12:38:46', '2019-07-15 12:41:42', 'Actualités', 'actualites', 1, 1, 0, 5, 'fr'),
(6, '2019-07-15 12:40:05', '2019-07-15 12:41:30', 'Films', 'fiches-film', 1, 1, 0, 2, 'fr');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20190613153124', '2019-06-13 15:31:36'),
('20190613160323', '2019-06-13 16:03:31'),
('20190715114611', '2019-07-15 11:46:35'),
('20190715122744', '2019-07-15 12:28:09');

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

DROP TABLE IF EXISTS `page`;
CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referencement_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `poid` int(11) NOT NULL,
  `langue` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_140AB620989D9B62` (`slug`),
  UNIQUE KEY `UNIQ_140AB6209039D8F0` (`referencement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `page`
--

INSERT INTO `page` (`id`, `referencement_id`, `created`, `changed`, `titre`, `slug`, `contenu`, `isActive`, `poid`, `langue`) VALUES
(1, 1, '2019-06-13 15:39:24', NULL, 'Avengers Endgame : le film dépassera-t-il Avatar au box-office mondial ?', 'avengers-endgame-le-film-depassera-t-il-avatar-au-box-office-mondial', '<p><strong>Avec 2,7 milliards de dollars de recettes dans le monde, \"Avengers: Endgame\" n\'est plus qu\'à 57 \"petits\" millions de détrôner \"Avatar\", le champion absolu du box-office. Mais y parviendra-t-il ?</strong></p>\r\n<p>C\'est LA question qui taraude aujourd\'hui de nombreux fans : Avengers: Endgameparviendra-t-il à détrôner le champion Avatar au sommet du box-office mondial ? Bref, deviendra-t-il le film le plus rentable de tous les temps ? Si la question mérite aujourd\'hui d\'être posée, c\'est que ce qui semblait presque comme une évidence au lendemain du fabuleux démarrage US d\'Endgame (près de 360 millions de billets verts en seulement trois jours !) apparaît aujourd\'hui comme beaucoup plus hypothétique.</p>\r\n<p>Ce lundi 10 juin, soit presque sept semaines après ses débuts à l\'écran, Avengers: Endgame totalise 2,73 milliards de dollars de recettes dans le monde. Des chiffres colossaux qui lui permettent de ne plus pointer qu\' à 57 \"petits\" millions de billets verts du classique de James Cameron. Un écart minime qui, tout un paradoxe, va être particulièrement difficile à combler pour ce long métrage qui a déjà raflé tant de records.</p>\r\n<p><iframe src=\"https://www.youtube.com/embed/LDBojdBAjXU\" width=\"560\" height=\"315\" frameborder=\"0\" allowfullscreen=\"allowfullscreen\"></iframe></p>', 1, 1, 'fr');

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

DROP TABLE IF EXISTS `personne`;
CREATE TABLE IF NOT EXISTS `personne` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referencement_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_FCEC9EF989D9B62` (`slug`),
  UNIQUE KEY `UNIQ_FCEC9EF9039D8F0` (`referencement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`id`, `referencement_id`, `created`, `changed`, `nom`, `prenom`, `slug`) VALUES
(1, 2, '2019-06-13 15:42:19', NULL, 'Fincher', 'David', 'fincher-david'),
(2, 3, '2019-06-13 15:42:44', NULL, 'Willis', 'Bruce', 'bruce-willis'),
(3, 4, '2019-06-13 15:43:24', NULL, 'Keanu', 'Reeves', 'keanu-reeves'),
(4, 5, '2019-06-13 15:43:47', NULL, 'Smith', 'Will', 'will-smith');

-- --------------------------------------------------------

--
-- Structure de la table `referencement`
--

DROP TABLE IF EXISTS `referencement`;
CREATE TABLE IF NOT EXISTS `referencement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ogtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ogdescription` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ogurl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ogimage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `referencement`
--

INSERT INTO `referencement` (`id`, `created`, `changed`, `title`, `description`, `ogtitle`, `ogdescription`, `ogurl`, `ogimage`) VALUES
(1, '2019-06-13 15:39:24', NULL, 'Avengers Endgame : le film dépassera-t-il Avatar au box-office mondial ?', 'Avengers Endgame : le film dépassera-t-il Avatar au box-office mondial ?', NULL, NULL, NULL, NULL),
(2, '2019-06-13 15:42:20', NULL, 'Fincher David', 'Fincher David', NULL, NULL, NULL, NULL),
(3, '2019-06-13 15:42:44', NULL, 'Bruce willis', 'Bruce willis', NULL, NULL, NULL, NULL),
(4, '2019-06-13 15:43:24', NULL, 'Keanu Reeves', 'Keanu Reeves', NULL, NULL, NULL, NULL),
(5, '2019-06-13 15:43:47', NULL, 'Will Smith', 'Will Smith', NULL, NULL, NULL, NULL),
(6, '2019-06-13 15:46:06', NULL, 'The social network', 'The social network', NULL, NULL, NULL, NULL),
(7, '2019-06-13 15:52:59', NULL, 'Fight club', 'Fight club', NULL, NULL, NULL, NULL),
(8, '2019-06-13 15:53:58', NULL, 'Matrix', 'Matrix', NULL, NULL, NULL, NULL),
(9, '2019-06-13 15:55:07', NULL, 'Fight club', 'Fight club', NULL, NULL, NULL, NULL),
(10, '2019-06-13 15:58:36', NULL, 'Matrix', 'Matrix', NULL, NULL, NULL, NULL),
(11, '2019-07-15 11:58:44', '2019-07-15 12:00:19', 'Le Lorem Ipsum est simplement du', 'Le Lorem Ipsum est simplement du', NULL, NULL, NULL, NULL),
(12, '2019-07-15 12:06:15', NULL, 'psum sur un texte générique', 'psum sur un texte générique', NULL, NULL, NULL, NULL),
(13, '2019-07-15 12:34:37', NULL, 'Le Lorem Ipsum est simplement du faux texte employé dans la compos', 'Le Lorem Ipsum est simplement du faux texte employé dans la compos', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `slide`
--

DROP TABLE IF EXISTS `slide`;
CREATE TABLE IF NOT EXISTS `slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `lien` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `poid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_72EFEE622CCC9638` (`slider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `slide`
--

INSERT INTO `slide` (`id`, `slider_id`, `created`, `changed`, `titre`, `contenu`, `lien`, `image`, `isActive`, `poid`) VALUES
(1, 1, '2019-06-13 15:33:24', '2019-06-25 15:19:30', 'Avengers Endgame : le film dépassera-t-il Avatar au box-office mondial ?', 'Avec 2,7 milliards de dollars de recettes dans le monde, \"Avengers: Endgame\" n\'est plus qu\'à 57 \"petits\" millions de détrôner \"Avatar\", le champion absolu du box-office. Mais y parviendra-t-il ?', 'avengers-endgame-le-film-depassera-t-il-avatar-au-box-office-mondial/1', '74fbfe6203a5e179968ae387c44_5d026cc428029.jpeg', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `slider`
--

DROP TABLE IF EXISTS `slider`;
CREATE TABLE IF NOT EXISTS `slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `langue` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `slider`
--

INSERT INTO `slider` (`id`, `created`, `changed`, `titre`, `langue`) VALUES
(1, '2019-06-13 15:33:00', NULL, 'Accueil', 'fr');

-- --------------------------------------------------------

--
-- Structure de la table `souscategorie_film`
--

DROP TABLE IF EXISTS `souscategorie_film`;
CREATE TABLE IF NOT EXISTS `souscategorie_film` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_675A7CD4BCF5E72D` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `souscategorie_film`
--

INSERT INTO `souscategorie_film` (`id`, `categorie_id`, `created`, `changed`, `titre`) VALUES
(1, 1, '2019-06-13 15:31:46', NULL, 'Polar 1'),
(2, 1, '2019-06-13 15:31:46', NULL, 'Polar 2'),
(3, 2, '2019-06-13 15:31:46', NULL, 'Drame 1'),
(4, 2, '2019-06-13 15:31:46', NULL, 'Drame 2'),
(5, 2, '2019-06-13 15:31:46', NULL, 'Drame 3'),
(6, 3, '2019-06-13 15:31:46', NULL, 'Thriller 1'),
(7, 3, '2019-06-13 15:31:46', NULL, 'Thriller 2'),
(8, 3, '2019-06-13 15:31:46', NULL, 'Thriller 3'),
(9, 4, '2019-06-13 15:31:46', NULL, 'Comédie 1'),
(10, 4, '2019-06-13 15:31:46', NULL, 'Comédie 2'),
(11, 5, '2019-06-13 15:31:46', NULL, 'Fantastique 1'),
(12, 5, '2019-06-13 15:31:46', NULL, 'Fantastique 2'),
(13, 5, '2019-06-13 15:31:46', NULL, 'Fantastique 3'),
(14, 6, '2019-06-13 15:31:46', NULL, 'SF 1'),
(15, 6, '2019-06-13 15:31:46', NULL, 'SF 2');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `nickname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649A188FE64` (`nickname`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `created`, `changed`, `nickname`, `username`, `nom`, `prenom`, `password`, `email`, `isActive`, `roles`, `avatar`) VALUES
(1, '2019-06-13 15:31:46', '2019-07-15 11:47:37', 'admin', NULL, 'nom', 'prenom', '$2y$13$oiX9UHC3RdTwqh1BwClcdeAyuqQeo1gJqx5EH8FH1zg8iTohZraUW', 'pinelli.luc@hotmail.fr', 1, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_historique`
--

DROP TABLE IF EXISTS `user_historique`;
CREATE TABLE IF NOT EXISTS `user_historique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4AD81300FB88E14F` (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_historique`
--

INSERT INTO `user_historique` (`id`, `utilisateur_id`, `created`, `changed`, `contenu`, `ip`) VALUES
(1, 1, '2019-06-13 15:32:41', NULL, 'Connexion réussie', '127.0.0.1'),
(2, 1, '2019-06-24 14:04:28', NULL, 'Connexion réussie', '127.0.0.1'),
(3, 1, '2019-07-15 11:47:15', NULL, 'Connexion réussie', '127.0.0.1'),
(4, 1, '2019-07-15 12:57:52', NULL, 'Connexion réussie', '127.0.0.1');

-- --------------------------------------------------------

--
-- Structure de la table `user_newsletter`
--

DROP TABLE IF EXISTS `user_newsletter`;
CREATE TABLE IF NOT EXISTS `user_newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `langue` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_reinitialisation`
--

DROP TABLE IF EXISTS `user_reinitialisation`;
CREATE TABLE IF NOT EXISTS `user_reinitialisation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `changed` datetime DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `actualite`
--
ALTER TABLE `actualite`
  ADD CONSTRAINT `FK_549281979039D8F0` FOREIGN KEY (`referencement_id`) REFERENCES `referencement` (`id`),
  ADD CONSTRAINT `FK_54928197BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `actualite_categorie` (`id`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_67F068BC567F5183` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`),
  ADD CONSTRAINT `FK_67F068BCA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `FK_4C62E638F520CF5A` FOREIGN KEY (`objet_id`) REFERENCES `contact_objet` (`id`);

--
-- Contraintes pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `FK_B26681E9039D8F0` FOREIGN KEY (`referencement_id`) REFERENCES `referencement` (`id`),
  ADD CONSTRAINT `FK_B26681EBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `evenement_categorie` (`id`);

--
-- Contraintes pour la table `film`
--
ALTER TABLE `film`
  ADD CONSTRAINT `FK_8244BE229039D8F0` FOREIGN KEY (`referencement_id`) REFERENCES `referencement` (`id`),
  ADD CONSTRAINT `FK_8244BE22A27126E0` FOREIGN KEY (`souscategorie_id`) REFERENCES `souscategorie_film` (`id`),
  ADD CONSTRAINT `FK_8244BE22BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie_film` (`id`);

--
-- Contraintes pour la table `film_acteur`
--
ALTER TABLE `film_acteur`
  ADD CONSTRAINT `FK_8108EE68567F5183` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_8108EE68A21BD112` FOREIGN KEY (`personne_id`) REFERENCES `personne` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `film_realisateur`
--
ALTER TABLE `film_realisateur`
  ADD CONSTRAINT `FK_3F2B13F1567F5183` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3F2B13F1A21BD112` FOREIGN KEY (`personne_id`) REFERENCES `personne` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `galerieimage`
--
ALTER TABLE `galerieimage`
  ADD CONSTRAINT `FK_C017D8759039D8F0` FOREIGN KEY (`referencement_id`) REFERENCES `referencement` (`id`),
  ADD CONSTRAINT `FK_C017D875BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `galerieimage_categorie` (`id`),
  ADD CONSTRAINT `FK_C017D875FB0369E5` FOREIGN KEY (`filmgalerie_id`) REFERENCES `film` (`id`);

--
-- Contraintes pour la table `galerieimage_image`
--
ALTER TABLE `galerieimage_image`
  ADD CONSTRAINT `FK_F10EB94F825396CB` FOREIGN KEY (`galerie_id`) REFERENCES `galerieimage` (`id`);

--
-- Contraintes pour la table `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `FK_140AB6209039D8F0` FOREIGN KEY (`referencement_id`) REFERENCES `referencement` (`id`);

--
-- Contraintes pour la table `personne`
--
ALTER TABLE `personne`
  ADD CONSTRAINT `FK_FCEC9EF9039D8F0` FOREIGN KEY (`referencement_id`) REFERENCES `referencement` (`id`);

--
-- Contraintes pour la table `slide`
--
ALTER TABLE `slide`
  ADD CONSTRAINT `FK_72EFEE622CCC9638` FOREIGN KEY (`slider_id`) REFERENCES `slider` (`id`);

--
-- Contraintes pour la table `souscategorie_film`
--
ALTER TABLE `souscategorie_film`
  ADD CONSTRAINT `FK_675A7CD4BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie_film` (`id`);

--
-- Contraintes pour la table `user_historique`
--
ALTER TABLE `user_historique`
  ADD CONSTRAINT `FK_4AD81300FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
