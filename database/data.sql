-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 06 mars 2025 à 16:09
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hackaton`
--

-- --------------------------------------------------------

--
-- Structure de la table `chantier`
--

DROP TABLE IF EXISTS `chantier`;
CREATE TABLE IF NOT EXISTS `chantier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` longtext COLLATE utf8mb4_unicode_ci,
  `debut_travaux` date DEFAULT NULL,
  `fin_travaux` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chantier`
--

INSERT INTO `chantier` (`id`, `nom`, `adresse`, `debut_travaux`, `fin_travaux`, `status`) VALUES
(1, 'Gedimat', 'Rue de la maçonnerie', '2025-03-06', '2025-03-13', 'En cours'),
(2, 'Création d\'autoroute A69', 'Route arc-en-ciel', '2025-03-27', '2025-03-30', 'A venir'),
(3, 'Immeuble', NULL, '2025-04-01', '2025-04-30', 'A venir');

-- --------------------------------------------------------

--
-- Structure de la table `chantier_competence`
--

DROP TABLE IF EXISTS `chantier_competence`;
CREATE TABLE IF NOT EXISTS `chantier_competence` (
  `chantier_id` int NOT NULL,
  `competence_id` int NOT NULL,
  PRIMARY KEY (`chantier_id`,`competence_id`),
  KEY `IDX_E6D6C4ACD0C0049D` (`chantier_id`),
  KEY `IDX_E6D6C4AC15761DAB` (`competence_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chantier_competence`
--

INSERT INTO `chantier_competence` (`chantier_id`, `competence_id`) VALUES
(1, 1),
(1, 4),
(1, 5),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8);

-- --------------------------------------------------------

--
-- Structure de la table `chantier_employes`
--

DROP TABLE IF EXISTS `chantier_employes`;
CREATE TABLE IF NOT EXISTS `chantier_employes` (
  `chantier_id` int NOT NULL,
  `employes_id` int NOT NULL,
  PRIMARY KEY (`chantier_id`,`employes_id`),
  KEY `IDX_624A1537D0C0049D` (`chantier_id`),
  KEY `IDX_624A1537F971F91F` (`employes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `competence`
--

DROP TABLE IF EXISTS `competence`;
CREATE TABLE IF NOT EXISTS `competence` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `competence`
--

INSERT INTO `competence` (`id`, `nom`) VALUES
(1, 'Carreleur'),
(2, 'Plombier'),
(3, 'Electricien'),
(4, 'Maçon'),
(5, 'Permis B'),
(6, 'Permis poids lourd'),
(7, 'Mécanicien'),
(8, 'Grutier');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250306155600', '2025-03-06 15:56:03', 496);

-- --------------------------------------------------------

--
-- Structure de la table `employes`
--

DROP TABLE IF EXISTS `employes`;
CREATE TABLE IF NOT EXISTS `employes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disponible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employes`
--

INSERT INTO `employes` (`id`, `email`, `roles`, `password`, `nom`, `prenom`, `disponible`) VALUES
(1, 'admin@yopmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$/FoyQ5RvDLnnrSGtes/oVei3YVvjB8wanfINGjoXp9JIUa7TnmhkC', 'Administrateur', 'Paul', 1),
(2, 'user@yopmail.com', '[\"ROLE_USER\"]', '$2y$13$EgxpZcrenBjtcbf3LPjf1OLcxMUxRf1mFgANrbrEj2b5Q8EgCUydO', 'Bricoleur', 'Bob', 1),
(3, 'bon@yopmail.com', '[\"ROLE_USER\"]', '$2y$13$cWFkSGDOHoaVANUXJjdSF.1wivdYdqKZ7qJL9tV5W.dvusH.V3Cxu', 'Bon', 'Jean', 1),
(4, 'guy@yopmail.com', '[\"ROLE_USER\"]', '$2y$13$dIwVCT2KKMRHFyUhBUtyEOLUnV6B8d5WBFQLFHn9ddB1xdDA.U/xK', 'Jean', 'Guy', 1),
(5, 'nathan@yopmail.com', '[\"ROLE_USER\"]', '$2y$13$Cm44pqDc6jEuqXjC3HrTmubGzXwr5W4O/ve/0XhxJ35HhY9DCk1OW', 'L', 'Nathan', 1);

-- --------------------------------------------------------

--
-- Structure de la table `employes_competence`
--

DROP TABLE IF EXISTS `employes_competence`;
CREATE TABLE IF NOT EXISTS `employes_competence` (
  `employes_id` int NOT NULL,
  `competence_id` int NOT NULL,
  PRIMARY KEY (`employes_id`,`competence_id`),
  KEY `IDX_EF2690B7F971F91F` (`employes_id`),
  KEY `IDX_EF2690B715761DAB` (`competence_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employes_competence`
--

INSERT INTO `employes_competence` (`employes_id`, `competence_id`) VALUES
(2, 3),
(2, 5),
(2, 7),
(3, 1),
(3, 4),
(3, 8),
(4, 5),
(4, 6),
(4, 7),
(4, 8),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5),
(5, 6),
(5, 7),
(5, 8);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mission`
--

DROP TABLE IF EXISTS `mission`;
CREATE TABLE IF NOT EXISTS `mission` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chantier_id` int DEFAULT NULL,
  `employe_id` int DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9067F23CD0C0049D` (`chantier_id`),
  KEY `IDX_9067F23C1B65292` (`employe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mission`
--

INSERT INTO `mission` (`id`, `chantier_id`, `employe_id`, `date_debut`, `date_fin`) VALUES
(1, 1, 3, '2025-03-06', '2025-03-07'),
(2, 3, 5, '2025-04-01', '2025-04-04'),
(3, 3, 2, '2025-04-01', '2025-04-03'),
(4, 3, 4, '2025-04-07', '2025-04-09'),
(5, 1, 5, '2025-03-08', '2025-03-11'),
(6, 2, 5, '2025-03-27', '2025-03-30'),
(7, 2, 2, '2025-03-27', '2025-03-28'),
(8, 2, 4, '2025-03-29', '2025-03-30');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chantier_competence`
--
ALTER TABLE `chantier_competence`
  ADD CONSTRAINT `FK_E6D6C4AC15761DAB` FOREIGN KEY (`competence_id`) REFERENCES `competence` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E6D6C4ACD0C0049D` FOREIGN KEY (`chantier_id`) REFERENCES `chantier` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `chantier_employes`
--
ALTER TABLE `chantier_employes`
  ADD CONSTRAINT `FK_624A1537D0C0049D` FOREIGN KEY (`chantier_id`) REFERENCES `chantier` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_624A1537F971F91F` FOREIGN KEY (`employes_id`) REFERENCES `employes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `employes_competence`
--
ALTER TABLE `employes_competence`
  ADD CONSTRAINT `FK_EF2690B715761DAB` FOREIGN KEY (`competence_id`) REFERENCES `competence` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EF2690B7F971F91F` FOREIGN KEY (`employes_id`) REFERENCES `employes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `mission`
--
ALTER TABLE `mission`
  ADD CONSTRAINT `FK_9067F23C1B65292` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id`),
  ADD CONSTRAINT `FK_9067F23CD0C0049D` FOREIGN KEY (`chantier_id`) REFERENCES `chantier` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
