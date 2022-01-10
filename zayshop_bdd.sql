-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 10 jan. 2022 à 11:18
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
-- Base de données :  `zayshop`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Note` int(11) DEFAULT NULL,
  `Commentaire` varchar(500) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idProduit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idUser_Avis` (`idUser`),
  KEY `fk_idProduit_Avis` (`idProduit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `sujet` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Genre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id`, `Genre`) VALUES
(1, 'Homme'),
(2, 'Femme');

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) DEFAULT NULL,
  `URL` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `imageproduit`
--

DROP TABLE IF EXISTS `imageproduit`;
CREATE TABLE IF NOT EXISTS `imageproduit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idProduit` int(11) DEFAULT NULL,
  `idImage` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idProduit_ImageProduit` (`idProduit`),
  KEY `fk_idImage_ImageProduit` (`idImage`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Taille` varchar(5) DEFAULT NULL,
  `Quantite` int(11) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idProduit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idProduit_Panier` (`idProduit`),
  KEY `fk_idUser_Panier` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

DROP TABLE IF EXISTS `pays`;
CREATE TABLE IF NOT EXISTS `pays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`id`, `Nom`) VALUES
(1, 'Afghanistan'),
(2, 'Albanie'),
(3, 'Antarctique'),
(4, 'Algérie'),
(5, 'Samoa Américaines'),
(6, 'Andorre'),
(7, 'Angola'),
(8, 'Antigua-et-Barbuda'),
(9, 'Azerbaïdjan'),
(10, 'Argentine'),
(11, 'Australie'),
(12, 'Autriche'),
(13, 'Bahamas'),
(14, 'Bahreïn'),
(15, 'Bangladesh'),
(16, 'Arménie'),
(17, 'Barbade'),
(18, 'Belgique'),
(19, 'Bermudes'),
(20, 'Bhoutan'),
(21, 'Bolivie'),
(22, 'Bosnie-Herzégovine'),
(23, 'Botswana'),
(24, 'Île Bouvet'),
(25, 'Brésil'),
(26, 'Belize'),
(27, 'Territoire Britannique de l\'Océan Indien'),
(28, 'Îles Salomon'),
(29, 'Îles Vierges Britanniques'),
(30, 'Brunéi Darussalam'),
(31, 'Bulgarie'),
(32, 'Myanmar'),
(33, 'Burundi'),
(34, 'Bélarus'),
(35, 'Cambodge'),
(36, 'Cameroun'),
(37, 'Canada'),
(38, 'Cap-vert'),
(39, 'Îles Caïmanes'),
(40, 'République Centrafricaine'),
(41, 'Sri Lanka'),
(42, 'Tchad'),
(43, 'Chili'),
(44, 'Chine'),
(45, 'Taïwan'),
(46, 'Île Christmas'),
(47, 'Îles Cocos (Keeling)'),
(48, 'Colombie'),
(49, 'Comores'),
(50, 'Mayotte'),
(51, 'République du Congo'),
(52, 'République Démocratique du Congo'),
(53, 'Îles Cook'),
(54, 'Costa Rica'),
(55, 'Croatie'),
(56, 'Cuba'),
(57, 'Chypre'),
(58, 'République Tchèque'),
(59, 'Bénin'),
(60, 'Danemark'),
(61, 'Dominique'),
(62, 'République Dominicaine'),
(63, 'Équateur'),
(64, 'El Salvador'),
(65, 'Guinée Équatoriale'),
(66, 'Éthiopie'),
(67, 'Érythrée'),
(68, 'Estonie'),
(69, 'Îles Féroé'),
(70, 'Îles (malvinas) Falkland'),
(71, 'Géorgie du Sud et les Îles Sandwich du Sud'),
(72, 'Fidji'),
(73, 'Finlande'),
(74, 'Îles Åland'),
(75, 'France'),
(76, 'Guyane Française'),
(77, 'Polynésie Française'),
(78, 'Terres Australes Françaises'),
(79, 'Djibouti'),
(80, 'Gabon'),
(81, 'Géorgie'),
(82, 'Gambie'),
(83, 'Territoire Palestinien Occupé'),
(84, 'Allemagne'),
(85, 'Ghana'),
(86, 'Gibraltar'),
(87, 'Kiribati'),
(88, 'Grèce'),
(89, 'Groenland'),
(90, 'Grenade'),
(91, 'Guadeloupe'),
(92, 'Guam'),
(93, 'Guatemala'),
(94, 'Guinée'),
(95, 'Guyana'),
(96, 'Haïti'),
(97, 'Îles Heard et Mcdonald'),
(98, 'Saint-Siège (état de la Cité du Vatican)'),
(99, 'Honduras'),
(100, 'Hong-Kong'),
(101, 'Hongrie'),
(102, 'Islande'),
(103, 'Inde'),
(104, 'Indonésie'),
(105, 'République Islamique d\'Iran'),
(106, 'Iraq'),
(107, 'Irlande'),
(108, 'Israël'),
(109, 'Italie'),
(110, 'Côte d\'Ivoire'),
(111, 'Jamaïque'),
(112, 'Japon'),
(113, 'Kazakhstan'),
(114, 'Jordanie'),
(115, 'Kenya'),
(116, 'République Populaire Démocratique de Corée'),
(117, 'République de Corée'),
(118, 'Koweït'),
(119, 'Kirghizistan'),
(120, 'République Démocratique Populaire Lao'),
(121, 'Liban'),
(122, 'Lesotho'),
(123, 'Lettonie'),
(124, 'Libéria'),
(125, 'Jamahiriya Arabe Libyenne'),
(126, 'Liechtenstein'),
(127, 'Lituanie'),
(128, 'Luxembourg'),
(129, 'Macao'),
(130, 'Madagascar'),
(131, 'Malawi'),
(132, 'Malaisie'),
(133, 'Maldives'),
(134, 'Mali'),
(135, 'Malte'),
(136, 'Martinique'),
(137, 'Mauritanie'),
(138, 'Maurice'),
(139, 'Mexique'),
(140, 'Monaco'),
(141, 'Mongolie'),
(142, 'République de Moldova'),
(143, 'Montserrat'),
(144, 'Maroc'),
(145, 'Mozambique'),
(146, 'Oman'),
(147, 'Namibie'),
(148, 'Nauru'),
(149, 'Népal'),
(150, 'Pays-Bas'),
(151, 'Antilles Néerlandaises'),
(152, 'Aruba'),
(153, 'Nouvelle-Calédonie'),
(154, 'Vanuatu'),
(155, 'Nouvelle-Zélande'),
(156, 'Nicaragua'),
(157, 'Niger'),
(158, 'Nigéria'),
(159, 'Niué'),
(160, 'Île Norfolk'),
(161, 'Norvège'),
(162, 'Îles Mariannes du Nord'),
(163, 'Îles Mineures Éloignées des États-Unis'),
(164, 'États Fédérés de Micronésie'),
(165, 'Îles Marshall'),
(166, 'Palaos'),
(167, 'Pakistan'),
(168, 'Panama'),
(169, 'Papouasie-Nouvelle-Guinée'),
(170, 'Paraguay'),
(171, 'Pérou'),
(172, 'Philippines'),
(173, 'Pitcairn'),
(174, 'Pologne'),
(175, 'Portugal'),
(176, 'Guinée-Bissau'),
(177, 'Timor-Leste'),
(178, 'Porto Rico'),
(179, 'Qatar'),
(180, 'Réunion'),
(181, 'Roumanie'),
(182, 'Fédération de Russie'),
(183, 'Rwanda'),
(184, 'Sainte-Hélène'),
(185, 'Saint-Kitts-et-Nevis'),
(186, 'Anguilla'),
(187, 'Sainte-Lucie'),
(188, 'Saint-Pierre-et-Miquelon'),
(189, 'Saint-Vincent-et-les Grenadines'),
(190, 'Saint-Marin'),
(191, 'Sao Tomé-et-Principe'),
(192, 'Arabie Saoudite'),
(193, 'Sénégal'),
(194, 'Seychelles'),
(195, 'Sierra Leone'),
(196, 'Singapour'),
(197, 'Slovaquie'),
(198, 'Viet Nam'),
(199, 'Slovénie'),
(200, 'Somalie'),
(201, 'Afrique du Sud'),
(202, 'Zimbabwe'),
(203, 'Espagne'),
(204, 'Sahara Occidental'),
(205, 'Soudan'),
(206, 'Suriname'),
(207, 'Svalbard etÎle Jan Mayen'),
(208, 'Swaziland'),
(209, 'Suède'),
(210, 'Suisse'),
(211, 'République Arabe Syrienne'),
(212, 'Tadjikistan'),
(213, 'Thaïlande'),
(214, 'Togo'),
(215, 'Tokelau'),
(216, 'Tonga'),
(217, 'Trinité-et-Tobago'),
(218, 'Émirats Arabes Unis'),
(219, 'Tunisie'),
(220, 'Turquie'),
(221, 'Turkménistan'),
(222, 'Îles Turks et Caïques'),
(223, 'Tuvalu'),
(224, 'Ouganda'),
(225, 'Ukraine'),
(226, 'L\'ex-République Yougoslave de Macédoine'),
(227, 'Égypte'),
(228, 'Royaume-Uni'),
(229, 'Île de Man'),
(230, 'République-Unie de Tanzanie'),
(231, 'États-Unis'),
(232, 'Îles Vierges des États-Unis'),
(233, 'Burkina Faso'),
(234, 'Uruguay'),
(235, 'Ouzbékistan'),
(236, 'Venezuela'),
(237, 'Wallis et Futuna'),
(238, 'Samoa'),
(239, 'Yémen'),
(240, 'Serbie-et-Monténégro'),
(241, 'Zambie');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) DEFAULT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `Marque` varchar(100) DEFAULT NULL,
  `Prix` decimal(10,2) DEFAULT NULL,
  `Couleur` varchar(100) DEFAULT NULL,
  `Specification` varchar(500) DEFAULT NULL,
  `idCategorie` int(11) DEFAULT NULL,
  `idGenre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idCategorie_Produit` (`idCategorie`),
  KEY `fk_idGenre_Produit` (`idGenre`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `produitavis`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `produitavis`;
CREATE TABLE IF NOT EXISTS `produitavis` (
`id` int(11)
,`Nom` varchar(100)
,`Description` varchar(500)
,`Marque` varchar(100)
,`Prix` decimal(10,2)
,`Couleur` varchar(100)
,`Specification` varchar(500)
,`idCategorie` int(11)
,`idGenre` int(11)
,`Note` decimal(11,0)
,`Nb-commentaire` bigint(21)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `produitimage`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `produitimage`;
CREATE TABLE IF NOT EXISTS `produitimage` (
`idProduit` int(11)
,`idImage` int(11)
,`URL` varchar(100)
,`Nom` varchar(100)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `produitprixpanier`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `produitprixpanier`;
CREATE TABLE IF NOT EXISTS `produitprixpanier` (
`id` int(11)
,`Taille` varchar(5)
,`Quantite` int(11)
,`idUser` int(11)
,`idProduit` int(11)
,`Prix` decimal(10,2)
,`prixArticles` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `produittaille`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `produittaille`;
CREATE TABLE IF NOT EXISTS `produittaille` (
`idProduit` int(11)
,`idTaille` int(11)
,`libelle` varchar(100)
);

-- --------------------------------------------------------

--
-- Structure de la table `taille`
--

DROP TABLE IF EXISTS `taille`;
CREATE TABLE IF NOT EXISTS `taille` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `taille`
--

INSERT INTO `taille` (`id`, `libelle`) VALUES
(1, 'S'),
(2, 'M'),
(3, 'L'),
(4, 'XL');

-- --------------------------------------------------------

--
-- Structure de la table `tailleproduit`
--

DROP TABLE IF EXISTS `tailleproduit`;
CREATE TABLE IF NOT EXISTS `tailleproduit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idProduit` int(11) DEFAULT NULL,
  `idTaille` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idProduit_TailleProduit` (`idProduit`),
  KEY `fk_idTaille_TailleProduit` (`idTaille`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) DEFAULT NULL,
  `Prenom` varchar(100) DEFAULT NULL,
  `Telephone` varchar(10) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Mdp` varchar(100) DEFAULT NULL,
  `Adresse` varchar(100) DEFAULT NULL,
  `Complementadresse` varchar(100) DEFAULT NULL,
  `Codepostal` int(11) DEFAULT NULL,
  `Ville` varchar(100) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `idPays` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idPays_Users` (`idPays`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `Nom`, `Prenom`, `Telephone`, `Email`, `Mdp`, `Adresse`, `Complementadresse`, `Codepostal`, `Ville`, `admin`, `idPays`) VALUES
(5, 'Admin', 'Admin', '0000000000', 'admin@zayshop.fr', 'admin', '', '', NULL, '', 1, 75);

-- --------------------------------------------------------

--
-- Structure de la vue `produitavis`
--
DROP TABLE IF EXISTS `produitavis`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `produitavis`  AS  select `produit`.`id` AS `id`,`produit`.`Nom` AS `Nom`,`produit`.`Description` AS `Description`,`produit`.`Marque` AS `Marque`,`produit`.`Prix` AS `Prix`,`produit`.`Couleur` AS `Couleur`,`produit`.`Specification` AS `Specification`,`produit`.`idCategorie` AS `idCategorie`,`produit`.`idGenre` AS `idGenre`,round(avg(`avis`.`Note`),0) AS `Note`,count(`avis`.`id`) AS `Nb-commentaire` from (`produit` join `avis` on((`produit`.`id` = `avis`.`idProduit`))) group by `produit`.`id` ;

-- --------------------------------------------------------

--
-- Structure de la vue `produitimage`
--
DROP TABLE IF EXISTS `produitimage`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `produitimage`  AS  select `p`.`id` AS `idProduit`,`ip`.`idImage` AS `idImage`,`i`.`URL` AS `URL`,`i`.`Nom` AS `Nom` from ((`imageproduit` `ip` join `produit` `p`) join `image` `i`) where ((`ip`.`idProduit` = `p`.`id`) and (`ip`.`idImage` = `i`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure de la vue `produitprixpanier`
--
DROP TABLE IF EXISTS `produitprixpanier`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `produitprixpanier`  AS  select `pa`.`id` AS `id`,`pa`.`Taille` AS `Taille`,`pa`.`Quantite` AS `Quantite`,`pa`.`idUser` AS `idUser`,`pa`.`idProduit` AS `idProduit`,`produit`.`Prix` AS `Prix`,cast((`pa`.`Quantite` * `produit`.`Prix`) as decimal(10,2)) AS `prixArticles` from (`panier` `pa` join `produit` on((`pa`.`idProduit` = `produit`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `produittaille`
--
DROP TABLE IF EXISTS `produittaille`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `produittaille`  AS  select `p`.`id` AS `idProduit`,`tp`.`idTaille` AS `idTaille`,`t`.`libelle` AS `libelle` from ((`tailleproduit` `tp` join `produit` `p`) join `taille` `t`) where ((`tp`.`idProduit` = `p`.`id`) and (`tp`.`idTaille` = `t`.`id`)) ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `fk_idProduit_Avis` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`id`),
  ADD CONSTRAINT `fk_idUser_Avis` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `imageproduit`
--
ALTER TABLE `imageproduit`
  ADD CONSTRAINT `fk_idImage_ImageProduit` FOREIGN KEY (`idImage`) REFERENCES `image` (`id`),
  ADD CONSTRAINT `fk_idProduit_ImageProduit` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `fk_idProduit_Panier` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`id`),
  ADD CONSTRAINT `fk_idUser_Panier` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk_idCategorie_Produit` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`id`),
  ADD CONSTRAINT `fk_idGenre_Produit` FOREIGN KEY (`idGenre`) REFERENCES `genre` (`id`);

--
-- Contraintes pour la table `tailleproduit`
--
ALTER TABLE `tailleproduit`
  ADD CONSTRAINT `fk_idProduit_TailleProduit` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`id`),
  ADD CONSTRAINT `fk_idTaille_TailleProduit` FOREIGN KEY (`idTaille`) REFERENCES `taille` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_idPays_Users` FOREIGN KEY (`idPays`) REFERENCES `pays` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
