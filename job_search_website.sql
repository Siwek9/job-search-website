-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 15 Cze 2023, 07:55
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
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account_type` enum('employee','employer') NOT NULL DEFAULT 'employee',
  `id_user_data` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `email`, `password`, `account_type`, `id_user_data`) VALUES
(55, 'Siwek9', 'slawomir.s@poczta.onet.pl', '8ef745b22baa29dda8d93f801787397d842fb9afcc6ad9ea2f84258631279e70', 'employee', 19),
(56, 'Siwek10', 'siwek10@siwek10.com', '8ef745b22baa29dda8d93f801787397d842fb9afcc6ad9ea2f84258631279e70', 'employer', 2),
(57, 'Siwek11', 'siwek11@siwek11.com', '8ef745b22baa29dda8d93f801787397d842fb9afcc6ad9ea2f84258631279e70', 'employer', 3);

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
CREATE TABLE `account_activation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activation_code` varchar(255) NOT NULL,
  `expiration_time` datetime NOT NULL,
  `mail_sended` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `job_application`
--

DROP TABLE IF EXISTS `job_application`;
CREATE TABLE `job_application` (
  `id` int(11) NOT NULL,
  `job_offer_id` int(11) NOT NULL,
  `job_candidate_id` int(11) NOT NULL,
  `status` enum('sended','approved') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `job_offers`
--

DROP TABLE IF EXISTS `job_offers`;
CREATE TABLE `job_offers` (
  `id` int(11) NOT NULL,
  `job_position` varchar(100) NOT NULL,
  `job_place` varchar(50) NOT NULL,
  `job_years` int(11) NOT NULL,
  `job_contact_phone` varchar(15) NOT NULL,
  `job_abilities` text DEFAULT NULL,
  `job_education` text DEFAULT NULL,
  `job_description` text DEFAULT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `job_offers`
--

INSERT INTO `job_offers` (`id`, `job_position`, `job_place`, `job_years`, `job_contact_phone`, `job_abilities`, `job_education`, `job_description`, `company_id`) VALUES
(1, 'Operator Koparki', 'Jasło', 2, '+48123456789', 'granie w ping ponga;assembler', 'granie na nerwach', 'Przyjemna prosta praca.', 56),
(2, 'Groźny woźny', 'Elektryk Krosno', 20, '+48242424242', 'bicie miotłą', NULL, NULL, 56),
(3, 'Programista PHP', 'Elektryk Krosno', 5, '+48222222222', 'programista php', 'programista php', 'programista php', 57);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_employees`
--

DROP TABLE IF EXISTS `user_employees`;
CREATE TABLE `user_employees` (
  `id` int(11) NOT NULL,
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
  `interests` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `user_employees`
--

INSERT INTO `user_employees` (`id`, `first_name`, `last_name`, `photo_name`, `about_me`, `nationality`, `birth_date`, `contact_email`, `phone_number`, `experience`, `education`, `abilities`, `language_abilities`, `interests`) VALUES
(19, 'Lolek', 'Lolowski', '55.png', 'No jest wszystko w porządku,jest dobrze,dobrze robią,dobrze wszystko jest w porządku.Jest git pozdrawiam całą Legnice,dobrych chłopak&oacute;w i niech sie to trzyma.Dobry przekaz leci.', 'pl', '1988-06-23', 'slawomir.s@poczta.onet.pl', '+48420421422', 'nie wiem\\2023-06-09\\', 'elektryk krosno (kierunek ping-pong)\\2004-09-01\\2007-06-23;gdzies napewno\\2007-09-01\\now', 'ping-pong;assembler;akwarium umie', 'Angielski\\B2;Niemiecki\\C2;Hiszpański\\C1', 'zaba w elektryku;elektryk krosno');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_employers`
--

DROP TABLE IF EXISTS `user_employers`;
CREATE TABLE `user_employers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `contact_mail` varchar(255) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `company_description` text DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `user_employers`
--

INSERT INTO `user_employers` (`id`, `first_name`, `last_name`, `contact_mail`, `phone_number`, `company_name`, `company_description`, `company_logo`, `company_address`) VALUES
(2, 'Trollarz', 'Wielki', 'siwek10.sluzbowy@siwek10.com', '+48101010101', 'Fabryka Mebli', 'Firma bardzo dobra prosimy przyjmiemy każdego kto ma dwie rece i nogi (nie musi)', '56.png', 'Polska, Krosno, ul. Jana Pawła II 38-400'),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `account_activation`
--
ALTER TABLE `account_activation`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `job_application`
--
ALTER TABLE `job_application`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `job_offers`
--
ALTER TABLE `job_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `user_employees`
--
ALTER TABLE `user_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `user_employers`
--
ALTER TABLE `user_employers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT dla tabeli `account_activation`
--
ALTER TABLE `account_activation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT dla tabeli `job_application`
--
ALTER TABLE `job_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `job_offers`
--
ALTER TABLE `job_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `user_employees`
--
ALTER TABLE `user_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT dla tabeli `user_employers`
--
ALTER TABLE `user_employers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
