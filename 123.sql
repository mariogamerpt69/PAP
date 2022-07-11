-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           10.4.24-MariaDB - mariadb.org binary distribution
-- SO do servidor:               Win64
-- HeidiSQL Versão:              12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- A despejar estrutura da base de dados para school
DROP DATABASE IF EXISTS `school`;
CREATE DATABASE IF NOT EXISTS `school` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `school`;

-- A despejar estrutura para tabela school.classroom
DROP TABLE IF EXISTS `classroom`;
CREATE TABLE IF NOT EXISTS `classroom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pavilhao` int(11) NOT NULL,
  `numero` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_classroom_pavilhoes` (`pavilhao`),
  CONSTRAINT `FK_classroom_pavilhoes` FOREIGN KEY (`pavilhao`) REFERENCES `pavilhoes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- A despejar dados para tabela school.classroom: ~0 rows (aproximadamente)
DELETE FROM `classroom`;
INSERT INTO `classroom` (`id`, `pavilhao`, `numero`) VALUES
	(7, 1, '1');

-- A despejar estrutura para tabela school.computers
DROP TABLE IF EXISTS `computers`;
CREATE TABLE IF NOT EXISTS `computers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(50) NOT NULL,
  `room` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identifier` (`identifier`),
  KEY `FK_computers_classroom` (`room`),
  CONSTRAINT `FK_computers_classroom` FOREIGN KEY (`room`) REFERENCES `classroom` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- A despejar dados para tabela school.computers: ~2 rows (aproximadamente)
DELETE FROM `computers`;
INSERT INTO `computers` (`id`, `identifier`, `room`) VALUES
	(4, 'as', 7),
	(6, 'asd', 7);

-- A despejar estrutura para tabela school.material
DROP TABLE IF EXISTS `material`;
CREATE TABLE IF NOT EXISTS `material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `computerid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_material_classroom` (`room`),
  KEY `FK_material_computers` (`computerid`),
  KEY `FK_material_type` (`type`),
  CONSTRAINT `FK_material_classroom` FOREIGN KEY (`room`) REFERENCES `classroom` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_material_computers` FOREIGN KEY (`computerid`) REFERENCES `computers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_material_type` FOREIGN KEY (`type`) REFERENCES `type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

-- A despejar dados para tabela school.material: ~1 rows (aproximadamente)
DELETE FROM `material`;
INSERT INTO `material` (`id`, `name`, `type`, `room`, `computerid`) VALUES
	(16, 'sadq', 1, 7, NULL);

-- A despejar estrutura para tabela school.pavilhoes
DROP TABLE IF EXISTS `pavilhoes`;
CREATE TABLE IF NOT EXISTS `pavilhoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pavilhao` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pavilhao` (`pavilhao`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- A despejar dados para tabela school.pavilhoes: ~3 rows (aproximadamente)
DELETE FROM `pavilhoes`;
INSERT INTO `pavilhoes` (`id`, `pavilhao`) VALUES
	(1, 'A'),
	(2, 'B'),
	(3, 'C');

-- A despejar estrutura para tabela school.permissions
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `perm_id` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`perm_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- A despejar dados para tabela school.permissions: ~3 rows (aproximadamente)
DELETE FROM `permissions`;
INSERT INTO `permissions` (`perm_id`, `type`, `name`) VALUES
	('admin', 'admin', 'Administrador'),
	('owner', 'owner', 'Dono'),
	('user', 'user', 'Utilizador');

-- A despejar estrutura para tabela school.type
DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1002 DEFAULT CHARSET=utf8mb4;

-- A despejar dados para tabela school.type: ~10 rows (aproximadamente)
DELETE FROM `type`;
INSERT INTO `type` (`id`, `type`) VALUES
	(1, 'Memorias'),
	(2, 'Graficas'),
	(3, 'MotherBoards'),
	(4, 'Cabos'),
	(5, 'Fontes'),
	(6, 'Discos'),
	(7, 'Perifericos'),
	(8, 'Processadores'),
	(9, 'Coolers'),
	(999, 'Outros');

-- A despejar estrutura para tabela school.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(50) NOT NULL,
  `perm` varchar(50) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  KEY `FK_users_permissions` (`perm`),
  CONSTRAINT `FK_users_permissions` FOREIGN KEY (`perm`) REFERENCES `permissions` (`perm_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- A despejar dados para tabela school.users: ~2 rows (aproximadamente)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `username`, `password`, `email`, `perm`) VALUES
	(1, 'mario', '$2y$10$JdGSWJAtD6mfDojSmL8aTeefF/hLQ4rD4I4mEl5GmbBMPBmfQrypa', 'mhfgomes18@gmail.com', 'owner'),
	(4, 'leandro', '$2y$10$QX5HD8T.4.MlQ0hf.Y5odeGcx7CgwYA3GKaIiCb/rQmWN81k1n.t6', 'leandro@gmail.com', 'owner');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
