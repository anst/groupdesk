CREATE DATABASE  IF NOT EXISTS `schollab` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `schollab`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: localhost    Database: schollab
-- ------------------------------------------------------
-- Server version	5.6.14

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
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(50) NOT NULL DEFAULT 'Default',
  `Content` longtext NOT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcements_groups`
--

DROP TABLE IF EXISTS `announcements_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements_groups` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `AnnouncementID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements_groups`
--

LOCK TABLES `announcements_groups` WRITE;
/*!40000 ALTER TABLE `announcements_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `announcements_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcements_rooms`
--

DROP TABLE IF EXISTS `announcements_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements_rooms` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `AnnouncementID` int(11) NOT NULL,
  `RoomID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements_rooms`
--

LOCK TABLES `announcements_rooms` WRITE;
/*!40000 ALTER TABLE `announcements_rooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `announcements_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assignments` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `CreationDate` datetime NOT NULL,
  `DueDate` datetime DEFAULT NULL,
  `Description` longtext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignments`
--

LOCK TABLES `assignments` WRITE;
/*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
INSERT INTO `assignments` VALUES (1,'Bobby',1,'2014-06-13 19:54:07','2014-06-13 19:54:07','Hello!'),(2,'Bobby',4,'2014-06-13 19:54:21','2014-06-13 19:54:21','Hello!'),(3,'Billy',21,'0000-00-00 00:00:00','0000-00-00 00:00:00','K.');
/*!40000 ALTER TABLE `assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignments_students`
--

DROP TABLE IF EXISTS `assignments_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assignments_students` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `StudentID` int(11) NOT NULL DEFAULT '-1',
  `AssignmentID` int(11) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignments_students`
--

LOCK TABLES `assignments_students` WRITE;
/*!40000 ALTER TABLE `assignments_students` DISABLE KEYS */;
INSERT INTO `assignments_students` VALUES (1,2,1),(2,2,4),(3,2,6);
/*!40000 ALTER TABLE `assignments_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `Location` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `TeacherID` varchar(45) NOT NULL,
  `Title` varchar(45) NOT NULL,
  `Description` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (2,'4','Some Project','Goodbye'),(3,'4','Other Project','Nope'),(4,'4','New Project','Goodbye'),(5,'4','Old Project','Goodbye'),(7,'4','AP US History','Goodbye'),(8,'21','This is a Project','Yep');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups_users`
--

DROP TABLE IF EXISTS `groups_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups_users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `GroupID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Approved` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups_users`
--

LOCK TABLES `groups_users` WRITE;
/*!40000 ALTER TABLE `groups_users` DISABLE KEYS */;
INSERT INTO `groups_users` VALUES (8,3,2,0),(10,3,4,0),(11,5,2,0),(12,7,2,0);
/*!40000 ALTER TABLE `groups_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL DEFAULT '[Not Named]',
  `AssignmentID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'Hello',0),(2,'Bobby',1),(4,'Bobby',1);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms_students`
--

DROP TABLE IF EXISTS `rooms_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms_students` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `RoomID` int(11) NOT NULL DEFAULT '-1',
  `UserID` int(11) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms_students`
--

LOCK TABLES `rooms_students` WRITE;
/*!40000 ALTER TABLE `rooms_students` DISABLE KEYS */;
INSERT INTO `rooms_students` VALUES (1,2,20),(2,2,12);
/*!40000 ALTER TABLE `rooms_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students_teachers`
--

DROP TABLE IF EXISTS `students_teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students_teachers` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TeacherID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students_teachers`
--

LOCK TABLES `students_teachers` WRITE;
/*!40000 ALTER TABLE `students_teachers` DISABLE KEYS */;
/*!40000 ALTER TABLE `students_teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Password` varchar(45) NOT NULL,
  `Type` int(11) NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL,
  `Email` varchar(60) DEFAULT NULL,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `School` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'smith',0,'2014-06-14 02:42:52','bobby@smith.com','','',NULL),(2,'hello',0,'2014-06-14 02:43:09','bill@smith.com','Bill','Smith','Smith Academy'),(3,'smith',0,'2014-06-14 02:43:09','bobby@smith.com','','',NULL),(4,'smith',1,'2014-06-14 02:43:10','bobby@smith.com','','',NULL),(5,'smith',0,'2014-06-14 02:43:10','bobby@smith.com','','',NULL),(6,'smith',0,'2014-06-14 02:43:10','bobby@smith.com','','',NULL),(7,'smith',0,'2014-06-14 02:43:10','bobby@smith.com','','',NULL),(8,'smith',0,'2014-06-14 02:43:10','bobby@smith.com','','',NULL),(9,'smith',0,'2014-06-14 02:43:11','bobby@smith.com','','',NULL),(10,'smith',0,'2014-06-14 02:43:11','bobby@smith.com','','',NULL),(11,'smith',0,'2014-06-14 02:43:11','bobby@smith.com','','',NULL),(12,'smith',0,'2014-06-14 02:43:13','bobby@smith.com','','',NULL),(13,'smith',0,'2014-06-14 02:43:13','bobby@smith.com','','',NULL),(14,'smith',0,'2014-06-14 02:43:13','bobby@smith.com','','',NULL),(15,'smith',0,'2014-06-14 02:43:14','bobby@smith.com','','',NULL),(16,'smith',0,'2014-06-14 02:43:14','bobby@smith.com','','',NULL),(17,'smith',0,'2014-06-14 02:43:14','bobby@smith.com','','',NULL),(18,'smith',0,'2014-06-14 02:43:14','bobby@smith.com','','',NULL),(19,'smith',0,'2014-06-14 02:43:14','bobby@smith.com','','',NULL),(20,'smith',0,'2014-06-14 02:43:14','bobby@smith.com','','',NULL),(21,'hello',1,'2014-06-14 05:09:10','blacksmithgu@gmail.com','','',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'schollab'
--

--
-- Dumping routines for database 'schollab'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-06-14  4:41:53
