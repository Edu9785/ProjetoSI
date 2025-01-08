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
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_vendedor` int NOT NULL,
  `desc` varchar(455) NOT NULL,
  `preco` double NOT NULL,
  `id_tipo` int NOT NULL,
  `nome` varchar(45) NOT NULL,
  `estado` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_vendedor_idx` (`id_vendedor`),
  KEY `id_tipo_idx` (`id_tipo`),
  CONSTRAINT `id_tipo` FOREIGN KEY (`id_tipo`) REFERENCES `categorias` (`id`),
  CONSTRAINT `id_vendedor` FOREIGN KEY (`id_vendedor`) REFERENCES `profile` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (8,12,'Esta betoneira usada está em ótimo estado e pronta para ser utilizada em diversos tipos de obras. Perfeita para misturar cimento, areia e outros materiais de forma eficiente e rápida, facilitando o trabalho em construção civil e reformas. Possui motor potente e design robusto, ideal para suportar a intensidade das demandas de canteiros de obra.',20,26,'Betoneira',1,'2024-12-10 12:05:33'),(9,16,'Trator agricula, com pouca utilizaçao. Preço negociavel',10000,25,'Trator Agrícula',2,'2024-12-15 12:05:33'),(10,16,'Berbequim como novo',20,18,'Berbequim Elétrico',2,'2024-12-20 12:05:33'),(13,14,'Muito Bom',11,20,'Martelo',0,'2025-01-08 13:15:00'),(14,19,'Chave de fendas nunca usada, foi comprada por engano e nunca a cheguei a usar.\r\nQualquer informação necessário contactar através do telemóvel.',5,20,'Chave Fendas',2,'2025-01-08 16:54:00'),(15,19,'Motosserra com alguma utilização a precisar de alguns arranjos. Preço não negociável.',500,23,'Motosserra Husqvarna',0,'2025-01-08 17:00:21'),(16,19,'Berbequim C/Percussão 750W STANLEY em bom estado usado so para montar móveis, nunca apanhou pó.',60,18,'Berbequim STANLEY',0,'2025-01-08 17:03:17');
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-08 19:36:54
