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
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagens`
--

LOCK TABLES `imagens` WRITE;
/*!40000 ALTER TABLE `imagens` DISABLE KEYS */;
INSERT INTO `imagens` VALUES (22,'uploads/dmZpKahfTmJvdhQUJNLT8XUlFVwd1UZA.png'),(30,'uploads/gKGUNK8iN23L8K7veuzv985AgPPE3zY0.png'),(31,'uploads/gJN7aXcJEr8gDH9tdR3rVVqudPaBQKTF.png'),(32,'uploads/W6kYtxEqLt1YEjPbIYztNqAMOdSo7U2Y.png'),(33,'uploads/cZQtzzeaGSZwvYSUyZiCgszsDS9DSKz2.png'),(34,'uploads/gW0GFsXusEzx8foAtEkD5G1HgQQ8x1bz.png'),(35,'uploads/cCstUEsnaGzMz4XXDjuiuuOi1NJ1Tfq9.png'),(37,'uploads/UK_rJn12NwM1oVwkXS_ZWx9ZiPqWDZoQ.png'),(38,'uploads/7LGgUzcC64-TsU0ORP4UxXbpPVWngnAU.png'),(52,'uploads/FDML514bybVechgMcLiIiT2DnsKqumDb.png'),(53,'uploads/bFmmbE5V9jGAE_o9rsknyiyMRD7Y_FFb.png'),(54,'uploads/oUyBfkEy4jGljaCdDwa1PHgVlr1O4xz-.png'),(55,'uploads/yg0s2uKimURree792TsWqYQtEiWi2GNJ.png'),(56,'uploads/2ud9sF6osgdF_reMcSz917Oi4DD_GfAl.png'),(57,'uploads/s8n7sJp0iY3Hcq1Qt5_932IqirQJ5Sl2.png'),(58,'uploads/pQEZ5yhkit9nmJ9asKWruvDNsCLdyo-4.png'),(59,'uploads/jWTHxZi03e1gbwx7n99N5DwWytwSTuvb.png'),(66,'uploads/R19oe05tP0KjSlSLaMpF04Q5XvP2QjZx.png'),(67,'uploads/Jcs7smzN_f6HwiNpUEVazpio1nH9HDDQ.png'),(68,'uploads/lnI4yclxOyzCmfVVSE5hQ5uKcuRcWITh.png'),(69,'uploads/1luEvUSNfP7EPl0lOJHHXycXMX49oTj0.png'),(70,'uploads/75-RrUKewr3dd288Mcf6VtkpJBNf6oUq.png'),(71,'uploads/4UF2-rIuf8CGgk5pjtU9FjXsCV1kPXOE.png'),(78,'uploads/RFV2t-6OHUatyFTqKXSUbnt7ztHzr6VI.png'),(79,'uploads/imOr6lgEZ9Voe9YNS6kGi_pdb_w0iu4F.png'),(80,'uploads/gZgjCQm5O1lqXs7x8pCsmo3DtSO1dP_p.png'),(81,'uploads/5iO_6NBeLhXbPhE4bMAGoiKKRpzBX1oa.png'),(82,'uploads/f0qsSquDYgedtdoUhgGSTeJPFwkrAoz9.png'),(83,'uploads/FYxW9Pd3bAoYFClh-0KpKseha-Y7xEqM.png'),(84,'uploads/KhbKHfnRl4IDLFxsyLYSYO_GB63pYgsd.png'),(85,'uploads/r6OotHKNcx2K1Bg9FEU9arWJUDRD9gzL.png'),(86,'uploads/SJKpmPR7j2LkQulL8CfDh9uYnCv3xc7h.png'),(87,'uploads/uij93mNUzSxwdrvamtXYkAyatjtYLvRl.png'),(96,'uploads/Iz4sC5xiAZ2fqg1yaku8f3qRg1g_L3eY.png'),(97,'uploads/Unybbmo7OIeNu1H7ULojlblF2cWsHPiy.png'),(98,'uploads/PoyUQD2_-JFR5yo7Ti_u0d8Q7nNVle75.png'),(99,'uploads/aabE4YQO3BJbPCAjZStd36-juAQX7v63.png');
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

-- Dump completed on 2025-02-04 14:31:26
