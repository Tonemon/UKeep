-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2020 at 10:31 AM
-- Server version: 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `UKeepDAT`
--

-- --------------------------------------------------------

--
-- Table structure for table `items_H4J23`
--

CREATE TABLE IF NOT EXISTS `items_H4J23` (
  `id` int(5) NOT NULL,
  `user_code` varchar(5) NOT NULL,
  `type` varchar(4) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `dateon` datetime DEFAULT NULL,
  `editdate` datetime NOT NULL,
  `label` varchar(5) NOT NULL,
  `location` varchar(32) NOT NULL,
  `people` text NOT NULL,
  `bookmark` int(1) NOT NULL,
  `priority` varchar(1) NOT NULL,
  `status` varchar(8) NOT NULL,
  `visits` int(5) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items_H4J23`
--

INSERT INTO `items_H4J23` (`id`, `user_code`, `type`, `title`, `description`, `dateon`, `editdate`, `label`, `location`, `people`, `bookmark`, `priority`, `status`, `visits`) VALUES
(1, 'H4J23', 'task', 'The Title of my task ', 'Normal task with high priority. This is some placeholder text for a special item like this to check if everything is working correctly.', '0000-00-00 00:00:00', '2020-04-11 18:45:12', '2', 'Home', 'Me', 1, '3', 'ACTIVE', 321),
(2, 'H4J23', 'note', 'The Title of my note 2', 'Normal note with no priority. This is some placeholder text for a special item like this to check if everything is working correctly.', '0000-00-00 00:00:00', '2020-04-22 11:29:01', '3', '', '', 0, '', 'ACTIVE', 231),
(3, 'H4J23', 'task', 'An archived task', 'Normal task with high priority and archived. This is some placeholder text for a special item like this to check if everything is working correctly.', '0000-00-00 00:00:00', '2020-03-31 20:58:11', '3', 'Netherlands', 'John & Andrew', 0, '1', 'ARCHIVED', 122),
(5, 'H4J23', 'task', 'just trash lol', 'just trash lol 23', '0000-00-00 00:00:00', '2020-03-31 20:54:19', '1', '', '', 0, '0', 'TRASH', 122),
(6, 'H4J23', 'note', 'Testing note insert', 'Normal note with no priority. This is some placeholder text for a special item like this to check if everything is working correctly.', '0000-00-00 00:00:00', '2020-04-22 11:28:49', '1', '', '', 0, '', 'ACTIVE', 0);

-- --------------------------------------------------------

--
-- Table structure for table `label_H4J23`
--

CREATE TABLE IF NOT EXISTS `label_H4J23` (
  `label_id` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `color` varchar(10) NOT NULL,
  `lab_description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `label_H4J23`
--

INSERT INTO `label_H4J23` (`label_id`, `name`, `color`, `lab_description`) VALUES
(1, 'Inbox ðŸ“š', 'success', 'All items from the inbox will be stored with this label'),
(2, 'Digital ðŸ’»', 'info', 'These items can only be done digitally'),
(3, 'Quick â°', 'danger', 'This label is for items that need to be done as quick as possible');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items_H4J23`
--
ALTER TABLE `items_H4J23`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `label_H4J23`
--
ALTER TABLE `label_H4J23`
  ADD PRIMARY KEY (`label_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items_H4J23`
--
ALTER TABLE `items_H4J23`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `label_H4J23`
--
ALTER TABLE `label_H4J23`
  MODIFY `label_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
