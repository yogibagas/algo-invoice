# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.32)
# Database: algoapp
# Generation Time: 2021-04-07 03:46:18 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table banks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `banks`;

CREATE TABLE `banks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortname` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_swift` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_holder_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `banks` WRITE;
/*!40000 ALTER TABLE `banks` DISABLE KEYS */;

INSERT INTO `banks` (`id`, `bank_name`, `shortname`, `bank_number`, `bank_swift`, `bank_code`, `bank_holder_name`, `created_at`, `updated_at`, `status`)
VALUES
	(1,'bank central asia','bca','76704212064','CENAJAID','014','yogi bagas dikara','2021-03-29 06:33:02','2021-03-29 06:39:22','deactive'),
	(2,'PERMATA','PERMATA','777777777','02302','041','JOHN DOE','2021-03-29 06:56:44','2021-03-29 06:56:44','active');

/*!40000 ALTER TABLE `banks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table clients
# ------------------------------------------------------------

DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;

INSERT INTO `clients` (`id`, `code`, `name`, `pic_name`, `address`, `phone`, `created_at`, `updated_at`, `email`)
VALUES
	(1,'ASONE','Asone Digital','Damon Knott','Australia','0000000000','2021-03-29 06:45:46','2021-04-02 01:39:26','damon@asone.com.au'),
	(2,'SEPT','September Studio','Sarah Meyran','80232388','081257243900','2021-03-30 03:35:20','2021-04-02 01:39:37','hello@studio-september.com');

/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table invoice_details
# ------------------------------------------------------------

DROP TABLE IF EXISTS `invoice_details`;

CREATE TABLE `invoice_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) unsigned NOT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` double NOT NULL,
  `price` int(11) NOT NULL,
  `total` double NOT NULL,
  `adjustment` double NOT NULL,
  `item_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_details_invoice_id_foreign` (`invoice_id`),
  CONSTRAINT `invoice_details_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `invoice_details` WRITE;
/*!40000 ALTER TABLE `invoice_details` DISABLE KEYS */;

INSERT INTO `invoice_details` (`id`, `invoice_id`, `item_name`, `qty_type`, `qty`, `price`, `total`, `adjustment`, `item_note`, `created_at`, `updated_at`)
VALUES
	(3,7,'Web Development','FIXED',5000000,1,5000000,0,'Canine','2021-03-31 06:49:20','2021-03-31 06:49:20'),
	(4,7,'Web Development','HOURLY',150000,5,750000,0,'GMTAX','2021-03-31 06:49:20','2021-03-31 06:49:20'),
	(5,7,'Web Development','HOURLY',10,150000,1500000,0,'DWA Architect','2021-03-31 06:49:20','2021-03-31 06:49:20'),
	(6,8,'tes','FIXED',1,150000,112500,37500,NULL,'2021-04-01 04:11:53','2021-04-01 04:11:53'),
	(7,8,'tes','HOURLY',50,150000,5625000,1875000,NULL,'2021-04-01 04:11:53','2021-04-01 04:11:53'),
	(23,5,'SEO','HOURLY',50,150000,5625000,1875000,'CCC','2021-04-07 03:14:45','2021-04-07 03:14:45'),
	(24,5,'ts','FIXED',2,150000,285000,15000,'2','2021-04-07 03:14:45','2021-04-07 03:14:45');

/*!40000 ALTER TABLE `invoice_details` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table invoices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `invoices`;

CREATE TABLE `invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no_inv` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `security_code` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `total` double NOT NULL,
  `due_date` datetime NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_no_inv_unique` (`no_inv`),
  KEY `invoices_client_id_foreign` (`client_id`),
  CONSTRAINT `invoices_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;

INSERT INTO `invoices` (`id`, `no_inv`, `security_code`, `client_id`, `total`, `due_date`, `status`, `created_at`, `updated_at`)
VALUES
	(5,'ASONE-0001','225636',1,5910000,'2021-04-04 00:00:00','ONHOLD','2021-03-31 06:36:27','2021-04-07 03:14:45'),
	(7,'ASONE-0002','014139',1,7250000,'2021-04-08 00:00:00','ONHOLD','2021-03-31 06:49:20','2021-03-31 06:49:20'),
	(8,'SEPT-0001','154244',2,5737500,'2021-04-08 00:00:00','ONHOLD','2021-04-01 04:11:53','2021-04-01 04:11:53');

/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;


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
	(38,'2014_10_12_000000_create_users_table',1),
	(39,'2014_10_12_100000_create_password_resets_table',1),
	(40,'2019_08_19_000000_create_failed_jobs_table',1),
	(41,'2021_03_14_043923_create_clients_table',1),
	(42,'2021_03_14_044402_create_organization_configs_table',1),
	(43,'2021_03_17_055126_add_code_clients',1),
	(44,'2021_03_18_023946_add_logo_organization_configs',1),
	(45,'2021_03_18_090414_create_banks_table',1),
	(46,'2021_03_29_055056_add_status_banks',2),
	(47,'2021_03_29_060119_add_shortname_bank',3),
	(48,'2021_03_29_070610_create_invoices_table',4),
	(49,'2021_03_30_024019_create_invoice_details_table',4),
	(50,'2021_03_30_024919_create_transactions_table',4),
	(51,'2021_03_30_030127_add_hourly_rate_column',4),
	(52,'2021_03_30_032342_add_no_inv',5),
	(53,'2021_03_30_040626_add_item_note_and_qty',6),
	(54,'2021_03_30_070000_add_adjustment_column_to_invoice_details',7),
	(55,'2021_04_02_013431_add_email_clients',8),
	(57,'2021_04_02_022417_create_payments_table',9);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table organization_configs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `organization_configs`;

CREATE TABLE `organization_configs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `thankyou_message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `organization_configs` WRITE;
/*!40000 ALTER TABLE `organization_configs` DISABLE KEYS */;

INSERT INTO `organization_configs` (`id`, `thankyou_message`, `company_name`, `logo`, `phone_number`, `tax_id`, `created_at`, `updated_at`)
VALUES
	(1,'Thanks for trusting us','Example','logo.png','111-111-111','00.000.000.000.000',NULL,NULL);

/*!40000 ALTER TABLE `organization_configs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table payments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `references_code` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_invoice` bigint(20) unsigned NOT NULL,
  `method` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` double NOT NULL,
  `fee_merchant` double NOT NULL,
  `fee_customer` double NOT NULL,
  `total_fee` double NOT NULL,
  `amount_received` double NOT NULL,
  `status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_id_invoice_foreign` (`id_invoice`),
  CONSTRAINT `payments_id_invoice_foreign` FOREIGN KEY (`id_invoice`) REFERENCES `invoices` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table transactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `references_code` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_invoice` bigint(20) unsigned NOT NULL,
  `method` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` double NOT NULL,
  `fee_merchant` double NOT NULL,
  `fee_customer` double NOT NULL,
  `total_fee` double NOT NULL,
  `amount_received` double NOT NULL,
  `status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_id_invoice_foreign` (`id_invoice`),
  CONSTRAINT `transactions_id_invoice_foreign` FOREIGN KEY (`id_invoice`) REFERENCES `invoices` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'Admin Admin','admin@algoseabiz.com','2021-03-18 09:19:35','$2y$10$P1qlmlfuqfpVal7O08ZdlOChb/A2MWmtNWzuJfN3ePMQ6.InNkRKu',NULL,'2021-03-18 09:19:35','2021-03-18 09:19:35');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
