-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: nexeltoolsdb
-- ------------------------------------------------------
-- Server version	8.2.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (11,'admin','m21XUXjrtYcv8lLP3_Cb5QaNZNFOk7Fu','$2y$13$COgCPhgyspIisaqcMW3TLubaCFPom1HqnCwfJEnLXf3x4h/DQvk5e',NULL,'admin@gmail.com',10,1731695222,1731695222,NULL),(37,'admin2','CYuHRoMUKBsvRgU865vGdJYTZPuhRsPs','$2y$13$YluhXTtmvjiehMWMafblau1Cs///scCszwa4ky/LOv1MWwpppt7wW',NULL,'admin2@gmail.com',10,1732099387,1732099387,NULL),(39,'Teste','qgKFIlLy_4O0fWiZV7u7F8xCLCwmX4CG','$2y$13$xrfDLuyTshwbt4fqY6WI1OSPQ1WXR/4ZkusyUa1x2RiAdBHfAG1eG',NULL,'teste@gmail.com',10,1732544051,1732718948,NULL),(43,'God','CIwMxdJLVyWEhRbsnU-AauDTUQxb5kY0','$2y$13$O.FEwB0AErNjFIaHW7LwAOrnsBwrYNeke3klsDajMe6pi7DeC1u4a',NULL,'diogosimoes225@gmail.com',10,1733588387,1733588387,NULL),(45,'Brunoaltetos','PpZ6Xd5Y10b1z6iFewF15V5SAXx2To8Q','$2y$13$/DC9WG4ErIgY7InXDYy8WO8bB.bliS0sa0hp/7zUu6Y.IloZeCIMm',NULL,'brunoaltetos@gmail.com',10,1733934448,1733934448,NULL),(48,'EduFm','jtJsprp7wRBwQ4w5tql9nsHOXzxONyPu','$2y$13$pycScCzngmdeqyjhoVTks.N3KGJ9dj0GfVrIjHXBqAMTUtMd81IZu',NULL,'EduFm@gmail.com',10,1734018414,1734018414,NULL),(50,'Sibam','KO8ANjfZ8UWxLxYRY4PlJu1HGM0N-tL2','$2y$13$lrt1.3bp3zjFmqXjy3B3HeNfyZzmw9d3D9lrClqNkaQ1ny/vQ9.tG',NULL,'simao@gmail.com',10,1736355027,1736355027,NULL),(51,'admin3','15ob6aBo9YFyXFclTa5hpQsjnQnCRJbB','$2y$13$hHfsd0KMA9JunbliBtGeA.XWJalp1NfK7PWVvw0apyP28jfRwKko2',NULL,'admin3@gmail.com',10,1736356765,1736356765,NULL);
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

-- Dump completed on 2025-02-04 14:31:28
