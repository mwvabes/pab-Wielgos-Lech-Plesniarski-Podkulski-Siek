-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 05 Lut 2021, 12:20
-- Wersja serwera: 10.4.8-MariaDB
-- Wersja PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `bank_a`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `account`
--

CREATE TABLE `account` (
  `id_account` int(11) NOT NULL,
  `balance` decimal(19,2) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `number` varchar(26) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `account`
--

INSERT INTO `account` (`id_account`, `balance`, `id_user`, `number`) VALUES
(1, '1000000.00', 1, '84102029640000000000000001'),
(2, '997905.60', 2, '57102029640000000000000002'),
(16, '13710.90', 16, '67102029640000000000000016'),
(17, '9940.00', 17, '12102014170000000000000017'),
(18, '2101.00', 18, '13102029640000000000000018');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `login` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `moderator` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `login`
--

INSERT INTO `login` (`id_login`, `login`, `password`, `moderator`) VALUES
(3, 'admin', '$2a$10$DAjJElSd8QZdn2JgKwk8ZusW7ZhRU4QYArNf2wK0TbFRQWFcoLoX6', 1),
(20, 'Login', '1qa', 0),
(21, 'nup8', '1qwdfv', 0),
(22, 'test1', '$2a$10$SIdRyLrgTS7CIcCkV/RyqOP0ypvWxZS6.2e7etRX9ZqogBQ/Z9Hru', 0),
(23, 'test2', '$2a$10$5HJuuCEjkKe6rF5Vgh317.lwlnXUYAezte5/toa2Q3zwhsZu.E7J2', 0),
(24, 'test3', '$2a$10$qk0zUx1OYlZrWzik/Xo01e6SJ7jkCdsl2obNsSc5jdO9AmcUBJbsi', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `operation`
--

CREATE TABLE `operation` (
  `id_operation` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` varchar(30) NOT NULL,
  `sender_number` varchar(26) NOT NULL,
  `sender_name` text NOT NULL,
  `sender_address` text NOT NULL,
  `recipent_number` varchar(26) NOT NULL,
  `recipent_name` text NOT NULL,
  `recipent_address` text NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `operation`
--

INSERT INTO `operation` (`id_operation`, `type`, `date`, `amount`, `status`, `sender_number`, `sender_name`, `sender_address`, `recipent_number`, `recipent_name`, `recipent_address`, `title`) VALUES
(1, 'obciążenie', '2021-01-10', '1.00', 'Zrealizowany', '', '', '', '', '', '', ''),
(2, 'obciążenie', '2021-01-10', '2.00', 'Zrealizowany', '', '', '', '', '', '', ''),
(3, 'obciążenie', '2021-01-10', '3.00', 'Zrealizowany', '', '', '', '', '', '', ''),
(4, 'obciążenie', '2021-01-10', '1.50', 'Zrealizowany', '', '', '', '', '', '', ''),
(5, 'obciążenie', '2021-01-10', '1.50', 'Zrealizowany', '', '', '', '', '', '', ''),
(6, 'obciążenie', '2021-01-11', '2.00', 'Zrealizowany', '67102029640000000000000016', '', '', '12102014170000000000000017', '', '', 'asfd'),
(7, 'uznaniee', '2021-01-26', '240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(8, 'uznaniee', '2021-01-26', '240.00', 'Zrealizowany', '12102014170000000000000017', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(9, 'uznaniee', '2021-01-26', '1240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '12102014170000000000000017', '', '', 'Tytułem 12345667'),
(10, 'uznaniee', '2021-01-26', '240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(11, 'uznaniee', '2021-01-26', '240.00', 'Zrealizowany', '12102014170000000000000017', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(12, 'uznaniee', '2021-01-26', '1240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '12102014170000000000000017', '', '', 'Tytułem 12345667'),
(13, 'uznanie', '2021-01-26', '240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(14, 'uznanie', '2021-01-26', '240.00', 'Zrealizowany', '12102014170000000000000017', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(15, 'uznanie', '2021-01-26', '1240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '12102014170000000000000017', '', '', 'Tytułem 12345667'),
(16, 'uznanie', '2021-01-26', '240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(17, 'uznanie', '2021-01-26', '240.00', 'Zrealizowany', '12102014170000000000000017', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(18, 'uznanie', '2021-01-26', '1240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '12102014170000000000000017', '', '', 'Tytułem 12345667'),
(19, 'uznanie', '2021-01-26', '240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(20, 'uznanie', '2021-01-26', '240.00', 'Zrealizowany', '12102014170000000000000017', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(21, 'uznanie', '2021-01-26', '1240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '12102014170000000000000017', '', '', 'Tytułem 12345667'),
(22, 'uznanie', '2021-01-26', '240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(23, 'uznanie', '2021-01-26', '240.00', 'Zrealizowany', '12102014170000000000000017', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(24, 'uznanie', '2021-01-26', '1240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '12102014170000000000000017', '', '', 'Tytułem 12345667'),
(25, 'uznanie', '2021-01-28', '1500.00', 'Zrealizowany', '27105044759393063594017658', '', '', '13102029640000000000000018', '', '', 'Tytuł przykładowy'),
(26, 'uznanie', '2021-01-28', '150.00', 'Zrealizowany', '27105044759393063594017658', '', '', '13102029640000000000000018', '', '', 'Tytuł przykładowy'),
(27, 'uznanie', '2021-01-28', '150.00', 'Zrealizowany', '27105044759393063594017658', '', '', '13102029640000000000000018', '', '', ''),
(28, 'obciążenie', '2021-01-29', '5.00', 'Zrealizowany', '67102029640000000000000016', '', '', '12102014170000000000000017', '', '', 'TytuÅowy'),
(29, 'obciążenie', '2021-01-29', '10.00', 'Zlecony', '67102029640000000000000016', '', '', '27105044759393063594017658', '', '', 'Przelew'),
(30, 'obciążenie', '2021-01-29', '123.00', 'Zrealizowany', '67102029640000000000000016', '', '', '67102029640000000000000016', '', '', 'ÄÅÄÅ¼Åº'),
(31, 'obciążenie', '2021-01-29', '4.00', 'Zrealizowany', '67102029640000000000000016', '', '', '67102029640000000000000016', '', '', 'ąśćźż'),
(32, 'obciążenie', '2021-01-29', '1.00', 'Zrealizowany', '67102029640000000000000016', '', '', '67102029640000000000000016', '', '', 'ÄÅÅ¼ÅºÄ'),
(33, 'obciążenie', '2021-01-29', '1.00', 'Zrealizowany', '67102029640000000000000016', '', '', '67102029640000000000000016', '', '', 'ÄÅÅ¼ÅºÄ'),
(34, 'obciążenie', '2021-01-29', '1.20', 'Zrealizowany', '67102029640000000000000016', '', '', '67102029640000000000000016', '', '', 'ÄÅÅ¼ÅºÄ'),
(35, 'obciążenie', '2021-01-29', '1.00', 'Zrealizowany', '67102029640000000000000016', '', '', '13102029640000000000000018', '', '', 'ąśżźć'),
(36, 'obciążenie', '2021-01-30', '1.10', 'Zlecony', '67102029640000000000000016', '', '', '27105044759393063594017658', '', '', 'Zewnętrzny standardowy'),
(37, 'obciążenie', '2021-01-30', '1.20', 'Zrealizowany', '67102029640000000000000016', '', '', '27105044759393063594017658', '', '', 'Zewnętrzny ekspresowy'),
(38, 'obciążenie', '2021-01-30', '1.30', 'Zlecony', '67102029640000000000000016', '', '', '27105044759393063594017658', '', '', 'z s'),
(39, 'obciążenie', '2021-01-30', '1.40', 'Zrealizowany', '67102029640000000000000016', '', '', '27105044759393063594017658', '', '', 'z e'),
(40, 'obciążenie', '2021-01-30', '30.00', 'Zlecony', '67102029640000000000000016', '', '', '27105044759393063594017658', '', '', 'b'),
(41, 'obciążenie', '2021-02-01', '12.00', 'Zlecony', '67102029640000000000000016', '', '', '27105044759393063594017658', '', '', 'Test'),
(42, 'obciążenie', '2021-02-01', '12.00', 'Zlecony', '67102029640000000000000016', '', '', '27105044759393063594017658', '', '', 'Test'),
(43, 'obciążenie', '2021-02-01', '2.10', 'Zlecony', '67102029640000000000000016', '', '', '27105044759393063594017658', '', '', 'Interfejs z tokenem'),
(44, 'uznanie', '2021-02-01', '240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(45, 'uznanie', '2021-02-01', '240.00', 'Zrealizowany', '12102014170000000000000017', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(46, 'uznanie', '2021-02-01', '1240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '12102014170000000000000017', '', '', 'Tytułem 12345667'),
(47, 'uznanie', '2021-02-01', '240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(48, 'uznanie', '2021-02-01', '240.00', 'Zrealizowany', '12102014170000000000000017', '', '', '67102029640000000000000016', '', '', 'Tytułem 12345667'),
(49, 'uznanie', '2021-02-01', '1240.00', 'Zrealizowany', '35105014164430809416938388', '', '', '12102014170000000000000017', '', '', 'Tytułem 12345667'),
(50, 'obciążenie', '2021-02-02', '5.00', 'Zrealizowany', '67102029640000000000000016', '', '', '27105044759393063594017658', '', '', 'Tytuł'),
(51, 'uznanie', '2021-02-02', '150.00', 'Zrealizowany', '27105044759393063594017658', 'Nazwa nadawcy', 'Adres nadawcy', '13102029640000000000000018', 'Nazwa odbiorcy', 'Adres odbiorcy', ''),
(52, 'obciążenie', '2021-02-02', '5.00', 'Zrealizowany', '67102029640000000000000016', 'Janusz Siek', '23ertgh', '27105044759393063594017658', 'a', 'Rzeszów', 'b'),
(53, 'obciążenie', '2021-02-02', '5.00', 'Zrealizowany', '67102029640000000000000016', 'Janusz Siek', '23ertgh', '12102014170000000000000017', 'x', 'Szczebrzeszyn', 'y'),
(54, 'uznanie', '2021-02-05', '150.00', 'Zrealizowany', '27105044759393063594017658', 'Nazwa nadawcy', 'Adres nadawcy', '13102029640000000000000018', 'Nazwa odbiorcy', 'Adres odbiorcy', 'Tytuł');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `lastName` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `address` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `contact` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `id_login` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id_user`, `name`, `lastName`, `address`, `contact`, `id_login`) VALUES
(1, 'Bank', 'A', '', 'gfgdfgfg', 1),
(2, 'DEJLI', 'EXPRESS', '23ertgh', 'qwedfghj', 2),
(16, 'Janusz', 'Siek', 'Daleko', 'adres@adres.pl', 22),
(17, 'Jan', 'Siek', 'dasad', 'qwedfghj', 23),
(18, 'Test3', 'Test3', 'Rzeszów 1', 'test3', 24);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id_account`);

--
-- Indeksy dla tabeli `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indeksy dla tabeli `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id_operation`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `account`
--
ALTER TABLE `account`
  MODIFY `id_account` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT dla tabeli `operation`
--
ALTER TABLE `operation`
  MODIFY `id_operation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
