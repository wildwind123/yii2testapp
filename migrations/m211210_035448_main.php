<?php

use yii\db\Migration;

/**
 * Class m211210_035448_main
 */
class m211210_035448_main extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->execute("
        -- MySQL dump 10.13  Distrib 8.0.27, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: main
-- ------------------------------------------------------
-- Server version	8.0.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dish`
--

DROP TABLE IF EXISTS `dish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dish` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dish_name_uindex` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dish`
--

LOCK TABLES `dish` WRITE;
/*!40000 ALTER TABLE `dish` DISABLE KEYS */;
INSERT INTO `dish` VALUES (5,'Макарон с мясом','2021-12-10 14:06:24','2021-12-10 14:01:35'),(6,'Макарон с луком, мясом','2021-12-10 14:06:58','2021-12-10 14:06:58'),(7,'Картошка с мясом','2021-12-10 14:07:52','2021-12-10 14:07:52'),(8,'Картошка с рыбой','2021-12-10 14:08:12','2021-12-10 14:08:12'),(9,'Картошка с сыром','2021-12-10 14:08:22','2021-12-10 14:08:22'),(10,'Гречка с рыбой','2021-12-10 14:08:38','2021-12-10 14:08:38'),(11,'Гречка с мясом','2021-12-10 14:08:57','2021-12-10 14:08:57'),(12,'Гречка с сыром','2021-12-10 14:09:06','2021-12-10 14:09:06'),(15,'Рыбо мясо','2021-12-11 02:53:41','2021-12-11 02:53:41'),(16,'Гречка лук мясо','2021-12-11 07:30:47','2021-12-11 07:30:47');
/*!40000 ALTER TABLE `dish` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dish_ingredient`
--

DROP TABLE IF EXISTS `dish_ingredient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dish_ingredient` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ingredient_id` int NOT NULL DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dish_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dish_ingredient_dish_id_ingredient_id_uindex` (`dish_id`,`ingredient_id`),
  KEY `dish_ingredient___fk5` (`ingredient_id`),
  CONSTRAINT `dish_ingredient___fk5` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `dish_ingredient_dish_id_fk3` FOREIGN KEY (`dish_id`) REFERENCES `dish` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dish_ingredient`
--

LOCK TABLES `dish_ingredient` WRITE;
/*!40000 ALTER TABLE `dish_ingredient` DISABLE KEYS */;
INSERT INTO `dish_ingredient` VALUES (7,4,'2021-12-10 14:06:58','2021-12-10 14:06:58',6),(8,8,'2021-12-10 14:06:58','2021-12-10 14:06:58',6),(10,7,'2021-12-10 14:07:52','2021-12-10 14:07:52',7),(11,1,'2021-12-10 14:08:12','2021-12-10 14:08:12',8),(12,7,'2021-12-10 14:08:12','2021-12-10 14:08:12',8),(16,8,'2021-12-11 01:06:26','2021-12-11 01:06:26',5),(17,3,'2021-12-11 01:39:54','2021-12-11 01:39:54',9),(18,7,'2021-12-11 01:39:54','2021-12-11 01:39:54',9),(22,3,'2021-12-11 01:40:46','2021-12-11 01:40:46',12),(26,4,'2021-12-11 01:54:46','2021-12-11 01:54:46',5),(27,5,'2021-12-11 01:54:46','2021-12-11 01:54:46',5),(28,1,'2021-12-11 02:53:41','2021-12-11 02:53:41',15),(31,3,'2021-12-11 04:39:54','2021-12-11 04:39:54',11),(32,4,'2021-12-11 04:39:54','2021-12-11 04:39:54',11),(33,5,'2021-12-11 04:39:54','2021-12-11 04:39:54',11),(34,7,'2021-12-11 04:39:54','2021-12-11 04:39:54',11),(35,8,'2021-12-11 04:39:54','2021-12-11 04:39:54',11),(36,9,'2021-12-11 04:39:54','2021-12-11 04:39:54',11),(37,10,'2021-12-11 04:39:54','2021-12-11 04:39:54',11),(39,4,'2021-12-11 07:30:47','2021-12-11 07:30:47',16),(41,11,'2021-12-11 07:37:11','2021-12-11 07:37:11',5),(42,11,'2021-12-11 07:37:24','2021-12-11 07:37:24',7),(43,1,'2021-12-11 07:38:31','2021-12-11 07:38:31',10),(44,12,'2021-12-11 07:38:31','2021-12-11 07:38:31',10),(45,11,'2021-12-11 07:38:49','2021-12-11 07:38:49',11),(46,12,'2021-12-11 07:38:49','2021-12-11 07:38:49',11),(47,12,'2021-12-11 07:38:59','2021-12-11 07:38:59',12),(48,11,'2021-12-11 07:39:18','2021-12-11 07:39:18',15),(49,11,'2021-12-11 07:39:26','2021-12-11 07:39:26',16),(50,12,'2021-12-11 07:39:26','2021-12-11 07:39:26',16);
/*!40000 ALTER TABLE `dish_ingredient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredient`
--

DROP TABLE IF EXISTS `ingredient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingredient` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL,
  `updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ingredient_name_uindex` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredient`
--

LOCK TABLES `ingredient` WRITE;
/*!40000 ALTER TABLE `ingredient` DISABLE KEYS */;
INSERT INTO `ingredient` VALUES (1,'Рыба',0,'2021-12-11 07:56:05','2021-12-10 04:14:19'),(3,'Сыр',0,'2021-12-10 09:30:02','2021-12-10 09:30:02'),(4,'Лук',0,'2021-12-10 09:30:10','2021-12-10 09:30:10'),(5,'Рис',0,'2021-12-10 14:02:45','2021-12-10 14:02:45'),(7,'Картошка',0,'2021-12-10 14:04:08','2021-12-10 14:04:08'),(8,'Макароны',0,'2021-12-10 14:04:40','2021-12-10 14:04:40'),(9,'Яйцо',0,'2021-12-10 14:04:53','2021-12-10 14:04:53'),(10,'Чеснок',0,'2021-12-10 14:05:05','2021-12-10 14:05:05'),(11,'Мясо',0,'2021-12-11 07:36:35','2021-12-11 07:36:35'),(12,'Гречка',0,'2021-12-11 07:38:16','2021-12-11 07:38:16');
/*!40000 ALTER TABLE `ingredient` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-11 16:58:49
        ");
    }
}
