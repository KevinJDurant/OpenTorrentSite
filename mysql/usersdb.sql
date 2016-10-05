-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 05 okt 2016 om 17:44
-- Serverversie: 5.6.13
-- PHP-versie: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `usersdb`
--
CREATE DATABASE IF NOT EXISTS `usersdb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `usersdb`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `reg_date` varchar(10) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` char(60) NOT NULL,
  `uploaderstatus` int(11) NOT NULL,
  `tempkey` varchar(120) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Gegevens worden uitgevoerd voor tabel `users`
--

INSERT INTO `users` (`user_id`, `email`, `reg_date`, `username`, `password`, `uploaderstatus`, `tempkey`) VALUES
(12, 'Kevindurant16@hotmail.com', '2016-09-29', 'Darkfard', '$2y$10$nRw2yVIEyXztXuHARw9VvucE9Lx7X8lkEgVCJBsqONtlsSJvuel5O', 0, '5fce7a434c5027afd4198a4b29e391aa');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
