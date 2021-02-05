-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 05 Lut 2021, 16:52
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
-- Baza danych: `bankb`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `account`
--

CREATE TABLE `account` (
  `id_account` int(11) NOT NULL,
  `account_number` varchar(28) NOT NULL,
  `balance` float NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `account`
--

INSERT INTO `account` (`id_account`, `account_number`, `balance`, `id_user`) VALUES
(16, 'PL98105044756759862459242899', 235.25, 48),
(17, 'PL98105044758332285663955814', 4736.5, 1),
(19, 'PL98105044755588264284882898', 5007, 1),
(20, 'PL98105044757447294937977519', 10939.4, 2),
(21, 'PL98105044758669798444733241', 50.45, 50),
(22, 'PL98105044754218739331471968', 5000, 48),
(23, 'PL98105044752176153795696797', 4800, 54),
(24, 'PL98105044757745513657396641', 0, 49),
(25, 'PL87105044754135270066902937', 696.79, 1),
(26, '2', 3, 1),
(27, '2', 3, 1),
(28, '2', 3, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `operation`
--

CREATE TABLE `operation` (
  `id_operation` int(11) NOT NULL,
  `id_account` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `type` varchar(255) NOT NULL,
  `sender_number` varchar(28) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `sender_address` varchar(255) NOT NULL,
  `recipent_number` varchar(28) NOT NULL,
  `recipent_name` varchar(255) NOT NULL,
  `recipent_address` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `operation`
--

INSERT INTO `operation` (`id_operation`, `id_account`, `title`, `amount`, `type`, `sender_number`, `sender_name`, `sender_address`, `recipent_number`, `recipent_name`, `recipent_address`, `status`, `date`) VALUES
(69, 16, 'Projekt', 200, 'normal', 'PL98105044752176153795696797', 'Janusz SIek', 'Majdan', 'PL98105044756759862459242899', 'Marcin Wielgos', 'Majdan', 'received', '2021-02-02'),
(97, 25, 'Tytułem test', 230.93, 'czek', '1', 'czek', 'czek', '1', 'czek', 'czek', 'czek', '2021-02-05'),
(98, 25, 'Tytułem test', 230.93, 'normal', 'PL34102014173109908720474799', 'normal', 'normal', 'PL87105044754135270066902937', 'normal', 'normal', 'settled', '2021-02-05'),
(99, 25, 'Tytułem test', 230.93, 'normal', 'PL34102014173109908720474799', 'normal', 'normal', 'PL87105044754135270066902937', 'normal', 'normal', 'settled', '2021-02-05'),
(100, 25, 'Tytułem test', 230.93, 'normal', 'PL34102014173109908720474799', 'normal', 'normal', 'PL87105044754135270066902937', 'normal', 'normal', 'settled', '2021-02-05'),
(102, 25, 'Tytułem test', 230.93, 'normal', 'PL34102014173109908720474799', 'normal', 'normal', 'PL87105044754135270066902937', 'normal', 'normal', 'settled', '2021-02-05'),
(103, 25, 'Tytułem test', 230.93, 'normal', 'PL34102014173109908720474799', 'normal', 'normal', 'PL87105044754135270066902937', 'normal', 'normal', 'settled', '2021-02-05'),
(104, 17, 'Tytułem test', 230.93, 'normal Payback', 'PL98105044758332285663955814', 'Bank B Payback', 'Bank B Payback', 'PL34102014173109908720474799', 'normal', 'normal', 'sended', '2021-02-05'),
(107, 17, 'Tytułem test', 230.93, 'normal Payback', 'PL98105044758332285663955814', 'Bank B Payback', 'Bank B Payback', 'PL34102014173109908720474799', 'normal', 'normal', 'sended', '2021-02-05'),
(108, 17, 'Tytułem test', 230.93, 'normal Payback', 'PL98105044758332285663955814', 'Bank B Payback', 'Bank B Payback', 'PL34102014173109908720474799', 'normal', 'normal', 'sended', '2021-02-05'),
(111, 17, 'Tytułem test', 230.93, 'normal Payback', 'PL98105044758332285663955814', 'Bank B Payback', 'Bank B Payback', 'PL34102014173109908720474799', 'normal', 'normal', 'sended', '2021-02-05'),
(112, 17, 'asdsa', 123, 'express', 'PL98105044756759862459242899', 'asda', 'asd', 'PL98105044758332285663955814', 'sad', 'asd', 'sended', '2021-02-05'),
(113, 17, 'asdsa', 123, 'express2', 'PL98105044756759862459242899', 'Janusz siek', 'Rzeszow UR', 'PL98105044758332285663955814', 'sad', 'asd', 'sended', '2021-02-05'),
(118, 20, 'Projekt', 1, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL98105044756759862459242899', 'Marcin Wielgos', 'Majdan', 'completed', '2021-02-05'),
(119, 16, 'Projekt', 1, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL98105044756759862459242899', 'Marcin Wielgos', 'Majdan', 'received', '2021-02-05'),
(120, 16, 'asdsa', 123, 'normal Payback', 'PL98105044758332285663955814', 'Bank B Payback', 'Bank B Payback', 'PL98105044756759862459242899', 'Janusz mehh', 'Rzeszow UR', 'accepted', '2021-02-05'),
(121, 16, 'asdsa', 123, 'normal Payback', 'PL98105044758332285663955814', 'Bank B Payback', 'Bank B Payback', 'PL98105044756759862459242899', 'Janusz mehh', 'Rzeszow UR', 'accepted', '2021-02-05'),
(122, 16, 'asdsa', 123, 'normal Payback', 'PL98105044758332285663955814', 'Bank B Payback', 'Bank B Payback', 'PL98105044756759862459242899', 'Janusz mehh12312312312312', 'Rzeszow UR', 'accepted', '2021-02-05'),
(123, 16, 'asdsa', 123, 'normal Payback', 'PL98105044758332285663955814', 'Bank B Payback', 'Bank B Payback', 'PL98105044756759862459242899', 'Janusz mehh12312312312312543543131', 'Rzeszow UR', 'accepted', '2021-02-05'),
(133, 17, 'asdsa', 123, 'normal Payback', 'PL98105044758332285663955814', 'Bank B Payback', 'Bank B Payback', 'PL98105044758332285663955814', 'Janusz mehh12312312312312543543131', 'Rzeszow UR', 'accepted', '2021-02-05'),
(134, 20, 'test payment', 1, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL98105044756759862459242899', 'Bank B', 'Skolyszyn', 'completed', '2021-02-05'),
(135, 16, 'test payment', 1, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL98105044756759862459242899', 'Bank B', 'Skolyszyn', 'received', '2021-02-05');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `pesel` bigint(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` int(9) NOT NULL,
  `address` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type_user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `pesel`, `email`, `telephone`, `address`, `username`, `password`, `type_user`) VALUES
(1, 'Krzysztof', 'Podkulski', 98083108521, 'krzysztof453@onet.eu', 602358737, 'Skolyszyn 453', 'aysta', 'zaq1@WSX', 'admin'),
(2, 'Krzysztof', 'Podkulski', 11111111111, ' krzysztof453@onet.eu', 602358737, 'Skołyszyn 453', 'aysta1', '1234567', 'user'),
(48, 'Marcin', 'Wielgos', 12312312312, ' wielgos@cos.tak', 453453453, 'Rzeszow 123', 'wielgosik', 'zaq1@WSX', 'user'),
(49, 'Karol', 'Lech', 12345678901, ' krzysztof453@onet.eu', 602358737, 'Skołyszyn 453', 'ogien', 'kotek', 'user'),
(50, 'Przemek', 'Plesniarki', 12312312312, 'plesnarski@gmail.com', 123123987, 'sanok gdzies', ' przemus', 'betka', 'admin'),
(54, 'Janusz', 'SIek', 12345678901, 'kuba17447@wp.pl', 123123123, 'Majdan', 'januszek', 'sieczek', 'user');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id_account`),
  ADD KEY `account_with_user` (`id_user`);

--
-- Indeksy dla tabeli `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id_operation`),
  ADD KEY `id_account` (`id_account`),
  ADD KEY `operation_with_account` (`id_account`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `account`
--
ALTER TABLE `account`
  MODIFY `id_account` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT dla tabeli `operation`
--
ALTER TABLE `operation`
  MODIFY `id_operation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_with_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `operation`
--
ALTER TABLE `operation`
  ADD CONSTRAINT `operation_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id_account`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
