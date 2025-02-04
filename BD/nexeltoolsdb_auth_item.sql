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
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('accessBackOffice',2,'Acessar Backoffice',NULL,NULL,1732443451,1732443451),('addCategories',2,'Adicionar categorias de ferramentas',NULL,NULL,1732443451,1732443451),('addFavorites',2,'Adicionar produto a lista de favoritos',NULL,NULL,1732443451,1732443451),('addProductDetails',2,'Inserir detalhes do produto',NULL,NULL,1732443451,1732443451),('addShippingMethods',2,'Adicionar métodos de expedição',NULL,NULL,1732443451,1732443451),('addToCart',2,'Adicionar produtos ao carrinho',NULL,NULL,1732443451,1732443451),('addUser',2,'Adicionar utilizadores',NULL,NULL,1732443451,1732443451),('admin',1,NULL,NULL,NULL,1732443451,1732443451),('assignRoles',2,'Atribuir níveis de acesso com base no papel',NULL,NULL,1732443451,1732443451),('checkout',2,'Efetuar a compra de produtos com diferentes métodos de pagamento',NULL,NULL,1732443451,1732443451),('createSales',2,'Criar vendas',NULL,NULL,1732443451,1732443451),('deleteCategories',2,'Remover categorias de ferramentas',NULL,NULL,1732443451,1732443451),('deleteFavorites',2,'Remover produtos da lista de favoritos',NULL,NULL,1732443451,1732443451),('deleteReview',2,'Eliminar comentários e avaliações',NULL,NULL,1732443451,1732443451),('deleteSales',2,'Eliminar vendas',NULL,NULL,1732443451,1732443451),('deleteShippingMethods',2,'Remover métodos de expedição',NULL,NULL,1732443451,1732443451),('deleteUsers',2,'Remover utilizadores',NULL,NULL,1732443451,1732443451),('editCart',2,'Editar carrinho',NULL,NULL,1732443451,1732443451),('editCatalog',2,'Editar  produtos do catálogo',NULL,NULL,1732443451,1732443451),('editCategories',2,'Editar categorias de ferramentas',NULL,NULL,1732443451,1732443451),('editProductDetails',2,'Editar detalhes do produto',NULL,NULL,1732443451,1732443451),('editProfile',2,'Alterar dados do perfil',NULL,NULL,1732443451,1732443451),('editReview',2,'Editar comentários e avaliações',NULL,NULL,1732443451,1732443451),('editSales',2,'Editar vendas',NULL,NULL,1732443451,1732443451),('editShippingMethods',2,'Editar métodos de expedição',NULL,NULL,1732443451,1732443451),('editUsers',2,'Editar utilizadores',NULL,NULL,1732443451,1732443451),('leaveReview',2,'Deixar comentários e avaliações',NULL,NULL,1732443451,1732443451),('removeCatalog',2,'Remover produtos do catálogo',NULL,NULL,1732443451,1732443451),('removeFromCart',2,'Remover produtos do carrinho',NULL,NULL,1732443451,1732443451),('removeProductDetails',2,'Remover detalhes do produto',NULL,NULL,1732443451,1732443451),('utilizador',1,NULL,NULL,NULL,1732443451,1732443451),('viewProductDetails',2,'Visualizar detalhes dos produtos',NULL,NULL,1732443451,1732443451),('viewPurchaseHistory',2,'Visualizar histórico de compras',NULL,NULL,1732443451,1732443451),('viewSalesHistory',2,'Visualizar histórico de vendas',NULL,NULL,1732443451,1732443451);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-04 14:31:27
