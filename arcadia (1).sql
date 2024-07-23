-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 21 juil. 2024 à 21:57
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `arcadia`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id`, `utilisateur_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `animal`
--

CREATE TABLE `animal` (
  `id` int(11) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `race` varchar(50) NOT NULL,
  `images` text DEFAULT NULL,
  `habitat_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `animal`
--

INSERT INTO `animal` (`id`, `prenom`, `race`, `images`, `habitat_id`) VALUES
(11, 'Médor', 'Lion', '../uploads/image_2024_07_16T14_47_51_578Z.png', 6),
(12, 'Bella', 'Oiseau', '../uploads/animal-savane2.png', 6),
(13, 'gond', 'panthère', '../uploads/animal-savane3.png', 6),
(14, 'Josiane', 'loutre d\'europe', '../uploads/animal-marais1.png', 5),
(15, 'Delphine', 'La tortue', '../uploads/animal-marais2 (1).png', 5),
(16, 'gaston', 'Crocodylus acutus', '../uploads/animal-marais3.png', 5),
(17, 'gabin', 'perroquet', '../uploads/animal-savane1.JPEG', 7),
(18, 'anthony', 'gorille de l\'ouest', '../uploads/animal-jungle3.png', 7),
(19, 'hélios', 'anaconda', '../uploads/animal-jungle2.png', 7);

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `commentaire` text DEFAULT NULL,
  `date` date NOT NULL,
  `valide` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `pseudo`, `commentaire`, `date`, `valide`) VALUES
(1, 'ok', NULL, '2024-07-17', 1),
(2, 'corneille', 'azertyuip', '2024-07-17', 1),
(3, 'corneille', 'azertyuip', '2024-07-17', 1),
(4, 'corneille', 'ok bro', '2024-07-17', 1),
(5, '', '', '2024-07-17', 1),
(6, '', '', '2024-07-17', 1),
(7, 'yo', 'yo', '2024-07-17', 1);

-- --------------------------------------------------------

--
-- Structure de la table `compterendu`
--

CREATE TABLE `compterendu` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `etat` varchar(50) NOT NULL,
  `details` text DEFAULT NULL,
  `animal_id` int(11) NOT NULL,
  `nourritureProposee` varchar(255) DEFAULT NULL,
  `grammageNourriture` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `compterendu`
--

INSERT INTO `compterendu` (`id`, `date`, `etat`, `details`, `animal_id`, `nourritureProposee`, `grammageNourriture`) VALUES
(4, '2024-07-19', 'en forme', 'Aucune igratignure', 11, 'viande', 5000);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`id`, `utilisateur_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `habitat`
--

CREATE TABLE `habitat` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `images` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `habitat`
--

INSERT INTO `habitat` (`id`, `nom`, `description`, `images`) VALUES
(5, 'Le marais', 'Explorez ces écosystèmes humides où les eaux calmes et les roseaux ondulants abritent une vie abondante et fascinante, des crocodiles silencieux aux oiseaux échassiers gracieux.', '../uploads/marais.png'),
(6, 'La savane', 'Plongez dans l’immensité de la savane africaine, où l’esprit sauvage vous enlace, vous transportant au cœur de la nature brute.', '../uploads/savane.png'),
(7, 'La jungle', 'Laissez-vous envelopper par la canopée luxuriante et découvrez une multitude de créatures exotiques, des singes bondissants aux papillons aux couleurs vives.', '../uploads/jungle.png');

-- --------------------------------------------------------

--
-- Structure de la table `horaire`
--

CREATE TABLE `horaire` (
  `id` int(11) NOT NULL,
  `jour` varchar(50) NOT NULL,
  `heureOuverture` time NOT NULL,
  `heureFermeture` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `horaire`
--

INSERT INTO `horaire` (`id`, `jour`, `heureOuverture`, `heureFermeture`) VALUES
(1, 'lundi', '07:30:00', '18:30:00'),
(2, 'mardi', '07:30:00', '18:30:00');

-- --------------------------------------------------------

--
-- Structure de la table `nourriture`
--

CREATE TABLE `nourriture` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `quantite` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `nourriture`
--

INSERT INTO `nourriture` (`id`, `type`, `quantite`, `date`) VALUES
(1, 'viande', 55, '2024-07-15');

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id`, `nom`, `description`, `image`) VALUES
(5, 'Visite Guidée', 'Nos Guides Expérimentés Sont Là Pour Vous Offrir Des Visites Guidées Informatives Et Divertissantes À Travers Les Différents Habitats Du Zoo. Plongez Au Cœur De La Nature Sauvage Et Découvrez Les Secrets De Nos Résidents Fascinants. Que Vous Soyez Seul, En Famille Ou Entre Amis, L’expérience Sera Inoubliable !', '../uploads/Service-3.jpg'),
(6, 'Notre restauration', 'Découvrez Une Expérience Culinaire Unique Au Cœur De La Nature ! Notre Service De Restauration Au Zoo Offre Des Mets Délicieux Pour Combler Toutes Les Envies, Des Collations Rapides Aux Repas Savoureux. Profitez De Notre Ambiance Conviviale Et Observez Les Animaux Tout En Dégustant Nos Spécialités.', '../uploads/Service-2.jpg'),
(7, 'Tour du zou en train', 'Montez À Bord De Notre Petit Train Et Laissez-Vous Transporter À Travers Le Zoo Avec Confort Et Commodité. Profitez D’une Vue Panoramique Sur Les Habitats Et Les Animaux Tout En Écoutant Les Commentaires Instructifs De Notre Guide.', '../uploads/Service-4.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `username`, `password`) VALUES
(1, 'admin@gmail.com', '$2y$10$U8qogdIX51YocX7/uL4lm.eUOXbfADc9MgIgc4wgdJ09kOxisMMeW'),
(2, 'employe@gmail.com', '$2y$10$PbR6RQ1/.txtL0/RNVsZTOjLpVV5IgMvtJOVo8tg505tCs6vpiyiK');

-- --------------------------------------------------------

--
-- Structure de la table `veterinaire`
--

CREATE TABLE `veterinaire` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

CREATE TABLE `visiteur` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `habitat_id` (`habitat_id`);

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `compterendu`
--
ALTER TABLE `compterendu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `habitat`
--
ALTER TABLE `habitat`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `horaire`
--
ALTER TABLE `horaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `nourriture`
--
ALTER TABLE `nourriture`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `veterinaire`
--
ALTER TABLE `veterinaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `visiteur`
--
ALTER TABLE `visiteur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `animal`
--
ALTER TABLE `animal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `compterendu`
--
ALTER TABLE `compterendu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `habitat`
--
ALTER TABLE `habitat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `horaire`
--
ALTER TABLE `horaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `nourriture`
--
ALTER TABLE `nourriture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `veterinaire`
--
ALTER TABLE `veterinaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `visiteur`
--
ALTER TABLE `visiteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD CONSTRAINT `administrateur_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `animal_ibfk_2` FOREIGN KEY (`habitat_id`) REFERENCES `habitat` (`id`);

--
-- Contraintes pour la table `compterendu`
--
ALTER TABLE `compterendu`
  ADD CONSTRAINT `compterendu_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`);

--
-- Contraintes pour la table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `employe_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `veterinaire`
--
ALTER TABLE `veterinaire`
  ADD CONSTRAINT `veterinaire_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
