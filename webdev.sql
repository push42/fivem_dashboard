/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : webdev

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2023-07-31 03:02:15
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `active_users`
-- ----------------------------
DROP TABLE IF EXISTS `active_users`;
CREATE TABLE `active_users` (
  `count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of active_users
-- ----------------------------
INSERT INTO `active_users` VALUES ('66');

-- ----------------------------
-- Table structure for `chat_messages`
-- ----------------------------
DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `avatar_url` varchar(255) NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `rank` varchar(255) NOT NULL DEFAULT 'team'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


-- ----------------------------
-- Table structure for `security_codes`
-- ----------------------------
DROP TABLE IF EXISTS `security_codes`;
CREATE TABLE `security_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `code_hash` varchar(255) NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `security_codes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `staff_accounts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- ----------------------------
-- Table structure for `support_tickets`
-- ----------------------------
DROP TABLE IF EXISTS `support_tickets`;
CREATE TABLE `support_tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `priority` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ----------------------------
-- Table structure for `user_activity`
-- ----------------------------
DROP TABLE IF EXISTS `user_activity`;
CREATE TABLE `user_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `activity_description` varchar(255) NOT NULL,
  `activity_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `os` varchar(255) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `screen_resolution` varchar(50) NOT NULL,
  `connection_type` varchar(50) NOT NULL,
  `dnt_header` tinyint(1) NOT NULL,
  `local_storage` varchar(50) NOT NULL,
  `session_storage` varchar(50) NOT NULL,
  `cookies` text NOT NULL,
  `reg_date` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- ----------------------------
-- Table structure for `users_online`
-- ----------------------------
DROP TABLE IF EXISTS `users_online`;
CREATE TABLE `users_online` (
  `session_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of users_online
-- ----------------------------
