-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para db_juegos
CREATE DATABASE IF NOT EXISTS `db_juegos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_juegos`;

-- Volcando estructura para tabla db_juegos.tbl_puntajes
CREATE TABLE IF NOT EXISTS `tbl_puntajes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `telephone` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `ticket` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `establishment` varchar(50) DEFAULT NULL,
  `ticket_verificado` int DEFAULT NULL,
  `photo` varchar(50) DEFAULT NULL,
  `score` int NOT NULL,
  `status` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla db_juegos.tbl_puntajes: ~5 rows (aproximadamente)
INSERT INTO `tbl_puntajes` (`id`, `user_name`, `telephone`, `email`, `city`, `state`, `ticket`, `establishment`, `ticket_verificado`, `photo`, `score`, `status`, `date`) VALUES
	(6, 'juan 1', '4771111111', 'juan1@gmail.com', 'leon', 'Guanajuato', 'zzz', 'A', 0, 'zzz.png', 555, 1, '2024-05-20'),
	(7, 'juan 2', '4771111112', 'juan1@gmail.com', 'leon', 'Guanajuato', 'xxx', 'A', 0, 'xxx.png', 3000, 1, '2024-05-21'),
	(8, 'juan 2', '4771111113', 'juan3@gmail.com', 'leon', 'Guanajuato', 'yyy', 'F', 0, 'yyy.png', 100, 1, '2024-05-21'),
	(10, 'juan 7  (2)', '4771111111', 'juan@gmail.com', 'leon', 'Guanajuato', 'bbb', 'A', 0, 'bbb.jpg', 0, 0, '2024-05-23'),
	(16, 'juan 2', '4771111113', 'juan3@gmail.com', 'leon', 'Guanajuato', 'aaa', 'F', 0, 'aaa.png', 1500, 1, '2024-05-21');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
