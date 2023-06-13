-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 13 Cze 2023, 18:53
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
(55, 'Siwek9', 'slawomir.s@poczta.onet.pl', '8ef745b22baa29dda8d93f801787397d842fb9afcc6ad9ea2f84258631279e70', 'employee', 19);

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
CREATE TABLE `account_activation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activation_code` varchar(255) NOT NULL,
  `expiration_time` datetime NOT NULL,
  `mail_sended` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(19, 'Lolek', 'Lolowski', '55.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Error omnis, quam distinctio, eligendi repellat nam dicta repellendus ut porro optio maiores sapiente nisi quisquam illo, odio amet! Magni, laboriosam culpa.', 'ua', '1992-06-26', 'slawomir.s@poczta.onet.pl', '+48 420 421 422', 'praca w elektryku\\2008-04-13\\2012-12-20;programista w NASA\\2012-12-21\\2020-06-03;nauka c++ w elektryku\\2020-06-04\\now', 'elektryk krosno (kierunek ping-pong)\\2004-09-01\\2007-06-23', 'granie na nerwach;ping-pong;assembler', 'Angielski\\B2;Niemiecki\\C2', 'chodzenie do elektryka;zaba w elektryku;elektryk krosno');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_employers`
--

DROP TABLE IF EXISTS `user_employers`;
CREATE TABLE `user_employers` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT dla tabeli `account_activation`
--
ALTER TABLE `account_activation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT dla tabeli `user_employees`
--
ALTER TABLE `user_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT dla tabeli `user_employers`
--
ALTER TABLE `user_employers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
