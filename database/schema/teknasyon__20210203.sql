# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.29)
# Database: teknasyon
# Generation Time: 2021-02-03 08:43:46 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table devices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `devices`;

CREATE TABLE `devices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `u_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os` enum('android','ios') COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `devices_u_id_app_id_os_lang_index` (`u_id`,`app_id`,`os`,`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2021_02_01_044332_create_devices_table',1),
	(2,'2021_02_02_051037_create_subscription_table',1),
	(3,'2021_02_02_214616_create_operating_systems_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table operating_systems
# ------------------------------------------------------------

DROP TABLE IF EXISTS `operating_systems`;

CREATE TABLE `operating_systems` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prod_endpoint` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prod_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prod_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_endpoint` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `operating_systems_name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `operating_systems` WRITE;
/*!40000 ALTER TABLE `operating_systems` DISABLE KEYS */;

INSERT INTO `operating_systems` (`id`, `name`, `prod_endpoint`, `prod_username`, `prod_password`, `test_endpoint`, `test_username`, `test_password`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'android','http://android.com/api/v1','admin','123','http://localhost:8080/platform/android','admin','123','2021-02-03 10:17:19','2021-02-03 10:17:19',NULL),
	(2,'ios','http://apple.com/api/v1','admin','123','http://localhost:8080/platform/ios','admin','123','2021-02-03 10:17:20','2021-02-03 10:17:20',NULL);

/*!40000 ALTER TABLE `operating_systems` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table subscriptions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subscriptions`;

CREATE TABLE `subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `devices_id` bigint(20) NOT NULL,
  `expiry` datetime NOT NULL,
  `status` enum('active','expired','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_devices_id_index` (`devices_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
