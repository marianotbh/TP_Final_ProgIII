CREATE DATABASE  IF NOT EXISTS `heroku_586770c123f6dd2` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `heroku_586770c123f6dd2`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: us-cdbr-iron-east-04.cleardb.net    Database: heroku_586770c123f6dd2
-- ------------------------------------------------------
-- Server version	5.5.56-log

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
-- Table structure for table `empleado`
--

DROP TABLE IF EXISTS `empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empleado` (
  `ID_empleado` int(11) NOT NULL AUTO_INCREMENT,
  `ID_tipo_empleado` int(11) NOT NULL,
  `nombre_empleado` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_ultimo_login` datetime DEFAULT NULL,
  `estado` varchar(1) NOT NULL,
  `cantidad_operaciones` int(11) DEFAULT '0',
  PRIMARY KEY (`ID_empleado`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleado`
--

LOCK TABLES `empleado` WRITE;
/*!40000 ALTER TABLE `empleado` DISABLE KEYS */;
INSERT INTO `empleado` VALUES (1,5,'Mauricio Cerizza','admin','admin','2018-07-01 00:00:00','2018-07-07 00:00:00','A',13),(4,1,'Mario Rampi','bartender','bartender','2018-07-01 00:00:00','2018-07-08 00:00:00','A',2),(12,5,'Mauricio Dávila','socio','socio','2018-07-04 00:00:00','2018-10-25 21:42:36','A',0),(62,5,'UTN','utn','utn','2018-07-04 00:00:00',NULL,'A',0),(72,4,'Marina Cardozo','mozo','mozo','2018-07-04 00:00:00','2018-10-23 22:55:06','A',18),(82,2,'Matias Ramos','cervecero','cervecero','2018-07-07 00:00:00','2018-07-08 00:00:00','A',0),(92,3,'Mariano Burgos','cocinero','cocinero','2018-07-08 00:00:00','2018-10-25 19:35:38','A',2),(102,4,'Demian \'El Profe\' Boullon','mozo2','mozo2','2018-07-09 22:52:14','2018-07-09 22:53:01','B',0);
/*!40000 ALTER TABLE `empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `encuesta`
--

DROP TABLE IF EXISTS `encuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `encuesta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `puntuacion_mesa` int(11) NOT NULL,
  `codigoMesa` varchar(5) NOT NULL,
  `puntuacion_restaurante` int(11) NOT NULL,
  `puntuacion_mozo` int(11) NOT NULL,
  `idMozo` int(11) NOT NULL,
  `puntuacion_cocinero` int(11) NOT NULL,
  `comentario` varchar(66) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encuesta`
--

LOCK TABLES `encuesta` WRITE;
/*!40000 ALTER TABLE `encuesta` DISABLE KEYS */;
INSERT INTO `encuesta` VALUES (2,7,'MES01',9,6,72,8,'Muy bueno.','2018-07-09 15:56:18'),(12,9,'MES02',10,5,72,7,'Excelente .','2018-07-09 16:01:14'),(22,10,'MES02',10,10,72,10,'El mejor restaurante del mundo :D','2018-07-09 16:01:51'),(32,1,'MES03',1,1,72,1,'El peor restaurante del mundo >:(','2018-07-09 23:36:54');
/*!40000 ALTER TABLE `encuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_pedidos`
--

DROP TABLE IF EXISTS `estado_pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado_pedidos` (
  `id_estado_pedidos` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`id_estado_pedidos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_pedidos`
--

LOCK TABLES `estado_pedidos` WRITE;
/*!40000 ALTER TABLE `estado_pedidos` DISABLE KEYS */;
INSERT INTO `estado_pedidos` VALUES (1,'Pendiente'),(2,'En Preparacion'),(3,'Listo para Servir'),(4,'Entregado'),(5,'Cancelado'),(6,'Finalizado');
/*!40000 ALTER TABLE `estado_pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura` (
  `idFactura` int(11) NOT NULL AUTO_INCREMENT,
  `importe` int(11) NOT NULL,
  `codigoMesa` varchar(5) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`idFactura`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
INSERT INTO `factura` VALUES (2,160,'MES02','2018-07-09 17:00:58'),(12,160,'MES02','2018-07-09 17:02:02'),(22,0,'MES01','2018-07-09 21:35:49'),(32,100,'MES02','2018-07-09 23:33:35');
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `precio` int(11) NOT NULL,
  `id_sector` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (2,'Pizza Muzzarella',178,3),(12,'Milanesa a la Napolitana',90,3),(22,'Cerveza',60,2),(42,'Empanadas',30,3),(52,'Vino',100,1),(62,'Jugo de Naranja',60,1),(72,'Canelones',120,3);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mesa`
--

DROP TABLE IF EXISTS `mesa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mesa` (
  `codigo_mesa` varchar(5) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `foto` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`codigo_mesa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesa`
--

LOCK TABLES `mesa` WRITE;
/*!40000 ALTER TABLE `mesa` DISABLE KEYS */;
INSERT INTO `mesa` VALUES ('MES01','Con cliente esperando pedido','./Fotos/Mesas/MES01..jpg'),('MES02','Cerrada',NULL),('MES03','Cerrada','./Fotos/Mesas/MES03..jpg');
/*!40000 ALTER TABLE `mesa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido` (
  `codigo` varchar(5) NOT NULL,
  `id_estado_pedidos` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicial` time NOT NULL,
  `hora_entrega_estimada` time DEFAULT NULL,
  `hora_entrega_real` time DEFAULT NULL,
  `id_mesa` varchar(5) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_mozo` int(11) NOT NULL,
  `id_encargado` int(11) DEFAULT NULL,
  `nombre_cliente` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
INSERT INTO `pedido` VALUES ('1cvca',6,'2018-07-08','18:03:00','14:58:00','16:41:00','MES02',52,72,4,'Pepe'),('9sq43',4,'2018-07-09','23:36:00','20:07:00','19:58:00','MES03',12,72,92,'Rosa'),('hnr2t',5,'2018-07-09','23:03:00',NULL,NULL,'MES03',12,72,NULL,'Rosa'),('iuypn',5,'2018-07-08','12:22:00',NULL,NULL,'MES01',2,72,NULL,NULL),('j2j0d',6,'2018-07-09','19:42:00',NULL,NULL,'MES02',72,72,NULL,'Pepe'),('mzp34',6,'2018-07-08','17:10:00','14:14:00','14:17:00','MES02',62,72,4,NULL),('ortcx',6,'2018-07-09','18:36:00','23:41:00','23:31:00','MES02',52,72,4,'Pepe'),('p3x50',6,'2018-07-09','19:42:00',NULL,NULL,'MES02',72,72,NULL,'Pepe'),('q1xtm',6,'2018-07-09','19:42:00',NULL,NULL,'MES02',72,72,NULL,'Pepe'),('qdgz8',6,'2018-07-08','17:15:00',NULL,NULL,'MES02',52,72,NULL,NULL),('spk90',1,'2018-07-10','19:53:00',NULL,NULL,'MES03',2,72,NULL,'Jose'),('u8o4e',6,'2018-07-09','18:36:00',NULL,NULL,'MES02',52,72,NULL,'Pepe'),('ua3y8',6,'2018-07-08','17:10:00',NULL,NULL,'MES01',72,72,NULL,NULL),('uxkr5',6,'2018-07-09','18:34:00',NULL,NULL,'MES02',52,72,NULL,'Pepe'),('v3iye',6,'2018-07-09','19:42:00',NULL,NULL,'MES02',72,72,NULL,'Pepe'),('vnzci',6,'2018-07-09','18:33:00',NULL,NULL,'MES02',52,72,NULL,'Pepe'),('zixal',6,'2018-07-08','17:10:00',NULL,NULL,'MES01',22,72,NULL,NULL),('zs1v5',6,'2018-07-09','19:42:00',NULL,NULL,'MES02',72,72,NULL,'Pepe');
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoempleado`
--

DROP TABLE IF EXISTS `tipoempleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoempleado` (
  `ID_tipo_empleado` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(30) NOT NULL,
  `Estado` varchar(1) NOT NULL,
  PRIMARY KEY (`ID_tipo_empleado`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoempleado`
--

LOCK TABLES `tipoempleado` WRITE;
/*!40000 ALTER TABLE `tipoempleado` DISABLE KEYS */;
INSERT INTO `tipoempleado` VALUES (1,'Bartender','A'),(2,'Cervecero','A'),(3,'Cocinero','A'),(4,'Mozo','A'),(5,'Socio','A');
/*!40000 ALTER TABLE `tipoempleado` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-27 13:31:41
