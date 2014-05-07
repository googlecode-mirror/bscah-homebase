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

-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 09, 2014 at 04:59 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `masterschedule`
--

CREATE TABLE IF NOT EXISTS `masterschedule` (
  `MS_ID` varchar(25) NOT NULL DEFAULT '',
  `Schedule_type` text NOT NULL,
  `day` text NOT NULL,
  `Week_no` text NOT NULL, 
  `start_time` text NOT NULL,
  `end_time` text,
  `slots` int(11) DEFAULT NULL,
  `persons` text,
  `notes` text,
  `Shifts` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `ID` varchar(25) NOT NULL,
  `NameFirst` varchar(20) NOT NULL,
  `NameLast` varchar(25) NOT NULL,
  `Birthday` varchar(11) NOT NULL, 
  `Gender` varchar(1) NOT NULL,
  `Address` varchar(40) NOT NULL,
  `City` varchar(25) NOT NULL,
  `State` varchar(2) NOT NULL,
  `Zip` varchar(5) NOT NULL,
  `Phone1` int(10) NOT NULL,
  `Phone2` int(10) DEFAULT NULL,
  `Email` varchar(30) NOT NULL,
  `Type` varchar(15) NOT NULL COMMENT 'Denotes wether a manager, volunteer or guest',
  `Status` varchar(15) COMMENT 'values could be applicant or approved for volunteer, null for  manager',
  `Schedule` varchar(100) NOT NULL COMMENT 'Dates scheduled for voliunteering',
  `Notes` varchar(200) NOT NULL,
  `Password`  text NOT NULL,
  `Availability` varchar(50) NOT NULL COMMENT 'days and times free for volunteering',
   `ContactPreference` varchar(15) NOT NULL COMMENT 'either email, mail or phone number',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`ID`, `NameFirst`, `NameLast`, `Birthday`, `Gender`, `Address`, `City`, `State`, `Zip`, `Phone1`, `Phone2`, `Email`, `Type`, `Status`, `Schedule`, `Notes`, `Password`, `Availability`, `ContactPreference`) VALUES
('Alana2147483647', 'Alana', 'Mutum', '09/19/1993', 'F', '1140 Esther Street', 'Franklin Square', 'NY', '11010', 2147483647, NULL, 'lanixxjay@live.com', 'manager', NULL, '', '', '0a56fdd1488f6102ecd18dead95ed83c', '', 'email');
('Erick6464924106', 'Erick', 'Tavera', '05/10/1992', 'M', '1232 Mockingbird Lane', 'Queens', 'NY', '11439', 6464924106, NULL, 'erick.tavera10@stjohns.edu', 'Volunteer', 'approved', '', '', '323e5cf127866f33db001369b7a150be', '', 'email');
('Humza6462207988', 'Humza', 'Ahmad', '03/17/1992', 'M', '3000 Union Tpke', 'Queens', 'NY', '11439', 6462207988, NULL, 'humza15@gmail.com', 'Volunteer', 'approved', '', '', '8122dae99d7e5350db689e26377989bd', '', 'email');
('Ivan3897654321', 'Ivan', 'Ortiz', '06/02/1993', 'M', '8000 Utopia Pkwy', 'Queens', 'NY', '11439', 3897654321, NULL, 'ivan11@gmail.com', '', 'applicant', '', '','45ffbe878705cd88de5f943eac87da3b', '', 'email'); 

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Dumping data for table `person`
--



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
