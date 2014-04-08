-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 02, 2014 at 05:11 PM
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
  `DATE_ID` varchar(8) NOT NULL,
  `shifts` text,
  `mgr_notes` text,
  `Projects` text NOT NULL,
  PRIMARY KEY (`DATE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `masterschedule`
--

CREATE TABLE IF NOT EXISTS `masterschedule` (
  `MS_ID` varchar(25) NOT NULL DEFAULT '',
  `Schedule_type` text NOT NULL,
  `day` text NOT NULL,
  `start_time` text NOT NULL,
  `end_time` text,
  `slots` int(11) DEFAULT NULL,
  `persons` text,
  `notes` text,
  `Shifts` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `ID` varchar(25) NOT NULL,
  `NameFirst` varchar(20) NOT NULL,
  `NameLast` varchar(25) NOT NULL,
  `Gender` varchar(1) NOT NULL,
  `Address` varchar(40) NOT NULL,
  `City` varchar(25) NOT NULL,
  `State` varchar(2) NOT NULL,
  `Zip` varchar(5) NOT NULL,
  `County` varchar(25) DEFAULT NULL,
  `Phone1` int(10) NOT NULL,
  `Phone2` int(10) DEFAULT NULL,
  `Email` varchar(30) NOT NULL,
  `Type` varchar(15) NOT NULL COMMENT 'Denotes wether a Coordinator or Volunteer',
  `Status` varchar(15) NOT NULL COMMENT 'values could be applicant or approved for Volunteer, null for  Coordinator',
  `Schedule` varchar(100) NOT NULL COMMENT 'Dates scheduled for voliunteering',
  `Notes` varchar(200) NOT NULL,
  `Password` varchar(25) NOT NULL,
  `Availability` varchar(50) NOT NULL COMMENT 'days and times free for volunteering',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`ID`, `NameFirst`, `NameLast`, `Gender`, `Address`, `City`, `State`, `Zip`, `County`, `Phone1`, `Phone2`, `Email`, `Type`, `Status`, `Schedule`, `Notes`, `Password`, `Availability`) VALUES
('Alana5164918985', 'Alana', 'Mutum', 'F', '1140 Esther St', 'Franklin Square', 'NY', '11010', 'SomeCounty',2147483647, 0, 'lanixxjay@live.com', 'Volunteer', 'applicant','', '', 'cus1166', ''),
('staff1166', 'Student', 'Student', 'M', '8000 Utopia Pkwy', 'Queens', 'NY',  '11439', 'Queens',911, 0, 'student@stjohns,edu', 'Volunteer', 'approved','', '', 'cus1166', ''),
('student1166', 'Student', 'Student', 'M', '8000 Utopia Pkwy', 'Queens', 'NY',  '11439', 'Queens',911, 0, 'student@stjohns,edu', 'Volunteer', 'approved','', '', 'cus1166', '');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `ProjectID` varchar(58) NOT NULL,
  `Address` varchar(50),
  `Date` varchar(10) NOT NULL,
  `Vacancies` int(3) NOT NULL,
  `StartTime` int(4) NOT NULL,  
  `EndTime` int(4) NOT NULL,
 `DayOfWeek` varchar(3) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Persons`  text,
  `Notes` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ProjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Collection of Projects';

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE IF NOT EXISTS `shift` (
  `id` varchar(20) NOT NULL DEFAULT '',
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `venue` text,
  `vacancies` int(11) DEFAULT NULL,
  `persons` text,
  `removed_persons` text,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`id`, `start_time`, `end_time`, `venue`, `vacancies`, `persons`, `removed_persons`, `notes`) VALUES
('Health-01', 9, 10, 'HEALTH 360', 5, NULL, NULL, NULL),
('MPan-001', 9, 5, 'Mobile Pantry', 6, NULL, NULL, NULL),
('MPAN-002', 5, 11, 'Mobile Pantry', 6, NULL, NULL, NULL),
('REA-001', 9, 6, 'REACH', 8, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `weeks`
--

CREATE TABLE IF NOT EXISTS `weeks` (
  `id` varchar(8) NOT NULL,
  `dates` text,
  `status` text,
  `end` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
