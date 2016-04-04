-- MySQL dump 10.13  Distrib 5.5.47, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: GradStudents
-- ------------------------------------------------------
-- Server version	5.5.47-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `conditions`
--

DROP TABLE IF EXISTS `conditions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conditions` (
  `SID` int(11) NOT NULL DEFAULT '0',
  `CID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`SID`,`CID`),
  KEY `CID` (`CID`),
  CONSTRAINT `conditions_ibfk_1` FOREIGN KEY (`SID`) REFERENCES `students` (`SID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `conditions_ibfk_2` FOREIGN KEY (`CID`) REFERENCES `courses` (`CID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conditions`
--

LOCK TABLES `conditions` WRITE;
/*!40000 ALTER TABLE `conditions` DISABLE KEYS */;
INSERT INTO `conditions` VALUES (1010103,911020),(1010105,911020),(1010109,911020),(1010101,914040),(1010103,914040),(1010108,914040),(1010109,914040);
/*!40000 ALTER TABLE `conditions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `CID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `credits` int(11) DEFAULT NULL,
  `groupID` int(11) DEFAULT NULL,
  PRIMARY KEY (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (911020,'Computing II',3,0),(913080,'Operating Systems I',3,0),(914040,'Analysis of Algorithms',3,0),(915000,'Fundamentals of Computer Science',3,1),(915030,'Algorithms',3,1),(915130,'Internet & Web Systems I',3,4),(915140,'Internet & Web Systems II',3,4),(915150,'Operating Systems I',3,2),(915160,'Operating Systems II',3,2),(915300,'Special Topics',3,3),(915440,'Data Mining',3,3),(915450,'Machine Learning',3,3),(915460,'Computer Graphics I',3,3),(915470,'Computer Graphics II',3,3),(915610,'Computer & Network Security I',3,2),(915630,'Data Communications I',3,2),(915640,'Data Communications II',3,2),(915730,'Data Base I',3,4),(915740,'Data Base II',3,4),(915800,'Topics in Computer Science',3,4),(916730,'Advanced Database Systems',3,4);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrollment`
--

DROP TABLE IF EXISTS `enrollment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enrollment` (
  `SID` int(11) NOT NULL DEFAULT '0',
  `CID` int(11) NOT NULL DEFAULT '0',
  `secID` int(11) NOT NULL DEFAULT '0',
  `yearID` int(11) NOT NULL DEFAULT '0',
  `semesterID` varchar(1) NOT NULL DEFAULT '',
  `grade` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`SID`,`CID`,`secID`,`yearID`,`semesterID`),
  KEY `fkEnrollment` (`CID`,`secID`,`yearID`,`semesterID`),
  CONSTRAINT `enrollment_ibfk_1` FOREIGN KEY (`SID`) REFERENCES `students` (`SID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fkEnrollment` FOREIGN KEY (`CID`, `secID`, `yearID`, `semesterID`) REFERENCES `sections` (`CID`, `secID`, `yearID`, `semesterID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrollment`
--

LOCK TABLES `enrollment` WRITE;
/*!40000 ALTER TABLE `enrollment` DISABLE KEYS */;
INSERT INTO `enrollment` VALUES (1010101,914040,201,2014,'F','A-'),(1010101,915000,201,2014,'F','B+'),(1010101,915030,201,2015,'F','A-'),(1010101,915130,201,2014,'F','B'),(1010101,915140,201,2015,'S','A'),(1010101,915150,201,2015,'F','B+'),(1010101,915300,202,2015,'S','B+'),(1010101,915450,201,2015,'S','A-'),(1010101,915460,201,2015,'F','B+'),(1010101,915470,201,2016,'S','A'),(1010101,915610,201,2016,'S','A-'),(1010102,915000,201,2014,'F','B+'),(1010102,915030,201,2014,'F','B-'),(1010102,915300,202,2015,'S','A-'),(1010102,915460,201,2015,'F','A'),(1010102,915610,201,2015,'S','B-'),(1010102,915630,201,2015,'F','B'),(1010102,915730,201,2015,'F','A-'),(1010102,915740,201,2016,'S','A'),(1010102,915800,201,2015,'S','A-'),(1010102,916730,201,2014,'F','B-'),(1010103,911020,201,2014,'F','A'),(1010103,914040,201,2014,'F','A'),(1010103,915030,201,2015,'S','B'),(1010103,915300,201,2015,'S','C-'),(1010103,915450,201,2015,'F','B+'),(1010103,915460,201,2014,'F','B'),(1010103,915610,201,2015,'S','B+'),(1010103,915630,201,2015,'F','B'),(1010103,915640,201,2016,'S','B'),(1010103,915730,201,2015,'F','B-'),(1010103,915740,201,2016,'S','B'),(1010103,915800,201,2016,'S','B'),(1010104,915030,201,2014,'F','A'),(1010104,915150,201,2015,'F','A-'),(1010104,915160,201,2016,'S','A-'),(1010104,915300,201,2015,'F','A'),(1010104,915450,201,2015,'F','A'),(1010104,915610,201,2015,'S','A'),(1010104,915630,201,2014,'F','A'),(1010104,915640,201,2015,'S','A'),(1010104,915730,201,2014,'F','A'),(1010104,915740,201,2015,'S','A'),(1010105,915000,201,2014,'F','B+'),(1010105,915030,201,2015,'S','A-'),(1010105,915130,201,2014,'F','A-'),(1010105,915140,201,2015,'S','A-'),(1010105,915150,201,2014,'F','B+'),(1010105,915160,201,2015,'S','A-'),(1010105,915460,201,2015,'F','A-'),(1010105,915610,201,2016,'S','A-'),(1010105,915730,201,2015,'F','A-'),(1010105,915800,201,2015,'F','B'),(1010106,915000,201,2015,'F','A'),(1010106,915030,201,2014,'F','A'),(1010106,915150,201,2014,'F','A'),(1010106,915160,201,2015,'S','A-'),(1010106,915450,201,2015,'F','A'),(1010106,915460,201,2015,'F','B+'),(1010106,915470,201,2016,'S','B+'),(1010106,915610,201,2015,'S','A-'),(1010106,915630,201,2014,'F','A'),(1010106,915640,201,2015,'S','A-'),(1010107,915000,201,2014,'F','B+'),(1010107,915030,201,2014,'F','A'),(1010107,915150,201,2014,'F','A'),(1010107,915160,201,2015,'S','A-'),(1010107,915300,202,2015,'S','A-'),(1010107,915440,201,2015,'F','B'),(1010107,915460,201,2015,'F','A-'),(1010107,915610,201,2015,'S','B+'),(1010107,915730,201,2015,'F','A-'),(1010107,915740,201,2016,'S','A-'),(1010108,914040,201,2014,'F','A'),(1010108,915000,201,2014,'F','B+'),(1010108,915300,202,2015,'S','A-'),(1010108,915460,201,2015,'F','A'),(1010108,915470,201,2016,'S','A-'),(1010108,915610,201,2015,'S','A-'),(1010108,915630,201,2015,'F','A-'),(1010108,915640,201,2016,'S','A'),(1010108,915730,201,2015,'F','B-'),(1010108,915740,201,2016,'S','B+'),(1010109,914040,201,2014,'F','A'),(1010109,915030,201,2015,'S','B'),(1010109,915150,201,2015,'F','B+'),(1010109,915300,201,2015,'S','C-'),(1010109,915460,201,2014,'F','B'),(1010109,915610,201,2015,'S','B+'),(1010109,915630,201,2015,'F','A'),(1010109,915640,201,2016,'S','B'),(1010109,915730,201,2015,'F','A-'),(1010109,915740,201,2016,'S','A'),(1010109,915800,201,2014,'F','A'),(1010110,915000,201,2014,'F','A'),(1010110,915030,201,2014,'F','A-'),(1010110,915130,201,2014,'F','A'),(1010110,915140,201,2015,'S','A'),(1010110,915150,201,2015,'F','A-'),(1010110,915300,201,2015,'S','A'),(1010110,915440,201,2015,'F','A'),(1010110,915460,201,2015,'F','A'),(1010110,915470,201,2016,'S','B'),(1010110,915610,201,2015,'S','A');
/*!40000 ALTER TABLE `enrollment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instructors`
--

DROP TABLE IF EXISTS `instructors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instructors` (
  `IID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `rank` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructors`
--

LOCK TABLES `instructors` WRITE;
/*!40000 ALTER TABLE `instructors` DISABLE KEYS */;
INSERT INTO `instructors` VALUES (1,'Tingjian Ge','Associate Professor'),(2,'Haim Levkowitz','Associate Professor'),(3,'William Moloney Jr','Associate Professor'),(4,'Anna Rumshisky','Assistant Professor'),(5,'Xinwen Fu','Associate Professor'),(6,'Ekaterina Saenko','Assistant Professor'),(7,'Jie Wang','Professor'),(8,'Benyuan Liu','Associate Professor'),(9,'Cindy Chen','Associate Professor'),(10,'Guanling Chen','Associate Professor'),(11,'Byung Kim','Associate Professor'),(12,'David Adams','Lecturer');
/*!40000 ALTER TABLE `instructors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `CID` int(11) NOT NULL,
  `PID` int(11) DEFAULT NULL,
  PRIMARY KEY (`CID`),
  CONSTRAINT `fk_CID` FOREIGN KEY (`CID`) REFERENCES `courses` (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (915030,108390);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prerequisites`
--

DROP TABLE IF EXISTS `prerequisites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prerequisites` (
  `PCID` int(11) NOT NULL DEFAULT '0',
  `CID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`PCID`,`CID`),
  KEY `CID` (`CID`),
  CONSTRAINT `prerequisites_ibfk_1` FOREIGN KEY (`PCID`) REFERENCES `courses` (`CID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prerequisites_ibfk_2` FOREIGN KEY (`CID`) REFERENCES `courses` (`CID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prerequisites`
--

LOCK TABLES `prerequisites` WRITE;
/*!40000 ALTER TABLE `prerequisites` DISABLE KEYS */;
/*!40000 ALTER TABLE `prerequisites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sections` (
  `CID` int(11) NOT NULL DEFAULT '0',
  `secID` int(11) NOT NULL DEFAULT '0',
  `IID` int(11) DEFAULT NULL,
  `yearID` int(11) NOT NULL DEFAULT '0',
  `semesterID` varchar(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`CID`,`secID`,`yearID`,`semesterID`),
  KEY `IID` (`IID`),
  CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`IID`) REFERENCES `instructors` (`IID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sections`
--

LOCK TABLES `sections` WRITE;
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `SID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `IID` int(11) DEFAULT NULL,
  `major` varchar(255) DEFAULT NULL,
  `degreeHeld` varchar(255) DEFAULT NULL,
  `career` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`SID`),
  KEY `IID` (`IID`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`IID`) REFERENCES `instructors` (`IID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1010101,'James',1,'cs','bachelor','graduate'),(1010102,'John',2,'cs','bachelor','graduate'),(1010103,'Robert',3,'cs','bachelor','graduate'),(1010104,'Michael',4,'cs','bachelor','graduate'),(1010105,'william',5,'cs','bachelor','graduate'),(1010106,'Mary',6,'cs','bachelor','graduate'),(1010107,'Linda',7,'cs','bachelor','graduate'),(1010108,'Jennifer',8,'cs','bachelor','graduate'),(1010109,'Susan',9,'cs','bachelor','graduate'),(1010110,'Lisa',9,'cs','bachelor','graduate');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-04 17:35:01
