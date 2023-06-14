-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 14 Cze 2023, 12:09
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 8.1.6

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
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `email`, `password`, `account_type`, `id_user_data`) VALUES
(55, 'Siwek9', 'slawomir.s@poczta.onet.pl', '8ef745b22baa29dda8d93f801787397d842fb9afcc6ad9ea2f84258631279e70', 'employee', 19),
(56, 'Siwek10', 'siwek10@siwek10.com', '8ef745b22baa29dda8d93f801787397d842fb9afcc6ad9ea2f84258631279e70', 'employer', 1);

--
-- Wyzwalacze `accounts`
--
DROP TRIGGER IF EXISTS `log_patron_delete`;
DELIMITER $$
CREATE TRIGGER `log_patron_delete` AFTER DELETE ON `accounts` FOR EACH ROW BEGIN
DELETE FROM user_employees
    WHERE old.account_type LIKE "employee" AND user_employees.id = old.id_user_data;
DELETE FROM user_employers
    WHERE old.account_type LIKE "employer" AND user_employers.id = old.id_user_data;
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
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `job-offers`
--

DROP TABLE IF EXISTS `job-offers`;
CREATE TABLE IF NOT EXISTS `job-offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_position` varchar(100) NOT NULL,
  `job_description` text NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `job_application`
--

DROP TABLE IF EXISTS `job_application`;
CREATE TABLE IF NOT EXISTS `job_application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_offer_id` int(11) NOT NULL,
  `job_candidate_id` int(11) NOT NULL,
  `status` enum('sended','approved') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `nationality` varchar(20) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `education` text DEFAULT NULL,
  `abilities` text DEFAULT NULL,
  `language_abilities` text DEFAULT NULL,
  `interests` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user_employees`
--

INSERT INTO `user_employees` (`id`, `first_name`, `last_name`, `photo_name`, `about_me`, `nationality`, `birth_date`, `contact_email`, `phone_number`, `experience`, `education`, `abilities`, `language_abilities`, `interests`) VALUES
(19, 'Lolek', 'Lolowski', '55.png', 'No jest wszystko w porządku,jest dobrze,dobrze robią,dobrze wszystko jest w porządku.Jest git pozdrawiam całą Legnice,dobrych chłopak&oacute;w i niech sie to trzyma.Dobry przekaz leci.', 'pl', '1988-06-23', 'slawomir.s@poczta.onet.pl', '+48420421422', 'praca w elektryku\\2008-04-13\\2012-12-20;programista w NASA\\2012-12-21\\2020-06-03;nauka c++ w elektryku\\2020-06-04\\now', 'elektryk krosno (kierunek ping-pong)\\2004-09-01\\2007-06-23', 'granie na nerwach;ping-pong;assembler', 'Angielski\\B2;Niemiecki\\C2', 'chodzenie do elektryka;zaba w elektryku;elektryk krosno');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_employers`
--

DROP TABLE IF EXISTS `user_employers`;
CREATE TABLE IF NOT EXISTS `user_employers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact_mail` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_description` text DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user_employers`
--

INSERT INTO `user_employers` (`id`, `first_name`, `last_name`, `contact_mail`, `phone_number`, `company_name`, `company_description`, `company_logo`, `company_address`) VALUES
(1, '', '', '', '', '', NULL, NULL, NULL);

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
