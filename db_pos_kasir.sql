-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Nov 2026 pada 08.24
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pos_kasir`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-qwe@as.com|127.0.0.1', 'i:2;', 1794379037),
('laravel-cache-qwe@as.com|127.0.0.1:timer', 'i:1794379037;', 1794379037);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Minuman', '2026-11-11 06:29:06', '2026-11-11 06:29:06', NULL),
(2, 'Makanan ringan', '2026-11-11 06:29:06', '2026-11-11 06:29:06', NULL),
(3, 'Kebutuhan pokok', '2026-11-11 06:29:06', '2026-11-11 06:29:06', NULL),
(4, 'Perawatan rumah', '2026-11-11 06:29:06', '2026-11-11 06:29:06', NULL),
(6, 'Kebutuhan pokok pangan', '2026-11-11 07:13:36', '2026-11-11 07:13:36', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `buy_price` bigint(20) UNSIGNED NOT NULL,
  `sell_price` bigint(20) UNSIGNED NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `unit` varchar(255) NOT NULL DEFAULT 'pcs',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `items`
--

INSERT INTO `items` (`id`, `item_code`, `category_id`, `name`, `buy_price`, `sell_price`, `stock`, `unit`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'BRG-001', 1, 'Air Mineral 600ml', 3000, 4000, 47, 'botol', '2026-11-11 06:29:06', '2026-11-11 07:08:52', NULL),
(2, 'BRG-002', 1, 'Teh Melati 350ml', 3500, 5000, 30, 'botol', '2026-11-11 06:29:06', '2026-11-11 07:08:52', NULL),
(3, 'BRG-003', 1, 'Kopi Susu 250ml', 6000, 8500, 22, 'kotak', '2026-11-11 06:29:06', '2026-11-11 07:08:52', NULL),
(4, 'BRG-004', 1, 'Susu UHT Cokelat', 5000, 6500, 16, 'kotak', '2026-11-11 06:29:06', '2026-11-11 07:08:52', NULL),
(5, 'BRG-005', 2, 'Keripik Kentang Original', 6500, 9000, 18, 'pack', '2026-11-11 06:29:06', '2026-11-11 07:08:52', NULL),
(6, 'BRG-006', 2, 'Biskuit Cokelat', 4500, 6000, 2, 'pack', '2026-11-11 06:29:06', '2026-11-11 07:08:52', NULL),
(7, 'BRG-007', 2, 'Wafer Vanila', 3000, 4500, 16, 'pack', '2026-11-11 06:29:06', '2026-11-11 07:08:52', NULL),
(8, 'BRG-008', 2, 'Roti Susu', 4000, 5500, 2, 'pcs', '2026-11-11 06:29:06', '2026-11-11 07:08:52', NULL),
(9, 'BRG-009', 3, 'Beras Premium 5kg', 65000, 72000, 11, 'karung', '2026-11-11 06:29:06', '2026-11-11 07:08:52', NULL),
(10, 'BRG-010', 3, 'Minyak Goreng 1L', 16000, 18500, 18, 'botol', '2026-11-11 06:29:06', '2026-11-11 07:08:52', NULL),
(11, 'BRG-011', 3, 'Gula Pasir 1kg', 14000, 16500, 15, 'pack', '2026-11-11 06:29:06', '2026-11-11 07:08:52', NULL),
(12, 'BRG-012', 3, 'Mi Instan Goreng', 2500, 3500, 58, 'pcs', '2026-11-11 06:29:06', '2026-11-11 07:08:52', NULL),
(13, 'BRG-013', 4, 'Sabun Cuci Piring 750ml', 9500, 12000, 3, 'pouch', '2026-11-11 06:29:06', '2026-11-11 07:08:52', NULL),
(14, 'BRG-014', 4, 'Tisu Wajah 250 Sheets', 8000, 11000, 20, 'pack', '2026-11-11 06:29:06', '2026-11-11 07:08:52', NULL),
(15, 'BRG-015', 4, 'Detergen Bubuk 800g', 15000, 18500, 12, 'pack', '2026-11-11 06:29:06', '2026-11-11 07:08:52', NULL),
(16, 'BRG-016', 4, 'Pembersih Lantai 800ml', 11000, 14000, 0, 'botol', '2026-11-11 06:29:06', '2026-11-11 06:29:06', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_11_11_000001_create_pos_tables', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1LuCGjTqodG9tNuf6Qhbiv4UJkqmYaorRRgya3fL', NULL, '127.0.0.1', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTFEyaEFTMFlFajRlOHFiR3BLVVJXaVA4ZWtmUnFDRDhWb3VZdUg4NCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1794378918),
('4I0E6jmBBCRu6hZSugZBiI5U1p435YbOo3EkxsP1', NULL, '127.0.0.1', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXpyVE9rMjh4a1M2Yld3Q2lUZUdtd2Z0S2ttZzAxY1RmSXNwQ0pPSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1794379062),
('6uIV587Q0s1kgagz1OdQZQi0TMKECE7HjY8mXJen', NULL, '127.0.0.1', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRlRuWEx1SVpzME9wZnp1d2s1REdkRktpdGRDbTB3cFRTT2RpV2RHQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1794379063),
('9um3rJoJ0xlhUCtapOeb1IIOPelaqOYcKaUQ1I5B', NULL, '127.0.0.1', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS00yeVRycDl6ZzVTbEFPSFBvY2dxajZoUzJOdzZKZUxzTDlvTmp1YiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1794378813),
('bI62hRNdsP2JkkVUjKJO7zWnQ5CAi5Fvp68BiUId', NULL, '127.0.0.1', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ1c2QU82TWZoTmljUVR1d2llVUs2R2cwclA3WXByWXpaQlpPSEp5RCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1794378721),
('cBAOP8sZp66JUvx7Fl7SfL83BDl7HMITpRlDKnHp', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/157.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWFQ5c242eFZ4N2xYaHB0dHU3cWoxNUtTWVlEVlFUWUJDQkVYcnhQSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wb3MvaXRlbXM/cT1CUkctMDAxIjtzOjU6InJvdXRlIjtzOjk6InBvcy5pdGVtcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6IjFhZDI5YmE4N2JhZmU1MWRiNWNkOGRlMmRmY2RjMzBlNmZmNDEzMGJmMDcwYWM2NTJjZDQ4MWEwOTQ0MmNiMWEiO30=', 1794378925),
('Cf5F8Z5KH7l16ZqdDAffEbLvz21VlrurY1upE8Ou', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/157.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNGNsdVlCUE9Lb2loVWxWYmc1dXRlV2U2SUFXcDhCb2ZReVVuTnd0RyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pdGVtcyI7czo1OiJyb3V0ZSI7czoxMToiaXRlbXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiJlOGFhOThhNDljMTA0ZmJiMmE0OWM5MTY5MWUyZWFiMzFiNmVlMTFmMDVjZmQyYzg5MjkxMzdhNWIzZWZhNDM3Ijt9', 1794378730),
('ECMwuje9klzDWcf1li1z39LotPemx3BFZO8nqHcX', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/157.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSGhSS2F1OTY0R1pFNVcwZFM5SXpPMDZFNHdDZkhJWlNIZGYycmxZNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pdGVtcyI7czo1OiJyb3V0ZSI7czoxMToiaXRlbXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiJlOGFhOThhNDljMTA0ZmJiMmE0OWM5MTY5MWUyZWFiMzFiNmVlMTFmMDVjZmQyYzg5MjkxMzdhNWIzZWZhNDM3Ijt9', 1794379069),
('eJF21lLp2uN0VlwvaVqtmZvqq987WBvQ2zboFQqi', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/157.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQmJaYUtNeEFUcHpCWENlblpVWGJRTW5hcVBGMXBUNjYyTlg5c2RkOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wb3MvaXRlbXM/cT1CUkctMDAxIjtzOjU6InJvdXRlIjtzOjk6InBvcy5pdGVtcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6IjFhZDI5YmE4N2JhZmU1MWRiNWNkOGRlMmRmY2RjMzBlNmZmNDEzMGJmMDcwYWM2NTJjZDQ4MWEwOTQ0MmNiMWEiO30=', 1794379072),
('gDz3AidQxIrOYZU3Uot03IWm9u3isjppYwERkYxb', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/157.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQUlyMEc0WFlVd3kxWjdTRWk3MXZxNDZUWGRGM3Q4OWcxVklRQzRMUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wb3MvaXRlbXM/cT0iO3M6NToicm91dGUiO3M6OToicG9zLml0ZW1zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiMWFkMjliYTg3YmFmZTUxZGI1Y2Q4ZGUyZGZjZGMzMGU2ZmY0MTMwYmYwNzBhYzY1MmNkNDgxYTA5NDQyY2IxYSI7fQ==', 1794378740),
('GWV33tclNp2Sc1oIS5032VGWlFdrMGkoEAKHgGNb', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiU242VHJjUUhYNmNSNFhKWjlkemQ2bHBRb1BTQ3Q2UVVTYUFpcW4yQSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiZjA0MDJmOWU4M2M3NDc4NGVjZmNlZDdlZDUyNjIwNWRiZWFmZWIwNjY3MzFkZDg5NzE4Njg0NzkwYmQ4NWY1ZSI7fQ==', 1794381166),
('gZel0Jz3h22j04S38yEP3PigPzgKWeMuwNruEwXb', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiM0dlODRiRzFmWW5XTEUxbmVtNjg3eGx4YmI1TTVDTjdMV2xqT3V0cyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTc6Imh0dHA6Ly9ncm9vdmluZy1wYXN0ZWQtZW1vdGUubmdyb2stZnJlZS5kZXYvcmVwb3J0cy9wZGY/ZW5kX2RhdGU9MjAyNi0xMS0xMSZzdGFydF9kYXRlPTIwMjYtMTEtMDEiO3M6NToicm91dGUiO3M6MTE6InJlcG9ydHMucGRmIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiZThhYTk4YTQ5YzEwNGZiYjJhNDljOTE2OTFlMmVhYjMxYjZlZTExZjA1Y2ZkMmM4OTI5MTM3YTViM2VmYTQzNyI7fQ==', 1794381259),
('JntmWfFidi6qG6qUJjIaw6M5aVGJbJI8q0YzWhPA', NULL, '127.0.0.1', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRmxlOFlPczVJODh2V0ZIU0h1dGs0VEU3Mmd1dkVKeEhRc29heDFZeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1794378919),
('KlG31vxBLvEAxJJzyPizZuP1VOA1Cq8mSEG0FQty', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/157.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibUUyMGNmVGJBQ2M1ZndoZ0xEcENRNDREYkw1dFNhRlEzSXB5VFk2dyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pdGVtcyI7czo1OiJyb3V0ZSI7czoxMToiaXRlbXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiJlOGFhOThhNDljMTA0ZmJiMmE0OWM5MTY5MWUyZWFiMzFiNmVlMTFmMDVjZmQyYzg5MjkxMzdhNWIzZWZhNDM3Ijt9', 1794378923),
('KMGFFyvWIHUIWOZflswouW7jCzJb4uppPnq29xfP', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/157.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiN1RJSUx3SWxRYndqMU1CM3o1NTZmYWphY2JTb0owRWVJWHNycE9iVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wb3MvaXRlbXM/cT1CUkctMDAxIjtzOjU6InJvdXRlIjtzOjk6InBvcy5pdGVtcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6IjFhZDI5YmE4N2JhZmU1MWRiNWNkOGRlMmRmY2RjMzBlNmZmNDEzMGJmMDcwYWM2NTJjZDQ4MWEwOTQ0MmNiMWEiO30=', 1794378825),
('OfCYOKT63JPrBVr2Vm2Tjz4inWICX8XIgDgrzDot', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.145.3 Chrome/150.0.7871.250 Electron/43.8.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ3dIWnZEd0kxZllQMlZSTzJEQUZrc0ttV2VTWnZRRm1MamN1blNJSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1794381803),
('OT75dJt1MgGzaqeWrxTghRM2cPOcb78ZUmu0xRf0', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.145.3 Chrome/150.0.7871.250 Electron/43.8.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZHhkV2lmMGRrOGRYZHZWenFxcmI5TGUwSE9DaGl0VDFobTZzQVBZQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1794378985),
('qdYEqJQWLJ7omUuARTpsElGWgegmKlid27lwmmqP', NULL, '127.0.0.1', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZXBEcUpYbFBVeDNxQ3VIMTlpQTFweFp6aTgwREdHU0ZMRFc5a0sxRiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1794378722),
('qqaQgJxNaJaSqXN8aN1kZz7BKCcmYqf96dIy4rcD', NULL, '127.0.0.1', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQmlJWlBjU3FvbWhlcU1SUUJFcU1yQXZ5c3NPY1pENWRoemZjN3pBTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1794378813),
('sX6TXFvSjy06G85vvyc3rdEsb5CQkGhlmUbf3Xv9', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/157.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiemphdmZ6eno1eGFiNTZ3azBmWldDek1HS2kyYW1ieHAxS1dLcG1KbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pdGVtcyI7czo1OiJyb3V0ZSI7czoxMToiaXRlbXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiJlOGFhOThhNDljMTA0ZmJiMmE0OWM5MTY5MWUyZWFiMzFiNmVlMTFmMDVjZmQyYzg5MjkxMzdhNWIzZWZhNDM3Ijt9', 1794378821);

-- --------------------------------------------------------

--
-- Struktur dari tabel `store_settings`
--

CREATE TABLE `store_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `footer_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `store_settings`
--

INSERT INTO `store_settings` (`id`, `name`, `address`, `phone`, `footer_note`, `created_at`, `updated_at`) VALUES
(1, 'Toko Ritel', 'Jl. Melati No. 12, Jakarta', '021-555-0123', 'Terima kasih telah berbelanja. Sampai jumpa kembali!', '2026-11-11 06:29:06', '2026-11-11 06:29:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_code` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_price` bigint(20) UNSIGNED NOT NULL,
  `pay_amount` bigint(20) UNSIGNED NOT NULL,
  `change_amount` bigint(20) UNSIGNED NOT NULL,
  `notes` text DEFAULT NULL,
  `checkout_token` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `invoice_code`, `user_id`, `total_price`, `pay_amount`, `change_amount`, `notes`, `checkout_token`, `created_at`, `updated_at`) VALUES
(2, 'TRX-20261111-01M74NNBXAHJ0QSC1ADP9FATQ6', 2, 22000, 50000, 28000, NULL, '2e33720d-c82f-4d78-ac3a-e1d5d2e7a288', '2026-11-11 06:45:26', '2026-11-11 06:45:26'),
(3, 'TRX-20261111-01M74Q09NJ0VJXSYTDYS0WNBAY', 2, 335500, 350000, 14500, NULL, '5c59198f-b18a-4154-bb7a-6828cd49f48d', '2026-11-11 07:08:52', '2026-11-11 07:08:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` bigint(20) UNSIGNED NOT NULL,
  `buy_price` bigint(20) UNSIGNED NOT NULL,
  `subtotal` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `transaction_id`, `item_id`, `item_name`, `item_code`, `qty`, `price`, `buy_price`, `subtotal`, `created_at`, `updated_at`) VALUES
(2, 2, 12, 'Mi Instan Goreng', 'BRG-012', 1, 3500, 2500, 3500, '2026-11-11 06:45:26', '2026-11-11 06:45:26'),
(3, 2, 15, 'Detergen Bubuk 800g', 'BRG-015', 1, 18500, 15000, 18500, '2026-11-11 06:45:26', '2026-11-11 06:45:26'),
(4, 3, 3, 'Kopi Susu 250ml', 'BRG-003', 2, 8500, 6000, 17000, '2026-11-11 07:08:52', '2026-11-11 07:08:52'),
(5, 3, 5, 'Keripik Kentang Original', 'BRG-005', 2, 9000, 6500, 18000, '2026-11-11 07:08:52', '2026-11-11 07:08:52'),
(6, 3, 13, 'Sabun Cuci Piring 750ml', 'BRG-013', 2, 12000, 9500, 24000, '2026-11-11 07:08:52', '2026-11-11 07:08:52'),
(7, 3, 8, 'Roti Susu', 'BRG-008', 2, 5500, 4000, 11000, '2026-11-11 07:08:52', '2026-11-11 07:08:52'),
(8, 3, 10, 'Minyak Goreng 1L', 'BRG-010', 2, 18500, 16000, 37000, '2026-11-11 07:08:52', '2026-11-11 07:08:52'),
(9, 3, 2, 'Teh Melati 350ml', 'BRG-002', 2, 5000, 3500, 10000, '2026-11-11 07:08:52', '2026-11-11 07:08:52'),
(10, 3, 14, 'Tisu Wajah 250 Sheets', 'BRG-014', 2, 11000, 8000, 22000, '2026-11-11 07:08:52', '2026-11-11 07:08:52'),
(11, 3, 7, 'Wafer Vanila', 'BRG-007', 14, 4500, 3000, 63000, '2026-11-11 07:08:52', '2026-11-11 07:08:52'),
(12, 3, 4, 'Susu UHT Cokelat', 'BRG-004', 2, 6500, 5000, 13000, '2026-11-11 07:08:52', '2026-11-11 07:08:52'),
(13, 3, 12, 'Mi Instan Goreng', 'BRG-012', 1, 3500, 2500, 3500, '2026-11-11 07:08:52', '2026-11-11 07:08:52'),
(14, 3, 11, 'Gula Pasir 1kg', 'BRG-011', 1, 16500, 14000, 16500, '2026-11-11 07:08:52', '2026-11-11 07:08:52'),
(15, 3, 1, 'Air Mineral 600ml', 'BRG-001', 1, 4000, 3000, 4000, '2026-11-11 07:08:52', '2026-11-11 07:08:52'),
(16, 3, 9, 'Beras Premium 5kg', 'BRG-009', 1, 72000, 65000, 72000, '2026-11-11 07:08:52', '2026-11-11 07:08:52'),
(17, 3, 6, 'Biskuit Cokelat', 'BRG-006', 1, 6000, 4500, 6000, '2026-11-11 07:08:52', '2026-11-11 07:08:52'),
(18, 3, 15, 'Detergen Bubuk 800g', 'BRG-015', 1, 18500, 15000, 18500, '2026-11-11 07:08:52', '2026-11-11 07:08:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','kasir') NOT NULL DEFAULT 'kasir'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Administrator', 'admin@ritel.test', '2026-11-11 06:29:05', '$2y$12$lC8PaacPdC3RC/zvXyO/DO5m2BEcXWIgrH8xLkquMOQrNPNBPATMu', NULL, '2026-11-11 06:29:06', '2026-11-11 06:29:06', 'admin'),
(2, 'Kasir Toko', 'kasir@ritel.test', '2026-11-11 06:29:06', '$2y$12$xhtSPeDfzB677oRpjvIM9.GtmgJGSyc0PLlcGo.FjoJcsNsBZ7nWe', NULL, '2026-11-11 06:29:06', '2026-11-11 07:11:57', 'kasir'),
(4, 'nathan', 'nathanahnaf6@gmail.com', NULL, '$2y$12$X0s6UJWowQNeiqxA2Q3od.ScZphuu3ZhXPBCR6vMyQ8TZsJVItquu', NULL, '2026-11-11 07:12:32', '2026-11-11 07:12:32', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `items_item_code_unique` (`item_code`),
  ADD KEY `items_category_id_foreign` (`category_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `store_settings`
--
ALTER TABLE `store_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_invoice_code_unique` (`invoice_code`),
  ADD UNIQUE KEY `transactions_checkout_token_unique` (`checkout_token`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_created_at_index` (`created_at`);

--
-- Indeks untuk tabel `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_details_transaction_id_foreign` (`transaction_id`),
  ADD KEY `transaction_details_item_id_foreign` (`item_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `store_settings`
--
ALTER TABLE `store_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `transaction_details_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `transaction_details_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
