-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  mer. 15 mai 2019 à 11:22
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `class_not_found`
--

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `name`, `firstname`, `username`, `email`, `passwd`, `isLocked`, `isAdmin`) VALUES
(1, 'Michiels', 'Alexis', 'alexismch', 'alexis.michiels@student.vinci.be', '$2y$10$5reFDF4z0rCxxSzUYgnfNuYDhK4KsdVZZAtDctOzg0sTUMczEPBHy', 0, 1),
(2, 'De Crombrugghe', 'Grégoire', 'decrombrugghe', 'gregoire.decrombrugghe@student.vinci.be', '$2y$10$5reFDF4z0rCxxSzUYgnfNuYDhK4KsdVZZAtDctOzg0sTUMczEPBHy', 0, 1),
(3, 'Random', 'Michel', 'randmi', 'michel.random@gmail.com', '$2y$10$5reFDF4z0rCxxSzUYgnfNuYDhK4KsdVZZAtDctOzg0sTUMczEPBHy', 0, 0);

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

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`question_id`, `title`, `category_id`, `subject`, `creation_date`, `state`, `user_id`, `referer_question_id`, `correct_answer_id`) VALUES
(1, 'Comment faire une boucle ?', 2, 'Bonjour,\r\nJe suis débutant, et j\'ai entendu parler des boucles for, while,... \r\nQu\'est-ce ? Et comment puis-je en faire ? \r\nMerci', '2019-03-28 12:11:17', 'd', 2, 1, NULL),
(3, 'Jeu 3D en Java', 5, 'Bonjour,\r\nJe suis actuellement étudiant et j\'ai vu du Java.\r\nTrès simple à mon gout... c\'est pourquoi j\'aimerais me lancer dans la création d\'un jeu 3D en Java. \r\nQuels outils me conseillez-vous ? \r\nMerci', '2019-03-26 02:21:17', 'o', 1, NULL, NULL),
(4, 'Le meilleur IDE', 1, 'Bonjour,&lt;br /&gt;<br />\r\nUtilisant Notepadd++ pour développer en C, je compile tout via le Terminal de mon Mac.&lt;br /&gt;<br />\r\nCependant, ça devient du travail pour rien... je cherche donc un IDE simple et efficace, que me conseillez-vous ?', '2019-03-31 11:36:52', 's', 1, NULL, 2),
(5, 'Facebook et leurs données', 4, 'Bonjour,\r\nJ\'ai découvert que Facebook est l\'un des sites ayant le + de données stockées... \r\nUne question me vint alors à l\'esprit : comment font-ils pour avoir tant de données et pourtant avoir une vitesse d\'exécution hors-normes ?', '2019-03-20 09:51:59', 'o', 2, NULL, NULL);

--
-- Déchargement des données de la table `answers`
--

INSERT INTO `answers` (`answer_id`, `creation_date`, `subject`, `question_id`, `user_id`) VALUES
(1, '2019-03-31 12:39:10', 'Yop, pour moi le meilleur IDE pour le C, c\'est CodeBlocks, certes très simple mais il fait l\'affaire.', 4, 2),
(2, '2019-03-31 18:22:02', 'Salut, je ne suis pas du tout d\'accord avec @decrombrugghe... CodeBlocks n\'est pas très efficace ! \r\nMoi je conseille dans tous les cas la suite JetBrains... pour toi ce sera alors CLion.', 4, 3),
(3, '2019-03-21 02:25:45', 'Ils ont juste beaucoup d\'argent.', 5, 3),
(5, '2019-03-26 13:31:12', 'Essaie avec Unity.', 3, 3),
(6, '2019-04-10 15:06:53', 'Une boucle sert à répéter la même action plusieurs fois en fonction de ce qui est demandé.\r\nTu as le for qui tourne un certain nombre de fois défini alors que le while, lui, tourne tant qu\'une condition est remplie.', 1, 1);

--
-- Déchargement des données de la table `votes`
--

INSERT INTO `votes` (`user_id`, `answer_id`, `value`) VALUES
(1, 1, -1),
(1, 2, 1),
(2, 2, 1),
(1, 6, 0);
