-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2024 at 01:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flowershop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `price` int(20) NOT NULL,
  `qty` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `subject`, `message`) VALUES
('hq6gl7KZyaoOwOpLlCVB', 'Gov1pwlO4zl39dGS4ipv', 'usersHoangVan', 'userHoangVan@gmail.com', 'Hoa cưới', 'Sản phẩm đẹp, rất ưng ý, Shop 10đ không có nhưng.');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `seller_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `address_type` varchar(10) NOT NULL,
  `method` varchar(50) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` int(20) NOT NULL,
  `qty` int(2) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'Đang xử lí',
  `payment_status` varchar(200) NOT NULL DEFAULT 'Đang xử lí',
  `product_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `seller_id`, `name`, `number`, `email`, `address`, `address_type`, `method`, `product_id`, `price`, `qty`, `date`, `status`, `payment_status`, `product_image`) VALUES
('PYRho2i1Sz4ND6NgC3M7', 'Gov1pwlO4zl39dGS4ipv', '7qTXNYIwcXzcQj7Whvo4', 'Thọ', 389597728, 'thoaaa@gmail.com', 'lê thị riêng, duong le quy don, HCM, Việt Nam, 70000', 'home', 'cash on delivery', 'tQCBXD12muxD8dKaUyYc', 440, 1, '2024-12-30', 'Đã Hủy', 'Hoàn thành', NULL),
('uTl5zHyWu50vMrm81ma4', 'Gov1pwlO4zl39dGS4ipv', '7qTXNYIwcXzcQj7Whvo4', 'Hoàng Văn', 348751185, 'userHoangVan@gmail.com', '74 võ văn tần, Võ Thị Sáu, HCM, Việt Nam, 70000', 'home', 'cash on delivery', 'JXodyF4DJ3KfiknjFZm1', 440, 1, '2024-12-30', 'Đã Nhận', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` varchar(20) NOT NULL,
  `seller_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `stock` int(100) NOT NULL,
  `product_detail` varchar(1000) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `name`, `price`, `image`, `stock`, `product_detail`, `status`) VALUES
('0bi6UEnfthmvSgcw9nFp', '7qTXNYIwcXzcQj7Whvo4', 'Bó hoa hồng xanh', 370, 'prd6.png', 9, 'Bó Hoa hồng xanh giấy kính gồm\r\n- Hồng Xanh mix Hồng 5 bông\r\n- Cát tường trắng\r\n- Hoa và lá phụ\r\n\r\nKích thước: Cao 50 cm, Ngang 30 cm\r\nđẹp quá', 'active'),
('flkbuFwAbytOoq1xPpfI', '7qTXNYIwcXzcQj7Whvo4', 'Giỏ hoa gấu trắng', 599, 'prd12.png', 9, 'Giỏ hoa gấu trắng gồm:\r\nHoa baby\r\nHoa cúc tana\r\nHoa cát tường\r\nThiệp và banner\r\nKích thước: Cao 25 cm, Ngang 20 cm', 'active'),
('GbYJZy178pGdZCL1DkV0', '7qTXNYIwcXzcQj7Whvo4', 'hoa sinh gấu hồng', 550, 'prd1.png', 5, 'Bó hoa độc lạ gấu hồng gồm:\r\nHoa baby\r\nCúc ping pong\r\nHoa lá phụ\r\nThiệp và banner\r\nKích thước: Cao 55 cm, Ngang 35 cm', 'active'),
('I3QxfARppUrAtPhRRtjh', '7qTXNYIwcXzcQj7Whvo4', 'Bó hoa hồng đỏ', 120, 'prd2.png', 4, 'Bó hoa gồm : \r\n50 bông hoa hồng đỏ\r\nHoa baby trắng\r\nGiấy gói Hàn Quốc\r\nPhụ liệu và nơ trang trí\r\nMiễn phí banner và thiệp \r\nKích thước: Cao 120 cm, Ngang 60 cm', 'active'),
('jFL9uqluJImh5hfTuYgz', '7qTXNYIwcXzcQj7Whvo4', 'Hoa baby màu tím', 440, 'prd5.png', 6, 'Bó hoa baby hình trái tim màu tím gồm:\r\nBaby tươi\r\nGiấy và phụ liệu\r\nKích thước: Cao 65 cm, Ngang 40 cm', 'active'),
('JXodyF4DJ3KfiknjFZm1', '7qTXNYIwcXzcQj7Whvo4', 'Bó baby hồng nhỏ', 440, 'prd10.png', 9, 'Bó baby hồng gồm:\r\nHoa baby hồng\r\nGiấy trắng\r\nNơ và phụ liệu\r\nKích thước: Cao 75 cm, Ngang 45 cm', 'active'),
('kBeyMt6lAG4yZK2NEsOb', '7qTXNYIwcXzcQj7Whvo4', 'Hoa CSPM1D', 2900, '15493_hi-vong-xanh.jpg', 3, 'Nguyễn Hoàng Văn , Đặng văn Hoàng, Thầy Nguyễn Thiện Phúc', 'active'),
('LB7qrrBYovYAEJSEprc0', '7qTXNYIwcXzcQj7Whvo4', 'Bó hồng lạc thần', 600, 'prd3.png', 3, 'Bó hồng lạc thần 13 bông mix cúc tana gồm:\r\n15 hoa hồng lạc thần\r\n\r\nCúc tana\r\n\r\nHoa lá phụ\r\n\r\nGiấy và nơ hàn quốc\r\n\r\nKích thước: Cao 55 cm, Ngang 40 cm', 'active'),
('ntQff9Mf8eDCt45A2IQP', '7qTXNYIwcXzcQj7Whvo4', 'Bó Hoa Kem Tím', 600, 'prd11.png', 7, 'Bó hoa gồm: \r\n Hồng Kem\r\n Hồng Tím\r\nBaby Trắng\r\nLá và phụ liệu\r\nNơ, giấy lụa( Hàn Quốc) \r\nKích thước: Cao 55 cm, Ngang 40 cm', 'active'),
('poM3qxC5CNaziGSlUy9Y', '7qTXNYIwcXzcQj7Whvo4', 'Hoa hồng tặng mẹ', 850, 'prd9.png', 8, 'Lẵng Hoa Hồng tặng mẹ gồm:\r\nHồng Da\r\nHồng Xanh \r\nCẩm tú cầu\r\nCát tường \r\nHoa lá phụ\r\nKích thước: Cao 60 cm, Ngang 55 cm', 'active'),
('tQCBXD12muxD8dKaUyYc', '7qTXNYIwcXzcQj7Whvo4', 'Giỏ hoa hồng pastel', 440, 'prd7.png', 6, 'Giỏ hoa hồng pastel tặng sinh nhật bạn gồm:\r\nHoa hồng da pastel\r\nHoa cát tường', 'active'),
('Z8mHgXcCUM0kbvJZKIBI', '7qTXNYIwcXzcQj7Whvo4', 'Hoa baby xanh dương', 550, 'prd4.png', 6, 'Bó hoa gồm có : \r\nHoa baby xanh dương\r\nGiấy gói Hàn Quốc\r\nPhụ liệu và nơ trang trí\r\nMiễn phí banner và thiệp chúc mừng\r\nKích thước: Cao 65 cm, Ngang 40 cm', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE `responses` (
  `id` int(11) NOT NULL,
  `message_id` varchar(20) NOT NULL,
  `response` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `responses`
--

INSERT INTO `responses` (`id`, `message_id`, `response`, `created_at`) VALUES
(4, 'hq6gl7KZyaoOwOpLlCVB', 'Cảm ơn bạn đã quan tâm. chúc bạn một ngày mới vui vẻ!', '2024-12-30 11:41:44');

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `name`, `email`, `password`, `image`) VALUES
('6EK646s2IrjYLR7Y2vgc', 'Thọ', 'admin04@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '0E2xvTvrW520QpS5max6.png'),
('7qTXNYIwcXzcQj7Whvo4', 'Hoangvan', 'hoanggvan1177@gmail.com', '123456', 'JQapwteN1E4FD9ak4W8F.webp');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `created_at`) VALUES
(18, 'QueTran@gmail.com', '2024-12-30 11:32:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`) VALUES
('Gov1pwlO4zl39dGS4ipv', 'Hoang Van', 'userHoangVan@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'DnIhJ8bWs6iLyT31tKpr.png');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `price`) VALUES
('LxhWoIbJjg11ODBUCzQy', 'Gov1pwlO4zl39dGS4ipv', '0bi6UEnfthmvSgcw9nFp', '370');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `responses`
--
ALTER TABLE `responses`
  ADD CONSTRAINT `responses_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `message` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
