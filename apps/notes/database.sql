CREATE TABLE notes (
  id int PRIMARY KEY AUTO_INCREMENT,
  user_id bigint(20) NOT NULL,
  note_name varchar(255) DEFAULT NULL,
  note_content text DEFAULT NULL,
  row_status tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;