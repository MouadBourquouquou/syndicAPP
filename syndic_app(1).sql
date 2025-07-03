-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 13 juin 2025 à 17:18
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `syndic_app`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `appartements`
--

CREATE TABLE `appartements` (
  `id_A` bigint(20) UNSIGNED NOT NULL,
  `CIN_A` varchar(20) NOT NULL,
  `Nom` varchar(20) NOT NULL,
  `Prenom` varchar(20) NOT NULL,
  `immeuble_id` bigint(20) UNSIGNED NOT NULL,
  `numero` varchar(50) NOT NULL,
  `surface` decimal(8,2) NOT NULL,
  `montant_cotisation_mensuelle` decimal(10,2) NOT NULL,
  `dernier_mois_paye` date NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `appartements`
--

INSERT INTO `appartements` (`id_A`, `CIN_A`, `Nom`, `Prenom`, `immeuble_id`, `numero`, `surface`, `montant_cotisation_mensuelle`, `dernier_mois_paye`, `telephone`, `email`, `created_at`, `updated_at`) VALUES
(30, 'AZ3456', 'FGTY', 'SDFRT', 6, 'A22EAa', 140.00, 100.00, '2025-06-13', '+212 65434567', 'GH@gmail.com', '2025-06-09 15:50:28', '2025-06-13 09:16:45'),
(32, 'AE3456', 'RT', 'HGT', 6, 'ZZ23', 100.00, 1000.00, '2025-06-10', '+212 65434567', 'hg@gmail.com', '2025-06-09 23:34:28', '2025-06-09 23:34:28'),
(33, 'AE3456', 'RT', 'HGT', 6, 'ZZ23', 100.00, 1000.00, '2025-06-10', '+212 65434567', 'hg@gmail.com', '2025-06-09 23:34:32', '2025-06-09 23:34:32'),
(35, 'AE345676', 'Hakim', 'HAYDAR', 14, 'D99', 300.00, 100.00, '2025-06-11', '+212 65434567', 'haydar@gmail.com', '2025-06-11 11:41:34', '2025-06-11 11:41:34'),
(36, 'AE435678', 'Hind', 'BELKHOURI', 9, '12D', 1000.00, 150.00, '2025-06-12', '+212 65436666', 'hind@gmail.com', '2025-06-12 11:04:11', '2025-06-12 11:04:32');

-- --------------------------------------------------------

--
-- Structure de la table `bereau`
--

CREATE TABLE `bereau` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `numB` int(11) NOT NULL,
  `immeuble_id` bigint(20) UNSIGNED NOT NULL,
  `numero` varchar(20) NOT NULL,
  `surface` float(8,2) NOT NULL,
  `montant_caisse` decimal(10,2) DEFAULT NULL,
  `dernier_mois_paye` varchar(7) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `charges`
--

CREATE TABLE `charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `immeuble_id` bigint(20) UNSIGNED NOT NULL,
  `id_residence` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `montant` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `charges`
--

INSERT INTO `charges` (`id`, `immeuble_id`, `id_residence`, `type`, `description`, `montant`, `date`, `created_at`, `updated_at`) VALUES
(7, 9, 4, 'Eauua', 'hjxd', 100.00, '2025-06-19', '2025-06-02 06:42:22', '2025-06-13 09:17:15'),
(8, 4, 7, 'Sécuritée', 'gfrrtyuj', 200.00, '2025-06-11', '2025-06-12 11:41:54', '2025-06-12 11:58:10'),
(9, 12, 6, 'fff', 'gggg', 100.00, '2025-05-06', '2025-06-12 13:19:49', '2025-06-12 13:19:49'),
(10, 9, 8, 'GGGGG', 'IIII', 200.00, '2025-05-14', '2025-06-12 13:20:47', '2025-06-12 13:20:47'),
(11, 10, 5, 'AAAA', 'YYYY', 300.00, '2025-06-03', '2025-06-12 13:26:22', '2025-06-12 13:26:22');

-- --------------------------------------------------------

--
-- Structure de la table `employes`
--

CREATE TABLE `employes` (
  `id_E` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `poste` enum('assistant_syndic','concierge','femme_menage') NOT NULL,
  `immeuble_id` bigint(20) UNSIGNED DEFAULT NULL,
  `residence_id` int(11) DEFAULT NULL,
  `date_embauche` date NOT NULL,
  `salaire` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `employes`
--

INSERT INTO `employes` (`id_E`, `nom`, `prenom`, `email`, `telephone`, `ville`, `adresse`, `poste`, `immeuble_id`, `residence_id`, `date_embauche`, `salaire`, `created_at`, `updated_at`) VALUES
(1, 'Naima', 'OAATMANE', 'naima@gmail.com', '0643235491', 'Marrakech', 'Marrakech,Massira', 'assistant_syndic', NULL, NULL, '2025-05-07', 10000.00, '2025-05-28 07:51:30', '2025-05-28 07:51:30'),
(2, 'Ikram', 'ARO', 'ikram@gmail.com', '0654356786', 'Marrakech', 'Marrakech,Massira', 'assistant_syndic', NULL, NULL, '2025-05-14', 10000.00, '2025-05-29 12:40:11', '2025-05-29 12:40:11');

-- --------------------------------------------------------

--
-- Structure de la table `employe_immeuble`
--

CREATE TABLE `employe_immeuble` (
  `employe_id` bigint(20) UNSIGNED NOT NULL,
  `immeuble_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
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
-- Structure de la table `historique`
--

CREATE TABLE `historique` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_A` bigint(20) UNSIGNED NOT NULL,
  `mois` varchar(20) NOT NULL,
  `annee` int(11) NOT NULL,
  `montant_paye` decimal(10,2) NOT NULL,
  `recu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `immeuble`
--

CREATE TABLE `immeuble` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `code_postal` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `nombre_app` int(11) NOT NULL,
  `cotisation` decimal(10,2) DEFAULT NULL,
  `caisse` decimal(10,2) DEFAULT NULL,
  `residence_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `immeuble`
--

INSERT INTO `immeuble` (`id`, `nom`, `ville`, `code_postal`, `adresse`, `nombre_app`, `cotisation`, `caisse`, `residence_id`, `created_at`, `updated_at`) VALUES
(4, 'A333ZAq', 'Marrakech', '19876', 'Marrakech', 11, 100.00, 1000.00, 6, '2025-05-28 09:39:00', '2025-06-13 08:29:17'),
(6, '12', 'Casablanca', '11111111', 'Casablanca', 11, 1000.00, 1000000.00, NULL, '2025-05-30 06:55:45', '2025-05-30 06:55:45'),
(7, '12', 'Casablanca', '11111111', 'Casablanca', 11, 1000.00, 1000000.00, NULL, '2025-05-30 06:58:06', '2025-05-30 06:58:06'),
(8, '100', 'Rabat', '3333', 'Rabat', 60, 200.00, 20000.00, NULL, '2025-05-30 06:59:02', '2025-05-30 06:59:02'),
(9, 'GFTR', 'Casablanca', '22222', 'GFRT', 11, 150.00, 1500.00, NULL, '2025-05-31 07:09:19', '2025-05-31 07:09:19'),
(10, 'AA', NULL, NULL, NULL, 11, 1000.00, NULL, 2, '2025-06-01 21:11:11', '2025-06-01 21:11:11'),
(11, 'gg', NULL, NULL, NULL, 11, 100.00, NULL, 2, '2025-06-02 10:57:35', '2025-06-02 10:57:35'),
(12, 'n', NULL, NULL, NULL, 11, 233.00, NULL, 2, '2025-06-02 11:49:14', '2025-06-02 11:49:14'),
(13, 'ZER', NULL, NULL, NULL, 11, 1111.00, NULL, 4, '2025-06-02 12:13:04', '2025-06-02 12:13:04'),
(14, '33', 'Marrakech', '122', 'Marrakech,Massira', 1, 100.00, 1000.00, 2, '2025-06-04 08:48:34', '2025-06-04 08:48:34'),
(15, '4', 'Rabat', '222222', 'FFFFFFFF', 12, 1667.00, 1356700.00, NULL, '2025-06-04 08:49:59', '2025-06-04 08:49:59'),
(16, 'gfrt', 'Casablanca', '2222', 'EEEEE', 22, 2000.00, 20000.00, NULL, '2025-06-04 11:40:05', '2025-06-04 11:40:05'),
(18, 'A111', 'Marrakech', '2000', 'Marrakech,abouab Marrakech', 10, 100.00, 1200.00, 5, '2025-06-10 09:24:23', '2025-06-11 12:37:24'),
(19, '12R', 'Marrakech', '3333', 'Marrakech', 122, 100.00, 1200.00, NULL, '2025-06-12 11:05:36', '2025-06-12 11:05:36'),
(20, 'D44', 'Marrakech', '2000', 'Marrakech,abouab Marrakech', 10, 100.00, 1200.00, 5, '2025-06-12 11:06:31', '2025-06-12 11:06:31');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
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
-- Structure de la table `job_batches`
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
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_19_133819_create_immeubles_table', 2),
(5, '2025_05_19_134509_create_appartements_table', 2);

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE `paiement` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_A` bigint(20) UNSIGNED NOT NULL,
  `id_E` bigint(20) UNSIGNED DEFAULT NULL,
  `id_S` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mois_payes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`mois_payes`)),
  `montant` decimal(10,2) NOT NULL DEFAULT 0.00,
  `mois_paye` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`id`, `id_A`, `id_E`, `id_S`, `created_at`, `updated_at`, `mois_payes`, `montant`, `mois_paye`) VALUES
(24, 30, NULL, 1, '2025-06-11 09:07:48', '2025-06-11 09:07:48', '\"[\\\"2025-01-01\\\",\\\"2025-02-01\\\",\\\"2025-03-01\\\",\\\"2025-04-01\\\",\\\"2025-05-01\\\",\\\"2025-06-01\\\"]\"', 600.00, NULL),
(27, 35, NULL, 1, '2025-06-11 12:38:44', '2025-06-11 12:38:44', '\"[\\\"2025-01-01\\\",\\\"2025-02-01\\\",\\\"2025-03-01\\\",\\\"2025-04-01\\\",\\\"2025-05-01\\\"]\"', 500.00, NULL),
(28, 35, NULL, 1, '2025-06-11 12:39:25', '2025-06-11 12:39:25', '\"[\\\"2025-01-01\\\",\\\"2025-02-01\\\",\\\"2025-03-01\\\",\\\"2025-04-01\\\",\\\"2025-05-01\\\",\\\"2025-06-01\\\",\\\"2025-07-01\\\",\\\"2025-08-01\\\"]\"', 800.00, NULL),
(29, 36, NULL, 1, '2025-06-12 12:18:03', '2025-06-12 12:18:03', '\"[\\\"2025-07-01\\\",\\\"2025-08-01\\\"]\"', 300.00, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `residences`
--

CREATE TABLE `residences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `nombre_immeubles` int(10) UNSIGNED NOT NULL,
  `ville` varchar(100) NOT NULL,
  `code_postal` varchar(20) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `cotisation` decimal(10,2) NOT NULL DEFAULT 0.00,
  `caisse` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `residences`
--

INSERT INTO `residences` (`id`, `nom`, `nombre_immeubles`, `ville`, `code_postal`, `adresse`, `cotisation`, `caisse`, `created_at`, `updated_at`) VALUES
(5, 'IkrameeaAa', 3033, 'Marrakech', '2000', 'Marrakech,abouab Marrakech', 100.00, 1200.00, '2025-05-29 12:38:56', '2025-06-13 08:31:53'),
(7, 'DohaA', 5, 'Meknès', '7777', 'Meknes', 100.00, 1200.00, '2025-06-11 13:05:40', '2025-06-11 13:05:55'),
(8, 'Saida', 100, 'Agadir', '6666', 'Agadir', 100.00, 10000.00, '2025-06-12 11:07:31', '2025-06-12 11:07:31');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
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
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('at89JBxRerkK0GSxl7udycXsr0KxPMdbcqd1tHT1', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVmZjbm0xTEZ1Zm1NVXZTSEpCanVudkI5MWNZdVhjQWR1U1lDTGZYZiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749827863),
('fIGYdAduUyrC1yR6HgtAW0m8pWs3oygWVdSCfXii', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaDk5cjU2R2JxckZDZDJMcWRudUViZElrZGJTRVd5ZElFajUwek1XZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9oaXN0b3JpcXVlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1749824415),
('m15oln5Lnlbzc1w94yb59v6bOX1EUgQh9ZYAUJdz', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib25uZWs4MHdrWnpXcWVmQnRxeFd1VGNOQXNGc2tBcjRQMjI1alZ2MSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9oaXN0b3JpcXVlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1749815488),
('pKR1VxoetDd0dkRXyYYDGTvy4Khqe2j0K648ONDM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSnZlYVU1MGJQWnpMdzFDS2NjNmdWbHd3SlFVUHhuQzVIRlpXOVplaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbXBsb3llcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749812188);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_S` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'professionnel',
  `nom_societé` varchar(100) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `Fax` varchar(20) NOT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_S`, `name`, `prenom`, `statut`, `nom_societé`, `adresse`, `tel`, `Fax`, `ville`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'lahcen', 'OAATMANE', 'professionnel', '', 'Ben guerir', '0654324578', '', 'Ben guerir', 'lahcen12@gmail.com', NULL, '$2y$12$Mp1Oo1cPwFu8ZKeX.B8YouI/xQEKIMaIG7o8kr.kPTuKfXFhiICTW', 'rASQK618aaMeWAYUpZjmgeOztRO5CaWNQhJ4JaGdTgn4k8icGMqMjDAj1aaZ', '2025-05-26 20:43:38', '2025-05-26 20:43:38'),
(2, 'hgfrt', 'dfgh', 'benevolat', '', 'CASA', '0765432345', '', 'CASA', 'hg@gmail.com', NULL, '$2y$12$h2Y2CDcLsuOO90hwYVQAGeL1V5w4IxSyfti9wACzN6ozHDVij.8IK', NULL, '2025-05-27 08:36:15', '2025-05-27 08:36:15'),
(3, 'hgfty', 'hgt', 'professionnel', 'ghft', 'Marrakech,abouab Marrakech', '0654324567', '0556786545', 'Marrakech', 'GH@gmail.com', NULL, '$2y$12$6vTO5Cs6K48Wb/cMuJm30OPQGCq4RtAKavptv17sW7X/FYrkPtrSm', NULL, '2025-06-04 06:35:58', '2025-06-04 06:35:58');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `appartements`
--
ALTER TABLE `appartements`
  ADD PRIMARY KEY (`id_A`),
  ADD KEY `fk_appartements_immeuble_id` (`immeuble_id`);

--
-- Index pour la table `bereau`
--
ALTER TABLE `bereau`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `immeuble_id` (`immeuble_id`,`numero`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `charges`
--
ALTER TABLE `charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `immeuble_id` (`immeuble_id`);

--
-- Index pour la table `employes`
--
ALTER TABLE `employes`
  ADD PRIMARY KEY (`id_E`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_employes_immeuble` (`immeuble_id`);

--
-- Index pour la table `employe_immeuble`
--
ALTER TABLE `employe_immeuble`
  ADD PRIMARY KEY (`employe_id`,`immeuble_id`),
  ADD KEY `immeuble_id` (`immeuble_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_A` (`id_A`);

--
-- Index pour la table `immeuble`
--
ALTER TABLE `immeuble`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `numA` (`id_A`),
  ADD KEY `paiement_ibfk_2` (`id_E`),
  ADD KEY `paiement_ibfk_3` (`id_S`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `residences`
--
ALTER TABLE `residences`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_S`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `appartements`
--
ALTER TABLE `appartements`
  MODIFY `id_A` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT pour la table `bereau`
--
ALTER TABLE `bereau`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `charges`
--
ALTER TABLE `charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `employes`
--
ALTER TABLE `employes`
  MODIFY `id_E` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `historique`
--
ALTER TABLE `historique`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `immeuble`
--
ALTER TABLE `immeuble`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `residences`
--
ALTER TABLE `residences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_S` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartements`
--
ALTER TABLE `appartements`
  ADD CONSTRAINT `fk_appartements_immeuble_id` FOREIGN KEY (`immeuble_id`) REFERENCES `immeuble` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `bereau`
--
ALTER TABLE `bereau`
  ADD CONSTRAINT `fk_bereau_immeuble` FOREIGN KEY (`immeuble_id`) REFERENCES `immeuble` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `charges`
--
ALTER TABLE `charges`
  ADD CONSTRAINT `charges_ibfk_1` FOREIGN KEY (`immeuble_id`) REFERENCES `immeuble` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `employes`
--
ALTER TABLE `employes`
  ADD CONSTRAINT `fk_employes_immeuble` FOREIGN KEY (`immeuble_id`) REFERENCES `immeuble` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `employe_immeuble`
--
ALTER TABLE `employe_immeuble`
  ADD CONSTRAINT `employe_immeuble_ibfk_1` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id_E`) ON DELETE CASCADE,
  ADD CONSTRAINT `employe_immeuble_ibfk_2` FOREIGN KEY (`immeuble_id`) REFERENCES `immeuble` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `historique`
--
ALTER TABLE `historique`
  ADD CONSTRAINT `historique_ibfk_1` FOREIGN KEY (`id_A`) REFERENCES `appartements` (`id_A`);

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `paiement_ibfk_1` FOREIGN KEY (`id_A`) REFERENCES `appartements` (`id_A`) ON DELETE CASCADE,
  ADD CONSTRAINT `paiement_ibfk_2` FOREIGN KEY (`id_E`) REFERENCES `employes` (`id_E`),
  ADD CONSTRAINT `paiement_ibfk_3` FOREIGN KEY (`id_S`) REFERENCES `users` (`id_S`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
