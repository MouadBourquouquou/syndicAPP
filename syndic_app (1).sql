-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 31 juil. 2025 à 13:06
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
-- Structure de la table `appartements`
--

CREATE TABLE `appartements` (
  `id_A` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `immeuble_id` bigint(20) UNSIGNED NOT NULL,
  `numero` varchar(50) NOT NULL,
  `surface` decimal(8,2) NOT NULL,
  `montant_cotisation_mensuelle` decimal(10,2) NOT NULL,
  `dernier_mois_paye` date NOT NULL,
  `CIN_A` varchar(10) NOT NULL,
  `Nom` varchar(100) NOT NULL,
  `Prenom` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `appartements`
--

INSERT INTO `appartements` (`id_A`, `created_at`, `updated_at`, `immeuble_id`, `numero`, `surface`, `montant_cotisation_mensuelle`, `dernier_mois_paye`, `CIN_A`, `Nom`, `Prenom`, `telephone`, `email`) VALUES
(27, '2025-07-14 09:17:37', '2025-07-31 10:02:51', 12, '12B', 50.00, 400.00, '2025-09-01', 'EE339388', 'Inras', 'Soufian', '+212 7 10 46 18 52', 'mouadbourquouquou@gmail.com'),
(29, '2025-07-15 10:01:42', '2025-07-31 07:38:09', 12, '12', 50.00, 400.00, '2025-09-01', 'AB333456', 'Charaf', 'Ali', '+212 7 10 46 18 52', 'custom@gmail.com'),
(32, '2025-07-25 16:51:53', '2025-07-29 08:43:39', 14, '13C', 50.00, 400.00, '2025-07-01', 'AB333456', 'Bourquouquou', 'Mouad', '+212 7 10 46 18 52', 'mouadbourquouquou@gmail.com'),
(33, '2025-07-31 08:00:40', '2025-07-31 09:17:12', 18, '13', 50.00, 200.00, '2025-07-01', 'AB333456', 'Barik', 'Saad', '+212 7 10 46 18 52', 'mouadbourquouquou@gmail.com'),
(34, '2025-07-31 08:01:50', '2025-07-31 08:01:50', 18, 'AB', 60.00, 300.00, '2025-07-01', 'w456780', 'Obus', 'Jean', '+212 7 10 46 18 52', 'mouadbourquouquou@gmail.com'),
(35, '2025-07-31 08:02:53', '2025-07-31 08:34:44', 18, '8D', 45.50, 100.00, '2025-08-01', 'FF3338900', 'houd', 'Mohammad', '+212 7 10 46 18 52', 'mouadbourquouquou@gmail.com');

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
  `id_residence` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `etat` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `montant` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `charges`
--

INSERT INTO `charges` (`id`, `immeuble_id`, `id_residence`, `type`, `etat`, `description`, `montant`, `date`, `created_at`, `updated_at`) VALUES
(42, 14, 11, 'Clima', 'payée', 'clima', 300.00, '2025-07-25', '2025-07-26 20:02:51', '2025-07-26 20:02:51'),
(43, 12, 11, 'Eau', 'payée', 'Eau', 400.00, '2025-07-08', '2025-07-26 20:03:54', '2025-07-26 20:03:54'),
(44, 14, 11, 'Installation', 'payée', 'Installation', 500.00, '2025-07-30', '2025-07-26 20:04:26', '2025-07-26 20:06:20'),
(45, 14, 11, 'Eau', 'payée', '45', 1000.00, '2025-07-16', '2025-07-27 13:21:12', '2025-07-30 13:31:47'),
(46, 18, 12, 'Eau', 'non payée', 'Eau', 300.00, '2025-07-13', '2025-07-27 14:45:27', '2025-07-27 14:45:27'),
(47, 14, 11, 'Eau', 'non payée', 'Facture d\'eau', 300.00, '2025-07-18', '2025-07-30 13:32:25', '2025-07-30 13:32:25'),
(48, 18, 12, 'Eau', 'non payée', 'Eau', 200.00, '2025-07-23', '2025-07-31 09:41:20', '2025-07-31 09:41:20'),
(49, 12, 11, 'Eau', 'non payée', 'EAU', 200.00, '2025-07-24', '2025-07-31 10:04:29', '2025-07-31 10:04:29');

-- --------------------------------------------------------

--
-- Structure de la table `employes`
--

CREATE TABLE `employes` (
  `id_E` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `poste` varchar(255) NOT NULL,
  `date_embauche` date DEFAULT NULL,
  `salaire` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_S` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employes`
--

INSERT INTO `employes` (`id_E`, `nom`, `prenom`, `email`, `telephone`, `ville`, `adresse`, `poste`, `date_embauche`, `salaire`, `created_at`, `updated_at`, `id_S`) VALUES
(50, 'Alaoui Soussi', '', 'mouadbourquouquou@gmail.com', NULL, 'Marrakech', '199 Afaq1 Marrakech', 'assistant_syndic', '2025-07-24', 4000.00, '2025-07-17 08:43:11', '2025-07-31 09:35:10', 28),
(56, 'benzaghar', 'Hakim', 'ncomp920@gmail.com', '+212 71 04 61 852', 'Marrakech', '199 Afaq1 Marrakech , Maroc', 'assistant_syndic', '2025-07-25', 5000.00, '2025-07-31 09:07:41', '2025-07-31 09:07:41', 28);

-- --------------------------------------------------------

--
-- Structure de la table `employe_immeuble`
--

CREATE TABLE `employe_immeuble` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employe_id` bigint(20) UNSIGNED NOT NULL,
  `immeuble_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employe_immeuble`
--

INSERT INTO `employe_immeuble` (`id`, `employe_id`, `immeuble_id`, `created_at`, `updated_at`) VALUES
(9, 50, 12, NULL, NULL),
(10, 50, 14, NULL, NULL),
(16, 56, 18, NULL, NULL);

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
-- Structure de la table `immeuble`
--

CREATE TABLE `immeuble` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `code_postal` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `nombre_app` int(11) NOT NULL DEFAULT 0,
  `cotisation` decimal(10,2) NOT NULL,
  `caisse` decimal(10,2) DEFAULT NULL,
  `residence_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_S` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `immeuble`
--

INSERT INTO `immeuble` (`id`, `nom`, `ville`, `code_postal`, `adresse`, `nombre_app`, `cotisation`, `caisse`, `residence_id`, `created_at`, `updated_at`, `id_S`) VALUES
(12, '5', 'Marrakech', '40000', '199 Afaq1 Marrakech', 2, 400.00, 950.00, 11, '2025-07-14 09:17:09', '2025-07-31 10:02:51', 28),
(14, '15', 'Marrakech', '40000', '199 Afaq1 Marrakech', 3, 400.00, 3800.00, 11, '2025-07-15 13:13:59', '2025-07-30 13:31:47', 28),
(18, '2', 'Marrakech', '40000', '199 Afaq1 Marrakech , Maroc', 3, 500.00, 5500.00, 12, '2025-07-27 12:05:03', '2025-07-31 09:17:12', 28);

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
(4, '2025_05_18_000000__create_residences_table', 1),
(5, '2025_05_19_133819_create_immeubles_table', 1),
(6, '2025_05_19_134514_create_employes_table', 1),
(7, '2025_05_22_093620_create_charges_table', 1),
(8, '2025_05_23_114928_create_appartements_table', 1),
(9, '2025_05_25_140627_create_historiques_table', 1),
(10, '2025_05_30_101706_create_paiement_table', 1),
(11, '2025_06_05_002006_create_employe_immeuble_table', 1),
(12, '2025_07_02_115455_add_montant_to_paiement_table', 2),
(13, '2025_07_02_115933_add_immeuble_id_to_appartements_table', 3),
(14, '2025_07_02_132124_add_numero_to_appartements_table', 4),
(15, '2025_07_02_132234_add_surface_to_appartements_table', 5),
(16, '2025_07_02_132353_add_montant_cotisation_mensuelle_to_appartements_table', 6),
(17, '2025_07_02_132508_add_dernier_mois_paye_to_appartements_table', 7),
(18, '2025_07_02_132610_add_columns_to_appartements_table', 8),
(19, '2025_07_02_132733_add_missing_columns_to_appartements_table', 9),
(20, '2025_07_07_105616_create_historiques_table', 10),
(21, '2025_07_08_141542_add_is_active_to_users_table', 11),
(22, '2025_07_09_111012_add_is_admin_column_to_users_table', 12),
(23, '2025_07_14_102556_create_notifications_table', 13),
(24, '2025_07_18_122718_add_logo_to_users_table', 14);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('01047f07-a271-43d6-9064-3300e6d9f327', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9\",\"model_id\":null,\"model_name\":\" un Employ\\u00e9\",\"model_keyword\":\"employe\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9  un employ\\u00e9\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 09:14:42', '2025-07-31 08:55:22', '2025-07-31 09:14:42'),
('037a69d0-83ae-47c8-a938-2f4f94ed46fe', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 et pay\\u00e9\",\"model_id\":35,\"model_name\":\"!\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 et pay\\u00e9 !\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 19:24:20', '2025-07-27 15:32:54'),
('04cf9df4-4d4e-4e07-9f1f-2d1c572760ca', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a pay\\u00e9\",\"model_id\":24,\"model_name\":\"la charge\",\"model_keyword\":\"\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a pay\\u00e9 la charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 19:19:53', '2025-07-27 15:32:54'),
('074a64a7-806e-4b09-9724-621155d1b5ff', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 51, '{\"action\":\" a cr\\u00e9e\",\"model_id\":null,\"model_name\":\" Appartement\",\"user_name\":\"Hamid\",\"message\":\"Hamid a cr\\u00e9e appartement\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-23 13:31:28', '2025-07-23 13:28:27', '2025-07-23 13:31:28'),
('09efc980-f3da-4c95-a768-45be4d6d1fb2', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":14,\"model_name\":\" un Immeuble\",\"model_keyword\":\"immeuble\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a mis \\u00e0 jour  un immeuble\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-27 12:44:41', '2025-07-27 15:32:54'),
('0cebeeb5-9a02-4471-b35e-f32e1b00cd11', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a ajout\\u00e9\",\"model_id\":22,\"model_name\":\" une Charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou a ajout\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-25 09:32:52', '2025-07-25 09:30:31', '2025-07-25 09:32:52'),
('0ffad844-d08b-4ff3-be34-7b39285acff4', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\"a tent\\u00e9 de supprimer un paiement \",\"model_id\":36,\"model_name\":\"hors dernier mois.\",\"model_keyword\":\"paiement\",\"user_name\":\"Bourquouquou Mouad\",\"message\":\"Bourquouquou Mouad a tent\\u00e9 de supprimer un paiement  hors dernier mois.\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-29 08:15:04', '2025-07-29 08:14:52', '2025-07-29 08:15:04'),
('100e696c-b04e-4c3a-9687-915a548d063f', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a supprim\\u00e9\",\"model_id\":23,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 14:16:12', '2025-07-26 20:02:21', '2025-07-27 14:16:12'),
('102124e9-77fd-4985-925d-09814c1b2d32', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a supprim\\u00e9\",\"model_id\":19,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:23:31', '2025-07-27 15:23:27', '2025-07-27 15:23:31'),
('1029f489-c5c6-4479-b93b-6a7e8b6f7dc3', 'App\\Notifications\\SyndicDeactivated', 'App\\Models\\User', 39, '{\"message\":\"Votre compte a \\u00e9t\\u00e9 d\\u00e9sactiv\\u00e9 par l\'administrateur.\"}', NULL, '2025-07-21 07:07:44', '2025-07-21 07:07:44'),
('128d18ba-864b-43af-a213-813f85788eb5', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":48,\"model_name\":\"un paiement (mise \\u00e0 jour de la caisse)\",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9 un paiement (mise \\u00e0 jour de la caisse)\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 07:23:54', '2025-07-30 12:13:39', '2025-07-31 07:23:54'),
('14ef7a59-0a69-484e-bf3e-97fc9cadae0b', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":17,\"model_name\":\" une Charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf a supprim\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-23 21:31:47', '2025-07-23 21:18:28', '2025-07-23 21:31:47'),
('178193c2-b980-45fc-bfed-67a8f954fa72', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e \",\"model_id\":30,\"model_name\":\"\",\"model_keyword\":\",Fonds insuffisants dans la caisse.\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:29:54', '2025-07-27 15:32:54'),
('17ea09be-e796-4e05-9766-6ff155782dae', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":6,\"model_name\":\" une Charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf a supprim\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-23 21:31:34', '2025-07-23 21:31:27', '2025-07-23 21:31:34'),
('19a2b971-5a03-4164-8f37-01cc7ed5caa9', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e\",\"model_id\":41,\"model_name\":\"\",\"model_keyword\":\"charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a ajout\\u00e9 une charge non pay\\u00e9e \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 14:16:12', '2025-07-26 20:01:19', '2025-07-27 14:16:12'),
('1d1b6679-daa5-4467-8985-ec3bf6bc71c6', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e \",\"model_id\":26,\"model_name\":\"\",\"model_keyword\":\",Fonds insuffisants dans la caisse.\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:20:41', '2025-07-27 15:32:54'),
('1dea3a15-beb9-4070-bdcd-c3cf9ca3f0bb', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":25,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:47:17', '2025-07-27 15:32:54'),
('1e94220b-7d28-4d93-be78-611e82de16b9', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a supprim\\u00e9\",\"model_id\":41,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 14:16:12', '2025-07-26 20:01:25', '2025-07-27 14:16:12'),
('23e7757d-0ad9-4512-80ff-3e6f6b453125', 'App\\Notifications\\SyndicDeactivated', 'App\\Models\\User', 25, '{\"message\":\"Votre compte a \\u00e9t\\u00e9 d\\u00e9sactiv\\u00e9 par l\'administrateur.\"}', NULL, '2025-07-14 08:54:54', '2025-07-14 08:54:54'),
('263edda1-c714-476f-89ca-7e24baf20c3d', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a tent\\u00e9 de payer un mois d\\u00e9j\\u00e0 pay\\u00e9\",\"model_id\":null,\"model_name\":\"\",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a tent\\u00e9 de payer un mois d\\u00e9j\\u00e0 pay\\u00e9 \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 22:26:49', '2025-07-27 15:32:54'),
('27da26f7-42c5-4936-831f-74d2a8504f48', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":31,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:31:52', '2025-07-27 15:32:54'),
('2aa0e5f6-6892-4a8f-845b-9f2f8a25569a', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a supprim\\u00e9\",\"model_id\":40,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 14:16:12', '2025-07-26 19:59:57', '2025-07-27 14:16:12'),
('2c5853f1-10cf-474e-8977-2f34cdf71f64', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":34,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 20:16:37', '2025-07-26 19:25:06', '2025-07-26 20:16:37'),
('2ca5cf37-af5a-42b3-af8f-6efc9d92726f', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e\",\"model_id\":37,\"model_name\":\"!\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e !\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 20:16:30', '2025-07-26 19:31:47', '2025-07-26 20:16:30'),
('2e398edb-9876-4c48-b236-4673d91fdb9f', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":56,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 14:24:24', '2025-07-27 14:24:16', '2025-07-27 14:24:24'),
('307e9ac9-b26d-4768-a0e7-5b2c6614ad4b', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e\",\"model_id\":39,\"model_name\":\"!\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e !\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 20:16:23', '2025-07-26 19:39:55', '2025-07-26 20:16:23'),
('309b7f6e-dbb2-4372-b909-870988459d66', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a pay\\u00e9 une charge\",\"model_id\":45,\"model_name\":\"\",\"model_keyword\":\"charge\",\"user_name\":\"Alaoui\",\"message\":\"Alaoui  a pay\\u00e9 une charge \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-30 13:32:29', '2025-07-30 13:31:47', '2025-07-30 13:32:29'),
('3137ba5e-9ef7-4c09-abe3-e5b7caffa751', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e\",\"model_id\":24,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:13:33', '2025-07-27 15:32:54'),
('329d71dc-cd24-466e-bc92-a2dd504eddeb', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":54,\"model_name\":\"un paiement (mise \\u00e0 jour de la caisse)\",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9 un paiement (mise \\u00e0 jour de la caisse)\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-29 08:11:00', '2025-07-29 08:10:25', '2025-07-29 08:11:00'),
('39d67512-2c8f-4d61-940d-549800d38e54', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":59,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Bourquouquou Mouad\",\"message\":\"Bourquouquou Mouad  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-30 12:18:16', '2025-07-30 12:18:10', '2025-07-30 12:18:16'),
('3be9bc23-cff8-428b-b5ac-b238ffb6c615', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":53,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-27 09:37:46', '2025-07-27 15:32:54'),
('3d61a213-426e-48a9-9eb9-012d777ad35d', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\"a tent\\u00e9 de supprimer un paiement \",\"model_id\":51,\"model_name\":\"hors dernier mois.\",\"model_keyword\":\"paiement\",\"user_name\":\"Bourquouquou Mouad\",\"message\":\"Bourquouquou Mouad a tent\\u00e9 de supprimer un paiement  hors dernier mois.\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-30 12:06:28', '2025-07-30 12:06:08', '2025-07-30 12:06:28'),
('3e9952a2-36c1-4180-a0a9-cb302dfb7c19', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":8,\"model_name\":\" une Charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf a supprim\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-23 21:31:36', '2025-07-23 21:31:21', '2025-07-23 21:31:36'),
('49504e54-7626-4414-9067-424efb3767ea', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a ajout\\u00e9 et pay\\u00e9\",\"model_id\":43,\"model_name\":\"\",\"model_keyword\":\"charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a ajout\\u00e9 et pay\\u00e9 \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 14:16:12', '2025-07-26 20:03:55', '2025-07-27 14:16:12'),
('49e84575-26ff-4e07-b155-13fbb6749697', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e\",\"model_id\":47,\"model_name\":\"\",\"model_keyword\":\"charge\",\"user_name\":\"Alaoui\",\"message\":\"Alaoui  a ajout\\u00e9 une charge non pay\\u00e9e \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-30 13:32:29', '2025-07-30 13:32:25', '2025-07-30 13:32:29'),
('4a350f96-9fa6-46ea-a84b-5111766063d9', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e\",\"model_id\":49,\"model_name\":\"!\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e !\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 10:04:37', '2025-07-31 10:04:30', '2025-07-31 10:04:37'),
('4c0ab972-e14a-4c64-b24c-02285d77b09c', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 et pay\\u00e9\",\"model_id\":34,\"model_name\":\"!\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 et pay\\u00e9 !\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 19:24:19', '2025-07-27 15:32:54'),
('4dd1620c-7e50-4ab7-aff8-b74954c44daa', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9\",\"model_id\":19,\"model_name\":\" une Charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf a ajout\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-24 07:39:00', '2025-07-24 06:15:13', '2025-07-24 07:39:00'),
('5173edb0-d9d7-4556-9485-22b81a2ff420', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":55,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 14:16:12', '2025-07-27 10:55:03', '2025-07-27 14:16:12'),
('51b1568d-2d89-466c-9ee1-43ef8a9213d8', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a ajout\\u00e9\",\"model_id\":21,\"model_name\":\" une Charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou a ajout\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-24 09:33:24', '2025-07-24 09:33:10', '2025-07-24 09:33:24'),
('51f9992e-c30d-46ce-9ff1-7db29288d287', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9\",\"model_id\":17,\"model_name\":\" un Immeuble\",\"model_keyword\":\"immeuble\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9  un immeuble\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-27 11:49:32', '2025-07-27 15:32:54'),
('523d2889-db8a-44ec-a53d-17e9ddfe2068', 'App\\Notifications\\SyndicDeactivated', 'App\\Models\\User', 50, '{\"message\":\"Votre compte a \\u00e9t\\u00e9 d\\u00e9sactiv\\u00e9 par l\'administrateur.\"}', '2025-07-23 16:30:11', '2025-07-21 07:09:24', '2025-07-23 16:30:11'),
('54de0301-0654-4947-a48d-8bf9db080b34', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a supprim\\u00e9\",\"model_id\":55,\"model_name\":\"un paiement (mise \\u00e0 jour de la caisse)\",\"model_keyword\":\"paiement\",\"user_name\":\"Bourquouquou Mouad\",\"message\":\"Bourquouquou Mouad  a supprim\\u00e9 un paiement (mise \\u00e0 jour de la caisse)\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-29 08:43:51', '2025-07-29 08:43:39', '2025-07-29 08:43:51'),
('55559f30-a1fc-4be7-8d39-6d6ea639769a', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":12,\"model_name\":\" une R\\u00e9sidence\",\"model_keyword\":\"residence\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a mis \\u00e0 jour  une r\\u00e9sidence\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-27 11:48:57', '2025-07-27 15:32:54'),
('58fcce0f-bbae-4259-80a8-dd687b5eca32', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e, Fonds insuffisants dans la caisse. \",\"model_id\":31,\"model_name\":\"\",\"model_keyword\":\"\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e, Fonds insuffisants dans la caisse.  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:31:37', '2025-07-27 15:32:54'),
('596b931e-bff6-4faf-8d72-3ff6ca916fff', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":35,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 20:16:38', '2025-07-26 19:24:49', '2025-07-26 20:16:38'),
('5a5d16c4-568d-40ed-b189-98018b683785', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":20,\"model_name\":\" une Charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf a supprim\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-24 09:24:01', '2025-07-24 08:55:59', '2025-07-24 09:24:01'),
('5b03895b-4aef-461b-9ae5-294025a1c4ca', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":16,\"model_name\":\" une Charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf a supprim\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-23 21:31:43', '2025-07-23 21:18:32', '2025-07-23 21:31:43'),
('5e404b2f-8220-4b5d-b603-37b029b89e76', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 51, '{\"action\":\" a ajout\\u00e9\",\"model_id\":12,\"model_name\":\" une Charge\",\"user_name\":\"Hamid\",\"message\":\"Hamid a ajout\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', NULL, '2025-07-23 16:14:45', '2025-07-23 16:14:45'),
('60022064-a007-4191-8748-a1df2c8a5cf9', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e\",\"model_id\":40,\"model_name\":\"\",\"model_keyword\":\"charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a ajout\\u00e9 une charge non pay\\u00e9e \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 14:16:12', '2025-07-26 19:59:18', '2025-07-27 14:16:12'),
('655523b2-a4cb-43c6-aea6-1014227b9adb', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":17,\"model_name\":\" un Immeuble\",\"model_keyword\":\"immeuble\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  un immeuble\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-27 11:58:32', '2025-07-27 15:32:54'),
('65d6fc63-5432-48fd-8b08-58f3a65bf2a1', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e, Fonds insuffisants dans la caisse. \",\"model_id\":38,\"model_name\":\"\",\"model_keyword\":\"\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e, Fonds insuffisants dans la caisse.  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 20:16:27', '2025-07-26 19:32:31', '2025-07-26 20:16:27'),
('68c49365-74f7-40c6-ba4d-de8c9911dd1b', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":null,\"model_name\":\" une Appartement\",\"user_name\":\"Charaf\",\"message\":\"Charaf a supprim\\u00e9 une appartement\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-24 07:39:03', '2025-07-24 05:54:11', '2025-07-24 07:39:03'),
('694bf844-7f5f-42d6-bfcf-bfe106094a98', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":14,\"model_name\":\" un Immeuble\",\"model_keyword\":\"immeuble\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a mis \\u00e0 jour  un immeuble\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-27 12:47:20', '2025-07-27 15:32:54'),
('69a48666-c876-4c40-ac63-cdfbb7f792e4', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":9,\"model_name\":\" une Charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf a supprim\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-23 21:31:37', '2025-07-23 21:31:15', '2025-07-23 21:31:37'),
('71e2a353-c010-4e48-85a4-41da2a7a3c51', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":null,\"model_name\":\" une Appartement\",\"model_keyword\":\"appartement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a mis \\u00e0 jour  une appartement\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:11:58', '2025-07-27 15:32:54'),
('72a19d4c-c82b-470e-8f56-084d877c80ec', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":36,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 20:16:32', '2025-07-26 19:31:23', '2025-07-26 20:16:32'),
('7300802f-7052-4710-96b4-231d45158c9d', 'App\\Notifications\\SyndicDeactivated', 'App\\Models\\User', 28, '{\"message\":\"Votre compte a \\u00e9t\\u00e9 d\\u00e9sactiv\\u00e9 par l\'administrateur.\"}', '2025-07-23 21:18:01', '2025-07-21 07:07:23', '2025-07-23 21:18:01'),
('75ae01ef-45ae-4941-b644-f90645d9ff68', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a tent\\u00e9 de payer un mois d\\u00e9j\\u00e0 pay\\u00e9\",\"model_id\":null,\"model_name\":\" un Paiement\",\"model_keyword\":\"paiement\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a tent\\u00e9 de payer un mois d\\u00e9j\\u00e0 pay\\u00e9  un paiement\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 14:16:12', '2025-07-26 21:05:55', '2025-07-27 14:16:12'),
('7651c57e-b9b4-4a2d-9dee-4b027d083b6b', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":21,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 19:23:07', '2025-07-27 15:32:54'),
('77329e0c-c1a4-4289-89bd-14948e1e9895', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 51, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":null,\"model_name\":\" une Appartement\",\"user_name\":\"Hamid\",\"message\":\"Hamid a mis \\u00e0 jour une appartement\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-24 06:29:13', '2025-07-24 05:54:01', '2025-07-24 06:29:13'),
('77effd9b-1e9a-4a31-b074-301aad840eb6', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9\",\"model_id\":20,\"model_name\":\" une Charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf a ajout\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-24 08:43:59', '2025-07-24 08:18:40', '2025-07-24 08:43:59'),
('789c75fe-da40-49db-b497-be0158dae7f2', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":52,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 21:08:36', '2025-07-27 15:32:54'),
('7c3b03e2-feaf-4d56-a08a-d8e894701c25', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 51, '{\"action\":\" a ajout\\u00e9\",\"model_id\":16,\"model_name\":\" un Immeuble\",\"user_name\":\"Hamid\",\"message\":\"Hamid a ajout\\u00e9 un immeuble\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-23 13:31:27', '2025-07-23 13:27:34', '2025-07-23 13:31:27'),
('7dfd4115-b196-402f-ba16-70a30fc6e072', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":39,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 20:16:22', '2025-07-26 19:40:10', '2025-07-26 20:16:22'),
('7f83b46a-6216-4854-9062-f73450553b06', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e\",\"model_id\":33,\"model_name\":\"!\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e !\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:46:03', '2025-07-27 15:32:54'),
('81d24fad-45ed-4c6e-972f-a801dc3487bb', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":33,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:47:01', '2025-07-27 15:32:54'),
('873af59f-5030-4234-9214-64db9a67db79', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 51, '{\"action\":\" a ajout\\u00e9\",\"model_id\":13,\"model_name\":\" une Charge\",\"user_name\":\"Hamid\",\"message\":\"Hamid a ajout\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', NULL, '2025-07-23 16:14:46', '2025-07-23 16:14:46'),
('8837a72e-f56e-4bd7-99f8-04692f2dee38', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\"a tent\\u00e9 de supprimer un paiement \",\"model_id\":40,\"model_name\":\"hors dernier mois.\",\"model_keyword\":\"paiement\",\"user_name\":\"Bourquouquou Mouad\",\"message\":\"Bourquouquou Mouad a tent\\u00e9 de supprimer un paiement  hors dernier mois.\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-30 12:16:56', '2025-07-30 12:07:18', '2025-07-30 12:16:56'),
('8af828c1-6e8f-4ac5-bf4b-a0c4247a6d68', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e\",\"model_id\":46,\"model_name\":\"!\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e !\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:09:42', '2025-07-27 14:45:27', '2025-07-27 15:09:42'),
('8df72adb-2356-4ed8-8a4c-ec27af5253cc', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e\",\"model_id\":44,\"model_name\":\"\",\"model_keyword\":\"charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a ajout\\u00e9 une charge non pay\\u00e9e \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 14:16:12', '2025-07-26 20:04:26', '2025-07-27 14:16:12'),
('8e54830f-5de5-4b2b-82a7-465887dbbdfc', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":14,\"model_name\":\" un Immeuble\",\"model_keyword\":\"immeuble\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a mis \\u00e0 jour  un immeuble\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-27 12:44:57', '2025-07-27 15:32:54'),
('9306aa13-ef54-4df4-b437-2d260a4d889a', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\"a tent\\u00e9 de supprimer un paiement \",\"model_id\":48,\"model_name\":\"hors dernier mois.\",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf a tent\\u00e9 de supprimer un paiement  hors dernier mois.\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-30 12:12:30', '2025-07-30 12:11:37', '2025-07-30 12:12:30'),
('95348227-c0dd-4730-9f20-4581ad80192d', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":10,\"model_name\":\" une Charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf a supprim\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-23 21:20:17', '2025-07-23 21:18:49', '2025-07-23 21:20:17'),
('964386d0-9315-49bf-b560-f212ca9a698e', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a pay\\u00e9 une charge\",\"model_id\":44,\"model_name\":\"\",\"model_keyword\":\"charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a pay\\u00e9 une charge \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 14:16:12', '2025-07-26 20:06:20', '2025-07-27 14:16:12'),
('97db3778-9424-4df3-a830-bff67ba64a7c', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a cr\\u00e9e\",\"model_id\":null,\"model_name\":\" une Appartement\",\"model_keyword\":\"appartement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a cr\\u00e9e  une appartement\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 08:03:26', '2025-07-31 08:02:53', '2025-07-31 08:03:26'),
('9859b71c-edf8-4ca3-a522-cd8232e9a20d', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\"a tent\\u00e9 de supprimer un paiement \",\"model_id\":49,\"model_name\":\"hors dernier mois.\",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf a tent\\u00e9 de supprimer un paiement  hors dernier mois.\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-29 08:10:19', '2025-07-29 08:02:38', '2025-07-29 08:10:19'),
('9d026c9a-f3be-499d-a456-952841ff9d8a', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 et pay\\u00e9\",\"model_id\":27,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 et pay\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:26:10', '2025-07-27 15:32:54'),
('9dcb51b9-8c6d-44fb-a2ba-9b11075e561e', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":12,\"model_name\":\" un Immeuble\",\"user_name\":\"Charaf\",\"message\":\"Charaf a mis \\u00e0 jour un immeuble\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 09:41:16', '2025-07-25 17:24:57', '2025-07-26 09:41:16'),
('9ddc21e9-e0ec-42cb-a5e2-f4424a2562fb', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e\",\"model_id\":45,\"model_name\":\"!\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e !\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:09:50', '2025-07-27 13:21:12', '2025-07-27 15:09:50'),
('a3db999b-535a-4460-a8f7-89a08b420062', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":28,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 19:23:16', '2025-07-27 15:32:54'),
('a61f3097-9ebf-4094-a5d9-a2b2f287c42e', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":12,\"model_name\":\" un Immeuble\",\"model_keyword\":\"immeuble\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a mis \\u00e0 jour  un immeuble\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 20:16:18', '2025-07-26 20:07:12', '2025-07-26 20:16:18'),
('a6a0c78e-2ba5-4d46-ba26-bc198269e6e8', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":32,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:47:08', '2025-07-27 15:32:54'),
('a8866c26-c3a4-426f-bd66-060e8a9a2987', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":54,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-27 09:55:20', '2025-07-27 15:32:54'),
('a8fd79da-0e22-4717-b3b8-ad6c91e9fc40', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a ajout\\u00e9\",\"model_id\":17,\"model_name\":\" une Charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou a ajout\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-23 17:15:16', '2025-07-23 17:15:01', '2025-07-23 17:15:16'),
('a95abb63-5869-4c81-aa39-f53f855a69d3', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a supprim\\u00e9\",\"model_id\":24,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 14:16:12', '2025-07-26 20:02:04', '2025-07-27 14:16:12'),
('aa994f78-195d-4527-b337-1685eb04251a', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a pay\\u00e9\",\"model_id\":51,\"model_name\":\" un Paiement\",\"model_keyword\":\"paiement\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a pay\\u00e9  un paiement\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 14:16:12', '2025-07-26 21:06:13', '2025-07-27 14:16:12'),
('ac569e06-6b8a-4297-93b0-093cba887993', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a pay\\u00e9\",\"model_id\":37,\"model_name\":\"la charge\",\"model_keyword\":\"\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a pay\\u00e9 la charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 20:16:29', '2025-07-26 19:31:59', '2025-07-26 20:16:29'),
('add53fdc-afee-4033-9a52-7adf6bccf04a', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a supprim\\u00e9\",\"model_id\":58,\"model_name\":\"un paiement (mise \\u00e0 jour de la caisse)\",\"model_keyword\":\"paiement\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a supprim\\u00e9 un paiement (mise \\u00e0 jour de la caisse)\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-29 07:46:17', '2025-07-29 07:46:10', '2025-07-29 07:46:17'),
('b09d4df8-26fe-40ca-8f66-f53fe4be7076', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":11,\"model_name\":\" une R\\u00e9sidence\",\"model_keyword\":\"residence\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a mis \\u00e0 jour  une r\\u00e9sidence\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-27 11:48:22', '2025-07-27 15:32:54'),
('b19004b5-eda4-497c-9cee-dd8e9a303d8e', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":12,\"model_name\":\" un Immeuble\",\"model_keyword\":\"immeuble\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a mis \\u00e0 jour  un immeuble\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:09:51', '2025-07-27 12:47:35', '2025-07-27 15:09:51'),
('b19c5643-dc97-4ffb-9f2c-d7c00e7553c8', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 51, '{\"action\":\" a ajout\\u00e9\",\"model_id\":13,\"model_name\":\" une R\\u00e9sidence\",\"user_name\":\"Hamid\",\"message\":\"Hamid a ajout\\u00e9 une r\\u00e9sidence\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-23 13:31:25', '2025-07-23 13:27:16', '2025-07-23 13:31:25'),
('b2cf3b17-8d10-4959-a161-51a973b5c252', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9\",\"model_id\":23,\"model_name\":\" une Charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf a ajout\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-25 16:55:32', '2025-07-25 16:55:00', '2025-07-25 16:55:32'),
('b3075b79-6847-4412-a254-a5b858cdc0fa', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e\",\"model_id\":36,\"model_name\":\"!\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e !\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 20:16:35', '2025-07-26 19:25:33', '2025-07-26 20:16:35'),
('b315dd27-5bf9-4aaa-933a-e89e81de6c2a', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":65,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 08:34:49', '2025-07-31 08:34:44', '2025-07-31 08:34:49'),
('b5bf7720-a4ec-4e7d-bdb0-fd0af9493573', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 51, '{\"action\":\" a ajout\\u00e9\",\"model_id\":14,\"model_name\":\" une Charge\",\"user_name\":\"Hamid\",\"message\":\"Hamid a ajout\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', NULL, '2025-07-23 16:16:40', '2025-07-23 16:16:40'),
('b6b9f884-15b5-49d3-84c0-44b21d22e9ea', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":null,\"model_name\":\" une Appartement\",\"user_name\":\"Charaf\",\"message\":\"Charaf a mis \\u00e0 jour une appartement\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-25 16:54:05', '2025-07-25 16:53:45', '2025-07-25 16:54:05'),
('b737ff3f-975b-434e-8a67-2a100ef7c366', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a pay\\u00e9\",\"model_id\":28,\"model_name\":\"la charge\",\"model_keyword\":\"\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a pay\\u00e9 la charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 19:19:45', '2025-07-27 15:32:54'),
('b79ebc56-a875-449c-9f2f-efb6ffa6cfb4', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":66,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 09:17:21', '2025-07-31 09:17:13', '2025-07-31 09:17:21'),
('b9705a8e-7760-4302-9a6c-cb336aaab9ff', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":60,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Bourquouquou Mouad\",\"message\":\"Bourquouquou Mouad  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-30 12:20:45', '2025-07-30 12:19:19', '2025-07-30 12:20:45'),
('ba1305d3-2edf-49c4-826e-15302912866b', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":null,\"model_name\":\" une Appartement\",\"model_keyword\":\"appartement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a mis \\u00e0 jour  une appartement\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 07:49:42', '2025-07-31 07:45:11', '2025-07-31 07:49:42'),
('ba5f5efd-9a09-4b7f-82fa-b42db6157672', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a ajout\\u00e9 et pay\\u00e9\",\"model_id\":42,\"model_name\":\"\",\"model_keyword\":\"charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a ajout\\u00e9 et pay\\u00e9 \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 14:16:12', '2025-07-26 20:02:51', '2025-07-27 14:16:12'),
('bf4d404c-7388-4191-a582-a58170e85db2', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":37,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 20:16:20', '2025-07-26 19:45:49', '2025-07-26 20:16:20'),
('c5e2b227-ff04-4443-b864-28f4cbe2478b', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":null,\"model_name\":\" une Appartement\",\"model_keyword\":\"appartement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a mis \\u00e0 jour  une appartement\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 07:23:54', '2025-07-30 12:15:31', '2025-07-31 07:23:54'),
('c7448338-6ea1-4bc5-beef-8e39f77c9886', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":62,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 07:38:28', '2025-07-31 07:38:09', '2025-07-31 07:38:28'),
('c8818e0f-1ec0-4297-97d8-bdbc778839e0', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":29,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:32:38', '2025-07-27 15:32:54'),
('cbb78cd6-d860-4d41-b5d2-d64b9719772a', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":52,\"model_name\":\"un paiement (mise \\u00e0 jour de la caisse)\",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9 un paiement (mise \\u00e0 jour de la caisse)\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-29 08:12:06', '2025-07-29 08:11:17', '2025-07-29 08:12:06'),
('cbf52aaa-4611-440a-9e3a-babbc5cf746f', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":14,\"model_name\":\" un Immeuble\",\"model_keyword\":\"immeuble\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a mis \\u00e0 jour  un immeuble\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 20:16:16', '2025-07-26 20:07:23', '2025-07-26 20:16:16'),
('cc553b30-3e14-4b7d-8ba8-12a9d2b350a4', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a supprim\\u00e9\",\"model_id\":46,\"model_name\":\"un paiement (mise \\u00e0 jour de la caisse)\",\"model_keyword\":\"paiement\",\"user_name\":\"Bourquouquou Mouad\",\"message\":\"Bourquouquou Mouad  a supprim\\u00e9 un paiement (mise \\u00e0 jour de la caisse)\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-29 08:42:34', '2025-07-29 08:41:53', '2025-07-29 08:42:34'),
('cca13b27-d994-4255-a66b-20946b04ca38', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e (fonds insuffisants)\",\"model_id\":25,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e (fonds insuffisants)  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:14:50', '2025-07-27 15:32:54'),
('cecd27ce-0aed-4192-ae91-1d84d107563e', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":64,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 07:49:42', '2025-07-31 07:49:39', '2025-07-31 07:49:42');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('cfe30d6d-1751-4c70-9417-08f152f51078', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9\",\"model_id\":null,\"model_name\":\" un Employ\\u00e9\",\"model_keyword\":\"employe\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9  un employ\\u00e9\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 09:14:42', '2025-07-31 09:07:45', '2025-07-31 09:14:42'),
('d185393e-cf27-40ac-bb32-7e552cb12bb0', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":38,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 20:16:25', '2025-07-26 19:35:46', '2025-07-26 20:16:25'),
('d2f1c5d2-2469-4aee-a9ec-0bbf6b76c64e', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":null,\"model_name\":\" une Appartement\",\"model_keyword\":\"appartement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a mis \\u00e0 jour  une appartement\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 07:23:54', '2025-07-30 12:13:22', '2025-07-31 07:23:54'),
('d3286a44-4fed-491a-9671-52cc62b71bed', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":15,\"model_name\":\" une Charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf a supprim\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-23 21:31:41', '2025-07-23 21:18:38', '2025-07-23 21:31:41'),
('d3b327b6-e10d-40cf-9491-8c3a7599d227', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 et pay\\u00e9\",\"model_id\":29,\"model_name\":\"!\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 et pay\\u00e9 !\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:28:19', '2025-07-27 15:32:54'),
('d76e2a85-ab08-428a-9e35-d7bb031b0f56', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a cr\\u00e9e\",\"model_id\":null,\"model_name\":\" une Appartement\",\"model_keyword\":\"appartement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a cr\\u00e9e  une appartement\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 08:01:02', '2025-07-31 08:00:40', '2025-07-31 08:01:02'),
('d8e93925-8845-4283-b09b-bef82f7f93ca', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a cr\\u00e9e\",\"model_id\":null,\"model_name\":\" Appartement\",\"user_name\":\"Charaf\",\"message\":\"Charaf a cr\\u00e9e appartement\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-25 16:52:00', '2025-07-25 16:51:53', '2025-07-25 16:52:00'),
('d9549e82-8cbc-4cf4-8e9f-16b64bb41f22', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\"a tent\\u00e9 de supprimer un paiement \",\"model_id\":51,\"model_name\":\"hors dernier mois.\",\"model_keyword\":\"paiement\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou a tent\\u00e9 de supprimer un paiement  hors dernier mois.\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-29 08:00:58', '2025-07-29 08:00:52', '2025-07-29 08:00:58'),
('d9f222ac-83be-496b-9ce5-4fe5a20fdc31', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a ajout\\u00e9\",\"model_id\":18,\"model_name\":\" une Charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou a ajout\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-23 18:31:59', '2025-07-23 18:15:50', '2025-07-23 18:31:59'),
('db8d8c2d-2db6-498d-adef-fc93d4f33c8f', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":30,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:30:49', '2025-07-27 15:32:54'),
('def48032-2930-4ebe-9709-8713af4e3e38', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":58,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-29 07:29:57', '2025-07-29 07:29:46', '2025-07-29 07:29:57'),
('e1245cd3-55bc-4bff-b304-199d60600788', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9\",\"model_id\":null,\"model_name\":\" un Employ\\u00e9\",\"model_keyword\":\"employe\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9  un employ\\u00e9\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 08:48:31', '2025-07-31 08:42:52', '2025-07-31 08:48:31'),
('e24ecc5f-d9ac-4e17-bd2c-4dfc6d7493f8', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 51, '{\"action\":\" a ajout\\u00e9\",\"model_id\":11,\"model_name\":\" une Charge\",\"user_name\":\"Hamid\",\"message\":\"Hamid a ajout\\u00e9 une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-23 14:34:26', '2025-07-23 14:34:19', '2025-07-23 14:34:26'),
('e53d0fcc-519d-40d3-b71a-f1e18fca5e65', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":26,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:25:18', '2025-07-27 15:32:54'),
('e5cec4e2-9f2f-4904-9db6-815aacc97bef', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\"a tent\\u00e9 de supprimer un paiement \",\"model_id\":36,\"model_name\":\"hors dernier mois.\",\"model_keyword\":\"paiement\",\"user_name\":\"Bourquouquou Mouad\",\"message\":\"Bourquouquou Mouad a tent\\u00e9 de supprimer un paiement  hors dernier mois.\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-29 08:43:15', '2025-07-29 08:42:42', '2025-07-29 08:43:15'),
('e5fe1a19-47a1-4e9a-8f0b-a31894acfc75', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e\",\"model_id\":32,\"model_name\":\"!\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e !\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:37:02', '2025-07-27 15:32:54'),
('e665aee9-43ee-4136-8f66-e4394cd8cb41', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":57,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:09:45', '2025-07-27 14:38:51', '2025-07-27 15:09:45'),
('e7991cd4-6e32-489e-8387-585f5c321371', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e\",\"model_id\":48,\"model_name\":\"!\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e !\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 10:03:34', '2025-07-31 09:41:20', '2025-07-31 10:03:34'),
('e7a50ae0-bb55-44c8-90ad-64579ee387d9', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":63,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 07:43:52', '2025-07-31 07:43:01', '2025-07-31 07:43:52'),
('e91bd2ad-641b-4dca-a95d-f3fde4195cb2', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a fait le paiement de \",\"model_id\":null,\"model_name\":\"avec succes\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou a fait le paiement de avec succes\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-23 17:24:55', '2025-07-23 17:24:17', '2025-07-23 17:24:55'),
('e9c39f9d-359f-413c-8529-c889a1e6947e', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a pay\\u00e9\",\"model_id\":36,\"model_name\":\"la charge\",\"model_keyword\":\"\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a pay\\u00e9 la charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 20:16:33', '2025-07-26 19:26:26', '2025-07-26 20:16:33'),
('f0f322c9-44bb-412f-a1eb-3bfe6c7fa52b', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":61,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 07:38:28', '2025-07-31 07:37:38', '2025-07-31 07:38:28'),
('f562cef8-3e9b-4f4f-94fa-33b4214e34b0', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a cr\\u00e9e\",\"model_id\":null,\"model_name\":\" une Appartement\",\"model_keyword\":\"appartement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a cr\\u00e9e  une appartement\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 08:01:52', '2025-07-31 08:01:50', '2025-07-31 08:01:52'),
('f79f8008-dec5-4efb-ae52-e5a31022206a', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 50, '{\"action\":\" a supprim\\u00e9\",\"model_id\":22,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Bourquouquou\",\"message\":\"Bourquouquou  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 14:16:12', '2025-07-26 20:02:11', '2025-07-27 14:16:12'),
('fb32c80c-2d87-4139-aef5-1691e6f0b00e', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a supprim\\u00e9\",\"model_id\":27,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a supprim\\u00e9  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-26 20:16:20', '2025-07-26 19:45:42', '2025-07-26 20:16:20'),
('fbdffe5f-88fa-4c9f-a5f9-2ff14eba2e10', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\"a tent\\u00e9 de supprimer un paiement \",\"model_id\":54,\"model_name\":\"hors dernier mois.\",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf a tent\\u00e9 de supprimer un paiement  hors dernier mois.\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-29 08:10:19', '2025-07-29 08:03:00', '2025-07-29 08:10:19'),
('fc2dd183-662e-492b-8d40-7a2f42a125d6', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9\",\"model_id\":18,\"model_name\":\" un Immeuble\",\"model_keyword\":\"immeuble\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9  un immeuble\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-27 12:05:03', '2025-07-27 15:32:54'),
('fdb9e224-ea02-44d9-a283-bb4159c69a7f', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a ajout\\u00e9 une charge non pay\\u00e9e\",\"model_id\":28,\"model_name\":\" une Charge\",\"model_keyword\":\"charge\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a ajout\\u00e9 une charge non pay\\u00e9e  une charge\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-26 18:27:05', '2025-07-27 15:32:54'),
('fe64b29d-6961-4be9-be90-9c3eaedfa5c8', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a mis \\u00e0 jour\",\"model_id\":11,\"model_name\":\" une R\\u00e9sidence\",\"model_keyword\":\"residence\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a mis \\u00e0 jour  une r\\u00e9sidence\",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-27 15:32:54', '2025-07-27 11:48:35', '2025-07-27 15:32:54'),
('ffb573eb-2c8c-431e-8791-57f478a088cb', 'App\\Notifications\\ActionNotification', 'App\\Models\\User', 28, '{\"action\":\" a pay\\u00e9 avec succ\\u00e8s\",\"model_id\":67,\"model_name\":\" \",\"model_keyword\":\"paiement\",\"user_name\":\"Charaf\",\"message\":\"Charaf  a pay\\u00e9 avec succ\\u00e8s  \",\"priority\":\"medium\",\"category\":\"system\",\"additional_data\":[]}', '2025-07-31 10:03:34', '2025-07-31 10:02:51', '2025-07-31 10:03:34');

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE `paiement` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_A` bigint(20) UNSIGNED NOT NULL,
  `mois_payes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`mois_payes`)),
  `id_E` int(11) DEFAULT NULL,
  `id_S` int(11) DEFAULT NULL,
  `montant` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`id`, `id_A`, `mois_payes`, `id_E`, `id_S`, `montant`, `created_at`, `updated_at`) VALUES
(35, 27, '\"[\\\"2025-02-01\\\"]\"', 50, 28, 400.00, '2025-07-20 10:48:50', '2025-07-20 10:48:50'),
(36, 29, '\"[\\\"2025-02-01\\\"]\"', 50, 50, 400.00, '2025-07-20 10:49:41', '2025-07-20 10:49:41'),
(37, 27, '\"[\\\"2025-03-01\\\"]\"', 50, 50, 400.00, '2025-07-20 14:13:42', '2025-07-20 14:13:42'),
(39, 27, '\"[\\\"2025-04-01\\\"]\"', 50, 50, 400.00, '2025-07-23 07:59:06', '2025-07-23 07:59:06'),
(40, 29, '\"[\\\"2025-03-01\\\"]\"', 50, 50, 400.00, '2025-07-23 13:30:30', '2025-07-23 13:30:30'),
(42, 27, '\"[\\\"2025-05-01\\\"]\"', 50, 50, 400.00, '2025-07-23 14:39:01', '2025-07-23 14:39:01'),
(45, 27, '\"[\\\"2025-07-01\\\"]\"', 50, 50, 400.00, '2025-07-23 17:21:30', '2025-07-23 17:21:30'),
(47, 27, '\"[\\\"2025-09-01\\\"]\"', 50, 50, 400.00, '2025-07-23 17:24:17', '2025-07-23 17:24:17'),
(49, 29, '\"[\\\"2025-07-01\\\"]\"', 50, 28, 400.00, '2025-07-24 08:16:48', '2025-07-24 08:16:48'),
(50, 32, '\"[\\\"2025-07-01\\\"]\"', 50, 28, 400.00, '2025-07-25 16:53:56', '2025-07-25 16:53:56'),
(51, 27, '\"[\\\"2025-05-01\\\"]\"', 50, 50, 400.00, '2025-07-26 21:06:13', '2025-07-26 21:06:13'),
(53, 27, '\"[\\\"2025-06-01\\\"]\"', 50, 28, 400.00, '2025-07-27 09:37:46', '2025-07-27 09:37:46'),
(56, 27, '\"[\\\"2025-07-01\\\"]\"', 50, 50, 400.00, '2025-07-27 14:24:12', '2025-07-27 14:24:12'),
(57, 27, '\"[\\\"2025-08-01\\\"]\"', 50, 28, 400.00, '2025-07-27 14:38:51', '2025-07-27 14:38:51'),
(59, 29, '\"[\\\"2025-06-01\\\",\\\"2025-07-01\\\"]\"', 50, 50, 800.00, '2025-07-30 12:18:10', '2025-07-30 12:18:10'),
(60, 29, '\"[\\\"2025-08-01\\\"]\"', 50, 50, 400.00, '2025-07-30 12:19:19', '2025-07-30 12:19:19'),
(61, 27, '\"[\\\"2025-09-01\\\"]\"', 50, 28, 400.00, '2025-07-31 07:37:36', '2025-07-31 07:37:36'),
(62, 29, '\"[\\\"2025-09-01\\\"]\"', 50, 28, 400.00, '2025-07-31 07:38:09', '2025-07-31 07:38:09'),
(63, 27, '\"[\\\"2025-10-01\\\"]\"', 50, 28, 400.00, '2025-07-31 07:43:01', '2025-07-31 07:43:01'),
(64, 27, '\"[\\\"2025-07-01\\\"]\"', 50, 28, 400.00, '2025-07-31 07:49:39', '2025-07-31 07:49:39'),
(65, 35, '\"[\\\"2025-08-01\\\"]\"', NULL, 28, 100.00, '2025-07-31 08:34:44', '2025-07-31 08:34:44'),
(66, 33, '\"[\\\"2025-06-01\\\",\\\"2025-07-01\\\"]\"', 56, 28, 400.00, '2025-07-31 09:17:12', '2025-07-31 09:17:12'),
(67, 27, '\"[\\\"2025-08-01\\\",\\\"2025-09-01\\\"]\"', 50, 28, 800.00, '2025-07-31 10:02:51', '2025-07-31 10:02:51');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `nombre_immeubles` int(11) DEFAULT 0,
  `ville` varchar(255) DEFAULT NULL,
  `code_postal` varchar(20) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `cotisation` decimal(10,2) DEFAULT NULL,
  `caisse` decimal(10,2) DEFAULT NULL,
  `id_S` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `residences`
--

INSERT INTO `residences` (`id`, `created_at`, `updated_at`, `nom`, `nombre_immeubles`, `ville`, `code_postal`, `adresse`, `cotisation`, `caisse`, `id_S`) VALUES
(11, '2025-07-14 09:16:51', '2025-07-27 11:48:35', 'Doha', 2, 'Marrakech', '40000', '199 Afaq1 Marrakech', 400.00, 5000.00, 28),
(12, '2025-07-18 08:29:52', '2025-07-27 11:48:57', 'Charif', 2, 'Marrakech', '40000', '199 Afaq1 Marrakech , Maroc', 500.00, 5000.00, 28),
(13, '2025-07-23 13:27:13', '2025-07-23 13:27:13', 'Hamido', 15, 'Marrakech', '55000', '12 Marb Marrakech', 400.00, 4000.00, 51);

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
('7bT57wDMVQUKYAr0730Y2oFpeptpLY4FD0R39zo1', 54, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTG1SQU9pWW9LMmZucGI4bmJnZkp6MVBEbE80anZBeGJzWTdDMHljRCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hc3Npc3RhbnQvZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTQ7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0ODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL25vdGlmaWNhdGlvbnMvdW5yZWFkLWNvdW50Ijt9fQ==', 1753956501),
('hhKJ9P54zR6mQug5PHftbygjTnb2J6ymxITJsgDE', 54, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYzBpZ0JTN2NMWFV4ak1BaE5sQjhrd1RwTVlnQzZFVHNCWVMxRnVkTCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Fzc2lzdGFudC9kYXNoYm9hcmQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Fzc2lzdGFudC9jaGFyZ2VzL2Fqb3V0ZXIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1NDt9', 1753959521),
('IVS0YV0nflLFF3m95YniO1264Lav5g2ioe7VkGb7', 50, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoid2NLZEtIclV0OEFVNmhMUURINDRFUVVybzBIeEFjMmh5UXprMGltVSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Fzc2lzdGFudC9kYXNoYm9hcmQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1NzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Fzc2lzdGFudC9pbW1ldWJsZXMvYnktcmVzaWRlbmNlLzExIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTA7fQ==', 1758648722),
('lZdyrsyUohMvgLS5n8ULTOeTWN7AfvjWwTDU5twx', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZWlneGdHQ0xVQ1BDeHZxbjg0MjhzaVlNSGNRb0tpVDRKRjY2VnJxSyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FwcGFydGVtZW50cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1783499268),
('RjM2P6QWPP5fNuaOuqsAiOCTJ4v1TSwu6puAIoIz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTm9BVzVjYlY1ekxtNmMwaDVJSkEwQ1JPdlNPTmJyTHJKZjQxc1k5UiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1758646476),
('ya2mxTiB0CmU0B48Ww4JPC5NkhU1oTkjUQFLet4k', 28, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQzJWVmNrR0g2ZmdGZ3RMNTVZeEdvaTNBVk5CNDJRQWNvZmEwdjJPWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyODt9', 1753959925),
('yRdRLasqw7K7bJ87G4gRSu1R73rqLWIle2UKKvFn', 50, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicXdJOG5TcHh5Q0hSaWJQN0JNdWVlaHVBUWhSNGNlVWxiVDRZWHJLaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ub3RpZmljYXRpb25zL3VucmVhZC1jb3VudCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjUwO30=', 1753959995);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'professionnel',
  `nom_societé` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `Fax` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_pending` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `prenom`, `statut`, `nom_societé`, `adresse`, `logo`, `tel`, `Fax`, `ville`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `is_admin`, `is_active`, `is_pending`) VALUES
(8, 'Bourquouquou', 'Younes', 'professionnel', NULL, NULL, NULL, NULL, NULL, NULL, 'younes@gmail.com', NULL, '$2y$12$9Nwp.ipKxkn78Dm.WvWsI.lj5ypoTrbfkdPoMJJr5m0UHWAyOfTWS', NULL, '2025-07-08 13:09:35', '2025-07-08 13:09:35', 1, 0, 0),
(26, 'Bourquouquou', 'Mouad', 'professionnel', NULL, NULL, NULL, NULL, NULL, NULL, 'mouad@gmail.com', NULL, '$2y$12$reesHytZgXHceVjM0r7dK.zzn1aKy4GZpPP/YyjRRdIGHGe5OE.qq', NULL, '2025-07-11 10:43:47', '2025-07-11 10:43:47', 1, 0, 0),
(28, 'Charaf', 'Amine', 'benevolat', NULL, '199 Afaq1 Marrakech', 'uploads/logos/ec754bc1a8584723ff7a5e07e44fb600df6f160f.jpeg', NULL, NULL, 'Marrkech', 'm.bourquouquou1181@uca.ac.ma', '2025-07-14 09:15:27', '$2y$12$rqOw3n6.7gbvDQ/zIc9K1OrsmTrUoiLyMGDPzgOZXGMKID3OjS/xC', NULL, '2025-05-14 09:11:05', '2025-07-24 07:22:09', 0, 1, 0),
(50, 'Alaoui Soussi', '', 'assistant_syndic', NULL, '199 Afaq1 Marrakech', NULL, NULL, NULL, NULL, 'mouadbourquouquou@gmail.com', NULL, '$2y$12$0GczrfUOow0TIVtpB2klYeWIXyh/Cnn2e77j8ts.9tYg005JbGXWy', '8F0F4FY5xL9wwMuU8YxJi9IdKb4PNRktXHmNsVHCdXYng58i5QBrdvBIz07V', '2025-05-17 08:43:12', '2025-07-31 09:35:10', 0, 1, 0),
(54, 'benzaghar', 'Hakim', 'assistant_syndic', NULL, NULL, NULL, NULL, NULL, NULL, 'ncomp920@gmail.com', NULL, '$2y$12$exlHYbddN7ONuNvZVXA36uNg4zM2LIoWi2aPmBW4.Utqv.Gj5MqWu', '5vjpSmimoUgquazBOLb1QkxBoKj4bOoIqElLd8VJ6r0OxMlV9gPBeDb2dbff', '2025-07-31 09:07:41', '2025-07-31 09:08:11', 0, 1, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `appartements`
--
ALTER TABLE `appartements`
  ADD PRIMARY KEY (`id_A`),
  ADD UNIQUE KEY `unique_immeuble_numero` (`immeuble_id`,`numero`);

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
  ADD KEY `charges_immeuble_id_foreign` (`immeuble_id`),
  ADD KEY `charges_id_residence_foreign` (`id_residence`);

--
-- Index pour la table `employes`
--
ALTER TABLE `employes`
  ADD PRIMARY KEY (`id_E`),
  ADD UNIQUE KEY `employes_email_unique` (`email`),
  ADD KEY `fk_employes` (`id_S`);

--
-- Index pour la table `employe_immeuble`
--
ALTER TABLE `employe_immeuble`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employe_immeuble_employe_id_immeuble_id_unique` (`employe_id`,`immeuble_id`),
  ADD KEY `employe_immeuble_immeuble_id_foreign` (`immeuble_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `immeuble`
--
ALTER TABLE `immeuble`
  ADD PRIMARY KEY (`id`),
  ADD KEY `immeuble_residence_id_foreign` (`residence_id`),
  ADD KEY `fk_syndic` (`id_S`);

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
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paiement_id_a_foreign` (`id_A`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `appartements`
--
ALTER TABLE `appartements`
  MODIFY `id_A` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `charges`
--
ALTER TABLE `charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `employes`
--
ALTER TABLE `employes`
  MODIFY `id_E` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `employe_immeuble`
--
ALTER TABLE `employe_immeuble`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `immeuble`
--
ALTER TABLE `immeuble`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT pour la table `residences`
--
ALTER TABLE `residences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartements`
--
ALTER TABLE `appartements`
  ADD CONSTRAINT `appartements_immeuble_id_foreign` FOREIGN KEY (`immeuble_id`) REFERENCES `immeuble` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_appartements_immeuble` FOREIGN KEY (`immeuble_id`) REFERENCES `immeuble` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `charges`
--
ALTER TABLE `charges`
  ADD CONSTRAINT `charges_id_residence_foreign` FOREIGN KEY (`id_residence`) REFERENCES `residences` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `charges_immeuble_id_foreign` FOREIGN KEY (`immeuble_id`) REFERENCES `immeuble` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `employes`
--
ALTER TABLE `employes`
  ADD CONSTRAINT `fk_employes` FOREIGN KEY (`id_S`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `employe_immeuble`
--
ALTER TABLE `employe_immeuble`
  ADD CONSTRAINT `employe_immeuble_employe_id_foreign` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id_E`) ON DELETE CASCADE,
  ADD CONSTRAINT `employe_immeuble_immeuble_id_foreign` FOREIGN KEY (`immeuble_id`) REFERENCES `immeuble` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `immeuble`
--
ALTER TABLE `immeuble`
  ADD CONSTRAINT `fk_syndic` FOREIGN KEY (`id_S`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `immeuble_residence_id_foreign` FOREIGN KEY (`residence_id`) REFERENCES `residences` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `paiement_id_a_foreign` FOREIGN KEY (`id_A`) REFERENCES `appartements` (`id_A`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
