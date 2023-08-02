
SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `chat_messages`
-- ----------------------------
DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `avatar_url` varchar(255) NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `rank` varchar(255) NOT NULL DEFAULT 'team',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


-- ----------------------------
-- Table structure for `online_users`
-- ----------------------------
DROP TABLE IF EXISTS `online_users`;
CREATE TABLE `online_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `avatar_url` varchar(255) NOT NULL,
  `last_seen` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table structure for `security_codes`
-- ----------------------------
DROP TABLE IF EXISTS `security_codes`;
CREATE TABLE `security_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of security_codes
-- ----------------------------
INSERT INTO `security_codes` VALUES ('1', '123456789');
INSERT INTO `security_codes` VALUES ('2', '123');
INSERT INTO `security_codes` VALUES ('3', '1234');
INSERT INTO `security_codes` VALUES ('4', '12345');

-- ----------------------------
-- Table structure for `staff_accounts`
-- ----------------------------
DROP TABLE IF EXISTS `staff_accounts`;
CREATE TABLE `staff_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `avatar_url` varchar(255) DEFAULT NULL,
  `security_code_id` int(11) DEFAULT NULL,
  `rank` varchar(50) NOT NULL DEFAULT 'Supporter',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- ----------------------------
-- Table structure for `todo_tasks`
-- ----------------------------
DROP TABLE IF EXISTS `todo_tasks`;
CREATE TABLE `todo_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task` text NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table structure for `user_logs`
-- ----------------------------
DROP TABLE IF EXISTS `user_logs`;
CREATE TABLE `user_logs` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `os` varchar(255) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `dnt_header` tinyint(1) NOT NULL,
  `local_storage` varchar(50) NOT NULL,
  `session_storage` varchar(50) NOT NULL,
  `cookies` text NOT NULL,
  `language` varchar(50) NOT NULL,
  `referrer` varchar(255) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

