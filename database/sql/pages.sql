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

 Date: 29/10/2025 08:18:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for page_data
-- ----------------------------
DROP TABLE IF EXISTS `page_data`;
CREATE TABLE `page_data`  (
  `data_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_id` int UNSIGNED NOT NULL,
  `page_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `page_module` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `page_sequence` int NULL DEFAULT NULL,
  `page_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `create_date` datetime NULL DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`data_id`) USING BTREE,
  INDEX `pgd_page_id`(`page_id` ASC) USING BTREE,
  CONSTRAINT `pgd_page_id` FOREIGN KEY (`page_id`) REFERENCES `pages` (`page_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 536 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of page_data
-- ----------------------------
INSERT INTO `page_data` VALUES (1, 1, 'page_data', 'page_layout', 0, 'two_cards_right', '2022-06-18 12:19:06', '2023-01-15 10:48:40');
INSERT INTO `page_data` VALUES (2, 2, 'page_data', 'page_layout', 0, 'full', '2022-07-06 10:56:54', '2022-07-07 14:50:14');
INSERT INTO `page_data` VALUES (4, 2, 'page_input', '13', 1, '1', '2022-07-07 13:54:44', '2022-07-07 14:53:00');
INSERT INTO `page_data` VALUES (5, 2, 'page_input', '14', 2, '1', '2022-07-07 13:54:44', '2022-07-07 14:53:01');
INSERT INTO `page_data` VALUES (6, 2, 'page_input', '1', 0, '1', '2022-07-07 13:54:44', '2022-07-16 14:15:55');
INSERT INTO `page_data` VALUES (7, 2, 'page_input', '2', 0, '1', '2022-07-07 13:54:44', '2022-07-16 14:15:55');
INSERT INTO `page_data` VALUES (8, 2, 'page_input', '3', 0, '1', '2022-07-07 13:54:44', '2022-07-16 08:58:04');
INSERT INTO `page_data` VALUES (9, 2, 'page_input', '8', 0, '1', '2022-07-07 13:54:45', '2022-07-16 08:58:04');
INSERT INTO `page_data` VALUES (10, 2, 'page_input', '9', 0, '1', '2022-07-07 13:54:45', '2022-07-16 08:58:04');
INSERT INTO `page_data` VALUES (11, 2, 'page_input', '10', 0, '1', '2022-07-07 13:54:45', '2022-07-16 08:58:04');
INSERT INTO `page_data` VALUES (12, 2, 'page_input', '12', 4, '1', '2022-07-07 13:54:45', '2022-07-07 14:53:02');
INSERT INTO `page_data` VALUES (13, 2, 'page_input', '15', 5, '1', '2022-07-07 13:54:45', '2022-07-07 14:53:02');
INSERT INTO `page_data` VALUES (14, 2, 'page_input', '16', 6, '1', '2022-07-07 13:54:45', '2022-07-07 14:53:02');
INSERT INTO `page_data` VALUES (26, 2, 'page_input_settings', 'group_settings', 0, '1', '2022-07-07 14:23:26', '2022-07-07 14:53:02');
INSERT INTO `page_data` VALUES (27, 2, 'page_input_settings', 'sort_order', 0, 'ascending_order', '2022-07-07 14:23:26', '2022-07-07 14:53:02');
INSERT INTO `page_data` VALUES (28, 3, 'page_data', 'page_layout', 0, 'full', '2022-07-07 15:12:44', '2022-07-07 15:12:44');
INSERT INTO `page_data` VALUES (29, 3, 'page_input', '13', 1, '1', '2022-07-07 15:12:44', '2022-07-07 15:12:44');
INSERT INTO `page_data` VALUES (30, 3, 'page_input', '14', 2, '1', '2022-07-07 15:12:45', '2022-07-07 15:12:45');
INSERT INTO `page_data` VALUES (31, 3, 'page_input', '1', 0, '1', '2022-07-07 15:12:45', '2022-07-15 14:29:09');
INSERT INTO `page_data` VALUES (32, 3, 'page_input', '2', 0, '1', '2022-07-07 15:12:45', '2022-07-15 14:29:09');
INSERT INTO `page_data` VALUES (33, 3, 'page_input', '3', 0, '1', '2022-07-07 15:12:45', '2022-07-15 14:29:09');
INSERT INTO `page_data` VALUES (34, 3, 'page_input', '8', 0, '1', '2022-07-07 15:12:45', '2022-07-15 14:29:09');
INSERT INTO `page_data` VALUES (35, 3, 'page_input', '9', 0, '1', '2022-07-07 15:12:45', '2022-07-15 14:29:09');
INSERT INTO `page_data` VALUES (36, 3, 'page_input', '10', 0, '1', '2022-07-07 15:12:45', '2022-07-15 14:29:09');
INSERT INTO `page_data` VALUES (37, 3, 'page_input', '12', 4, '1', '2022-07-07 15:12:46', '2022-07-07 15:12:46');
INSERT INTO `page_data` VALUES (38, 3, 'page_input', '15', 5, '1', '2022-07-07 15:12:46', '2022-07-07 15:12:46');
INSERT INTO `page_data` VALUES (39, 3, 'page_input', '16', 6, '1', '2022-07-07 15:12:46', '2022-07-07 15:12:46');
INSERT INTO `page_data` VALUES (40, 3, 'page_input_settings', 'group_settings', 0, '1', '2022-07-07 15:12:46', '2022-07-16 18:25:09');
INSERT INTO `page_data` VALUES (41, 3, 'page_input_settings', 'sort_order', 0, 'ascending_order', '2022-07-07 15:12:46', '2022-07-16 18:25:09');
INSERT INTO `page_data` VALUES (42, 4, 'page_data', 'page_layout', 0, 'two_cards_left', '2022-07-09 12:37:56', '2022-07-09 12:37:56');
INSERT INTO `page_data` VALUES (43, 5, 'page_data', 'page_layout', 0, 'two_cards_left', '2022-07-09 12:40:06', '2022-07-13 14:08:35');
INSERT INTO `page_data` VALUES (44, 4, 'page_input', '13', 1, '1', '2022-07-09 12:43:54', '2022-07-09 12:43:54');
INSERT INTO `page_data` VALUES (45, 4, 'page_input', '14', 2, '1', '2022-07-09 12:43:54', '2022-07-09 12:43:54');
INSERT INTO `page_data` VALUES (46, 4, 'page_input', '1', 0, '1', '2022-07-09 12:43:54', '2022-07-18 08:12:22');
INSERT INTO `page_data` VALUES (47, 4, 'page_input', '2', 0, '1', '2022-07-09 12:43:54', '2022-07-18 08:12:22');
INSERT INTO `page_data` VALUES (48, 4, 'page_input', '3', 0, '1', '2022-07-09 12:43:54', '2022-07-18 08:12:22');
INSERT INTO `page_data` VALUES (49, 4, 'page_input', '8', 0, '1', '2022-07-09 12:43:54', '2022-07-18 08:12:23');
INSERT INTO `page_data` VALUES (50, 4, 'page_input', '9', 0, '1', '2022-07-09 12:43:54', '2022-07-18 08:12:23');
INSERT INTO `page_data` VALUES (51, 4, 'page_input', '10', 0, '1', '2022-07-09 12:43:54', '2022-07-18 08:12:23');
INSERT INTO `page_data` VALUES (52, 4, 'page_input', '12', 4, '1', '2022-07-09 12:43:54', '2022-07-09 12:43:54');
INSERT INTO `page_data` VALUES (53, 4, 'page_input', '15', 5, '1', '2022-07-09 12:43:55', '2022-07-09 12:43:55');
INSERT INTO `page_data` VALUES (54, 4, 'page_input', '16', 6, '1', '2022-07-09 12:43:55', '2022-07-09 12:43:55');
INSERT INTO `page_data` VALUES (55, 4, 'page_input', '17', 1, '1', '2022-07-09 12:43:55', '2022-07-09 12:43:55');
INSERT INTO `page_data` VALUES (56, 4, 'page_input_settings', 'group_settings', 0, '0', '2022-07-09 12:43:55', '2022-07-09 12:43:55');
INSERT INTO `page_data` VALUES (57, 4, 'page_input_settings', 'sort_order', 0, 'random_order', '2022-07-09 12:43:55', '2022-07-09 12:43:55');
INSERT INTO `page_data` VALUES (58, 5, 'page_input', '13', 1, '1', '2022-07-11 22:44:13', '2022-07-11 22:44:13');
INSERT INTO `page_data` VALUES (59, 5, 'page_input', '14', 2, '1', '2022-07-11 22:44:14', '2022-07-11 22:44:14');
INSERT INTO `page_data` VALUES (60, 5, 'page_input', '1', 0, '1', '2022-07-11 22:44:14', '2022-07-11 23:14:27');
INSERT INTO `page_data` VALUES (61, 5, 'page_input', '2', 0, '1', '2022-07-11 22:44:14', '2022-07-11 23:14:27');
INSERT INTO `page_data` VALUES (62, 5, 'page_input', '3', 0, '1', '2022-07-11 22:44:14', '2022-07-11 23:14:27');
INSERT INTO `page_data` VALUES (63, 5, 'page_input', '8', 0, '1', '2022-07-11 22:44:14', '2022-07-11 23:14:27');
INSERT INTO `page_data` VALUES (64, 5, 'page_input', '9', 0, '1', '2022-07-11 22:44:14', '2022-07-11 23:14:27');
INSERT INTO `page_data` VALUES (65, 5, 'page_input', '10', 0, '1', '2022-07-11 22:44:14', '2022-07-11 23:14:27');
INSERT INTO `page_data` VALUES (66, 5, 'page_input', '12', 4, '1', '2022-07-11 22:44:15', '2022-07-11 22:44:15');
INSERT INTO `page_data` VALUES (67, 5, 'page_input', '15', 5, '1', '2022-07-11 22:44:15', '2022-07-11 22:44:15');
INSERT INTO `page_data` VALUES (68, 5, 'page_input', '16', 6, '1', '2022-07-11 22:44:15', '2022-07-11 22:44:15');
INSERT INTO `page_data` VALUES (69, 5, 'page_input', '17', 1, '1', '2022-07-11 23:18:25', '2022-07-11 23:18:25');
INSERT INTO `page_data` VALUES (70, 5, 'page_input_required', '13', 0, '1', '2022-07-11 23:18:25', '2022-07-11 23:18:25');
INSERT INTO `page_data` VALUES (71, 5, 'page_input_required', '14', 0, '1', '2022-07-11 23:18:25', '2022-07-11 23:18:25');
INSERT INTO `page_data` VALUES (72, 5, 'page_input_required', '1', 0, '1', '2022-07-11 23:18:25', '2022-07-11 23:18:25');
INSERT INTO `page_data` VALUES (73, 5, 'page_input_required', '2', 0, '1', '2022-07-11 23:18:26', '2022-07-11 23:18:26');
INSERT INTO `page_data` VALUES (74, 5, 'page_input_required', '3', 0, '1', '2022-07-11 23:18:26', '2022-07-11 23:18:26');
INSERT INTO `page_data` VALUES (75, 5, 'page_input_required', '8', 0, '1', '2022-07-11 23:18:26', '2022-07-11 23:18:26');
INSERT INTO `page_data` VALUES (76, 5, 'page_input_required', '9', 0, '1', '2022-07-11 23:18:26', '2022-07-11 23:18:26');
INSERT INTO `page_data` VALUES (77, 5, 'page_input_required', '10', 0, '1', '2022-07-11 23:18:26', '2022-07-11 23:18:26');
INSERT INTO `page_data` VALUES (78, 5, 'page_input_required', '12', 0, '1', '2022-07-11 23:18:26', '2022-07-11 23:18:26');
INSERT INTO `page_data` VALUES (79, 5, 'page_input_required', '15', 0, '1', '2022-07-11 23:18:26', '2022-07-11 23:18:26');
INSERT INTO `page_data` VALUES (80, 5, 'page_input_required', '16', 0, '1', '2022-07-11 23:18:26', '2022-07-11 23:18:26');
INSERT INTO `page_data` VALUES (91, 5, 'son_input_settings', '1728', 0, '[{\"multiple_select\":\"2\"},{\"input\":\"dropdown\"},{\"required\":\"1\"}]', '2022-07-11 23:20:08', '2022-07-11 23:48:52');
INSERT INTO `page_data` VALUES (92, 5, 'son_input_settings', '1729', 0, '[{\"data_date_format\":\"YYYY-MM-DD\"},{\"input\":\"date\"},{\"required\":\"1\"}]', '2022-07-11 23:20:09', '2022-07-11 23:48:52');
INSERT INTO `page_data` VALUES (93, 5, 'son_input_settings', '1730', 0, '[{\"data_date_format\":\"YYYY-MM-DD\"},{\"input\":\"date\"},{\"required\":\"1\"}]', '2022-07-11 23:20:09', '2022-07-11 23:48:52');
INSERT INTO `page_data` VALUES (94, 5, 'son_input_settings', '1731', 0, '[{\"input\":\"text\"},{\"required\":\"1\"}]', '2022-07-11 23:20:09', '2022-07-11 23:20:09');
INSERT INTO `page_data` VALUES (95, 5, 'son_input_settings', '1732', 0, '[{\"multiple_select\":\"2\"},{\"input\":\"dropdown\"},{\"required\":\"1\"}]', '2022-07-11 23:20:09', '2022-07-11 23:48:52');
INSERT INTO `page_data` VALUES (96, 5, 'son_input_settings', '1733', 0, '[{\"input\":\"number\"},{\"required\":\"1\"}]', '2022-07-11 23:20:09', '2022-07-11 23:20:09');
INSERT INTO `page_data` VALUES (97, 5, 'son_input_settings', '1734', 0, '[{\"input\":\"text\"},{\"required\":\"1\"}]', '2022-07-11 23:20:09', '2022-07-16 15:42:15');
INSERT INTO `page_data` VALUES (98, 5, 'son_input_settings', '1735', 0, '[{\"input\":\"text\"},{\"required\":\"1\"}]', '2022-07-11 23:20:09', '2022-07-11 23:20:09');
INSERT INTO `page_data` VALUES (99, 5, 'son_input_settings', '1736', 0, '[{\"input\":\"widget\"},{\"widget\":\"dropdown\"},{\"dropdown_value\":\"201|South Africa\"},{\"dropdown_type\":\"state-dropdown\"},{\"required\":\"1\"}]', '2022-07-11 23:20:09', '2022-07-16 15:42:15');
INSERT INTO `page_data` VALUES (100, 5, 'son_input_settings', '1737', 0, '[{\"input\":\"widget\"},{\"widget\":\"dropdown\"},{\"dropdown_value\":\"201|South Africa\"},{\"dropdown_type\":\"country-dropdown\"},{\"required\":\"1\"}]', '2022-07-11 23:20:09', '2022-07-16 15:42:16');
INSERT INTO `page_data` VALUES (111, 5, 'page_input', 'username', 0, '1', '2022-07-13 12:55:23', '2022-07-13 12:55:23');
INSERT INTO `page_data` VALUES (112, 5, 'page_input', 'firstname', 0, '1', '2022-07-13 12:55:24', '2022-07-13 12:55:24');
INSERT INTO `page_data` VALUES (113, 5, 'page_input', 'lastname', 0, '1', '2022-07-13 12:55:24', '2022-07-13 12:55:24');
INSERT INTO `page_data` VALUES (114, 5, 'page_input', 'email', 0, '1', '2022-07-13 12:55:24', '2022-07-13 12:55:24');
INSERT INTO `page_data` VALUES (115, 5, 'page_input', 'password', 0, '1', '2022-07-13 12:55:25', '2022-07-13 12:55:25');
INSERT INTO `page_data` VALUES (116, 5, 'page_input_required', 'username', 0, '1', '2022-07-13 12:55:26', '2022-07-13 12:55:26');
INSERT INTO `page_data` VALUES (117, 5, 'page_input_required', 'firstname', 0, '1', '2022-07-13 12:55:26', '2022-07-13 12:55:26');
INSERT INTO `page_data` VALUES (118, 5, 'page_input_required', 'lastname', 0, '1', '2022-07-13 12:55:26', '2022-07-13 12:55:26');
INSERT INTO `page_data` VALUES (119, 5, 'page_input_required', 'email', 0, '1', '2022-07-13 12:55:27', '2022-07-13 12:55:27');
INSERT INTO `page_data` VALUES (120, 5, 'page_input_required', 'password', 0, '1', '2022-07-13 12:55:27', '2022-07-13 12:55:27');
INSERT INTO `page_data` VALUES (121, 3, 'page_input', 'username', 0, '1', '2022-07-15 14:29:07', '2022-07-16 18:25:08');
INSERT INTO `page_data` VALUES (122, 3, 'page_input', 'name', 0, '0', '2022-07-15 14:29:07', '2022-12-21 12:42:27');
INSERT INTO `page_data` VALUES (123, 3, 'page_input', 'firstname', 0, '1', '2022-07-15 14:29:07', '2022-07-16 18:25:08');
INSERT INTO `page_data` VALUES (124, 3, 'page_input', 'lastname', 0, '1', '2022-07-15 14:29:07', '2022-07-16 18:25:09');
INSERT INTO `page_data` VALUES (125, 3, 'page_input', 'email', 0, '1', '2022-07-15 14:29:07', '2022-07-16 18:25:09');
INSERT INTO `page_data` VALUES (126, 3, 'page_input', 'password', 0, '1', '2022-07-15 14:29:08', '2022-07-16 18:25:09');
INSERT INTO `page_data` VALUES (127, 3, 'page_input', 'menuroles', 0, '0', '2022-07-15 14:29:08', '2022-07-15 14:30:01');
INSERT INTO `page_data` VALUES (128, 3, 'page_input', 'profile_pic', 0, '1', '2022-07-15 14:29:08', '2022-07-16 18:25:09');
INSERT INTO `page_data` VALUES (129, 3, 'page_input', 'user_role', 0, '0', '2022-07-15 14:29:08', '2022-07-15 14:30:01');
INSERT INTO `page_data` VALUES (130, 3, 'page_input', 'user_bio', 0, '0', '2022-07-15 14:29:08', '2022-07-16 18:25:09');
INSERT INTO `page_data` VALUES (131, 3, 'page_input', '17', 1, '1', '2022-07-15 14:29:10', '2022-07-15 14:29:10');
INSERT INTO `page_data` VALUES (132, 3, 'page_input_required', 'username', 0, '1', '2022-07-15 14:29:10', '2022-07-16 18:25:12');
INSERT INTO `page_data` VALUES (133, 3, 'page_input_required', 'name', 0, '1', '2022-07-15 14:29:10', '2022-07-16 18:25:13');
INSERT INTO `page_data` VALUES (134, 3, 'page_input_required', 'firstname', 0, '1', '2022-07-15 14:29:10', '2022-07-16 18:25:13');
INSERT INTO `page_data` VALUES (135, 3, 'page_input_required', 'lastname', 0, '1', '2022-07-15 14:29:10', '2022-07-16 18:25:13');
INSERT INTO `page_data` VALUES (136, 3, 'page_input_required', 'email', 0, '1', '2022-07-15 14:29:11', '2022-07-16 18:25:13');
INSERT INTO `page_data` VALUES (137, 3, 'page_input_required', 'password', 0, '1', '2022-07-15 14:29:11', '2022-07-16 18:25:13');
INSERT INTO `page_data` VALUES (138, 3, 'page_input_required', 'menuroles', 0, '0', '2022-07-15 14:29:11', '2022-07-15 14:30:03');
INSERT INTO `page_data` VALUES (139, 3, 'page_input_required', 'profile_pic', 0, '1', '2022-07-15 14:29:11', '2022-07-16 18:25:13');
INSERT INTO `page_data` VALUES (140, 3, 'page_input_required', 'user_role', 0, '0', '2022-07-15 14:29:11', '2022-07-15 14:30:03');
INSERT INTO `page_data` VALUES (141, 3, 'page_input_required', 'user_bio', 0, '1', '2022-07-15 14:29:11', '2022-07-15 14:29:11');
INSERT INTO `page_data` VALUES (142, 5, 'page_input', 'name', 0, '1', '2022-07-15 14:41:17', '2022-07-15 14:41:17');
INSERT INTO `page_data` VALUES (143, 5, 'page_input', 'menuroles', 0, '0', '2022-07-15 14:41:17', '2022-07-16 18:33:50');
INSERT INTO `page_data` VALUES (144, 5, 'page_input', 'profile_pic', 0, '1', '2022-07-15 14:41:17', '2022-07-15 14:41:17');
INSERT INTO `page_data` VALUES (145, 5, 'page_input', 'user_role', 0, '0', '2022-07-15 14:41:18', '2022-07-16 18:33:50');
INSERT INTO `page_data` VALUES (146, 5, 'page_input', 'user_bio', 0, '1', '2022-07-15 14:41:18', '2022-07-15 14:41:18');
INSERT INTO `page_data` VALUES (147, 5, 'page_input_required', 'name', 0, '1', '2022-07-15 14:41:19', '2022-07-15 14:41:19');
INSERT INTO `page_data` VALUES (148, 5, 'page_input_required', 'menuroles', 0, '1', '2022-07-15 14:41:19', '2022-07-15 14:41:19');
INSERT INTO `page_data` VALUES (149, 5, 'page_input_required', 'profile_pic', 0, '1', '2022-07-15 14:41:19', '2022-07-15 14:41:19');
INSERT INTO `page_data` VALUES (150, 5, 'page_input_required', 'user_role', 0, '1', '2022-07-15 14:41:19', '2022-07-15 14:41:19');
INSERT INTO `page_data` VALUES (151, 5, 'page_input_required', 'user_bio', 0, '1', '2022-07-15 14:41:20', '2022-07-15 14:41:20');
INSERT INTO `page_data` VALUES (152, 2, 'page_input', 'username', 0, '1', '2022-07-16 08:58:02', '2025-01-04 12:44:51');
INSERT INTO `page_data` VALUES (153, 2, 'page_input', 'name', 0, '1', '2022-07-16 08:58:02', '2025-01-04 12:44:51');
INSERT INTO `page_data` VALUES (154, 2, 'page_input', 'firstname', 0, '1', '2022-07-16 08:58:02', '2025-01-04 12:44:51');
INSERT INTO `page_data` VALUES (155, 2, 'page_input', 'lastname', 0, '1', '2022-07-16 08:58:03', '2025-01-04 12:44:51');
INSERT INTO `page_data` VALUES (156, 2, 'page_input', 'email', 0, '1', '2022-07-16 08:58:03', '2025-01-04 12:44:51');
INSERT INTO `page_data` VALUES (157, 2, 'page_input', 'password', 0, '0', '2022-07-16 08:58:03', '2022-07-16 08:58:03');
INSERT INTO `page_data` VALUES (158, 2, 'page_input', 'menuroles', 0, '0', '2022-07-16 08:58:03', '2022-07-16 08:58:03');
INSERT INTO `page_data` VALUES (159, 2, 'page_input', 'profile_pic', 0, '1', '2022-07-16 08:58:03', '2025-01-04 11:19:18');
INSERT INTO `page_data` VALUES (160, 2, 'page_input', 'user_role', 0, '0', '2022-07-16 08:58:03', '2022-07-16 08:58:03');
INSERT INTO `page_data` VALUES (161, 2, 'page_input', 'user_bio', 0, '1', '2022-07-16 08:58:03', '2022-07-16 08:58:03');
INSERT INTO `page_data` VALUES (162, 2, 'page_input', '17', 1, '1', '2022-07-16 08:58:04', '2022-07-16 08:58:04');
INSERT INTO `page_data` VALUES (163, 2, 'page_input_required', 'username', 0, '1', '2022-07-16 08:58:04', '2025-01-04 12:44:51');
INSERT INTO `page_data` VALUES (164, 2, 'page_input_required', 'name', 0, '1', '2022-07-16 08:58:04', '2025-01-04 12:44:51');
INSERT INTO `page_data` VALUES (165, 2, 'page_input_required', 'firstname', 0, '1', '2022-07-16 08:58:05', '2025-01-04 12:44:51');
INSERT INTO `page_data` VALUES (166, 2, 'page_input_required', 'lastname', 0, '1', '2022-07-16 08:58:05', '2025-01-04 12:44:51');
INSERT INTO `page_data` VALUES (167, 2, 'page_input_required', 'email', 0, '1', '2022-07-16 08:58:05', '2025-01-04 12:44:51');
INSERT INTO `page_data` VALUES (168, 2, 'page_input_required', 'password', 0, '0', '2022-07-16 08:58:05', '2022-07-16 09:21:30');
INSERT INTO `page_data` VALUES (169, 2, 'page_input_required', 'menuroles', 0, '0', '2022-07-16 08:58:05', '2022-07-16 09:21:30');
INSERT INTO `page_data` VALUES (170, 2, 'page_input_required', 'profile_pic', 0, '1', '2022-07-16 08:58:05', '2025-01-04 11:19:31');
INSERT INTO `page_data` VALUES (171, 2, 'page_input_required', 'user_role', 0, '0', '2022-07-16 08:58:05', '2022-07-16 09:21:30');
INSERT INTO `page_data` VALUES (172, 2, 'page_input_required', 'user_bio', 0, '1', '2022-07-16 08:58:05', '2022-07-16 08:58:05');
INSERT INTO `page_data` VALUES (173, 2, 'page_input_required', '13', 0, '1', '2022-07-16 08:58:06', '2022-07-16 08:58:06');
INSERT INTO `page_data` VALUES (174, 2, 'page_input_required', '14', 0, '1', '2022-07-16 08:58:06', '2022-07-16 08:58:06');
INSERT INTO `page_data` VALUES (175, 2, 'page_input_required', '1', 0, '1', '2022-07-16 08:58:06', '2022-07-16 08:58:06');
INSERT INTO `page_data` VALUES (176, 2, 'page_input_required', '2', 0, '1', '2022-07-16 08:58:06', '2022-07-16 08:58:06');
INSERT INTO `page_data` VALUES (177, 2, 'page_input_required', '3', 0, '1', '2022-07-16 08:58:06', '2022-07-16 08:58:06');
INSERT INTO `page_data` VALUES (178, 2, 'page_input_required', '8', 0, '1', '2022-07-16 08:58:06', '2022-07-16 08:58:06');
INSERT INTO `page_data` VALUES (179, 2, 'page_input_required', '9', 0, '1', '2022-07-16 08:58:06', '2022-07-16 08:58:06');
INSERT INTO `page_data` VALUES (180, 2, 'page_input_required', '10', 0, '1', '2022-07-16 08:58:07', '2022-07-16 08:58:07');
INSERT INTO `page_data` VALUES (181, 2, 'page_input_required', '12', 0, '1', '2022-07-16 08:58:07', '2022-07-16 08:58:07');
INSERT INTO `page_data` VALUES (182, 2, 'page_input_required', '15', 0, '1', '2022-07-16 08:58:07', '2022-07-16 08:58:07');
INSERT INTO `page_data` VALUES (183, 2, 'page_input_required', '16', 0, '1', '2022-07-16 08:58:07', '2022-07-16 08:58:07');
INSERT INTO `page_data` VALUES (184, 2, 'son_input_settings', '1728', 0, '[{\"multiple_select\":\"2\"},{\"input\":\"dropdown\"},{\"required\":\"0\"}]', '2022-07-16 08:58:07', '2022-07-16 08:58:07');
INSERT INTO `page_data` VALUES (185, 2, 'son_input_settings', '1729', 0, '[{\"data_date_format\":\"YYYY-MM\"},{\"input\":\"date\"},{\"required\":\"0\"}]', '2022-07-16 08:58:07', '2022-07-16 08:58:07');
INSERT INTO `page_data` VALUES (186, 2, 'son_input_settings', '1730', 0, '[{\"data_date_format\":\"YYYY-MM\"},{\"input\":\"date\"},{\"required\":\"0\"}]', '2022-07-16 08:58:07', '2022-07-16 08:58:07');
INSERT INTO `page_data` VALUES (187, 2, 'son_input_settings', '1731', 0, '[{\"input\":\"text\"},{\"required\":\"0\"}]', '2022-07-16 08:58:07', '2022-07-16 08:58:07');
INSERT INTO `page_data` VALUES (188, 2, 'son_input_settings', '1732', 0, '[{\"multiple_select\":\"2\"},{\"input\":\"dropdown\"},{\"required\":\"0\"}]', '2022-07-16 08:58:08', '2022-07-16 08:58:08');
INSERT INTO `page_data` VALUES (189, 2, 'son_input_settings', '1733', 0, '[{\"input\":\"number\"},{\"required\":\"0\"}]', '2022-07-16 08:58:08', '2022-07-16 08:58:08');
INSERT INTO `page_data` VALUES (190, 2, 'son_input_settings', '1734', 0, '[{\"input\":\"text\"},{\"required\":\"0\"}]', '2022-07-16 08:58:08', '2022-07-16 08:58:08');
INSERT INTO `page_data` VALUES (191, 2, 'son_input_settings', '1735', 0, '[{\"input\":\"text\"},{\"required\":\"0\"}]', '2022-07-16 08:58:08', '2022-07-16 08:58:08');
INSERT INTO `page_data` VALUES (192, 2, 'son_input_settings', '1736', 0, '[{\"input\":\"widget\"},{\"widget\":\"dropdown\"},{\"dropdown_value\":\"201|South Africa\"},{\"dropdown_type\":\"state-dropdown\"},{\"required\":\"0\"}]', '2022-07-16 08:58:08', '2022-07-16 08:58:08');
INSERT INTO `page_data` VALUES (193, 2, 'son_input_settings', '1737', 0, '[{\"input\":\"widget\"},{\"widget\":\"dropdown\"},{\"dropdown_value\":\"201|South Africa\"},{\"dropdown_type\":\"country-dropdown\"},{\"required\":\"0\"}]', '2022-07-16 08:58:08', '2022-07-16 08:58:08');
INSERT INTO `page_data` VALUES (194, 2, 'page_input_settings', 'username', 0, '{\"input\":\"text\"}', '2022-07-16 10:42:25', '2022-07-16 11:45:47');
INSERT INTO `page_data` VALUES (195, 2, 'page_input_settings', 'name', 0, '{\"input\":\"text\"}', '2022-07-16 10:42:25', '2022-07-16 11:45:47');
INSERT INTO `page_data` VALUES (196, 2, 'page_input_settings', 'firstname', 0, '{\"input\":\"text\"}', '2022-07-16 10:42:25', '2022-07-16 11:45:47');
INSERT INTO `page_data` VALUES (197, 2, 'page_input_settings', 'lastname', 0, '{\"input\":\"text\"}', '2022-07-16 10:42:26', '2022-07-16 11:45:48');
INSERT INTO `page_data` VALUES (198, 2, 'page_input_settings', 'email', 0, '{\"input\":\"email\"}', '2022-07-16 10:42:26', '2022-07-16 11:45:48');
INSERT INTO `page_data` VALUES (199, 2, 'page_input_settings', 'password', 0, '{\"input\":\"password\"}', '2022-07-16 10:42:26', '2022-07-16 11:45:48');
INSERT INTO `page_data` VALUES (200, 2, 'page_input_settings', 'menuroles', 0, '{\"input\":\"widget\"}', '2022-07-16 10:42:26', '2022-07-16 11:45:48');
INSERT INTO `page_data` VALUES (201, 2, 'page_input_settings', 'profile_pic', 0, '{\"input\":\"image\"}', '2022-07-16 10:42:26', '2022-07-16 14:25:24');
INSERT INTO `page_data` VALUES (202, 2, 'page_input_settings', 'user_role', 0, '{\"input\":\"widget\"}', '2022-07-16 10:42:27', '2022-07-16 11:45:48');
INSERT INTO `page_data` VALUES (203, 2, 'page_input_settings', 'user_bio', 0, '{\"input\":\"textarea\"}', '2022-07-16 10:42:27', '2022-07-16 11:45:48');
INSERT INTO `page_data` VALUES (204, 2, 'page_input_settings', '13', 0, '{\"input\":\"tel\"}', '2022-07-16 11:26:15', '2022-07-16 11:45:49');
INSERT INTO `page_data` VALUES (205, 2, 'page_input_settings', '14', 0, '{\"input\":\"tel\"}', '2022-07-16 11:26:15', '2022-07-16 11:45:49');
INSERT INTO `page_data` VALUES (206, 2, 'page_input_settings', '1', 0, '{\"input\":\"dropdown\"}', '2022-07-16 11:26:15', '2022-07-16 11:26:15');
INSERT INTO `page_data` VALUES (207, 2, 'page_input_settings', '2', 0, '{\"input\":\"dropdown\"}', '2022-07-16 11:26:15', '2022-07-16 11:26:15');
INSERT INTO `page_data` VALUES (208, 2, 'page_input_settings', '3', 0, '{\"input\":\"text\"}', '2022-07-16 11:26:15', '2022-07-16 11:45:49');
INSERT INTO `page_data` VALUES (209, 2, 'page_input_settings', '8', 0, '{\"input\":\"text\"}', '2022-07-16 11:26:15', '2022-07-16 11:45:49');
INSERT INTO `page_data` VALUES (210, 2, 'page_input_settings', '9', 0, '{\"input\":\"text\"}', '2022-07-16 11:26:15', '2022-07-16 11:45:49');
INSERT INTO `page_data` VALUES (211, 2, 'page_input_settings', '10', 0, '{\"input\":\"text\"}', '2022-07-16 11:26:16', '2022-07-16 11:45:50');
INSERT INTO `page_data` VALUES (212, 2, 'page_input_settings', '12', 0, '{\"input\":\"dropdown\"}', '2022-07-16 11:26:16', '2022-07-16 11:26:16');
INSERT INTO `page_data` VALUES (213, 2, 'page_input_settings', '15', 0, '{\"input\":\"text\"}', '2022-07-16 11:26:16', '2022-07-16 11:45:50');
INSERT INTO `page_data` VALUES (214, 2, 'page_input_settings', '16', 0, '{\"input\":\"date\"}', '2022-07-16 11:26:16', '2022-07-16 12:06:43');
INSERT INTO `page_data` VALUES (215, 5, 'group_enabled', '2', 0, '1', '2022-07-16 15:40:58', '2022-07-16 15:40:58');
INSERT INTO `page_data` VALUES (216, 5, 'group_enabled', '3', 0, '1', '2022-07-16 15:40:58', '2022-07-16 15:40:58');
INSERT INTO `page_data` VALUES (217, 5, 'group_enabled', '4', 0, '1', '2022-07-16 15:40:58', '2022-07-16 15:40:58');
INSERT INTO `page_data` VALUES (218, 5, 'group_enabled', '5', 0, '1', '2022-07-16 15:40:59', '2022-07-16 16:45:35');
INSERT INTO `page_data` VALUES (219, 5, 'group_enabled', '6', 0, '1', '2022-07-16 15:40:59', '2022-07-16 15:40:59');
INSERT INTO `page_data` VALUES (220, 5, 'group_enabled', '7', 0, '0', '2022-07-16 15:40:59', '2022-07-16 18:41:28');
INSERT INTO `page_data` VALUES (221, 5, 'group_layout', '2', 0, 'cards', '2022-07-16 15:41:41', '2022-07-16 15:41:41');
INSERT INTO `page_data` VALUES (222, 5, 'group_layout', '3', 0, 'cards', '2022-07-16 15:41:41', '2022-07-16 15:41:41');
INSERT INTO `page_data` VALUES (223, 5, 'group_layout', '4', 0, 'cards', '2022-07-16 15:41:41', '2022-07-16 15:41:41');
INSERT INTO `page_data` VALUES (224, 5, 'group_layout', '5', 0, 'cards', '2022-07-16 15:41:41', '2022-07-16 15:41:41');
INSERT INTO `page_data` VALUES (225, 5, 'group_layout', '6', 0, 'cards', '2022-07-16 15:41:42', '2022-07-16 15:41:42');
INSERT INTO `page_data` VALUES (226, 5, 'group_layout', '7', 0, 'cards', '2022-07-16 15:41:42', '2022-07-16 15:41:42');
INSERT INTO `page_data` VALUES (227, 5, 'group_input', '2', 0, 'col-xl-12 col-lg-12', '2022-07-16 15:41:42', '2022-12-21 11:51:54');
INSERT INTO `page_data` VALUES (228, 5, 'group_input', '3', 0, 'col-xl-12 col-lg-12', '2022-07-16 15:41:42', '2022-12-21 11:51:54');
INSERT INTO `page_data` VALUES (229, 5, 'group_input', '4', 0, 'col-xl-12 col-lg-12', '2022-07-16 15:41:42', '2022-07-16 18:41:28');
INSERT INTO `page_data` VALUES (230, 5, 'group_input', '5', 0, 'col-xl-12 col-lg-12', '2022-07-16 15:41:43', '2022-12-21 11:51:54');
INSERT INTO `page_data` VALUES (231, 5, 'group_input', '6', 0, 'col-xl-12 col-lg-12', '2022-07-16 15:41:43', '2022-12-21 11:51:54');
INSERT INTO `page_data` VALUES (232, 5, 'group_input', '7', 0, 'col-xl-12 col-lg-12', '2022-07-16 15:41:43', '2022-07-16 18:41:29');
INSERT INTO `page_data` VALUES (233, 5, 'page_input_settings', 'username', 0, '{\"input\":\"text\"}', '2022-07-16 15:42:10', '2022-07-16 18:33:50');
INSERT INTO `page_data` VALUES (234, 5, 'page_input_settings', 'name', 0, '{\"input\":\"text\"}', '2022-07-16 15:42:10', '2022-07-16 18:33:50');
INSERT INTO `page_data` VALUES (235, 5, 'page_input_settings', 'firstname', 0, '{\"input\":\"text\"}', '2022-07-16 15:42:11', '2022-07-16 19:15:18');
INSERT INTO `page_data` VALUES (236, 5, 'page_input_settings', 'lastname', 0, '{\"input\":\"text\"}', '2022-07-16 15:42:11', '2022-07-16 18:33:51');
INSERT INTO `page_data` VALUES (237, 5, 'page_input_settings', 'email', 0, '{\"input\":\"email\"}', '2022-07-16 15:42:11', '2022-07-16 18:33:51');
INSERT INTO `page_data` VALUES (238, 5, 'page_input_settings', 'password', 0, '{\"input\":\"password\"}', '2022-07-16 15:42:12', '2022-07-16 18:33:51');
INSERT INTO `page_data` VALUES (239, 5, 'page_input_settings', 'menuroles', 0, '{\"input\":\"widget\"}', '2022-07-16 15:42:12', '2022-07-16 18:33:51');
INSERT INTO `page_data` VALUES (240, 5, 'page_input_settings', 'profile_pic', 0, '{\"input\":\"image\"}', '2022-07-16 15:42:12', '2022-07-16 18:33:51');
INSERT INTO `page_data` VALUES (241, 5, 'page_input_settings', 'user_role', 0, '{\"input\":\"widget\"}', '2022-07-16 15:42:12', '2022-07-16 18:33:51');
INSERT INTO `page_data` VALUES (242, 5, 'page_input_settings', 'user_bio', 0, '{\"input\":\"textarea\"}', '2022-07-16 15:42:12', '2022-07-16 18:33:51');
INSERT INTO `page_data` VALUES (243, 5, 'page_input_settings', '13', 0, '{\"input\":\"button\"}', '2022-07-16 15:42:12', '2022-07-16 15:42:12');
INSERT INTO `page_data` VALUES (244, 5, 'page_input_settings', '14', 0, '{\"input\":\"button\"}', '2022-07-16 15:42:13', '2022-07-16 15:42:13');
INSERT INTO `page_data` VALUES (245, 5, 'page_input_settings', '1', 0, '{\"input\":\"dropdown\"}', '2022-07-16 15:42:14', '2022-07-16 15:42:14');
INSERT INTO `page_data` VALUES (246, 5, 'page_input_settings', '2', 0, '{\"input\":\"dropdown\"}', '2022-07-16 15:42:14', '2022-07-16 15:42:14');
INSERT INTO `page_data` VALUES (247, 5, 'page_input_settings', '3', 0, '{\"input\":\"button\"}', '2022-07-16 15:42:14', '2022-07-16 15:42:14');
INSERT INTO `page_data` VALUES (248, 5, 'page_input_settings', '8', 0, '{\"input\":\"button\"}', '2022-07-16 15:42:14', '2022-07-16 15:42:14');
INSERT INTO `page_data` VALUES (249, 5, 'page_input_settings', '9', 0, '{\"input\":\"button\"}', '2022-07-16 15:42:14', '2022-07-16 15:42:14');
INSERT INTO `page_data` VALUES (250, 5, 'page_input_settings', '10', 0, '{\"input\":\"button\"}', '2022-07-16 15:42:14', '2022-07-16 15:42:14');
INSERT INTO `page_data` VALUES (251, 5, 'page_input_settings', '12', 0, '{\"input\":\"dropdown\"}', '2022-07-16 15:42:14', '2022-07-16 15:42:14');
INSERT INTO `page_data` VALUES (252, 5, 'page_input_settings', '15', 0, '{\"input\":\"button\"}', '2022-07-16 15:42:15', '2022-07-16 15:42:15');
INSERT INTO `page_data` VALUES (253, 5, 'page_input_settings', '16', 0, '{\"input\":\"date\"}', '2022-07-16 15:42:15', '2022-07-16 15:42:15');
INSERT INTO `page_data` VALUES (254, 2, 'group_enabled', '2', 0, '1', '2022-07-16 17:06:54', '2022-07-16 17:06:54');
INSERT INTO `page_data` VALUES (255, 2, 'group_enabled', '3', 0, '1', '2022-07-16 17:06:54', '2022-07-16 17:06:54');
INSERT INTO `page_data` VALUES (256, 2, 'group_enabled', '4', 0, '1', '2022-07-16 17:06:54', '2024-06-22 12:37:19');
INSERT INTO `page_data` VALUES (257, 2, 'group_enabled', '5', 0, '1', '2022-07-16 17:06:54', '2022-07-16 17:06:54');
INSERT INTO `page_data` VALUES (258, 2, 'group_enabled', '6', 0, '0', '2022-07-16 17:06:55', '2024-06-22 12:35:46');
INSERT INTO `page_data` VALUES (259, 2, 'group_enabled', '7', 0, '0', '2022-07-16 17:06:55', '2024-06-22 12:36:13');
INSERT INTO `page_data` VALUES (273, 2, 'group_layout', 'input_layout', 0, 'cards', '2022-07-16 17:43:51', '2022-07-16 17:55:26');
INSERT INTO `page_data` VALUES (274, 2, 'group_layout', 'cols', 0, 'col-xl-4 col-lg-4 col-md-4 col-sm-4', '2022-07-16 17:43:51', '2022-07-16 17:45:39');
INSERT INTO `page_data` VALUES (275, 2, 'group_input', 'cols', 0, 'col-xl-4 col-lg-4 col-md-4 col-sm-4', '2022-07-16 17:55:27', '2022-07-16 17:55:27');
INSERT INTO `page_data` VALUES (276, 5, 'group_layout', 'input_layout', 0, 'cards', '2022-07-16 18:20:27', '2022-07-16 18:20:27');
INSERT INTO `page_data` VALUES (277, 5, 'group_input', 'cols', 0, 'col-xl-12 col-lg-12', '2022-07-16 18:20:27', '2022-07-16 18:28:41');
INSERT INTO `page_data` VALUES (278, 5, 'page_input_settings', 'group_settings', 0, '1', '2022-07-16 18:20:28', '2022-07-16 18:28:42');
INSERT INTO `page_data` VALUES (279, 5, 'page_input_settings', 'sort_order', 0, 'ascending_order', '2022-07-16 18:20:28', '2022-07-16 18:28:42');
INSERT INTO `page_data` VALUES (280, 3, 'group_enabled', '2', 0, '1', '2022-07-16 18:25:07', '2022-07-20 18:18:28');
INSERT INTO `page_data` VALUES (281, 3, 'group_enabled', '3', 0, '1', '2022-07-16 18:25:07', '2022-07-20 18:18:28');
INSERT INTO `page_data` VALUES (282, 3, 'group_enabled', '4', 0, '0', '2022-07-16 18:25:08', '2022-07-20 17:27:31');
INSERT INTO `page_data` VALUES (283, 3, 'group_enabled', '5', 0, '0', '2022-07-16 18:25:08', '2022-07-20 17:27:32');
INSERT INTO `page_data` VALUES (284, 3, 'group_enabled', '6', 0, '0', '2022-07-16 18:25:08', '2022-07-16 18:25:08');
INSERT INTO `page_data` VALUES (285, 3, 'group_enabled', '7', 0, '0', '2022-07-16 18:25:08', '2022-07-16 18:25:08');
INSERT INTO `page_data` VALUES (286, 3, 'group_layout', 'input_layout', 0, 'form-group', '2022-07-16 18:25:08', '2022-07-20 18:00:46');
INSERT INTO `page_data` VALUES (287, 3, 'group_input', 'cols', 0, 'col-xl-12 col-lg-12', '2022-07-16 18:25:08', '2022-07-20 17:27:32');
INSERT INTO `page_data` VALUES (288, 3, 'page_input_settings', 'username', 0, '{\"input\":\"text\"}', '2022-07-16 18:25:10', '2022-07-16 18:25:10');
INSERT INTO `page_data` VALUES (289, 3, 'page_input_settings', 'name', 0, '{\"input\":\"text\"}', '2022-07-16 18:25:10', '2022-07-16 18:25:10');
INSERT INTO `page_data` VALUES (290, 3, 'page_input_settings', 'firstname', 0, '{\"input\":\"text\"}', '2022-07-16 18:25:10', '2022-07-16 18:25:10');
INSERT INTO `page_data` VALUES (291, 3, 'page_input_settings', 'lastname', 0, '{\"input\":\"text\"}', '2022-07-16 18:25:10', '2022-07-16 18:25:10');
INSERT INTO `page_data` VALUES (292, 3, 'page_input_settings', 'email', 0, '{\"input\":\"email\"}', '2022-07-16 18:25:10', '2022-07-16 18:25:10');
INSERT INTO `page_data` VALUES (293, 3, 'page_input_settings', 'password', 0, '{\"input\":\"password\"}', '2022-07-16 18:25:10', '2022-07-16 18:25:10');
INSERT INTO `page_data` VALUES (294, 3, 'page_input_settings', 'menuroles', 0, '{\"input\":\"widget\"}', '2022-07-16 18:25:10', '2022-07-16 18:25:10');
INSERT INTO `page_data` VALUES (295, 3, 'page_input_settings', 'profile_pic', 0, '{\"input\":\"image\"}', '2022-07-16 18:25:10', '2022-07-16 18:25:10');
INSERT INTO `page_data` VALUES (296, 3, 'page_input_settings', 'user_role', 0, '{\"input\":\"widget\"}', '2022-07-16 18:25:11', '2022-07-16 18:25:11');
INSERT INTO `page_data` VALUES (297, 3, 'page_input_settings', 'user_bio', 0, '{\"input\":\"textarea\"}', '2022-07-16 18:25:11', '2022-07-16 18:25:11');
INSERT INTO `page_data` VALUES (298, 3, 'page_input_settings', '13', 0, '{\"input\":\"button\"}', '2022-07-16 18:25:11', '2022-07-16 18:25:11');
INSERT INTO `page_data` VALUES (299, 3, 'page_input_settings', '14', 0, '{\"input\":\"button\"}', '2022-07-16 18:25:11', '2022-07-16 18:25:11');
INSERT INTO `page_data` VALUES (300, 3, 'page_input_settings', '1', 0, '{\"input\":\"dropdown\"}', '2022-07-16 18:25:11', '2022-07-16 18:25:11');
INSERT INTO `page_data` VALUES (301, 3, 'page_input_settings', '2', 0, '{\"input\":\"dropdown\"}', '2022-07-16 18:25:11', '2022-07-16 18:25:11');
INSERT INTO `page_data` VALUES (302, 3, 'page_input_settings', '3', 0, '{\"input\":\"button\"}', '2022-07-16 18:25:12', '2022-07-16 18:25:12');
INSERT INTO `page_data` VALUES (303, 3, 'page_input_settings', '8', 0, '{\"input\":\"button\"}', '2022-07-16 18:25:12', '2022-07-16 18:25:12');
INSERT INTO `page_data` VALUES (304, 3, 'page_input_settings', '9', 0, '{\"input\":\"button\"}', '2022-07-16 18:25:12', '2022-07-16 18:25:12');
INSERT INTO `page_data` VALUES (305, 3, 'page_input_settings', '10', 0, '{\"input\":\"button\"}', '2022-07-16 18:25:12', '2022-07-16 18:25:12');
INSERT INTO `page_data` VALUES (306, 3, 'page_input_settings', '12', 0, '{\"input\":\"dropdown\"}', '2022-07-16 18:25:12', '2022-07-16 18:25:12');
INSERT INTO `page_data` VALUES (307, 3, 'page_input_settings', '15', 0, '{\"input\":\"button\"}', '2022-07-16 18:25:12', '2022-07-16 18:25:12');
INSERT INTO `page_data` VALUES (308, 3, 'page_input_settings', '16', 0, '{\"input\":\"date\"}', '2022-07-16 18:25:12', '2022-07-16 18:25:12');
INSERT INTO `page_data` VALUES (309, 3, 'page_input_required', '13', 0, '1', '2022-07-16 18:25:13', '2022-07-16 18:25:13');
INSERT INTO `page_data` VALUES (310, 3, 'page_input_required', '14', 0, '1', '2022-07-16 18:25:14', '2022-07-16 18:25:14');
INSERT INTO `page_data` VALUES (311, 3, 'page_input_required', '1', 0, '1', '2022-07-16 18:25:14', '2022-07-16 18:25:14');
INSERT INTO `page_data` VALUES (312, 3, 'page_input_required', '2', 0, '1', '2022-07-16 18:25:14', '2022-07-16 18:25:14');
INSERT INTO `page_data` VALUES (313, 3, 'page_input_required', '3', 0, '1', '2022-07-16 18:25:14', '2022-07-16 18:25:14');
INSERT INTO `page_data` VALUES (314, 3, 'page_input_required', '8', 0, '1', '2022-07-16 18:25:14', '2022-07-16 18:25:14');
INSERT INTO `page_data` VALUES (315, 3, 'page_input_required', '9', 0, '1', '2022-07-16 18:25:14', '2022-07-16 18:25:14');
INSERT INTO `page_data` VALUES (316, 3, 'page_input_required', '10', 0, '1', '2022-07-16 18:25:14', '2022-07-16 18:25:14');
INSERT INTO `page_data` VALUES (317, 3, 'page_input_required', '12', 0, '1', '2022-07-16 18:25:14', '2022-07-16 18:25:14');
INSERT INTO `page_data` VALUES (318, 3, 'page_input_required', '15', 0, '1', '2022-07-16 18:25:15', '2022-07-16 18:25:15');
INSERT INTO `page_data` VALUES (319, 3, 'page_input_required', '16', 0, '1', '2022-07-16 18:25:15', '2022-07-16 18:25:15');
INSERT INTO `page_data` VALUES (320, 3, 'son_input_settings', '1728', 0, '[{\"multiple_select\":\"2\"},{\"input\":\"dropdown\"},{\"required\":\"0\"}]', '2022-07-16 18:25:15', '2022-07-16 18:25:15');
INSERT INTO `page_data` VALUES (321, 3, 'son_input_settings', '1729', 0, '[{\"data_date_format\":\"YYYY-MM\"},{\"input\":\"date\"},{\"required\":\"0\"}]', '2022-07-16 18:25:15', '2022-07-16 18:25:15');
INSERT INTO `page_data` VALUES (322, 3, 'son_input_settings', '1730', 0, '[{\"data_date_format\":\"YYYY-MM\"},{\"input\":\"date\"},{\"required\":\"0\"}]', '2022-07-16 18:25:15', '2022-07-16 18:25:15');
INSERT INTO `page_data` VALUES (323, 3, 'son_input_settings', '1731', 0, '[{\"input\":\"text\"},{\"required\":\"0\"}]', '2022-07-16 18:25:15', '2022-07-16 18:25:15');
INSERT INTO `page_data` VALUES (324, 3, 'son_input_settings', '1732', 0, '[{\"multiple_select\":\"2\"},{\"input\":\"dropdown\"},{\"required\":\"0\"}]', '2022-07-16 18:25:15', '2022-07-16 18:25:15');
INSERT INTO `page_data` VALUES (325, 3, 'son_input_settings', '1733', 0, '[{\"input\":\"number\"},{\"required\":\"0\"}]', '2022-07-16 18:25:16', '2022-07-16 18:25:16');
INSERT INTO `page_data` VALUES (326, 3, 'son_input_settings', '1734', 0, '[{\"input\":\"text\"},{\"required\":\"0\"}]', '2022-07-16 18:25:16', '2022-07-16 18:25:16');
INSERT INTO `page_data` VALUES (327, 3, 'son_input_settings', '1735', 0, '[{\"input\":\"text\"},{\"required\":\"0\"}]', '2022-07-16 18:25:16', '2022-07-16 18:25:16');
INSERT INTO `page_data` VALUES (328, 3, 'son_input_settings', '1736', 0, '[{\"input\":\"widget\"},{\"widget\":\"dropdown\"},{\"dropdown_value\":\"201|South Africa\"},{\"dropdown_type\":\"state-dropdown\"},{\"required\":\"0\"}]', '2022-07-16 18:25:16', '2022-07-16 18:25:16');
INSERT INTO `page_data` VALUES (329, 3, 'son_input_settings', '1737', 0, '[{\"input\":\"widget\"},{\"widget\":\"dropdown\"},{\"dropdown_value\":\"201|South Africa\"},{\"dropdown_type\":\"country-dropdown\"},{\"required\":\"0\"}]', '2022-07-16 18:25:16', '2022-07-16 18:25:16');
INSERT INTO `page_data` VALUES (330, 5, 'group_enabled', 'default', 0, '1', '2022-07-16 19:24:13', '2022-07-16 19:24:13');
INSERT INTO `page_data` VALUES (331, 5, 'group_input', 'default', 0, 'col-xl-6 col-lg-6 col-md-6 col-sm-12', '2022-07-16 19:24:13', '2022-07-16 19:24:13');
INSERT INTO `page_data` VALUES (332, 2, 'group_enabled', 'default', 0, '0', '2022-07-16 19:38:24', '2022-07-16 19:38:24');
INSERT INTO `page_data` VALUES (333, 2, 'group_input', 'default', 0, 'col-xl-12 col-lg-12', '2022-07-16 19:38:24', '2022-07-16 19:38:24');
INSERT INTO `page_data` VALUES (334, 2, 'group_input', '2', 0, 'col-xl-4 col-lg-4 col-md-4 col-sm-4', '2022-07-16 19:38:25', '2022-12-21 12:33:51');
INSERT INTO `page_data` VALUES (335, 2, 'group_input', '3', 0, 'col-xl-4 col-lg-4 col-md-4 col-sm-4', '2022-07-16 19:38:25', '2022-12-21 12:33:51');
INSERT INTO `page_data` VALUES (336, 2, 'group_input', '4', 0, 'col-xl-4 col-lg-4 col-md-4 col-sm-4', '2022-07-16 19:38:25', '2022-12-21 12:33:51');
INSERT INTO `page_data` VALUES (337, 2, 'group_input', '5', 0, 'col-xl-4 col-lg-4 col-md-4 col-sm-4', '2022-07-16 19:38:25', '2022-12-21 12:33:51');
INSERT INTO `page_data` VALUES (338, 2, 'group_input', '6', 0, 'col-xl-4 col-lg-4 col-md-4 col-sm-4', '2022-07-16 19:38:25', '2022-12-21 12:33:51');
INSERT INTO `page_data` VALUES (339, 2, 'group_input', '7', 0, 'col-xl-4 col-lg-4 col-md-4 col-sm-4', '2022-07-16 19:38:25', '2022-07-16 19:38:25');
INSERT INTO `page_data` VALUES (340, 4, 'group_enabled', 'default', 0, '1', '2022-07-18 08:12:14', '2022-07-18 08:12:14');
INSERT INTO `page_data` VALUES (341, 4, 'group_enabled', '2', 0, '1', '2022-07-18 08:12:15', '2022-07-18 09:50:01');
INSERT INTO `page_data` VALUES (342, 4, 'group_enabled', '3', 0, '1', '2022-07-18 08:12:15', '2022-07-18 09:50:01');
INSERT INTO `page_data` VALUES (343, 4, 'group_enabled', '4', 0, '1', '2022-07-18 08:12:15', '2022-07-18 09:50:02');
INSERT INTO `page_data` VALUES (344, 4, 'group_enabled', '5', 0, '1', '2022-07-18 08:12:15', '2022-07-18 09:50:02');
INSERT INTO `page_data` VALUES (345, 4, 'group_enabled', '6', 0, '1', '2022-07-18 08:12:16', '2022-07-18 09:50:02');
INSERT INTO `page_data` VALUES (346, 4, 'group_enabled', '7', 0, '0', '2022-07-18 08:12:16', '2022-07-18 08:12:16');
INSERT INTO `page_data` VALUES (347, 4, 'group_layout', 'input_layout', 0, 'cards', '2022-07-18 08:12:16', '2022-07-18 08:12:16');
INSERT INTO `page_data` VALUES (348, 4, 'group_input', 'cols', 0, 'col-xl-12 col-lg-12', '2022-07-18 08:12:16', '2022-07-18 08:12:16');
INSERT INTO `page_data` VALUES (349, 4, 'group_input', 'default', 0, 'col-xl-6 col-lg-6 col-md-6 col-sm-12', '2022-07-18 08:12:17', '2022-07-18 08:46:48');
INSERT INTO `page_data` VALUES (350, 4, 'group_input', '2', 0, 'col-xl-6 col-lg-6 col-md-6 col-sm-12', '2022-07-18 08:12:17', '2022-07-18 09:50:02');
INSERT INTO `page_data` VALUES (351, 4, 'group_input', '3', 0, 'col-xl-6 col-lg-6 col-md-6 col-sm-12', '2022-07-18 08:12:17', '2022-07-18 09:50:03');
INSERT INTO `page_data` VALUES (352, 4, 'group_input', '4', 0, 'col-xl-6 col-lg-6 col-md-6 col-sm-12', '2022-07-18 08:12:17', '2022-07-18 09:50:03');
INSERT INTO `page_data` VALUES (353, 4, 'group_input', '5', 0, 'col-xl-6 col-lg-6 col-md-6 col-sm-12', '2022-07-18 08:12:18', '2022-07-18 09:50:03');
INSERT INTO `page_data` VALUES (354, 4, 'group_input', '6', 0, 'col-xl-4 col-lg-4 col-md-4 col-sm-4', '2022-07-18 08:12:18', '2022-07-18 09:50:03');
INSERT INTO `page_data` VALUES (355, 4, 'group_input', '7', 0, 'col-xl-12 col-lg-12', '2022-07-18 08:12:18', '2022-07-18 08:12:18');
INSERT INTO `page_data` VALUES (356, 4, 'page_input', 'username', 0, '1', '2022-07-18 08:12:19', '2022-07-18 08:12:19');
INSERT INTO `page_data` VALUES (357, 4, 'page_input', 'name', 0, '1', '2022-07-18 08:12:19', '2022-07-18 08:12:19');
INSERT INTO `page_data` VALUES (358, 4, 'page_input', 'firstname', 0, '1', '2022-07-18 08:12:19', '2022-07-18 08:12:19');
INSERT INTO `page_data` VALUES (359, 4, 'page_input', 'lastname', 0, '1', '2022-07-18 08:12:19', '2022-07-18 08:12:19');
INSERT INTO `page_data` VALUES (360, 4, 'page_input', 'email', 0, '1', '2022-07-18 08:12:20', '2022-07-18 08:12:20');
INSERT INTO `page_data` VALUES (361, 4, 'page_input', 'password', 0, '0', '2022-07-18 08:12:20', '2022-07-18 08:13:48');
INSERT INTO `page_data` VALUES (362, 4, 'page_input', 'menuroles', 0, '0', '2022-07-18 08:12:20', '2022-07-18 08:13:49');
INSERT INTO `page_data` VALUES (363, 4, 'page_input', 'profile_pic', 0, '1', '2022-07-18 08:12:21', '2022-07-18 08:12:21');
INSERT INTO `page_data` VALUES (364, 4, 'page_input', 'user_role', 0, '1', '2022-07-18 08:12:21', '2022-07-18 08:12:21');
INSERT INTO `page_data` VALUES (365, 4, 'page_input', 'user_bio', 0, '1', '2022-07-18 08:12:21', '2022-07-18 08:12:21');
INSERT INTO `page_data` VALUES (366, 4, 'page_input_settings', 'username', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:24', '2022-07-18 08:12:24');
INSERT INTO `page_data` VALUES (367, 4, 'page_input_settings', 'name', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:24', '2022-07-18 08:12:24');
INSERT INTO `page_data` VALUES (368, 4, 'page_input_settings', 'firstname', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:24', '2022-07-18 08:12:24');
INSERT INTO `page_data` VALUES (369, 4, 'page_input_settings', 'lastname', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:24', '2022-07-18 08:12:24');
INSERT INTO `page_data` VALUES (370, 4, 'page_input_settings', 'email', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:25', '2022-07-18 08:12:25');
INSERT INTO `page_data` VALUES (371, 4, 'page_input_settings', 'password', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:25', '2022-07-18 08:12:25');
INSERT INTO `page_data` VALUES (372, 4, 'page_input_settings', 'menuroles', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:25', '2022-07-18 08:12:25');
INSERT INTO `page_data` VALUES (373, 4, 'page_input_settings', 'profile_pic', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:25', '2022-07-18 08:12:25');
INSERT INTO `page_data` VALUES (374, 4, 'page_input_settings', 'user_role', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:26', '2022-07-18 08:12:26');
INSERT INTO `page_data` VALUES (375, 4, 'page_input_settings', 'user_bio', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:26', '2022-07-18 08:12:26');
INSERT INTO `page_data` VALUES (376, 4, 'page_input_settings', '13', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:26', '2022-07-18 08:12:26');
INSERT INTO `page_data` VALUES (377, 4, 'page_input_settings', '14', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:26', '2022-07-18 08:12:26');
INSERT INTO `page_data` VALUES (378, 4, 'page_input_settings', '1', 0, '{\"input\":\"dropdown\"}', '2022-07-18 08:12:27', '2022-07-18 08:12:27');
INSERT INTO `page_data` VALUES (379, 4, 'page_input_settings', '2', 0, '{\"input\":\"dropdown\"}', '2022-07-18 08:12:27', '2022-07-18 08:12:27');
INSERT INTO `page_data` VALUES (380, 4, 'page_input_settings', '3', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:27', '2022-07-18 08:12:27');
INSERT INTO `page_data` VALUES (381, 4, 'page_input_settings', '8', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:27', '2022-07-18 08:12:27');
INSERT INTO `page_data` VALUES (382, 4, 'page_input_settings', '9', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:28', '2022-07-18 08:12:28');
INSERT INTO `page_data` VALUES (383, 4, 'page_input_settings', '10', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:28', '2022-07-18 08:12:28');
INSERT INTO `page_data` VALUES (384, 4, 'page_input_settings', '12', 0, '{\"input\":\"dropdown\"}', '2022-07-18 08:12:28', '2022-07-18 08:12:28');
INSERT INTO `page_data` VALUES (385, 4, 'page_input_settings', '15', 0, '{\"input\":\"button\"}', '2022-07-18 08:12:28', '2022-07-18 08:12:28');
INSERT INTO `page_data` VALUES (386, 4, 'page_input_settings', '16', 0, '{\"input\":\"date\"}', '2022-07-18 08:12:29', '2022-07-18 08:12:29');
INSERT INTO `page_data` VALUES (387, 4, 'page_input_required', 'username', 0, '1', '2022-07-18 08:12:29', '2022-07-18 08:12:29');
INSERT INTO `page_data` VALUES (388, 4, 'page_input_required', 'name', 0, '1', '2022-07-18 08:12:29', '2022-07-18 08:12:29');
INSERT INTO `page_data` VALUES (389, 4, 'page_input_required', 'firstname', 0, '1', '2022-07-18 08:12:30', '2022-07-18 08:12:30');
INSERT INTO `page_data` VALUES (390, 4, 'page_input_required', 'lastname', 0, '1', '2022-07-18 08:12:30', '2022-07-18 08:12:30');
INSERT INTO `page_data` VALUES (391, 4, 'page_input_required', 'email', 0, '1', '2022-07-18 08:12:30', '2022-07-18 08:12:30');
INSERT INTO `page_data` VALUES (392, 4, 'page_input_required', 'password', 0, '1', '2022-07-18 08:12:30', '2022-07-18 08:12:30');
INSERT INTO `page_data` VALUES (393, 4, 'page_input_required', 'menuroles', 0, '1', '2022-07-18 08:12:30', '2022-07-18 08:12:30');
INSERT INTO `page_data` VALUES (394, 4, 'page_input_required', 'profile_pic', 0, '1', '2022-07-18 08:12:31', '2022-07-18 08:12:31');
INSERT INTO `page_data` VALUES (395, 4, 'page_input_required', 'user_role', 0, '1', '2022-07-18 08:12:31', '2022-07-18 08:12:31');
INSERT INTO `page_data` VALUES (396, 4, 'page_input_required', 'user_bio', 0, '1', '2022-07-18 08:12:31', '2022-07-18 08:12:31');
INSERT INTO `page_data` VALUES (397, 4, 'page_input_required', '13', 0, '1', '2022-07-18 08:12:31', '2022-07-18 08:12:31');
INSERT INTO `page_data` VALUES (398, 4, 'page_input_required', '14', 0, '1', '2022-07-18 08:12:32', '2022-07-18 08:12:32');
INSERT INTO `page_data` VALUES (399, 4, 'page_input_required', '1', 0, '1', '2022-07-18 08:12:32', '2022-07-18 08:12:32');
INSERT INTO `page_data` VALUES (400, 4, 'page_input_required', '2', 0, '1', '2022-07-18 08:12:32', '2022-07-18 08:12:32');
INSERT INTO `page_data` VALUES (401, 4, 'page_input_required', '3', 0, '1', '2022-07-18 08:12:32', '2022-07-18 08:12:32');
INSERT INTO `page_data` VALUES (402, 4, 'page_input_required', '8', 0, '1', '2022-07-18 08:12:32', '2022-07-18 08:12:32');
INSERT INTO `page_data` VALUES (403, 4, 'page_input_required', '9', 0, '1', '2022-07-18 08:12:33', '2022-07-18 08:12:33');
INSERT INTO `page_data` VALUES (404, 4, 'page_input_required', '10', 0, '1', '2022-07-18 08:12:33', '2022-07-18 08:12:33');
INSERT INTO `page_data` VALUES (405, 4, 'page_input_required', '12', 0, '1', '2022-07-18 08:12:33', '2022-07-18 08:12:33');
INSERT INTO `page_data` VALUES (406, 4, 'page_input_required', '15', 0, '1', '2022-07-18 08:12:33', '2022-07-18 08:12:33');
INSERT INTO `page_data` VALUES (407, 4, 'page_input_required', '16', 0, '1', '2022-07-18 08:12:34', '2022-07-18 08:12:34');
INSERT INTO `page_data` VALUES (408, 4, 'son_input_settings', '1728', 0, '[{\"multiple_select\":\"2\"},{\"input\":\"dropdown\"},{\"required\":\"0\"}]', '2022-07-18 08:12:34', '2022-07-18 08:12:34');
INSERT INTO `page_data` VALUES (409, 4, 'son_input_settings', '1729', 0, '[{\"data_date_format\":\"YYYY-MM\"},{\"input\":\"date\"},{\"required\":\"0\"}]', '2022-07-18 08:12:34', '2022-07-18 08:12:34');
INSERT INTO `page_data` VALUES (410, 4, 'son_input_settings', '1730', 0, '[{\"data_date_format\":\"YYYY-MM\"},{\"input\":\"date\"},{\"required\":\"0\"}]', '2022-07-18 08:12:34', '2022-07-18 08:12:34');
INSERT INTO `page_data` VALUES (411, 4, 'son_input_settings', '1731', 0, '[{\"input\":\"text\"},{\"required\":\"0\"}]', '2022-07-18 08:12:35', '2022-07-18 08:12:35');
INSERT INTO `page_data` VALUES (412, 4, 'son_input_settings', '1732', 0, '[{\"multiple_select\":\"2\"},{\"input\":\"dropdown\"},{\"required\":\"0\"}]', '2022-07-18 08:12:36', '2022-07-18 08:12:36');
INSERT INTO `page_data` VALUES (413, 4, 'son_input_settings', '1733', 0, '[{\"input\":\"number\"},{\"required\":\"0\"}]', '2022-07-18 08:12:37', '2022-07-18 08:12:37');
INSERT INTO `page_data` VALUES (414, 4, 'son_input_settings', '1734', 0, '[{\"input\":\"text\"},{\"required\":\"0\"}]', '2022-07-18 08:12:37', '2022-07-18 08:12:37');
INSERT INTO `page_data` VALUES (415, 4, 'son_input_settings', '1735', 0, '[{\"input\":\"text\"},{\"required\":\"0\"}]', '2022-07-18 08:12:37', '2022-07-18 08:12:37');
INSERT INTO `page_data` VALUES (416, 4, 'son_input_settings', '1736', 0, '[{\"input\":\"widget\"},{\"widget\":\"dropdown\"},{\"dropdown_value\":\"201|South Africa\"},{\"dropdown_type\":\"state-dropdown\"},{\"required\":\"0\"}]', '2022-07-18 08:12:38', '2022-07-18 08:12:38');
INSERT INTO `page_data` VALUES (417, 4, 'son_input_settings', '1737', 0, '[{\"input\":\"widget\"},{\"widget\":\"dropdown\"},{\"dropdown_value\":\"201|South Africa\"},{\"dropdown_type\":\"country-dropdown\"},{\"required\":\"0\"}]', '2022-07-18 08:12:38', '2022-07-18 08:12:38');
INSERT INTO `page_data` VALUES (512, 3, 'group_enabled', 'default', 0, '1', '2022-07-20 17:27:30', '2022-07-20 17:27:30');
INSERT INTO `page_data` VALUES (513, 3, 'group_input', 'default', 0, 'col-xl-12 col-lg-12', '2022-07-20 17:27:33', '2022-07-20 17:27:33');
INSERT INTO `page_data` VALUES (514, 3, 'group_input', '2', 0, 'col-xl-12 col-lg-12', '2022-07-20 17:27:33', '2022-07-20 18:00:46');
INSERT INTO `page_data` VALUES (515, 3, 'group_input', '3', 0, 'col-xl-12 col-lg-12', '2022-07-20 17:27:33', '2022-07-20 18:00:46');
INSERT INTO `page_data` VALUES (516, 3, 'group_input', '4', 0, 'col-xl-12 col-lg-12', '2022-07-20 17:27:33', '2022-07-20 18:00:46');
INSERT INTO `page_data` VALUES (517, 3, 'group_input', '5', 0, 'col-xl-12 col-lg-12', '2022-07-20 17:27:33', '2022-07-20 18:00:47');
INSERT INTO `page_data` VALUES (518, 3, 'group_input', '6', 0, 'col-xl-12 col-lg-12', '2022-07-20 17:27:34', '2022-07-20 18:00:47');
INSERT INTO `page_data` VALUES (519, 3, 'group_input', '7', 0, 'col-xl-12 col-lg-12', '2022-07-20 17:27:34', '2022-07-20 18:00:47');
INSERT INTO `page_data` VALUES (529, 3, 'page_input_settings', 'registration_type', 0, '4', '2023-10-17 05:01:30', '2023-10-17 05:01:30');
INSERT INTO `page_data` VALUES (530, 2, 'page_input', 'middle_name', 0, '1', '2025-01-04 11:19:18', '2025-01-04 11:19:18');
INSERT INTO `page_data` VALUES (531, 2, 'page_input', 'user_avatar', 0, '0', '2025-01-04 11:19:18', '2025-01-04 11:19:18');
INSERT INTO `page_data` VALUES (532, 2, 'page_input_settings', 'middle_name', 0, '{\"input\":\"button\"}', '2025-01-04 11:19:18', '2025-01-04 11:19:18');
INSERT INTO `page_data` VALUES (533, 2, 'page_input_settings', 'user_avatar', 0, '{\"input\":\"image\"}', '2025-01-04 11:19:18', '2025-01-04 11:19:18');
INSERT INTO `page_data` VALUES (534, 2, 'page_input_required', 'middle_name', 0, '0', '2025-01-04 11:19:18', '2025-01-04 12:44:51');
INSERT INTO `page_data` VALUES (535, 2, 'page_input_required', 'user_avatar', 0, '1', '2025-01-04 11:19:18', '2025-01-04 11:19:18');

-- ----------------------------
-- Table structure for page_modules
-- ----------------------------
DROP TABLE IF EXISTS `page_modules`;
CREATE TABLE `page_modules`  (
  `module_id` int NOT NULL AUTO_INCREMENT,
  `page_id` int UNSIGNED NULL DEFAULT NULL,
  `group_id` int NOT NULL,
  `setting_id` int NULL DEFAULT NULL,
  `has_widget` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '2',
  `widget_order` int NULL DEFAULT NULL,
  `widget_type` enum('public','admin','user','profile') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'user',
  `module_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `mudule_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `module_icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `module_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `module_active` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`module_id`) USING BTREE,
  INDEX `pm_page_id`(`page_id` ASC) USING BTREE,
  CONSTRAINT `pm_page_id` FOREIGN KEY (`page_id`) REFERENCES `pages` (`page_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of page_modules
-- ----------------------------
INSERT INTO `page_modules` VALUES (1, 1, 2, NULL, '2', 4, 'profile', 'Profile', '_PROFILE', 'fa-user-circle-o', '<p>User Profile module</p>', '2', '2025-01-04 10:52:29', '2023-01-15 08:48:40');
INSERT INTO `page_modules` VALUES (2, NULL, 2, NULL, '2', 3, 'admin', 'User Management', '_USER_MANAGEMENT', 'fa-users', '<p>User management module</p>', '2', '2025-01-04 10:52:29', '2023-01-15 08:48:40');

-- ----------------------------
-- Table structure for page_widgets
-- ----------------------------
DROP TABLE IF EXISTS `page_widgets`;
CREATE TABLE `page_widgets`  (
  `widget_id` int NOT NULL AUTO_INCREMENT,
  `page_id` int UNSIGNED NOT NULL,
  `page_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `widget_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `widget_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `widget_active` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '0',
  `widget_order` int NULL DEFAULT NULL,
  `create_date` datetime NULL DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`widget_id`) USING BTREE,
  INDEX `pw_page_id`(`page_id` ASC) USING BTREE,
  CONSTRAINT `pw_page_id` FOREIGN KEY (`page_id`) REFERENCES `pages` (`page_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 133 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of page_widgets
-- ----------------------------
INSERT INTO `page_widgets` VALUES (4, 1, 'page_module', '_PROFILE', NULL, '0', 4, '2022-06-16 15:13:15', '2025-01-04 10:52:29');
INSERT INTO `page_widgets` VALUES (5, 1, 'page_module', '_PAYMENT_PLAN', NULL, '0', 19, '2022-06-16 15:13:15', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (6, 1, 'page_module', '_ACCOUNT_STATEMENT', NULL, '0', 20, '2022-06-16 15:13:15', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (7, 1, 'page_module', '_DOCUMENTS', NULL, '0', 14, '2022-06-16 15:13:15', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (8, 1, 'page_module', '_FORUMS', NULL, '0', 10, '2022-06-16 15:13:15', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (9, 1, 'page_module', '_ANNOUNCEMENTS', '2', '0', 5, '2022-06-16 15:13:15', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (10, 1, 'page_module', '_LEARNING', NULL, '0', 11, '2022-06-16 15:13:15', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (11, 1, 'page_module', '_NOTES', '2', '0', 8, '2022-06-16 15:13:16', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (12, 1, 'page_module', '_GAMIFICATION', '2', '0', 17, '2022-06-16 15:13:16', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (13, 1, 'page_col', '_PROFILE', 'left_col', '0', NULL, '2022-06-16 15:13:16', '2022-06-18 09:07:38');
INSERT INTO `page_widgets` VALUES (14, 1, 'page_col', '_PAYMENT_PLAN', 'left_col', '0', NULL, '2022-06-16 15:13:16', '2022-06-18 09:07:38');
INSERT INTO `page_widgets` VALUES (15, 1, 'page_col', '_ACCOUNT_STATEMENT', 'left_col', '0', NULL, '2022-06-16 15:13:16', '2022-06-18 09:07:39');
INSERT INTO `page_widgets` VALUES (16, 1, 'page_col', '_DOCUMENTS', 'left_col', '0', NULL, '2022-06-16 15:13:16', '2022-06-18 09:07:39');
INSERT INTO `page_widgets` VALUES (17, 1, 'page_col', '_FORUMS', 'left_col', '0', NULL, '2022-06-16 15:13:16', '2022-06-18 09:07:39');
INSERT INTO `page_widgets` VALUES (18, 1, 'page_col', '_ANNOUNCEMENTS', 'right_col', '0', NULL, '2022-06-16 15:13:16', '2022-06-18 15:56:21');
INSERT INTO `page_widgets` VALUES (19, 1, 'page_col', '_LEARNING', 'left_col', '0', NULL, '2022-06-16 15:13:17', '2022-06-18 09:07:39');
INSERT INTO `page_widgets` VALUES (20, 1, 'page_col', '_NOTES', 'right_col', '0', NULL, '2022-06-16 15:13:17', '2022-06-18 15:56:21');
INSERT INTO `page_widgets` VALUES (21, 1, 'page_col', '_GAMIFICATION', 'right_col', '0', NULL, '2022-06-16 15:13:17', '2022-06-18 15:56:21');
INSERT INTO `page_widgets` VALUES (22, 1, 'page_row', '_PROFILE', 'col-xl-3 col-lg-3 col-md-3 col-sm-3', '0', NULL, '2022-06-16 15:13:17', '2022-06-18 09:58:07');
INSERT INTO `page_widgets` VALUES (23, 1, 'page_row', '_PAYMENT_PLAN', 'col-xl-3 col-lg-3 col-md-3 col-sm-3', '0', NULL, '2022-06-16 15:13:17', '2022-06-18 09:58:07');
INSERT INTO `page_widgets` VALUES (24, 1, 'page_row', '_ACCOUNT_STATEMENT', 'col-xl-3 col-lg-3 col-md-3 col-sm-3', '0', NULL, '2022-06-16 15:13:17', '2022-06-18 09:58:07');
INSERT INTO `page_widgets` VALUES (25, 1, 'page_row', '_DOCUMENTS', 'col-xl-3 col-lg-3 col-md-3 col-sm-3', '0', NULL, '2022-06-16 15:13:17', '2022-06-18 09:58:07');
INSERT INTO `page_widgets` VALUES (26, 1, 'page_row', '_FORUMS', 'col-xl-3 col-lg-3 col-md-3 col-sm-3', '0', NULL, '2022-06-16 15:13:17', '2022-06-18 09:58:07');
INSERT INTO `page_widgets` VALUES (27, 1, 'page_row', '_ANNOUNCEMENTS', 'col-xl-12 col-lg-12', '0', NULL, '2022-06-16 15:13:18', '2022-06-18 09:57:24');
INSERT INTO `page_widgets` VALUES (28, 1, 'page_row', '_LEARNING', 'col-xl-3 col-lg-3 col-md-3 col-sm-3', '0', NULL, '2022-06-16 15:13:18', '2022-06-18 09:58:07');
INSERT INTO `page_widgets` VALUES (29, 1, 'page_row', '_NOTES', 'col-xl-6 col-lg-6 col-md-6 col-sm-12', '0', NULL, '2022-06-16 15:13:18', '2022-06-18 14:20:14');
INSERT INTO `page_widgets` VALUES (30, 1, 'page_row', '_GAMIFICATION', 'col-xl-6 col-lg-6 col-md-6 col-sm-12', '0', NULL, '2022-06-16 15:13:18', '2022-06-18 15:57:10');
INSERT INTO `page_widgets` VALUES (31, 1, 'page_module', '_DEFAULT', '2', '0', NULL, '2022-06-18 13:56:52', '2022-06-18 13:56:52');
INSERT INTO `page_widgets` VALUES (32, 1, 'page_col', '_DEFAULT', 'left_col_right_col', '0', NULL, '2022-06-18 13:56:52', '2022-06-18 15:56:20');
INSERT INTO `page_widgets` VALUES (33, 1, 'page_row', '_DEFAULT', 'col-xl-12 col-lg-12', '0', NULL, '2022-06-18 13:56:52', '2022-06-18 13:56:52');
INSERT INTO `page_widgets` VALUES (100, 1, 'page_module', '_USER_MANAGEMENT', NULL, '0', NULL, '2023-01-15 10:48:39', '2023-01-15 10:48:39');
INSERT INTO `page_widgets` VALUES (101, 1, 'page_module', '_COURSE_MANAGEMENT', NULL, '0', NULL, '2023-01-15 10:48:39', '2023-01-15 10:48:39');
INSERT INTO `page_widgets` VALUES (102, 1, 'page_module', '_FORUM_MANAGEMENT', NULL, '0', NULL, '2023-01-15 10:48:39', '2023-01-15 10:48:39');
INSERT INTO `page_widgets` VALUES (103, 1, 'page_module', '_GAMIFICATION_MANAGEMENT', NULL, '0', NULL, '2023-01-15 10:48:39', '2023-01-15 10:48:39');
INSERT INTO `page_widgets` VALUES (104, 1, 'page_module', '_DOCUMENT_MANAGEMENT', NULL, '0', NULL, '2023-01-15 10:48:39', '2023-01-15 10:48:39');
INSERT INTO `page_widgets` VALUES (105, 1, 'page_module', '_ANNOUNCEMENT_MANAGEMENT', NULL, '0', NULL, '2023-01-15 10:48:39', '2023-01-15 10:48:39');
INSERT INTO `page_widgets` VALUES (106, 1, 'page_module', '_SETTINGS_MANAGEMENT', NULL, '0', NULL, '2023-01-15 10:48:39', '2023-01-15 10:48:39');
INSERT INTO `page_widgets` VALUES (107, 1, 'page_module', '_MESSAGE_MANAGEMENT', NULL, '0', 4, '2023-01-15 10:48:39', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (108, 1, 'page_module', '_CHAT_MANAGEMENT', NULL, '0', 3, '2023-01-15 10:48:39', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (109, 1, 'page_module', '_REPORT_MANAGEMENT', NULL, '0', 2, '2023-01-15 10:48:39', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (110, 1, 'page_module', '_REPORTS', NULL, '0', 1, '2023-01-15 10:48:39', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (111, 1, 'page_col', '_USER_MANAGEMENT', 'left_col', '0', NULL, '2023-01-15 10:48:39', '2023-01-15 10:48:39');
INSERT INTO `page_widgets` VALUES (112, 1, 'page_col', '_COURSE_MANAGEMENT', 'left_col', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (113, 1, 'page_col', '_FORUM_MANAGEMENT', 'left_col', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (114, 1, 'page_col', '_GAMIFICATION_MANAGEMENT', 'left_col', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (115, 1, 'page_col', '_DOCUMENT_MANAGEMENT', 'left_col', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (116, 1, 'page_col', '_ANNOUNCEMENT_MANAGEMENT', 'left_col', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (117, 1, 'page_col', '_SETTINGS_MANAGEMENT', 'left_col', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (118, 1, 'page_col', '_MESSAGE_MANAGEMENT', 'left_col', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (119, 1, 'page_col', '_CHAT_MANAGEMENT', 'left_col', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (120, 1, 'page_col', '_REPORT_MANAGEMENT', 'left_col', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (121, 1, 'page_col', '_REPORTS', 'right_col', '0', NULL, '2023-01-15 10:48:40', '2025-01-04 10:52:37');
INSERT INTO `page_widgets` VALUES (122, 1, 'page_row', '_USER_MANAGEMENT', 'col-xl-12 col-lg-12', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (123, 1, 'page_row', '_COURSE_MANAGEMENT', 'col-xl-12 col-lg-12', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (124, 1, 'page_row', '_FORUM_MANAGEMENT', 'col-xl-12 col-lg-12', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (125, 1, 'page_row', '_GAMIFICATION_MANAGEMENT', 'col-xl-12 col-lg-12', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (126, 1, 'page_row', '_DOCUMENT_MANAGEMENT', 'col-xl-12 col-lg-12', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (127, 1, 'page_row', '_ANNOUNCEMENT_MANAGEMENT', 'col-xl-12 col-lg-12', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (128, 1, 'page_row', '_SETTINGS_MANAGEMENT', 'col-xl-12 col-lg-12', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (129, 1, 'page_row', '_MESSAGE_MANAGEMENT', 'col-xl-12 col-lg-12', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (130, 1, 'page_row', '_CHAT_MANAGEMENT', 'col-xl-12 col-lg-12', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (131, 1, 'page_row', '_REPORT_MANAGEMENT', 'col-xl-12 col-lg-12', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');
INSERT INTO `page_widgets` VALUES (132, 1, 'page_row', '_REPORTS', 'col-xl-12 col-lg-12', '0', NULL, '2023-01-15 10:48:40', '2023-01-15 10:48:40');

-- ----------------------------
-- Table structure for pages
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages`  (
  `page_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `page_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `page_tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `page_type` int NULL DEFAULT NULL,
  `page_admin` int NULL DEFAULT NULL,
  `page_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `page_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `linked_page` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `page_settings` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `create_date` datetime NULL DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`page_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES (1, 'user-dashboard', 'User Dashboard', '', NULL, 1, 1, NULL, NULL, NULL, 'user_dashboard', '2022-06-13 19:55:31', '2022-06-18 11:46:02');
INSERT INTO `pages` VALUES (2, 'force-profile', 'Force Profile', NULL, NULL, 1, 1, NULL, NULL, NULL, 'force_profile', '2022-06-13 20:19:55', '2022-07-07 14:14:54');
INSERT INTO `pages` VALUES (3, 'user-registration', 'User Registration', NULL, NULL, 1, 1, NULL, NULL, NULL, 'user_registration', '2022-06-13 20:20:35', '2022-07-07 15:12:30');
INSERT INTO `pages` VALUES (4, 'profile-dashboard', 'Profile Dashboard', NULL, NULL, 1, 1, 'Profile Page', NULL, NULL, 'profile_dashboard', '2022-07-09 12:31:28', '2022-07-09 12:37:56');
INSERT INTO `pages` VALUES (5, 'profile-management', 'Profile Management', NULL, NULL, 1, 1, 'Profile Management Page', NULL, NULL, 'profile_management', '2022-07-09 12:31:45', '2022-07-09 12:40:06');

SET FOREIGN_KEY_CHECKS = 1;
