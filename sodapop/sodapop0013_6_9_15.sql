-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2015 at 12:46 AM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sodapop`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_user_users`
--

CREATE TABLE IF NOT EXISTS `app_user_users` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `username` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `bio` varchar(10000) NOT NULL,
  `accessLevel` int(2) NOT NULL,
  `recoveryToken` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=185 ;

--
-- Dumping data for table `app_user_users`
--

INSERT INTO `app_user_users` (`id`, `name`, `email`, `username`, `password`, `bio`, `accessLevel`, `recoveryToken`) VALUES
(178, 'Peter Pumpkin', 'qwerqwer@EMAIL3.com', 'Peter12345', '74be16979710d4c4e7c6647856088456', '', 5, ''),
(175, 'Bradley', 'bradisarobot@gmail.com', 'administrator', 'f855c82ad2efd190031207e9f41263ae', 'I am the site Administrator.  Hear me RAWR! (Really loudly.)', 10, ''),
(176, 'kjasdhfasdjh', 'qwerqwer@EMAIL1.com', 'akajshdf', '74be16979710d4c4e7c6647856088456', '', 3, ''),
(183, 'someone new', 'hello@SEAMAIL.com', 'someonenew', 'f855c82ad2efd190031207e9f41263ae', 'I am someone new!  Look how shiny I am!', 3, ''),
(184, 'anotherguy', 'asdfds@asdfasd.com', 'Another Guy', 'f855c82ad2efd190031207e9f41263ae', '', 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `positions` varchar(100) NOT NULL,
  `pages` varchar(1000) NOT NULL,
  `hidden` varchar(1000) NOT NULL,
  `params` varchar(1000) NOT NULL,
  `ordering` int(10) NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `positions`, `pages`, `hidden`, `params`, `ordering`, `active`) VALUES
(1, 'testModule', 'test', '', '', '', 3, 0),
(2, 'newModule', 'test', '', 'episode', '', 2, 0),
(3, 'login', 'login', '', '', 'redirect==user::registration==on::recover==on', 0, 1),
(4, 'menu', 'menu', '', '', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `pageID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `handle` varchar(11) NOT NULL,
  `getApp` varchar(20) NOT NULL,
  PRIMARY KEY (`pageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`pageID`, `name`, `handle`, `getApp`) VALUES
(3, '', 'drwho', 'show'),
(6, 'Home', '', 'demo'),
(4, 'The Monkey Page', 'monkeys', 'demo'),
(5, 'Hit The Brick Wall', 'brick-wall', 'demo'),
(7, 'LAMP!', 'lamp', 'demo'),
(8, 'User Page', 'user', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `templateID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(21) NOT NULL,
  `dflt` varchar(1) NOT NULL,
  `assigned` int(11) NOT NULL,
  PRIMARY KEY (`templateID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`templateID`, `name`, `dflt`, `assigned`) VALUES
(3, 'default', '0', 0),
(4, 'devTemplate', '1', 0);
