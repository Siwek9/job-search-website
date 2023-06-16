-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 16 Cze 2023, 04:58
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
(57, 'Siwek11', 'siwek11@siwek11.com', '8ef745b22baa29dda8d93f801787397d842fb9afcc6ad9ea2f84258631279e70', 'employer', 3),
(58, 'bolek123', 'bolek@bolek.com', 'c1a7d345674f8f748a1d2791f6a4757ba46f8443e047ca08bb58ea3c1ce3972d', 'employee', 20),
(59, 'Dziobman', 'dziob@dziob.pl', '72553b2b1a0d567bce71dec8a418afd147e217cec2ebac7d627e02367e9b4abd', 'employee', 21),
(60, 'Juzek456', 'Juzek@psi.pl', '998c56848e818d4f4a1822dc501c25a838d8511c09edf77d70c58c60345e6e5e', 'employer', 4),
(61, 'ASDF123', 'asdf1234@1234.com', 'd6a17bdecdc5407753ef51e4dfcec7b62dac515e5a58e864a0510cafe2ea0972', 'employee', 22),
(62, 'Kot1234', 'kot@kot.pl', 'd6a17bdecdc5407753ef51e4dfcec7b62dac515e5a58e864a0510cafe2ea0972', 'employee', 23);

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

--
-- Zrzut danych tabeli `job_application`
--

INSERT INTO `job_application` (`id`, `job_offer_id`, `job_candidate_id`, `status`) VALUES
(1, 1, 55, 'sended');

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
(3, 'Programista PHP', 'Elektryk Krosno', 5, '+48222222222', 'programista php', 'programista php', 'programista php', 57),
(4, 'Opchnięcie tira', 'Krosno', 4, '+48123456789', 'mieć pogadane;szybkość', 'brak', 'Prosta szybka praca. Dobrze płatna.', 62),
(5, 'Pisanie głupot', 'Jasło', 4, '+48123456789', 'Pisanie;Czytanie', 'Przedszkolna', 'Pisanie głupot. ', 62),
(6, 'Tynkarz murarz', 'Gdzieś', 6, '+48672901267', 'Tynkowanie;Malowanie;Akrobatyka', 'Wyższa', 'TYnkarz malarz akrobata. ', 62);

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
(19, 'Lolek', 'Lolowski', '', 'No jest wszystko w porządku,jest dobrze,dobrze robią,dobrze wszystko jest w porządku.Jest git pozdrawiam całą Legnice,dobrych chłopak&oacute;w i niech sie to trzyma.Dobry przekaz leci.', 'pl', '1988-06-23', 'slawomir.s@poczta.onet.pl', '+48420421422', 'nie wiem\\2023-06-09\\', 'elektryk krosno (kierunek ping-pong)\\2004-09-01\\2007-06-23;gdzies napewno\\2007-09-01\\now', 'ping-pong;assembler;akwarium umie', 'Angielski\\B2;Niemiecki\\C2;Hiszpański\\C1', 'zaba w elektryku;elektryk krosno'),
(20, 'Zbyszek', 'Nowak', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'pl', '2023-06-08', 'asdf@asdf.com', '+48123421422', 'Przedszkole\\2023-06-09\\', 'Mechanik Jasło\\2004-09-10\\2004-06-19', 'brak;', NULL, NULL),
(21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT dla tabeli `account_activation`
--
ALTER TABLE `account_activation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT dla tabeli `job_application`
--
ALTER TABLE `job_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `job_offers`
--
ALTER TABLE `job_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `user_employees`
--
ALTER TABLE `user_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT dla tabeli `user_employers`
--
ALTER TABLE `user_employers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
