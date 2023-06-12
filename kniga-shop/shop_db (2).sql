-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 19 2023 г., 15:17
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shop_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `price`, `quantity`, `image`) VALUES
(179, 1, 3, 13, 3, '1984.jpg'),
(180, 1, 4, 16, 2, 'benzop.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE `message` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(10, 1, 'sfasfasfasf', 'aaa@mai.ru', '375255005622', 'Тестовое сообщение №4'),
(11, 1, 'Alexander', 'aaa@mail.ru', '375255005622', 'SODNFLSNDL L Lkj lslskj dlskdg a\'d\n \n \nASDF\nASD F[SD F[\n ASD[FASDP[F [SADF \n[ASDF ;ASDJ ;ASDF; OASDO;F JSAOD OSIDJFOSADFJ OISDFJOIASD OSDJ OASDJF O  OASIDJF OA OASIDJ ASD  ;ASIDOFF JA;S ;ASDIJF ;AS ;ASDO; J;ASDOF JFOASDJ ;ASDF '),
(12, 1, 'Тестировщик', 'petr@gmail.com', '375255005622', 'ОЛЫФИВФЫОВЫФОВ АХЫФВОА ЫФВОА ФЫВОА ФЫВОА ЫФВОА ЫФВАО ФЫВОА ЫФВТАЫ ФВАОЛЫВ АЛФЫВАЛЫФВ АЛЫФВТ АЛФЫОВ АОЛФЫВА ЛЫФВА ЛФЫВА ТЛФЫВО АТЛЫФВА ');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(100) NOT NULL,
  `total_price` int NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(4, 1, 'Александр', '12', 'sashatomelovichsasha@mail.ru', 'cash on delivery', 'Беларусь, Ивье, Чехова, № 8 - 231337', ',  (1) ,  (3) ', 55, '18-Mar-2023', 'pending'),
(5, 1, 'Александр', '1313', 'sashatomelovichsasha@mail.ru', 'cash on delivery', 'Беларусь, Ивье, Чехова, № 8 - 231337', ',  (1) ', 13, '18-Mar-2023', 'pending'),
(6, 1, 'Александр', '1313', 'sashatomelovichsasha@mail.ru', 'cash on delivery', 'Беларусь, Ивье, Чехова, № 8 - 231337', ', Синтонимы (2) , Человек для себя (1) ', 42, '18-Mar-2023', 'pending'),
(7, 1, 'Петр', '333', 'petr@gmail.com', 'cash on delivery', 'Беларусь, Гродно, Курчатова, № 13 - 230009', ', Человек-бензопила. Книга 6. Вперед, Человек-бензопила! (11) , Тревожные люди (8) , Оно (4) ', 432, '18-Mar-2023', 'completed');

-- --------------------------------------------------------

--
-- Структура таблицы `order_products`
--

CREATE TABLE `order_products` (
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity_products` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `order_products`
--

INSERT INTO `order_products` (`order_id`, `product_id`, `quantity_products`) VALUES
(4, 4, 1),
(4, 3, 3),
(5, 3, 1),
(5, 4, 2),
(6, 5, 2),
(6, 7, 1),
(7, 4, 11),
(7, 6, 8),
(7, 2, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `image` varchar(100) NOT NULL,
  `type_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `type_id`) VALUES
(2, 'Оно', 10, 'ono.jpg', 1),
(3, '1984', 13, '1984.jpg', 1),
(4, 'Человек-бензопила. Книга 6. Вперед, Человек-бензопила!', 16, 'benzop.jpg', 2),
(5, 'Синтонимы', 12, 'sintonim.jpg', 1),
(6, 'Тревожные люди', 27, 'people.jpg', 1),
(7, 'Человек для себя', 18, 'chel_i.jpg', 1),
(8, '1984. Скотный двор', 16, 'skotn-dvor.jpg', 1),
(9, 'Мастер и Маргарита', 16, 'Master_i_Margarita.jpg', 1),
(10, 'Гордость и предубеждение', 17, 'gordost.jpg', 1),
(11, 'Рик и Морти. Истории за кадром', 26, 'Rik_i_Morti.jpg', 3),
(12, 'Death Note. Black Edition. Книга 1', 37, 'Death_Note_Black_Edition_Kniga_1.jpg', 2),
(13, 'One Piece. Большой куш. Книга 5. Только вперед!', 34, 'One_Piece_Bolshoy_kush_Kniga_5.jpg', 2),
(14, 'Бэтмен. Убийственная шутка', 28, 'Betmen_Ubiystvennaya_shutka.jpg', 3),
(15, 'Стальной алхимик. Книга 1', 35, 'stal-alh.jpg', 2),
(16, 'Ганнибал', 26, 'ganibal.jpg', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `type_books`
--

CREATE TABLE `type_books` (
  `type_id` int NOT NULL,
  `name_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `type_books`
--

INSERT INTO `type_books` (`type_id`, `name_type`) VALUES
(1, 'Книга'),
(2, 'Манга'),
(3, 'Комикс');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(1, 'Томелович Александр Евгеньевич', 'aaa@mai.ru', 'b0baee9d279d34fa1dfd71aadb908c3f', 'user'),
(2, 'Томелович Александр Евгеньевич', 'tomelovichs@gmail.com', 'b0baee9d279d34fa1dfd71aadb908c3f', 'admin'),
(3, 'Пётр', 'petr@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `order_products`
--
ALTER TABLE `order_products`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`);

--
-- Индексы таблицы `type_books`
--
ALTER TABLE `type_books`
  ADD PRIMARY KEY (`type_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT для таблицы `message`
--
ALTER TABLE `message`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ограничения внешнего ключа таблицы `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type_books` (`type_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
