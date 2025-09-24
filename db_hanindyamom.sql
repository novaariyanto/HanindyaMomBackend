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

 Date: 12/09/2025 09:51:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for baby_profiles
-- ----------------------------
DROP TABLE IF EXISTS `baby_profiles`;
CREATE TABLE `baby_profiles`  (
  `id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_uuid` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `birth_date` date NOT NULL,
  `photo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `birth_weight` decimal(5, 2) NULL DEFAULT NULL,
  `birth_height` decimal(5, 2) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of baby_profiles
-- ----------------------------
INSERT INTO `baby_profiles` VALUES ('0810619f-af3e-46d6-95b3-dc728ae16991', '7ca298c8-27aa-4831-ad1a-5429b266f9ce', 'Bayi x', '2025-09-01', NULL, 3.00, 47.00, '2025-09-10 04:55:51', '2025-09-11 02:24:52');
INSERT INTO `baby_profiles` VALUES ('9c3f2356-7d4f-464f-b500-85a908419383', '7ca298c8-27aa-4831-ad1a-5429b266f9ce', 'Hanindya Zahra Renjana', '2024-11-06', NULL, 8.00, 70.00, '2025-09-10 04:44:01', '2025-09-10 04:44:01');

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
-- Records of cache
-- ----------------------------
INSERT INTO `cache` VALUES ('user_menus_1', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:3:{i:0;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:38;s:4:\"uuid\";s:36:\"a9a8a2ef-454b-4759-821d-18854c26ffe8\";s:5:\"route\";s:1:\"#\";s:4:\"icon\";s:14:\"ti ti-database\";s:9:\"nama_menu\";s:5:\"Admin\";s:9:\"parent_id\";N;s:10:\"created_at\";s:19:\"2025-09-10 05:21:46\";s:10:\"updated_at\";s:19:\"2025-09-10 05:21:46\";s:5:\"order\";N;s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:7:{i:0;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:39;s:4:\"uuid\";s:36:\"57985765-3d35-44d6-8b33-aa220954e0a4\";s:5:\"route\";s:17:\"admin.users.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:5:\"Users\";s:9:\"parent_id\";i:38;s:10:\"created_at\";s:19:\"2025-09-10 05:24:28\";s:10:\"updated_at\";s:19:\"2025-09-10 05:24:28\";s:5:\"order\";N;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:39;s:4:\"uuid\";s:36:\"57985765-3d35-44d6-8b33-aa220954e0a4\";s:5:\"route\";s:17:\"admin.users.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:5:\"Users\";s:9:\"parent_id\";i:38;s:10:\"created_at\";s:19:\"2025-09-10 05:24:28\";s:10:\"updated_at\";s:19:\"2025-09-10 05:24:28\";s:5:\"order\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";s:13:\"pivot_menu_id\";i:39;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:39;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:39;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:28;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:40;s:4:\"uuid\";s:36:\"ab9c3316-e537-4bb5-83b7-1b2d3a621b9d\";s:5:\"route\";s:18:\"admin.babies.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:6:\"Babies\";s:9:\"parent_id\";i:38;s:10:\"created_at\";s:19:\"2025-09-10 05:25:04\";s:10:\"updated_at\";s:19:\"2025-09-10 05:25:04\";s:5:\"order\";N;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:40;s:4:\"uuid\";s:36:\"ab9c3316-e537-4bb5-83b7-1b2d3a621b9d\";s:5:\"route\";s:18:\"admin.babies.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:6:\"Babies\";s:9:\"parent_id\";i:38;s:10:\"created_at\";s:19:\"2025-09-10 05:25:04\";s:10:\"updated_at\";s:19:\"2025-09-10 05:25:04\";s:5:\"order\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";s:13:\"pivot_menu_id\";i:40;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:40;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:40;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:202;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:41;s:4:\"uuid\";s:36:\"fdc409b6-bacb-45aa-81ab-2cd6c15f8ff1\";s:5:\"route\";s:19:\"admin.feeding.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:7:\"Feeding\";s:9:\"parent_id\";i:38;s:10:\"created_at\";s:19:\"2025-09-10 06:31:15\";s:10:\"updated_at\";s:19:\"2025-09-10 06:31:15\";s:5:\"order\";N;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:41;s:4:\"uuid\";s:36:\"fdc409b6-bacb-45aa-81ab-2cd6c15f8ff1\";s:5:\"route\";s:19:\"admin.feeding.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:7:\"Feeding\";s:9:\"parent_id\";i:38;s:10:\"created_at\";s:19:\"2025-09-10 06:31:15\";s:10:\"updated_at\";s:19:\"2025-09-10 06:31:15\";s:5:\"order\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";s:13:\"pivot_menu_id\";i:41;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:41;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:41;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:376;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:42;s:4:\"uuid\";s:36:\"c561ebcf-35a2-4c84-bd65-1be70463374c\";s:5:\"route\";s:19:\"admin.diapers.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:7:\"Diapers\";s:9:\"parent_id\";i:38;s:10:\"created_at\";s:19:\"2025-09-10 06:31:33\";s:10:\"updated_at\";s:19:\"2025-09-10 06:31:33\";s:5:\"order\";N;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:42;s:4:\"uuid\";s:36:\"c561ebcf-35a2-4c84-bd65-1be70463374c\";s:5:\"route\";s:19:\"admin.diapers.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:7:\"Diapers\";s:9:\"parent_id\";i:38;s:10:\"created_at\";s:19:\"2025-09-10 06:31:33\";s:10:\"updated_at\";s:19:\"2025-09-10 06:31:33\";s:5:\"order\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";s:13:\"pivot_menu_id\";i:42;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:42;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:42;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:550;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:43;s:4:\"uuid\";s:36:\"dfd74e44-1a99-455d-9c02-644f8b3b2968\";s:5:\"route\";s:17:\"admin.sleep.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:5:\"Sleep\";s:9:\"parent_id\";i:38;s:10:\"created_at\";s:19:\"2025-09-10 06:31:48\";s:10:\"updated_at\";s:19:\"2025-09-10 06:31:48\";s:5:\"order\";N;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:43;s:4:\"uuid\";s:36:\"dfd74e44-1a99-455d-9c02-644f8b3b2968\";s:5:\"route\";s:17:\"admin.sleep.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:5:\"Sleep\";s:9:\"parent_id\";i:38;s:10:\"created_at\";s:19:\"2025-09-10 06:31:48\";s:10:\"updated_at\";s:19:\"2025-09-10 06:31:48\";s:5:\"order\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";s:13:\"pivot_menu_id\";i:43;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:43;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:43;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:724;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:44;s:4:\"uuid\";s:36:\"fb7e6701-9b6f-4aa9-98ae-8774fffe3920\";s:5:\"route\";s:18:\"admin.growth.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:6:\"Growth\";s:9:\"parent_id\";i:38;s:10:\"created_at\";s:19:\"2025-09-10 06:32:03\";s:10:\"updated_at\";s:19:\"2025-09-10 06:32:03\";s:5:\"order\";N;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:44;s:4:\"uuid\";s:36:\"fb7e6701-9b6f-4aa9-98ae-8774fffe3920\";s:5:\"route\";s:18:\"admin.growth.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:6:\"Growth\";s:9:\"parent_id\";i:38;s:10:\"created_at\";s:19:\"2025-09-10 06:32:03\";s:10:\"updated_at\";s:19:\"2025-09-10 06:32:03\";s:5:\"order\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";s:13:\"pivot_menu_id\";i:44;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:44;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:44;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:898;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:6;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:45;s:4:\"uuid\";s:36:\"1be91b58-8644-446e-bd88-704986a280e4\";s:5:\"route\";s:20:\"admin.vaccines.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:8:\"Vaccines\";s:9:\"parent_id\";i:38;s:10:\"created_at\";s:19:\"2025-09-10 06:32:15\";s:10:\"updated_at\";s:19:\"2025-09-10 06:32:15\";s:5:\"order\";N;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:45;s:4:\"uuid\";s:36:\"1be91b58-8644-446e-bd88-704986a280e4\";s:5:\"route\";s:20:\"admin.vaccines.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:8:\"Vaccines\";s:9:\"parent_id\";i:38;s:10:\"created_at\";s:19:\"2025-09-10 06:32:15\";s:10:\"updated_at\";s:19:\"2025-09-10 06:32:15\";s:5:\"order\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";s:13:\"pivot_menu_id\";i:45;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:45;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:45;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:1072;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:38;s:4:\"uuid\";s:36:\"a9a8a2ef-454b-4759-821d-18854c26ffe8\";s:5:\"route\";s:1:\"#\";s:4:\"icon\";s:14:\"ti ti-database\";s:9:\"nama_menu\";s:5:\"Admin\";s:9:\"parent_id\";N;s:10:\"created_at\";s:19:\"2025-09-10 05:21:46\";s:10:\"updated_at\";s:19:\"2025-09-10 05:21:46\";s:5:\"order\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:7:{i:0;r:28;i:1;r:202;i:2;r:376;i:3;r:550;i:4;r:724;i:5;r:898;i:6;r:1072;}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";s:13:\"pivot_menu_id\";i:38;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:38;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:38;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:3;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:5;s:4:\"uuid\";s:36:\"f602469c-7303-4df9-9164-76ba63e2a5b0\";s:5:\"route\";s:1:\"#\";s:4:\"icon\";s:9:\"ti ti-key\";s:9:\"nama_menu\";s:11:\"Autentikasi\";s:9:\"parent_id\";N;s:10:\"created_at\";s:19:\"2025-02-18 09:17:37\";s:10:\"updated_at\";s:19:\"2025-09-10 05:15:18\";s:5:\"order\";i:1;s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:3:{i:0;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:1;s:4:\"uuid\";s:36:\"bb5e49c9-5c7b-4840-bb4b-b48a96e8a260\";s:5:\"route\";s:10:\"user.index\";s:4:\"icon\";s:10:\"ti ti-user\";s:9:\"nama_menu\";s:4:\"User\";s:9:\"parent_id\";i:5;s:10:\"created_at\";s:19:\"2025-02-18 09:01:15\";s:10:\"updated_at\";s:19:\"2025-07-02 21:35:11\";s:5:\"order\";i:13;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:1;s:4:\"uuid\";s:36:\"bb5e49c9-5c7b-4840-bb4b-b48a96e8a260\";s:5:\"route\";s:10:\"user.index\";s:4:\"icon\";s:10:\"ti ti-user\";s:9:\"nama_menu\";s:4:\"User\";s:9:\"parent_id\";i:5;s:10:\"created_at\";s:19:\"2025-02-18 09:01:15\";s:10:\"updated_at\";s:19:\"2025-07-02 21:35:11\";s:5:\"order\";i:13;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";s:13:\"pivot_menu_id\";i:1;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:1;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:1;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:1433;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:3;s:4:\"uuid\";s:36:\"9b1c00d5-5b6b-4161-b976-87a6da9573d1\";s:5:\"route\";s:10:\"role.index\";s:4:\"icon\";s:12:\"ti ti-shield\";s:9:\"nama_menu\";s:4:\"Role\";s:9:\"parent_id\";i:5;s:10:\"created_at\";s:19:\"2025-02-18 09:10:58\";s:10:\"updated_at\";s:19:\"2025-07-02 21:35:11\";s:5:\"order\";i:14;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:3;s:4:\"uuid\";s:36:\"9b1c00d5-5b6b-4161-b976-87a6da9573d1\";s:5:\"route\";s:10:\"role.index\";s:4:\"icon\";s:12:\"ti ti-shield\";s:9:\"nama_menu\";s:4:\"Role\";s:9:\"parent_id\";i:5;s:10:\"created_at\";s:19:\"2025-02-18 09:10:58\";s:10:\"updated_at\";s:19:\"2025-07-02 21:35:11\";s:5:\"order\";i:14;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";s:13:\"pivot_menu_id\";i:3;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:3;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:3;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:1607;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:4;s:4:\"uuid\";s:36:\"1f2f5340-6912-42da-9331-ab768c5d44ee\";s:5:\"route\";s:10:\"menu.index\";s:4:\"icon\";s:10:\"ti ti-list\";s:9:\"nama_menu\";s:4:\"Menu\";s:9:\"parent_id\";i:5;s:10:\"created_at\";s:19:\"2025-02-18 09:15:39\";s:10:\"updated_at\";s:19:\"2025-07-02 21:35:11\";s:5:\"order\";i:15;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:4;s:4:\"uuid\";s:36:\"1f2f5340-6912-42da-9331-ab768c5d44ee\";s:5:\"route\";s:10:\"menu.index\";s:4:\"icon\";s:10:\"ti ti-list\";s:9:\"nama_menu\";s:4:\"Menu\";s:9:\"parent_id\";i:5;s:10:\"created_at\";s:19:\"2025-02-18 09:15:39\";s:10:\"updated_at\";s:19:\"2025-07-02 21:35:11\";s:5:\"order\";i:15;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";s:13:\"pivot_menu_id\";i:4;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:4;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:4;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:1781;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:5;s:4:\"uuid\";s:36:\"f602469c-7303-4df9-9164-76ba63e2a5b0\";s:5:\"route\";s:1:\"#\";s:4:\"icon\";s:9:\"ti ti-key\";s:9:\"nama_menu\";s:11:\"Autentikasi\";s:9:\"parent_id\";N;s:10:\"created_at\";s:19:\"2025-02-18 09:17:37\";s:10:\"updated_at\";s:19:\"2025-09-10 05:15:18\";s:5:\"order\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:3:{i:0;r:1433;i:1;r:1607;i:2;r:1781;}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";s:13:\"pivot_menu_id\";i:5;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:5;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:5;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:1408;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:2;s:4:\"uuid\";s:36:\"6ee7d0a1-4aca-4cc5-ba7b-7eb636977c57\";s:5:\"route\";s:13:\"settings.edit\";s:4:\"icon\";s:14:\"ti ti-settings\";s:9:\"nama_menu\";s:10:\"Pengaturan\";s:9:\"parent_id\";N;s:10:\"created_at\";s:19:\"2025-02-18 09:10:08\";s:10:\"updated_at\";s:19:\"2025-09-10 05:15:18\";s:5:\"order\";i:2;s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:2;s:4:\"uuid\";s:36:\"6ee7d0a1-4aca-4cc5-ba7b-7eb636977c57\";s:5:\"route\";s:13:\"settings.edit\";s:4:\"icon\";s:14:\"ti ti-settings\";s:9:\"nama_menu\";s:10:\"Pengaturan\";s:9:\"parent_id\";N;s:10:\"created_at\";s:19:\"2025-02-18 09:10:08\";s:10:\"updated_at\";s:19:\"2025-09-10 05:15:18\";s:5:\"order\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 08:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 08:56:49\";s:13:\"pivot_menu_id\";i:2;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:2;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:2;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:2113;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1757659539);

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
-- Table structure for diaper_logs
-- ----------------------------
DROP TABLE IF EXISTS `diaper_logs`;
CREATE TABLE `diaper_logs`  (
  `id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `baby_id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `type` enum('pipis','pup','campuran') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `color` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `texture` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `time` datetime NOT NULL,
  `notes` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of diaper_logs
-- ----------------------------
INSERT INTO `diaper_logs` VALUES ('5e6c66d0-bc3d-420c-8669-04d6dcc30d53', '0810619f-af3e-46d6-95b3-dc728ae16991', 'pipis', NULL, NULL, '2025-09-10 15:16:27', 'test', '2025-09-10 08:16:33', '2025-09-10 08:16:33');
INSERT INTO `diaper_logs` VALUES ('aa17c959-76b6-4d5c-9abf-b7ade51887c7', '9c3f2356-7d4f-464f-b500-85a908419383', 'pipis', NULL, NULL, '2025-09-11 11:36:19', 'test', '2025-09-11 04:36:24', '2025-09-11 04:36:24');
INSERT INTO `diaper_logs` VALUES ('b227c713-b496-454e-b61b-196280c2108c', '0810619f-af3e-46d6-95b3-dc728ae16991', 'pipis', 'kuning', NULL, '2025-09-11 09:31:00', NULL, '2025-09-11 02:31:19', '2025-09-11 02:31:19');

-- ----------------------------
-- Table structure for feeding_logs
-- ----------------------------
DROP TABLE IF EXISTS `feeding_logs`;
CREATE TABLE `feeding_logs`  (
  `id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `baby_id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `type` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `start_time` datetime NOT NULL,
  `duration_minutes` int(11) NOT NULL,
  `notes` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of feeding_logs
-- ----------------------------
INSERT INTO `feeding_logs` VALUES ('5fa93881-4cce-49cf-8ef8-d941f86cf97e', '0810619f-af3e-46d6-95b3-dc728ae16991', 'breastLeft', '2025-09-10 15:26:29', 2, NULL, '2025-09-10 08:28:42', '2025-09-10 08:28:42');
INSERT INTO `feeding_logs` VALUES ('b88a75fe-9c74-49e0-bc20-0f271200e38c', '0810619f-af3e-46d6-95b3-dc728ae16991', 'asi_left', '2025-09-11 09:30:00', 15, NULL, '2025-09-11 02:30:56', '2025-09-11 02:30:56');

-- ----------------------------
-- Table structure for growth_logs
-- ----------------------------
DROP TABLE IF EXISTS `growth_logs`;
CREATE TABLE `growth_logs`  (
  `id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `baby_id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date` date NOT NULL,
  `weight` decimal(5, 2) NOT NULL,
  `height` decimal(5, 2) NOT NULL,
  `head_circumference` decimal(5, 2) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of growth_logs
-- ----------------------------
INSERT INTO `growth_logs` VALUES ('685236ea-6c56-46db-b114-0498a3201a3c', '0810619f-af3e-46d6-95b3-dc728ae16991', '2025-09-11', 8.50, 70.00, NULL, '2025-09-11 06:32:28', '2025-09-11 06:32:28');
INSERT INTO `growth_logs` VALUES ('8c2c6f6e-6153-4584-a708-72110b3b53b5', '9c3f2356-7d4f-464f-b500-85a908419383', '2025-09-11', 8.00, 70.00, NULL, '2025-09-11 06:10:02', '2025-09-11 06:10:02');
INSERT INTO `growth_logs` VALUES ('efbb21f7-5da8-462b-940b-4f194f7019d0', '0810619f-af3e-46d6-95b3-dc728ae16991', '2025-09-10', 8.00, 70.00, NULL, '2025-09-11 06:35:21', '2025-09-11 06:35:21');

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
) ENGINE = InnoDB AUTO_INCREMENT = 46 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES (1, 'bb5e49c9-5c7b-4840-bb4b-b48a96e8a260', 'user.index', 'ti ti-user', 'User', 5, '2025-02-18 09:01:15', '2025-07-02 21:35:11', 13);
INSERT INTO `menus` VALUES (2, '6ee7d0a1-4aca-4cc5-ba7b-7eb636977c57', 'settings.edit', 'ti ti-settings', 'Pengaturan', NULL, '2025-02-18 09:10:08', '2025-09-10 05:15:18', 2);
INSERT INTO `menus` VALUES (3, '9b1c00d5-5b6b-4161-b976-87a6da9573d1', 'role.index', 'ti ti-shield', 'Role', 5, '2025-02-18 09:10:58', '2025-07-02 21:35:11', 14);
INSERT INTO `menus` VALUES (4, '1f2f5340-6912-42da-9331-ab768c5d44ee', 'menu.index', 'ti ti-list', 'Menu', 5, '2025-02-18 09:15:39', '2025-07-02 21:35:11', 15);
INSERT INTO `menus` VALUES (5, 'f602469c-7303-4df9-9164-76ba63e2a5b0', '#', 'ti ti-key', 'Autentikasi', NULL, '2025-02-18 09:17:37', '2025-09-10 05:15:18', 1);
INSERT INTO `menus` VALUES (38, 'a9a8a2ef-454b-4759-821d-18854c26ffe8', '#', 'ti ti-database', 'Admin', NULL, '2025-09-10 05:21:46', '2025-09-10 05:21:46', NULL);
INSERT INTO `menus` VALUES (39, '57985765-3d35-44d6-8b33-aa220954e0a4', 'admin.users.index', 'ti ti-users', 'Users', 38, '2025-09-10 05:24:28', '2025-09-10 05:24:28', NULL);
INSERT INTO `menus` VALUES (40, 'ab9c3316-e537-4bb5-83b7-1b2d3a621b9d', 'admin.babies.index', 'ti ti-users', 'Babies', 38, '2025-09-10 05:25:04', '2025-09-10 05:25:04', NULL);
INSERT INTO `menus` VALUES (41, 'fdc409b6-bacb-45aa-81ab-2cd6c15f8ff1', 'admin.feeding.index', 'ti ti-users', 'Feeding', 38, '2025-09-10 06:31:15', '2025-09-10 06:31:15', NULL);
INSERT INTO `menus` VALUES (42, 'c561ebcf-35a2-4c84-bd65-1be70463374c', 'admin.diapers.index', 'ti ti-users', 'Diapers', 38, '2025-09-10 06:31:33', '2025-09-10 06:31:33', NULL);
INSERT INTO `menus` VALUES (43, 'dfd74e44-1a99-455d-9c02-644f8b3b2968', 'admin.sleep.index', 'ti ti-users', 'Sleep', 38, '2025-09-10 06:31:48', '2025-09-10 06:31:48', NULL);
INSERT INTO `menus` VALUES (44, 'fb7e6701-9b6f-4aa9-98ae-8774fffe3920', 'admin.growth.index', 'ti ti-users', 'Growth', 38, '2025-09-10 06:32:03', '2025-09-10 06:32:03', NULL);
INSERT INTO `menus` VALUES (45, '1be91b58-8644-446e-bd88-704986a280e4', 'admin.vaccines.index', 'ti ti-users', 'Vaccines', 38, '2025-09-10 06:32:15', '2025-09-10 06:32:15', NULL);

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
-- Table structure for milestones
-- ----------------------------
DROP TABLE IF EXISTS `milestones`;
CREATE TABLE `milestones`  (
  `id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `baby_id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `month` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `achieved` tinyint(1) NULL DEFAULT 0,
  `achieved_at` datetime NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of milestones
-- ----------------------------
INSERT INTO `milestones` VALUES ('34d85e40-7a06-4d91-b186-3a0e2fdf63b7', '9c3f2356-7d4f-464f-b500-85a908419383', 6, 'Merangkak', 'jos', 1, '2025-09-11 00:00:00', '2025-09-11 04:32:26', '2025-09-11 04:32:34');

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

-- ----------------------------
-- Table structure for nutrition_entries
-- ----------------------------
DROP TABLE IF EXISTS `nutrition_entries`;
CREATE TABLE `nutrition_entries`  (
  `id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `baby_id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `time` datetime NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `photo_path` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `notes` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of nutrition_entries
-- ----------------------------
INSERT INTO `nutrition_entries` VALUES ('13f77fbe-5931-496b-8c05-ee2c7fe44c09', '9c3f2356-7d4f-464f-b500-85a908419383', '2025-09-11 14:15:00', 'test tw', NULL, 'test te', '2025-09-11 07:14:45', '2025-09-11 07:14:45');
INSERT INTO `nutrition_entries` VALUES ('3bddccef-226e-464d-9db1-69543db348db', '9c3f2356-7d4f-464f-b500-85a908419383', '2025-09-11 14:11:51', 'test', NULL, 'test', '2025-09-11 07:12:08', '2025-09-11 07:12:08');
INSERT INTO `nutrition_entries` VALUES ('a34776b1-3768-4e95-b6a1-e21b28b39f1c', '9c3f2356-7d4f-464f-b500-85a908419383', '2025-09-11 14:12:18', 'test', NULL, 'test', '2025-09-11 07:12:21', '2025-09-11 07:12:21');

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
INSERT INTO `password_reset_tokens` VALUES ('alexandrine81@example.org', '$2y$04$z2kqkdc5BkL.nTwrmI2QeeR0HP0IGkwbc3qS6Xc7LuXv3B8F0sNwC', '2025-09-10 03:58:00');
INSERT INTO `password_reset_tokens` VALUES ('carolyne61@example.com', '$2y$04$7pRERIxZHkhhEy/miXKjUuTbIkr12UfuSAYLENYYMeFw4p1/PVWIW', '2025-09-10 03:57:39');
INSERT INTO `password_reset_tokens` VALUES ('ebednar@example.net', '$2y$04$gbLJ/d6OK9dtZ7hedE2scuX9SjHFIcmPJjMGzbWD7egqrwOlglgiW', '2025-09-10 03:57:05');
INSERT INTO `password_reset_tokens` VALUES ('jaylen27@example.net', '$2y$04$8zMVOYkz8DhpyvbDh0P2O.L90bYRxiwcbOjthL0xbl96NTtPbLtRe', '2025-09-10 03:57:05');
INSERT INTO `password_reset_tokens` VALUES ('miller.orland@example.net', '$2y$04$2RMdZTmcb0gm0sA9unNZJOGnkbmPcJNKMKOimigawLNXxMxaxYaRm', '2025-09-10 03:57:39');
INSERT INTO `password_reset_tokens` VALUES ('vonrueden.elliot@example.com', '$2y$04$kINRbFJ.0ig9r0rk/DcWqesRFEudQ0rsbiXvOKqI/HVqbn7tbJ77i', '2025-09-10 03:58:00');

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
INSERT INTO `pegawai_masters` VALUES (1, 'b4d0cdd1-0e39-4b27-849d-0df3155e4818', '3507182109970003', 'MUHAMMAD NAJMUL FAIZ', 3, 4, 'aktif', '2025-02-24 10:07:41', '2025-02-25 08:38:41', 7);
INSERT INTO `pegawai_masters` VALUES (2, '37c0a26c-4f71-4f3c-8744-86f078cce64f', '3318121902790001', 'THOMAS FREDY ERVAN ANANTO, S.Kom', 3, 4, 'aktif', '2025-02-24 10:07:41', '2025-02-24 10:07:41', NULL);
INSERT INTO `pegawai_masters` VALUES (3, 'c1494f04-1aca-49ce-998d-2e0ab712f8e2', '3318082502800001', 'VERRY KARLIYANTO, S.Kom', 3, 4, 'aktif', '2025-02-24 10:07:41', '2025-02-24 10:07:41', NULL);
INSERT INTO `pegawai_masters` VALUES (4, '9f1e0f55-cb12-4006-ada1-461a5e0d8d72', '3318154812760001', 'PUJI DYAH HASTUTI', 3, 4, 'aktif', '2025-02-24 10:07:41', '2025-02-24 10:07:41', NULL);
INSERT INTO `pegawai_masters` VALUES (5, 'ed480de3-63e9-4b30-b35f-474cef9ae579', '3318172912870001', 'BUDI CAHYONO', 3, 4, 'aktif', '2025-02-24 10:07:41', '2025-02-24 10:07:41', NULL);
INSERT INTO `pegawai_masters` VALUES (6, '3b72b1e8-1b1a-47bd-9528-a29d5df2ce5c', '3309132109880002', 'EKO YUDHATAMA NUR ASLAM', 3, 4, 'aktif', '2025-02-24 10:07:42', '2025-02-25 08:43:11', 8);
INSERT INTO `pegawai_masters` VALUES (7, 'bf7d8c59-4b9c-4567-8394-06b4c824bf1b', '3318104703830008', 'PUJI UTAMI, SKM', 3, 4, 'aktif', '2025-02-24 10:07:42', '2025-02-24 10:07:42', NULL);
INSERT INTO `pegawai_masters` VALUES (10, '24720db6-2a11-4e8c-9ca0-610f6d19c53e', '3318107011720003', 'ATIK ENDROATI NAWANGSRI, A.Md', 3, 4, 'aktif', '2025-02-24 10:07:42', '2025-02-24 10:07:42', NULL);
INSERT INTO `pegawai_masters` VALUES (12, '1137f965-aacd-43a7-8569-f4557e7cb780', '3324192910880001', 'SETYO EDYATMO, SE', 3, 3, 'aktif', '2025-02-25 21:41:44', '2025-02-27 21:27:17', 9);

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
) ENGINE = InnoDB AUTO_INCREMENT = 80 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------
INSERT INTO `personal_access_tokens` VALUES (1, 'App\\Models\\User', 2, 'authToken', '30641497cdec3064c2e72e35a018c6c4070b57993f0191a347b35949549e4c9e', '[\"*\"]', NULL, NULL, '2025-02-24 10:52:00', '2025-02-24 10:52:00');
INSERT INTO `personal_access_tokens` VALUES (2, 'App\\Models\\User', 3, 'authToken', '7c9b7ca10f5c11ca20dd55b4191a575c67b8ca699bfe64b4a42896684114afff', '[\"*\"]', NULL, NULL, '2025-02-24 10:58:17', '2025-02-24 10:58:17');
INSERT INTO `personal_access_tokens` VALUES (3, 'App\\Models\\User', 4, 'authToken', '0eef9bd1cfdd0a8128809afcae30bf074b76e5d892870e46cb9353fe9e6b0e9c', '[\"*\"]', NULL, NULL, '2025-02-24 11:03:57', '2025-02-24 11:03:57');
INSERT INTO `personal_access_tokens` VALUES (4, 'App\\Models\\User', 5, 'authToken', 'bc38dac7770925ee1defd7e9cf55db8dd0bef148a4dc820778d2bdff176e312e', '[\"*\"]', NULL, NULL, '2025-02-24 11:05:15', '2025-02-24 11:05:15');
INSERT INTO `personal_access_tokens` VALUES (5, 'App\\Models\\User', 5, 'authToken', '2a4deb38e9b1ddf2910e1d812efdcdad7293b92534a5717fa941c24d233e05bf', '[\"*\"]', '2025-02-24 11:14:57', NULL, '2025-02-24 11:10:41', '2025-02-24 11:14:57');
INSERT INTO `personal_access_tokens` VALUES (6, 'App\\Models\\User', 5, 'authToken', 'bdd15a4a80d9dd08d8364113e18c8ae18d2f30b9dd1cef2adbef538155279ee1', '[\"*\"]', NULL, NULL, '2025-02-24 11:15:12', '2025-02-24 11:15:12');
INSERT INTO `personal_access_tokens` VALUES (7, 'App\\Models\\User', 5, 'authToken', '3b2371ec0ce8fba1e8b29cbf764190afeccf6d9b1a0b35a8e3b7e1b5c60dde5a', '[\"*\"]', NULL, NULL, '2025-02-24 11:15:52', '2025-02-24 11:15:52');
INSERT INTO `personal_access_tokens` VALUES (8, 'App\\Models\\User', 5, 'authToken', 'bb0f10e0d483ce21c095fe7a27eaf07fee236b0401aeba3a41c5435017a40fbf', '[\"*\"]', NULL, NULL, '2025-02-24 11:20:34', '2025-02-24 11:20:34');
INSERT INTO `personal_access_tokens` VALUES (9, 'App\\Models\\User', 5, 'authToken', '7cc5049f5ae7ebf98e810abff59d33a34623c6e104d340d56170fd4672dab55c', '[\"*\"]', NULL, NULL, '2025-02-24 11:23:23', '2025-02-24 11:23:23');
INSERT INTO `personal_access_tokens` VALUES (10, 'App\\Models\\User', 5, 'authToken', '63aa120907b715696c6a4522def5c30f995509378ec7102932181776942b9cb9', '[\"*\"]', '2025-02-24 11:26:45', NULL, '2025-02-24 11:23:43', '2025-02-24 11:26:45');
INSERT INTO `personal_access_tokens` VALUES (11, 'App\\Models\\User', 6, 'authToken', 'e362804cdf53090006872845c1c45d03838a5e6f73f98d9d1c2cda3215cdd859', '[\"*\"]', '2025-02-25 08:22:38', NULL, '2025-02-24 11:29:07', '2025-02-25 08:22:38');
INSERT INTO `personal_access_tokens` VALUES (12, 'App\\Models\\User', 7, 'authToken', '040dba3f735cf4e3f893d7d2d4806b685195863717ac9ce2d7250b02a0db3085', '[\"*\"]', NULL, NULL, '2025-02-25 08:38:41', '2025-02-25 08:38:41');
INSERT INTO `personal_access_tokens` VALUES (13, 'App\\Models\\User', 7, 'authToken', '5a5292c4f8d9d8e901968fbe41bfd8a2e8387718e2777a35d89892cca4239ca7', '[\"*\"]', '2025-02-25 16:12:54', NULL, '2025-02-25 08:39:51', '2025-02-25 16:12:54');
INSERT INTO `personal_access_tokens` VALUES (14, 'App\\Models\\User', 8, 'authToken', 'd8532a708a83e00029967734afaa6bbe4bc260e5d4c86bc65583e37aeb28c77a', '[\"*\"]', '2025-02-26 15:37:37', NULL, '2025-02-25 08:43:11', '2025-02-26 15:37:37');
INSERT INTO `personal_access_tokens` VALUES (15, 'App\\Models\\User', 7, 'authToken', '062ebcbd52956c4ea5038da79b24e32ed5ef7a4b18c8fe74ceed32245e8b1171', '[\"*\"]', NULL, NULL, '2025-02-25 16:14:01', '2025-02-25 16:14:01');
INSERT INTO `personal_access_tokens` VALUES (16, 'App\\Models\\User', 7, 'authToken', '608d2440da5a0372e5699ecf9439fe6f4ac719b362b99d215d0991f01df87ae4', '[\"*\"]', NULL, NULL, '2025-02-25 21:00:45', '2025-02-25 21:00:45');
INSERT INTO `personal_access_tokens` VALUES (17, 'App\\Models\\User', 7, 'authToken', 'd251b0484470be0ad4e1de9eda9dc15c5421ac87dcc2517cec379d28c79ca25c', '[\"*\"]', NULL, NULL, '2025-02-25 21:03:07', '2025-02-25 21:03:07');
INSERT INTO `personal_access_tokens` VALUES (18, 'App\\Models\\User', 8, 'authToken', 'f47e2cccd4ed27ae38f9d90980cf561ae28537c033f3222791f0d0dd1ae72576', '[\"*\"]', '2025-02-26 17:39:44', NULL, '2025-02-26 15:47:22', '2025-02-26 17:39:44');
INSERT INTO `personal_access_tokens` VALUES (19, 'App\\Models\\User', 8, 'authToken', 'b14cfed8729a6fe9dacf0f5a427859aee37dd5ef25afdc702714829d214c73da', '[\"*\"]', '2025-03-10 17:26:49', NULL, '2025-02-26 20:54:48', '2025-03-10 17:26:49');
INSERT INTO `personal_access_tokens` VALUES (20, 'App\\Models\\User', 8, 'authToken', 'c2ad4abe77865573800c61be4d7a8374b82e88b9dd138aa246da5dad37e78d8e', '[\"*\"]', NULL, NULL, '2025-02-26 21:34:38', '2025-02-26 21:34:38');
INSERT INTO `personal_access_tokens` VALUES (21, 'App\\Models\\User', 7, 'authToken', '8c7ea4880c6fe46922795bf0afcee2ad6ba25a835e1ca75c0df23d7cf3fb004b', '[\"*\"]', NULL, NULL, '2025-02-26 21:36:40', '2025-02-26 21:36:40');
INSERT INTO `personal_access_tokens` VALUES (22, 'App\\Models\\User', 8, 'authToken', '9e6ab6ddfd914d10030779553c63705f394e063e917d300422f9b9a351461449', '[\"*\"]', NULL, NULL, '2025-02-26 21:39:07', '2025-02-26 21:39:07');
INSERT INTO `personal_access_tokens` VALUES (23, 'App\\Models\\User', 8, 'authToken', 'eeff75d401775dd37ec12f0bafb1858e439b72569ed7296caa57569f5d53eca6', '[\"*\"]', NULL, NULL, '2025-02-26 21:41:43', '2025-02-26 21:41:43');
INSERT INTO `personal_access_tokens` VALUES (24, 'App\\Models\\User', 8, 'authToken', 'f5a11eede3a5b507c4a80bc35098f418fa6a0e8f3b11a2b52f329cc6ed4d31d2', '[\"*\"]', NULL, NULL, '2025-02-26 21:46:14', '2025-02-26 21:46:14');
INSERT INTO `personal_access_tokens` VALUES (25, 'App\\Models\\User', 8, 'authToken', 'b0af611303b379b9e960702d08821194f5e642a87f1cc34421487f2a5d9c1f96', '[\"*\"]', NULL, NULL, '2025-02-26 21:46:58', '2025-02-26 21:46:58');
INSERT INTO `personal_access_tokens` VALUES (26, 'App\\Models\\User', 8, 'authToken', 'f7c9d9c8a044ed8113fba16f3afb6b9b183eee49e846f091f62bc7c492a9ebca', '[\"*\"]', NULL, NULL, '2025-02-26 21:48:41', '2025-02-26 21:48:41');
INSERT INTO `personal_access_tokens` VALUES (27, 'App\\Models\\User', 8, 'authToken', 'a98ce5923adb676ba7e70972ad1b9b54c97394d27bd5c77784549867e3f8d53d', '[\"*\"]', NULL, NULL, '2025-02-26 21:50:40', '2025-02-26 21:50:40');
INSERT INTO `personal_access_tokens` VALUES (28, 'App\\Models\\User', 8, 'authToken', '87ba56205fda0688d517cfcc87f14f095bd0ec1ec06d6fa6aa0ef07e09cd3987', '[\"*\"]', NULL, NULL, '2025-02-26 21:51:39', '2025-02-26 21:51:39');
INSERT INTO `personal_access_tokens` VALUES (29, 'App\\Models\\User', 7, 'authToken', 'a25f75953722e0f83d65dc5b9db9fe81e60d630af787f38a46a9cbac3878a4a0', '[\"*\"]', '2025-02-27 18:07:40', NULL, '2025-02-26 22:06:16', '2025-02-27 18:07:40');
INSERT INTO `personal_access_tokens` VALUES (30, 'App\\Models\\User', 7, 'authToken', 'ef7451e7a3c56a693eff94096b91c14639e56bafcac1998bb01812bce5dcba0c', '[\"*\"]', '2025-03-06 20:25:06', NULL, '2025-02-27 15:38:27', '2025-03-06 20:25:06');
INSERT INTO `personal_access_tokens` VALUES (31, 'App\\Models\\User', 7, 'authToken', '367c6d7a5c3a9e65f501d0b880075c22a41daba00e8088b8b9cb028a56ac30f3', '[\"*\"]', '2025-03-04 19:26:44', NULL, '2025-03-04 15:34:22', '2025-03-04 19:26:44');
INSERT INTO `personal_access_tokens` VALUES (32, 'App\\Models\\User', 7, 'authToken', 'dc5794b77abecf47f5656e18661eee77bb1d33629d6b019e0d192175e3a90dd3', '[\"*\"]', '2025-03-05 20:59:06', NULL, '2025-03-05 15:46:26', '2025-03-05 20:59:06');
INSERT INTO `personal_access_tokens` VALUES (33, 'App\\Models\\User', 8, 'authToken', '6b7ec57a767b502642a24e5ecd9d4ee42b7d42a9ede7e05d05999c718b840a4f', '[\"*\"]', NULL, NULL, '2025-03-05 17:55:52', '2025-03-05 17:55:52');
INSERT INTO `personal_access_tokens` VALUES (34, 'App\\Models\\User', 8, 'authToken', 'de7d7d2616b1814036bfd849df8dc340270be9d1d641751eb8ce7a52235e3764', '[\"*\"]', NULL, NULL, '2025-03-05 17:57:07', '2025-03-05 17:57:07');
INSERT INTO `personal_access_tokens` VALUES (35, 'App\\Models\\User', 7, 'authToken', '094e61ce527aef355a85692b360cba94c78ffe3c4ad2df5bfc72bf1982eea825', '[\"*\"]', '2025-03-06 20:24:22', NULL, '2025-03-05 18:18:39', '2025-03-06 20:24:22');
INSERT INTO `personal_access_tokens` VALUES (36, 'App\\Models\\User', 8, 'authToken', 'd151eb062780cbeed55f8fcd268268040b51d370f060c353df081786cc521e3c', '[\"*\"]', NULL, NULL, '2025-03-06 16:47:56', '2025-03-06 16:47:56');
INSERT INTO `personal_access_tokens` VALUES (37, 'App\\Models\\User', 8, 'authToken', '5c883b7db50eb4fec7759d784f2a099e53bcf5329f8ae0d346d3d81c270f1aef', '[\"*\"]', NULL, NULL, '2025-03-06 17:08:28', '2025-03-06 17:08:28');
INSERT INTO `personal_access_tokens` VALUES (38, 'App\\Models\\User', 8, 'authToken', '9d85529adf4f9dd4b26d884bd1715199052d5b32209aa55667706ab73cebbc0c', '[\"*\"]', NULL, NULL, '2025-03-06 17:15:17', '2025-03-06 17:15:17');
INSERT INTO `personal_access_tokens` VALUES (39, 'App\\Models\\User', 8, 'authToken', 'e2fd43d9853430841fcd8eabdee38fef55a80f83ee2eafc369f90a10e43b00b7', '[\"*\"]', NULL, NULL, '2025-03-06 17:16:00', '2025-03-06 17:16:00');
INSERT INTO `personal_access_tokens` VALUES (40, 'App\\Models\\User', 7, 'authToken', '34a0e2809eeb82b7a1d6842adb10777c6bd614238167b860eb9b7db19a5e943c', '[\"*\"]', '2025-03-06 20:46:35', NULL, '2025-03-06 20:24:22', '2025-03-06 20:46:35');
INSERT INTO `personal_access_tokens` VALUES (41, 'App\\Models\\User', 7, 'authToken', '7e004a6f1043e902ce226890a65c9c9870b13289540ff920443e21bfd9758724', '[\"*\"]', '2025-03-10 17:42:01', NULL, '2025-03-06 20:28:07', '2025-03-10 17:42:01');
INSERT INTO `personal_access_tokens` VALUES (42, 'App\\Models\\User', 8, 'authToken', '10000075ed4336b9000249ed858dd6d090191ccd5e6c97e800c5865dca6bab87', '[\"*\"]', '2025-03-12 17:55:48', NULL, '2025-03-10 18:22:40', '2025-03-12 17:55:48');
INSERT INTO `personal_access_tokens` VALUES (43, 'App\\Models\\User', 50, 'authToken', 'e798fd5ad813b0051d689acdba40e03320b722f92d2f0b65fa23ecd19b409cd4', '[\"*\"]', NULL, NULL, '2025-09-10 03:55:50', '2025-09-10 03:55:50');
INSERT INTO `personal_access_tokens` VALUES (45, 'App\\Models\\User', 71, 'authToken', 'c8e0702095aaaf7795b5d43016ce7e9ab060e406c7db8533c366e82d1e2d7827', '[\"*\"]', NULL, NULL, '2025-09-10 03:57:08', '2025-09-10 03:57:08');
INSERT INTO `personal_access_tokens` VALUES (47, 'App\\Models\\User', 114, 'authToken', 'f6ed8e78e6b02923ed7e4038273f1185ded2dd1ba8d398660b6f3fb080ac39e3', '[\"*\"]', NULL, NULL, '2025-09-10 03:58:03', '2025-09-10 03:58:03');
INSERT INTO `personal_access_tokens` VALUES (49, 'App\\Models\\User', 119, 'authToken', '1256c85f17ef7ad59e52749ca2f9aece8548e5eca0c83f1e5035aa7bcfafb3aa', '[\"*\"]', NULL, NULL, '2025-09-10 04:43:03', '2025-09-10 04:43:03');
INSERT INTO `personal_access_tokens` VALUES (50, 'App\\Models\\User', 119, 'authToken', 'f5a6a302a2325d9974bcd84c85ae745b0d69b2c41d0e7682507c4871d9887078', '[\"*\"]', '2025-09-10 04:44:51', NULL, '2025-09-10 04:43:04', '2025-09-10 04:44:51');
INSERT INTO `personal_access_tokens` VALUES (51, 'App\\Models\\User', 119, 'authToken', '8668b5d2bdf3ab57133654bbbb77326123e258ecc2211d32f3dacdb95a33c709', '[\"*\"]', '2025-09-10 04:56:04', NULL, '2025-09-10 04:50:56', '2025-09-10 04:56:04');
INSERT INTO `personal_access_tokens` VALUES (52, 'App\\Models\\User', 119, 'authToken', 'd00fd58ba35b6bb5ef9b0ac235abd38d2b0ff634ac09688b28f0a6d579b3139a', '[\"*\"]', '2025-09-10 05:18:45', NULL, '2025-09-10 05:11:28', '2025-09-10 05:18:45');
INSERT INTO `personal_access_tokens` VALUES (53, 'App\\Models\\User', 119, 'authToken', '565678b507a2525816484415a0047f8bb5c9f74e30a75a628c589d7c63ef592e', '[\"*\"]', '2025-09-10 06:34:41', NULL, '2025-09-10 06:33:14', '2025-09-10 06:34:41');
INSERT INTO `personal_access_tokens` VALUES (54, 'App\\Models\\User', 119, 'authToken', '050609498a37a1c729fbb9366422f5ecb356a4d99a4fa678cf63b891b1899073', '[\"*\"]', '2025-09-10 06:50:46', NULL, '2025-09-10 06:47:15', '2025-09-10 06:50:46');
INSERT INTO `personal_access_tokens` VALUES (55, 'App\\Models\\User', 119, 'authToken', '5fe6fe7cf2bd48cf2bc34e4e18cfc8a8d3dc5e0a8fc19848c04523a6308e85a2', '[\"*\"]', '2025-09-10 06:55:01', NULL, '2025-09-10 06:53:21', '2025-09-10 06:55:01');
INSERT INTO `personal_access_tokens` VALUES (56, 'App\\Models\\User', 119, 'authToken', '4b01b4ecb35d4a964082e47b763a019694fc5868fecb8270259d01551f1a81e2', '[\"*\"]', '2025-09-10 07:05:20', NULL, '2025-09-10 07:02:18', '2025-09-10 07:05:20');
INSERT INTO `personal_access_tokens` VALUES (57, 'App\\Models\\User', 119, 'authToken', '252965294e02c6b1b661e3c0172161449115585b8257e4d85d43b49e72e2de26', '[\"*\"]', '2025-09-10 07:09:39', NULL, '2025-09-10 07:05:55', '2025-09-10 07:09:39');
INSERT INTO `personal_access_tokens` VALUES (58, 'App\\Models\\User', 119, 'authToken', '82d268dbda95e13dd8376fa12c8c6708e00aad8e821f6fdb5bd810e48c6a6b8a', '[\"*\"]', NULL, NULL, '2025-09-10 07:16:17', '2025-09-10 07:16:17');
INSERT INTO `personal_access_tokens` VALUES (59, 'App\\Models\\User', 119, 'authToken', '1be14b04cd648e6a59c73785916311c4a3be4b64c179ecc51511232dc349e7f3', '[\"*\"]', NULL, NULL, '2025-09-10 07:23:50', '2025-09-10 07:23:50');
INSERT INTO `personal_access_tokens` VALUES (60, 'App\\Models\\User', 119, 'authToken', 'be03a1730c37dd277fadd777a7a371f7b4c44ee09ded07e8885460014f06f31b', '[\"*\"]', NULL, NULL, '2025-09-10 07:26:09', '2025-09-10 07:26:09');
INSERT INTO `personal_access_tokens` VALUES (61, 'App\\Models\\User', 119, 'authToken', '9fc5891ced7a834eff5f0f3dd19ece47502015cfe426b95ea4d149cba153213f', '[\"*\"]', NULL, NULL, '2025-09-10 07:27:46', '2025-09-10 07:27:46');
INSERT INTO `personal_access_tokens` VALUES (62, 'App\\Models\\User', 119, 'authToken', 'b2515307c3d47f0d6cdad996d8a7e0f8b4884c9a4e3a6ac1ab53fcc13ef63afe', '[\"*\"]', NULL, NULL, '2025-09-10 07:29:54', '2025-09-10 07:29:54');
INSERT INTO `personal_access_tokens` VALUES (63, 'App\\Models\\User', 119, 'authToken', '0febd6d1e144bf5904f693157fdd400f932931565b2e5d005f918298f06d718e', '[\"*\"]', NULL, NULL, '2025-09-10 07:32:53', '2025-09-10 07:32:53');
INSERT INTO `personal_access_tokens` VALUES (64, 'App\\Models\\User', 119, 'authToken', '6366d7bdca128f75b83c70b601b32f8c5417342d4b878cc8e0cb5c2d3040fbe7', '[\"*\"]', '2025-09-11 06:24:41', NULL, '2025-09-10 07:39:26', '2025-09-11 06:24:41');
INSERT INTO `personal_access_tokens` VALUES (65, 'App\\Models\\User', 119, 'authToken', 'd0f02595fdab4413799c190db15cbcdfc68e43b6907c33dbf3d86a6cee8417c8', '[\"*\"]', '2025-09-10 07:52:53', NULL, '2025-09-10 07:47:38', '2025-09-10 07:52:53');
INSERT INTO `personal_access_tokens` VALUES (66, 'App\\Models\\User', 119, 'authToken', '1061fbed59e204a9fcddb8e34cedabaa4369bd42db1bea1d4ab6126ea83329fc', '[\"*\"]', '2025-09-10 08:03:11', NULL, '2025-09-10 07:59:27', '2025-09-10 08:03:11');
INSERT INTO `personal_access_tokens` VALUES (67, 'App\\Models\\User', 119, 'authToken', 'c93f258ae805c4ff9b57fd6b06ff1fa7ad4d4f74ef8956fdd2d1b16260bcd074', '[\"*\"]', '2025-09-10 08:21:20', NULL, '2025-09-10 08:15:19', '2025-09-10 08:21:20');
INSERT INTO `personal_access_tokens` VALUES (68, 'App\\Models\\User', 119, 'authToken', 'a94443e2039c36988058c5848351f1b29c73f408b6625a21aabf16d671715e94', '[\"*\"]', '2025-09-10 08:23:18', NULL, '2025-09-10 08:23:16', '2025-09-10 08:23:18');
INSERT INTO `personal_access_tokens` VALUES (69, 'App\\Models\\User', 119, 'authToken', '9379932d78c2e15349794f2110222b911bc5f68e189b37fb6a9373e2ef86245a', '[\"*\"]', '2025-09-10 08:38:54', NULL, '2025-09-10 08:25:51', '2025-09-10 08:38:54');
INSERT INTO `personal_access_tokens` VALUES (70, 'App\\Models\\User', 119, 'authToken', '5b2930d156bfbf2a5079e1005d444ae26f63eb3737ea392e958c3d2bbd4a00cb', '[\"*\"]', '2025-09-10 08:50:09', NULL, '2025-09-10 08:42:17', '2025-09-10 08:50:09');
INSERT INTO `personal_access_tokens` VALUES (71, 'App\\Models\\User', 119, 'authToken', '358f9e4c74457b3a9a52a32e26ec69ed273d2ccadcfa3f1aa819c3b246b40fc7', '[\"*\"]', '2025-09-10 08:55:31', NULL, '2025-09-10 08:51:33', '2025-09-10 08:55:31');
INSERT INTO `personal_access_tokens` VALUES (72, 'App\\Models\\User', 119, 'authToken', '053cbbc794c41a89cba319a957f7e6faf42f25fe7cc0f93b3f0fc09108d8ebfc', '[\"*\"]', '2025-09-10 09:04:01', NULL, '2025-09-10 08:58:44', '2025-09-10 09:04:01');
INSERT INTO `personal_access_tokens` VALUES (73, 'App\\Models\\User', 119, 'authToken', 'c8f0558dc4dff592852db2edaef793f9bb097292fb43ba012fb5771c14d9230c', '[\"*\"]', '2025-09-11 04:09:44', NULL, '2025-09-11 02:24:31', '2025-09-11 04:09:44');
INSERT INTO `personal_access_tokens` VALUES (74, 'App\\Models\\User', 119, 'authToken', '33469169642691a216f14eddee6500efecbe1c353f9ec9793cad82f994215bb1', '[\"*\"]', '2025-09-11 04:28:34', NULL, '2025-09-11 04:11:26', '2025-09-11 04:28:34');
INSERT INTO `personal_access_tokens` VALUES (75, 'App\\Models\\User', 119, 'authToken', '361b8766198ca198527ed89942dab0a51ff58ee9a8bafaff6989fc49751628c7', '[\"*\"]', '2025-09-11 04:41:00', NULL, '2025-09-11 04:31:16', '2025-09-11 04:41:00');
INSERT INTO `personal_access_tokens` VALUES (76, 'App\\Models\\User', 119, 'authToken', 'd199c7154e11bef083bd1404d9a1aa74729cfad551bc3c5b756206c3ddcb20fe', '[\"*\"]', '2025-09-11 05:52:17', NULL, '2025-09-11 04:47:11', '2025-09-11 05:52:17');
INSERT INTO `personal_access_tokens` VALUES (77, 'App\\Models\\User', 119, 'authToken', '8166b90c143b108160365ce42d80771718ff02578031be717a5116aa5d848a34', '[\"*\"]', '2025-09-11 06:23:14', NULL, '2025-09-11 06:00:00', '2025-09-11 06:23:14');
INSERT INTO `personal_access_tokens` VALUES (78, 'App\\Models\\User', 119, 'authToken', '3fa6efe859b6af40608eecc90ac71215fb0d7c1f421666a8fa0692fabdbb91e6', '[\"*\"]', '2025-09-11 06:40:41', NULL, '2025-09-11 06:25:05', '2025-09-11 06:40:41');
INSERT INTO `personal_access_tokens` VALUES (79, 'App\\Models\\User', 119, 'authToken', '4c0ccc21c252bc2acc5341794ead7c625647a2c98655de552bb9626fd2553065', '[\"*\"]', '2025-09-11 07:18:20', NULL, '2025-09-11 07:06:25', '2025-09-11 07:18:20');

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
) ENGINE = InnoDB AUTO_INCREMENT = 81 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of role_menus
-- ----------------------------
INSERT INTO `role_menus` VALUES (1, 1, 1, NULL, NULL);
INSERT INTO `role_menus` VALUES (2, 1, 2, NULL, NULL);
INSERT INTO `role_menus` VALUES (3, 1, 3, NULL, NULL);
INSERT INTO `role_menus` VALUES (4, 1, 4, NULL, NULL);
INSERT INTO `role_menus` VALUES (5, 1, 5, NULL, NULL);
INSERT INTO `role_menus` VALUES (73, 1, 38, NULL, NULL);
INSERT INTO `role_menus` VALUES (74, 1, 39, NULL, NULL);
INSERT INTO `role_menus` VALUES (75, 1, 40, NULL, NULL);
INSERT INTO `role_menus` VALUES (76, 1, 41, NULL, NULL);
INSERT INTO `role_menus` VALUES (77, 1, 42, NULL, NULL);
INSERT INTO `role_menus` VALUES (78, 1, 43, NULL, NULL);
INSERT INTO `role_menus` VALUES (79, 1, 44, NULL, NULL);
INSERT INTO `role_menus` VALUES (80, 1, 45, NULL, NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'SUPERADMIN', 'web', '2025-02-18 08:56:49', '2025-02-18 08:56:49');
INSERT INTO `roles` VALUES (3, 'admin', 'web', '2025-03-12 19:48:41', '2025-03-12 19:48:41');

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
INSERT INTO `sessions` VALUES ('5aYPRzvhPPXPFYOJ1aMSkslEn10jX8nI9dhIMKEi', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWk1QS1JzcmY1cXlLQ0tCUDVyZkRFRE1hcUF6WDY1Qm95dW5sWXJuVyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYWRtaW4vdXNlcnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1757565783);
INSERT INTO `sessions` VALUES ('Ami1e7nMEeo9eNvieMBMsOesVURbDT21GjF9E9Ub', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoia1NCRDh0cm1JOHlwMU1pR1c2Z3BsNElQMTU0TEJxbmxCUGRrbEMyUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9iYWJpZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo3OiJzdWNjZXNzIjt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6Nzoic3VjY2VzcyI7czoxMjoiVXNlciBkaWhhcHVzIjt9', 1757555835);
INSERT INTO `sessions` VALUES ('LN0pE7QHETrbjqEx3xbQuYDJy0qQccXt8qfpgdlV', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNUE4eG5xTmw0WXo2Y1VjRUwxUzVBOVVsRHJJb0xMZUhTdFlaQmFmOSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYWRtaW4vc2xlZXAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1757575119);
INSERT INTO `sessions` VALUES ('QuQVa94hjCq837Zn4obeYAWCno6HOujfa5M2Rd0y', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoic0VkZVlQZ05RMG9DMlFpVUwzSWx4YzYzZXZHY2lsQ3dxYjBteTMwWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1757573776);
INSERT INTO `sessions` VALUES ('yoHWToRL1uWqFiDcRmn41YqHQ52U7PPsuFoheX27', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNXp5WWlaV3NhYnhsdW5jUDc2blhBeFpnQlB1R2FHNUh5ODRKUEk4SCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM0OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYWRtaW4vZ3Jvd3RoIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1757557822);

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
INSERT INTO `settings` VALUES (1, 'Hanindya Mom', 'HanindyaMom adalah aplikasi baby tracker dari Indonesia yang dirancang khusus untuk membantu ibu dan ayah memantau pertumbuhan dan aktivitas bayi dengan mudah. Mulai dari jadwal menyusui, ganti popok, tidur, hingga perkembangan harian si kecil – semuanya dalam satu aplikasi sederhana dan praktis.', 'logos/1757476940_logo.png', 'favicons/1757476940_favicon.png', 'novasampoerna@gmail.com', '0895361034833', 'kejarkoding', '2025-02-18 09:08:56', '2025-09-11 03:03:32');

-- ----------------------------
-- Table structure for settings_apps
-- ----------------------------
DROP TABLE IF EXISTS `settings_apps`;
CREATE TABLE `settings_apps`  (
  `id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_uuid` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `timezone` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `unit` enum('ml','oz') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'ml',
  `notifications` tinyint(1) NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of settings_apps
-- ----------------------------
INSERT INTO `settings_apps` VALUES ('4a3966ee-965a-45d7-ac7b-20066b490d9a', '7ca298c8-27aa-4831-ad1a-5429b266f9ce', 'Asia/Jakarta', 'ml', 1, '2025-09-10 04:43:07', '2025-09-10 04:43:07');
INSERT INTO `settings_apps` VALUES ('eff12a1d-f38b-4834-94b1-96d23fdbc96b', '6e891ae3-2091-431b-a380-4d65949d6d49', 'Asia/Jakarta', 'oz', 0, '2025-09-10 03:57:09', '2025-09-10 03:57:09');

-- ----------------------------
-- Table structure for sleep_logs
-- ----------------------------
DROP TABLE IF EXISTS `sleep_logs`;
CREATE TABLE `sleep_logs`  (
  `id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `baby_id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `duration_minutes` int(11) NOT NULL,
  `notes` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sleep_logs
-- ----------------------------
INSERT INTO `sleep_logs` VALUES ('5e1d1f1a-c1ef-4fc0-8434-f7fff0019cf5', '0810619f-af3e-46d6-95b3-dc728ae16991', '2025-09-10 14:25:00', '2025-09-10 15:29:15', 64, NULL, '2025-09-10 08:29:19', '2025-09-10 08:29:19');
INSERT INTO `sleep_logs` VALUES ('e7e54590-8058-4754-bb32-c502607dbbba', '0810619f-af3e-46d6-95b3-dc728ae16991', '2025-09-11 09:31:00', '2025-09-11 10:31:00', 60, NULL, '2025-09-11 02:31:36', '2025-09-11 02:31:36');

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
  `photo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_username_unique`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 120 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, '9e9df8ba-de16-4b99-b0dc-7676ff0220c5', 'Admin', 'admin', 'admin@gmail.com', '2025-02-18 08:52:46', '$2y$12$DncXVy8bmctiX5.3662FpOVX80btc2JhVtC/am7L148h3ntZbq4Ci', 'stlGysawatSxp9DtXtIgjU4dedy1cQuWESOJGLzBwSQ9ERIJUYZRMg9VCVmv', '2025-02-18 08:52:46', '2025-09-11 06:46:04', '', 'uploads/users/user_1_1757573164.png');
INSERT INTO `users` VALUES (119, '7ca298c8-27aa-4831-ad1a-5429b266f9ce', 'nova', 'novaariyanto', 'novasampoerna@gmail.com', NULL, '$2y$12$ZVJ4QYkLzESMhO0CKNGzHOvjhNOSV5NXIze.jujpjPm8S3Fzj/13O', NULL, '2025-09-10 04:43:03', '2025-09-11 03:59:14', NULL, 'uploads/users/user_119_1757563154.png');

-- ----------------------------
-- Table structure for vaccine_schedules
-- ----------------------------
DROP TABLE IF EXISTS `vaccine_schedules`;
CREATE TABLE `vaccine_schedules`  (
  `id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `baby_id` char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `vaccine_name` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `schedule_date` date NOT NULL,
  `status` enum('scheduled','done') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'scheduled',
  `notes` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vaccine_schedules
-- ----------------------------
INSERT INTO `vaccine_schedules` VALUES ('2acbb4e8-31ee-49cc-b1e3-8ab166472702', '9c3f2356-7d4f-464f-b500-85a908419383', 'Vaksin Baru', '2025-09-11', 'done', NULL, '2025-09-11 03:05:36', '2025-09-11 03:05:41');
INSERT INTO `vaccine_schedules` VALUES ('5df13ed0-fac9-47eb-aa98-1085eed15bbd', '9c3f2356-7d4f-464f-b500-85a908419383', 'campak', '2025-09-11', 'scheduled', NULL, '2025-09-11 04:41:00', '2025-09-11 04:41:00');
INSERT INTO `vaccine_schedules` VALUES ('7e1a3648-c82a-433f-804b-4528790b8df0', '0810619f-af3e-46d6-95b3-dc728ae16991', 'Vaksin Baru2', '2025-09-10', 'scheduled', NULL, '2025-09-10 07:52:29', '2025-09-11 02:35:12');
INSERT INTO `vaccine_schedules` VALUES ('ece4df29-786c-47ae-88a6-1b2249bc1e0f', '0810619f-af3e-46d6-95b3-dc728ae16991', 'Vaksin Baru3', '2025-09-11', 'scheduled', 'test', '2025-09-11 02:35:26', '2025-09-11 02:35:26');

SET FOREIGN_KEY_CHECKS = 1;
