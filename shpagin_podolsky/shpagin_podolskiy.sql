-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3308
-- Время создания: Окт 19 2023 г., 22:26
-- Версия сервера: 8.0.29
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shpagin_podolskiy`
--
CREATE DATABASE IF NOT EXISTS `shpagin_podolskiy` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `shpagin_podolskiy`;

-- --------------------------------------------------------

--
-- Структура таблицы `klient`
--

DROP TABLE IF EXISTS `klient`;
CREATE TABLE `klient` (
  `id_klient` int NOT NULL,
  `name_klient` varchar(40) NOT NULL,
  `klient_fon` varchar(14) NOT NULL,
  `number_passport` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `adress` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `klient`
--

INSERT INTO `klient` (`id_klient`, `name_klient`, `klient_fon`, `number_passport`, `adress`) VALUES
(1, 'укеукеу', 'укеуке', 'укеуке', 'укеуке');

-- --------------------------------------------------------

--
-- Структура таблицы `oper_klient`
--

DROP TABLE IF EXISTS `oper_klient`;
CREATE TABLE `oper_klient` (
  `id_operklient` int NOT NULL,
  `id_schet` int NOT NULL,
  `id_operation` int NOT NULL,
  `date_operation` date NOT NULL,
  `price_operation` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `schet`
--

DROP TABLE IF EXISTS `schet`;
CREATE TABLE `schet` (
  `id_schet` int NOT NULL,
  `id_klient` int NOT NULL,
  `id_account` int NOT NULL,
  `number_account` int NOT NULL,
  `date_open` date NOT NULL,
  `date_close` date DEFAULT NULL,
  `price_open` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `schet`
--

INSERT INTO `schet` (`id_schet`, `id_klient`, `id_account`, `number_account`, `date_open`, `date_close`, `price_open`) VALUES
(1, 1, 4, 234234, '2023-10-19', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `s_accoount`
--

DROP TABLE IF EXISTS `s_accoount`;
CREATE TABLE `s_accoount` (
  `id_account` int NOT NULL,
  `name_account` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `s_accoount`
--

INSERT INTO `s_accoount` (`id_account`, `name_account`) VALUES
(4, 'апрапрапрывааыв');

-- --------------------------------------------------------

--
-- Структура таблицы `s_operation`
--

DROP TABLE IF EXISTS `s_operation`;
CREATE TABLE `s_operation` (
  `id_operation` int NOT NULL,
  `name_operation` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `klient`
--
ALTER TABLE `klient`
  ADD PRIMARY KEY (`id_klient`);

--
-- Индексы таблицы `oper_klient`
--
ALTER TABLE `oper_klient`
  ADD PRIMARY KEY (`id_operklient`),
  ADD KEY `id_schet` (`id_schet`),
  ADD KEY `id_opetation` (`id_operation`);

--
-- Индексы таблицы `schet`
--
ALTER TABLE `schet`
  ADD PRIMARY KEY (`id_schet`),
  ADD KEY `id_klient` (`id_klient`),
  ADD KEY `id_account` (`id_account`);

--
-- Индексы таблицы `s_accoount`
--
ALTER TABLE `s_accoount`
  ADD PRIMARY KEY (`id_account`);

--
-- Индексы таблицы `s_operation`
--
ALTER TABLE `s_operation`
  ADD PRIMARY KEY (`id_operation`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `klient`
--
ALTER TABLE `klient`
  MODIFY `id_klient` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `oper_klient`
--
ALTER TABLE `oper_klient`
  MODIFY `id_operklient` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `schet`
--
ALTER TABLE `schet`
  MODIFY `id_schet` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `s_accoount`
--
ALTER TABLE `s_accoount`
  MODIFY `id_account` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `s_operation`
--
ALTER TABLE `s_operation`
  MODIFY `id_operation` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `oper_klient`
--
ALTER TABLE `oper_klient`
  ADD CONSTRAINT `oper_klient_ibfk_1` FOREIGN KEY (`id_schet`) REFERENCES `schet` (`id_schet`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `oper_klient_ibfk_2` FOREIGN KEY (`id_operation`) REFERENCES `s_operation` (`id_operation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `schet`
--
ALTER TABLE `schet`
  ADD CONSTRAINT `schet_ibfk_1` FOREIGN KEY (`id_klient`) REFERENCES `klient` (`id_klient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schet_ibfk_2` FOREIGN KEY (`id_account`) REFERENCES `s_accoount` (`id_account`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
