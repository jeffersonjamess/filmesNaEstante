-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.18-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para ra201366435
CREATE DATABASE IF NOT EXISTS `ra201366435` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `ra201366435`;

-- Copiando estrutura para tabela ra201366435.courses
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL,
  `nameCourse` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `dateStart` timestamp NULL DEFAULT NULL,
  `dateFinish` timestamp NULL DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela ra201366435.courses: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` (`id`, `nameCourse`, `description`, `dateStart`, `dateFinish`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Administração', 'Curso de Adm.', '2022-02-01 00:00:00', '2022-06-30 00:00:00', 'A', '2021-09-26 19:15:19', '2021-09-26 19:15:19'),
	(2, 'História da Arte', 'Curso extensivo sobre história da arte', '2022-03-01 00:00:00', '2022-09-21 00:00:00', 'A', '2021-09-26 19:16:01', '2021-09-26 19:16:01'),
	(3, 'Informática Básica', 'Principais fundamentos de informática para adultos.', '2022-02-01 00:00:00', '2022-06-14 00:00:00', 'A', '2021-09-26 19:16:42', '2021-09-26 19:21:45');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;

-- Copiando estrutura para tabela ra201366435.students
CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `password` varchar(80) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `course` int(11) DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_courses_students` (`course`),
  CONSTRAINT `fk_courses_students` FOREIGN KEY (`course`) REFERENCES `courses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela ra201366435.students: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` (`id`, `name`, `email`, `password`, `phone`, `course`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Luciana', 'luciana@email.com', '202cb962ac59075b964b07152d234b70', '(11) 122-3232', 1, 'A', '2021-09-26 19:18:17', '2021-09-26 19:18:17'),
	(2, 'Beatriz', 'bia@email.com', '202cb962ac59075b964b07152d234b70', '(20) 2222-2220', 1, 'A', '2021-09-26 19:18:36', '2021-09-26 19:21:14'),
	(3, 'Renata', 'renata@email.com', '202cb962ac59075b964b07152d234b70', '(12) 12121-2122', 2, 'A', '2021-09-26 19:18:59', '2021-09-26 19:18:59');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
