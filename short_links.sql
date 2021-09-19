-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Хост: localhost
-- Час створення: Вер 19 2021 р., 14:17
-- Версія сервера: 10.3.28-MariaDB-cll-lve
-- Версія PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `link`
--

-- --------------------------------------------------------

--
-- Структура таблиці `short_links`
--

CREATE TABLE IF NOT EXISTS `short_links` (
  `link_id` int(11) NOT NULL COMMENT 'ID link',
  `link_hash` varchar(32) DEFAULT NULL COMMENT 'hash link',
  `link_url` text DEFAULT NULL COMMENT 'url link'
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='Re:Director Database';

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `short_links`
--
ALTER TABLE `short_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_hash` (`link_hash`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `short_links`
--
ALTER TABLE `short_links`
  MODIFY `link_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID link',AUTO_INCREMENT=0;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
