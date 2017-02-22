-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 21 Février 2017 à 08:14
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `la_bonne_rue`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
(1, 'Electroménager'),
(2, 'Vêtements/Textile'),
(3, 'Meubles'),
(4, 'Hight Tech'),
(5, 'Matériaux'),
(6, 'Jouets'),
(7, 'Décoration'),
(8, 'Divers'),
(9, 'Litterie'),
(10, 'Pièces Automobiles'),
(11, 'Equipement Sportif');

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_lock_id` int(100) DEFAULT NULL,
  `picture` varchar(500) NOT NULL,
  `metro` varchar(150) DEFAULT NULL,
  `bus` varchar(150) DEFAULT NULL,
  `tram` varchar(150) DEFAULT NULL,
  `quality_id` int(100) NOT NULL,
  `longitude` varchar(100) DEFAULT NULL,
  `latitude` varchar(100) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `items`
--

INSERT INTO `items` (`id`, `title`, `description`, `category_id`, `user_id`, `user_lock_id`, `picture`, `metro`, `bus`, `tram`, `quality_id`, `longitude`, `latitude`, `address`, `created_at`) VALUES
(1, 'Titre de l\'annonce 8', 'zdfergtyj', 1, 6, NULL, 'annonce/img/objet_UeFIh3CACGQlqut2eRZM2JxNfH7CUS.png', NULL, NULL, NULL, 1, '1.4320065', '43.625017', '12 Rue de Figeac, 31200 Toulouse, France', '2017-02-15 09:10:13'),
(2, 'mon titre ', '\'gzh hzhzh zrn rnrztn nhnzsr tnt', 1, 6, NULL, 'annonce/img/objet_Vd0eGqRtEbAdvT54aHAfj8QCHtwlkN.png', NULL, NULL, NULL, 1, '1.4318955', '43.625004499999996', '10 Rue de Figeac, 31200 Toulouse, France', '2017-02-15 13:46:22'),
(3, 'test annonce 4', 'exrdck', 1, 6, NULL, 'annonce/img/objet_fMQ9lnnY9OLAt7JtETrWbI5BhiEd8r.png', NULL, NULL, NULL, 2, '1.4319347999999998', '43.6250029', '12 Rue de Figeac, 31200 Toulouse, France', '2017-02-15 13:47:01'),
(4, 'iyvberbebsebse', 'nbstndt ntyn tydn,dn ,ytnerns nfgng,jd sh srd d', 1, 6, 6, 'annonce/img/objet_6GWhodEIJrOQoXC844XIVWDWIA97y7.png', NULL, NULL, NULL, 5, '1.4319282000000002', '43.6250005', '12 Rue de Figeac, 31200 Toulouse, France', '2017-02-15 13:47:24');

-- --------------------------------------------------------

--
-- Structure de la table `qualities`
--

CREATE TABLE `qualities` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `qualities`
--

INSERT INTO `qualities` (`id`, `title`) VALUES
(1, 'Très Abimé'),
(2, 'Abimé'),
(3, 'Bon Etat'),
(4, 'Très Bon Etat'),
(5, 'Neuf');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email_user` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `premium` tinyint(1) NOT NULL DEFAULT '0',
  `premium_until` datetime DEFAULT NULL,
  `tokens` int(11) NOT NULL DEFAULT '1',
  `confirmation_token` varchar(60) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `user_name`, `first_name`, `last_name`, `email_user`, `password`, `premium`, `premium_until`, `tokens`, `confirmation_token`, `confirmed_at`) VALUES
(5, 'elition31', 'Thomas', 'Loiseau', 'thomas.loiseau1@ynov.com', '$2y$10$aiAVH467QYZgPLjJjEuRVO4FGmfEVsiECZyKDW2SkrbwNF/jbYAuu', 0, NULL, 1, NULL, '2017-02-11 15:32:00'),
(6, 'elition', 'Thomas', 'Loiseau', 'thomas.loisea@gmail.com', '$2y$10$C50z4KxwUcVjGJsoGohze.Bwzhv.9Z./YMu6T2owzd1WPYq8YguBq', 0, NULL, 1, NULL, '2017-02-11 16:22:06'),
(7, 'test1', 'blabla', 'blabla', 'test@test.com', '$2y$10$DPoRZdK0EMpk7.2V8eNwsOl59Q2qbCSda7XzF0CuWJ4G4R588EPL.', 0, NULL, 1, NULL, '2017-02-11 16:24:23'),
(8, 'test2', 'Antoine', 'bkfoz', 'antoine@coco.com', '$2y$10$UptTgcK/DgONmun4KLEk4.HY7jMpB2e/G0tfEOXr9hPbp4EX72keK', 0, NULL, 1, NULL, '2017-02-11 19:17:57'),
(9, 'elition311', 'Thomas', 'Loiseau', 'thomas.loisea31@gmail.com', '$2y$10$YglDg4KgTqvXcob/I3BTU.j..kBCaR101aI.mSoQ.mFvCXHkXYLHG', 0, NULL, 1, 'LSmGnOVybVVYpUz0koxrTcPwfxfozQTa1ZdJZb1cZG9JK6wSWDcsDZoppRuy', NULL),
(10, 'test', 'tcrfguhy', 'cfvgybh', 'test@testt.com', '$2y$10$odCGFvx6CXUTTg/oNq70BOhfHT8beOP3giJ.eTLhTEGC4nqdRl6ny', 0, NULL, 1, 'j1YEJnInlMNsqjN43vz2JexuOV8gTW2jsBNW8984pXH9gnDVujSf5oAT2Kqt', NULL),
(11, 'compte01', 'Thomas', 'Loiseau', 'compte_test@gmail.com', '$2y$10$ctVrUsV0HNDPKcakYdVpDucSJU/BLhyRqIvnRdx2mZWlf2.Lpnq0K', 0, NULL, 1, 'sSMndqrLujDHwUHhVCI5zBG5i5sfd0Fo9gSWNkw8IPeC1wOXdVejO8yt4D8R', NULL),
(12, 'Doudou', 'Pascal', 'Dang', 'dang.pascal@hotmail.fr', '$2y$10$JUrj98tzCNMztEURxh9FK..d9Ukh7Qy69Q1Mdj1TAjvd4sh2Uv2Sa', 0, NULL, 1, NULL, '2017-02-14 08:19:27');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lock_user` (`user_lock_id`),
  ADD KEY `categorie` (`category_id`),
  ADD KEY `quality` (`quality_id`),
  ADD KEY `create_by` (`user_id`);

--
-- Index pour la table `qualities`
--
ALTER TABLE `qualities`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `qualities`
--
ALTER TABLE `qualities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`user_lock_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `items_ibfk_3` FOREIGN KEY (`quality_id`) REFERENCES `qualities` (`id`),
  ADD CONSTRAINT `items_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
