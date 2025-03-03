-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 07 mai 2023 à 16:43
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bddres`
--

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

CREATE TABLE `comptes` (
  `Identifiant` varchar(20) NOT NULL,
  `Nom` varchar(60) NOT NULL,
  `ProfilePic` varchar(30) NOT NULL DEFAULT 'default.png',
  `Mdp` varchar(255) NOT NULL,
  `DateDeNaissance` date NOT NULL,
  `Université` varchar(100) NOT NULL,
  `Admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`Identifiant`, `Nom`, `ProfilePic`, `Mdp`, `DateDeNaissance`, `Université`, `Admin`) VALUES
('exemple123', 'Nom Prénom', 'i5fFvV9UK4yWHwXsWdV8.png', '$2y$10$Pd1C1NAmyDzTRVtyTnBwdOjXLZXuzUKU6qaek4fulbJmZZQivN8EC', '2003-02-01', 'UPC', 0),
('root', 'admin', 'default.jpg', '$2y$10$njZ0/6NECkSCNlWpk.qFz.IIF9dT0TW7c11b6oXMrIyWWJzG8Flv2', '1970-01-01', 'UPC', 1),
('tester1', 'Test 1', 'default.jpg', '$2y$10$c2DQ6HVuqv0N5L42.4s7IurfENEhlU3R6gIjOtNCBqoDPxFcb9a2y', '1970-10-20', 'UP', 0),
('tester2', 'Test 2', 'default.jpg', '$2y$10$gAJdgYsMf6Z9V.WMH1Q25.aMe3j3wHhjCetckOeGwVyWBr/H.ipJe', '1970-10-20', 'UP', 0),
('tester3', 'Test 3', 'default.jpg', '$2y$10$5aVumjnnHXnnUPex1xtwkeS3ZzRngkgC1v5oUS3PscCRqj/Meqs1a', '1970-10-20', 'UP', 0);

-- --------------------------------------------------------

--
-- Structure de la table `connectionhist`
--

CREATE TABLE `connectionhist` (
  `Identifiant` varchar(20) NOT NULL,
  `IpAddress` varchar(40) NOT NULL,
  `IpLocation` varchar(100) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `connectionhist`
--

INSERT INTO `connectionhist` (`Identifiant`, `IpAddress`, `IpLocation`, `Date`) VALUES
('exemple123', '::1', 'Lieu introuvable ou IP locale au serveur', '2023-05-05 15:34:32'),
('exemple123', '::1', 'Lieu introuvable ou IP locale au serveur', '2023-05-05 21:04:44'),
('exemple123', '::1', 'Lieu introuvable ou IP locale au serveur', '2023-05-06 01:23:40'),
('exemple123', '::1', 'Lieu introuvable ou IP locale au serveur', '2023-05-06 01:28:58'),
('exemple123', '::1', 'Lieu introuvable ou IP locale au serveur', '2023-05-06 15:36:31'),
('root', '::1', 'Lieu introuvable ou IP locale au serveur', '2023-05-06 16:42:40'),
('exemple123', '::1', 'Lieu introuvable ou IP locale au serveur', '2023-05-07 13:21:28'),
('exemple123', '::1', 'Lieu introuvable ou IP locale au serveur', '2023-05-07 15:58:21'),
('root', '::1', 'Lieu introuvable ou IP locale au serveur', '2023-05-07 15:58:28');

-- --------------------------------------------------------

--
-- Structure de la table `follows`
--

CREATE TABLE `follows` (
  `Account` varchar(20) NOT NULL,
  `Follower` varchar(20) NOT NULL,
  `DateFollow` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `follows`
--

INSERT INTO `follows` (`Account`, `Follower`, `DateFollow`) VALUES
('exemple123', 'root', '2023-05-04 19:54:14'),
('tester1', 'root', '2023-05-05 00:17:35'),
('tester2', 'root', '2023-05-05 02:18:54'),
('tester3', 'root', '2023-05-05 02:18:59'),
('tester1', 'exemple123', '2023-05-06 00:40:22');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `Id` int(20) NOT NULL,
  `Contenu` text NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp(),
  `IdSender` varchar(20) NOT NULL,
  `IdReceiver` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`Id`, `Contenu`, `Date`, `IdSender`, `IdReceiver`) VALUES
(1, 'Un message', '2023-04-28 04:39:25', 'exemple123', 'tester1'),
(3, 'New test', '2023-05-02 12:01:01', 'tester1', 'exemple123'),
(4, 'New test', '2023-05-04 02:07:47', 'root', 'exemple123'),
(5, 'New test', '2023-05-04 03:25:42', 'root', 'exemple123'),
(6, 'TEST', '2023-05-04 04:36:30', 'exemple123', 'root'),
(7, 'TEST', '2023-05-04 04:36:33', 'exemple123', 'root'),
(12, 'TEST', '2023-05-04 04:36:42', 'exemple123', 'root'),
(13, 'lorem ipsum', '2023-05-04 21:32:28', 'root', 'exemple123'),
(14, 'Test', '2023-05-01 10:10:10', 'tester1', 'root'),
(15, 'Test j-1', '2023-05-03 12:45:00', 'tester1', 'root'),
(16, 'Test j', '2023-05-04 23:46:10', 'tester1', 'root'),
(17, 'Test 0', '2023-05-04 23:46:37', 'root', 'tester1'),
(18, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vulputate felis eu massa ultricies posuere. Ut id tortor pulvinar, euismod leo vel, mollis lorem. Cras dignissim lacinia elit et finibus. Aliquam tempus enim tellus, nec malesuada odio vestibulum id. Phasellus ullamcorper lacinia nibh, eget ultricies magna aliquam id. Maecenas felis nisi, malesuada quis condimentum id, varius ut purus. Praesent aliquet rhoncus posuere. Proin a pretium magna. In volutpat vestibulum faucibus. Fusce quis imperdiet diam. Nullam sodales, turpis maximus tincidunt ultrices, mi ante hendrerit ex, at efficitur augue sapien convallis nulla. Aliquam finibus odio quis odio auctor rhoncus sed eu massa. Duis imperdiet turpis ut urna pulvinar, ut hendrerit sem imperdiet.', '2023-05-04 23:47:15', 'root', 'tester1'),
(19, 'essai', '2023-05-05 00:17:01', 'tester1', 'root');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `Id` int(15) NOT NULL,
  `IdUser` varchar(20) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp(),
  `ContenuTxt` text NOT NULL,
  `ContenuMedia` varchar(30) NOT NULL,
  `Backroom` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`Id`, `IdUser`, `Date`, `ContenuTxt`, `ContenuMedia`, `Backroom`) VALUES
(2, 'exemple123', '2023-04-30 18:23:13', 'Nouveau test', '', 0),
(3, 'exemple123', '2023-05-03 23:52:40', 'Essai 3', '', 0),
(4, 'exemple123', '2023-05-04 20:41:58', 'Essai', '', 0),
(5, 'root', '2023-05-04 22:39:20', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vulputate felis eu massa ultricies posuere. Ut id tortor pulvinar, euismod leo vel, mollis lorem. Cras dignissim lacinia elit et finibus. Aliquam tempus enim tellus, nec malesuada odio vestibulum id. Phasellus ullamcorper lacinia nibh, eget ultricies magna aliquam id. Maecenas felis nisi, malesuada quis condimentum id, varius ut purus. Praesent aliquet rhoncus posuere. Proin a pretium magna. In volutpat vestibulum faucibus. Fusce quis imperdiet diam. Nullam sodales, turpis maximus tincidunt ultrices, mi ante hendrerit ex, at efficitur augue sapien convallis nulla. Aliquam finibus odio quis odio auctor rhoncus sed eu massa. Duis imperdiet turpis ut urna pulvinar, ut hendrerit sem imperdiet.', '', 0),
(7, 'root', '2023-05-05 03:59:11', 'Essai img1', 'KW9O4iIaiZ9yPJ4odIAt.png', 1),
(8, 'tester1', '2023-05-05 04:00:57', 'Essai img2', 'kg9Fx6qhMugrJf3BgXu8.png', 0),
(9, 'tester1', '2023-05-05 04:05:39', 'Essai gif', 'o37mExKhjKmSfRmXPOZ4.gif', 1),
(10, 'exemple123', '2023-05-05 15:38:20', 'Test encore', '', 1),
(11, 'exemple123', '2023-05-06 01:10:55', 'Test de plus', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `report`
--

CREATE TABLE `report` (
  `Id` int(15) NOT NULL,
  `IdPost` int(15) NOT NULL,
  `IdReporter` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `report`
--

INSERT INTO `report` (`Id`, `IdPost`, `IdReporter`) VALUES
(1, 9, 'exemple123');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD PRIMARY KEY (`Identifiant`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
