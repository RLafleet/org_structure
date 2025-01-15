-- Удаление таблиц, если они существуют
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `company_branch`;

-- Создание таблицы company_branch
CREATE TABLE `company_branch` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `workers_count` int unsigned DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `address` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Создание таблицы user
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `branch_id` int unsigned DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sex` enum('male','female') DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `hiring_date` date DEFAULT NULL,
  `position` varchar(200) DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `company_branch` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;