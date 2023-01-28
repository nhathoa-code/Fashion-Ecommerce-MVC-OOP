-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 28, 2023 lúc 05:41 PM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ecommerce_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 0,
  `token` varchar(100) DEFAULT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`id`, `email`, `password`, `role`, `is_active`, `token`, `created_on`) VALUES
(15, 'nhathoa530@gmail.com', '$2y$10$Ohko1s/ScUQo87WiAK3GbupK318.9qaXAsImjFPhS6Is3zxRgrSFC', 0, 1, NULL, '2022-12-31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`category_id`, `name`, `parent_id`, `slug`) VALUES
(65, 'NAM', 0, 'nam'),
(67, 'ÁO', 65, 'ao'),
(68, 'Áo Thun', 67, 'ao-thun'),
(69, 'QUẦN', 65, 'quan'),
(71, 'Quần Jean', 69, 'quan-jean'),
(72, 'NỮ', 0, 'nu'),
(73, 'ÁO', 72, 'ao'),
(74, 'QUẦN', 72, 'quan'),
(76, 'Áo Thun', 73, 'ao-thun'),
(77, 'Áo Len', 73, 'ao-len'),
(78, 'Quần Jeans', 74, 'quan-jeans'),
(79, 'Áo Sơ Mi', 67, 'ao-so-mi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp(),
  `shipped_on` date DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `pay_status` varchar(255) NOT NULL,
  `payment` varchar(100) NOT NULL,
  `note` text DEFAULT '',
  `fullname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `subtotal` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `account_id`, `created_on`, `shipped_on`, `status`, `pay_status`, `payment`, `note`, `fullname`, `address`, `email`, `phone_number`, `subtotal`) VALUES
(58, 15, '2023-01-28', '2023-01-28', 'Đã giao', 'Đã thanh toán | MGD:13929120', 'VNPay', 'abc...', 'anonymous', '123, Phường Bình Trị Đông, Quận Bình Tân, Thành phố Hồ Chí Minh', 'hoa@gmail.com', 912345672, 1291000),
(59, 15, '2023-01-28', '2023-01-28', 'Đã giao', 'Đã thanh toán', 'COD', 'abc...', 'anonymous', '123, Phường Bình Trị Đông, Quận Bình Tân, Thành phố Hồ Chí Minh', 'hoa@gmail.com', 912345672, 535000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  `size` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `color`, `size`, `quantity`, `unit_price`) VALUES
(103, 58, 130, 'http://localhost/ecommerce/content/images/1672153154/colors/vngoods_69_453626.jpg', 'L', 1, 293000),
(104, 58, 153, 'http://localhost/ecommerce/content/images/1674482110/colors/vngoods_66_453175.jpg', 'S', 1, 499000),
(105, 58, 153, 'http://localhost/ecommerce/content/images/1674482110/colors/vngoods_12_453175.jpg', 'XL', 1, 499000),
(106, 59, 121, 'http://localhost/ecommerce/content/images/1667125858/colors/goods_02_422992.jpg', 'L', 1, 144000),
(107, 59, 128, 'http://localhost/ecommerce/content/images/1671205695/colors/vngoods_456149_sub3.jpg', 'M', 1, 391000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `discounted_price` int(11) NOT NULL,
  `dir` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `new` tinyint(4) NOT NULL DEFAULT 0,
  `featured` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `discounted_price`, `dir`, `slug`, `new`, `featured`) VALUES
(121, 'Áo Thun Cổ Tròn Ngắn Tay', '<p><span style=\"color:rgb(27, 27, 27); font-family:helvetica neue,helveticaneue,helvetica,noto sans,roboto,arial,hiragino sans,hiragino kaku gothic pro,ヒラギノ角ゴ  pro w3,noto sans cjk jp,osaka,meiryo,メイリオ,ms pgothic,ｍｓ  ｐゴシック,hiragino sans gb,arial unicode ms,sans-serif; font-size:16px\">Designed with meticulous attention to detail and a stylish cut.</span></p>\r\n', 244000, 100000, '1667125858', 'ao-thun-co-tron-ngan-tay', 1, 0),
(128, 'Áo Thun Dáng Rộng Cổ Tròn Tay Lỡ', '<p><span style=\"color:rgb(27, 27, 27); font-family:helvetica neue,helveticaneue,helvetica,noto sans,roboto,arial,hiragino sans,hiragino kaku gothic pro,ヒラギノ角ゴ  pro w3,noto sans cjk jp,osaka,meiryo,メイリオ,ms pgothic,ｍｓ  ｐゴシック,hiragino sans gb,arial unicode ms,sans-serif; font-size:16px\">&Aacute;o thun d&aacute;ng rộng với chất liệu vải bền v&agrave; kiểu đơn giản.</span></p>\r\n', 391000, 0, '1671205695', 'ao-thun-dang-rong-co-tron-tay-lo', 1, 0),
(129, 'Quần Jeans Slim Fit', '<p><span style=\"color:rgb(27, 27, 27); font-family:helvetica neue,helveticaneue,helvetica,noto sans,roboto,arial,hiragino sans,hiragino kaku gothic pro,ヒラギノ角ゴ  pro w3,noto sans cjk jp,osaka,meiryo,メイリオ,ms pgothic,ｍｓ  ｐゴシック,hiragino sans gb,arial unicode ms,sans-serif; font-size:16px\">Chất liệu vải denim c&oacute; th&ecirc;m độ co gi&atilde;n. Quần jean của ch&uacute;ng t&ocirc;i kết hợp giữa phong c&aacute;ch v&agrave; sự thoải m&aacute;i.</span></p>\n', 980000, 0, '1671285944', 'quan-jeans-slim-fit', 1, 1),
(130, 'Áo Thun Kẻ Sọc Cổ Tròn Dài Tay', '<p><span style=\"color:rgb(27, 27, 27); font-family:helvetica neue,helveticaneue,helvetica,noto sans,roboto,arial,hiragino sans,hiragino kaku gothic pro,ヒラギノ角ゴ  pro w3,noto sans cjk jp,osaka,meiryo,メイリオ,ms pgothic,ｍｓ  ｐゴシック,hiragino sans gb,arial unicode ms,sans-serif; font-size:16px\">&Aacute;o thun cotton 100% bền đẹp. Kẻ sọc rộng tạo cảm gi&aacute;c giản dị.</span></p>\r\n', 489000, 196000, '1672153154', 'ao-thun-ke-soc-co-tron-dai-tay', 1, 0),
(140, 'AIRism Cotton Áo Thun Cổ Tròn Dáng Rộng', '<p><span style=\"color:rgb(27, 27, 27); font-family:helvetica neue,helveticaneue,helvetica,noto sans,roboto,arial,hiragino sans,hiragino kaku gothic pro,ヒラギノ角ゴ  pro w3,noto sans cjk jp,osaka,meiryo,メイリオ,ms pgothic,ｍｓ  ｐゴシック,hiragino sans gb,arial unicode ms,sans-serif; font-size:16px\">Chất liệu với bề mặt của cotton c&ugrave;ng hiệu năng m&aacute;t mẻ của &quot;AIRism&quot;. Đường viền cổ &aacute;o hẹp tạo phong c&aacute;ch gọn g&agrave;ng, sạch sẽ.</span></p>\r\n', 391000, 0, '1672237119', 'airism-cotton-ao-thun-co-tron-dang-rong', 1, 0),
(141, 'Áo Thun Cotton Cổ Tròn Dài Tay', '<p><span style=\"color:rgb(27, 27, 27); font-family:helvetica neue,helveticaneue,helvetica,noto sans,roboto,arial,hiragino sans,hiragino kaku gothic pro,ヒラギノ角ゴ  pro w3,noto sans cjk jp,osaka,meiryo,メイリオ,ms pgothic,ｍｓ  ｐゴシック,hiragino sans gb,arial unicode ms,sans-serif; font-size:16px\">Deceptively simple look with attention to detail on material and silhouette. Chest pocket so this can be worn on its own.</span></p>\r\n', 489000, 0, '1672237745', 'ao-thun-cotton-co-tron-dai-tay', 1, 1),
(143, 'Quần Jean Skinny Fit Siêu Co Giãn', '<p><span style=\"color:rgb(27, 27, 27); font-family:helvetica neue,helveticaneue,helvetica,noto sans,roboto,arial,hiragino sans,hiragino kaku gothic pro,ヒラギノ角ゴ  pro w3,noto sans cjk jp,osaka,meiryo,メイリオ,ms pgothic,ｍｓ  ｐゴシック,hiragino sans gb,arial unicode ms,sans-serif; font-size:16px\">Độ co gi&atilde;n đ&aacute;ng ngạc nhi&ecirc;n mang đến vẻ ngo&agrave;i thời trang nhưng vẫn thoải m&aacute;i. D&aacute;ng skinny fit &ocirc;m vừa vặn dễ chịu.</span></p>\n', 980000, 196000, '1672238913', 'quan-jean-skinny-fit-sieu-co-gian', 1, 1),
(144, 'AIRism Áo Thun Dáng Dài Không Đường May', '<p><span style=\"color:rgb(27, 27, 27); font-family:helvetica neue,helveticaneue,helvetica,noto sans,roboto,arial,hiragino sans,hiragino kaku gothic pro,ヒラギノ角ゴ  pro w3,noto sans cjk jp,osaka,meiryo,メイリオ,ms pgothic,ｍｓ  ｐゴシック,hiragino sans gb,arial unicode ms,sans-serif; font-size:16px\">Smooth and silky AIRism. Natural texture is perfect for a variety of styles.</span></p>\r\n', 399000, 0, '1674048278', 'airism-ao-thun-dang-dai-khong-duong-may', 1, 1),
(146, 'Áo Len Cổ Giả Sợi Souffle Nhẹ', '<p><span style=\"color:rgb(27, 27, 27); font-family:helvetica neue,helveticaneue,helvetica,noto sans,roboto,arial,hiragino sans,hiragino kaku gothic pro,ヒラギノ角ゴ  pro w3,noto sans cjk jp,osaka,meiryo,メイリオ,ms pgothic,ｍｓ  ｐゴシック,hiragino sans gb,arial unicode ms,sans-serif; font-size:16px\">Sợi souffle mềm mịn, kh&ocirc;ng g&acirc;y ngứa. Th&acirc;n v&agrave; tay &aacute;o d&agrave;y dặn tạo vẻ mềm mại.</span></p>\r\n', 799000, 100000, '1674356301', 'ao-len-co-gia-soi-souffle-nhe', 1, 1),
(153, 'Áo Sơ Mi Vải Dạ Kẻ Caro Dài Tay', '<p><span style=\"color:rgb(27, 27, 27); font-family:helvetica neue,helveticaneue,helvetica,noto sans,roboto,arial,hiragino sans,hiragino kaku gothic pro,ヒラギノ角ゴ  pro w3,noto sans cjk jp,osaka,meiryo,メイリオ,ms pgothic,ｍｓ  ｐゴシック,hiragino sans gb,arial unicode ms,sans-serif; font-size:16px\">Vải flannel d&agrave;y hơn, vừa vặn, c&oacute; thể tự tạo kiểu ho&agrave;n hảo hoặc l&agrave;m lớp ngo&agrave;i.</span></p>\r\n', 699000, 200000, '1674482110', 'ao-so-mi-vai-da-ke-caro-dai-tay', 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_category`
--

CREATE TABLE `product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `product_category`
--

INSERT INTO `product_category` (`product_id`, `category_id`) VALUES
(121, 65),
(121, 67),
(121, 68),
(128, 65),
(128, 67),
(128, 68),
(129, 65),
(129, 69),
(129, 71),
(130, 65),
(130, 67),
(130, 68),
(140, 65),
(140, 67),
(140, 68),
(141, 65),
(141, 67),
(141, 68),
(143, 65),
(143, 69),
(143, 71),
(144, 72),
(144, 73),
(144, 76),
(146, 72),
(146, 73),
(146, 77),
(153, 65),
(153, 67),
(153, 79);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_color`
--

CREATE TABLE `product_color` (
  `id` int(11) NOT NULL,
  `image_color` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `product_color`
--

INSERT INTO `product_color` (`id`, `image_color`, `product_id`, `size_id`) VALUES
(50, 'goods_02_422992.jpg', 121, 8),
(61, 'goods_02_422992.jpg', 121, 9),
(62, 'goods_02_422992.jpg', 121, 10),
(63, 'goods_02_422992.jpg', 121, 11),
(64, 'goods_22_422992.jpg', 121, 9),
(65, 'goods_22_422992.jpg', 121, 10),
(66, 'goods_22_422992.jpg', 121, 8),
(67, 'vngoods_55_456150.jpg', 128, 8),
(68, 'vngoods_55_456150.jpg', 128, 9),
(69, 'vngoods_55_456150.jpg', 128, 10),
(70, 'vngoods_55_456150.jpg', 128, 11),
(71, 'vngoods_456149_sub3.jpg', 128, 8),
(72, 'vngoods_456149_sub3.jpg', 128, 9),
(73, 'vngoods_456149_sub3.jpg', 128, 10),
(74, 'vngoods_456149_sub3.jpg', 128, 11),
(75, 'vngoods_62_452524.jpg', 129, 18),
(76, 'vngoods_62_452524.jpg', 129, 20),
(77, 'vngoods_62_452524.jpg', 129, 21),
(78, 'vngoods_62_452524.jpg', 129, 23),
(79, 'vngoods_62_452524.jpg', 129, 24),
(80, 'vngoods_62_452524.jpg', 129, 25),
(81, 'vngoods_62_452524.jpg', 129, 26),
(82, 'vngoods_63_452524.jpg', 129, 18),
(83, 'vngoods_63_452524.jpg', 129, 19),
(84, 'vngoods_63_452524.jpg', 129, 20),
(85, 'vngoods_63_452524.jpg', 129, 21),
(86, 'vngoods_63_452524.jpg', 129, 22),
(87, 'vngoods_63_452524.jpg', 129, 23),
(88, 'vngoods_63_452524.jpg', 129, 24),
(89, 'vngoods_63_452524.jpg', 129, 25),
(90, 'vngoods_63_452524.jpg', 129, 26),
(99, 'vngoods_69_453626.jpg', 130, 8),
(100, 'vngoods_69_453626.jpg', 130, 9),
(101, 'vngoods_69_453626.jpg', 130, 10),
(102, 'vngoods_69_453626.jpg', 130, 11),
(103, 'vngoods_453626_sub1.jpg', 130, 9),
(126, 'vngoods_22_455404.jpg', 141, 8),
(127, 'vngoods_22_455404.jpg', 141, 9),
(128, 'vngoods_22_455404.jpg', 141, 10),
(129, 'vngoods_22_455404.jpg', 141, 11),
(130, 'vngoods_22_455404.jpg', 141, 27),
(131, 'vngoods_09_425974.jpg', 140, 10),
(132, 'vngoods_09_425974.jpg', 140, 11),
(133, 'vngoods_09_425974.jpg', 140, 27),
(134, 'goods_22_456265.jpg', 144, 8),
(135, 'goods_22_456265.jpg', 144, 9),
(136, 'goods_22_456265.jpg', 144, 10),
(137, 'goods_22_456265.jpg', 144, 11),
(138, 'goods_22_456265.jpg', 144, 27),
(139, 'goods_54_456265.jpg', 144, 8),
(140, 'goods_54_456265.jpg', 144, 9),
(141, 'goods_54_456265.jpg', 144, 10),
(142, 'goods_54_456265.jpg', 144, 11),
(143, 'goods_54_456265.jpg', 144, 27),
(144, 'goods_61_456265.jpg', 144, 8),
(145, 'goods_61_456265.jpg', 144, 9),
(146, 'goods_61_456265.jpg', 144, 10),
(147, 'goods_61_456265.jpg', 144, 11),
(148, 'goods_61_456265.jpg', 144, 27),
(149, 'vngoods_01_452388.jpg', 146, 8),
(150, 'vngoods_01_452388.jpg', 146, 9),
(151, 'vngoods_01_452388.jpg', 146, 10),
(152, 'vngoods_01_452388.jpg', 146, 11),
(153, 'vngoods_01_452388.jpg', 146, 27),
(156, 'vngoods_66_453175.jpg', 153, 8),
(157, 'vngoods_66_453175.jpg', 153, 9),
(158, 'vngoods_12_453175.jpg', 153, 9),
(159, 'vngoods_12_453175.jpg', 153, 8),
(160, 'vngoods_12_453175.jpg', 153, 10),
(161, 'vngoods_12_453175.jpg', 153, 11),
(162, 'vngoods_12_453175.jpg', 153, 27),
(163, 'vngoods_09_455404.jpg', 141, 8),
(164, 'vngoods_09_455404.jpg', 141, 9),
(165, 'vngoods_09_455404.jpg', 141, 10),
(166, 'vngoods_09_455404.jpg', 141, 11),
(167, 'vngoods_09_455404.jpg', 141, 27),
(168, 'vngoods_00_455404.jpg', 141, 8),
(169, 'vngoods_00_455404.jpg', 141, 9),
(170, 'vngoods_00_455404.jpg', 141, 10),
(171, 'vngoods_00_455404.jpg', 141, 11),
(172, 'vngoods_00_455404.jpg', 141, 27);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_size_type`
--

CREATE TABLE `product_size_type` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `product_size_type`
--

INSERT INTO `product_size_type` (`id`, `product_id`, `size_type_id`) VALUES
(6, 121, 3),
(12, 128, 3),
(13, 129, 6),
(14, 130, 3),
(24, 140, 3),
(25, 141, 3),
(26, 143, 3),
(27, 144, 3),
(28, 146, 3),
(35, 153, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `save_to_deli_info` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `profile`
--

INSERT INTO `profile` (`id`, `account_id`, `username`, `fullname`, `email`, `phone`, `address`, `save_to_deli_info`) VALUES
(4, 15, 'corona', 'anonymous', 'hoa@gmail.com', '0912345672', '{\"dia_chi\":\"123\",\"phuong_xa\":\"Phường Bình Trị Đông\",\"quan_huyen\":\"Quận Bình Tân\",\"tinh_thanh\":\"Thành phố Hồ Chí Minh\"}', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `account_id` int(1) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `rate` smallint(6) NOT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `review`
--

INSERT INTO `review` (`id`, `account_id`, `product_id`, `name`, `content`, `rate`, `created_on`) VALUES
(37, 15, 141, 'corona', 'abc...', 5, '2023-01-27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` int(100) NOT NULL,
  `size` varchar(10) NOT NULL,
  `color` varchar(255) NOT NULL,
  `added_on` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `size_type`
--

CREATE TABLE `size_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `size_type`
--

INSERT INTO `size_type` (`id`, `name`) VALUES
(3, 'Size'),
(6, 'Inch');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `size_value`
--

CREATE TABLE `size_value` (
  `id` int(11) NOT NULL,
  `size_type_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `size_value`
--

INSERT INTO `size_value` (`id`, `size_type_id`, `value`) VALUES
(8, 3, 'XS'),
(9, 3, 'S'),
(10, 3, 'M'),
(11, 3, 'L'),
(18, 6, '27 inch'),
(19, 6, '28 inch'),
(20, 6, '29 inch'),
(21, 6, '30 inch'),
(22, 6, '31 inch'),
(23, 6, '32 inch'),
(24, 6, '33 inch'),
(25, 6, '34 inch'),
(26, 6, '35 inch'),
(27, 3, 'XL');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `title1` varchar(100) DEFAULT NULL,
  `content` varchar(255) NOT NULL,
  `button` varchar(100) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `slider`
--

INSERT INTO `slider` (`id`, `image`, `title`, `title1`, `content`, `button`, `link`) VALUES
(15, 'slider1.jpg', 'tieu de 1', 'tieu de 2', 'noi dung 1', 'Mua Ngay', '/ecommerce'),
(20, 'slider2.jpg', 'tieu de 2', 'tieu de 2', 'noi dung 2', 'Mua Ngay', '/ecommerce'),
(21, 'slider3.jpg', 'tieu de 3', 'tieu de 3', 'noi dung 3', 'Mua Ngay', '/ecommerce');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_order` (`account_id`);

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order` (`order_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_id`,`category_id`),
  ADD KEY `category` (`category_id`);

--
-- Chỉ mục cho bảng `product_color`
--
ALTER TABLE `product_color`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_color` (`product_id`),
  ADD KEY `color_size` (`size_id`);

--
-- Chỉ mục cho bảng `product_size_type`
--
ALTER TABLE `product_size_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `size_type_id` (`size_type_id`);

--
-- Chỉ mục cho bảng `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_profile` (`account_id`);

--
-- Chỉ mục cho bảng `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_review` (`product_id`),
  ADD KEY `account_review` (`account_id`);

--
-- Chỉ mục cho bảng `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopping_cart_product` (`product_id`),
  ADD KEY `shopping_cart_account` (`account_id`);

--
-- Chỉ mục cho bảng `size_type`
--
ALTER TABLE `size_type`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `size_value`
--
ALTER TABLE `size_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `size_type_value` (`size_type_id`);

--
-- Chỉ mục cho bảng `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT cho bảng `product_color`
--
ALTER TABLE `product_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT cho bảng `product_size_type`
--
ALTER TABLE `product_size_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT cho bảng `size_type`
--
ALTER TABLE `size_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `size_value`
--
ALTER TABLE `size_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `customer_order` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product_color`
--
ALTER TABLE `product_color`
  ADD CONSTRAINT `color_size` FOREIGN KEY (`size_id`) REFERENCES `size_value` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_color` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product_size_type`
--
ALTER TABLE `product_size_type`
  ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `size_type_id` FOREIGN KEY (`size_type_id`) REFERENCES `size_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `account_profile` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `account_review` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`),
  ADD CONSTRAINT `product_review` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_account` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shopping_cart_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `size_value`
--
ALTER TABLE `size_value`
  ADD CONSTRAINT `size_type_value` FOREIGN KEY (`size_type_id`) REFERENCES `size_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
