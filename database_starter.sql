/*
 Navicat Premium Data Transfer

 Source Server         : DB Local
 Source Server Type    : MySQL
 Source Server Version : 50724 (5.7.24)
 Source Host           : localhost:3306
 Source Schema         : db_hanindyamom

 Target Server Type    : MySQL
 Target Server Version : 50724 (5.7.24)
 File Encoding         : 65001

 Date: 10/09/2025 09:58:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama_menu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `menus_parent_id_foreign`(`parent_id`) USING BTREE,
  CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES (1, 'bb5e49c9-5c7b-4840-bb4b-b48a96e8a260', 'user.index', 'ti ti-user', 'User', 5, '2025-02-18 02:01:15', '2025-07-02 14:35:11', 13);
INSERT INTO `menus` VALUES (2, '6ee7d0a1-4aca-4cc5-ba7b-7eb636977c57', 'settings.edit', 'ti ti-settings', 'Pengaturan', NULL, '2025-02-18 02:10:08', '2025-07-02 14:35:11', 21);
INSERT INTO `menus` VALUES (3, '9b1c00d5-5b6b-4161-b976-87a6da9573d1', 'role.index', 'ti ti-shield', 'Role', 5, '2025-02-18 02:10:58', '2025-07-02 14:35:11', 14);
INSERT INTO `menus` VALUES (4, '1f2f5340-6912-42da-9331-ab768c5d44ee', 'menu.index', 'ti ti-list', 'Menu', 5, '2025-02-18 02:15:39', '2025-07-02 14:35:11', 15);
INSERT INTO `menus` VALUES (5, 'f602469c-7303-4df9-9164-76ba63e2a5b0', '#', 'ti ti-key', 'Autentikasi', NULL, '2025-02-18 02:17:37', '2025-07-02 14:35:11', 12);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (9, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (10, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` VALUES (11, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (12, '2025_02_18_013140_create_settings_table', 1);
INSERT INTO `migrations` VALUES (13, '2025_02_18_014202_create_permission_tables', 1);
INSERT INTO `migrations` VALUES (14, '2025_02_18_015415_create_menus_table', 2);
INSERT INTO `migrations` VALUES (15, '2025_02_18_015517_create_role_menus_table', 2);
INSERT INTO `migrations` VALUES (16, '2025_02_18_031243_create_divisis_table', 3);
INSERT INTO `migrations` VALUES (17, '2025_02_18_031322_create_jabatans_table', 3);
INSERT INTO `migrations` VALUES (19, '2025_02_18_040607_create_radii_table', 5);
INSERT INTO `migrations` VALUES (21, '2025_02_18_034610_create_shifts_table', 6);
INSERT INTO `migrations` VALUES (22, '2025_02_18_061406_create_jam_kerjas_table', 6);
INSERT INTO `migrations` VALUES (23, '2025_02_19_005354_create_divisi_shifts_table', 6);
INSERT INTO `migrations` VALUES (34, '2025_02_20_034830_create_pegawai_masters_table', 7);
INSERT INTO `migrations` VALUES (35, '2025_02_22_011112_create_pegawai_shifts_table', 8);
INSERT INTO `migrations` VALUES (36, '2025_02_24_014835_create_presensis_table', 8);
INSERT INTO `migrations` VALUES (37, '2025_02_24_032535_create_personal_access_tokens_table', 9);
INSERT INTO `migrations` VALUES (38, '2025_02_24_033112_create_o_t_p_verifications_table', 10);
INSERT INTO `migrations` VALUES (41, '2025_02_25_005648_create_user_photos_table', 11);
INSERT INTO `migrations` VALUES (42, '2025_05_14_041214_create_proporsi_fairness_table', 12);
INSERT INTO `migrations` VALUES (43, '2025_05_14_044119_create_grade_table', 13);
INSERT INTO `migrations` VALUES (44, '2025_05_14_050000_create_sumbers_table', 14);
INSERT INTO `migrations` VALUES (45, '2025_05_14_050000_create_sumber_table', 15);
INSERT INTO `migrations` VALUES (46, '2024_01_15_create_remunerasi_batch_table', 16);
INSERT INTO `migrations` VALUES (47, '2024_01_15_create_remunerasi_source_table', 17);
INSERT INTO `migrations` VALUES (48, '2024_03_19_000001_create_detail_source_table', 18);
INSERT INTO `migrations` VALUES (50, '2024_03_19_000002_create_pembagian_klaim_table', 19);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 'App\\Models\\User', 1);
INSERT INTO `model_has_roles` VALUES (1, 'App\\Models\\User', 14);

-- ----------------------------
-- Table structure for o_t_p_verifications
-- ----------------------------
DROP TABLE IF EXISTS `o_t_p_verifications`;
CREATE TABLE `o_t_p_verifications`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomor_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `o_t_p_verifications_nomor_hp_unique`(`nomor_hp`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of o_t_p_verifications
-- ----------------------------

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for pegawai_masters
-- ----------------------------
DROP TABLE IF EXISTS `pegawai_masters`;
CREATE TABLE `pegawai_masters`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan_id` int(11) NOT NULL,
  `divisi_id` int(11) NOT NULL,
  `status` enum('aktif','non_aktif') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_user` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pegawai_masters
-- ----------------------------
INSERT INTO `pegawai_masters` VALUES (1, 'b4d0cdd1-0e39-4b27-849d-0df3155e4818', '3507182109970003', 'MUHAMMAD NAJMUL FAIZ', 3, 4, 'aktif', '2025-02-24 03:07:41', '2025-02-25 01:38:41', 7);
INSERT INTO `pegawai_masters` VALUES (2, '37c0a26c-4f71-4f3c-8744-86f078cce64f', '3318121902790001', 'THOMAS FREDY ERVAN ANANTO, S.Kom', 3, 4, 'aktif', '2025-02-24 03:07:41', '2025-02-24 03:07:41', NULL);
INSERT INTO `pegawai_masters` VALUES (3, 'c1494f04-1aca-49ce-998d-2e0ab712f8e2', '3318082502800001', 'VERRY KARLIYANTO, S.Kom', 3, 4, 'aktif', '2025-02-24 03:07:41', '2025-02-24 03:07:41', NULL);
INSERT INTO `pegawai_masters` VALUES (4, '9f1e0f55-cb12-4006-ada1-461a5e0d8d72', '3318154812760001', 'PUJI DYAH HASTUTI', 3, 4, 'aktif', '2025-02-24 03:07:41', '2025-02-24 03:07:41', NULL);
INSERT INTO `pegawai_masters` VALUES (5, 'ed480de3-63e9-4b30-b35f-474cef9ae579', '3318172912870001', 'BUDI CAHYONO', 3, 4, 'aktif', '2025-02-24 03:07:41', '2025-02-24 03:07:41', NULL);
INSERT INTO `pegawai_masters` VALUES (6, '3b72b1e8-1b1a-47bd-9528-a29d5df2ce5c', '3309132109880002', 'EKO YUDHATAMA NUR ASLAM', 3, 4, 'aktif', '2025-02-24 03:07:42', '2025-02-25 01:43:11', 8);
INSERT INTO `pegawai_masters` VALUES (7, 'bf7d8c59-4b9c-4567-8394-06b4c824bf1b', '3318104703830008', 'PUJI UTAMI, SKM', 3, 4, 'aktif', '2025-02-24 03:07:42', '2025-02-24 03:07:42', NULL);
INSERT INTO `pegawai_masters` VALUES (10, '24720db6-2a11-4e8c-9ca0-610f6d19c53e', '3318107011720003', 'ATIK ENDROATI NAWANGSRI, A.Md', 3, 4, 'aktif', '2025-02-24 03:07:42', '2025-02-24 03:07:42', NULL);
INSERT INTO `pegawai_masters` VALUES (12, '1137f965-aacd-43a7-8569-f4557e7cb780', '3324192910880001', 'SETYO EDYATMO, SE', 3, 3, 'aktif', '2025-02-25 14:41:44', '2025-02-27 14:27:17', 9);

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_name_guard_name_unique`(`name`, `guard_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permissions
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 43 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------
INSERT INTO `personal_access_tokens` VALUES (1, 'App\\Models\\User', 2, 'authToken', '30641497cdec3064c2e72e35a018c6c4070b57993f0191a347b35949549e4c9e', '[\"*\"]', NULL, NULL, '2025-02-24 03:52:00', '2025-02-24 03:52:00');
INSERT INTO `personal_access_tokens` VALUES (2, 'App\\Models\\User', 3, 'authToken', '7c9b7ca10f5c11ca20dd55b4191a575c67b8ca699bfe64b4a42896684114afff', '[\"*\"]', NULL, NULL, '2025-02-24 03:58:17', '2025-02-24 03:58:17');
INSERT INTO `personal_access_tokens` VALUES (3, 'App\\Models\\User', 4, 'authToken', '0eef9bd1cfdd0a8128809afcae30bf074b76e5d892870e46cb9353fe9e6b0e9c', '[\"*\"]', NULL, NULL, '2025-02-24 04:03:57', '2025-02-24 04:03:57');
INSERT INTO `personal_access_tokens` VALUES (4, 'App\\Models\\User', 5, 'authToken', 'bc38dac7770925ee1defd7e9cf55db8dd0bef148a4dc820778d2bdff176e312e', '[\"*\"]', NULL, NULL, '2025-02-24 04:05:15', '2025-02-24 04:05:15');
INSERT INTO `personal_access_tokens` VALUES (5, 'App\\Models\\User', 5, 'authToken', '2a4deb38e9b1ddf2910e1d812efdcdad7293b92534a5717fa941c24d233e05bf', '[\"*\"]', '2025-02-24 04:14:57', NULL, '2025-02-24 04:10:41', '2025-02-24 04:14:57');
INSERT INTO `personal_access_tokens` VALUES (6, 'App\\Models\\User', 5, 'authToken', 'bdd15a4a80d9dd08d8364113e18c8ae18d2f30b9dd1cef2adbef538155279ee1', '[\"*\"]', NULL, NULL, '2025-02-24 04:15:12', '2025-02-24 04:15:12');
INSERT INTO `personal_access_tokens` VALUES (7, 'App\\Models\\User', 5, 'authToken', '3b2371ec0ce8fba1e8b29cbf764190afeccf6d9b1a0b35a8e3b7e1b5c60dde5a', '[\"*\"]', NULL, NULL, '2025-02-24 04:15:52', '2025-02-24 04:15:52');
INSERT INTO `personal_access_tokens` VALUES (8, 'App\\Models\\User', 5, 'authToken', 'bb0f10e0d483ce21c095fe7a27eaf07fee236b0401aeba3a41c5435017a40fbf', '[\"*\"]', NULL, NULL, '2025-02-24 04:20:34', '2025-02-24 04:20:34');
INSERT INTO `personal_access_tokens` VALUES (9, 'App\\Models\\User', 5, 'authToken', '7cc5049f5ae7ebf98e810abff59d33a34623c6e104d340d56170fd4672dab55c', '[\"*\"]', NULL, NULL, '2025-02-24 04:23:23', '2025-02-24 04:23:23');
INSERT INTO `personal_access_tokens` VALUES (10, 'App\\Models\\User', 5, 'authToken', '63aa120907b715696c6a4522def5c30f995509378ec7102932181776942b9cb9', '[\"*\"]', '2025-02-24 04:26:45', NULL, '2025-02-24 04:23:43', '2025-02-24 04:26:45');
INSERT INTO `personal_access_tokens` VALUES (11, 'App\\Models\\User', 6, 'authToken', 'e362804cdf53090006872845c1c45d03838a5e6f73f98d9d1c2cda3215cdd859', '[\"*\"]', '2025-02-25 01:22:38', NULL, '2025-02-24 04:29:07', '2025-02-25 01:22:38');
INSERT INTO `personal_access_tokens` VALUES (12, 'App\\Models\\User', 7, 'authToken', '040dba3f735cf4e3f893d7d2d4806b685195863717ac9ce2d7250b02a0db3085', '[\"*\"]', NULL, NULL, '2025-02-25 01:38:41', '2025-02-25 01:38:41');
INSERT INTO `personal_access_tokens` VALUES (13, 'App\\Models\\User', 7, 'authToken', '5a5292c4f8d9d8e901968fbe41bfd8a2e8387718e2777a35d89892cca4239ca7', '[\"*\"]', '2025-02-25 09:12:54', NULL, '2025-02-25 01:39:51', '2025-02-25 09:12:54');
INSERT INTO `personal_access_tokens` VALUES (14, 'App\\Models\\User', 8, 'authToken', 'd8532a708a83e00029967734afaa6bbe4bc260e5d4c86bc65583e37aeb28c77a', '[\"*\"]', '2025-02-26 08:37:37', NULL, '2025-02-25 01:43:11', '2025-02-26 08:37:37');
INSERT INTO `personal_access_tokens` VALUES (15, 'App\\Models\\User', 7, 'authToken', '062ebcbd52956c4ea5038da79b24e32ed5ef7a4b18c8fe74ceed32245e8b1171', '[\"*\"]', NULL, NULL, '2025-02-25 09:14:01', '2025-02-25 09:14:01');
INSERT INTO `personal_access_tokens` VALUES (16, 'App\\Models\\User', 7, 'authToken', '608d2440da5a0372e5699ecf9439fe6f4ac719b362b99d215d0991f01df87ae4', '[\"*\"]', NULL, NULL, '2025-02-25 14:00:45', '2025-02-25 14:00:45');
INSERT INTO `personal_access_tokens` VALUES (17, 'App\\Models\\User', 7, 'authToken', 'd251b0484470be0ad4e1de9eda9dc15c5421ac87dcc2517cec379d28c79ca25c', '[\"*\"]', NULL, NULL, '2025-02-25 14:03:07', '2025-02-25 14:03:07');
INSERT INTO `personal_access_tokens` VALUES (18, 'App\\Models\\User', 8, 'authToken', 'f47e2cccd4ed27ae38f9d90980cf561ae28537c033f3222791f0d0dd1ae72576', '[\"*\"]', '2025-02-26 10:39:44', NULL, '2025-02-26 08:47:22', '2025-02-26 10:39:44');
INSERT INTO `personal_access_tokens` VALUES (19, 'App\\Models\\User', 8, 'authToken', 'b14cfed8729a6fe9dacf0f5a427859aee37dd5ef25afdc702714829d214c73da', '[\"*\"]', '2025-03-10 10:26:49', NULL, '2025-02-26 13:54:48', '2025-03-10 10:26:49');
INSERT INTO `personal_access_tokens` VALUES (20, 'App\\Models\\User', 8, 'authToken', 'c2ad4abe77865573800c61be4d7a8374b82e88b9dd138aa246da5dad37e78d8e', '[\"*\"]', NULL, NULL, '2025-02-26 14:34:38', '2025-02-26 14:34:38');
INSERT INTO `personal_access_tokens` VALUES (21, 'App\\Models\\User', 7, 'authToken', '8c7ea4880c6fe46922795bf0afcee2ad6ba25a835e1ca75c0df23d7cf3fb004b', '[\"*\"]', NULL, NULL, '2025-02-26 14:36:40', '2025-02-26 14:36:40');
INSERT INTO `personal_access_tokens` VALUES (22, 'App\\Models\\User', 8, 'authToken', '9e6ab6ddfd914d10030779553c63705f394e063e917d300422f9b9a351461449', '[\"*\"]', NULL, NULL, '2025-02-26 14:39:07', '2025-02-26 14:39:07');
INSERT INTO `personal_access_tokens` VALUES (23, 'App\\Models\\User', 8, 'authToken', 'eeff75d401775dd37ec12f0bafb1858e439b72569ed7296caa57569f5d53eca6', '[\"*\"]', NULL, NULL, '2025-02-26 14:41:43', '2025-02-26 14:41:43');
INSERT INTO `personal_access_tokens` VALUES (24, 'App\\Models\\User', 8, 'authToken', 'f5a11eede3a5b507c4a80bc35098f418fa6a0e8f3b11a2b52f329cc6ed4d31d2', '[\"*\"]', NULL, NULL, '2025-02-26 14:46:14', '2025-02-26 14:46:14');
INSERT INTO `personal_access_tokens` VALUES (25, 'App\\Models\\User', 8, 'authToken', 'b0af611303b379b9e960702d08821194f5e642a87f1cc34421487f2a5d9c1f96', '[\"*\"]', NULL, NULL, '2025-02-26 14:46:58', '2025-02-26 14:46:58');
INSERT INTO `personal_access_tokens` VALUES (26, 'App\\Models\\User', 8, 'authToken', 'f7c9d9c8a044ed8113fba16f3afb6b9b183eee49e846f091f62bc7c492a9ebca', '[\"*\"]', NULL, NULL, '2025-02-26 14:48:41', '2025-02-26 14:48:41');
INSERT INTO `personal_access_tokens` VALUES (27, 'App\\Models\\User', 8, 'authToken', 'a98ce5923adb676ba7e70972ad1b9b54c97394d27bd5c77784549867e3f8d53d', '[\"*\"]', NULL, NULL, '2025-02-26 14:50:40', '2025-02-26 14:50:40');
INSERT INTO `personal_access_tokens` VALUES (28, 'App\\Models\\User', 8, 'authToken', '87ba56205fda0688d517cfcc87f14f095bd0ec1ec06d6fa6aa0ef07e09cd3987', '[\"*\"]', NULL, NULL, '2025-02-26 14:51:39', '2025-02-26 14:51:39');
INSERT INTO `personal_access_tokens` VALUES (29, 'App\\Models\\User', 7, 'authToken', 'a25f75953722e0f83d65dc5b9db9fe81e60d630af787f38a46a9cbac3878a4a0', '[\"*\"]', '2025-02-27 11:07:40', NULL, '2025-02-26 15:06:16', '2025-02-27 11:07:40');
INSERT INTO `personal_access_tokens` VALUES (30, 'App\\Models\\User', 7, 'authToken', 'ef7451e7a3c56a693eff94096b91c14639e56bafcac1998bb01812bce5dcba0c', '[\"*\"]', '2025-03-06 13:25:06', NULL, '2025-02-27 08:38:27', '2025-03-06 13:25:06');
INSERT INTO `personal_access_tokens` VALUES (31, 'App\\Models\\User', 7, 'authToken', '367c6d7a5c3a9e65f501d0b880075c22a41daba00e8088b8b9cb028a56ac30f3', '[\"*\"]', '2025-03-04 12:26:44', NULL, '2025-03-04 08:34:22', '2025-03-04 12:26:44');
INSERT INTO `personal_access_tokens` VALUES (32, 'App\\Models\\User', 7, 'authToken', 'dc5794b77abecf47f5656e18661eee77bb1d33629d6b019e0d192175e3a90dd3', '[\"*\"]', '2025-03-05 13:59:06', NULL, '2025-03-05 08:46:26', '2025-03-05 13:59:06');
INSERT INTO `personal_access_tokens` VALUES (33, 'App\\Models\\User', 8, 'authToken', '6b7ec57a767b502642a24e5ecd9d4ee42b7d42a9ede7e05d05999c718b840a4f', '[\"*\"]', NULL, NULL, '2025-03-05 10:55:52', '2025-03-05 10:55:52');
INSERT INTO `personal_access_tokens` VALUES (34, 'App\\Models\\User', 8, 'authToken', 'de7d7d2616b1814036bfd849df8dc340270be9d1d641751eb8ce7a52235e3764', '[\"*\"]', NULL, NULL, '2025-03-05 10:57:07', '2025-03-05 10:57:07');
INSERT INTO `personal_access_tokens` VALUES (35, 'App\\Models\\User', 7, 'authToken', '094e61ce527aef355a85692b360cba94c78ffe3c4ad2df5bfc72bf1982eea825', '[\"*\"]', '2025-03-06 13:24:22', NULL, '2025-03-05 11:18:39', '2025-03-06 13:24:22');
INSERT INTO `personal_access_tokens` VALUES (36, 'App\\Models\\User', 8, 'authToken', 'd151eb062780cbeed55f8fcd268268040b51d370f060c353df081786cc521e3c', '[\"*\"]', NULL, NULL, '2025-03-06 09:47:56', '2025-03-06 09:47:56');
INSERT INTO `personal_access_tokens` VALUES (37, 'App\\Models\\User', 8, 'authToken', '5c883b7db50eb4fec7759d784f2a099e53bcf5329f8ae0d346d3d81c270f1aef', '[\"*\"]', NULL, NULL, '2025-03-06 10:08:28', '2025-03-06 10:08:28');
INSERT INTO `personal_access_tokens` VALUES (38, 'App\\Models\\User', 8, 'authToken', '9d85529adf4f9dd4b26d884bd1715199052d5b32209aa55667706ab73cebbc0c', '[\"*\"]', NULL, NULL, '2025-03-06 10:15:17', '2025-03-06 10:15:17');
INSERT INTO `personal_access_tokens` VALUES (39, 'App\\Models\\User', 8, 'authToken', 'e2fd43d9853430841fcd8eabdee38fef55a80f83ee2eafc369f90a10e43b00b7', '[\"*\"]', NULL, NULL, '2025-03-06 10:16:00', '2025-03-06 10:16:00');
INSERT INTO `personal_access_tokens` VALUES (40, 'App\\Models\\User', 7, 'authToken', '34a0e2809eeb82b7a1d6842adb10777c6bd614238167b860eb9b7db19a5e943c', '[\"*\"]', '2025-03-06 13:46:35', NULL, '2025-03-06 13:24:22', '2025-03-06 13:46:35');
INSERT INTO `personal_access_tokens` VALUES (41, 'App\\Models\\User', 7, 'authToken', '7e004a6f1043e902ce226890a65c9c9870b13289540ff920443e21bfd9758724', '[\"*\"]', '2025-03-10 10:42:01', NULL, '2025-03-06 13:28:07', '2025-03-10 10:42:01');
INSERT INTO `personal_access_tokens` VALUES (42, 'App\\Models\\User', 8, 'authToken', '10000075ed4336b9000249ed858dd6d090191ccd5e6c97e800c5865dca6bab87', '[\"*\"]', '2025-03-12 10:55:48', NULL, '2025-03-10 11:22:40', '2025-03-12 10:55:48');

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id`) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for role_menus
-- ----------------------------
DROP TABLE IF EXISTS `role_menus`;
CREATE TABLE `role_menus`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `role_menus_role_id_foreign`(`role_id`) USING BTREE,
  INDEX `role_menus_menu_id_foreign`(`menu_id`) USING BTREE,
  CONSTRAINT `role_menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_menus_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 73 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of role_menus
-- ----------------------------
INSERT INTO `role_menus` VALUES (1, 1, 1, NULL, NULL);
INSERT INTO `role_menus` VALUES (2, 1, 2, NULL, NULL);
INSERT INTO `role_menus` VALUES (3, 1, 3, NULL, NULL);
INSERT INTO `role_menus` VALUES (4, 1, 4, NULL, NULL);
INSERT INTO `role_menus` VALUES (5, 1, 5, NULL, NULL);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_guard_name_unique`(`name`, `guard_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'SUPERADMIN', 'web', '2025-02-18 01:56:49', '2025-02-18 01:56:49');
INSERT INTO `roles` VALUES (3, 'admin', 'web', '2025-03-12 12:48:41', '2025-03-12 12:48:41');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id`) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('bS9Q5bIL3D2QZFjlQpyqwoZATxedSojoOSaObc2M', 1, '10.0.108.252', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoia2VQUkV0YmZOYzBWSW9JMDNUNm1OUlloY3FzSmZjRmxiTzZYdGFFQSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vYmJtLnJzdWRwYXRpLmlkL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoibGFzdF9yZWdlbmVyYXRpb24iO2k6MTc1NzQ3MTEyNTt9', 1757471125);
INSERT INTO `sessions` VALUES ('g5h4gluD47rKTNDvhA86FInnIDki97gLV0lZi9FV', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiT2N1ZnY5RGF1cWVCQ2pIWXF3c2JXcWd3aVFUUDkwaHk5ZkhsczRYNSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvc2V0dGluZ3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1757473081);

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `website_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `website_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `favicon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES (1, 'HanindyaMom', 'HanindyaMom adalah aplikasi baby tracker dari Indonesia yang dirancang khusus untuk membantu ibu dan ayah memantau pertumbuhan dan aktivitas bayi dengan mudah. Mulai dari jadwal menyusui, ganti popok, tidur, hingga perkembangan harian si kecil – semuanya dalam satu aplikasi sederhana dan praktis.', 'logos/1741239243_logo.png', 'favicons/1739844536_favicon.webp', NULL, NULL, NULL, '2025-02-18 02:08:56', '2025-09-10 02:55:46');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_username_unique`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, '9e9df8ba-de16-4b99-b0dc-7676ff0220c5', 'Admin', 'admin', '', '2025-02-18 01:52:46', '$2y$12$DncXVy8bmctiX5.3662FpOVX80btc2JhVtC/am7L148h3ntZbq4Ci', 'V1z8O8k95Co5hVjPY3kAnll0gUJBbHfgchmJZ5pR5SD1BSbhPelNohqvyBga', '2025-02-18 01:52:46', '2025-02-18 01:52:46', '');

SET FOREIGN_KEY_CHECKS = 1;
