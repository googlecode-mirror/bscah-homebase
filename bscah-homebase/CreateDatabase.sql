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

CREATE TABLE IF NOT EXISTS `DATE` (
  `DATE_ID` varchar(8) NOT NULL,
  `SHIFTS` text,
  `MGR_NOTES` text,
  `PROJECTS` text NOT NULL,
  PRIMARY KEY (`DATE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `DATE` (`DATE_ID`, `SHIFTS`, `MGR_NOTES`, `PROJECTS`) VALUES
('02-24-14', '02-24-14-9-12*02-24-14-12-15*02-24-14-18-21*02-24-14-overnight', '', null),
('02-25-14', '02-25-14-9-12*02-25-14-12-15*02-25-14-15-18*02-25-14-18-21*02-25-14-overnight', '', null),
('02-26-14', '02-26-14-9-12*02-26-14-15-18*02-26-14-18-21*02-26-14-overnight', '', null),
('02-27-14', '02-27-14-9-12*02-27-14-12-15*02-27-14-15-18*02-27-14-18-21*02-27-14-overnight', '', null),
('02-28-14', '02-28-14-9-12*02-28-14-12-15*02-28-14-15-18*02-28-14-overnight*02-28-14-18-21', '', null),
('03-01-14', '03-01-14-10-13*03-01-14-13-16*03-01-14-overnight*03-01-14-16-18*03-01-14-9-10*03-01-14-18-21', '', null),
('03-02-14', '03-02-14-9-12*03-02-14-14-17*03-02-14-17-21*03-02-14-overnight*03-02-14-12-14', '', null),
('03-03-14', '03-03-14-9-12*03-03-14-12-15*03-03-14-15-18*03-03-14-18-21*03-03-14-overnight', '', null),
('03-04-14', '03-04-14-9-12*03-04-14-18-21*03-04-14-overnight*03-04-14-15-18', '', null),
('03-05-14', '03-05-14-9-12*03-05-14-12-15*03-05-14-15-18*03-05-14-18-21*03-05-14-overnight', '', null),
('03-06-14', '03-06-14-9-12*03-06-14-12-15*03-06-14-15-18*03-06-14-18-21*03-06-14-overnight', '', null),
('03-07-14', '03-07-14-9-12*03-07-14-12-15*03-07-14-15-18*03-07-14-overnight*03-07-14-18-21', '', null),
('03-08-14', '03-08-14-10-13*03-08-14-13-16*03-08-14-overnight*03-08-14-9-10*03-08-14-16-21', '', null),
('03-09-14', '03-09-14-9-12*03-09-14-14-17*03-09-14-12-14*03-09-14-overnight*03-09-14-17-21', '', null),
('03-10-14', '03-10-14-9-12*03-10-14-12-15*03-10-14-18-21*03-10-14-overnight', '', null),
('03-11-14', '03-11-14-9-12*03-11-14-12-15*03-11-14-15-18*03-11-14-18-21*03-11-14-overnight', '', null),
('03-12-14', '03-12-14-9-12*03-12-14-15-18*03-12-14-18-21*03-12-14-overnight', '', null),
('03-13-14', '03-13-14-9-12*03-13-14-12-15*03-13-14-15-18*03-13-14-18-21*03-13-14-overnight', '', null),
('03-14-14', '03-14-14-9-12*03-14-14-12-15*03-14-14-15-18*03-14-14-overnight*03-14-14-18-21', '', null),
('03-15-14', '03-15-14-10-13*03-15-14-13-16*03-15-14-overnight*03-15-14-18-21*03-15-14-9-10*03-15-14-16-18', '', null),
('03-16-14', '03-16-14-9-12*03-16-14-14-17*03-16-14-17-21*03-16-14-12-14*03-16-14-overnight', '', null),
('03-17-14', '03-17-14-9-12*03-17-14-12-15*03-17-14-15-18*03-17-14-18-21*03-17-14-overnight', '', null),
('03-18-14', '03-18-14-9-12*03-18-14-18-21*03-18-14-overnight*03-18-14-15-18', '', null),
('03-19-14', '03-19-14-9-12*03-19-14-12-15*03-19-14-15-18*03-19-14-18-21*03-19-14-overnight', '', null),
('03-20-14', '03-20-14-9-12*03-20-14-12-15*03-20-14-15-18*03-20-14-18-21*03-20-14-overnight', '', null),
('03-21-14', '03-21-14-9-12*03-21-14-12-15*03-21-14-15-18*03-21-14-overnight*03-21-14-18-21', '', null),
('03-22-14', '03-22-14-10-13*03-22-14-13-16*03-22-14-overnight*03-22-14-9-10*03-22-14-16-21', '', null),
('03-23-14', '03-23-14-9-12*03-23-14-14-17*03-23-14-17-21*03-23-14-overnight*03-23-14-12-14', '', null),
('03-24-14', '03-24-14-9-12*03-24-14-12-15*03-24-14-18-21*03-24-14-overnight', '', null),
('03-25-14', '03-25-14-9-12*03-25-14-12-15*03-25-14-15-18*03-25-14-18-21*03-25-14-overnight', '', null),
('03-26-14', '03-26-14-9-12*03-26-14-15-18*03-26-14-18-21*03-26-14-overnight', '', null),
('03-27-14', '03-27-14-9-12*03-27-14-12-15*03-27-14-15-18*03-27-14-18-21*03-27-14-overnight', '', null),
('03-28-14', '03-28-14-9-12*03-28-14-12-15*03-28-14-15-18*03-28-14-overnight*03-28-14-18-21', '', null),
('03-29-14', '03-29-14-10-13*03-29-14-13-16*03-29-14-overnight*03-29-14-9-10*03-29-14-16-18*03-29-14-18-21', '', null),
('03-30-14', '03-30-14-9-12*03-30-14-14-17*03-30-14-17-21*03-30-14-12-14*03-30-14-overnight', '', null),
('03-31-14', '03-31-14-9-12*03-31-14-12-15*03-31-14-15-18*03-31-14-18-21*03-31-14-overnight', '', null),
('04-01-14', '04-01-14-9-12*04-01-14-18-21*04-01-14-overnight*04-01-14-15-18', '', null),
('04-02-14', '04-02-14-9-12*04-02-14-12-15*04-02-14-15-18*04-02-14-18-21*04-02-14-overnight', '', null),
('04-03-14', '04-03-14-9-12*04-03-14-12-15*04-03-14-15-18*04-03-14-18-21*04-03-14-overnight', '', null),
('04-04-14', '04-04-14-9-12*04-04-14-12-15*04-04-14-15-18*04-04-14-overnight*04-04-14-18-21', '', null),
('04-05-14', '04-05-14-10-13*04-05-14-13-16*04-05-14-overnight*04-05-14-16-18*04-05-14-9-10*04-05-14-18-21', '', null),
('04-06-14', '04-06-14-9-12*04-06-14-14-17*04-06-14-17-21*04-06-14-overnight*04-06-14-12-14', '', null),
('04-07-14', '04-07-14-9-12*04-07-14-12-15*04-07-14-18-21*04-07-14-overnight', '', null),
('04-08-14', '04-08-14-9-12*04-08-14-12-15*04-08-14-15-18*04-08-14-18-21*04-08-14-overnight', '', null),
('04-09-14', '04-09-14-9-12*04-09-14-15-18*04-09-14-18-21*04-09-14-overnight', '', null),
('04-10-14', '04-10-14-9-12*04-10-14-12-15*04-10-14-15-18*04-10-14-18-21*04-10-14-overnight', '', null),
('04-11-14', '04-11-14-9-12*04-11-14-12-15*04-11-14-15-18*04-11-14-overnight*04-11-14-18-21', '', null),
('04-12-14', '04-12-14-10-13*04-12-14-13-16*04-12-14-overnight*04-12-14-9-10*04-12-14-16-21', '', null),
('04-13-14', '04-13-14-9-12*04-13-14-14-17*04-13-14-12-14*04-13-14-overnight*04-13-14-17-21', '', null),
('07-15-13', '07-15-13-9-12*07-15-13-12-15*07-15-13-18-21*07-15-13-overnight*07-15-13-15-18', '', null),
('07-16-13', '07-16-13-9-12*07-16-13-12-15*07-16-13-15-18*07-16-13-18-21*07-16-13-overnight', '', null),
('07-17-13', '07-17-13-9-12*07-17-13-12-15*07-17-13-15-18*07-17-13-18-21*07-17-13-overnight', '', null),
('07-18-13', '07-18-13-9-12*07-18-13-12-15*07-18-13-15-18*07-18-13-18-21*07-18-13-overnight', '', null),
('07-19-13', '07-19-13-9-12*07-19-13-12-15*07-19-13-15-18*07-19-13-overnight*07-19-13-18-21', '', null),
('07-20-13', '07-20-13-10-13*07-20-13-13-16*07-20-13-overnight*07-20-13-16-18*07-20-13-9-10*07-20-13-18-21', '', null),
('07-21-13', '07-21-13-9-12*07-21-13-14-17*07-21-13-17-21*07-21-13-overnight*07-21-13-12-14', '', null);
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

CREATE TABLE IF NOT EXISTS `MASTERSCHEDULE` (
  `MS_ID` varchar(25) NOT NULL DEFAULT '',
  `SCHEDULE_TYPE` text NOT NULL,
  `DAY` text NOT NULL,
  `START_TIME` text NOT NULL,
  `END_TIME` text,
  `SLOTS` int(11) DEFAULT NULL,
  `NOTES` text,
  `SHIFTS` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `PERSON` (
  `ID` varchar(25) NOT NULL,
  `NAMEFIRST` varchar(20) NOT NULL,
  `NAMELAST` varchar(25) NOT NULL,
  `BIRTHDAY` varchar(11) NOT NULL, 
  `GENDER` varchar(1) NOT NULL,
  `ADDRESS` varchar(40) NOT NULL,
  `CITY` varchar(25) NOT NULL,
  `STATE` varchar(2) NOT NULL,
  `ZIP` varchar(5) NOT NULL,
  `PHONE1` varchar(12) NOT NULL,
  `PHONE2` varchar(12) DEFAULT NULL,
  `EMAIL` varchar(30) NOT NULL,
  `TYPE` varchar(15) NOT NULL COMMENT 'Denotes wether a manager, volunteer or guest',
  `STATUS` varchar(15) COMMENT 'values could be applicant or approved for volunteer, null for  manager',
  `SCHEDULE` varchar(100) NOT NULL COMMENT 'Dates scheduled for voliunteering',
  `NOTES` varchar(200) NOT NULL,
  `PASSWORD`  text NOT NULL,
  `AVAILABILITY` varchar(580) NOT NULL COMMENT 'days and times free for volunteering',
   `CONTACTPREFERENCE` varchar(15) NOT NULL COMMENT 'either email, mail or phone number',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--

INSERT INTO `PERSON` (`ID`, `NAMEFIRST`, `NAMELAST`, `BIRTHDAY`, `GENDER`, `ADDRESS`, `CITY`, `STATE`, `ZIP`, `PHONE1`, `PHONE2`, `EMAIL`, `TYPE`, `STATUS`, `SCHEDULE`, `NOTES`, `PASSWORD`, `AVAILABILITY`, `CONTACTPREFERENCE`) VALUES
('Alana2147483647', 'Alana', 'Mutum', '09/19/93', 'F', '1140 Esther Street', 'Franklin Square', 'NY', '11010', '2147483647', NULL, 'lanixxjay@live.com', 'manager', NULL, '', '', '0a56fdd1488f6102ecd18dead95ed83c', '', 'email'),
('Erick6464924106', 'Erick', 'Tavera', '05/10/92', 'M', '1232 Mockingbird Lane', 'Queens', 'NY', '11439', '6464924106', NULL, 'erick.tavera10@stjohns.edu', 'Volunteer', 'approved', '', '', '323e5cf127866f33db001369b7a150be', '', 'email'),
('Humza6462207988', 'Humza', 'Ahmad', '03/17/92', 'M', '3000 Union Tpke', 'Queens', 'NY', '11439', '6462207988', NULL, 'humza15@gmail.com', 'Volunteer', 'approved', '', '', '8122dae99d7e5350db689e26377989bd', '', 'email'),
('Ivan3897654321', 'Ivan', 'Ortiz', '06/02/93', 'M', '8000 Utopia Pkwy', 'Queens', 'NY', '11439', '3897654321', NULL, 'ivan11@gmail.com', 'guest', 'applicant', '', '','45ffbe878705cd88de5f943eac87da3b', '', 'email'), 
('Mark7186938903', 'Mark','Tavera', '08/24/94', 'M', '123 Main Street','Brooklyn', 'NY', '11230','7186938903', NULL, 'sampleemail@yahoo.com', 'Volunteer', 'approved',	'', '',	'74be16979710d4c4e7c6647856088456', '', 'email'),
('Erick9149876342', 'Erick', 'Jones', '09/12/92', 'M', '123 Main Street', 'Brooklyn', 'NY', '11230', '9149876342', NULL, 'sampleemail2@yahoo.com', 'Volunteer',	'approved', '',	'', '74be16979710d4c4e7c6647856088456',	'', 'email'),
('Jefferson3475899639',	'Jefferson', 'Steelflex', '12-16-76', 'M', '1337 PWND rd.', 'Kingston',	'NY', '11478', '3475899639', NULL, 'bigbang@gmail.com', 'Volunteer', 'approved', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', 'email'),
('Gregory7188057221', 'Gregory', 'Wilson', '04-18-80', 'M', 'Main Street', 'Manhattan', 'NY', '11325', '7188057221', NULL, 'sectoidblaster@gmail.com', 'Volunteer', 'approved', '', '', '74be16979710d4c4e7c6647856088456', '', 'phone'); 


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Dumping data for table `person`
--



-- --------------------------------------------------------


--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `PROJECT` (
  `PROJECTID` varchar(58) NOT NULL,
  `ADDRESS` varchar(50),
  `DATE` varchar(10) NOT NULL,
  `TYPE` varchar(30) NOT NULL,
  `VACANCIES` int(3) NOT NULL,
  `STARTTIME` int(4) NOT NULL,  
  `ENDTIME` int(4) NOT NULL,
 `DAYOFWEEK` varchar(3) NOT NULL,
  `NAME` varchar(50) NOT NULL,
  `PERSONS`  text,
  `AGEREQUIREMENT`  int(3) DEFAULT NULL,
  `PROJECTDESCRIPTION` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`PROJECTID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Collection of Projects';

--
-- Dumping data for table `project`
--

INSERT INTO `PROJECT` (`PROJECTID`, `ADDRESS`, `DATE`,`TYPE`, `VACANCIES`, `STARTTIME`, `ENDTIME`, `DAYOFWEEK`, `NAME`, `PERSONS`,`AGEREQUIREMENT` ,`PROJECTDESCRIPTION`) VALUES
('02-24-14-900-1200-Food', '4119 Nuzum Court Williamsville', '02-24-14', null, '3', '900', '1200', 'Mon', 'Food', 'Erick6464924106+Erick+Tavera+*Humza6462207988+Humza+Ahmad+','50', ''),
('02-25-14-1200-1500-Food', '521 White Pine Lane Fredericksburg', '02-25-14',null, '2', '1200', '1500', 'Tue', 'Food', 'Gregory7188057221+Gregory+Wilson+' , '5', ''),
('02-26-14-1800-2300-Food Delivery', '4964 Sardis Sta Grand Prairie', '02-26-14',null, '4', '1800', '2300', 'Wed', 'Food Delivery', 'Jefferson3475899639+Jefferson+Steelflex+*Erick6464924106+Erick+Tavera+',null,  ''),
('02-27-14-100-400-Food Delivery', '2009 Wetzel Lane Grand Rapids', '02-27-14',null, '3', '100', '400', 'Thu', 'Food Delivery', 'Gregory7188057221+Gregory+Wilson+',null, ''),
('02-24-14-900-1200-Truck Delivery', '4119 Nuzum Court Williamsville', '02-24-14',null, '3', '900', '1200', 'Mon', 'Truck Delivery', 'Erick6464924106+Erick+Tavera+*Humza6462207988+Humza+Ahmad+',null,  ''),
('02-25-14-1200-1500-Truck Delivery', '521 White Pine Lane Fredericksburg', '02-25-14',null, '2', '1200', '1500', 'Tue', 'Truck Delivery', 'Gregory7188057221+Gregory+Wilson+', null, ''),
('02-26-14-1800-2300-Truck Delivery', '4964 Sardis Sta Grand Prairie', '02-26-14',null, '4', '1800', '2300', 'Wed', 'Truck Delivery', 'Jefferson3475899639+Jefferson+Steelflex+*Erick6464924106+Erick+Tavera', null, ''),
('02-27-14-100-400-Truck Delivery', '2009 Wetzel Lane Grand Rapids', '02-27-14', null,'3', '100', '400', 'Thu', 'Truck Delivery', 'Gregory7188057221+Gregory+Wilson+', null,''),
('02-24-14-900-1200-Snack Delivery', '4119 Nuzum Court Williamsville', '02-24-14',null, '3', '900', '1200', 'Mon', 'Snack Delivery', 'Erick6464924106+Erick+Tavera+*Humza6462207988+Humza+Ahmad+',null,  ''),
('02-25-14-1200-1500-Snack Delivery', '521 White Pine Lane Fredericksburg', '02-25-14',null, '2', '1200', '1500', 'Tue', 'Snack Delivery', 'Gregory7188057221+Gregory+Wilson+',null,  ''),
('02-26-14-1800-2300-Snack Delivery', '4964 Sardis Sta Grand Prairie', '02-26-14',null, '4', '1800', '2300', 'Wed', 'Snack Delivery', 'Jefferson3475899639+Jefferson+Steelflex+*Erick6464924106+Erick+Tavera+',null,  ''),
('02-27-14-100-400-Snack Delivery', '2009 Wetzel Lane Grand Rapids', '02-27-14', null,'3', '100', '400', 'Thu', 'Snack Delivery', 'Gregory7188057221+Gregory+Wilson+',null,  '');



-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE IF NOT EXISTS `SHIFT` (
  `ID` varchar(20) NOT NULL DEFAULT '', 
  `START_TIME` int(11) DEFAULT NULL,
  `END_TIME` int(11) DEFAULT NULL,
  `VENUE` text,
  `VACANCIES` int(11) DEFAULT NULL,
  `PERSONS` text,
  `REMOVED_PERSONS` text,
  `NOTES` text,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shift`
--

INSERT INTO `SHIFT` (`ID`, `START_TIME`, `END_TIME`, `VENUE`, `VACANCIES`, `PERSONS`, `REMOVED_PERSONS`, `NOTES`) VALUES
('05-21-14-12-15', 12, 15, 'HEALTH 360', 5, 'Jefferson3475899639+Jefferson+Steelflex+*Erick6464924106+Erick+Tavera+', NULL, NULL),
('05-22-14-12-15', 12, 15, 'Mobile Pantry', 6, 'Erick6464924106+Erick+Tavera+*Ivan3897654321+Ivan+Ortiz+', NULL, NULL),
('05-22-14-15-18', 15, 18, 'Mobile Pantry', 6, NULL, NULL, NULL),
('05-23-14-9-18', 9, 18, 'REACH', 8, NULL, NULL, NULL),
('10-30-14-10-11', 10, 11, 'Test Venue', '10', 'Erick9149876342+Erick+Jones*Erick6464924106+Erick+Tavera', NULL, NULL),
('10-31-14-13-14', 13, 14, 'Test Venue 2', '10', 'Erick9149876342+Erick+Jones*Erick6464924106+Erick+Tavera', NULL, NULL),
('07-12-14-12-18', 12, 18, 'Andersons Orphanage', 4, 'Humza6462207988+Humza+Ahmad+', NULL, NULL),
('09-07-14-9-12', 9, 12, 'Freeside', 3, 'Gregory7188057221+Gregory+Wilson+*Jefferson3475899639+Jefferson+Steelflex+', NULL, NULL);


-- --------------------------------------------------------

--
-- Table structure for table `weeks`
--

CREATE TABLE IF NOT EXISTS `WEEKS` (
  `ID` varchar(8) NOT NULL,
  `DATES` text,
  `STATUS` text,
  `END` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- -- ----------------------------------------------------------
-- 
-- -- 
-- -- Table structure for table `dblog`
-- --
-- 
CREATE TABLE IF NOT EXISTS  `DBLOG`(
    `ID` INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `TIME` text,
   `MESSAGE` text) ENGINE=InnoDB DEFAULT CHARSET=latin1;