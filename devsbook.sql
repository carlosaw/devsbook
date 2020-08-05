-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 03-Ago-2020 às 20:25
-- Versão do servidor: 10.4.10-MariaDB
-- versão do PHP: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `devsbook`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `postcomments`
--

DROP TABLE IF EXISTS `postcomments`;
CREATE TABLE IF NOT EXISTS `postcomments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `postlikes`
--

DROP TABLE IF EXISTS `postlikes`;
CREATE TABLE IF NOT EXISTS `postlikes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `posts`
--

INSERT INTO `posts` (`id`, `id_user`, `type`, `created_at`, `body`) VALUES
(1, 1, 'photo', '2020-07-28 01:10:48', '1.jpg'),
(2, 1, 'text', '2020-07-28 01:12:02', 'Postando alguma coisa bem legal'),
(3, 1, 'text', '2020-07-27 21:19:19', 'Outro post bacana'),
(4, 1, 'text', '2020-07-28 09:19:22', 'Postando aquilo que gosta'),
(5, 1, 'text', '2020-07-28 10:49:27', 'enviando de novo'),
(6, 1, 'text', '2020-07-28 10:50:13', 'algum post enviado'),
(7, 1, 'text', '2020-07-28 10:50:36', 'enviando com igual'),
(8, 1, 'text', '2020-07-28 10:52:56', 'mais post bem legal'),
(9, 1, 'text', '2020-08-03 16:13:37', 'Digitando teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `userrelations`
--

DROP TABLE IF EXISTS `userrelations`;
CREATE TABLE IF NOT EXISTS `userrelations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `userrelations`
--

INSERT INTO `userrelations` (`id`, `user_from`, `user_to`) VALUES
(2, 6, 1),
(3, 1, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `work` varchar(100) DEFAULT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT 'avatar.jpg',
  `cover` varchar(100) NOT NULL DEFAULT 'cover.jpg',
  `token` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `birthdate`, `city`, `work`, `avatar`, `cover`, `token`) VALUES
(1, 'b7@gmail.com', '$2y$10$5p/JG23TE0F9a.hgLZhNouz5KPR4kftjrjV6aZHrjtIua7ph69C2O', 'Carlos Alberto', '1902-12-11', 'CuiabÃ¡', 'AW Regulagens Ltda.', 'avatar1.png', 'maxresdefault.jpg', 'a8a4217ed48b0360c77a30caa3a06871'),
(2, 'carlos@gmail.com', '$2y$10$i5iQElOAYZxniLwQHQH2gOhSFuOWxpa5t1sUXd6jgTFHPyYm/h2.y', 'Alberto Moraes', '1930-01-10', NULL, NULL, 'avatar.jpg', 'cover.jpg', 'b5a32bdb058c16299292481d68b3d0ca'),
(3, 'feliciano@gmail.com', '$2y$10$F57iro3e9uE6qcp3Z.2nx.KjUUC7YA8X.ttNs4UYiK0qml00LTD6G', 'João Feliciano', '1980-11-12', NULL, NULL, 'avatar.jpg', 'cover.jpg', 'de6f40225066e5105a0e2f3bc06da7ef'),
(4, 'pedro@gmail.com', '$2y$10$xVnqsu14neBM9MFf2aHyP.jVEJ23xXxq5SHT2d9gZQ5HA6JdW0FHq', 'Pedro Henrique', '1980-10-11', NULL, NULL, 'avatar.jpg', 'cover.jpg', '885d4612bebcc87f13642a6644d53026'),
(5, 'joao@gmail.com', '$2y$10$3fm7dwaKH4KRoW.aDoiFG.yxwW57bmKFRf15G3fy9djCDHdP9aZLq', 'JoaÃµ Pedro', '1980-04-20', NULL, NULL, 'avatar.jpg', 'cover.jpg', '7bdd402ce096f464d60ff6fbf7473edc'),
(6, 'ana@gmail.com', '$2y$10$W0esw6vcXfVBFuJJ.tIf0ePPE3LmH4PnfPNZAR2XN9.PkWFSbqsKS', 'Ana Paula', '1980-12-11', 'VÃ¡rzea Grande', 'ConcÃ³rdia Grill', 'avatar.jpg', 'cover.jpg', '5513445823a702c05ece8f621d2374e8');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
