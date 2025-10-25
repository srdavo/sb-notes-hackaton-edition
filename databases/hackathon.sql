-- --------------------------------------------------------
-- Database: `hackathon`
-- --------------------------------------------------------

-- --------------------------------------------------------
-- Table structure for table `notes`
-- --------------------------------------------------------

CREATE TABLE `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `note_name` varchar(255) DEFAULT NULL,
  `note_content` text DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Optional: Foreign Key Constraint
-- Uncomment if `users` table exists
-- --------------------------------------------------------
-- ALTER TABLE `notes`
--   ADD CONSTRAINT `notes_ibfk_1`
--   FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
--   ON DELETE CASCADE;

COMMIT;
