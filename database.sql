-- Cấu hình chuẩn cho tiếng Việt
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--
CREATE DATABASE IF NOT EXISTS `database` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `database`;

-- --------------------------------------------------------

--
-- 1. Bảng `users`: Lưu thông tin thành viên & Admin
--
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT 'default.png',
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dữ liệu mẫu Users
-- Mật khẩu mặc định là: 123456 (đã mã hóa)
INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `avatar`) VALUES
(1, 'Quản Trị Viên', 'admin@gmail.com', '$2y$10$RVyy1shjGVoHmzZfnl3fYO0YRC79eZlcHBM7GxEom8OEy1LXjeYVa', 'admin', 'default.png'),
(2, 'Nguyễn Văn Khách', 'khach@gmail.com', '$2y$10$RVyy1shjGVoHmzZfnl3fYO0YRC79eZlcHBM7GxEom8OEy1LXjeYVa', 'user', 'default.png');

-- --------------------------------------------------------

--
-- 2. Bảng `settings`: Cấu hình website (Role #1)
--
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_key` varchar(50) NOT NULL,
  `config_value` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `config_key` (`config_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dữ liệu mẫu Settings
INSERT INTO `settings` (`config_key`, `config_value`) VALUES
('site_logo', 'logo.png'),
('site_name', 'Công Ty Công Nghệ ABC'),
('contact_email', 'contact@abc.com'),
('contact_phone', '0909 123 456'),
('contact_address', '123 Đường Số 1, Quận 1, TP.HCM');

-- --------------------------------------------------------

--
-- 3. Bảng `contacts`: Liên hệ từ khách hàng (Role #1)
--
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','replied') DEFAULT 'new',
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 4. Bảng `faqs`: Câu hỏi thường gặp (Role #2)
--
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `order_number` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dữ liệu mẫu FAQs
INSERT INTO `faqs` (`question`, `answer`, `order_number`) VALUES
('Làm thế nào để mua hàng?', 'Bạn chỉ cần chọn sản phẩm vào giỏ hàng và tiến hành thanh toán.', 1),
('Chính sách bảo hành bao lâu?', 'Tất cả sản phẩm điện tử được bảo hành 12 tháng.', 2);

-- --------------------------------------------------------

--
-- 5. Bảng `products`: Sản phẩm (Role #3)
--
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dữ liệu mẫu Products
INSERT INTO `products` (`name`, `price`, `description`, `image`) VALUES
('Laptop Gaming Dell', 25000000, 'Laptop cấu hình mạnh mẽ cho game thủ', 'laptop.jpg'),
('iPhone 15 Pro Max', 32000000, 'Điện thoại thông minh cao cấp nhất của Apple', 'iphone.jpg'),
('Chuột Logitech', 500000, 'Chuột không dây tiện lợi', 'mouse.jpg');

-- --------------------------------------------------------

--
-- 6. Bảng `orders`: Đơn hàng (Role #3)
--
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_money` int(11) NOT NULL DEFAULT 0,
  `note` text DEFAULT NULL,
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 7. Bảng `order_details`: Chi tiết đơn hàng (Role #3)
--
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `fk_details_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_details_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 8. Bảng `news`: Tin tức (Role #4)
--
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `view_count` int(11) DEFAULT 0,
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dữ liệu mẫu News
INSERT INTO `news` (`title`, `description`, `content`, `image`) VALUES
('Thông báo nghỉ lễ 30/4', 'Lịch nghỉ lễ của công ty...', 'Nội dung chi tiết thông báo nghỉ lễ...', 'holiday.jpg'),
('Ra mắt sản phẩm mới', 'Công ty ra mắt dòng sản phẩm X...', 'Chi tiết sản phẩm mới...', 'new_product.jpg');

-- --------------------------------------------------------

--
-- 9. Bảng `comments`: Bình luận (Role #4)
--
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `status` enum('visible','hidden') DEFAULT 'visible',
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_comments_news` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;