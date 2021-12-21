-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 21 déc. 2021 à 15:27
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
  `Commentaire` varchar(100) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `Nom`) VALUES
(1, 'Shoes'),
(3, 'Clothe'),
(7, 'Accessories');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 'Men'),
(2, 'Women');

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
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id`, `Nom`, `URL`) VALUES
(112, 'Active Wear Photo 1', 'img/products_img/169__product_single_01.jpg'),
(113, 'Active Wear Photo 2', 'img/products_img/169__product_single_02.jpg'),
(114, 'Active Wear Photo 3', 'img/products_img/169__product_single_03.jpg'),
(117, 'Active Wear Photo 4', 'img/products_img/169__product_single_09.jpg');

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
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `imageproduit`
--

INSERT INTO `imageproduit` (`id`, `idProduit`, `idImage`) VALUES
(136, 169, 112),
(137, 169, 113),
(138, 169, 114),
(141, 169, 117);

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Quantite` int(11) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idProduit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idProduit_Panier` (`idProduit`),
  KEY `fk_idUser_Panier` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

DROP TABLE IF EXISTS `pays`;
CREATE TABLE IF NOT EXISTS `pays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`id`, `Nom`) VALUES
(1, 'France'),
(2, 'Espagne');

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
  `Prix` float DEFAULT NULL,
  `Couleur` varchar(100) DEFAULT NULL,
  `Specification` varchar(500) DEFAULT NULL,
  `idCategorie` int(11) DEFAULT NULL,
  `idGenre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idCategorie_Produit` (`idCategorie`),
  KEY `fk_idGenre_Produit` (`idGenre`)
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `Nom`, `Description`, `Marque`, `Prix`, `Couleur`, `Specification`, `idCategorie`, `idGenre`) VALUES
(169, 'Active Wear', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse. Donec condimentum elementum convallis. Nunc sed orci a diam ultrices aliquet interdum quis nulla.', 'Easy Wear', 25, 'White / Black', 'Lorem ipsum dolor sitâ€¨Amet, consectetur â€¨Adipisicing elit, set\r\nDuis aute irure\r\nUt enim ad minim\r\nDolore magna aliqua\r\nExcepteur sint', 3, 2);

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
,`Prix` float
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
,`Quantite` int(11)
,`idUser` int(11)
,`idProduit` int(11)
,`Prix` float
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `taille`
--

INSERT INTO `taille` (`id`, `libelle`) VALUES
(2, 'S'),
(3, 'M'),
(4, 'L'),
(6, 'XS'),
(7, 'XL'),
(8, 'XXL');

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
) ENGINE=InnoDB AUTO_INCREMENT=376 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tailleproduit`
--

INSERT INTO `tailleproduit` (`id`, `idProduit`, `idTaille`) VALUES
(373, 169, 2),
(374, 169, 3),
(375, 169, 4);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `Nom`, `Prenom`, `Telephone`, `Email`, `Mdp`, `Adresse`, `Complementadresse`, `Codepostal`, `Ville`, `admin`, `idPays`) VALUES
(3, 'a', 'b', 'd', 'c', 'e', 'NULL', 'NULL', NULL, 'NULL', 0, 1);

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `produitprixpanier`  AS  select `pa`.`id` AS `id`,`pa`.`Quantite` AS `Quantite`,`pa`.`idUser` AS `idUser`,`pa`.`idProduit` AS `idProduit`,`produit`.`Prix` AS `Prix`,cast((`pa`.`Quantite` * `produit`.`Prix`) as decimal(10,2)) AS `prixArticles` from (`panier` `pa` join `produit` on((`pa`.`idProduit` = `produit`.`id`))) ;

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
