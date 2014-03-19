-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 18, 2014 at 10:03 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbbscah`
--
CREATE DATABASE IF NOT EXISTS `dbbscah` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dbbscah`;

-- --------------------------------------------------------

--
-- Table structure for table `date`
--

CREATE TABLE IF NOT EXISTS `date` (
  `id` varchar(4) NOT NULL,
  `shifts` text,
  `mgr_notes` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `masterschedule`
--

CREATE TABLE IF NOT EXISTS `masterschedule` (
  `Schedule_type` text NOT NULL,
  `day` text NOT NULL,
  `start_time` text NOT NULL,
  `end_time` text,
  `slots` int(11) DEFAULT NULL,
  `persons` text,
  `notes` text,
  `id` text,
  `Projects` text,
  `Shifts` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `NameFirst` varchar(20) NOT NULL,
  `NameLast` varchar(25) NOT NULL,
  `Gender` varchar(1) NOT NULL,
  `Address` varchar(40) NOT NULL,
  `City` varchar(25) NOT NULL,
  `State` varchar(2) NOT NULL,
  `County` varchar(25) NOT NULL,
  `Phone1` int(10) NOT NULL,
  `Phone2` int(10) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Type` varchar(15) NOT NULL COMMENT 'Denotes wether a Coordinator or Volunteer',
  `Schedule` varchar(100) NOT NULL COMMENT 'Dates scheduled for voliunteering',
  `Notes` varchar(200) NOT NULL,
  `Password` varchar(25) NOT NULL,
  `ID` int(11) NOT NULL,
  `Availability` varchar(50) NOT NULL COMMENT 'days and times free for volunteering'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `ProjectID` int(3) NOT NULL AUTO_INCREMENT,
  `Address` varchar(50) NOT NULL,
  `Zip` int(5) NOT NULL,
  `StartDate` date NOT NULL,
  `End Date` date NOT NULL,
  `Coordinator` varchar(30) NOT NULL,
  `VolunteersRequired` int(3) NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  PRIMARY KEY (`ProjectID`),
  KEY `ProjectID` (`ProjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Collection of Projects' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE IF NOT EXISTS `shift` (
  `id` varchar(20) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `venue` text,
  `vacancies` int(11) DEFAULT NULL,
  `persons` text,
  `removed_persons` text,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `weeks`
--

CREATE TABLE IF NOT EXISTS `weeks` (
  `id` varchar(8) NOT NULL,
  `dates` text,
  `status` text,
  `end` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;