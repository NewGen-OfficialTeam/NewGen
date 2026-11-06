-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: sistema_de_gestion
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `actuacion`
--

DROP TABLE IF EXISTS `actuacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actuacion` (
  `id_actuacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_ticket` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `descripcion_actuacion` text DEFAULT NULL,
  `solucion` text DEFAULT NULL,
  PRIMARY KEY (`id_actuacion`),
  KEY `fk_actuacion_ticket` (`id_ticket`),
  CONSTRAINT `fk_actuacion_ticket` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id_ticket`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actuacion`
--

LOCK TABLES `actuacion` WRITE;
/*!40000 ALTER TABLE `actuacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `actuacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Laptops','Está en malas condiciones pero se puede arreglar'),(2,'Perifericos','Mouses, teclados y accesorios'),(3,'Monitores','Monitores y pantallas LED/IPS'),(4,'Almacenamiento','Discos duros y unidades de estado solido'),(5,'Escritorio','Equipos de escritorio y workstations'),(6,'Impresoras','Impresoras multifuncion y laser');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipo`
--

DROP TABLE IF EXISTS `equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipo` (
  `id_equipo` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `id_marca` int(11) DEFAULT NULL,
  `id_modelo` int(11) DEFAULT NULL,
  `nombre_equipo` varchar(100) NOT NULL,
  `estado` varchar(30) DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  PRIMARY KEY (`id_equipo`),
  KEY `fk_equipo_categoria` (`id_categoria`),
  KEY `fk_equipo_marca` (`id_marca`),
  KEY `fk_equipo_modelo` (`id_modelo`),
  CONSTRAINT `fk_equipo_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`),
  CONSTRAINT `fk_equipo_marca` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id_marca`),
  CONSTRAINT `fk_equipo_modelo` FOREIGN KEY (`id_modelo`) REFERENCES `modelo` (`id_modelo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipo`
--

LOCK TABLES `equipo` WRITE;
/*!40000 ALTER TABLE `equipo` DISABLE KEYS */;
INSERT INTO `equipo` VALUES (1,1,1,9,'Laptop Dell Inspiron 15','Disponible',NULL),(2,2,7,2,'Mouse Logitech M170','En uso',NULL),(3,2,7,3,'Teclado Logitech K120','Disponible',NULL),(4,1,2,1,'HP 14 de Pablito','ARREGLADOOOO','2026-10-08'),(5,4,5,5,'SSD Kingston 480GB','Disponible',NULL),(6,1,6,6,'Lenovo ThinkPad E14','En uso',NULL);
/*!40000 ALTER TABLE `equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_equipo`
--

DROP TABLE IF EXISTS `historial_equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historial_equipo` (
  `id_historial` int(11) NOT NULL AUTO_INCREMENT,
  `id_equipo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_asignacion` date DEFAULT NULL,
  `fecha_devolucion` date DEFAULT NULL,
  PRIMARY KEY (`id_historial`),
  KEY `fk_historial_equipo` (`id_equipo`),
  KEY `fk_historial_usuario` (`id_usuario`),
  CONSTRAINT `fk_historial_equipo` FOREIGN KEY (`id_equipo`) REFERENCES `equipo` (`id_equipo`),
  CONSTRAINT `fk_historial_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_equipo`
--

LOCK TABLES `historial_equipo` WRITE;
/*!40000 ALTER TABLE `historial_equipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `historial_equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marca`
--

DROP TABLE IF EXISTS `marca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marca`
--

LOCK TABLES `marca` WRITE;
/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
INSERT INTO `marca` VALUES (1,'Dell'),(2,'HP'),(3,'Mac'),(4,'LG'),(5,'Kingston'),(6,'Lenovo'),(7,'Logitech');
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modelo`
--

DROP TABLE IF EXISTS `modelo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modelo` (
  `id_modelo` int(11) NOT NULL AUTO_INCREMENT,
  `id_marca` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_modelo`),
  KEY `fk_modelo_marca` (`id_marca`),
  CONSTRAINT `fk_modelo_marca` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modelo`
--

LOCK TABLES `modelo` WRITE;
/*!40000 ALTER TABLE `modelo` DISABLE KEYS */;
INSERT INTO `modelo` VALUES (1,2,'14'),(2,7,'M170'),(3,7,'K120'),(4,4,'24 UltraGear'),(5,5,'A400 480GB'),(6,6,'ThinkPad E14'),(7,2,'LaserJet Pro M404n'),(8,1,'OptiPlex 3080'),(9,1,'Inspiron 15');
/*!40000 ALTER TABLE `modelo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'Admin',NULL),(2,'Técnico',NULL),(3,'Usuario',NULL);
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tecnico`
--

DROP TABLE IF EXISTS `tecnico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tecnico` (
  `id_tecnico` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`id_tecnico`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tecnico`
--

LOCK TABLES `tecnico` WRITE;
/*!40000 ALTER TABLE `tecnico` DISABLE KEYS */;
INSERT INTO `tecnico` VALUES (1,'Técnico','Prueba','tecnico_t@newgen.com','1234','');
/*!40000 ALTER TABLE `tecnico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket` (
  `id_ticket` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_tecnico` int(11) DEFAULT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL,
  `estado` varchar(30) DEFAULT NULL,
  `prioridad` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_ticket`),
  KEY `fk_ticket_usuario` (`id_usuario`),
  KEY `fk_ticket_tecnico` (`id_tecnico`),
  CONSTRAINT `fk_ticket_tecnico` FOREIGN KEY (`id_tecnico`) REFERENCES `tecnico` (`id_tecnico`),
  CONSTRAINT `fk_ticket_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket`
--

LOCK TABLES `ticket` WRITE;
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
INSERT INTO `ticket` VALUES (7,5,1,'Pantalla azul al iniciar','La PC del sector ventas tira un error BSOD al arrancar.','2026-10-08 03:14:18','Abierto','Alta'),(8,5,1,'Instalar AutoCAD','Se necesita la licencia de AutoCAD 2026.','2026-10-08 03:14:18','En Progreso','Media'),(9,5,1,'Teclado no funciona','Varias teclas dejaron de funcionar.','2026-10-08 03:14:18','Abierto','Baja'),(10,4,1,'No funcionan los puertos USB','De un día para el otro mi cable de red dejó de funcionar','2026-10-08 05:21:57','Abierto','Critica'),(11,5,NULL,'Ayuda','No prende la compu','2026-11-06 12:27:26','Abierto','Media');
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_usuario_rol` (`id_rol`),
  CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (2,1,'Admin','','admin@newgen.com','81dc9bdb52d04dc20036dbd8313ed055','Activo'),(4,2,'Técnico','','tecnico@newgen.com','81dc9bdb52d04dc20036dbd8313ed055','Activo'),(5,3,'Usuario','','usuario@newgen.com','81dc9bdb52d04dc20036dbd8313ed055','Activo');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-06  8:33:09
