-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: gardenlabstests
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
INSERT INTO `auth_assignment` VALUES ('admin','90',1735756927),('client','91',1735758358),('client','93',1735759267),('provider','94',1735759746);
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
INSERT INTO `auth_item` VALUES ('accessBackend',2,'Access backend',NULL,NULL,1735309369,1735309369),('accountDetails',2,'Account details',NULL,NULL,1735309369,1735309369),('addToCart',2,'Add to cart',NULL,NULL,1735309369,1735309369),('addToWishlist',2,'Add to wishlist',NULL,NULL,1735309369,1735309369),('admin',1,NULL,NULL,NULL,1735309369,1735309369),('cartCheckout',2,'Cart checkout',NULL,NULL,1735309369,1735309369),('categoriesIndex',2,'Categories Index',NULL,NULL,1735309369,1735309369),('client',1,NULL,NULL,NULL,1735309369,1735309369),('confirmCheckout',2,'Confirm checkout',NULL,NULL,1735309369,1735309369),('createCategory',2,'Create category',NULL,NULL,1735309369,1735309369),('createProduct',2,'Create product',NULL,NULL,1735309369,1735309369),('createReview',2,'Create review',NULL,NULL,1735309369,1735309369),('createService',2,'Create service',NULL,NULL,1735309369,1735309369),('createSupplier',2,'Create supplier',NULL,NULL,1735309369,1735309369),('createUser',2,'Create user',NULL,NULL,1735309369,1735309369),('createUserProfile',2,'Create user profile',NULL,NULL,1735309369,1735309369),('createWishlist',2,'Create wishlist',NULL,NULL,1735309369,1735309369),('deleteAccount',2,'Delete account',NULL,NULL,1735309369,1735309369),('deleteCategory',2,'Delete category',NULL,NULL,1735309369,1735309369),('deleteImage',2,'Delete image',NULL,NULL,1735309369,1735309369),('deleteOwnReview',2,'Delete own review',NULL,NULL,1735309369,1735309369),('deleteProduct',2,'Delete product',NULL,NULL,1735309369,1735309369),('deleteReview',2,'Delete review',NULL,NULL,1735309369,1735309369),('deleteService',2,'Delete service',NULL,NULL,1735309369,1735309369),('deleteSupplier',2,'Delete supplier',NULL,NULL,1735309369,1735309369),('deleteUser',2,'Delete user',NULL,NULL,1735309369,1735309369),('deleteUserProfile',2,'Delete user profile',NULL,NULL,1735309369,1735309369),('deleteWishlist',2,'Delete wishlist',NULL,NULL,1735309369,1735309369),('editAccountDetails',2,'Edit account details',NULL,NULL,1735309369,1735309369),('editCategory',2,'Edit category',NULL,NULL,1735309369,1735309369),('editProduct',2,'Edit product',NULL,NULL,1735309369,1735309369),('editReview',2,'Edit review',NULL,NULL,1735309369,1735309369),('editService',2,'Edit service',NULL,NULL,1735309369,1735309369),('editSupplier',2,'Edit supplier',NULL,NULL,1735309369,1735309369),('editWishlist',2,'Edit wishlist',NULL,NULL,1735309369,1735309369),('expeditionMethodCreate',2,'Create expedition method',NULL,NULL,1735309369,1735309369),('expeditionMethodDelete',2,'Delete expedition method',NULL,NULL,1735309369,1735309369),('expeditionMethodsIndex',2,'Expedition Methods Index',NULL,NULL,1735309369,1735309369),('expeditionMethodUpdate',2,'Update expedition method',NULL,NULL,1735309369,1735309369),('expeditionMethodView',2,'View expedition method',NULL,NULL,1735309369,1735309369),('imagesIndex',2,'Images Index',NULL,NULL,1735309369,1735309369),('invoiceCreate',2,'Create invoice',NULL,NULL,1735309369,1735309369),('invoiceDelete',2,'Delete invoice',NULL,NULL,1735309369,1735309369),('invoiceLineCreate',2,'Create invoice line',NULL,NULL,1735309369,1735309369),('invoiceLineDelete',2,'Delete invoice line',NULL,NULL,1735309369,1735309369),('invoiceLinesIndex',2,'Invoice Lines Index',NULL,NULL,1735309369,1735309369),('invoiceLineUpdate',2,'Update invoice line',NULL,NULL,1735309369,1735309369),('invoiceLineView',2,'View invoice line',NULL,NULL,1735309369,1735309369),('invoicesIndex',2,'Invoices Index',NULL,NULL,1735309369,1735309369),('invoiceUpdate',2,'Update invoice',NULL,NULL,1735309369,1735309369),('invoiceView',2,'View invoice',NULL,NULL,1735309369,1735309369),('leaveReview',2,'Leave review',NULL,NULL,1735309369,1735309369),('manageProductImages',2,'Manage product images',NULL,NULL,1735309369,1735309369),('manager',1,NULL,NULL,NULL,1735309369,1735309369),('orderConfirmed',2,'Order confirmed',NULL,NULL,1735309369,1735309369),('orderDetails',2,'Order details',NULL,NULL,1735309369,1735309369),('ordersHistory',2,'Orders history',NULL,NULL,1735309369,1735309369),('paymentMethodCreate',2,'Create payment method',NULL,NULL,1735309369,1735309369),('paymentMethodDelete',2,'Delete payment method',NULL,NULL,1735309369,1735309369),('paymentMethodsIndex',2,'Payment Methods Index',NULL,NULL,1735309369,1735309369),('paymentMethodUpdate',2,'Update payment method',NULL,NULL,1735309369,1735309369),('paymentMethodView',2,'View payment method',NULL,NULL,1735309369,1735309369),('productCartCreate',2,'Create product cart',NULL,NULL,1735309369,1735309369),('productCartDelete',2,'Delete product cart',NULL,NULL,1735309369,1735309369),('productCartLineCreate',2,'Create product cart line',NULL,NULL,1735309369,1735309369),('productCartLineDelete',2,'Delete product cart line',NULL,NULL,1735309369,1735309369),('productCartLinesIndex',2,'Product Cart Lines Index',NULL,NULL,1735309369,1735309369),('productCartLineUpdate',2,'Update product cart line',NULL,NULL,1735309369,1735309369),('productCartLineView',2,'View product cart line',NULL,NULL,1735309369,1735309369),('productCartsIndex',2,'Product Carts Index',NULL,NULL,1735309369,1735309369),('productCartUpdate',2,'Update product cart',NULL,NULL,1735309369,1735309369),('productCartView',2,'View product cart',NULL,NULL,1735309369,1735309369),('productsIndex',2,'Products Index',NULL,NULL,1735309369,1735309369),('provider',1,NULL,NULL,NULL,1735309369,1735309369),('removeFromCart',2,'Remove from cart',NULL,NULL,1735309369,1735309369),('removeFromWishlist',2,'Remove from wishlist',NULL,NULL,1735309369,1735309369),('reviewsIndex',2,'Reviews Index',NULL,NULL,1735309369,1735309369),('serviceCartCreate',2,'Create service cart',NULL,NULL,1735309369,1735309369),('serviceCartDelete',2,'Delete service cart',NULL,NULL,1735309369,1735309369),('serviceCartLineCreate',2,'Create service cart line',NULL,NULL,1735309369,1735309369),('serviceCartLineDelete',2,'Delete service cart line',NULL,NULL,1735309369,1735309369),('serviceCartLinesIndex',2,'Service Cart Lines Index',NULL,NULL,1735309369,1735309369),('serviceCartLineUpdate',2,'Update service cart line',NULL,NULL,1735309369,1735309369),('serviceCartLineView',2,'View service cart line',NULL,NULL,1735309369,1735309369),('serviceCartsIndex',2,'Service Carts Index',NULL,NULL,1735309369,1735309369),('serviceCartUpdate',2,'Update service cart',NULL,NULL,1735309369,1735309369),('serviceCartView',2,'View service cart',NULL,NULL,1735309369,1735309369),('servicesIndex',2,'Services Index',NULL,NULL,1735309369,1735309369),('suppliersIndex',2,'Suppliers Index',NULL,NULL,1735309369,1735309369),('updateQuantity',2,'Update quantity',NULL,NULL,1735309369,1735309369),('updateUser',2,'Update user',NULL,NULL,1735309369,1735309369),('updateUserProfile',2,'Update user profile',NULL,NULL,1735309369,1735309369),('uploadImages',2,'Upload images',NULL,NULL,1735309369,1735309369),('usersIndex',2,'Users Index',NULL,NULL,1735309369,1735309369),('usersProfilesIndex',2,'User Profiles Index',NULL,NULL,1735309369,1735309369),('viewCategory',2,'View category',NULL,NULL,1735309369,1735309369),('viewImage',2,'View image',NULL,NULL,1735309369,1735309369),('viewProduct',2,'View product',NULL,NULL,1735309369,1735309369),('viewReview',2,'View review',NULL,NULL,1735309369,1735309369),('viewService',2,'View service',NULL,NULL,1735309369,1735309369),('viewSupplier',2,'View supplier',NULL,NULL,1735309369,1735309369),('viewUser',2,'View user',NULL,NULL,1735309369,1735309369),('viewUserProfile',2,'View user profile',NULL,NULL,1735309369,1735309369),('viewWishlist',2,'View wishlist',NULL,NULL,1735309369,1735309369),('wishlistsIndex',2,'Wishlists Index',NULL,NULL,1735309369,1735309369);
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
INSERT INTO `auth_item_child` VALUES ('manager','accessBackend'),('client','accountDetails'),('client','addToCart'),('client','addToWishlist'),('client','cartCheckout'),('manager','categoriesIndex'),('client','confirmCheckout'),('manager','createCategory'),('manager','createProduct'),('manager','createReview'),('manager','createService'),('manager','createSupplier'),('admin','createUser'),('admin','createUserProfile'),('manager','createWishlist'),('client','deleteAccount'),('admin','deleteCategory'),('admin','deleteImage'),('client','deleteOwnReview'),('admin','deleteProduct'),('admin','deleteReview'),('admin','deleteService'),('admin','deleteSupplier'),('admin','deleteUser'),('admin','deleteUserProfile'),('admin','deleteWishlist'),('client','editAccountDetails'),('manager','editCategory'),('manager','editProduct'),('manager','editReview'),('manager','editService'),('manager','editSupplier'),('manager','editWishlist'),('admin','expeditionMethodCreate'),('admin','expeditionMethodDelete'),('admin','expeditionMethodsIndex'),('admin','expeditionMethodUpdate'),('admin','expeditionMethodView'),('manager','imagesIndex'),('admin','invoiceCreate'),('admin','invoiceDelete'),('admin','invoiceLineCreate'),('admin','invoiceLineDelete'),('admin','invoiceLinesIndex'),('admin','invoiceLineUpdate'),('admin','invoiceLineView'),('admin','invoicesIndex'),('admin','invoiceUpdate'),('admin','invoiceView'),('client','leaveReview'),('manager','manageProductImages'),('admin','manager'),('client','orderConfirmed'),('client','orderDetails'),('client','ordersHistory'),('admin','paymentMethodCreate'),('admin','paymentMethodDelete'),('admin','paymentMethodsIndex'),('admin','paymentMethodUpdate'),('admin','paymentMethodView'),('manager','productCartCreate'),('admin','productCartDelete'),('manager','productCartLineCreate'),('admin','productCartLineDelete'),('manager','productCartLinesIndex'),('manager','productCartLineUpdate'),('manager','productCartLineView'),('manager','productCartsIndex'),('manager','productCartUpdate'),('manager','productCartView'),('manager','productsIndex'),('client','removeFromCart'),('client','removeFromWishlist'),('manager','reviewsIndex'),('manager','serviceCartCreate'),('admin','serviceCartDelete'),('manager','serviceCartLineCreate'),('admin','serviceCartLineDelete'),('manager','serviceCartLinesIndex'),('manager','serviceCartLineUpdate'),('manager','serviceCartLineView'),('manager','serviceCartsIndex'),('manager','serviceCartUpdate'),('manager','serviceCartView'),('manager','servicesIndex'),('manager','suppliersIndex'),('client','updateQuantity'),('admin','updateUser'),('admin','updateUserProfile'),('manager','uploadImages'),('admin','usersIndex'),('admin','usersProfilesIndex'),('manager','viewCategory'),('manager','viewImage'),('manager','viewProduct'),('manager','viewReview'),('manager','viewService'),('manager','viewSupplier'),('admin','viewUser'),('admin','viewUserProfile'),('manager','viewWishlist'),('manager','wishlistsIndex');
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
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrinhoproduto`
--

LOCK TABLES `carrinhoproduto` WRITE;
/*!40000 ALTER TABLE `carrinhoproduto` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrinhoservico`
--

LOCK TABLES `carrinhoservico` WRITE;
/*!40000 ALTER TABLE `carrinhoservico` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fatura`
--

LOCK TABLES `fatura` WRITE;
/*!40000 ALTER TABLE `fatura` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorito`
--

LOCK TABLES `favorito` WRITE;
/*!40000 ALTER TABLE `favorito` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fornecedor`
--

LOCK TABLES `fornecedor` WRITE;
/*!40000 ALTER TABLE `fornecedor` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagem`
--

LOCK TABLES `imagem` WRITE;
/*!40000 ALTER TABLE `imagem` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linhacarrinhoproduto`
--

LOCK TABLES `linhacarrinhoproduto` WRITE;
/*!40000 ALTER TABLE `linhacarrinhoproduto` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linhafatura`
--

LOCK TABLES `linhafatura` WRITE;
/*!40000 ALTER TABLE `linhafatura` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodoexpedicao`
--

LOCK TABLES `metodoexpedicao` WRITE;
/*!40000 ALTER TABLE `metodoexpedicao` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodopagamento`
--

LOCK TABLES `metodopagamento` WRITE;
/*!40000 ALTER TABLE `metodopagamento` DISABLE KEYS */;
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
INSERT INTO `migration` VALUES ('m130524_201442_init',1734833958),('m190124_110200_add_verification_token_column_to_user_table',1734833958),('m241116_220638_init_rbac',1735309369);
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
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userprofile`
--

LOCK TABLES `userprofile` WRITE;
/*!40000 ALTER TABLE `userprofile` DISABLE KEYS */;
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

-- Dump completed on 2025-01-06 17:50:56
