-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 19, 2017 at 07:03 PM
-- Server version: 5.6.13
-- PHP Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `opentorrentsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `torrentid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `hasvoted` tinyint(1) NOT NULL COMMENT 'votes increment of upcrement',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
