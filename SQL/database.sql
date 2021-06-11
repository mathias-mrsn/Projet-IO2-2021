-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : Dim 23 mai 2021 à 17:28
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `database`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `id_user`, `id_post`, `comment`, `date`) VALUES
(2, 6, 2, 'L\'Italie ?', '2021-05-13 15:48:00'),
(3, 4, 5, 'Je préfère largement le basket ', '2021-05-13 15:59:00'),
(4, 4, 2, 'Les états unis ???', '2021-05-13 15:59:00'),
(5, 3, 2, 'Et pourquoi pas le Japon ?', '2021-05-13 16:09:00'),
(6, 2, 3, 'Rien de special', '2021-05-13 16:13:00'),
(7, 2, 6, 'Moi j\'adore ca ', '2021-05-13 16:13:00'),
(8, 2, 2, 'La canada a 100% !!', '2021-05-13 16:13:00');

-- --------------------------------------------------------

--
-- Structure de la table `follow`
--

CREATE TABLE `follow` (
  `id` int(11) NOT NULL,
  `follower` text NOT NULL,
  `following` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `follow`
--

INSERT INTO `follow` (`id`, `follower`, `following`) VALUES
(1, 'Mick', 'Antoine'),
(2, 'Mick', 'Louis'),
(3, 'Mick', 'Pierre'),
(4, 'Mick', 'Samy'),
(5, 'Edie', 'Mick'),
(6, 'Edie', 'Samy'),
(7, 'Edie', 'Antoine'),
(8, 'Samy', 'Edie'),
(9, 'Samy', 'Antoine'),
(10, 'Samy', 'Jean'),
(11, 'Samy', 'Louis'),
(12, 'Louis', 'Antoine'),
(13, 'Louis', 'Samy'),
(14, 'Louis', 'Pierre'),
(15, 'Louis', 'Mick'),
(17, 'Pierre', 'Jean'),
(18, 'Pierre', 'Samy'),
(19, 'Pierre', 'Mick'),
(22, 'Pierre', 'Antoine'),
(23, 'Antoine', 'Mick'),
(24, 'Antoine', 'Samy'),
(25, 'Antoine', 'Jean'),
(26, 'Antoine', 'Pierre');

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `id_user`, `id_post`) VALUES
(1, 6, 2),
(2, 6, 1),
(3, 6, 4),
(5, 5, 5),
(6, 5, 4),
(7, 4, 5),
(8, 4, 2),
(9, 3, 6),
(10, 3, 4),
(11, 3, 3),
(12, 3, 2),
(13, 3, 1),
(14, 2, 7),
(16, 2, 3),
(17, 2, 2),
(18, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `id_expediteur` int(11) NOT NULL,
  `id_destinataire` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `id_expediteur`, `id_destinataire`, `message`, `date`) VALUES
(1, 6, 4, 'Ce soir je sors tu viens ?', '2021-05-13 15:50:00'),
(2, 6, 1, 'Tout va bien au travail', '2021-05-13 15:50:00'),
(3, 6, 7, 'Je sors avec Samy ce soir tu viens ?', '2021-05-13 15:51:00'),
(4, 5, 4, 'Yo quoi de neuf ?', '2021-05-13 15:53:00'),
(5, 5, 2, 'Tu fini le travail a quelle heure ?', '2021-05-13 15:53:00'),
(6, 5, 6, 'J\'ai entendu que tu voulais sortir ce soir ?', '2021-05-13 15:54:00'),
(7, 3, 7, 'Comment tu vas depuis la fac ?', '2021-05-13 16:10:00'),
(8, 3, 6, 'Tu as vu le dernier Tarantino ?', '2021-05-13 16:10:00'),
(9, 2, 1, 'Je sors voir un spectacle ce soir tu viens ?', '2021-05-13 16:14:00'),
(10, 2, 7, 'Tu viens a la salle avec moi quand ils vont rouvrir ?', '2021-05-13 16:15:00'),
(12, 2, 5, '18h30 et toi ?', '2021-05-13 16:26:00');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `post` varchar(1024) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id_post`, `id_user`, `post`, `date`) VALUES
(1, 7, 'Je passe une superbe journée !', '2021-05-13 15:44:00'),
(2, 7, 'Je veux partir en vacance. Des idées ?', '2021-05-13 15:44:00'),
(3, 6, 'Vous avez prévu quoi ce soir ?', '2021-05-13 15:45:00'),
(4, 6, 'Je viens de recevoir ma nouvelle tele.', '2021-05-13 15:45:00'),
(5, 5, 'J\'adore le foot !!!', '2021-05-13 15:52:00'),
(6, 4, 'Je deteste le foot !', '2021-05-13 15:58:00'),
(7, 2, 'Vivement la réouverture des salles de sport !', '2021-05-13 16:12:00');

-- --------------------------------------------------------

--
-- Structure de la table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `report`
--

INSERT INTO `report` (`id`, `id_user`, `id_post`, `date`) VALUES
(1, 6, 1, '2021-05-13 15:52:00'),
(2, 5, 2, '2021-05-13 15:55:00'),
(3, 3, 4, '2021-05-13 16:10:00'),
(4, 2, 4, '2021-05-13 16:13:00'),
(5, 2, 6, '2021-05-13 16:15:00');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(100) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `private` tinyint(1) NOT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `mot_de_passe`, `admin`, `private`, `bio`) VALUES
(1, 'Jean', 'Jean@outlook.fr', '81dc9bdb52d04dc20036dbd8313ed055', 0, 1, 'Je suis un fan de Ariana Grande'),
(2, 'Pierre', 'Pierre@outlook.fr', '81dc9bdb52d04dc20036dbd8313ed055', 0, 1, 'Salut c\'est votre Pierre préféré'),
(3, 'Louis', 'Louis@outlook.fr', '81dc9bdb52d04dc20036dbd8313ed055', 1, 0, 'Hiiiii !'),
(4, 'Samy', 'Samy@outlook.fr', '81dc9bdb52d04dc20036dbd8313ed055', 0, 0, 'Yo c\'est Samy'),
(5, 'Edie', 'Edie@outlook.fr', '81dc9bdb52d04dc20036dbd8313ed055', 0, 1, ''),
(6, 'Mick', 'Mick@outlook.fr', '81dc9bdb52d04dc20036dbd8313ed055', 0, 0, '#student'),
(7, 'Antoine', 'Antoine@outlook.fr', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1, 'Etudiant a l\'université de Paris');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_post`);

--
-- Index pour la table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `follow`
--
ALTER TABLE `follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
