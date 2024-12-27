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
-- Table structure for table `imagens`
--

DROP TABLE IF EXISTS `imagens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `imagens` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagens`
--

LOCK TABLES `imagens` WRITE;
/*!40000 ALTER TABLE `imagens` DISABLE KEYS */;
INSERT INTO `imagens` VALUES (22,'uploads/dmZpKahfTmJvdhQUJNLT8XUlFVwd1UZA.png'),(30,'uploads/gKGUNK8iN23L8K7veuzv985AgPPE3zY0.png'),(31,'uploads/gJN7aXcJEr8gDH9tdR3rVVqudPaBQKTF.png'),(32,'uploads/W6kYtxEqLt1YEjPbIYztNqAMOdSo7U2Y.png'),(33,'uploads/cZQtzzeaGSZwvYSUyZiCgszsDS9DSKz2.png'),(34,'uploads/gW0GFsXusEzx8foAtEkD5G1HgQQ8x1bz.png'),(35,'uploads/cCstUEsnaGzMz4XXDjuiuuOi1NJ1Tfq9.png'),(37,'uploads/UK_rJn12NwM1oVwkXS_ZWx9ZiPqWDZoQ.png'),(38,'uploads/7LGgUzcC64-TsU0ORP4UxXbpPVWngnAU.png'),(52,'uploads/FDML514bybVechgMcLiIiT2DnsKqumDb.png'),(53,'uploads/bFmmbE5V9jGAE_o9rsknyiyMRD7Y_FFb.png'),(54,'uploads/oUyBfkEy4jGljaCdDwa1PHgVlr1O4xz-.png'),(55,'uploads/yg0s2uKimURree792TsWqYQtEiWi2GNJ.png'),(56,'uploads/2ud9sF6osgdF_reMcSz917Oi4DD_GfAl.png'),(57,'uploads/s8n7sJp0iY3Hcq1Qt5_932IqirQJ5Sl2.png'),(58,'uploads/pQEZ5yhkit9nmJ9asKWruvDNsCLdyo-4.png'),(59,'uploads/jWTHxZi03e1gbwx7n99N5DwWytwSTuvb.png'),(60,'uploads/icwEgVMdx5C1YUcZ2bPUSkMok9OzXKe5.png'),(61,'uploads/PLuMNshxNAPg3w0lOixQNzUfnorqzTgl.png'),(62,'uploads/HRQxKJdxajY-0TOx1fY4XycBtE3a7MXD.png');
/*!40000 ALTER TABLE `imagens` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-27 18:57:37
