-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 07 Mars 2017 à 11:28
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gsbjm`
--

-- --------------------------------------------------------

--
-- Structure de la table `datepriseencharge`
--

CREATE TABLE `datepriseencharge` (
  `jour` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `declarer`
--

CREATE TABLE `declarer` (
  `idVisiteur` int(11) NOT NULL,
  `idEquipement` int(11) NOT NULL,
  `IdTypePanne` int(11) NOT NULL,
  `jour` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `equipement`
--

CREATE TABLE `equipement` (
  `id` int(11) NOT NULL,
  `dateAffectation` date NOT NULL,
  `prixOrigine` int(11) NOT NULL,
  `etatOrigine` varchar(30) NOT NULL,
  `dateAchat` date NOT NULL,
  `idVisiteur` int(11) NOT NULL,
  `idType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `lienvisiteur`
--

CREATE TABLE `lienvisiteur` (
  `idVisiteur` int(11) NOT NULL,
  `idChef` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `priseencharge`
--

CREATE TABLE `priseencharge` (
  `idEquipement` int(11) NOT NULL,
  `idTypePanne` int(11) NOT NULL,
  `jour` date NOT NULL,
  `prix` float NOT NULL,
  `dateFinR` date NOT NULL,
  `dateFinT` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `rolevisiteur`
--

CREATE TABLE `rolevisiteur` (
  `id` int(11) NOT NULL,
  `libelle` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `typeequipement`
--

CREATE TABLE `typeequipement` (
  `id` int(11) NOT NULL,
  `libelle` varchar(30) NOT NULL,
  `taux` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `typepanne`
--

CREATE TABLE `typepanne` (
  `id` int(11) NOT NULL,
  `naturePanne` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

CREATE TABLE `visiteur` (
  `id` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `loginv` varchar(20) NOT NULL,
  `mdp` varchar(30) NOT NULL,
  `adresse` varchar(75) NOT NULL,
  `cp` varchar(10) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `dateEmb` date NOT NULL,
  `idRole` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `datepriseencharge`
--
ALTER TABLE `datepriseencharge`
  ADD PRIMARY KEY (`jour`);

--
-- Index pour la table `declarer`
--
ALTER TABLE `declarer`
  ADD KEY `idVisiteur` (`idVisiteur`),
  ADD KEY `idEquipement` (`idEquipement`),
  ADD KEY `IdTypePanne` (`IdTypePanne`),
  ADD KEY `jour` (`jour`);

--
-- Index pour la table `equipement`
--
ALTER TABLE `equipement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idVisiteur` (`idVisiteur`),
  ADD KEY `idType` (`idType`);

--
-- Index pour la table `lienvisiteur`
--
ALTER TABLE `lienvisiteur`
  ADD KEY `idVisiteur` (`idVisiteur`),
  ADD KEY `idChef` (`idChef`);

--
-- Index pour la table `priseencharge`
--
ALTER TABLE `priseencharge`
  ADD KEY `idEquipement` (`idEquipement`),
  ADD KEY `idTypePanne` (`idTypePanne`),
  ADD KEY `jour` (`jour`);

--
-- Index pour la table `rolevisiteur`
--
ALTER TABLE `rolevisiteur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `typeequipement`
--
ALTER TABLE `typeequipement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `typepanne`
--
ALTER TABLE `typepanne`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `visiteur`
--
ALTER TABLE `visiteur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idRole` (`idRole`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `equipement`
--
ALTER TABLE `equipement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `rolevisiteur`
--
ALTER TABLE `rolevisiteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `typeequipement`
--
ALTER TABLE `typeequipement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `typepanne`
--
ALTER TABLE `typepanne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `visiteur`
--
ALTER TABLE `visiteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
