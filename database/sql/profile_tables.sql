/*
 Navicat MySQL Dump SQL

 Source Server         : baberuka@156.155.253.202
 Source Server Type    : MySQL
 Source Server Version : 80040 (8.0.40-0ubuntu0.22.04.1)
 Source Host           : localhost:3306
 Source Schema         : profilehub_appdb_25

 Target Server Type    : MySQL
 Target Server Version : 80040 (8.0.40-0ubuntu0.22.04.1)
 File Encoding         : 65001

 Date: 30/10/2025 10:39:00
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for user_details
-- ----------------------------
DROP TABLE IF EXISTS `user_details`;
CREATE TABLE `user_details`  (
  `details_id` int NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_bio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `profile_pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`details_id`) USING BTREE,
  UNIQUE INDEX `user_id`(`user_id` ASC) USING BTREE,
  UNIQUE INDEX `username`(`username` ASC) USING BTREE,
  INDEX `user_details_user_bio_index`(`user_bio` ASC) USING BTREE,
  INDEX `firstname`(`firstname` ASC) USING BTREE,
  INDEX `lastname`(`lastname` ASC) USING BTREE,
  INDEX `middle_name`(`middle_name` ASC) USING BTREE,
  INDEX `profile_pic`(`profile_pic` ASC) USING BTREE,
  INDEX `user_avatar`(`user_avatar` ASC) USING BTREE,
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_field
-- ----------------------------
DROP TABLE IF EXISTS `user_field`;
CREATE TABLE `user_field`  (
  `field_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_details` int NULL DEFAULT 0,
  `group_id` int UNSIGNED NULL DEFAULT NULL,
  `type_field` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'eng',
  `translation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sequence` int NULL DEFAULT 0,
  `group_sequence` int NULL DEFAULT NULL,
  `show_on_platform` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'framework,',
  `use_multilang` tinyint(1) NULL DEFAULT 0,
  `create_date` datetime NULL DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`field_id`) USING BTREE,
  INDEX `id_common`(`id_details` ASC) USING BTREE,
  INDEX `group_id`(`group_id` ASC) USING BTREE,
  INDEX `type_field`(`type_field` ASC) USING BTREE,
  INDEX `translation`(`translation` ASC) USING BTREE,
  CONSTRAINT `uf_group_id` FOREIGN KEY (`group_id`) REFERENCES `user_field_groups` (`group_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_field_details
-- ----------------------------
DROP TABLE IF EXISTS `user_field_details`;
CREATE TABLE `user_field_details`  (
  `details_id` int NOT NULL AUTO_INCREMENT,
  `field_id` int UNSIGNED NOT NULL,
  `son_id` int NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL DEFAULT 0,
  `user_entry` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `details_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `create_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`details_id`) USING BTREE,
  UNIQUE INDEX `field_id_user_id`(`field_id` ASC, `user_id` ASC) USING BTREE,
  INDEX `field_id`(`field_id` ASC) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  FULLTEXT INDEX `user_entry`(`user_entry`),
  CONSTRAINT `ufd_field_id` FOREIGN KEY (`field_id`) REFERENCES `user_field` (`field_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `ufd_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_field_details_data
-- ----------------------------
DROP TABLE IF EXISTS `user_field_details_data`;
CREATE TABLE `user_field_details_data`  (
  `data_id` int NOT NULL AUTO_INCREMENT,
  `field_id` int UNSIGNED NOT NULL,
  `son_id` int UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `user_entry` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `user_rows` int NULL DEFAULT NULL,
  `details_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `sequence` int NULL DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`data_id`) USING BTREE,
  INDEX `field_id`(`field_id` ASC) USING BTREE,
  INDEX `son_id`(`son_id` ASC) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  INDEX `sequence`(`sequence` ASC) USING BTREE,
  FULLTEXT INDEX `user_entry`(`user_entry`),
  CONSTRAINT `ufdd_field_id` FOREIGN KEY (`field_id`) REFERENCES `user_field` (`field_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `ufdd_son_id` FOREIGN KEY (`son_id`) REFERENCES `user_field_son` (`son_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `ufdd_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_field_groups
-- ----------------------------
DROP TABLE IF EXISTS `user_field_groups`;
CREATE TABLE `user_field_groups`  (
  `group_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `type_group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `group_icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `group_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sequence` int NULL DEFAULT 0,
  `create_date` datetime NULL DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`group_id`) USING BTREE,
  INDEX `type_group`(`type_group` ASC) USING BTREE,
  INDEX `group_icon`(`group_icon` ASC) USING BTREE,
  INDEX `group_name`(`group_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_field_son
-- ----------------------------
DROP TABLE IF EXISTS `user_field_son`;
CREATE TABLE `user_field_son`  (
  `son_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `field_id` int UNSIGNED NOT NULL DEFAULT 0,
  `lang_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '',
  `translation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `field_type` enum('text','data','json','number','string','dropdown','date','widget') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `field_settings` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sequence` int NULL DEFAULT 0,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `create_date` datetime NULL DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`son_id`) USING BTREE,
  INDEX `field_id`(`field_id` ASC) USING BTREE,
  CONSTRAINT `field_id` FOREIGN KEY (`field_id`) REFERENCES `user_field` (`field_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_field_son_data
-- ----------------------------
DROP TABLE IF EXISTS `user_field_son_data`;
CREATE TABLE `user_field_son_data`  (
  `data_id` int NOT NULL AUTO_INCREMENT,
  `son_id` int NOT NULL DEFAULT 0,
  `data_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `data_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `data_sequence` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `create_date` datetime NULL DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`data_id`) USING BTREE,
  INDEX `field_id`(`son_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_field_type
-- ----------------------------
DROP TABLE IF EXISTS `user_field_type`;
CREATE TABLE `user_field_type`  (
  `type_id` int NOT NULL AUTO_INCREMENT,
  `type_field` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type_class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type_category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'standard',
  `create_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_group_users
-- ----------------------------
DROP TABLE IF EXISTS `user_group_users`;
CREATE TABLE `user_group_users`  (
  `user_group_id` int NOT NULL AUTO_INCREMENT,
  `group_id` int NULL DEFAULT NULL,
  `user_id` int NULL DEFAULT NULL,
  `create_date` datetime NULL DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_group_id`) USING BTREE,
  INDEX `group_id`(`group_id` ASC) USING BTREE,
  CONSTRAINT `group_id` FOREIGN KEY (`group_id`) REFERENCES `user_groups` (`group_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_groups
-- ----------------------------
DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups`  (
  `group_id` int NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `group_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `group_type` enum('user','cluster') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `group_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_date` datetime NULL DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`group_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_input_types
-- ----------------------------
DROP TABLE IF EXISTS `user_input_types`;
CREATE TABLE `user_input_types`  (
  `input_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `input_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `input_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `input_type` enum('html','custom') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'html',
  `create_date` datetime NULL DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`input_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_profiles
-- ----------------------------
DROP TABLE IF EXISTS `user_profiles`;
CREATE TABLE `user_profiles`  (
  `profile_id` int NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `pforce` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `num_rows` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `num_filled` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `create_date` datetime NULL DEFAULT NULL,
  `modified_date` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`profile_id`) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  INDEX `pforce`(`pforce` ASC) USING BTREE,
  INDEX `num_rows`(`num_rows` ASC) USING BTREE,
  INDEX `num_filled`(`num_filled` ASC) USING BTREE,
  CONSTRAINT `up_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
