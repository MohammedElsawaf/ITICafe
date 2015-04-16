-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2015 at 01:06 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cafeteria`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
`category_id` smallint(6) NOT NULL,
  `category_name` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'hot drink'),
(2, 'soft drink'),
(3, 'juices'),
(4, 'sawaftea'),
(5, 'tea'),
(8, 'teas');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
`order_id` smallint(6) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `users_user_id` smallint(6) NOT NULL,
  `status` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `date`, `users_user_id`, `status`) VALUES
(2, '2015-04-02 06:32:22', 2, 'process'),
(3, '2015-04-03 07:19:15', 2, 'process'),
(4, '2015-04-09 04:14:15', 3, 'done'),
(5, '2015-04-09 02:14:15', 3, 'done');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
`product_id` smallint(6) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `product_image` varchar(200) NOT NULL,
  `avaliable` tinyint(1) NOT NULL,
  `category_category_id` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `price`, `product_image`, `avaliable`, `category_category_id`) VALUES
(17, 'sawaftea', 100, 'Penguins.jpg', 1, 1),
(19, 'sawaftea', 200, 'upload92223367jpg', 1, 1),
(21, 'sawaft', 100, '67093460jpg', 1, 4),
(27, 'Latee', 200, '98368326jpg', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_has_orders`
--

CREATE TABLE IF NOT EXISTS `product_has_orders` (
  `product_product_id` smallint(6) NOT NULL,
  `orders_order_id` smallint(6) NOT NULL,
  `quantity` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_has_orders`
--

INSERT INTO `product_has_orders` (`product_product_id`, `orders_order_id`, `quantity`) VALUES
(17, 4, 1),
(19, 3, 1),
(21, 2, 1),
(21, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` smallint(6) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(50) NOT NULL,
  `room_no` int(11) NOT NULL,
  `ext` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `type` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `room_no`, `ext`, `image`, `type`) VALUES
(1, 'Mohammed Elsawaf', 'mohamed.elsawaf@yahoo.com', '827ccb0eea8a706c4c34a16891f84e7b', 112, 12, '', 1),
(2, 'Mohamed', 'sawaf@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 12, 1234, 'AlbumArtSmall.jpg', 1),
(3, 'ahmed', 'ahm@yahoo.com', '5be7ccdfacd74baa1cc52c96437ade2d', 11, 1234, 'AlbumArtSmall.jpg', 0),
(4, 'sawafff', 'sawaf4@yahoo.com', 'e10adc3949ba59abbe56e057f20f883e', 12, 123, '', 0),
(9, 'maii', 'mai@yahoo.com', 'fcea920f7412b5da7be0cf42b8c93759', 12, 112, 'Penguins.jpg', 0),
(10, 'mai', 'sawaf@sa.com', '14e1b600b1fd579f47433b88e8d85291', 3, 33, 'Desert.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`order_id`), ADD KEY `fk_orders_users1_idx` (`users_user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
 ADD PRIMARY KEY (`product_id`), ADD KEY `fk_product_category_idx` (`category_category_id`);

--
-- Indexes for table `product_has_orders`
--
ALTER TABLE `product_has_orders`
 ADD PRIMARY KEY (`product_product_id`,`orders_order_id`), ADD KEY `fk_product_has_orders_orders1_idx` (`orders_order_id`), ADD KEY `fk_product_has_orders_product1_idx` (`product_product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
MODIFY `category_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
MODIFY `order_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
MODIFY `product_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
ADD CONSTRAINT `fk_orders_users1` FOREIGN KEY (`users_user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_category_id`) REFERENCES `category` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_has_orders`
--
ALTER TABLE `product_has_orders`
ADD CONSTRAINT `fk_product_has_orders_orders1` FOREIGN KEY (`orders_order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_product_has_orders_product1` FOREIGN KEY (`product_product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
