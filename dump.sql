-- MySQL dump 10.13  Distrib 5.7.24, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: bassin_vert
-- ------------------------------------------------------
-- Server version	5.7.24

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
-- Table structure for table `appointment`
--

DROP TABLE IF EXISTS `appointment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `service_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `garden_size` double NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scheduled_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FE38F844A76ED395` (`user_id`),
  CONSTRAINT `FK_FE38F844A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment`
--

LOCK TABLES `appointment` WRITE;
/*!40000 ALTER TABLE `appointment` DISABLE KEYS */;
INSERT INTO `appointment` VALUES (1,4,'Mowing',56,'BERNEUIL EN BRAY','2026-02-13 13:30:00','CONFIRMED',NULL),(4,4,'Mowing',95,'BERNEUIL EN BRAY','2026-02-13 16:30:00','CONFIRMED',NULL),(5,6,'Mowing',0.65,'Berneuil-En-Bray','2026-02-13 14:30:00','CONFIRMED',NULL),(6,6,'Mowing',23,'BERNEUIL EN BRAY','2026-02-18 14:00:00','CONFIRMED','V-69923f6179073.jpg');
/*!40000 ALTER TABLE `appointment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20240101000000',NULL,NULL),('DoctrineMigrations\\Version20240101000001',NULL,NULL),('DoctrineMigrations\\Version20240210000000','2026-02-10 13:43:19',136),('DoctrineMigrations\\Version20260211100000','2026-02-11 08:55:12',58),('DoctrineMigrations\\Version20260215231752','2026-02-15 23:18:25',93),('DoctrineMigrations\\Version20260215232230','2026-02-15 23:22:49',22);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quote_request`
--

DROP TABLE IF EXISTS `quote_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quote_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `service_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `garden_size` double NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scheduled_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D478271BA76ED395` (`user_id`),
  CONSTRAINT `FK_D478271BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quote_request`
--

LOCK TABLES `quote_request` WRITE;
/*!40000 ALTER TABLE `quote_request` DISABLE KEYS */;
INSERT INTO `quote_request` VALUES (1,NULL,'Mowing',1300,'BERNEUIL EN BRAY',NULL,'ACCEPTED','2026-02-13 12:00:00','2026-02-11 15:39:01','dbatistamachado1996@gmail.com','DIOGO'),(2,6,'Mowing',0.65,'Berneuil-En-Bray',NULL,'ACCEPTED','2026-02-13 14:30:00','2026-02-13 08:59:50','dbatistamachado1996@gmail.com','DIOGO MACHADO'),(3,4,'Mowing',95,'BERNEUIL EN BRAY',NULL,'ACCEPTED','2026-02-13 16:30:00','2026-02-13 09:47:15','admin2@bassinvert.com','DIOGO'),(4,4,'Mowing',56,'BERNEUIL EN BRAY',NULL,'ACCEPTED','2026-02-13 13:30:00','2026-02-13 09:56:11','admin2@bassinvert.com','-\'jutk;'),(5,6,'Mowing',23,'BERNEUIL EN BRAY','V-69923f6179073.jpg','ACCEPTED','2026-02-18 14:00:00','2026-02-15 21:49:21','dbatistamachado1996@gmail.com','DIOGO');
/*!40000 ALTER TABLE `quote_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day_of_week` int(11) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule`
--

LOCK TABLES `schedule` WRITE;
/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;
INSERT INTO `schedule` VALUES (1,1,'09:00:00','18:00:00',1),(2,2,'09:00:00','18:00:00',1),(3,3,'09:00:00','18:00:00',1),(4,4,'09:00:00','18:00:00',1),(5,5,'09:00:00','18:00:00',1),(6,6,'11:00:00','14:00:00',1),(7,7,NULL,NULL,0);
/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unavailability`
--

DROP TABLE IF EXISTS `unavailability`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unavailability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `end_time` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unavailability`
--

LOCK TABLES `unavailability` WRITE;
/*!40000 ALTER TABLE `unavailability` DISABLE KEYS */;
INSERT INTO `unavailability` VALUES (1,'2026-02-12 09:00:00','2026-02-12 17:00:00','Admin blocked');
/*!40000 ALTER TABLE `unavailability` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'test@example.com','[\"ROLE_USER\"]','$2y$13$PxOV9.qM.1.1.1.1.1.1.1'),(4,'admin2@bassinvert.com','[\"ROLE_ADMIN\", \"ROLE_USER\"]','$2y$13$THvLvQWJdUAcU0B8E7/Pe.ljQnobKsfQQO0WNV.2CHBx3/cVGiXIK'),(6,'dbatistamachado1996@gmail.com','[\"ROLE_USER\"]','$2y$13$N0oSUjZbQGhpsSYfGf1xv.g7kjsxdCRxHVypqTYhSeFp7.BhDO/wa');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-19 11:55:08
