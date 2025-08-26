-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 26 août 2025 à 21:17
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ece_cine`
--

-- --------------------------------------------------------

--
-- Structure de la table `films`
--

CREATE TABLE `films` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_ajout` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `films`
--

INSERT INTO `films` (`id`, `titre`, `description`, `annee`, `genre`, `image`, `date_ajout`) VALUES
(1, 'Inception', 'Un voleur expérimenté qui vole les secrets en s’infiltrant dans les rêves doit accomplir la mission inverse : implanter une idée dans un esprit.', 2010, 'Science-Fiction', 'inception.jpg', '2025-08-12 10:22:22'),
(2, 'Interstellar', 'Un groupe d’explorateurs voyage à travers un trou de ver dans l’espace afin de sauver l’humanité.', 2014, 'Science-Fiction', 'interstellar.jpg', '2025-08-12 10:22:22'),
(3, 'le_seigneur_des_anneaux_la_communaute_de_l_anneau_version_longue', 'Un jeune hobbit hérite d’un anneau magique et dangereux, et doit le détruire pour sauver le monde.', 2001, 'Fantasy', 'le_seigneur_des_anneaux_la_communaute_de_l_anneau_version_longue.jpg', '2025-08-12 10:22:22'),
(4, 'Avengers: Endgame', 'Les Avengers restants s’unissent pour annuler les actions de Thanos et restaurer l’ordre dans l’univers.', 2019, 'Action', 'avengers_endgame.jpg', '2025-08-12 10:22:22'),
(5, 'Parasite', 'Une famille pauvre s’infiltre progressivement dans la vie d’une famille riche, avec des conséquences imprévisibles.', 2019, 'Thriller', 'parasite.jpg', '2025-08-12 10:22:22');

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL,
  `date_like` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `film_id`, `date_like`) VALUES
(5, 3, 3, '2025-08-24 21:30:44'),
(7, 3, 1, '2025-08-24 21:35:58'),
(8, 3, 4, '2025-08-24 21:42:05');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `lu` tinyint(1) DEFAULT 0,
  `date_envoi` timestamp NOT NULL DEFAULT current_timestamp(),
  `vue` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `statut` enum('etudiant','admin','superadmin') NOT NULL,
  `valide` tinyint(1) DEFAULT 0,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `avatar` varchar(255) DEFAULT 'default.png',
  `fond_ecran` varchar(255) DEFAULT 'default_bg.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `statut`, `valide`, `date_creation`, `avatar`, `fond_ecran`) VALUES
(1, 'admin', 'super', 'superadmin@ece.com', '$2y$10$r0L.vA42pZfclMv.tKYPT.8QPWJ5GuFqBmkvNGCobLcQ6SGCBi3Jq', 'superadmin', 1, '2025-08-15 17:13:21', 'default.png', 'default_bg.jpg'),
(3, 'etudiant', 'ece', 'etudiant@ece.com', '$2y$10$r6r5VEpRHZbfKIskGEDX7.U.5TC5UiXQ9i2CrIWOfATX0nOpMto8u', 'etudiant', 1, '2025-08-15 17:49:34', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `validation_etudiants`
--

CREATE TABLE `validation_etudiants` (
  `id` int(11) NOT NULL,
  `etudiant_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `statut` enum('accepte','refuse') DEFAULT NULL,
  `date_validation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `validation_utilisateurs`
--

CREATE TABLE `validation_utilisateurs` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `superadmin_id` int(11) NOT NULL,
  `statut` enum('accepte','refuse') DEFAULT NULL,
  `date_validation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `film_id` (`film_id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `validation_etudiants`
--
ALTER TABLE `validation_etudiants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etudiant_id` (`etudiant_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Index pour la table `validation_utilisateurs`
--
ALTER TABLE `validation_utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `superadmin_id` (`superadmin_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `films`
--
ALTER TABLE `films`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `validation_etudiants`
--
ALTER TABLE `validation_etudiants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `validation_utilisateurs`
--
ALTER TABLE `validation_utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `validation_etudiants`
--
ALTER TABLE `validation_etudiants`
  ADD CONSTRAINT `validation_etudiants_ibfk_1` FOREIGN KEY (`etudiant_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `validation_etudiants_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `validation_utilisateurs`
--
ALTER TABLE `validation_utilisateurs`
  ADD CONSTRAINT `validation_utilisateurs_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `validation_utilisateurs_ibfk_2` FOREIGN KEY (`superadmin_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
