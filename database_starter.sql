-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 24, 2025 at 02:23 AM
-- Server version: 5.7.24
-- PHP Version: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasi_bbm`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('user_menus_1', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:3:{i:0;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:5;s:4:\"uuid\";s:36:\"f602469c-7303-4df9-9164-76ba63e2a5b0\";s:5:\"route\";s:1:\"#\";s:4:\"icon\";s:9:\"ti ti-key\";s:9:\"nama_menu\";s:11:\"Autentikasi\";s:9:\"parent_id\";N;s:10:\"created_at\";s:19:\"2025-02-18 02:17:37\";s:10:\"updated_at\";s:19:\"2025-05-21 03:15:30\";s:5:\"order\";i:1;s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:3:{i:0;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:1;s:4:\"uuid\";s:36:\"bb5e49c9-5c7b-4840-bb4b-b48a96e8a260\";s:5:\"route\";s:10:\"user.index\";s:4:\"icon\";s:10:\"ti ti-user\";s:9:\"nama_menu\";s:4:\"User\";s:9:\"parent_id\";i:5;s:10:\"created_at\";s:19:\"2025-02-18 02:01:15\";s:10:\"updated_at\";s:19:\"2025-05-21 03:15:30\";s:5:\"order\";i:2;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:1;s:4:\"uuid\";s:36:\"bb5e49c9-5c7b-4840-bb4b-b48a96e8a260\";s:5:\"route\";s:10:\"user.index\";s:4:\"icon\";s:10:\"ti ti-user\";s:9:\"nama_menu\";s:4:\"User\";s:9:\"parent_id\";i:5;s:10:\"created_at\";s:19:\"2025-02-18 02:01:15\";s:10:\"updated_at\";s:19:\"2025-05-21 03:15:30\";s:5:\"order\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";s:13:\"pivot_menu_id\";i:1;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:1;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:1;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:28;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}i:1;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";s:13:\"pivot_menu_id\";i:1;s:13:\"pivot_role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:1;s:7:\"role_id\";i:2;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:1;s:7:\"role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:28;s:12:\"pivotRelated\";r:144;s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:3;s:4:\"uuid\";s:36:\"9b1c00d5-5b6b-4161-b976-87a6da9573d1\";s:5:\"route\";s:10:\"role.index\";s:4:\"icon\";s:12:\"ti ti-shield\";s:9:\"nama_menu\";s:4:\"Role\";s:9:\"parent_id\";i:5;s:10:\"created_at\";s:19:\"2025-02-18 02:10:58\";s:10:\"updated_at\";s:19:\"2025-05-21 03:15:30\";s:5:\"order\";i:3;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:3;s:4:\"uuid\";s:36:\"9b1c00d5-5b6b-4161-b976-87a6da9573d1\";s:5:\"route\";s:10:\"role.index\";s:4:\"icon\";s:12:\"ti ti-shield\";s:9:\"nama_menu\";s:4:\"Role\";s:9:\"parent_id\";i:5;s:10:\"created_at\";s:19:\"2025-02-18 02:10:58\";s:10:\"updated_at\";s:19:\"2025-05-21 03:15:30\";s:5:\"order\";i:3;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";s:13:\"pivot_menu_id\";i:3;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:3;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:3;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:285;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}i:1;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";s:13:\"pivot_menu_id\";i:3;s:13:\"pivot_role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:3;s:7:\"role_id\";i:2;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:3;s:7:\"role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:285;s:12:\"pivotRelated\";r:401;s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:4;s:4:\"uuid\";s:36:\"1f2f5340-6912-42da-9331-ab768c5d44ee\";s:5:\"route\";s:10:\"menu.index\";s:4:\"icon\";s:10:\"ti ti-list\";s:9:\"nama_menu\";s:4:\"Menu\";s:9:\"parent_id\";i:5;s:10:\"created_at\";s:19:\"2025-02-18 02:15:39\";s:10:\"updated_at\";s:19:\"2025-05-21 03:15:30\";s:5:\"order\";i:4;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:4;s:4:\"uuid\";s:36:\"1f2f5340-6912-42da-9331-ab768c5d44ee\";s:5:\"route\";s:10:\"menu.index\";s:4:\"icon\";s:10:\"ti ti-list\";s:9:\"nama_menu\";s:4:\"Menu\";s:9:\"parent_id\";i:5;s:10:\"created_at\";s:19:\"2025-02-18 02:15:39\";s:10:\"updated_at\";s:19:\"2025-05-21 03:15:30\";s:5:\"order\";i:4;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";s:13:\"pivot_menu_id\";i:4;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:4;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:4;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:542;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}i:1;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";s:13:\"pivot_menu_id\";i:4;s:13:\"pivot_role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:4;s:7:\"role_id\";i:2;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:4;s:7:\"role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:542;s:12:\"pivotRelated\";r:658;s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:5;s:4:\"uuid\";s:36:\"f602469c-7303-4df9-9164-76ba63e2a5b0\";s:5:\"route\";s:1:\"#\";s:4:\"icon\";s:9:\"ti ti-key\";s:9:\"nama_menu\";s:11:\"Autentikasi\";s:9:\"parent_id\";N;s:10:\"created_at\";s:19:\"2025-02-18 02:17:37\";s:10:\"updated_at\";s:19:\"2025-05-21 03:15:30\";s:5:\"order\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:3:{i:0;r:28;i:1;r:285;i:2;r:542;}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";s:13:\"pivot_menu_id\";i:5;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:5;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:5;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:3;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}i:1;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";s:13:\"pivot_menu_id\";i:5;s:13:\"pivot_role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:5;s:7:\"role_id\";i:2;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:5;s:7:\"role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:3;s:12:\"pivotRelated\";r:899;s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:14;s:4:\"uuid\";s:36:\"65e1728b-0ea5-4cfd-8a60-50be200e94f8\";s:5:\"route\";s:1:\"#\";s:4:\"icon\";s:10:\"ti ti-list\";s:9:\"nama_menu\";s:11:\"Master Data\";s:9:\"parent_id\";N;s:10:\"created_at\";s:19:\"2025-02-25 13:53:39\";s:10:\"updated_at\";s:19:\"2025-05-21 03:20:33\";s:5:\"order\";i:2;s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:4:{i:0;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:6;s:4:\"uuid\";s:36:\"9ad70638-92b6-49e9-9b36-8a378bb24007\";s:5:\"route\";s:13:\"jabatan.index\";s:4:\"icon\";s:15:\"ti ti-briefcase\";s:9:\"nama_menu\";s:7:\"Jabatan\";s:9:\"parent_id\";i:14;s:10:\"created_at\";s:19:\"2025-02-18 03:30:14\";s:10:\"updated_at\";s:19:\"2025-05-21 03:15:30\";s:5:\"order\";i:6;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:6;s:4:\"uuid\";s:36:\"9ad70638-92b6-49e9-9b36-8a378bb24007\";s:5:\"route\";s:13:\"jabatan.index\";s:4:\"icon\";s:15:\"ti ti-briefcase\";s:9:\"nama_menu\";s:7:\"Jabatan\";s:9:\"parent_id\";i:14;s:10:\"created_at\";s:19:\"2025-02-18 03:30:14\";s:10:\"updated_at\";s:19:\"2025-05-21 03:15:30\";s:5:\"order\";i:6;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";s:13:\"pivot_menu_id\";i:6;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:6;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:6;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:1065;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}i:1;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";s:13:\"pivot_menu_id\";i:6;s:13:\"pivot_role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:6;s:7:\"role_id\";i:2;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:6;s:7:\"role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:1065;s:12:\"pivotRelated\";r:1181;s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:7;s:4:\"uuid\";s:36:\"0a0d3ce4-11af-4854-b7e8-ddbc7e460a8c\";s:5:\"route\";s:12:\"divisi.index\";s:4:\"icon\";s:14:\"ti ti-building\";s:9:\"nama_menu\";s:6:\"Divisi\";s:9:\"parent_id\";i:14;s:10:\"created_at\";s:19:\"2025-02-18 03:31:06\";s:10:\"updated_at\";s:19:\"2025-05-21 03:15:30\";s:5:\"order\";i:7;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:7;s:4:\"uuid\";s:36:\"0a0d3ce4-11af-4854-b7e8-ddbc7e460a8c\";s:5:\"route\";s:12:\"divisi.index\";s:4:\"icon\";s:14:\"ti ti-building\";s:9:\"nama_menu\";s:6:\"Divisi\";s:9:\"parent_id\";i:14;s:10:\"created_at\";s:19:\"2025-02-18 03:31:06\";s:10:\"updated_at\";s:19:\"2025-05-21 03:15:30\";s:5:\"order\";i:7;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";s:13:\"pivot_menu_id\";i:7;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:7;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:7;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:1322;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}i:1;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";s:13:\"pivot_menu_id\";i:7;s:13:\"pivot_role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:7;s:7:\"role_id\";i:2;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:7;s:7:\"role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:1322;s:12:\"pivotRelated\";r:1438;s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:11;s:4:\"uuid\";s:36:\"ad47e60a-f37e-4420-a2ad-a242c56eaa80\";s:5:\"route\";s:20:\"pegawai-master.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:7:\"Pegawai\";s:9:\"parent_id\";i:14;s:10:\"created_at\";s:19:\"2025-02-21 03:33:28\";s:10:\"updated_at\";s:19:\"2025-05-21 03:20:27\";s:5:\"order\";i:2;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:11;s:4:\"uuid\";s:36:\"ad47e60a-f37e-4420-a2ad-a242c56eaa80\";s:5:\"route\";s:20:\"pegawai-master.index\";s:4:\"icon\";s:11:\"ti ti-users\";s:9:\"nama_menu\";s:7:\"Pegawai\";s:9:\"parent_id\";i:14;s:10:\"created_at\";s:19:\"2025-02-21 03:33:28\";s:10:\"updated_at\";s:19:\"2025-05-21 03:20:27\";s:5:\"order\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";s:13:\"pivot_menu_id\";i:11;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:11;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:11;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:1579;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}i:1;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";s:13:\"pivot_menu_id\";i:11;s:13:\"pivot_role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:11;s:7:\"role_id\";i:2;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:11;s:7:\"role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:1579;s:12:\"pivotRelated\";r:1695;s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:15;s:4:\"uuid\";s:36:\"2fb40bdc-18c5-4b29-afc6-99fa6041bcc0\";s:5:\"route\";s:13:\"pegawai.index\";s:4:\"icon\";s:14:\"ti ti-database\";s:9:\"nama_menu\";s:14:\"Master Pegawai\";s:9:\"parent_id\";i:14;s:10:\"created_at\";s:19:\"2025-03-11 08:48:40\";s:10:\"updated_at\";s:19:\"2025-05-21 03:15:30\";s:5:\"order\";i:8;}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:15;s:4:\"uuid\";s:36:\"2fb40bdc-18c5-4b29-afc6-99fa6041bcc0\";s:5:\"route\";s:13:\"pegawai.index\";s:4:\"icon\";s:14:\"ti ti-database\";s:9:\"nama_menu\";s:14:\"Master Pegawai\";s:9:\"parent_id\";i:14;s:10:\"created_at\";s:19:\"2025-03-11 08:48:40\";s:10:\"updated_at\";s:19:\"2025-05-21 03:15:30\";s:5:\"order\";i:8;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";s:13:\"pivot_menu_id\";i:15;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:15;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:15;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:1836;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}i:1;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";s:13:\"pivot_menu_id\";i:15;s:13:\"pivot_role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:15;s:7:\"role_id\";i:2;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:15;s:7:\"role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:1836;s:12:\"pivotRelated\";r:1952;s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:14;s:4:\"uuid\";s:36:\"65e1728b-0ea5-4cfd-8a60-50be200e94f8\";s:5:\"route\";s:1:\"#\";s:4:\"icon\";s:10:\"ti ti-list\";s:9:\"nama_menu\";s:11:\"Master Data\";s:9:\"parent_id\";N;s:10:\"created_at\";s:19:\"2025-02-25 13:53:39\";s:10:\"updated_at\";s:19:\"2025-05-21 03:20:33\";s:5:\"order\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:4:{i:0;r:1065;i:1;r:1322;i:2;r:1579;i:3;r:1836;}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";s:13:\"pivot_menu_id\";i:14;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:14;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:14;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:1040;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}i:1;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";s:13:\"pivot_menu_id\";i:14;s:13:\"pivot_role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:14;s:7:\"role_id\";i:2;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:14;s:7:\"role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:1040;s:12:\"pivotRelated\";r:2194;s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:15:\"App\\Models\\Menu\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:2;s:4:\"uuid\";s:36:\"6ee7d0a1-4aca-4cc5-ba7b-7eb636977c57\";s:5:\"route\";s:13:\"settings.edit\";s:4:\"icon\";s:14:\"ti ti-settings\";s:9:\"nama_menu\";s:10:\"Pengaturan\";s:9:\"parent_id\";N;s:10:\"created_at\";s:19:\"2025-02-18 02:10:08\";s:10:\"updated_at\";s:19:\"2025-05-21 03:20:33\";s:5:\"order\";i:5;s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:2;s:4:\"uuid\";s:36:\"6ee7d0a1-4aca-4cc5-ba7b-7eb636977c57\";s:5:\"route\";s:13:\"settings.edit\";s:4:\"icon\";s:14:\"ti ti-settings\";s:9:\"nama_menu\";s:10:\"Pengaturan\";s:9:\"parent_id\";N;s:10:\"created_at\";s:19:\"2025-02-18 02:10:08\";s:10:\"updated_at\";s:19:\"2025-05-21 03:20:33\";s:5:\"order\";i:5;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:5:\"roles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"SUPERADMIN\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-18 01:56:49\";s:10:\"updated_at\";s:19:\"2025-02-18 01:56:49\";s:13:\"pivot_menu_id\";i:2;s:13:\"pivot_role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:2;s:7:\"role_id\";i:1;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:2;s:7:\"role_id\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:2335;s:12:\"pivotRelated\";O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:0;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:1:{s:10:\"guard_name\";s:3:\"web\";}s:11:\"\0*\0original\";a:0:{}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}i:1;O:15:\"App\\Models\\Role\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Pegawai\";s:10:\"guard_name\";s:3:\"web\";s:10:\"created_at\";s:19:\"2025-02-24 04:27:29\";s:10:\"updated_at\";s:19:\"2025-02-24 04:27:29\";s:13:\"pivot_menu_id\";i:2;s:13:\"pivot_role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"pivot\";O:44:\"Illuminate\\Database\\Eloquent\\Relations\\Pivot\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"role_menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:0;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:7:\"menu_id\";i:2;s:7:\"role_id\";i:2;}s:11:\"\0*\0original\";a:2:{s:7:\"menu_id\";i:2;s:7:\"role_id\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}s:11:\"pivotParent\";r:2335;s:12:\"pivotRelated\";r:2457;s:13:\"\0*\0foreignKey\";s:7:\"menu_id\";s:13:\"\0*\0relatedKey\";s:7:\"role_id\";}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:2:\"id\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"uuid\";i:1;s:5:\"route\";i:2;s:4:\"icon\";i:3;s:9:\"nama_menu\";i:4;s:9:\"parent_id\";i:5;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1750817662);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `divisis`
--

CREATE TABLE `divisis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `divisis`
--

INSERT INTO `divisis` (`id`, `uuid`, `nama`, `keterangan`, `created_at`, `updated_at`) VALUES
(6, '2df63e96-b296-4d89-b845-fdd2e4270f20', 'Apoteker', 'Apoteker', '2025-05-20 21:28:03', '2025-05-20 21:31:30'),
(7, '2efebd75-a08a-42f7-a591-ed537c5b1b34', 'Dokter_Umum_IGD', 'dokter IGD', '2025-05-20 21:28:43', '2025-05-20 21:32:18'),
(8, '73a140d6-2975-46ca-9c85-35aa8e7ebf29', 'PERAWAT_HD_RAJAL', 'perawat HD', '2025-05-20 21:29:22', '2025-05-21 00:40:42'),
(9, '8ca86588-dc04-4e52-adbd-aee3391e367b', 'PENATA', 'Perawat IBS', '2025-05-20 21:29:45', '2025-05-21 00:01:42'),
(10, '01c0d6a5-a972-4674-a288-40b1082d3e93', 'ASISTEN', 'ASISTEN', '2025-05-21 00:01:50', '2025-05-21 00:40:54'),
(11, '36dcaca8-5d8e-4ada-92df-3e837aa3de2a', 'PERAWAT', 'perawat/bidan', '2025-05-21 00:06:51', '2025-05-21 00:39:01'),
(12, '85c5d34b-3f95-4b6c-9547-bef8cbd6d095', 'PERAWAT_HD_RANAP', 'PERAWAT_HD_RANAP', '2025-05-21 00:25:32', '2025-05-21 00:40:48'),
(13, 'ee99cbe3-294e-4366-9650-be7873905b73', 'STRUKTURAL', 'STRUKTURAL', '2025-05-21 01:11:59', '2025-05-21 01:11:59'),
(14, '013d7af3-41cb-4b51-8d6d-feeea8a118d6', 'JTL', 'JTL', '2025-05-21 01:12:05', '2025-05-21 01:12:05');

-- --------------------------------------------------------

--
-- Table structure for table `divisi_shifts`
--

CREATE TABLE `divisi_shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `divisi_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `jam_kerjas`
--

CREATE TABLE `jam_kerjas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `senin_masuk` time DEFAULT NULL,
  `senin_pulang` time DEFAULT NULL,
  `selasa_masuk` time DEFAULT NULL,
  `selasa_pulang` time DEFAULT NULL,
  `rabu_masuk` time DEFAULT NULL,
  `rabu_pulang` time DEFAULT NULL,
  `kamis_masuk` time DEFAULT NULL,
  `kamis_pulang` time DEFAULT NULL,
  `jumat_masuk` time DEFAULT NULL,
  `jumat_pulang` time DEFAULT NULL,
  `sabtu_masuk` time DEFAULT NULL,
  `sabtu_pulang` time DEFAULT NULL,
  `minggu_masuk` time DEFAULT NULL,
  `minggu_pulang` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `jam_kerjas`
--

INSERT INTO `jam_kerjas` (`id`, `shift_id`, `senin_masuk`, `senin_pulang`, `selasa_masuk`, `selasa_pulang`, `rabu_masuk`, `rabu_pulang`, `kamis_masuk`, `kamis_pulang`, `jumat_masuk`, `jumat_pulang`, `sabtu_masuk`, `sabtu_pulang`, `minggu_masuk`, `minggu_pulang`, `created_at`, `updated_at`) VALUES
(1, 14, '23:12:00', '01:01:00', '10:07:00', '10:10:00', '11:00:00', '11:00:00', '11:00:00', '10:59:00', '10:07:00', '10:10:00', '10:07:00', '10:10:00', '07:00:00', '15:00:00', '2025-02-18 20:18:11', '2025-02-27 04:14:08'),
(2, 13, '13:25:00', '15:15:00', '10:25:00', '11:00:00', '10:23:00', '11:00:00', '07:00:00', '15:15:00', '07:00:00', '15:15:00', '07:00:00', '15:15:00', NULL, NULL, '2025-02-18 20:26:30', '2025-03-11 03:23:18'),
(3, 12, '07:00:00', '15:15:00', '12:30:00', '12:37:00', '07:00:00', '15:15:00', '14:03:00', '15:15:00', '07:00:00', '15:15:00', '07:00:00', '15:15:00', NULL, NULL, '2025-02-18 21:18:58', '2025-03-06 07:03:52');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_menu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `uuid`, `route`, `icon`, `nama_menu`, `parent_id`, `created_at`, `updated_at`, `order`) VALUES
(1, 'bb5e49c9-5c7b-4840-bb4b-b48a96e8a260', 'user.index', 'ti ti-user', 'User', 5, '2025-02-17 19:01:15', '2025-05-20 20:15:30', 2),
(2, '6ee7d0a1-4aca-4cc5-ba7b-7eb636977c57', 'settings.edit', 'ti ti-settings', 'Pengaturan', NULL, '2025-02-17 19:10:08', '2025-05-20 20:20:33', 5),
(3, '9b1c00d5-5b6b-4161-b976-87a6da9573d1', 'role.index', 'ti ti-shield', 'Role', 5, '2025-02-17 19:10:58', '2025-05-20 20:15:30', 3),
(4, '1f2f5340-6912-42da-9331-ab768c5d44ee', 'menu.index', 'ti ti-list', 'Menu', 5, '2025-02-17 19:15:39', '2025-05-20 20:15:30', 4),
(5, 'f602469c-7303-4df9-9164-76ba63e2a5b0', '#', 'ti ti-key', 'Autentikasi', NULL, '2025-02-17 19:17:37', '2025-05-20 20:15:30', 1),
(6, '9ad70638-92b6-49e9-9b36-8a378bb24007', 'jabatan.index', 'ti ti-briefcase', 'Jabatan', 14, '2025-02-17 20:30:14', '2025-05-20 20:15:30', 6),
(7, '0a0d3ce4-11af-4854-b7e8-ddbc7e460a8c', 'divisi.index', 'ti ti-building', 'Divisi', 14, '2025-02-17 20:31:06', '2025-05-20 20:15:30', 7),
(11, 'ad47e60a-f37e-4420-a2ad-a242c56eaa80', 'pegawai-master.index', 'ti ti-users', 'Pegawai', 14, '2025-02-20 20:33:28', '2025-05-20 20:20:27', 2),
(14, '65e1728b-0ea5-4cfd-8a60-50be200e94f8', '#', 'ti ti-list', 'Master Data', NULL, '2025-02-25 06:53:39', '2025-05-20 20:20:33', 2),
(15, '2fb40bdc-18c5-4b29-afc6-99fa6041bcc0', 'pegawai.index', 'ti ti-database', 'Master Pegawai', 14, '2025-03-11 01:48:40', '2025-05-20 20:15:30', 8);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(9, '0001_01_01_000000_create_users_table', 1),
(10, '0001_01_01_000001_create_cache_table', 1),
(11, '0001_01_01_000002_create_jobs_table', 1),
(12, '2025_02_18_013140_create_settings_table', 1),
(13, '2025_02_18_014202_create_permission_tables', 1),
(14, '2025_02_18_015415_create_menus_table', 2),
(15, '2025_02_18_015517_create_role_menus_table', 2),
(16, '2025_02_18_031243_create_divisis_table', 3),
(17, '2025_02_18_031322_create_jabatans_table', 3),
(19, '2025_02_18_040607_create_radii_table', 5),
(21, '2025_02_18_034610_create_shifts_table', 6),
(22, '2025_02_18_061406_create_jam_kerjas_table', 6),
(23, '2025_02_19_005354_create_divisi_shifts_table', 6),
(34, '2025_02_20_034830_create_pegawai_masters_table', 7),
(35, '2025_02_22_011112_create_pegawai_shifts_table', 8),
(36, '2025_02_24_014835_create_presensis_table', 8),
(37, '2025_02_24_032535_create_personal_access_tokens_table', 9),
(38, '2025_02_24_033112_create_o_t_p_verifications_table', 10),
(41, '2025_02_25_005648_create_user_photos_table', 11),
(42, '2025_05_14_041214_create_proporsi_fairness_table', 12),
(43, '2025_05_14_044119_create_grade_table', 13),
(44, '2025_05_14_050000_create_sumbers_table', 14),
(45, '2025_05_14_050000_create_sumber_table', 15),
(46, '2024_01_15_create_remunerasi_batch_table', 16),
(47, '2024_01_15_create_remunerasi_source_table', 17),
(48, '2024_03_19_000001_create_detail_source_table', 18);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 10);

-- --------------------------------------------------------

--
-- Table structure for table `o_t_p_verifications`
--

CREATE TABLE `o_t_p_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_masters`
--

CREATE TABLE `pegawai_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan_id` int(11) NOT NULL,
  `divisi_id` int(11) NOT NULL,
  `status` enum('aktif','non_aktif') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pegawai_masters`
--

INSERT INTO `pegawai_masters` (`id`, `uuid`, `nik`, `nama`, `jabatan_id`, `divisi_id`, `status`, `created_at`, `updated_at`, `id_user`) VALUES
(1, 'b4d0cdd1-0e39-4b27-849d-0df3155e4818', '3507182109970003', 'MUHAMMAD NAJMUL FAIZ', 3, 4, 'aktif', '2025-02-23 20:07:41', '2025-02-24 18:38:41', 7),
(2, '37c0a26c-4f71-4f3c-8744-86f078cce64f', '3318121902790001', 'THOMAS FREDY ERVAN ANANTO, S.Kom', 3, 4, 'aktif', '2025-02-23 20:07:41', '2025-02-23 20:07:41', NULL),
(3, 'c1494f04-1aca-49ce-998d-2e0ab712f8e2', '3318082502800001', 'VERRY KARLIYANTO, S.Kom', 3, 4, 'aktif', '2025-02-23 20:07:41', '2025-02-23 20:07:41', NULL),
(4, '9f1e0f55-cb12-4006-ada1-461a5e0d8d72', '3318154812760001', 'PUJI DYAH HASTUTI', 3, 4, 'aktif', '2025-02-23 20:07:41', '2025-02-23 20:07:41', NULL),
(5, 'ed480de3-63e9-4b30-b35f-474cef9ae579', '3318172912870001', 'BUDI CAHYONO', 3, 4, 'aktif', '2025-02-23 20:07:41', '2025-02-23 20:07:41', NULL),
(6, '3b72b1e8-1b1a-47bd-9528-a29d5df2ce5c', '3309132109880002', 'EKO YUDHATAMA NUR ASLAM', 3, 4, 'aktif', '2025-02-23 20:07:42', '2025-02-24 18:43:11', 8),
(7, 'bf7d8c59-4b9c-4567-8394-06b4c824bf1b', '3318104703830008', 'PUJI UTAMI, SKM', 3, 4, 'aktif', '2025-02-23 20:07:42', '2025-02-23 20:07:42', NULL),
(10, '24720db6-2a11-4e8c-9ca0-610f6d19c53e', '3318107011720003', 'ATIK ENDROATI NAWANGSRI, A.Md', 3, 4, 'aktif', '2025-02-23 20:07:42', '2025-02-23 20:07:42', NULL),
(12, '1137f965-aacd-43a7-8569-f4557e7cb780', '3324192910880001', 'SETYO EDYATMO, SE', 3, 3, 'aktif', '2025-02-25 07:41:44', '2025-02-27 07:27:17', 9);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_shifts`
--

CREATE TABLE `pegawai_shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pegawai_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pegawai_shifts`
--

INSERT INTO `pegawai_shifts` (`id`, `uuid`, `pegawai_id`, `shift_id`, `tanggal`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(10, '1e15d8ff-0c82-4627-93d2-bf4c77b94ac6', 10, 13, '2025-02-01', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(50, 'db55e506-2fac-49a3-843c-0cc07a5891eb', 10, 13, '2025-02-06', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(60, '7ed131d8-9930-4d5e-bf1a-f441f40ceff8', 10, 13, '2025-02-07', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(70, 'cbbbbfde-8f16-4df2-b985-04f90dffd9b8', 10, 13, '2025-02-08', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(80, 'f5ed2a4a-4b7a-4124-bdc6-ff8be85462ee', 10, 13, '2025-02-10', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(90, 'ba9e53df-6739-4d61-8b88-94e2d5a011dd', 10, 13, '2025-02-11', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(100, '28dccdee-ea27-4758-a7e6-c1b228196db6', 10, 13, '2025-02-12', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(110, 'bb9f0181-2193-44dd-9445-26c58392ac54', 10, 13, '2025-02-13', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(120, 'f96204d6-2596-48ab-908b-773b36c6fc6c', 10, 13, '2025-02-14', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(130, 'f0c65f80-3042-4ad6-82ba-1da605c1b975', 10, 13, '2025-02-15', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(140, 'a92a90ef-d533-4f16-9495-22871923e696', 10, 13, '2025-02-17', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(150, '0efc0b65-40dc-42cf-bdf6-f0a16b29e128', 10, 13, '2025-02-18', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(160, '30aabf88-02a0-41d1-9ec5-1eebff4cff57', 10, 13, '2025-02-19', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(170, '28c3079a-4cbc-4584-b23f-e3d978e82569', 10, 13, '2025-02-20', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(180, '531e54bf-adfe-4482-912f-2f4ece911153', 10, 13, '2025-02-21', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(190, '49237cdd-e1c4-40fb-bb00-4513858aa237', 10, 13, '2025-02-22', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(192, 'cd68e72a-c455-4a79-9284-169196b5137b', 2, 13, '2025-02-24', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(193, '30c16f51-15ba-4dcf-a633-adeea30c45aa', 3, 13, '2025-02-24', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(194, 'ea22a546-4cf5-4611-8a5b-a3cea37c78db', 4, 13, '2025-02-24', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(195, 'b5172842-8731-40a6-ad2a-5e1a778e9140', 5, 13, '2025-02-24', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(196, 'ae84ee28-31cc-48c1-a7b6-c270ecf2bd6a', 6, 13, '2025-02-24', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(197, '0ad6a143-683f-4a07-ad52-55c8c01b5887', 7, 13, '2025-02-24', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(200, '3948d201-e700-42c1-9f6b-cb18eedc1b7d', 10, 13, '2025-02-24', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(202, 'eb7d3690-bb48-4fa8-b09e-bbc391949e82', 2, 13, '2025-02-25', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(203, 'edde1e81-187e-4322-82d1-5d7249e291ed', 3, 13, '2025-02-25', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(204, '4cb396fc-5312-468f-a952-de71b70973dc', 4, 13, '2025-02-25', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(205, 'cfd39a0a-94b5-4d4b-9763-98e8558d7023', 5, 13, '2025-02-25', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(206, 'c6b5f3d8-b015-4a6f-8a63-199a7b00db23', 6, 13, '2025-02-25', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(207, '8feb34d2-757c-4dd8-b550-061950614a7a', 7, 13, '2025-02-25', 1, 1, '2025-02-23 20:08:07', '2025-02-23 20:08:07'),
(210, '1cc0fe5a-8b20-4be6-8f75-c1da2b7cc830', 10, 13, '2025-02-25', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(212, 'd211d1b0-09c1-43fa-89d7-2ba565667cfd', 2, 13, '2025-02-26', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(213, 'e00c428a-d03c-4985-854c-26cdb5350a40', 3, 13, '2025-02-26', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(214, '9871ac3a-b6b4-48e8-8a4c-19b8a15f1a21', 4, 13, '2025-02-26', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(215, 'ebae2363-3b9b-4789-bfd9-c5bcfbc244a0', 5, 13, '2025-02-26', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(216, '63d3ee9f-367c-47c5-8d74-d1677330b5dd', 6, 14, '2025-02-26', 1, 1, '2025-02-23 20:08:08', '2025-02-27 04:15:49'),
(217, '6d7c18ed-cb79-4057-a2ea-b596ebd7b80b', 7, 13, '2025-02-26', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(220, 'e411b465-030e-4923-8b20-5d30f6d4fb15', 10, 13, '2025-02-26', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(222, '03f03c76-b118-4ba3-ad73-d7c4525349fa', 2, 13, '2025-02-27', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(223, '9587afbb-d37c-4ffa-b3ca-2a6be3596448', 3, 13, '2025-02-27', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(224, '02097390-1ea3-474c-9fc1-48a31f150481', 4, 13, '2025-02-27', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(225, 'e151afc8-a32d-45e0-b3c5-fd35d8bb4e3d', 5, 13, '2025-02-27', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(226, '9ab4f50b-9034-4d0b-8916-db582eae1d0b', 6, 13, '2025-02-27', 1, 1, '2025-02-23 20:08:08', '2025-02-27 04:23:20'),
(227, 'afe6ed89-d3f2-44d4-86b9-dfa683c6a622', 7, 13, '2025-02-27', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(230, '8ce1d062-bce0-4cff-b7c8-1b3ecd974410', 10, 13, '2025-02-27', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(232, '8597cbb9-286e-4aaf-b805-276a786e5713', 2, 13, '2025-02-28', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(233, '567b75df-c9b6-4259-bb49-3aa1d7fc8d07', 3, 13, '2025-02-28', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(234, '3fbd07b8-e94b-4aa0-b5e9-c35325cb2319', 4, 13, '2025-02-28', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(235, '16a2be20-4d6c-4d7f-98b7-7fee234cd55f', 5, 13, '2025-02-28', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(236, '03711c3c-453f-4284-80e3-952f6a068b82', 6, 13, '2025-02-28', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(237, 'd7bc9526-2f09-44f5-bc15-6f2fd2e4043c', 7, 13, '2025-02-28', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(240, '373332f7-df77-47ff-b383-16dc7e5b4546', 10, 13, '2025-02-28', 1, 1, '2025-02-23 20:08:08', '2025-02-23 20:08:08'),
(242, '7f5ac85b-d54d-4a59-a1c4-121ad99973a5', 2, 13, '2025-02-01', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(243, '048d86ea-6500-4729-8781-0d6357e38be5', 3, 13, '2025-02-01', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(244, '89556bee-db8e-4793-9e0f-cdbafed96945', 4, 13, '2025-02-01', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(245, 'cf1d8e96-4193-45c9-a295-897483335ca9', 5, 13, '2025-02-01', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(246, 'b5f72cf0-2dd8-4d4a-84b9-b2bef8d95c5a', 6, 13, '2025-02-01', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(247, 'a5bda9cc-faaa-47c1-ba4a-6c0f8cf14af9', 7, 13, '2025-02-01', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(273, 'aecfc989-aa19-48f6-91c1-f020e891036c', 1, 13, '2025-02-06', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(274, '57d50330-9cf3-4275-8686-0066fa637124', 2, 13, '2025-02-06', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(275, 'f60215c9-0275-4097-b5cc-d1a8e2688b61', 3, 13, '2025-02-06', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(276, '343f4b94-091f-496d-af16-cfba489a48ed', 4, 13, '2025-02-06', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(277, '3df26605-df36-49d7-8c03-7fe51b856ba9', 5, 13, '2025-02-06', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(278, 'ae56492d-59ed-45cd-8750-a65b05ebb69e', 6, 13, '2025-02-06', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(279, 'bedce655-3d63-43fe-a6d4-19c75a46590e', 7, 13, '2025-02-06', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(281, 'f4e583d6-16db-41a2-9d89-b8f5809d0e54', 1, 13, '2025-02-07', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(282, 'b2ecabcc-d760-4bc2-ab21-a15f3316d5d7', 2, 13, '2025-02-07', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(283, '3aa171db-61f9-4de4-a31b-ced6db26fd22', 3, 13, '2025-02-07', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(284, 'bb08b8a2-5960-4932-856f-089d7147b6f0', 4, 13, '2025-02-07', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(285, '47e83df0-b950-41de-b52a-1b089c9064b0', 5, 13, '2025-02-07', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(286, 'ca9110e4-1c41-40a8-8255-c435cbb99cab', 6, 13, '2025-02-07', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(287, '27c12c02-af7f-470b-89e7-7bc15b394b5d', 7, 13, '2025-02-07', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(289, 'c0ea426e-d0ca-4cc5-a6c1-02f178fe19ce', 1, 13, '2025-02-08', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(290, '9533ed32-40d1-4052-b0e0-73bfbcb91d43', 2, 13, '2025-02-08', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(291, 'aeb78c4a-a860-40ed-84f7-5dc84d824ec8', 3, 13, '2025-02-08', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(292, 'b4c0542a-cbd4-489b-b6a7-576cd57f9b08', 4, 13, '2025-02-08', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(293, '8fba1126-7c95-4b78-aa16-57fecca21165', 5, 13, '2025-02-08', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(294, 'a9bae194-1b04-4411-af68-551ab492d76a', 6, 13, '2025-02-08', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(295, 'd16ab19a-817d-424b-9a1d-7f86a4a20aa6', 7, 13, '2025-02-08', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(297, '92ef87e4-e4da-4bb4-90d2-f5980c2c3a13', 1, 13, '2025-02-10', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(298, '74160af9-f5ac-4d05-9a42-43fa580225c3', 2, 13, '2025-02-10', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(299, '3e259054-3bd9-459f-8bc2-9d10a8d235ac', 3, 13, '2025-02-10', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(300, 'efcfee1d-832f-41fa-985d-c9af81b06c0a', 4, 13, '2025-02-10', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(301, '33763b81-8b4b-4cd6-a5e9-f57129a037f8', 5, 13, '2025-02-10', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(302, '4eabfab4-ec9c-4560-856f-d1a3334ff688', 6, 13, '2025-02-10', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(303, '78a19f82-7cdb-47b0-b0ef-d08e50a91421', 7, 13, '2025-02-10', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(305, '1a846dbd-ba56-452a-97f3-eb54859dc8e3', 1, 13, '2025-02-11', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(306, '8d81aeed-f568-4305-93d9-77285b843a0e', 2, 13, '2025-02-11', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(307, '9ef7e082-6e80-44a2-9935-d95dc54c7afa', 3, 13, '2025-02-11', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(308, 'ea4037ce-9afd-4320-a670-0372471a105e', 4, 13, '2025-02-11', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(309, 'b4a39a81-8c1d-40cd-97b2-6334e36748b4', 5, 13, '2025-02-11', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(310, '8cb7316f-3562-4946-ac6c-6fcf6223c3e0', 6, 13, '2025-02-11', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(311, '62fd6831-ce40-4dfa-b966-af7483037683', 7, 13, '2025-02-11', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(313, '280d577e-5629-495b-8136-25b1c0a1c6bf', 1, 13, '2025-02-12', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(314, '63235f47-4ddc-429d-bfb8-873c6be023be', 2, 13, '2025-02-12', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(315, '807cdd6e-1b54-448f-8dac-f32c292816dd', 3, 13, '2025-02-12', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(316, 'fb3ad3fe-41e5-4f69-939c-51eb2fca4a16', 4, 13, '2025-02-12', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(317, '483de46c-d016-4e25-927e-6cf465169c73', 5, 13, '2025-02-12', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(318, 'b72c4f64-6686-4886-adc0-6e6ede6949f9', 6, 13, '2025-02-12', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(319, 'cd289f47-6c61-476f-9586-4a2480fff67a', 7, 13, '2025-02-12', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(321, '728328ac-eeba-4c92-aa49-9b2f8fa15527', 1, 13, '2025-02-13', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(322, '2513e75c-e4e3-474f-8134-5a2c775fbd94', 2, 13, '2025-02-13', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(323, '93980120-28f1-43ad-a801-6304703bd46f', 3, 13, '2025-02-13', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(324, '4502afff-9086-4b15-9c3b-32b00deb01ba', 4, 13, '2025-02-13', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(325, '5251e888-508a-4b18-9c3f-511622ada2df', 5, 13, '2025-02-13', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(326, 'c517381b-8020-4a6c-ac6f-31cbb4368646', 6, 13, '2025-02-13', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(327, '95bb4953-2312-46ac-b72c-b917deea387b', 7, 13, '2025-02-13', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(329, 'ff615600-21c2-4480-9219-3f7d749ac6de', 1, 13, '2025-02-14', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(330, 'b60c1748-62dd-4d20-84ea-3b14f6bbc984', 2, 13, '2025-02-14', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(331, '7b7260df-d562-4d1b-bb66-d6f0bde24f82', 3, 13, '2025-02-14', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(332, '54e4d35b-cf6d-4560-809c-03c7a852ef5d', 4, 13, '2025-02-14', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(333, 'dae87f0b-4803-428b-84a8-bc8e5a6f1c37', 5, 13, '2025-02-14', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(334, '4a8b141f-2ffa-4b68-a2ad-07d55b3eb25b', 6, 13, '2025-02-14', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(335, '2e8a6b24-f116-4ed2-b82a-9128948df064', 7, 13, '2025-02-14', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(337, '1bac76a1-60d0-4fde-b89f-3903059b7abd', 1, 13, '2025-02-15', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(338, '7a9504c6-fa91-4edf-92a3-334ce39fa6a6', 2, 13, '2025-02-15', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(339, 'a6df1330-48e3-435e-b401-9f660586dd3b', 3, 13, '2025-02-15', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(340, '5db0fcb5-75bf-49d1-9093-d97a7015e9a2', 4, 13, '2025-02-15', 1, 1, '2025-02-23 21:51:49', '2025-02-27 07:23:33'),
(341, '3150ada2-6fa3-4ed9-8b9c-8c7330ded2b9', 5, 13, '2025-02-15', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(342, '45392c8c-0783-4930-af65-c5125d926f80', 6, 13, '2025-02-15', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(343, '00e04a6d-5670-402e-b5c5-8cb75c93c2f5', 7, 13, '2025-02-15', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(345, '5a0f633b-47af-4bdd-9799-51cee4c66ba3', 1, 13, '2025-02-17', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(346, '59778537-4934-422f-a98d-be388c985123', 2, 13, '2025-02-17', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(347, '1aa254aa-30b3-4de8-877f-b921d856bffd', 3, 13, '2025-02-17', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(348, '8d33cc4f-4095-4381-8e32-c29bcd23a065', 4, 13, '2025-02-17', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(349, 'fb24b7bf-bed3-4ebd-a735-084797c80801', 5, 13, '2025-02-17', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(350, '595e2e02-54e5-422f-8e83-b0c41f8b04c0', 6, 13, '2025-02-17', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(351, '7c268b6a-abc6-4a09-86ac-7373c0db239b', 7, 13, '2025-02-17', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(353, 'cec07fb4-7f65-43ed-9a1e-21f65f66fe0d', 1, 13, '2025-02-18', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(354, '8f6f76e1-5796-4ae6-a68d-b4d08b72d6c5', 2, 13, '2025-02-18', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(355, 'f50e9858-22bb-4699-bdc1-35e8180894c1', 3, 13, '2025-02-18', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(356, 'e7c7dc26-adc5-48ca-af80-8373d15e4c04', 4, 13, '2025-02-18', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(357, '8eef1e1b-cb9d-4967-8629-05997cefa413', 5, 13, '2025-02-18', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(358, '81773061-bb90-42f1-9687-3a50a91ac46a', 6, 13, '2025-02-18', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(359, 'a76591db-5d60-4cc7-87d0-03b3bb51c5fa', 7, 13, '2025-02-18', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(361, '04f8b562-a8ed-4027-b806-02f4d0b2bfd1', 1, 13, '2025-02-19', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(362, '5b6ce3a4-0b0b-4a27-8f48-b557426135b4', 2, 13, '2025-02-19', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(363, 'c974b9f0-06bf-4e0a-9e00-9acf49e7bca0', 3, 13, '2025-02-19', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(364, '55427c4b-5db8-44f7-a0b8-65e3d98ff18c', 4, 13, '2025-02-19', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(365, '850d830e-e581-4ed3-b504-c017026f90e5', 5, 13, '2025-02-19', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(366, '402e889a-85f1-42da-b28f-f178b0989039', 6, 13, '2025-02-19', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(367, 'ce6112cb-8f4b-411e-bc03-b55171c30e04', 7, 13, '2025-02-19', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(369, 'bf11318a-e7fe-4fac-8e4f-ff80a55a6171', 1, 13, '2025-02-20', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(370, 'e480d2c3-d374-4f3d-b6f0-bdec1efa705f', 2, 13, '2025-02-20', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(371, 'c430be8a-f51b-49f2-b0fa-67f86997042e', 3, 13, '2025-02-20', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(372, 'a4b3b638-e87d-4680-a62e-bf589b2851f4', 4, 13, '2025-02-20', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(373, '7f6fd736-e4be-4b07-adbb-17c073d93fef', 5, 13, '2025-02-20', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(374, 'f59c4c72-0832-42b1-b07e-92b5468e5271', 6, 13, '2025-02-20', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(375, '8f677831-db25-4ecb-88e7-1ba94c3d0c7b', 7, 13, '2025-02-20', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(377, 'b1fbb7c0-862a-43ac-be2a-cca4f6077ad4', 1, 13, '2025-02-21', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(378, '5da08d7e-6f79-476b-aee1-fa40a97025f5', 2, 13, '2025-02-21', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(379, '859a48be-e554-4cab-becb-11c4bafd401a', 3, 13, '2025-02-21', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(380, 'ecd5201a-87c1-47f2-9e5f-9a97823c2a16', 4, 13, '2025-02-21', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(381, 'ca300dfa-8657-4942-928a-ec8e1f1357c7', 5, 13, '2025-02-21', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(382, '3a3f95ec-3d45-495a-a3d8-d1cb666f3d50', 6, 13, '2025-02-21', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(383, 'ecad99dd-4bac-46c2-a5d0-68dc3187566a', 7, 13, '2025-02-21', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(385, 'b2e0c3c9-0b80-406f-a854-579365601578', 1, 13, '2025-02-22', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(386, '3c59b3e4-69ca-472b-9a89-5db23bafb46e', 2, 13, '2025-02-22', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(387, '55d1e182-008b-4ef6-a7c7-2033f1df3ecf', 3, 13, '2025-02-22', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(388, '2d781519-7d3d-480c-b265-a5c4d4f1c7bb', 4, 13, '2025-02-22', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(389, '8fca89df-9a6c-49c3-8d21-1498df86ec52', 5, 13, '2025-02-22', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(390, '5620443e-3bb7-450b-b287-c93d8a188ad0', 6, 13, '2025-02-22', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(391, 'b42521c9-2e48-44a2-bf35-beea330d05c6', 7, 13, '2025-02-22', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(393, 'b1c9c3e2-31d6-4951-9f04-9723c5b1eb72', 1, 13, '2025-02-24', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(394, '29434099-eb00-434a-b714-1d80fba23ce0', 1, 13, '2025-02-25', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(395, '146887c9-62d8-438f-9a45-858b97215766', 1, 13, '2025-02-26', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(396, '7ef83dc2-8ded-44f9-b633-182a3073898d', 1, 13, '2025-02-27', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(397, 'bedcb9f7-f412-4b1b-8609-4c61ca313703', 1, 13, '2025-02-28', 1, 1, '2025-02-23 21:51:49', '2025-02-23 21:51:49'),
(430, '63d7d0aa-6a34-4248-ac2b-8170473e5cc7', 12, 13, '2025-02-01', 1, 1, '2025-02-27 06:59:37', '2025-02-27 06:59:37'),
(434, '10876386-7abc-4f7d-939b-5a2c9eb91ca9', 12, 13, '2025-02-06', 1, 1, '2025-02-27 06:59:37', '2025-02-27 06:59:37'),
(435, 'f1830b55-5693-454f-b756-5648886be4ce', 12, 13, '2025-02-07', 1, 1, '2025-02-27 06:59:37', '2025-02-27 06:59:37'),
(436, 'cd189a75-0501-4632-9ae7-f264e0097560', 12, 13, '2025-02-08', 1, 1, '2025-02-27 06:59:37', '2025-02-27 06:59:37'),
(437, 'c101bd93-37c6-480a-b1e5-93e0ec7118bd', 12, 13, '2025-02-10', 1, 1, '2025-02-27 06:59:37', '2025-02-27 06:59:37'),
(438, 'ff1046c2-5f57-4941-97c3-48888aaf6893', 12, 13, '2025-02-11', 1, 1, '2025-02-27 06:59:37', '2025-02-27 06:59:37'),
(439, '513f222c-e1e8-4f21-8bb0-d2de53b40f74', 12, 13, '2025-02-12', 1, 1, '2025-02-27 06:59:37', '2025-02-27 06:59:37'),
(440, '59d904b0-26f6-4175-8f0b-c4e9b4d404f2', 12, 13, '2025-02-13', 1, 1, '2025-02-27 06:59:37', '2025-02-27 06:59:37'),
(441, 'c162738f-3884-4f3d-b8a7-e7b737c0097f', 12, 13, '2025-02-14', 1, 1, '2025-02-27 06:59:37', '2025-02-27 06:59:37'),
(442, '4e252dbe-73b1-4737-8813-83b606eb86cd', 12, 13, '2025-02-15', 1, 1, '2025-02-27 06:59:37', '2025-02-27 06:59:37'),
(443, '9ecc52e7-46b4-4b96-90c9-22d379f1a324', 1, 13, '2025-02-03', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(444, '740fc794-73aa-4c1e-bc09-9a62f77e7ec9', 2, 13, '2025-02-03', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(445, '2ae60479-141c-48df-b958-3b3564e6d1c3', 3, 13, '2025-02-03', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(446, 'bb36fab3-1b5f-49eb-a400-c4bb6a970cc5', 4, 13, '2025-02-03', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(447, '8c04183f-3003-434e-b05b-d6a3b5878e48', 5, 13, '2025-02-03', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(448, '32d07940-e1bd-4c04-9549-2990de56c742', 6, 13, '2025-02-03', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(449, '39a6d712-b09d-4c3d-8168-5dd590c9b8fc', 7, 13, '2025-02-03', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(450, '863da98f-c6a5-43dc-a56c-bab330631953', 10, 13, '2025-02-03', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(451, '9b1e8c38-37bc-4eb3-b151-3d7787cb1329', 12, 13, '2025-02-03', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(452, '0fcb9688-ea2a-4db1-b47f-77c602b78099', 1, 13, '2025-02-04', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(453, 'd809937d-f0f9-469e-a3ee-486b00861b46', 2, 13, '2025-02-04', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(454, 'ee659ea8-38ef-431a-8e7c-0574765e04af', 3, 13, '2025-02-04', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(455, '60bb7d9a-efec-4132-a774-c65a59d8e941', 4, 13, '2025-02-04', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(456, '9549eb72-a5e1-41d3-b80f-51a028a8f74f', 5, 13, '2025-02-04', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(457, '5d185163-8b24-4cfe-ae18-60da4ef16bee', 6, 13, '2025-02-04', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(458, 'aca45328-c787-4375-9ad5-60f849ca79ac', 7, 13, '2025-02-04', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(459, '3f5aa6cb-d65e-46ac-920c-4aa95569a34b', 10, 13, '2025-02-04', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(460, '08f85fc4-14ce-46c7-aed1-5552728c6a21', 12, 13, '2025-02-04', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(461, '9a16803b-9a4a-4678-a366-02f965f51976', 1, 13, '2025-02-05', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(462, 'f11a1d58-3a91-4755-b780-f5908c89f3cd', 2, 13, '2025-02-05', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(463, '40effb58-1d50-4339-b431-6167a0fa0815', 3, 13, '2025-02-05', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(464, 'b6381132-b1ae-4494-adcb-cb9f96e40331', 4, 13, '2025-02-05', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(465, '6dbb28ed-7bfe-44cb-bf76-add79ff7de37', 5, 13, '2025-02-05', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(466, '8a3881a0-8779-49be-894f-a49a0f7cdb8b', 6, 13, '2025-02-05', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(467, 'a49eed2d-6f01-4089-933d-66c3c0774c63', 7, 13, '2025-02-05', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(468, 'd7e55b89-f5d8-48c1-8640-5ad856059245', 10, 13, '2025-02-05', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(469, '37874d89-206a-4c15-927a-40bd6710f303', 12, 13, '2025-02-05', 1, 1, '2025-02-27 07:24:14', '2025-02-27 07:24:14'),
(470, '3bea29d0-67d3-4195-b665-5c82055346e6', 1, 13, '2025-02-01', 1, 1, '2025-02-27 07:26:54', '2025-02-27 07:26:54'),
(475, 'a5455f66-5287-4ac8-b89c-506fdf20e2a4', 1, 13, '2025-03-04', 1, 1, '2025-03-04 02:09:29', '2025-03-04 05:13:00'),
(476, '927eceb5-a132-4b7d-999d-ce73429c2d1b', 1, 13, '2025-03-01', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(477, '5b6bdc63-2c3f-4931-90a9-849a62263873', 1, 13, '2025-03-03', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(478, 'f3b4ec50-20e3-400a-99dd-7363e6bda294', 1, 13, '2025-03-05', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(479, 'f360badd-7269-4e56-bc02-37b5d421887d', 1, 13, '2025-03-06', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(480, 'd4e185e9-5686-42da-8585-6345ca0916c5', 1, 13, '2025-03-07', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(481, 'd8326b51-10d5-4d3c-bf88-ac545a04383a', 1, 13, '2025-03-08', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(482, '8379b298-42c4-4817-a7e7-fa43424a7fe0', 1, 13, '2025-03-10', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(483, 'a53d4bd2-ead1-4545-bd7c-43d8bfb4cef7', 1, 13, '2025-03-11', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(484, 'fc4e09d8-9314-4a79-8167-cd01444986b1', 1, 13, '2025-03-12', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(485, '12749432-e42b-4922-ba41-2d5f8229e525', 1, 13, '2025-03-13', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(486, '56bb7925-66dc-4070-b7f5-f3a2a575fe05', 1, 13, '2025-03-14', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(487, '3e7b9352-0f36-4ced-a524-c585fb810c57', 1, 13, '2025-03-15', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(488, '104f4fc7-95b5-4eb2-8608-7a51d92ee2dc', 1, 13, '2025-03-17', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(489, '61dc5d97-e7a4-4b87-9901-44c26f0b4ba9', 1, 13, '2025-03-18', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(490, 'a3a7a2cc-d2cf-4ae7-929c-30dd163217f1', 1, 13, '2025-03-19', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(491, 'cb43f4b7-155a-4c93-a79a-dfad8060c855', 1, 13, '2025-03-20', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(492, '4a0b69ae-7304-4cfb-a8e0-256d43249837', 1, 13, '2025-03-21', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(493, 'ee0dc06c-b63f-4a53-a55d-7681b7b01a19', 1, 13, '2025-03-22', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(494, '3c805a18-a62e-4380-8e6a-40709fb09e46', 1, 13, '2025-03-24', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(495, '59d509ba-8b03-4040-bc81-8540ac41ec9d', 1, 13, '2025-03-25', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(496, '2b108c4b-488c-490e-ba58-c82a587e245a', 1, 13, '2025-03-26', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(497, 'f15409a0-6b67-4706-b31d-4a437c00b85e', 1, 13, '2025-03-27', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(498, '04f15144-4cf2-49b5-ab18-bdd33bb59036', 1, 13, '2025-03-28', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(499, '1ee50fc9-a130-4d71-9d95-5642fc079920', 1, 13, '2025-03-29', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(500, '064e1862-96a6-4d8f-9290-22ebf723c1bb', 1, 13, '2025-03-31', 1, 1, '2025-03-04 05:24:26', '2025-03-04 05:24:26'),
(501, 'ae0a43c3-bdcf-4e2c-99b5-f533e5d9118b', 6, 12, '2025-03-04', 1, 1, '2025-03-04 05:32:43', '2025-03-04 05:33:36'),
(502, '27a5453e-7bd1-4e99-bcb1-a57daf386c14', 6, 12, '2025-03-03', 1, 1, '2025-03-05 02:17:52', '2025-03-05 02:17:52'),
(503, '4cc96769-24c5-4753-a646-0c2904b93e55', 6, 13, '2025-03-05', 1, 1, '2025-03-06 02:49:15', '2025-03-06 02:49:15'),
(504, '154664a3-c8b1-4cb6-b1b4-7677349c7f58', 6, 12, '2025-03-06', 1, 1, '2025-03-06 02:49:31', '2025-03-06 06:48:20'),
(505, '3c4e05f4-9ac6-4be3-a681-48f1098094ec', 6, 13, '2025-03-10', 1, 1, '2025-03-10 04:25:01', '2025-03-10 04:28:56'),
(506, '1bfccf66-406d-407d-83fb-156facf34c1e', 6, 13, '2025-03-11', 1, 1, '2025-03-11 02:11:22', '2025-03-11 02:11:22'),
(507, '2bf01928-cfb2-40cc-aa8e-0d64d3538654', 6, 13, '2025-03-12', 1, 1, '2025-03-12 02:38:57', '2025-03-12 02:38:57');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 2, 'authToken', '30641497cdec3064c2e72e35a018c6c4070b57993f0191a347b35949549e4c9e', '[\"*\"]', NULL, NULL, '2025-02-23 20:52:00', '2025-02-23 20:52:00'),
(2, 'App\\Models\\User', 3, 'authToken', '7c9b7ca10f5c11ca20dd55b4191a575c67b8ca699bfe64b4a42896684114afff', '[\"*\"]', NULL, NULL, '2025-02-23 20:58:17', '2025-02-23 20:58:17'),
(3, 'App\\Models\\User', 4, 'authToken', '0eef9bd1cfdd0a8128809afcae30bf074b76e5d892870e46cb9353fe9e6b0e9c', '[\"*\"]', NULL, NULL, '2025-02-23 21:03:57', '2025-02-23 21:03:57'),
(4, 'App\\Models\\User', 5, 'authToken', 'bc38dac7770925ee1defd7e9cf55db8dd0bef148a4dc820778d2bdff176e312e', '[\"*\"]', NULL, NULL, '2025-02-23 21:05:15', '2025-02-23 21:05:15'),
(5, 'App\\Models\\User', 5, 'authToken', '2a4deb38e9b1ddf2910e1d812efdcdad7293b92534a5717fa941c24d233e05bf', '[\"*\"]', '2025-02-23 21:14:57', NULL, '2025-02-23 21:10:41', '2025-02-23 21:14:57'),
(6, 'App\\Models\\User', 5, 'authToken', 'bdd15a4a80d9dd08d8364113e18c8ae18d2f30b9dd1cef2adbef538155279ee1', '[\"*\"]', NULL, NULL, '2025-02-23 21:15:12', '2025-02-23 21:15:12'),
(7, 'App\\Models\\User', 5, 'authToken', '3b2371ec0ce8fba1e8b29cbf764190afeccf6d9b1a0b35a8e3b7e1b5c60dde5a', '[\"*\"]', NULL, NULL, '2025-02-23 21:15:52', '2025-02-23 21:15:52'),
(8, 'App\\Models\\User', 5, 'authToken', 'bb0f10e0d483ce21c095fe7a27eaf07fee236b0401aeba3a41c5435017a40fbf', '[\"*\"]', NULL, NULL, '2025-02-23 21:20:34', '2025-02-23 21:20:34'),
(9, 'App\\Models\\User', 5, 'authToken', '7cc5049f5ae7ebf98e810abff59d33a34623c6e104d340d56170fd4672dab55c', '[\"*\"]', NULL, NULL, '2025-02-23 21:23:23', '2025-02-23 21:23:23'),
(10, 'App\\Models\\User', 5, 'authToken', '63aa120907b715696c6a4522def5c30f995509378ec7102932181776942b9cb9', '[\"*\"]', '2025-02-23 21:26:45', NULL, '2025-02-23 21:23:43', '2025-02-23 21:26:45'),
(11, 'App\\Models\\User', 6, 'authToken', 'e362804cdf53090006872845c1c45d03838a5e6f73f98d9d1c2cda3215cdd859', '[\"*\"]', '2025-02-24 18:22:38', NULL, '2025-02-23 21:29:07', '2025-02-24 18:22:38'),
(12, 'App\\Models\\User', 7, 'authToken', '040dba3f735cf4e3f893d7d2d4806b685195863717ac9ce2d7250b02a0db3085', '[\"*\"]', NULL, NULL, '2025-02-24 18:38:41', '2025-02-24 18:38:41'),
(13, 'App\\Models\\User', 7, 'authToken', '5a5292c4f8d9d8e901968fbe41bfd8a2e8387718e2777a35d89892cca4239ca7', '[\"*\"]', '2025-02-25 02:12:54', NULL, '2025-02-24 18:39:51', '2025-02-25 02:12:54'),
(14, 'App\\Models\\User', 8, 'authToken', 'd8532a708a83e00029967734afaa6bbe4bc260e5d4c86bc65583e37aeb28c77a', '[\"*\"]', '2025-02-26 01:37:37', NULL, '2025-02-24 18:43:11', '2025-02-26 01:37:37'),
(15, 'App\\Models\\User', 7, 'authToken', '062ebcbd52956c4ea5038da79b24e32ed5ef7a4b18c8fe74ceed32245e8b1171', '[\"*\"]', NULL, NULL, '2025-02-25 02:14:01', '2025-02-25 02:14:01'),
(16, 'App\\Models\\User', 7, 'authToken', '608d2440da5a0372e5699ecf9439fe6f4ac719b362b99d215d0991f01df87ae4', '[\"*\"]', NULL, NULL, '2025-02-25 07:00:45', '2025-02-25 07:00:45'),
(17, 'App\\Models\\User', 7, 'authToken', 'd251b0484470be0ad4e1de9eda9dc15c5421ac87dcc2517cec379d28c79ca25c', '[\"*\"]', NULL, NULL, '2025-02-25 07:03:07', '2025-02-25 07:03:07'),
(18, 'App\\Models\\User', 8, 'authToken', 'f47e2cccd4ed27ae38f9d90980cf561ae28537c033f3222791f0d0dd1ae72576', '[\"*\"]', '2025-02-26 03:39:44', NULL, '2025-02-26 01:47:22', '2025-02-26 03:39:44'),
(19, 'App\\Models\\User', 8, 'authToken', 'b14cfed8729a6fe9dacf0f5a427859aee37dd5ef25afdc702714829d214c73da', '[\"*\"]', '2025-03-10 03:26:49', NULL, '2025-02-26 06:54:48', '2025-03-10 03:26:49'),
(20, 'App\\Models\\User', 8, 'authToken', 'c2ad4abe77865573800c61be4d7a8374b82e88b9dd138aa246da5dad37e78d8e', '[\"*\"]', NULL, NULL, '2025-02-26 07:34:38', '2025-02-26 07:34:38'),
(21, 'App\\Models\\User', 7, 'authToken', '8c7ea4880c6fe46922795bf0afcee2ad6ba25a835e1ca75c0df23d7cf3fb004b', '[\"*\"]', NULL, NULL, '2025-02-26 07:36:40', '2025-02-26 07:36:40'),
(22, 'App\\Models\\User', 8, 'authToken', '9e6ab6ddfd914d10030779553c63705f394e063e917d300422f9b9a351461449', '[\"*\"]', NULL, NULL, '2025-02-26 07:39:07', '2025-02-26 07:39:07'),
(23, 'App\\Models\\User', 8, 'authToken', 'eeff75d401775dd37ec12f0bafb1858e439b72569ed7296caa57569f5d53eca6', '[\"*\"]', NULL, NULL, '2025-02-26 07:41:43', '2025-02-26 07:41:43'),
(24, 'App\\Models\\User', 8, 'authToken', 'f5a11eede3a5b507c4a80bc35098f418fa6a0e8f3b11a2b52f329cc6ed4d31d2', '[\"*\"]', NULL, NULL, '2025-02-26 07:46:14', '2025-02-26 07:46:14'),
(25, 'App\\Models\\User', 8, 'authToken', 'b0af611303b379b9e960702d08821194f5e642a87f1cc34421487f2a5d9c1f96', '[\"*\"]', NULL, NULL, '2025-02-26 07:46:58', '2025-02-26 07:46:58'),
(26, 'App\\Models\\User', 8, 'authToken', 'f7c9d9c8a044ed8113fba16f3afb6b9b183eee49e846f091f62bc7c492a9ebca', '[\"*\"]', NULL, NULL, '2025-02-26 07:48:41', '2025-02-26 07:48:41'),
(27, 'App\\Models\\User', 8, 'authToken', 'a98ce5923adb676ba7e70972ad1b9b54c97394d27bd5c77784549867e3f8d53d', '[\"*\"]', NULL, NULL, '2025-02-26 07:50:40', '2025-02-26 07:50:40'),
(28, 'App\\Models\\User', 8, 'authToken', '87ba56205fda0688d517cfcc87f14f095bd0ec1ec06d6fa6aa0ef07e09cd3987', '[\"*\"]', NULL, NULL, '2025-02-26 07:51:39', '2025-02-26 07:51:39'),
(29, 'App\\Models\\User', 7, 'authToken', 'a25f75953722e0f83d65dc5b9db9fe81e60d630af787f38a46a9cbac3878a4a0', '[\"*\"]', '2025-02-27 04:07:40', NULL, '2025-02-26 08:06:16', '2025-02-27 04:07:40'),
(30, 'App\\Models\\User', 7, 'authToken', 'ef7451e7a3c56a693eff94096b91c14639e56bafcac1998bb01812bce5dcba0c', '[\"*\"]', '2025-03-06 06:25:06', NULL, '2025-02-27 01:38:27', '2025-03-06 06:25:06'),
(31, 'App\\Models\\User', 7, 'authToken', '367c6d7a5c3a9e65f501d0b880075c22a41daba00e8088b8b9cb028a56ac30f3', '[\"*\"]', '2025-03-04 05:26:44', NULL, '2025-03-04 01:34:22', '2025-03-04 05:26:44'),
(32, 'App\\Models\\User', 7, 'authToken', 'dc5794b77abecf47f5656e18661eee77bb1d33629d6b019e0d192175e3a90dd3', '[\"*\"]', '2025-03-05 06:59:06', NULL, '2025-03-05 01:46:26', '2025-03-05 06:59:06'),
(33, 'App\\Models\\User', 8, 'authToken', '6b7ec57a767b502642a24e5ecd9d4ee42b7d42a9ede7e05d05999c718b840a4f', '[\"*\"]', NULL, NULL, '2025-03-05 03:55:52', '2025-03-05 03:55:52'),
(34, 'App\\Models\\User', 8, 'authToken', 'de7d7d2616b1814036bfd849df8dc340270be9d1d641751eb8ce7a52235e3764', '[\"*\"]', NULL, NULL, '2025-03-05 03:57:07', '2025-03-05 03:57:07'),
(35, 'App\\Models\\User', 7, 'authToken', '094e61ce527aef355a85692b360cba94c78ffe3c4ad2df5bfc72bf1982eea825', '[\"*\"]', '2025-03-06 06:24:22', NULL, '2025-03-05 04:18:39', '2025-03-06 06:24:22'),
(36, 'App\\Models\\User', 8, 'authToken', 'd151eb062780cbeed55f8fcd268268040b51d370f060c353df081786cc521e3c', '[\"*\"]', NULL, NULL, '2025-03-06 02:47:56', '2025-03-06 02:47:56'),
(37, 'App\\Models\\User', 8, 'authToken', '5c883b7db50eb4fec7759d784f2a099e53bcf5329f8ae0d346d3d81c270f1aef', '[\"*\"]', NULL, NULL, '2025-03-06 03:08:28', '2025-03-06 03:08:28'),
(38, 'App\\Models\\User', 8, 'authToken', '9d85529adf4f9dd4b26d884bd1715199052d5b32209aa55667706ab73cebbc0c', '[\"*\"]', NULL, NULL, '2025-03-06 03:15:17', '2025-03-06 03:15:17'),
(39, 'App\\Models\\User', 8, 'authToken', 'e2fd43d9853430841fcd8eabdee38fef55a80f83ee2eafc369f90a10e43b00b7', '[\"*\"]', NULL, NULL, '2025-03-06 03:16:00', '2025-03-06 03:16:00'),
(40, 'App\\Models\\User', 7, 'authToken', '34a0e2809eeb82b7a1d6842adb10777c6bd614238167b860eb9b7db19a5e943c', '[\"*\"]', '2025-03-06 06:46:35', NULL, '2025-03-06 06:24:22', '2025-03-06 06:46:35'),
(41, 'App\\Models\\User', 7, 'authToken', '7e004a6f1043e902ce226890a65c9c9870b13289540ff920443e21bfd9758724', '[\"*\"]', '2025-03-10 03:42:01', NULL, '2025-03-06 06:28:07', '2025-03-10 03:42:01'),
(42, 'App\\Models\\User', 8, 'authToken', '10000075ed4336b9000249ed858dd6d090191ccd5e6c97e800c5865dca6bab87', '[\"*\"]', '2025-03-12 03:55:48', NULL, '2025-03-10 04:22:40', '2025-03-12 03:55:48');

-- --------------------------------------------------------

--
-- Table structure for table `presensis`
--

CREATE TABLE `presensis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pegawai_id` bigint(20) UNSIGNED NOT NULL,
  `pegawai_shift_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` timestamp NULL DEFAULT NULL,
  `jam_keluar` timestamp NULL DEFAULT NULL,
  `jam_masuk_jadwal` timestamp NULL DEFAULT NULL,
  `jam_keluar_jadwal` timestamp NULL DEFAULT NULL,
  `status` enum('hadir','terlambat','izin','sakit','alpha') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `longitude_masuk` text COLLATE utf8mb4_unicode_ci,
  `latitude_masuk` text COLLATE utf8mb4_unicode_ci,
  `longitude_keluar` text COLLATE utf8mb4_unicode_ci,
  `latitude_keluar` text COLLATE utf8mb4_unicode_ci,
  `face_landmarks_in` longtext COLLATE utf8mb4_unicode_ci,
  `face_landmarks_out` longtext COLLATE utf8mb4_unicode_ci,
  `terlambat_detik` int(11) DEFAULT NULL,
  `durasi_kerja_detik` int(11) DEFAULT NULL,
  `pulang_cepat_detik` int(11) DEFAULT NULL,
  `catatan` longtext COLLATE utf8mb4_unicode_ci,
  `divisi_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `radius`
--

CREATE TABLE `radius` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coordinates` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `width` decimal(10,2) NOT NULL,
  `height` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `radius`
--

INSERT INTO `radius` (`id`, `coordinates`, `width`, `height`, `created_at`, `updated_at`) VALUES
(23, '[[-6.73941360234213,111.04278266429901],[-6.737037598089341,111.04428470134737],[-6.737570335481318,111.04553997516634],[-6.740484398659177,111.04433298110962],[-6.73956276814001,111.04269683361055]]', '204.96', '304.48', '2025-03-06 06:24:38', '2025-03-06 06:24:38');

-- --------------------------------------------------------

--
-- Table structure for table `remunerasi_batch`
--

CREATE TABLE `remunerasi_batch` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_batch` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `remunerasi_batch`
--

INSERT INTO `remunerasi_batch` (`id`, `nama_batch`, `tanggal`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Batch Remunerasi Mei', '2025-05-22', 'draft', '2025-05-14 02:11:22', '2025-05-21 23:32:25'),
(2, 'Batch Remunerasi Juni', '2025-05-22', 'draft', '2025-05-20 20:55:04', '2025-05-21 23:34:08');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'SUPERADMIN', 'web', '2025-02-17 18:56:49', '2025-02-17 18:56:49'),
(2, 'Pegawai', 'web', '2025-02-23 21:27:29', '2025-02-23 21:27:29'),
(3, 'admin', 'web', '2025-03-12 05:48:41', '2025-03-12 05:48:41');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `role_menus`
--

CREATE TABLE `role_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `role_menus`
--

INSERT INTO `role_menus` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 3, NULL, NULL),
(4, 1, 4, NULL, NULL),
(5, 1, 5, NULL, NULL),
(6, 1, 6, NULL, NULL),
(7, 1, 7, NULL, NULL),
(11, 1, 11, NULL, NULL),
(26, 1, 14, NULL, NULL),
(27, 1, 15, NULL, NULL),
(31, 2, 1, NULL, NULL),
(32, 2, 2, NULL, NULL),
(33, 2, 3, NULL, NULL),
(34, 2, 4, NULL, NULL),
(35, 2, 5, NULL, NULL),
(36, 2, 6, NULL, NULL),
(37, 2, 7, NULL, NULL),
(41, 2, 11, NULL, NULL),
(43, 2, 14, NULL, NULL),
(44, 2, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('H1bHL4hIzg5vJvwPVSMAoFhPipcMbNYy3oJ2SxWu', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUENycDZIOXdZM01yenI4TkJDaVVibDZiOUV0WXpaTDBwN2FiVktYTiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vbG9jYWxob3N0OjgwMDMvc2V0dGluZ3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1750731510),
('km9dMO6u22d3JClBj8HWIMc8PcVSj91ioqaio8Jn', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSE0yMk12Z2hCTnRhcnlCbmxiUmVnMEZld3VzVk1ZS0pLdmphY3pldiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI2OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvbWVudSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1750730938);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `website_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_description` text COLLATE utf8mb4_unicode_ci,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `website_name`, `website_description`, `logo`, `favicon`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'BBM Rumah Sakit', 'Aplikasi BBM Rumah Sakit adalah sistem manajemen digital yang dirancang khusus untuk memantau dan mengelola pembelian serta penggunaan bahan bakar kendaraan operasional di lingkungan rumah sakit, seperti ambulans, mobil dinas, dan kendaraan logistik lainnya.', 'logos/1741239243_logo.png', 'favicons/1739844536_favicon.webp', NULL, NULL, NULL, '2025-02-17 19:08:56', '2025-06-23 19:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_shift` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_shift` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `toleransi_terlambat` int(11) NOT NULL DEFAULT '0',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `waktu_mulai_masuk` int(11) DEFAULT NULL,
  `waktu_akhir_masuk` int(11) DEFAULT NULL,
  `waktu_mulai_keluar` int(11) DEFAULT NULL,
  `waktu_akhir_keluar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id`, `uuid`, `nama_shift`, `kode_shift`, `keterangan`, `toleransi_terlambat`, `status`, `created_at`, `updated_at`, `waktu_mulai_masuk`, `waktu_akhir_masuk`, `waktu_mulai_keluar`, `waktu_akhir_keluar`) VALUES
(12, 'd5181a94-150f-41b1-ac83-f5df072eefcb', 'SHIFT SORE', 'SS', 'OK', 20, '1', '2025-02-18 19:29:01', '2025-03-06 07:01:23', -10, 20, 0, 10),
(13, '4f8fc7b3-963a-43c6-b3cf-013e6389691d', 'SHIFT PAGI', 'SP', 'OK', 20, '1', '2025-02-18 19:29:30', '2025-03-10 04:56:09', -60, 60, -60, 20),
(14, '20a6a8fa-df3e-4ab2-ba2e-2e9be3c5b332', 'SHIFT MALAM', 'SM', NULL, 20, '1', '2025-02-18 19:30:18', '2025-03-10 02:45:41', -60, 60, -60, 60);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `key`) VALUES
(1, '9e9df8ba-de16-4b99-b0dc-7676ff0220c5', 'Admin', 'admin', '2025-02-17 18:52:46', '$2y$12$DncXVy8bmctiX5.3662FpOVX80btc2JhVtC/am7L148h3ntZbq4Ci', '0LcOwayzFp07kumaNvfjP41ZkaimLeiT0zSuxzGJwTs9Hro5cVLmHso2KQaG', '2025-02-17 18:52:46', '2025-02-17 18:52:46', ''),
(7, '4ae2009f-6467-408b-bb4b-d1e59426effa', 'MUHAMMAD NAJMUL FAIZ', '089679884144', NULL, '$2y$12$MobxstAuc78iUTE70oYY/up9q5Y/2m/AuLcYq41oaVgEyKor45cLO', NULL, '2025-02-24 18:38:41', '2025-03-06 06:28:07', '7J3ONPB'),
(8, '6c3af4a7-4a04-4413-a9ba-c65fda38f973', 'EKO YUDHATAMA NUR ASLAM', '08982382323', NULL, '$2y$12$J9SJAHLyxAPeC8vIl9MOdOEnGgRkaNhKe5q0iNmhKylsmQSwfKb6a', NULL, '2025-02-24 18:43:11', '2025-03-10 04:22:40', 'tes-ini-adalah-key'),
(9, '6b603feb-6af9-48d4-832f-40a14eb47dca', 'SETYO EDYATMO, SE', '085226940802', NULL, '$2y$12$BXey/SJU0J3JexTH0cqPX.tAPdJnIw15G3Cs4NpK3yfo0q0dBV6J2', NULL, '2025-02-25 07:41:44', '2025-02-25 07:41:44', NULL),
(10, '6a344e65-7718-4ea6-aeeb-fe89d7d03949', 'faleh', 'faleh', NULL, '$2y$12$gV6zHQWwTAQk199v4HRgdeabyKs5KWW/jhno3fPVPbRfX9kzTUsMW', NULL, '2025-04-07 21:42:56', '2025-04-07 21:42:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_divisis`
--

CREATE TABLE `user_divisis` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `divisi_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `user_photos`
--

CREATE TABLE `user_photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `face_landmarks` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `user_photos`
--

INSERT INTO `user_photos` (`id`, `uuid`, `path`, `user_id`, `created_at`, `updated_at`, `face_landmarks`) VALUES
(154, '66d21d1c-955a-489f-bc91-1f34300f7a1e', 'faces/6c3af4a7-4a04-4413-a9ba-c65fda38f973_1741243519_fotoku.png', 8, '2025-03-06 03:35:47', '2025-03-06 06:45:21', '{\"bottom_lip\":[{\"x\":487,\"y\":480},{\"x\":463,\"y\":488},{\"x\":441,\"y\":491},{\"x\":425,\"y\":492},{\"x\":409,\"y\":492},{\"x\":387,\"y\":490},{\"x\":363,\"y\":482},{\"x\":375,\"y\":479},{\"x\":409,\"y\":469},{\"x\":425,\"y\":469},{\"x\":441,\"y\":468},{\"x\":475,\"y\":478}],\"chin\":[{\"x\":257,\"y\":389},{\"x\":260,\"y\":427},{\"x\":265,\"y\":463},{\"x\":272,\"y\":499},{\"x\":286,\"y\":531},{\"x\":310,\"y\":554},{\"x\":344,\"y\":569},{\"x\":383,\"y\":578},{\"x\":427,\"y\":580},{\"x\":470,\"y\":577},{\"x\":508,\"y\":564},{\"x\":539,\"y\":547},{\"x\":559,\"y\":521},{\"x\":570,\"y\":488},{\"x\":576,\"y\":453},{\"x\":579,\"y\":418},{\"x\":582,\"y\":380}],\"left_eye\":[{\"x\":322,\"y\":364},{\"x\":341,\"y\":353},{\"x\":361,\"y\":351},{\"x\":381,\"y\":361},{\"x\":362,\"y\":366},{\"x\":341,\"y\":367}],\"left_eyebrow\":[{\"x\":287,\"y\":337},{\"x\":306,\"y\":314},{\"x\":335,\"y\":301},{\"x\":367,\"y\":298},{\"x\":396,\"y\":304}],\"nose_bridge\":[{\"x\":421,\"y\":343},{\"x\":422,\"y\":356},{\"x\":422,\"y\":370},{\"x\":421,\"y\":385}],\"nose_tip\":[{\"x\":390,\"y\":421},{\"x\":407,\"y\":423},{\"x\":424,\"y\":426},{\"x\":442,\"y\":422},{\"x\":458,\"y\":419}],\"right_eye\":[{\"x\":462,\"y\":358},{\"x\":481,\"y\":347},{\"x\":502,\"y\":348},{\"x\":519,\"y\":358},{\"x\":502,\"y\":363},{\"x\":482,\"y\":362}],\"right_eyebrow\":[{\"x\":443,\"y\":302},{\"x\":472,\"y\":294},{\"x\":503,\"y\":295},{\"x\":531,\"y\":306},{\"x\":550,\"y\":328}],\"top_lip\":[{\"x\":363,\"y\":482},{\"x\":386,\"y\":457},{\"x\":409,\"y\":443},{\"x\":425,\"y\":446},{\"x\":440,\"y\":442},{\"x\":463,\"y\":455},{\"x\":487,\"y\":480},{\"x\":475,\"y\":478},{\"x\":441,\"y\":466},{\"x\":425,\"y\":467},{\"x\":410,\"y\":467},{\"x\":375,\"y\":479}]}'),
(158, 'ca9ded9f-4846-4cc1-b059-7cbee85937a8', 'storage/faces/4ae2009f-6467-408b-bb4b-d1e59426effa_1741573390_compressed_face.jpg', 7, '2025-03-10 02:23:12', '2025-03-10 02:23:12', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`) USING BTREE;

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`) USING BTREE;

--
-- Indexes for table `divisis`
--
ALTER TABLE `divisis`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `divisi_shifts`
--
ALTER TABLE `divisi_shifts`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `divisi_shifts_divisi_id_foreign` (`divisi_id`) USING BTREE,
  ADD KEY `divisi_shifts_shift_id_foreign` (`shift_id`) USING BTREE;

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`) USING BTREE;

--
-- Indexes for table `jam_kerjas`
--
ALTER TABLE `jam_kerjas`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `jam_kerjas_shift_id_foreign` (`shift_id`) USING BTREE;

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `jobs_queue_index` (`queue`) USING BTREE;

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `menus_parent_id_foreign` (`parent_id`) USING BTREE;

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`) USING BTREE,
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`) USING BTREE;

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`) USING BTREE,
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`) USING BTREE;

--
-- Indexes for table `o_t_p_verifications`
--
ALTER TABLE `o_t_p_verifications`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `o_t_p_verifications_nomor_hp_unique` (`nomor_hp`) USING BTREE;

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`) USING BTREE;

--
-- Indexes for table `pegawai_masters`
--
ALTER TABLE `pegawai_masters`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `pegawai_shifts`
--
ALTER TABLE `pegawai_shifts`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `pegawai_shifts_pegawai_id_foreign` (`pegawai_id`) USING BTREE,
  ADD KEY `pegawai_shifts_shift_id_foreign` (`shift_id`) USING BTREE,
  ADD KEY `pegawai_shifts_created_by_foreign` (`created_by`) USING BTREE,
  ADD KEY `pegawai_shifts_updated_by_foreign` (`updated_by`) USING BTREE;

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`) USING BTREE;

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`) USING BTREE,
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`) USING BTREE;

--
-- Indexes for table `presensis`
--
ALTER TABLE `presensis`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `presensis_pegawai_id_foreign` (`pegawai_id`) USING BTREE,
  ADD KEY `presensis_pegawai_shift_id_foreign` (`pegawai_shift_id`) USING BTREE,
  ADD KEY `presensis_created_by_foreign` (`created_by`) USING BTREE,
  ADD KEY `presensis_updated_by_foreign` (`updated_by`) USING BTREE,
  ADD KEY `divisi_id` (`divisi_id`) USING BTREE;

--
-- Indexes for table `radius`
--
ALTER TABLE `radius`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `remunerasi_batch`
--
ALTER TABLE `remunerasi_batch`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `remunerasi_batch_nama_batch_unique` (`nama_batch`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`) USING BTREE;

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`) USING BTREE,
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`) USING BTREE;

--
-- Indexes for table `role_menus`
--
ALTER TABLE `role_menus`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `role_menus_role_id_foreign` (`role_id`) USING BTREE,
  ADD KEY `role_menus_menu_id_foreign` (`menu_id`) USING BTREE;

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `sessions_user_id_index` (`user_id`) USING BTREE,
  ADD KEY `sessions_last_activity_index` (`last_activity`) USING BTREE;

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `users_username_unique` (`username`) USING BTREE;

--
-- Indexes for table `user_divisis`
--
ALTER TABLE `user_divisis`
  ADD PRIMARY KEY (`user_id`,`divisi_id`) USING BTREE;

--
-- Indexes for table `user_photos`
--
ALTER TABLE `user_photos`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `user_photos_user_id_foreign` (`user_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `divisis`
--
ALTER TABLE `divisis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `divisi_shifts`
--
ALTER TABLE `divisi_shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jam_kerjas`
--
ALTER TABLE `jam_kerjas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `o_t_p_verifications`
--
ALTER TABLE `o_t_p_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pegawai_masters`
--
ALTER TABLE `pegawai_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pegawai_shifts`
--
ALTER TABLE `pegawai_shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=508;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `presensis`
--
ALTER TABLE `presensis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radius`
--
ALTER TABLE `radius`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `remunerasi_batch`
--
ALTER TABLE `remunerasi_batch`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_menus`
--
ALTER TABLE `role_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_photos`
--
ALTER TABLE `user_photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `divisi_shifts`
--
ALTER TABLE `divisi_shifts`
  ADD CONSTRAINT `divisi_shifts_divisi_id_foreign` FOREIGN KEY (`divisi_id`) REFERENCES `divisis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `divisi_shifts_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jam_kerjas`
--
ALTER TABLE `jam_kerjas`
  ADD CONSTRAINT `jam_kerjas_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pegawai_shifts`
--
ALTER TABLE `pegawai_shifts`
  ADD CONSTRAINT `pegawai_shifts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pegawai_shifts_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai_masters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pegawai_shifts_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pegawai_shifts_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `presensis`
--
ALTER TABLE `presensis`
  ADD CONSTRAINT `presensis_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `presensis_ibfk_1` FOREIGN KEY (`divisi_id`) REFERENCES `divisis` (`id`),
  ADD CONSTRAINT `presensis_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai_masters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `presensis_pegawai_shift_id_foreign` FOREIGN KEY (`pegawai_shift_id`) REFERENCES `pegawai_shifts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `presensis_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_menus`
--
ALTER TABLE `role_menus`
  ADD CONSTRAINT `role_menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_menus_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_divisis`
--
ALTER TABLE `user_divisis`
  ADD CONSTRAINT `user_divisis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_photos`
--
ALTER TABLE `user_photos`
  ADD CONSTRAINT `user_photos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
