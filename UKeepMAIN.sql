-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2020 at 10:30 AM
-- Server version: 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `UKeepMAIN`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL,
  `usercode` varchar(5) NOT NULL,
  `date` date NOT NULL,
  `amount_created` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `usercode`, `date`, `amount_created`) VALUES
(1, 'H4J23', '2020-03-29', 2);

-- --------------------------------------------------------

--
-- Table structure for table `codes`
--

CREATE TABLE IF NOT EXISTS `codes` (
  `id` int(5) NOT NULL,
  `type` varchar(10) NOT NULL,
  `code` varchar(10) NOT NULL,
  `times_used` int(5) NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `codes`
--

INSERT INTO `codes` (`id`, `type`, `code`, `times_used`, `status`) VALUES
(1, 'register', '5F9FSW66W3', 0, 'VALID'),
(2, 'team', '45JLKD9823', 0, 'VALID');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `usercode_user1` varchar(32) NOT NULL,
  `usercode_user2` varchar(32) NOT NULL COMMENT 'unique because user cannot add the same person twice',
  `user1_status` varchar(10) NOT NULL DEFAULT 'REQUEST',
  `user2_status` varchar(10) NOT NULL DEFAULT 'PENDING',
  `status` varchar(10) NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE IF NOT EXISTS `preferences` (
  `account_usercode` varchar(5) NOT NULL,
  `user_theme` varchar(10) NOT NULL DEFAULT 'primary',
  `redirect_url` varchar(10) NOT NULL,
  `side_suite` int(1) NOT NULL DEFAULT '1',
  `side_notes_tasks` int(1) NOT NULL DEFAULT '0',
  `side_notes` int(1) NOT NULL DEFAULT '0',
  `side_tasks` int(1) NOT NULL DEFAULT '0',
  `side_labels` int(1) NOT NULL DEFAULT '0',
  `side_trash` int(1) NOT NULL DEFAULT '0',
  `side_teams` int(1) NOT NULL DEFAULT '1',
  `side_contacts` int(1) NOT NULL DEFAULT '1',
  `side_support` int(1) NOT NULL DEFAULT '1',
  `side_guide` int(1) NOT NULL DEFAULT '1',
  `side_settings` int(1) NOT NULL DEFAULT '1',
  `dash_show_start` int(1) NOT NULL DEFAULT '1',
  `dashw_show_week` int(1) NOT NULL DEFAULT '1',
  `dashw_show_deadlines` int(1) NOT NULL DEFAULT '1',
  `dashw_show_active` int(1) NOT NULL DEFAULT '1',
  `dashw_show_ratio` int(1) NOT NULL DEFAULT '1',
  `dash_show_chart1` int(1) NOT NULL DEFAULT '1',
  `dash_show_chart2` int(1) NOT NULL DEFAULT '1',
  `dash_show_labels` int(1) NOT NULL DEFAULT '1',
  `dash_show_book` int(1) NOT NULL DEFAULT '1',
  `account_show_pic` int(1) NOT NULL DEFAULT '0',
  `account_show_status` int(1) NOT NULL DEFAULT '1',
  `account_show_fullname` int(1) NOT NULL DEFAULT '0',
  `account_show_email` int(1) NOT NULL DEFAULT '0',
  `account_show_dob` int(1) NOT NULL DEFAULT '0',
  `account_show_gender` int(1) NOT NULL DEFAULT '1',
  `teams_show_start` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`account_usercode`, `user_theme`, `redirect_url`, `side_suite`, `side_notes_tasks`, `side_notes`, `side_tasks`, `side_labels`, `side_trash`, `side_teams`, `side_contacts`, `side_support`, `side_guide`, `side_settings`, `dash_show_start`, `dashw_show_week`, `dashw_show_deadlines`, `dashw_show_active`, `dashw_show_ratio`, `dash_show_chart1`, `dash_show_chart2`, `dash_show_labels`, `dash_show_book`, `account_show_pic`, `account_show_status`, `account_show_fullname`, `account_show_email`, `account_show_dob`, `account_show_gender`, `teams_show_start`) VALUES
('H4J23', 'danger', '', 1, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(10) NOT NULL,
  `name` varchar(32) NOT NULL,
  `email` varchar(60) NOT NULL,
  `question` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL,
  `readby` varchar(32) NOT NULL,
  `askedby` varchar(32) NOT NULL,
  `time` datetime NOT NULL,
  `response` varchar(255) NOT NULL,
  `useraction` varchar(8) NOT NULL DEFAULT 'NEW'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `name`, `email`, `question`, `message`, `status`, `readby`, `askedby`, `time`, `response`, `useraction`) VALUES
(1, 'John Doe', 'johndoe@gmail.com', 'Services', 'Hi, I would like to know more about the two account types and which one will suit me the best. I am thinking about premium for work. Greets, John', 'TO REVIEW', '', 'User panel', '2019-01-20 08:44:25', '', 'NEW');

-- --------------------------------------------------------

--
-- Table structure for table `security`
--

CREATE TABLE IF NOT EXISTS `security` (
  `id` int(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `timeleft` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1323 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `security`
--

INSERT INTO `security` (`id`, `description`, `message`, `status`, `author`, `timeleft`) VALUES
(1321, 'System Maintenance', 'Developing messages board. Normal online banking should be working.', 'PENDING', 'Development Center', '2019-07-20 20:00:00'),
(1322, 'Security Maintenance', 'Fixing different minor bugs during the night. UBank Online banking will be unavailable for a moment.', 'PENDING', 'Security Center', '2019-07-19 04:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(5) NOT NULL,
  `name` varchar(32) NOT NULL,
  `email` varchar(60) NOT NULL,
  `username` varchar(32) NOT NULL,
  `accstatus` varchar(8) NOT NULL,
  `status` varchar(7) NOT NULL,
  `lastlogin` datetime DEFAULT '0000-00-00 00:00:00',
  `password` varchar(80) NOT NULL,
  `usercode` varchar(5) NOT NULL,
  `account` varchar(7) NOT NULL,
  `first_login` int(1) NOT NULL DEFAULT '1',
  `gender` varchar(1) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(40) NOT NULL,
  `mobile` varchar(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `accstatus`, `status`, `lastlogin`, `password`, `usercode`, `account`, `first_login`, `gender`, `dob`, `address`, `mobile`) VALUES
(1, 'Admin User', 'admin@ukeep.me', 'admin', 'ACTIVE', 'online', '2020-04-23 08:37:17', '515b11240733ed0a3eed2daecaba9e215b5a241f', 'H4J23', 'admin', 1, 'M', '1996-05-08', 'street 7', '0612345678');

-- --------------------------------------------------------

--
-- Table structure for table `usersclosed`
--

CREATE TABLE IF NOT EXISTS `usersclosed` (
  `id` int(5) NOT NULL,
  `name` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `acc_type` varchar(7) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `deleted` varchar(10) NOT NULL,
  `reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD UNIQUE KEY `usercode_user2` (`usercode_user2`);

--
-- Indexes for table `preferences`
--
ALTER TABLE `preferences`
  ADD UNIQUE KEY `account_usercode` (`account_usercode`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `security`
--
ALTER TABLE `security`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usersclosed`
--
ALTER TABLE `usersclosed`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `codes`
--
ALTER TABLE `codes`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `security`
--
ALTER TABLE `security`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1323;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usersclosed`
--
ALTER TABLE `usersclosed`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
