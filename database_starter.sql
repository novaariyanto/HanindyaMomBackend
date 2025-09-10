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
  `key` varchar(255)  NOT NULL,
  `value` mediumtext  NOT NULL,
  `expiration` int(11) NOT NULL
);

--
-- Dumping data for table `cache`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255)  NOT NULL,
  `owner` varchar(255)  NOT NULL,
  `expiration` int(11) NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `divisis`
--

CREATE TABLE `divisis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36)  NOT NULL,
  `nama` varchar(255)  NOT NULL,
  `keterangan` text ,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

--
-- Dumping data for table `divisis`

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
  `uuid` char(36)  DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255)  NOT NULL,
  `connection` text  NOT NULL,
  `queue` text  NOT NULL,
  `payload` longtext  NOT NULL,
  `exception` longtext  NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

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
);

--
-- Dumping data for table `jam_kerjas`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255)  NOT NULL,
  `payload` longtext  NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255)  NOT NULL,
  `name` varchar(255)  NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext  NOT NULL,
  `options` mediumtext ,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36)  NOT NULL,
  `route` varchar(255)  DEFAULT NULL,
  `icon` varchar(255)  DEFAULT NULL,
  `nama_menu` varchar(255)  NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order` int(11) DEFAULT NULL
);

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
  `migration` varchar(255)  NOT NULL,
  `batch` int(11) NOT NULL
);

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
  `model_type` varchar(255)  NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255)  NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
);

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
  `nomor_hp` varchar(255)  NOT NULL,
  `otp_code` varchar(255)  NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nik` varchar(16)  DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255)  NOT NULL,
  `token` varchar(255)  NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_masters`
--

CREATE TABLE `pegawai_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36)  NOT NULL,
  `nik` varchar(16)  NOT NULL,
  `nama` varchar(255)  NOT NULL,
  `jabatan_id` int(11) NOT NULL,
  `divisi_id` int(11) NOT NULL,
  `status` enum('aktif','non_aktif')  NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
);

--
-- Dumping data for table `pegawai_masters`
--


-- --------------------------------------------------------

--
-- Table structure for table `pegawai_shifts`
--

CREATE TABLE `pegawai_shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36)  NOT NULL,
  `pegawai_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

--
-- Dumping data for table `pegawai_shifts`
--

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255)  NOT NULL,
  `guard_name` varchar(255)  NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255)  NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255)  NOT NULL,
  `token` varchar(64)  NOT NULL,
  `abilities` text ,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

--
-- Dumping data for table `personal_access_tokens`
--

-- --------------------------------------------------------

--
-- Table structure for table `presensis`
--

CREATE TABLE `presensis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36)  NOT NULL,
  `pegawai_id` bigint(20) UNSIGNED NOT NULL,
  `pegawai_shift_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` timestamp NULL DEFAULT NULL,
  `jam_keluar` timestamp NULL DEFAULT NULL,
  `jam_masuk_jadwal` timestamp NULL DEFAULT NULL,
  `jam_keluar_jadwal` timestamp NULL DEFAULT NULL,
  `status` enum('hadir','terlambat','izin','sakit','alpha')  NOT NULL,
  `keterangan` text ,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `longitude_masuk` text ,
  `latitude_masuk` text ,
  `longitude_keluar` text ,
  `latitude_keluar` text ,
  `face_landmarks_in` longtext ,
  `face_landmarks_out` longtext ,
  `terlambat_detik` int(11) DEFAULT NULL,
  `durasi_kerja_detik` int(11) DEFAULT NULL,
  `pulang_cepat_detik` int(11) DEFAULT NULL,
  `catatan` longtext ,
  `divisi_id` bigint(20) UNSIGNED DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `radius`
--

CREATE TABLE `radius` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coordinates` text  NOT NULL,
  `width` decimal(10,2) NOT NULL,
  `height` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

--
-- Dumping data for table `radius`
--

-- --------------------------------------------------------

--
-- Table structure for table `remunerasi_batch`
--

CREATE TABLE `remunerasi_batch` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_batch` varchar(100)  NOT NULL,
  `tanggal` date DEFAULT NULL,
  `status` varchar(30)  NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

--
-- Dumping data for table `remunerasi_batch`
--


--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255)  NOT NULL,
  `guard_name` varchar(255)  NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

--
-- Dumping data for table `roles`
--

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
);

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
);

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
  `id` varchar(255)  NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45)  DEFAULT NULL,
  `user_agent` text ,
  `payload` longtext  NOT NULL,
  `last_activity` int(11) NOT NULL
);

--
-- Dumping data for table `sessions`
--


-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `website_name` varchar(255)  DEFAULT NULL,
  `website_description` text ,
  `logo` varchar(255)  DEFAULT NULL,
  `favicon` varchar(255)  DEFAULT NULL,
  `email` varchar(255)  DEFAULT NULL,
  `phone` varchar(255)  DEFAULT NULL,
  `address` text ,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

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
  `uuid` char(36)  NOT NULL,
  `nama_shift` varchar(255)  NOT NULL,
  `kode_shift` varchar(255)  NOT NULL,
  `keterangan` text ,
  `toleransi_terlambat` int(11) NOT NULL DEFAULT '0',
  `status` enum('1','2')  NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `waktu_mulai_masuk` int(11) DEFAULT NULL,
  `waktu_akhir_masuk` int(11) DEFAULT NULL,
  `waktu_mulai_keluar` int(11) DEFAULT NULL,
  `waktu_akhir_keluar` int(11) DEFAULT NULL
);

--
-- Dumping data for table `shifts`
--

-- ----------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36)  NOT NULL,
  `name` varchar(255)  NOT NULL,
  `username` varchar(255)  NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255)  NOT NULL,
  `remember_token` varchar(100)  DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `key` varchar(255)  DEFAULT NULL
);

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
);

-- --------------------------------------------------------

--
-- Table structure for table `user_photos`
--

CREATE TABLE `user_photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36)  NOT NULL,
  `path` varchar(255)  NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `face_landmarks` longtext 
) 


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
