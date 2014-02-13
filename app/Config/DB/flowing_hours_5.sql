-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 13, 2014 at 08:33 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `flowing_hours`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) CHARACTER SET latin1 NOT NULL,
  `level` int(2) NOT NULL COMMENT 'level of intensity',
  `message` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `type`, `level`, `message`) VALUES
(1, 'positive', 0, 'Great job!'),
(2, 'positive', 1, 'Wow, you have really got things done!'),
(3, 'encouraging', 0, 'Great job!'),
(4, 'caring', 1, 'It seems you have lots of work and no breaks. How about a break now?'),
(5, 'caring', 0, 'You haven’t checked on your tasks. Do you have too much to do?'),
(6, 'encouraging', 1, 'Hey, you are doing really great!'),
(7, 'persuasive', 2, 'Is everything alright? Have you been sick or something? If yes, we sympethize with you else you real'),
(8, 'persuasive', 0, 'You still need plenty of work to do'),
(9, 'persuasive', 1, 'Push more, before the weekend, you can complete remaining %d hours');

-- --------------------------------------------------------

--
-- Table structure for table `schema_migrations`
--

CREATE TABLE IF NOT EXISTS `schema_migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` varchar(255) CHARACTER SET latin1 NOT NULL,
  `type` varchar(50) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `schema_migrations`
--

INSERT INTO `schema_migrations` (`id`, `class`, `type`, `created`) VALUES
(1, 'InitMigrations', 'Migrations', '2013-10-13 14:57:57'),
(2, 'ConvertVersionToClassNames', 'Migrations', '2013-10-13 14:57:57'),
(3, 'IncreaseClassNameLength', 'Migrations', '2013-10-13 14:57:57'),
(4, 'Emptydb', 'app', '2013-10-13 14:58:23'),
(5, 'M49c3417a54874a9d276811502cedc421', 'Users', '2013-10-13 14:59:40'),
(6, 'M4ef8ba03ff504ab2b415980575f6eb26', 'Users', '2013-10-13 14:59:40');

-- --------------------------------------------------------

--
-- Table structure for table `tasklists`
--

CREATE TABLE IF NOT EXISTS `tasklists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` varchar(36) CHARACTER SET latin1 NOT NULL,
  `title` varchar(255) NOT NULL,
  `ordering` tinyint(1) NOT NULL DEFAULT '0',
  `attribs` text CHARACTER SET latin1,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `users_id` (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `tasklists`
--

INSERT INTO `tasklists` (`id`, `users_id`, `title`, `ordering`, `attribs`) VALUES
(2, '525abf41-447c-4ede-a7ee-1074788903e6', 'TEST ', 1, NULL),
(13, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 'Ã¤Ã¤Ã¤Ã¤Ã¤Ã¤uu', 0, NULL),
(14, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 'TEST2', 0, NULL),
(15, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 'HHHHHHHHHHHHHH', 0, NULL),
(16, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 'tettt3', 0, NULL),
(17, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 'TEST', 0, NULL),
(18, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 'TTTTTTTTTTTT', 0, NULL),
(19, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 'fffffffffff', 0, NULL),
(20, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 'FFFFFFFFFFFFFFFFFFFF', 0, NULL),
(21, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 'ffffffffffffaaaaaaaaaaa', 0, NULL),
(22, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 'faaaaaaaaaaaaaaaaaa', 0, NULL),
(23, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 'fffffffffffff', 0, NULL),
(24, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', '9999999999999999', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` varchar(36) CHARACTER SET latin1 NOT NULL,
  `tasklists_id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `desc` text,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '(1- done/0 - unfinished)',
  `estimated_hours` int(3) NOT NULL DEFAULT '0',
  `reported_hours` int(3) NOT NULL DEFAULT '0',
  `ordering` tinyint(1) NOT NULL DEFAULT '0',
  `attribs` text CHARACTER SET latin1 NOT NULL COMMENT 'misc attributes like color scheme etc',
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`),
  KEY `tasklists_id` (`tasklists_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `users_id`, `tasklists_id`, `title`, `desc`, `start_date`, `end_date`, `status`, `estimated_hours`, `reported_hours`, `ordering`, `attribs`) VALUES
(23, '525abf41-447c-4ede-a7ee-1074788903e6', 2, 'TEST', 'TEST', '2014-01-23 23:43:00', '2014-01-23 23:43:00', 0, 1, 0, 0, ''),
(31, '525abf41-447c-4ede-a7ee-1074788903e6', 2, 'TEST444', 'TEST444', '2014-01-24 07:20:00', '2014-01-29 07:33:00', 0, 2, 0, 0, ''),
(33, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 13, 'TEST2222', 'TESSSSSSSSSS', '2014-02-06 21:42:00', '2014-02-06 21:59:00', 0, 2, 0, 0, ''),
(34, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 13, 'ttttttttt3', 'ttttttttttttttttt', '2014-02-13 18:40:00', '2014-02-13 18:40:00', 1, 2, 0, 0, ''),
(35, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 13, 'TTTTTTTT', 'ssssssssssssss', '2014-01-31 05:41:00', '2014-01-31 05:53:00', 0, 2, 0, 0, ''),
(36, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 13, 'aaaaaaaa', 'ddddddddddddd', '2014-01-30 05:43:00', '2014-01-31 05:43:00', 0, 3, 0, 0, ''),
(39, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 14, 'ddddd', 'ddddddd', '2014-02-01 03:53:00', '2014-02-07 03:53:00', 0, 6, 0, 0, ''),
(40, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 14, 'tesss', 'fffffff', '2014-02-01 04:33:00', '2014-02-08 04:33:00', 0, 5, 0, 0, ''),
(41, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 14, 'tesss', 'fffffff', '2014-02-01 04:33:00', '2014-02-08 04:33:00', 0, 5, 0, 0, ''),
(42, '52e9c10b-f5f4-4e1e-81b0-1794788903e6', 14, 'fg', 'gfgf', '2014-02-01 04:34:00', '2014-02-07 04:34:00', 0, 2, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(36) CHARACTER SET latin1 NOT NULL,
  `username` varchar(255) NOT NULL,
  `slug` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` varchar(128) DEFAULT NULL,
  `password_token` varchar(128) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT '0',
  `email_token` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `email_token_expires` datetime DEFAULT NULL,
  `tos` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `last_action` datetime DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `role` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `settings` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `BY_USERNAME` (`username`),
  KEY `BY_EMAIL` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `slug`, `password`, `password_token`, `email`, `email_verified`, `email_token`, `email_token_expires`, `tos`, `active`, `last_login`, `last_action`, `is_admin`, `role`, `created`, `modified`, `settings`) VALUES
('525abf41-447c-4ede-a7ee-1074788903e6', 'abrar', 'abrar', '1306d87df0130193d7a4d0581af8cce1ed38aa74', NULL, 'abrar.aamer@uta.fi', 1, 'jkwxgmld9o', '2013-10-14 15:41:53', 1, 1, '2014-02-13 08:24:21', NULL, 0, 'registered', '2013-10-13 15:41:53', '2014-02-13 08:24:21', '{"energy_hours":"12"}'),
('525ac11a-1ce4-4fcf-a462-1074788903e6', 'admin', 'admin', '1306d87df0130193d7a4d0581af8cce1ed38aa74', NULL, 'admin@localhost.com', 1, '7fdwcrz9mn', '2013-10-14 15:49:46', 1, 1, '2013-11-03 15:31:23', NULL, 1, 'admin', '2013-10-13 15:49:46', '2013-11-03 15:31:23', ''),
('52e9c10b-f5f4-4e1e-81b0-1794788903e6', 'tester', 'tester', '1306d87df0130193d7a4d0581af8cce1ed38aa74', NULL, 'tester@htmyth.fi', 1, 'zj61q3vapk', '2014-01-31 03:03:39', 1, 1, '2014-02-13 04:08:46', NULL, 0, 'user_registered', '2014-01-30 03:03:39', '2014-02-13 04:08:46', '{"energy_hours":"12","calendar_wallpaper":"scenica","g_energy_hours":"25","g_punctual":"0"}');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
  `id` varchar(36) CHARACTER SET latin1 NOT NULL,
  `user_id` varchar(36) CHARACTER SET latin1 NOT NULL,
  `position` float NOT NULL DEFAULT '1',
  `field` varchar(60) CHARACTER SET latin1 NOT NULL,
  `value` text CHARACTER SET latin1,
  `input` varchar(16) CHARACTER SET latin1 NOT NULL,
  `data_type` varchar(16) CHARACTER SET latin1 NOT NULL,
  `label` varchar(128) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_PROFILE_PROPERTY` (`field`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_preference`
--

CREATE TABLE IF NOT EXISTS `user_preference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) NOT NULL COMMENT 'g stands for global- this is saved in the users table',
  `question_title` text NOT NULL,
  `question_descriptions` text NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_preference`
--

INSERT INTO `user_preference` (`id`, `type`, `question_title`, `question_descriptions`, `ordering`) VALUES
(1, 'g_energy_hours', 'Work hours', 'How many hours do you work in a week?', 1),
(2, 'g_punctual', 'Task Completion Time', 'Do you usually complete your tasks in time?', 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasklists`
--
ALTER TABLE `tasklists`
  ADD CONSTRAINT `tasklists_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`tasklists_id`) REFERENCES `tasklists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
