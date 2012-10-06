-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 08, 2011 at 04:08 AM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `episodapop`
--

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `pageID` int(11) NOT NULL AUTO_INCREMENT,
  `handle` varchar(11) NOT NULL,
  `getPage` varchar(20) NOT NULL,
  PRIMARY KEY (`pageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`pageID`, `handle`, `getPage`) VALUES
(3, 'drwho', 'show'),
(6, '', 'show'),
(4, 'episode', 'episode'),
(5, 'profile', 'profile'),
(7, 'show', 'show');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`templateID`, `name`, `dflt`, `assigned`) VALUES
(3, 'default', '0', 0),
(4, 'devTemplate', '1', 0);
