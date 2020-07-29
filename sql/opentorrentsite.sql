-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 29, 2020 at 10:09 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `opentorrentsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `categoryname` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `categoryname`) VALUES
(1, 'Movies'),
(2, 'Television'),
(3, 'Music'),
(4, 'Games'),
(5, 'Software'),
(6, 'Anime'),
(7, 'Books'),
(8, 'XXX'),
(9, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `torrents`
--

CREATE TABLE `torrents` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `description` varchar(21844) NOT NULL COMMENT 'richtext',
  `name` varchar(80) NOT NULL,
  `uploaddate` date NOT NULL,
  `size` varchar(250) NOT NULL,
  `seeders` int(11) NOT NULL,
  `leechers` int(11) NOT NULL,
  `hash` varchar(100) NOT NULL,
  `magnet` varchar(800) NOT NULL,
  `files` varchar(5000) NOT NULL,
  `imdb` varchar(10) DEFAULT NULL,
  `votes` int(23) DEFAULT '0',
  `LastRefresh` int(23) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `email` varchar(30) NOT NULL,
  `reg_date` varchar(10) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` char(60) NOT NULL,
  `uploaderstatus` int(11) NOT NULL DEFAULT '0',
  `tempkey` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `torrentid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `hasvoted` tinyint(1) NOT NULL COMMENT 'votes increment of upcrement'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `torrents`
--
ALTER TABLE `torrents`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `torrents` ADD FULLTEXT KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `torrents`
--
ALTER TABLE `torrents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
