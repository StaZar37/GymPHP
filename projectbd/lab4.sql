-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 05 2023 г., 17:27
-- Версия сервера: 5.7.39
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `lab4`
--

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

CREATE TABLE `client` (
  `client_id` int(11) NOT NULL,
  `client_fio` varchar(255) NOT NULL,
  `trainer_fio` varchar(255) NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `insurance_termin` int(11) NOT NULL,
  `num_trains` int(255) NOT NULL,
  `total_price` int(11) NOT NULL,
  `date_pay_service` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `client`
--

INSERT INTO `client` (`client_id`, `client_fio`, `trainer_fio`, `service_type`, `insurance_termin`, `num_trains`, `total_price`, `date_pay_service`) VALUES
(132, 'Іван Андрійович Еременко', 'Фролов Олександр Іванович', 'Тренування всіх груп м`язів', 36, 24, 15360, '2023-06-05');

-- --------------------------------------------------------

--
-- Структура таблицы `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `service_price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `service`
--

INSERT INTO `service` (`service_id`, `service_type`, `service_price`) VALUES
(8, 'Кардіо тренування', '130'),
(9, 'Тренування ніг', '130'),
(10, 'Тренування ніг, кардіо та рук', '170'),
(11, 'Тренування ніг та рук', '150'),
(13, 'Тренування ніг та кардіо', '150'),
(24, 'Тренування м`язів живота та рук', '150'),
(25, 'Тренування м`язів живота та кардіо', '150'),
(26, 'Тренування м`язів живота та ніг', '150'),
(27, 'Тренування всіх груп м`язів', '200'),
(28, 'Тренування м`язів спини та рук', '150'),
(29, 'Тренування м`язів спини та ніг', '150');

-- --------------------------------------------------------

--
-- Структура таблицы `trainer`
--

CREATE TABLE `trainer` (
  `trainer_id` int(11) NOT NULL,
  `trainer_fio` varchar(255) NOT NULL,
  `trainer_price` varchar(255) NOT NULL,
  `is_work` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `trainer`
--

INSERT INTO `trainer` (`trainer_id`, `trainer_fio`, `trainer_price`, `is_work`) VALUES
(17, 'Васько Наталія Любомирівна', '120', 'Так'),
(18, 'Дем`яненко Олена Вікторівна', '120', 'Так'),
(19, 'Фролов Олександр Іванович', '140', 'Так'),
(20, 'Фетісова Олена Леонідівна', '150', 'Так'),
(21, 'Ткаченко Олександр Владиславович', '200', 'Так'),
(22, 'Маслобойщиков Сергій Володимирович', '200', 'Так'),
(23, 'Слабошпицький Мирослав Михайлович', '120', 'Так'),
(24, 'Педан Олег Ігорович', '130', 'Так'),
(25, 'Ігнатуша Олександр Федорович', '140', 'Так');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `roles`) VALUES
(1, 'admin', '$2y$10$xK9h.r6O6wWjs.6azdETFOCQWFZdhMGJyMqHcdjqLLEQss9IQfGQS', 'admin'),
(2, '123', '$2y$10$r0mO1pA2DUpcoUqcvBwlh.tQUqptwl2YjYmmJSWQ1xYJLjkV5d9IG', 'user'),
(3, '321', '$2y$10$xaHNvSq6Nb/TnssXZDGTou69OOEMrgnsG6t.E/LPXkrYkLdSYtfR2', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`);

--
-- Индексы таблицы `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Индексы таблицы `trainer`
--
ALTER TABLE `trainer`
  ADD PRIMARY KEY (`trainer_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT для таблицы `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `trainer`
--
ALTER TABLE `trainer`
  MODIFY `trainer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
