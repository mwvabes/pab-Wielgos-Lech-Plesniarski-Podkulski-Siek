-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 06 Lut 2021, 14:32
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
(16, 'PL98105044756759862459242899', 513.25, 48),
(17, 'PL98105044758332285663955814', 54583.9, 1),
(19, 'PL98105044755588264284882898', 5158.5, 1),
(20, 'PL98105044757447294937977519', 10002.4, 2),
(21, 'PL98105044758669798444733241', 50.45, 50),
(22, 'PL98105044754218739331471968', 5002, 48),
(23, 'PL98105044752176153795696797', 4800, 54),
(29, 'PL98105044751144856531642383', 112737, 50);

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
(97, NULL, 'Tytułem test', 230.93, 'czek', '1', 'czek', 'czek', '1', 'czek', 'czek', 'czek', '2021-02-05'),
(98, NULL, 'Tytułem test', 230.93, 'normal', 'PL34102014173109908720474799', 'normal', 'normal', 'PL87105044754135270066902937', 'normal', 'normal', 'settled', '2021-02-05'),
(99, NULL, 'Tytułem test', 230.93, 'normal', 'PL34102014173109908720474799', 'normal', 'normal', 'PL87105044754135270066902937', 'normal', 'normal', 'settled', '2021-02-05'),
(100, NULL, 'Tytułem test', 230.93, 'normal', 'PL34102014173109908720474799', 'normal', 'normal', 'PL87105044754135270066902937', 'normal', 'normal', 'settled', '2021-02-05'),
(102, NULL, 'Tytułem test', 230.93, 'normal', 'PL34102014173109908720474799', 'normal', 'normal', 'PL87105044754135270066902937', 'normal', 'normal', 'settled', '2021-02-05'),
(103, NULL, 'Tytułem test', 230.93, 'normal', 'PL34102014173109908720474799', 'normal', 'normal', 'PL87105044754135270066902937', 'normal', 'normal', 'settled', '2021-02-05'),
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
(135, 16, 'test payment', 1, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL98105044756759862459242899', 'Bank B', 'Skolyszyn', 'received', '2021-02-05'),
(136, 20, 'test payment', 1, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL34102014173109908720474799', 'Janusz Siek', 'Majdan', 'sended', '2021-02-05'),
(137, 20, 'jk', 150, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL98105044755588264284882898', 'Marcin Wielgos', 'Kraków', 'completed', '2021-02-05'),
(138, 19, 'jk', 150, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL98105044755588264284882898', 'Marcin Wielgos', 'Kraków', 'received', '2021-02-05'),
(139, 20, 'Projekt', 255, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL98105044756759862459242899', 'Marcin Wielgos', 'Pusta Wola', 'completed', '2021-02-05'),
(140, 16, 'Projekt', 255, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL98105044756759862459242899', 'Marcin Wielgos', 'Pusta Wola', 'received', '2021-02-05'),
(141, 17, 'talon na balony', 300, 'getting express', 'PL98105044758332285663955814', 'Krzysztof Podkulski', 'Skolyszyn 453', 'PL52102029640589242593459630', 'Marcin Wielgos', 'Jaroslaw Gdzies', 'accepted', '2021-02-05'),
(142, 17, 'talon na balony', 300, 'PL98105044757447294937977519', '', 'Krzysztof Podkulski', 'Skolyszyn 453', 'PL98105044758332285663955814', 'send to user acc', 'Rzeszow 10a', 'sended', '2021-02-05'),
(143, 20, 'talon na balony', 300, 'getting express', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skolyszyn 453', 'PL52102029640589242593459630', 'Marcin Wielgos', 'Jaroslaw Gdzies', 'accepted', '2021-02-05'),
(144, 17, 'geting from express payment', 300, 'express output', 'PL52102029640589242593459630', 'Marcin Wielgos', 'Jaroslaw Gdzies', 'PL98105044758332285663955814', 'Bank B express account', 'Rzeszow 10a', 'accepted', '2021-02-05'),
(145, 17, 'From express account to PL98105044757447294937977519 ', 300, 'send to user', 'PL98105044758332285663955814', 'Bank B express account', 'Rzeszow 10a', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skolyszyn 453', 'sended', '2021-02-05'),
(146, 20, 'talon na balony', 300, 'express payment', 'PL52102029640589242593459630', 'Marcin Wielgos', 'Jaroslaw Gdzies', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skolyszyn 453', 'accepted', '2021-02-05'),
(147, 17, 'geting from express payment', 300, 'express output', 'PL52102029640589242593459630', 'Marcin Wielgos', 'Jaroslaw Gdzies', 'PL98105044758332285663955814', 'Bank B express account', 'Rzeszow 10a', 'accepted', '2021-02-05'),
(148, 17, 'From express account to PL98105044757447294937977519 ', 300, 'send to user', 'PL98105044758332285663955814', 'Bank B express account', 'Rzeszow 10a', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skolyszyn 453', 'sended', '2021-02-05'),
(149, 20, 'dymy jak mlody z mockiem', 300, 'express payment', 'PL52102029640589242593459630', 'Marcin Wielgos', 'Jaroslaw Gdzies', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skolyszyn 453', 'accepted', '2021-02-05'),
(150, 17, 'geting from express payment', 300, 'express output', 'PL52102029640589242593459630', 'Marcin Wielgos', 'Jaroslaw Gdzies', 'PL98105044758332285663955814', 'Bank B express account', 'Rzeszow 10a', 'accepted', '2021-02-05'),
(151, 17, 'From express account to PL98105044758332285663955814 ', 300, 'send to user', 'PL98105044758332285663955814', 'Bank B express account', 'Rzeszow 10a', 'PL98105044758332285663955814', 'Krzysztof Podkulski', 'Skolyszyn 453', 'sended', '2021-02-05'),
(152, 17, 'dymy jak mlody z mockiem', 300, 'express payment', 'PL52102029640589242593459630', 'Marcin Wielgos', 'Jaroslaw Gdzies', 'PL98105044758332285663955814', 'Krzysztof Podkulski', 'Skolyszyn 453', 'accepted', '2021-02-05'),
(153, 20, 'Projekt', 25, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL98105044756759862459242899', 'Bank B', 'Kraków', 'completed', '2021-02-05'),
(154, 16, 'Projekt', 25, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL98105044756759862459242899', 'Bank B', 'Kraków', 'received', '2021-02-05'),
(155, 20, 'Marcin test', 200, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL34102014173109908720474799', 'Marcin Wielgos', 'Pusta Wola', 'sended', '2021-02-05'),
(156, NULL, 'PL87105044754135270066902937', 0, 'outside', 'PL34102014173109908720474799', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', '2021-02-06'),
(157, NULL, 'PL87105044754135270066902937', 0, 'outside', 'PL34102014173109908720474799', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', '2021-02-06'),
(158, NULL, 'PL87105044754135270066902937', 0, 'outside', 'PL34102014173109908720474799', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', '2021-02-06'),
(159, NULL, 'PL87105044754135270066902937', 0, 'outside', 'PL34102014173109908720474799', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', '2021-02-06'),
(160, NULL, 'PL87105044754135270066902937', 0, 'outside', 'PL34102014173109908720474799', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', '2021-02-06'),
(161, NULL, 'PL87105044754135270066902937', 0, 'outside', 'PL34102014173109908720474799', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', 'PL87105044754135270066902937', '2021-02-06'),
(166, NULL, 'Tytułem test bez zamknięcia', 12230.9, 'outside', 'PL34102014173109908720474799', 'Nazwa nadawcy', 'Adres nadawcy 1', 'PL87105044754135270066902937', 'Nazwa odbiorcy', 'Adres odbiorcy', 'settled', '2021-02-06'),
(167, NULL, 'Testowy', 230.93, 'outside', 'PL34102014173109908720474799', 'Nazwa nadawcy', 'Adres nadawcy 1', 'PL87105044754135270066902937', 'Krzyś', 'Adres odbiorcy', 'settled', '2021-02-06'),
(172, 29, 'Not found a number: PL87105044754135270066902937', 12230.9, 'save cash on bank payback acoount', 'PL34102014173109908720474799', 'Nazwa nadawcy', 'Adres nadawcy 1', 'PL98105044751144856531642383', 'Bank B Payback', 'Rzeszow 10a', 'gained', '2021-02-06'),
(173, 29, 'payback PL87105044754135270066902937', 12230.9, 'normal Payback', 'PL98105044751144856531642383', 'Nazwa odbiorcy Bank B Payback', 'Adres odbiorcy Bank B Payback', 'PL34102014173109908720474799', 'Nazwa nadawcy', 'Adres nadawcy 1', 'sended', '2021-02-06'),
(174, 29, 'Not found a number: PL87105044754135270066902937', 230.93, 'save cash on bank payback acoount', 'PL34102014173109908720474799', 'Nazwa nadawcy', 'Adres nadawcy 1', 'PL98105044751144856531642383', 'Bank B Payback', 'Rzeszow 10a', 'gained', '2021-02-06'),
(175, 29, 'payback PL87105044754135270066902937', 230.93, 'normal Payback', 'PL98105044751144856531642383', 'Krzyś Bank B Payback', 'Adres odbiorcy Bank B Payback', 'PL34102014173109908720474799', 'Nazwa nadawcy', 'Adres nadawcy 1', 'sended', '2021-02-06'),
(176, 20, 'To bank', 275.23, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL98105044751144856531642383', 'Bank B', 'nana', 'completed', '2021-02-06'),
(177, 29, 'To bank', 275.23, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL98105044751144856531642383', 'Bank B', 'nana', 'received', '2021-02-06'),
(178, 20, 'test payment', 28.23, 'normal', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL34102014173109908720474799', 'Janusz Siek', 'Rzeszow 1a', 'sended', '2021-02-06'),
(179, 20, 'Projekt', 3.5, 'express', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL34102014173109908720474799', 'Marcin Wielgos', 'Skolyszyn', 'sended', '2021-02-06'),
(180, 19, 'express: PL98105044757447294937977519 -> PL34102014173109908720474799', 3.5, 'express', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'PL98105044755588264284882898', 'bank express account', 'Rzeszow 14a', 'received', '2021-02-06'),
(181, 20, 'express: PaymentBack PL98105044757447294937977519 -> PL34102014173109908720474799', 1, 'express', 'PL98105044755588264284882898', 'bank express account', 'Rzeszow 14a', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skołyszyn 453', 'received', '2021-02-06'),
(182, 29, 'Not found a number: PL87105044754135270066902937', 12230.9, 'save cash on bank payback acoount', 'PL34102014173109908720474799', 'Nazwa nadawcy', 'Adres nadawcy 1', 'PL98105044751144856531642383', 'Bank B Payback', 'Rzeszow 10a', 'gained', '2021-02-06'),
(183, 29, 'PayBack for  PL87105044754135270066902937', 12230.9, 'normal Payback', 'PL98105044751144856531642383', 'Nazwa odbiorcy Bank B Payback', 'Adres odbiorcy Bank B Payback', 'PL34102014173109908720474799', 'Nazwa nadawcy', 'Adres nadawcy 1', 'sended', '2021-02-06'),
(184, 29, 'Not found a number: PL87105044754135270066902937', 230.93, 'save cash on bank payback acoount', 'PL34102014173109908720474799', 'Nazwa nadawcy', 'Adres nadawcy 1', 'PL98105044751144856531642383', 'Bank B Payback', 'Rzeszow 10a', 'gained', '2021-02-06'),
(185, 29, 'PayBack for  PL87105044754135270066902937', 230.93, 'normal Payback', 'PL98105044751144856531642383', 'Krzyś Bank B Payback', 'Adres odbiorcy Bank B Payback', 'PL34102014173109908720474799', 'Nazwa nadawcy', 'Adres nadawcy 1', 'sended', '2021-02-06'),
(186, 17, 'geting from express payment', 300, 'express output', 'PL52102029640589242593459630', 'Marcin Wielgos', 'Jaroslaw Gdzies', 'PL98105044758332285663955814', 'Bank B express account', 'Rzeszow 10a', 'accepted', '2021-02-06'),
(187, 17, 'From express account to PL98105044757447294937977519 ', 300, 'send to user', 'PL98105044758332285663955814', 'Bank B express account', 'Rzeszow 10a', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skolyszyn 453', 'sended', '2021-02-06'),
(188, 20, 'dymy jak mlody z mockiem', 300, 'express payment', 'PL52102029640589242593459630', 'Marcin Wielgos', 'Jaroslaw Gdzies', 'PL98105044757447294937977519', 'Krzysztof Podkulski', 'Skolyszyn 453', 'accepted', '2021-02-06'),
(189, 16, 'Projekt', 2, '', 'PL98105044756759862459242899', 'Marcin Wielgos', 'Rzeszow 123', 'PL98105044754218739331471968', 'Marcin Wielgos', 'Pusta Wola', 'completed', '2021-02-06'),
(190, 22, 'Projekt', 2, '', 'PL98105044756759862459242899', 'Marcin Wielgos', 'Rzeszow 123', 'PL98105044754218739331471968', 'Marcin Wielgos', 'Pusta Wola', 'received', '2021-02-06');

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
(1, 'Admin Bank', 'Express', 98083108521, 'krzysztof453@onet.eu', 602358737, 'Skolyszyn 453', 'aysta', 'zaq1@WSX', 'admin'),
(2, 'Krzysztof', 'Podkulski', 11111111111, ' krzysztof453@onet.eu', 602358737, 'Skołyszyn 453', 'aysta1', '1234567', 'user'),
(48, 'Marcin', 'Wielgos', 12312312312, ' wielgos@cos.tak', 453453453, 'Rzeszow 123', 'wielgosik', 'zaq1@WSX', 'user'),
(49, 'Karol', 'Lech', 12345678901, ' krzysztof453@onet.eu', 602358737, 'Skołyszyn 453', 'ogien', 'kotek', 'user'),
(50, 'Bank Admin', 're payback account', 12312312312, 'bankb@gmail.om', 123123987, 'rzeszow 14a', 'aysta2', 'zaq1@WSX', 'admin'),
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
  MODIFY `id_account` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT dla tabeli `operation`
--
ALTER TABLE `operation`
  MODIFY `id_operation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

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
