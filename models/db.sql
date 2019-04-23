-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  mar. 23 avr. 2019 à 14:24
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `class_not_found`
--
CREATE DATABASE IF NOT EXISTS `class_not_found` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `class_not_found`;

-- --------------------------------------------------------

--
-- Structure de la table `answers`
--

DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `answers`
--

INSERT INTO `answers` (`answer_id`, `creation_date`, `subject`, `question_id`, `user_id`) VALUES
(1, '2019-03-31 12:39:10', 'Yop, pour moi le meilleur IDE pour le C, c\'est CodeBlocks, certes très simple mais il fait l\'affaire.', 4, 2),
(2, '2019-03-31 18:22:02', 'Salut, je ne suis pas du tout d\'accord avec @decrombrugghe... CodeBlocks n\'est pas très efficace ! \r\nMoi je conseille dans tous les cas la suite JetBrains... pour toi ce sera alors CLion.', 4, 3),
(3, '2019-03-21 02:25:45', 'Ils ont juste beaucoup d\'argent.', 5, 3),
(4, '2019-03-28 03:29:04', 'Il te suffit de faire une requête SQL qui va récupérer toutes les données et après tu fais une boucle pour les parcourir et tu les affiches dans les balises HTML.', 2, 3),
(5, '2019-03-26 13:31:12', 'Essaie avec Unity.', 3, 3),
(6, '2019-04-10 15:06:53', 'Une boucle sert à répéter la même action plusieurs fois en fonction de ce qui est demandé.\r\nTu as le for qui tourne un certain nombre de fois défini alors que le while, lui, tourne tant qu\'une condition est remplie.', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link_referer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `link_referer`) VALUES
(1, 'Général', 'general'),
(2, 'Algorithme', 'algorithme'),
(3, 'IA', 'ia'),
(4, 'Grosses données', 'grosses-donnees'),
(5, 'Graphismes 3D', 'graphismes-3d'),
(6, 'Web', 'web');

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `creation_date` datetime NOT NULL,
  `state` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'o' COMMENT '{‘o’, ’s’, ‘d’}',
  `user_id` int(11) NOT NULL,
  `referer_question_id` int(11) DEFAULT NULL,
  `correct_answer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`question_id`, `title`, `category_id`, `subject`, `creation_date`, `state`, `user_id`, `referer_question_id`, `correct_answer_id`) VALUES
(1, 'Comment faire une boucle ?', 2, 'Bonjour,\r\nJe suis débutant, et j\'ai entendu parler des boucles for, while,... \r\nQu\'est-ce ? Et comment puis-je en faire ? \r\nMerci', '2019-03-28 12:11:17', 'o', 2, NULL, NULL),
(2, 'Afficher des infos depuis la db', 6, 'Bonjour,\r\nJ\'ai une base de donnée (db) et j\'aimerais avoir la possibilité d\'aller chercher ces infos et les mettre dans un tableau html... Comment faire ça ? \r\nJ\'utilise PHP, merci.', '2019-03-27 17:24:05', 'o', 2, NULL, NULL),
(3, 'Jeu 3D en Java', 5, 'Bonjour,\r\nJe suis actuellement étudiant et j\'ai vu du Java.\r\nTrès simple à mon gout... c\'est pourquoi j\'aimerais me lancer dans la création d\'un jeu 3D en Java. \r\nQuels outils me conseillez-vous ? \r\nMerci', '2019-03-26 02:21:17', 'o', 1, NULL, NULL),
(4, 'Le meilleur IDE', 1, 'Bonjour,\r\nUtilisant Notepadd++ pour développer en C, je compile tout via le Terminal de mon Mac.\r\nCependant, ça devient du travail pour rien... je cherche donc un IDE simple et efficace, que me conseillez-vous ?', '2019-03-31 11:36:52', 'o', 1, NULL, 2),
(5, 'Facebook et leurs données', 4, 'Bonjour,\r\nJ\'ai découvert que Facebook est l\'un des sites ayant le + de données stockées... \r\nUne question me vint alors à l\'esprit : comment font-ils pour avoir tant de données et pourtant avoir une vitesse d\'exécution hors-normes ?', '2019-03-20 09:51:59', 'o', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passwd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isLocked` tinyint(4) NOT NULL DEFAULT '0' COMMENT '{0, 1}',
  `isAdmin` tinyint(4) NOT NULL DEFAULT '0' COMMENT '{0, 1}'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `name`, `firstname`, `username`, `email`, `passwd`, `isLocked`, `isAdmin`) VALUES
(1, 'Michiels', 'Alexis', 'alexismch', 'alexis.michiels@student.vinci.be', '$2y$10$5reFDF4z0rCxxSzUYgnfNuYDhK4KsdVZZAtDctOzg0sTUMczEPBHy', 0, 1),
(2, 'De Crombrugghe', 'Grégoire', 'decrombrugghe', 'gregoire.decrombrugghe@student.vinci.be', '$2y$10$5reFDF4z0rCxxSzUYgnfNuYDhK4KsdVZZAtDctOzg0sTUMczEPBHy', 0, 1),
(3, 'Random', 'Michel', 'randmi', 'michel.random@gmail.com', '$2y$10$5reFDF4z0rCxxSzUYgnfNuYDhK4KsdVZZAtDctOzg0sTUMczEPBHy', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `votes`
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE `votes` (
  `user_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `value` tinyint(1) NOT NULL COMMENT '{-1, +1}'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `votes`
--

INSERT INTO `votes` (`user_id`, `answer_id`, `value`) VALUES
(1, 1, -1),
(1, 2, 1),
(2, 2, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answer_id`) USING BTREE,
  ADD KEY `fk_answers_questions1_idx` (`question_id`),
  ADD KEY `fk_answers_users_idx` (`user_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`),
  ADD UNIQUE KEY `link_referer` (`link_referer`);

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`) USING BTREE,
  ADD KEY `fk_questions_users_idx` (`user_id`),
  ADD KEY `fk_questions_questions1_idx` (`referer_question_id`),
  ADD KEY `fk_questions_categories1_idx` (`category_id`),
  ADD KEY `fk_questions_answers1_idx` (`correct_answer_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Index pour la table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`answer_id`,`user_id`),
  ADD KEY `fk_votes_answers1_idx` (`answer_id`),
  ADD KEY `fk_votes_users1_idx` (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `answers`
--
ALTER TABLE `answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `fk_answers_questions1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_answers_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `fk_questions_answers1` FOREIGN KEY (`correct_answer_id`) REFERENCES `answers` (`answer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_questions_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_questions_questions1` FOREIGN KEY (`referer_question_id`) REFERENCES `questions` (`question_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_questions_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `fk_votes_answers1` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`answer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_votes_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
