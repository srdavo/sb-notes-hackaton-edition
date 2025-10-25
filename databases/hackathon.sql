-- --------------------------------------------------------
-- Database: hackathon
-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS `hackathon`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `hackathon`;

-- --------------------------------------------------------
-- Table: notes
-- --------------------------------------------------------
CREATE TABLE `notes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT(20) NOT NULL,
  `note_name` VARCHAR(255) DEFAULT NULL,
  `note_content` TEXT DEFAULT NULL,
  `row_status` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: movements
-- --------------------------------------------------------
CREATE TABLE `movements` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT DEFAULT NULL,
  `note_id` INT DEFAULT NULL,
  `quantity` BIGINT DEFAULT NULL,
  `create_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `row_status` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: feelings
-- --------------------------------------------------------
CREATE TABLE `feelings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT DEFAULT NULL,
  `note_id` INT DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

COMMIT;
