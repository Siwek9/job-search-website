-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 12 Cze 2023, 21:53
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `job_search_website`
--
DROP DATABASE IF EXISTS `job_search_website`;
CREATE DATABASE IF NOT EXISTS `job_search_website` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `job_search_website`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account_type` enum('employee','employer') NOT NULL DEFAULT 'employee',
  `id_user_data` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Wyzwalacze `accounts`
--
DROP TRIGGER IF EXISTS `log_patron_delete`;
DELIMITER $$
CREATE TRIGGER `log_patron_delete` AFTER DELETE ON `accounts` FOR EACH ROW BEGIN
DELETE FROM user_employees
    WHERE old.account_type LIKE "employee" AND user_employees.id = old.id_user_data;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `account_activation`
--

DROP TABLE IF EXISTS `account_activation`;
CREATE TABLE IF NOT EXISTS `account_activation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `activation_code` varchar(255) NOT NULL,
  `expiration_time` datetime NOT NULL,
  `mail_sended` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_employees`
--

DROP TABLE IF EXISTS `user_employees`;
CREATE TABLE IF NOT EXISTS `user_employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `photo_name` varchar(255) DEFAULT NULL,
  `about_me` text DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(12) DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `education` text DEFAULT NULL,
  `abilities` text DEFAULT NULL,
  `language_abilities` text DEFAULT NULL,
  `interests` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_employers`
--

DROP TABLE IF EXISTS `user_employers`;
CREATE TABLE IF NOT EXISTS `user_employers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DELIMITER $$
--
-- Zdarzenia
--
DROP EVENT IF EXISTS `cleaning`$$
CREATE DEFINER=`root`@`localhost` EVENT `cleaning` ON SCHEDULE EVERY 2 MINUTE STARTS '2023-06-12 21:39:46' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DECLARE MaxTime TIMESTAMP;
    SET MaxTime = CURRENT_TIMESTAMP;
    DELETE FROM accounts
    WHERE accounts.id IN (SELECT account_activation.user_id FROM account_activation WHERE account_activation.expiration_time < MaxTime);
    DELETE FROM account_activation
    WHERE account_activation.expiration_time < MaxTime;
  END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
