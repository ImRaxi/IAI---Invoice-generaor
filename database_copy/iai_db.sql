-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 02 Lut 2022, 03:02
-- Wersja serwera: 10.4.17-MariaDB
-- Wersja PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `iai_db`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `buyers`
--

CREATE TABLE `buyers` (
  `id` int(11) NOT NULL,
  `buyer_name` varchar(255) NOT NULL,
  `buyer_surname` varchar(255) NOT NULL,
  `buyer_company` varchar(255) NOT NULL,
  `buyer_nip` double NOT NULL,
  `buyer_address` varchar(255) NOT NULL,
  `buyer_code` varchar(255) NOT NULL,
  `buyer_city` varchar(255) NOT NULL,
  `fv_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `fv`
--

CREATE TABLE `fv` (
  `id` int(11) NOT NULL,
  `place` varchar(255) NOT NULL,
  `create_date` date NOT NULL,
  `sale_date` date NOT NULL,
  `fv_name` varchar(255) NOT NULL,
  `unit` int(11) NOT NULL COMMENT '1 - sztuki',
  `amount` int(11) NOT NULL,
  `netto` float NOT NULL,
  `vat_percent` float NOT NULL,
  `vat` float NOT NULL,
  `brutto` float NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 - przelew, 2 - gotówka',
  `deadline` int(11) NOT NULL COMMENT '1- 7 dni, 2- 14dni, 3- 30dni, 4- 60dni',
  `account_number` varchar(255) NOT NULL,
  `fv_number` varchar(255) NOT NULL,
  `gen_data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sellers`
--

CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `nip` double NOT NULL,
  `address` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `fv_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `buyers`
--
ALTER TABLE `buyers`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `fv`
--
ALTER TABLE `fv`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `buyers`
--
ALTER TABLE `buyers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `fv`
--
ALTER TABLE `fv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT dla tabeli `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
