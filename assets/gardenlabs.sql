-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: gardenlabs
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
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at` int DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('admin','69',1735244611),('client','72',1735253971),('manager','71',1735251641);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `rule_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('accessBackend',2,'Access backend',NULL,NULL,1735244555,1735244555),('addToCart',2,'Add to cart',NULL,NULL,1735244555,1735244555),('addToWishlist',2,'Add to wishlist',NULL,NULL,1735244555,1735244555),('admin',1,NULL,NULL,NULL,1735244555,1735244555),('categoriesIndex',2,'Categories Index',NULL,NULL,1735244555,1735244555),('checkout',2,'Checkout',NULL,NULL,1735244555,1735244555),('client',1,NULL,NULL,NULL,1735244555,1735244555),('confirmOrder',2,'Confirm order',NULL,NULL,1735244555,1735244555),('confirmOrderCheckout',2,'Confirm order checkout',NULL,NULL,1735244555,1735244555),('createCategory',2,'Create category',NULL,NULL,1735244555,1735244555),('createProduct',2,'Create product',NULL,NULL,1735244555,1735244555),('createProductReview',2,'Create product review',NULL,NULL,1735244555,1735244555),('createReview',2,'Create review',NULL,NULL,1735244555,1735244555),('createService',2,'Create service',NULL,NULL,1735244555,1735244555),('createSupplier',2,'Create supplier',NULL,NULL,1735244555,1735244555),('createUser',2,'Create user',NULL,NULL,1735244555,1735244555),('createUserProfile',2,'Create user profile',NULL,NULL,1735244555,1735244555),('createWishlist',2,'Create wishlist',NULL,NULL,1735244555,1735244555),('deleteAccount',2,'Delete account',NULL,NULL,1735244555,1735244555),('deleteCategory',2,'Delete category',NULL,NULL,1735244555,1735244555),('deleteImage',2,'Delete image',NULL,NULL,1735244555,1735244555),('deleteOwnProductReview',2,'Delete own product review',NULL,NULL,1735244555,1735244555),('deleteProduct',2,'Delete product',NULL,NULL,1735244555,1735244555),('deleteReview',2,'Delete review',NULL,NULL,1735244555,1735244555),('deleteService',2,'Delete service',NULL,NULL,1735244555,1735244555),('deleteSupplier',2,'Delete supplier',NULL,NULL,1735244555,1735244555),('deleteUser',2,'Delete user',NULL,NULL,1735244555,1735244555),('deleteUserProfile',2,'Delete user profile',NULL,NULL,1735244555,1735244555),('deleteWishlist',2,'Delete wishlist',NULL,NULL,1735244555,1735244555),('editCategory',2,'Edit category',NULL,NULL,1735244555,1735244555),('editProduct',2,'Edit product',NULL,NULL,1735244555,1735244555),('editReview',2,'Edit review',NULL,NULL,1735244555,1735244555),('editService',2,'Edit service',NULL,NULL,1735244555,1735244555),('editSupplier',2,'Edit supplier',NULL,NULL,1735244555,1735244555),('editUserProfileDetails',2,'Edit user profile details',NULL,NULL,1735244555,1735244555),('editWishlist',2,'Edit wishlist',NULL,NULL,1735244555,1735244555),('expeditionMethodCreate',2,'Create expedition method',NULL,NULL,1735244555,1735244555),('expeditionMethodDelete',2,'Delete expedition method',NULL,NULL,1735244555,1735244555),('expeditionMethodsIndex',2,'Expedition Methods Index',NULL,NULL,1735244555,1735244555),('expeditionMethodUpdate',2,'Update expedition method',NULL,NULL,1735244555,1735244555),('expeditionMethodView',2,'View expedition method',NULL,NULL,1735244555,1735244555),('imagesIndex',2,'Images Index',NULL,NULL,1735244555,1735244555),('invoiceCreate',2,'Create invoice',NULL,NULL,1735244555,1735244555),('invoiceDelete',2,'Delete invoice',NULL,NULL,1735244555,1735244555),('invoiceLineCreate',2,'Create invoice line',NULL,NULL,1735244555,1735244555),('invoiceLineDelete',2,'Delete invoice line',NULL,NULL,1735244555,1735244555),('invoiceLinesIndex',2,'Invoice Lines Index',NULL,NULL,1735244555,1735244555),('invoiceLineUpdate',2,'Update invoice line',NULL,NULL,1735244555,1735244555),('invoiceLineView',2,'View invoice line',NULL,NULL,1735244555,1735244555),('invoicesIndex',2,'Invoices Index',NULL,NULL,1735244555,1735244555),('invoiceUpdate',2,'Update invoice',NULL,NULL,1735244555,1735244555),('invoiceView',2,'View invoice',NULL,NULL,1735244555,1735244555),('manageProductImages',2,'Manage product images',NULL,NULL,1735244555,1735244555),('manager',1,NULL,NULL,NULL,1735244555,1735244555),('paymentMethodCreate',2,'Create payment method',NULL,NULL,1735244555,1735244555),('paymentMethodDelete',2,'Delete payment method',NULL,NULL,1735244555,1735244555),('paymentMethodsIndex',2,'Payment Methods Index',NULL,NULL,1735244555,1735244555),('paymentMethodUpdate',2,'Update payment method',NULL,NULL,1735244555,1735244555),('paymentMethodView',2,'View payment method',NULL,NULL,1735244555,1735244555),('productCartCreate',2,'Create product cart',NULL,NULL,1735244555,1735244555),('productCartDelete',2,'Delete product cart',NULL,NULL,1735244555,1735244555),('productCartLineCreate',2,'Create product cart line',NULL,NULL,1735244555,1735244555),('productCartLineDelete',2,'Delete product cart line',NULL,NULL,1735244555,1735244555),('productCartLinesIndex',2,'Product Cart Lines Index',NULL,NULL,1735244555,1735244555),('productCartLineUpdate',2,'Update product cart line',NULL,NULL,1735244555,1735244555),('productCartLineView',2,'View product cart line',NULL,NULL,1735244555,1735244555),('productCartsIndex',2,'Product Carts Index',NULL,NULL,1735244555,1735244555),('productCartUpdate',2,'Update product cart',NULL,NULL,1735244555,1735244555),('productCartView',2,'View product cart',NULL,NULL,1735244555,1735244555),('productsIndex',2,'Products Index',NULL,NULL,1735244555,1735244555),('provider',1,NULL,NULL,NULL,1735244555,1735244555),('removeFromCart',2,'Remove from cart',NULL,NULL,1735244555,1735244555),('removeFromWishlist',2,'Remove from wishlist',NULL,NULL,1735244555,1735244555),('reviewsIndex',2,'Reviews Index',NULL,NULL,1735244555,1735244555),('serviceCartCreate',2,'Create service cart',NULL,NULL,1735244555,1735244555),('serviceCartDelete',2,'Delete service cart',NULL,NULL,1735244555,1735244555),('serviceCartLineCreate',2,'Create service cart line',NULL,NULL,1735244555,1735244555),('serviceCartLineDelete',2,'Delete service cart line',NULL,NULL,1735244555,1735244555),('serviceCartLinesIndex',2,'Service Cart Lines Index',NULL,NULL,1735244555,1735244555),('serviceCartLineUpdate',2,'Update service cart line',NULL,NULL,1735244555,1735244555),('serviceCartLineView',2,'View service cart line',NULL,NULL,1735244555,1735244555),('serviceCartsIndex',2,'Service Carts Index',NULL,NULL,1735244555,1735244555),('serviceCartUpdate',2,'Update service cart',NULL,NULL,1735244555,1735244555),('serviceCartView',2,'View service cart',NULL,NULL,1735244555,1735244555),('servicesIndex',2,'Services Index',NULL,NULL,1735244555,1735244555),('suppliersIndex',2,'Suppliers Index',NULL,NULL,1735244555,1735244555),('updateCartItemQuantity',2,'Update cart item quantity',NULL,NULL,1735244555,1735244555),('updateUser',2,'Update user',NULL,NULL,1735244555,1735244555),('updateUserProfile',2,'Update user profile',NULL,NULL,1735244555,1735244555),('uploadImages',2,'Upload images',NULL,NULL,1735244555,1735244555),('usersIndex',2,'Users Index',NULL,NULL,1735244555,1735244555),('usersProfilesIndex',2,'User Profiles Index',NULL,NULL,1735244555,1735244555),('viewCartFO',2,'View cart',NULL,NULL,1735244555,1735244555),('viewCategory',2,'View category',NULL,NULL,1735244555,1735244555),('viewImage',2,'View image',NULL,NULL,1735244555,1735244555),('viewOrderDetails',2,'View order details',NULL,NULL,1735244555,1735244555),('viewOrderHistory',2,'View order history',NULL,NULL,1735244555,1735244555),('viewProduct',2,'View product',NULL,NULL,1735244555,1735244555),('viewReview',2,'View review',NULL,NULL,1735244555,1735244555),('viewService',2,'View service',NULL,NULL,1735244555,1735244555),('viewSupplier',2,'View supplier',NULL,NULL,1735244555,1735244555),('viewUser',2,'View user',NULL,NULL,1735244555,1735244555),('viewUserProfile',2,'View user profile',NULL,NULL,1735244555,1735244555),('viewUserProfileDetails',2,'View user profile details',NULL,NULL,1735244555,1735244555),('viewWishlist',2,'View wishlist',NULL,NULL,1735244555,1735244555),('viewWishlistFO',2,'View wishlist',NULL,NULL,1735244555,1735244555),('wishlistsIndex',2,'Wishlists Index',NULL,NULL,1735244555,1735244555);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('manager','accessBackend'),('manager','createProduct'),('manager','createService'),('admin','createUser'),('admin','deleteProduct'),('manager','deleteProduct'),('manager','deleteService'),('admin','deleteUser'),('manager','editProduct'),('manager','editService'),('manager','manageProductImages'),('admin','manager'),('admin','updateUser');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrinhoproduto`
--

DROP TABLE IF EXISTS `carrinhoproduto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrinhoproduto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `total` double NOT NULL,
  `userprofile_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_carrinhoproduto_userprofile1_idx` (`userprofile_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrinhoproduto`
--

LOCK TABLES `carrinhoproduto` WRITE;
/*!40000 ALTER TABLE `carrinhoproduto` DISABLE KEYS */;
INSERT INTO `carrinhoproduto` VALUES (20,41.3,56),(18,0,53);
/*!40000 ALTER TABLE `carrinhoproduto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrinhoproduto_has_produto`
--

DROP TABLE IF EXISTS `carrinhoproduto_has_produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrinhoproduto_has_produto` (
  `carrinhoproduto_id` int NOT NULL,
  `produto_id` int NOT NULL,
  PRIMARY KEY (`carrinhoproduto_id`,`produto_id`),
  KEY `fk_carrinhoproduto_has_produto_produto1_idx` (`produto_id`),
  KEY `fk_carrinhoproduto_has_produto_carrinhoproduto1_idx` (`carrinhoproduto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrinhoproduto_has_produto`
--

LOCK TABLES `carrinhoproduto_has_produto` WRITE;
/*!40000 ALTER TABLE `carrinhoproduto_has_produto` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrinhoproduto_has_produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrinhoservico`
--

DROP TABLE IF EXISTS `carrinhoservico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrinhoservico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `total` double NOT NULL,
  `userprofile_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_carrinhoservico_userprofile1_idx` (`userprofile_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrinhoservico`
--

LOCK TABLES `carrinhoservico` WRITE;
/*!40000 ALTER TABLE `carrinhoservico` DISABLE KEYS */;
INSERT INTO `carrinhoservico` VALUES (19,0,56),(17,0,53);
/*!40000 ALTER TABLE `carrinhoservico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (7,'Hydro'),(8,'Seeds'),(19,'Tools');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fatura`
--

DROP TABLE IF EXISTS `fatura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fatura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `total` double NOT NULL,
  `datahora` datetime NOT NULL,
  `nome_destinatario` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `morada_destinatario` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `telefone_destinatario` int DEFAULT NULL,
  `nif_destinatario` int DEFAULT NULL,
  `preco_envio` double NOT NULL,
  `metodopagamento_id` int NOT NULL,
  `metodoexpedicao_id` int DEFAULT NULL,
  `userprofile_id` int NOT NULL,
  PRIMARY KEY (`id`,`userprofile_id`),
  KEY `fk_fatura_metodopagamento1_idx` (`metodopagamento_id`),
  KEY `fk_fatura_metodoexpedicao1_idx` (`metodoexpedicao_id`),
  KEY `fk_fatura_userprofile1_idx` (`userprofile_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fatura`
--

LOCK TABLES `fatura` WRITE;
/*!40000 ALTER TABLE `fatura` DISABLE KEYS */;
INSERT INTO `fatura` VALUES (32,41.3,'2024-12-26 23:06:52','Andre Costa','Rua da Camelia, Buarcos',960152312,134541234,0,3,3,56),(33,54.55,'2024-12-26 23:49:10','Andre Costa','Rua da Camelia, Buarcos',NULL,NULL,0,3,3,56);
/*!40000 ALTER TABLE `fatura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorito`
--

DROP TABLE IF EXISTS `favorito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favorito` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userprofile_id` int NOT NULL,
  `servico_id` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_favorito_userprofile1_idx` (`userprofile_id`),
  KEY `fk_favorito_servico1_idx` (`servico_id`),
  KEY `fk_favorito_produto1_idx` (`produto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorito`
--

LOCK TABLES `favorito` WRITE;
/*!40000 ALTER TABLE `favorito` DISABLE KEYS */;
INSERT INTO `favorito` VALUES (33,72,NULL,50);
/*!40000 ALTER TABLE `favorito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fornecedor`
--

DROP TABLE IF EXISTS `fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fornecedor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `telefone` int NOT NULL,
  `localizacao` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fornecedor`
--

LOCK TABLES `fornecedor` WRITE;
/*!40000 ALTER TABLE `fornecedor` DISABLE KEYS */;
INSERT INTO `fornecedor` VALUES (5,'Gardeners','gardeners@gmail.com',960123182,'Rua das Silverinhas, Leiria');
/*!40000 ALTER TABLE `fornecedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagem`
--

DROP TABLE IF EXISTS `imagem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagem` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` varchar(80) NOT NULL,
  `produto_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_imagem_produto1_idx` (`produto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagem`
--

LOCK TABLES `imagem` WRITE;
/*!40000 ALTER TABLE `imagem` DISABLE KEYS */;
INSERT INTO `imagem` VALUES (47,'50.big-img-01.jpg',50),(48,'51.big-img-02.jpg',51);
/*!40000 ALTER TABLE `imagem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `linhacarrinhoproduto`
--

DROP TABLE IF EXISTS `linhacarrinhoproduto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `linhacarrinhoproduto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantidade` int NOT NULL,
  `precounitario` double NOT NULL,
  `carrinhoproduto_id` int NOT NULL,
  `produto_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_linhacarrinhoproduto_carrinhoproduto1_idx` (`carrinhoproduto_id`),
  KEY `fk_linhacarrinhoproduto_produto1_idx` (`produto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linhacarrinhoproduto`
--

LOCK TABLES `linhacarrinhoproduto` WRITE;
/*!40000 ALTER TABLE `linhacarrinhoproduto` DISABLE KEYS */;
INSERT INTO `linhacarrinhoproduto` VALUES (66,1,41.3,19,51),(70,1,41.3,20,51);
/*!40000 ALTER TABLE `linhacarrinhoproduto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `linhacarrinhoservico`
--

DROP TABLE IF EXISTS `linhacarrinhoservico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `linhacarrinhoservico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `preco` double NOT NULL,
  `carrinhoservico_id` int NOT NULL,
  `servico_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_linhacarrinhoservico_carrinhoservico1_idx` (`carrinhoservico_id`),
  KEY `fk_linhacarrinhoservico_servico1_idx` (`servico_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linhacarrinhoservico`
--

LOCK TABLES `linhacarrinhoservico` WRITE;
/*!40000 ALTER TABLE `linhacarrinhoservico` DISABLE KEYS */;
/*!40000 ALTER TABLE `linhacarrinhoservico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `linhafatura`
--

DROP TABLE IF EXISTS `linhafatura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `linhafatura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantidade` int DEFAULT NULL,
  `precounitario` double DEFAULT NULL,
  `fatura_id` int NOT NULL,
  `produto_id` int DEFAULT NULL,
  `servico_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_linhafatura_fatura1_idx` (`fatura_id`),
  KEY `fk_linhafatura_produto1_idx` (`produto_id`),
  KEY `fk_linhafatura_servico1_idx` (`servico_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linhafatura`
--

LOCK TABLES `linhafatura` WRITE;
/*!40000 ALTER TABLE `linhafatura` DISABLE KEYS */;
INSERT INTO `linhafatura` VALUES (45,1,41.3,31,51,NULL),(47,1,41.3,32,51,NULL),(48,1,41.3,33,51,NULL),(49,1,13.25,33,50,NULL);
/*!40000 ALTER TABLE `linhafatura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metodoexpedicao`
--

DROP TABLE IF EXISTS `metodoexpedicao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metodoexpedicao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  `preco` double NOT NULL,
  `duracao` varchar(60) NOT NULL,
  `disponivel` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodoexpedicao`
--

LOCK TABLES `metodoexpedicao` WRITE;
/*!40000 ALTER TABLE `metodoexpedicao` DISABLE KEYS */;
INSERT INTO `metodoexpedicao` VALUES (3,'Standard',0,'3 a 4 dias úteis',1),(4,'Fast',1,'2 dias uteis',1);
/*!40000 ALTER TABLE `metodoexpedicao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metodopagamento`
--

DROP TABLE IF EXISTS `metodopagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metodopagamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  `disponivel` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodopagamento`
--

LOCK TABLES `metodopagamento` WRITE;
/*!40000 ALTER TABLE `metodopagamento` DISABLE KEYS */;
INSERT INTO `metodopagamento` VALUES (3,'Paypal',1);
/*!40000 ALTER TABLE `metodopagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m130524_201442_init',1734833958),('m190124_110200_add_verification_token_column_to_user_table',1734833958),('m241116_220638_init_rbac',1735244555);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  `preco` double NOT NULL,
  `nome` varchar(80) NOT NULL,
  `quantidade` int NOT NULL,
  `fornecedor_id` int NOT NULL,
  `categoria_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produto_fornecedor1_idx` (`fornecedor_id`),
  KEY `fk_produto_categoria1_idx` (`categoria_id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` VALUES (50,'Produto bueda fixe',13.25,'Produto',0,5,19),(51,'Produto 2 bueda bacano',41.3,'Produto2',5,5,7);
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `conteudo` varchar(100) NOT NULL,
  `datahora` datetime NOT NULL,
  `avaliacao` double NOT NULL,
  `servico_id` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  `userprofile_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_review_servico1_idx` (`servico_id`),
  KEY `fk_review_produto1_idx` (`produto_id`),
  KEY `fk_review_userprofile1_idx` (`userprofile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (9,'asdadasdasda','2024-12-26 23:26:56',1,NULL,51,56);
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servico`
--

DROP TABLE IF EXISTS `servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  `preco` double NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `duracao` int NOT NULL,
  `prestador_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_servico_userprofile1_idx` (`prestador_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servico`
--

LOCK TABLES `servico` WRITE;
/*!40000 ALTER TABLE `servico` DISABLE KEYS */;
/*!40000 ALTER TABLE `servico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servico_has_carrinhoservico`
--

DROP TABLE IF EXISTS `servico_has_carrinhoservico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servico_has_carrinhoservico` (
  `servico_id` int NOT NULL,
  `carrinhoservico_id` int NOT NULL,
  PRIMARY KEY (`servico_id`,`carrinhoservico_id`),
  KEY `fk_servico_has_carrinhoservico_carrinhoservico1_idx` (`carrinhoservico_id`),
  KEY `fk_servico_has_carrinhoservico_servico1_idx` (`servico_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servico_has_carrinhoservico`
--

LOCK TABLES `servico_has_carrinhoservico` WRITE;
/*!40000 ALTER TABLE `servico_has_carrinhoservico` DISABLE KEYS */;
/*!40000 ALTER TABLE `servico_has_carrinhoservico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (69,'tomas','J45Suqf4qq6zlwmhDa1UXCdI4uRzvgas','$2y$13$4JNCD.V2VCdHFsdYVULNtuI0A2OBJTtU0397f8cggmcyDJeITpUqi',NULL,'tomas@gmail.com',10,1735244611,1735244611,'35e7YmtENRr9nNQq3b4qgrWLwO9mBB-A_1735244611'),(71,'martim','pXEgxm7adAFv4xxeJr_yoMrYzNiuHIar','$2y$13$jdOHkhAQ.2DreRtKeEPHWeEV76Fp9/p/jR04ad95dd58O01620dqm',NULL,'martim@gmail.com',10,1735251641,1735251641,'4WY1ZUINhxw-qJwoSQk-IvtVsB97KhZ5_1735251641'),(72,'andre','pa7LsvC0n8v3pp-N5TS3Jc73_CaZnm4X','$2y$13$jTnKw4F63zFq77akMBZdceYh4si7LZSt2DIIjujbObixyG7VarlI2',NULL,'andre@gmail.com',10,1735253971,1735253971,'oTiVmYnb-TdD8q9PbZKd2bAHv_FzeIAp_1735253971');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userprofile`
--

DROP TABLE IF EXISTS `userprofile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `userprofile` (
  `id` int NOT NULL AUTO_INCREMENT,
  `morada` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nif` int DEFAULT NULL,
  `telefone` int DEFAULT NULL,
  `nome` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_userprofile_user1_idx` (`user_id`),
  CONSTRAINT `fk_userprofile_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userprofile`
--

LOCK TABLES `userprofile` WRITE;
/*!40000 ALTER TABLE `userprofile` DISABLE KEYS */;
INSERT INTO `userprofile` VALUES (53,NULL,NULL,NULL,NULL,69),(55,NULL,NULL,NULL,NULL,71),(56,'',NULL,NULL,'Andre Costa',72);
/*!40000 ALTER TABLE `userprofile` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-27 14:11:24
