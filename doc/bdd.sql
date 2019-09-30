-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 01 oct. 2019 à 00:20
-- Version du serveur :  10.3.16-MariaDB
-- Version de PHP :  7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `chez_maman`
--

-- --------------------------------------------------------

--
-- Structure de la table `avie`
--

CREATE TABLE `avie` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `afficher` int(1) NOT NULL DEFAULT 0,
  `id_entreprise` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE `entreprise` (
  `id` int(11) NOT NULL,
  `titre` varchar(50) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `video` varchar(50) DEFAULT NULL,
  `phrase` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `telephone` int(11) DEFAULT NULL,
  `numeroRue` int(11) DEFAULT NULL,
  `rue` varchar(50) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `cp` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entreprise`
--

INSERT INTO `entreprise` (`id`, `titre`, `logo`, `video`, `phrase`, `description`, `telephone`, `numeroRue`, `rue`, `ville`, `cp`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `horraire`
--

CREATE TABLE `horraire` (
  `id` int(11) NOT NULL,
  `jour` varchar(8) NOT NULL,
  `ouvertMat` time DEFAULT NULL,
  `fermeMat` time DEFAULT NULL,
  `ouvertAp` time DEFAULT NULL,
  `fermeAp` time DEFAULT NULL,
  `id_entreprise` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `horraire`
--

INSERT INTO `horraire` (`id`, `jour`, `ouvertMat`, `fermeMat`, `ouvertAp`, `fermeAp`, `id_entreprise`) VALUES
(1, 'lundi', NULL, NULL, NULL, NULL, 1),
(2, 'mardi', NULL, NULL, NULL, NULL, 1),
(3, 'mercredi', NULL, NULL, NULL, NULL, 1),
(4, 'jeudi', NULL, NULL, NULL, NULL, 1),
(5, 'vendredi', NULL, NULL, NULL, NULL, 1),
(6, 'samedi', NULL, NULL, NULL, NULL, 1),
(7, 'dimanche', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `id_entreprise` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `text` text DEFAULT NULL,
  `image` varchar(50) NOT NULL,
  `prix` float DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `id` int(11) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `motDePasse` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `id_entreprise` int(11) NOT NULL DEFAULT 1,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`id`, `mail`, `motDePasse`, `admin`, `id_entreprise`, `nom`) VALUES
(1, 'admin@admin', '$2y$10$S7qeUqGkjOHds0Tc4vnx/u7zH5Q415LNucM2dwZYycop/DsiN3P9y', 1, 1, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `reseau`
--

CREATE TABLE `reseau` (
  `id` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `url` text DEFAULT NULL,
  `id_entreprise` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reseau`
--

INSERT INTO `reseau` (`id`, `titre`, `image`, `url`, `id_entreprise`) VALUES
(1, 'facebook', 'facebook.png', NULL, 1),
(2, 'instagram', 'instagram.png', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `image` varchar(50) NOT NULL,
  `id_entreprise` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avie`
--
ALTER TABLE `avie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `avie_entreprise_FK` (`id_entreprise`);

--
-- Index pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `horraire`
--
ALTER TABLE `horraire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `horraire_entreprise_FK` (`id_entreprise`);

--
-- Index pour la table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_entreprise_FK` (`id_entreprise`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produit_menu_FK` (`id_menu`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profil_entreprise_FK` (`id_entreprise`);

--
-- Index pour la table `reseau`
--
ALTER TABLE `reseau`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reseau_entreprise_FK` (`id_entreprise`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_entreprise_FK` (`id_entreprise`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avie`
--
ALTER TABLE `avie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `entreprise`
--
ALTER TABLE `entreprise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `horraire`
--
ALTER TABLE `horraire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `reseau`
--
ALTER TABLE `reseau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avie`
--
ALTER TABLE `avie`
  ADD CONSTRAINT `avie_entreprise_FK` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `horraire`
--
ALTER TABLE `horraire`
  ADD CONSTRAINT `horraire_entreprise_FK` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_entreprise_FK` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_menu_FK` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`);

--
-- Contraintes pour la table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `profil_entreprise_FK` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `reseau`
--
ALTER TABLE `reseau`
  ADD CONSTRAINT `reseau_entreprise_FK` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_entreprise_FK` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprise` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
