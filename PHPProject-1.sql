-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Время создания: Июл 12 2022 г., 09:50
-- Версия сервера: 5.7.34
-- Версия PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `PHPProject-1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `baskets`
--

CREATE TABLE `baskets` (
  `basket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `baskets`
--

INSERT INTO `baskets` (`basket_id`, `user_id`, `product_id`) VALUES
(1, 2, 3),
(2, 2, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `category_photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`category_id`, `category`, `category_photo`) VALUES
(8, 'Чеснок', 'images/garlic.png'),
(36, 'Морковь', 'images/carrot.png'),
(45, 'Огурец', 'images/cucumber.png'),
(47, 'Лук', 'images/onion.png');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `number_of_order` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `kol` float NOT NULL,
  `cost` float NOT NULL,
  `address` varchar(255) NOT NULL,
  `number_of_phone` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`order_id`, `number_of_order`, `user_id`, `product_id`, `kol`, `cost`, `address`, `number_of_phone`, `status`) VALUES
(23, 1, 2, 14, 10, 33.2, 'minsk', '+375 (44) 777-22-11', 'доставлен'),
(24, 1, 2, 3, 1, 2.43, 'minsk', '+375 (44) 777-22-11', 'доставлен'),
(27, 3, 4, 15, 23.99, 106.276, 'minsk', '+375 (44) 777-22-11', 'передан курьеру'),
(28, 4, 2, 14, 2.54, 10.7442, 'sverdlova, 13a', '+375 (44) 234-12-34', 'в обработке'),
(29, 4, 2, 3, 1.2, 6.912, 'sverdlova, 13a', '+375 (44) 234-12-34', 'в обработке'),
(30, 5, 2, 3, 3, 17.28, 'Белорусская, 21', '+375 (33) 666-77-88', 'в обработке'),
(31, 5, 2, 14, 3, 12.69, 'Белорусская, 21', '+375 (33) 666-77-88', 'в обработке');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sort` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `max_kol` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `sort`, `price`, `max_kol`) VALUES
(3, 8, 'Обычный', 5.76, 11.2),
(14, 36, 'Сочная', 4.23, 34.69),
(15, 47, 'Наш', 4.43, 0.01),
(17, 45, 'Коля', 6.34, 123),
(18, 36, 'Erty', 12, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `secondname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `number_of_phone` varchar(255) NOT NULL,
  `type_of_user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `name`, `surname`, `secondname`, `address`, `number_of_phone`, `type_of_user`) VALUES
(1, 'admin@admin.by', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', 'admin', '', '', 'admin'),
(2, 'qwe@qwe.qwe', '76d80224611fc919a5d54f0ff9fba446', 'Илья', 'Савельев', 'Kuygklig.b', 'Белорусская, 21', '+375 (33) 666-77-88', 'client'),
(4, 'q@q.q', '76d80224611fc919a5d54f0ff9fba446', 'q', 'q', 'q', '', '', 'client'),
(5, 'qw@qw.qw', '21232f297a57a5a743894a0e4a801fc3', 'qw', 'qw', 'qw', '', '', 'client'),
(6, 'BepTyXa.B.yXo@yandex.ru', 'f9e90031e2f90373b91727e773b2f361', 'Кирилл', 'Юркевич', 'Александрович', 'Минск, Белорусская, 21', '+375 (44) 702-14-29', 'client');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `baskets`
--
ALTER TABLE `baskets`
  ADD PRIMARY KEY (`basket_id`),
  ADD KEY `baskets_ibfk_1` (`user_id`),
  ADD KEY `baskets_ibfk_2` (`product_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `orders_ibfk_1` (`user_id`),
  ADD KEY `orders_ibfk_2` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `products_ibfk_1` (`category_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `baskets`
--
ALTER TABLE `baskets`
  MODIFY `basket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `baskets`
--
ALTER TABLE `baskets`
  ADD CONSTRAINT `baskets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `baskets_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
