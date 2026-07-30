-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-04-2026 a las 03:31:31
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pizzafy`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

CREATE TABLE `cart` (
  `id` int(30) NOT NULL,
  `client_ip` varchar(20) NOT NULL,
  `user_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `category_list`
--

INSERT INTO `category_list` (`id`, `name`) VALUES
(1, 'test1'),
(2, 'test2'),
(3, 'test3'),
(4, 'test4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `mobile` text NOT NULL,
  `email` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `name`, `address`, `mobile`, `email`, `status`) VALUES
(1, 'Mark Cooper', 'Sample Address', '0912345698', 'mcooper@mail.com', 1),
(2, 'teste teste', 'teste', 'teste', 'teste@gmail.com', 1),
(3, 'teste teste', '156156156156', 'aaaaaaaaaaa', 'teste@gmail.com', 1),
(4, 'teste teste', 'hauahu', 'hauha', 'teste@gmail.com', 0),
(5, 'teste teste', '15616561', '15615', 'teste@gmail.com', 0),
(6, 'teste teste', 'hiuiuhaiu', 'huauiah', 'hau@gmail.com', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_list`
--

CREATE TABLE `order_list` (
  `id` int(30) NOT NULL,
  `order_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `order_list`
--

INSERT INTO `order_list` (`id`, `order_id`, `product_id`, `qty`) VALUES
(1, 1, 2, 2),
(2, 2, 1, 1),
(3, 3, 1, 1),
(4, 4, 1, 1),
(5, 5, 1, 1),
(6, 6, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_list`
--

CREATE TABLE `product_list` (
  `id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL DEFAULT 0,
  `img_path` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0= unavailable, 2 Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `product_list`
--

INSERT INTO `product_list` (`id`, `category_id`, `name`, `description`, `price`, `img_path`, `status`) VALUES
(2, 1, 'Brocolis', 'Brocolis', 380, '1775688240_1676512620_Sicilian.jpg', 1),
(3, 2, 'Cheese', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent suscipit porttitor dui, a accumsan metus molestie vel. Quisque luctus eros interdum, facilisis lectus at, aliquam lacus.', 360, '1676512980_detroit-style-thick.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'Pizzfy E-commerce', 'info@pizzafy.com', '0912654789', 'dynamic-pizza-slice-with-melting-cheese-dark-background.jpg', '<h1 style=\"margin-bottom: 0px; padding: 0px; line-height: 90px; color: rgb(0, 0, 0); text-align: center; font-size: 70px; font-family: DauphinPlain;\">Pizzafy</h1><h4 style=\"text-align: center; margin: 10px 10px 5px; padding: 0px; font-size: 14px; line-height: 18px; font-style: italic;\" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;\"=\"\"><span style=\"font-size: 14px; text-align: left;\"><font color=\"#000000\">This is Pizzafy E-commerce.</font></span></h4><p></p><p></p><p></p><p></p>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` text NOT NULL,
  `password` varchar(200) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=admin , 2 = staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'Administrator', 'admin@gmail.com', '$2y$10$efDvenHYJ5Fu/xxt1ANbXuRx5/TuzNs/s4k6keUiiFvr2ueE0GmrG', 1),
(2, 'Staff1111112', 'staff', '$2y$10$HwqavW3eNYD9.uKLS8CIKu0RMXyEgaes/n22hHusFYWGf1swtjIa2', 2),
(3, 'teste151', '156156', '$2y$10$aNkvXcXR96JDtQySDPHCXuT.s3Y4Xu/OJhYsvZnW6UnkZ37It6ZAC', 1),
(4, 'Staff111111', '115156', '$2y$10$Xe7oFPbBjqTrJVuEfeGqOODh3Qs8HFoAxtSR1xxsPUij4eIsycQv2', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_info`
--

CREATE TABLE `user_info` (
  `user_id` int(10) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `user_info`
--

INSERT INTO `user_info` (`user_id`, `first_name`, `last_name`, `email`, `password`, `mobile`, `address`) VALUES
(1, 'Mark', 'Cooper', 'mcooper@mail.com', '$2y$10$Z.LYi0zrDsrCYIgU1e7yCOkn1lbREGbUcIpSvgkB0OPapDfp7Xc0a', '0912345698', 'Sample Address'),
(2, 'teste', 'teste', 'teste@gmail.com', '$2y$10$tS8OqxXDQJW.STbLd6PCKu7Z5BJIturYHg4SoL/pio0NElaizSzJu', 'teste', 'teste');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
