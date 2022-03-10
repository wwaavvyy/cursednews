-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 27 2022 г., 00:46
-- Версия сервера: 10.5.11-MariaDB
-- Версия PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cursednews`
--

-- --------------------------------------------------------

--
-- Структура таблицы `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `datestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `article`
--

INSERT INTO `article` (`id`, `title`, `description`, `content`, `datestamp`, `image`, `views`, `likes`, `user_id`, `status_id`, `category_id`) VALUES
(8, 'Первая новость', 'Ехал грека через реку', '<p><b>Ехал грека через реку.&nbsp;</b><u style=\"font-weight: bold;\">Ехал грека через реку.&nbsp;</u><font color=\"#000000\" style=\"background-color: rgb(255, 255, 0);\">Ехал грека через реку.&nbsp;</font><span style=\"font-size: 1rem; font-weight: bolder;\">Ехал грека через реку.&nbsp;</span><u style=\"font-size: 1rem; font-weight: bold;\">Ехал грека через реку.&nbsp;</u><font color=\"#000000\" style=\"font-size: 1rem; background-color: rgb(255, 255, 0);\">Ехал грека через реку.&nbsp;</font><span style=\"font-size: 1rem; font-weight: bolder;\">Ехал грека через реку.&nbsp;</span><u style=\"font-size: 1rem; font-weight: bold;\">Ехал грека через реку.&nbsp;</u><font color=\"#000000\" style=\"font-size: 1rem; background-color: rgb(255, 255, 0);\">Ехал грека через реку.&nbsp;</font><span style=\"font-size: 1rem; font-weight: bolder;\">Ехал грека через реку.&nbsp;</span><u style=\"font-size: 1rem; font-weight: bold;\">Ехал грека через реку.&nbsp;</u><font color=\"#000000\" style=\"font-size: 1rem; background-color: rgb(255, 255, 0);\">Ехал грека через реку.&nbsp;</font><span style=\"font-size: 1rem; font-weight: bolder;\">Ехал грека через реку.&nbsp;</span><u style=\"font-size: 1rem; font-weight: bold;\">Ехал грека через реку.&nbsp;</u><font color=\"#000000\" style=\"font-size: 1rem; background-color: rgb(255, 255, 0);\">Ехал грека через реку.&nbsp;</font><span style=\"font-size: 1rem; font-weight: bolder;\">Ехал грека через реку.&nbsp;</span><u style=\"font-size: 1rem; font-weight: bold;\">Ехал грека через реку.&nbsp;</u><font color=\"#000000\" style=\"font-size: 1rem; background-color: rgb(255, 255, 0);\">Ехал грека через реку.&nbsp;</font><span style=\"font-size: 1rem; font-weight: bolder;\">Ехал грека через реку.&nbsp;</span><u style=\"font-size: 1rem; font-weight: bold;\">Ехал грека через реку.&nbsp;</u><font color=\"#000000\" style=\"font-size: 1rem; background-color: rgb(255, 255, 0);\">Ехал грека через реку.&nbsp;</font><span style=\"font-size: 1rem; font-weight: bolder;\">Ехал грека через реку.&nbsp;</span><u style=\"font-size: 1rem; font-weight: bold;\">Ехал грека через реку.&nbsp;</u><font color=\"#000000\" style=\"font-size: 1rem; background-color: rgb(255, 255, 0);\">Ехал грека через реку.</font><br></p>', '2022-01-27 00:42:47', 'rOy4q2uKYsjYtHF87YuDMCfNW_14jUHA.jpg', 0, 0, 1, 2, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `article_tag`
--

CREATE TABLE `article_tag` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `article_tag`
--

INSERT INTO `article_tag` (`id`, `article_id`, `tag_id`) VALUES
(15, 8, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Политика'),
(2, 'Спорт'),
(3, 'Технологии'),
(4, 'Экономика'),
(5, 'Общество'),
(6, 'Курсы'),
(7, 'Погода'),
(8, 'Наука'),
(10, 'Образование'),
(11, 'Путешествия'),
(12, 'Транспорт');

-- --------------------------------------------------------

--
-- Структура таблицы `commentary`
--

CREATE TABLE `commentary` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Скрытый'),
(2, 'Публичный');

-- --------------------------------------------------------

--
-- Структура таблицы `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tag`
--

INSERT INTO `tag` (`id`, `name`) VALUES
(1, 'Знаменитости'),
(2, 'Игры');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `isAdmin` int(11) NOT NULL DEFAULT 0,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `isAdmin`, `photo`) VALUES
(1, 'admin', '$2y$13$d.gBpMUDAOKKlrVZGDt2heTQSbhUuHULjgN.9HOlgKYiPk1IQwxQ2', 'admin@gmail.com', 1, NULL),
(2, 'wwaavvyy', '$2y$13$gT4at0DGNTxoncYOTkCBw.1TW0yuNyA43ARM0j7HQhkS6oI6vrjia', 'wwaavvyy2k@gmail.com', 0, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `article_tag`
--
ALTER TABLE `article_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `commentary`
--
ALTER TABLE `commentary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `article_id` (`article_id`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `article_tag`
--
ALTER TABLE `article_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `commentary`
--
ALTER TABLE `commentary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `article_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `article_tag`
--
ALTER TABLE `article_tag`
  ADD CONSTRAINT `article_tag_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `article_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `commentary`
--
ALTER TABLE `commentary`
  ADD CONSTRAINT `commentary_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commentary_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
