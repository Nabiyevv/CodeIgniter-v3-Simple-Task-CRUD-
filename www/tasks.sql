-- -------------------------------------------------------------
-- -------------------------------------------------------------
-- TablePlus 1.2.2
--
-- https://tableplus.com/
--
-- Database: demo
-- Generation Time: 2024-12-16 21:41:08.445301
-- -------------------------------------------------------------

CREATE TABLE `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `deadline` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

