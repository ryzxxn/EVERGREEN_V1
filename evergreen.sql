-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2023 at 06:49 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evergreen`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `blog_id` char(36) NOT NULL,
  `blogCreator_id` char(36) NOT NULL,
  `blogCreator_name` varchar(255) NOT NULL,
  `blog_title` varchar(255) DEFAULT NULL,
  `blog_content` text DEFAULT NULL,
  `blog_rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`blog_id`, `blogCreator_id`, `blogCreator_name`, `blog_title`, `blog_content`, `blog_rating`) VALUES
('042003f9-8a88-11ee-9dfa-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', 'Elton', 'The Power of Green: How Plants Boost Your Mood and Productivity', 'In this in-depth exploration, we delve into the multifaceted world of biophilia, examining how exposure to nature, specifically through plants, positively impacts mental health and productivity. Backed by scientific studies, we\'ll uncover the psychological benefits of cultivating indoor green spaces, discussing not only stress reduction but also increased creativity and focus. This comprehensive guide will include practical tips on selecting and caring for specific indoor plants renowned for their mood-enhancing qualities.', 0),
('0b004b4c-8a88-11ee-9dfa-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', 'Elton', 'Plant Parenthood: A Comprehensive Guide to Indoor Gardening', 'This extensive guide is tailored for both novice and experienced gardeners alike, offering a step-by-step journey into the art of indoor gardening. From understanding the nuances of light and soil requirements to mastering the art of propagation and troubleshooting common issues, this blog provides an all-encompassing resource for cultivating a thriving indoor garden. Expect detailed plant profiles, care calendars, and innovative design ideas for transforming your living space into a lush haven.', 0),
('1c33564e-8a88-11ee-9dfa-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', 'Elton', 'The Language of Flowers: Decoding Your Plants\' Communication', 'In this thorough exploration, we not only scratch the surface but dive deep into the intricate language of plants. Beyond the basics of wilting leaves and changing colors, we\'ll explore lesser-known signals, such as leaf positioning and root behavior, helping you decipher your plants\' nuanced communication. With practical advice on responsive care, this blog equips you with the knowledge to foster a symbiotic relationship with your green companions.', 0),
('d1631b5f-8a88-11ee-9dfa-50ebf6b6af3a', 'b8477aeb-8a88-11ee-9dfa-50ebf6b6af3a', 'Rowan', 'Sustainable Gardening: Cultivating an Eco-Friendly Paradise', 'Elevate your gardening practices with this comprehensive guide to sustainable gardening. From implementing rainwater harvesting systems to embracing permaculture principles, we\'ll explore a wide range of eco-conscious techniques. This blog will empower you to create a garden that not only flourishes aesthetically but also contributes positively to the broader ecosystem, fostering biodiversity and resilience in the face of environmental challenges.', 0),
('d7f408cd-8a88-11ee-9dfa-50ebf6b6af3a', 'b8477aeb-8a88-11ee-9dfa-50ebf6b6af3a', 'Rowan', 'Marvels of Adaptation: Plants That Thrive in Unusual Environments', 'Take an awe-inspiring journey into the world of extremophyte plants that have evolved to thrive in seemingly inhospitable environments. We\'ll delve into the biology and ecology of these remarkable species, showcasing their unique adaptations. From succulents in arid deserts to underwater wonders, this blog will highlight the resilience and diversity found in nature.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `cart_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`cart_content`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `cart_content`) VALUES
('655f81f15a879', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', '[]'),
('656031db54ec3', 'b8477aeb-8a88-11ee-9dfa-50ebf6b6af3a', '[]');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `order_id` varchar(36) NOT NULL,
  `customer_id` varchar(36) DEFAULT NULL,
  `seller_id` varchar(255) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `seller_first_name` varchar(255) NOT NULL,
  `seller_last_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`order_id`, `customer_id`, `seller_id`, `pid`, `seller_first_name`, `seller_last_name`) VALUES
('78f34aed-8a36-11ee-9741-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', 4, 'Elton', 'Costa'),
('922e4637-8a36-11ee-9741-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', 4, 'Elton', 'Costa'),
('9d57243a-8a36-11ee-9741-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', 6, 'Elton', 'Costa');

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `list_id` char(36) NOT NULL,
  `seller_id` char(36) NOT NULL,
  `pid` int(11) NOT NULL,
  `list_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lists`
--

INSERT INTO `lists` (`list_id`, `seller_id`, `pid`, `list_date`) VALUES
('2e72a6ec-8a36-11ee-9741-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', 3, '2023-11-23'),
('3c925a83-8a36-11ee-9741-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', 4, '2023-11-23'),
('5568d5b1-8a36-11ee-9741-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', 5, '2023-11-23'),
('6393dfc2-8a36-11ee-9741-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', 6, '2023-11-23'),
('942a3a37-8a89-11ee-9dfa-50ebf6b6af3a', 'b8477aeb-8a88-11ee-9dfa-50ebf6b6af3a', 7, '2023-11-24'),
('a82e5634-8a89-11ee-9dfa-50ebf6b6af3a', 'b8477aeb-8a88-11ee-9dfa-50ebf6b6af3a', 8, '2023-11-24');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` char(36) NOT NULL,
  `customer_id` char(36) NOT NULL,
  `order_date` date NOT NULL,
  `order_price` varchar(255) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `order_date`, `order_price`, `pid`) VALUES
('78f34aed-8a36-11ee-9741-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', '2023-11-24', '420', 4),
('922e4637-8a36-11ee-9741-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', '2023-11-24', '20', 4),
('9d57243a-8a36-11ee-9741-50ebf6b6af3a', 'd029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', '2023-11-24', '400', 6);

--
-- Triggers `orders`
--
DELIMITER $$
CREATE TRIGGER `after_order_insert` AFTER INSERT ON `orders` FOR EACH ROW BEGIN
    DECLARE seller_id VARCHAR(255);
    DECLARE first_name VARCHAR(255);
    DECLARE last_name VARCHAR(255);
    DECLARE p_id INT;

    -- Get seller_id from lists table based on pid in orders table
    SELECT lists.seller_id, lists.pid INTO seller_id, p_id
    FROM lists
    WHERE lists.pid = NEW.pid;

    -- Get seller's first name and last name from user table based on seller_id
    SELECT users.firstname, users.lastname INTO first_name, last_name
    FROM users
    WHERE users.uid = seller_id;

    -- Update data table with information from orders, lists, and user tables
    INSERT INTO data (order_id, customer_id, pid, seller_id, seller_first_name, seller_last_name)
    VALUES (NEW.order_id, NEW.customer_id, NEW.pid, seller_id, first_name, last_name);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_description` varchar(255) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `product_price` int(11) DEFAULT NULL,
  `product_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_quantity`, `product_price`, `product_url`) VALUES
(3, 'potato', 'vegetable', 100, 8, 'https://cdn.discordapp.com/attachments/1170259812932665406/1177329309988438077/download.jpeg?ex=65721c5d&is=655fa75d&hm=9c4f3fb360bd5dc5538c1b77dba54f714cade3f0a7bb3a8d79c476df5899308f&'),
(4, 'avacado', 'a green fruit', 46, 20, 'https://cdn.discordapp.com/attachments/1170259812932665406/1177329409364078592/Avocados-3d84a3a.jpg?ex=65721c74&is=655fa774&hm=773f1931b20de0811ca6c27d7104619c5604013c6bfe738c06cebab819b313f1&'),
(5, 'Tulsi', 'medeicnal plant', 0, 300, 'https://cdn.discordapp.com/attachments/1170259812932665406/1177329584732123216/360_F_501256782_h5g0cYrUwao6hpne2JxcyBlhbHORjmML.jpg?ex=65721c9e&is=655fa79e&hm=c3c9dfcb44cd9aeebea3e75548ff4475f4895aefa332811d2f89d6a45ae114bf&'),
(6, 'Aloe vera', 'medeicnal plant', 46, 400, 'https://cdn.discordapp.com/attachments/1170259812932665406/1177329683759640667/natural-aloe-vera-leaf.jpg?ex=65721cb6&is=655fa7b6&hm=706be09d173b9574e9aa1c33e3d9f36c73e52c8c5cc8dd992cf2970293921b60&'),
(7, 'Rose', 'A flower', 20, 50, 'https://cdn.discordapp.com/attachments/1170259812932665406/1177479541510373396/rose.jpeg?ex=6572a847&is=65603347&hm=3e786dab5678835f77dab454fb00d48ff6659fcb21ca09f439f06baf74125e3a&'),
(8, 'Papaya', 'A fruit', 30, 400, 'https://cdn.discordapp.com/attachments/1170259812932665406/1177479682673872906/download_1.jpeg?ex=6572a868&is=65603368&hm=30b8cd3d3992ed01aa0c96bff1ab746cd2cdbda6b352dacabc344d94efcc2e05&');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` char(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT NULL,
  `account_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `email`, `password`, `firstname`, `lastname`, `address`, `role`, `phone`, `verified`, `account_created`) VALUES
('b8477aeb-8a88-11ee-9dfa-50ebf6b6af3a', 'rowan@gmail.com', 'hello123', 'Rowan', 'Ferrao', 'Benaulim ,pedda', 'User', 2147483647, 1, '2023-11-24'),
('d029a0df-8a1c-11ee-8e2a-50ebf6b6af3a', 'elton02costa@gmail.com', 'hello123', 'Elton', 'Costa', 'Nuvem guirim 403604', 'Admin', 2147483647, 1, '2023-11-23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blog_id`),
  ADD KEY `blogCreator_id` (`blogCreator_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`list_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`blogCreator_id`) REFERENCES `users` (`uid`);

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`);

--
-- Constraints for table `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `data_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lists`
--
ALTER TABLE `lists`
  ADD CONSTRAINT `lists_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `lists_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
