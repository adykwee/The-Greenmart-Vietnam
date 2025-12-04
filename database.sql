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
(2, 'Khách', 'khach@gmail.com', '$2y$10$RVyy1shjGVoHmzZfnl3fYO0YRC79eZlcHBM7GxEom8OEy1LXjeYVa', 'user', 'default.png');

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
('site_name', 'The Greenmart Vietnam'),
('contact_email', 'contact@thegreenmart.com'),
('contact_phone', '0794 204 340'),
('contact_address', '268/23 Lê Văn Việt, P. Tăng Nhơn Phú B, TP. Thủ Đức, TP.HCM');

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
('Chính sách đổi trả như thế nào?', 'Khách hàng có thể đổi hàng trong một khoảng thời gian 7 ngày nếu sản phẩm lỗi do nhà sản xuất hoặc không như mô tả.', 2);

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
('Ống hút tre', 10000, 'Ống hút thân thiện với môi trường', 'bamboo_straw.jpg'),
('Bình nước giữ nhiệt tre', 120000, 'Bình nước làm từ tre tự nhiên', 'bamboo_water_bottle.jpg'),
('Túi vải tái sử dụng', 50000, 'Túi vải thân thiện với môi trường', 'fabric_bag.jpg'),
('Bút tre', 15000, 'Bút làm từ tre tự nhiên', 'bamboo_pen.jpg'),
('Khay lục bình đan thủ công', 80000, 'Khay đựng đồ làm từ lục bình', 'water_hyacinth_tray.jpg'),
('Nến thơm thiên nhiên', 60000, 'Nến làm từ sáp ong tự nhiên', 'natural_candle.jpg'),
('Làn mây đan tay', 70000, 'Làn đựng đồ làm từ mây tre', 'woven_basket.jpg'),
('Cốc tre', 20000, 'Cốc uống nước làm từ tre', 'bamboo_cup.jpg'),
('Chasen - Cây đánh trà Nhật Bản', 30000, 'Dụng cụ đánh trà truyền thống Nhật Bản', 'chasen.jpg'),
('Bàn chải đánh răng tre', 25000, 'Bàn chải thân thiện với môi trường', 'bamboo_toothbrush.jpg'),
('Túi xách cỏ bàng', 90000, 'Túi xách làm từ cỏ bàng tự nhiên', 'seagrass_bag.jpg'),
('Ống hút cỏ bàng', 12000, 'Ống hút làm từ cỏ bàng', 'seagrass_straw.jpg'),
('Giỏ đựng trái cây mây tre', 110000, 'Giỏ đựng trái cây làm từ mây tre', 'fruit_basket.jpg'),
('Hộp đựng bút tre', 40000, 'Hộp đựng bút làm từ tre', 'bamboo_pen_holder.jpg'),
('Bộ dao, thìa , dĩa tre', 60000, 'Bộ dao, thìa, dĩa làm từ tre', 'bamboo_cutlery_set.jpg'),
('Khăn lau đa năng từ sợi tre', 15000, 'Khăn lau thân thiện với môi trường', 'bamboo_fiber_cloth.jpg'),
('Túi xách bồn bồn thổ cẩm', 95000, 'Túi xách đan từ cây bồn bồn', 'bong_bong_bag.jpg');

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
('Bảo vệ môi trường với sản phẩm từ thiên nhiên', 'Sử dụng sản phẩm từ thiên nhiên giúp giảm thiểu ô nhiễm môi trường.', 'Nội dung chi tiết về việc bảo vệ môi trường...', 'environment_friendly.jpg'),
('Lợi ích của việc sử dụng ống hút tre', 'Ống hút tre là lựa chọn thân thiện với môi trường.', 'Nội dung chi tiết về ống hút tre...', 'bamboo_straw_news.jpg'),
('Xu hướng tiêu dùng xanh năm 2024', 'Người tiêu dùng ngày càng quan tâm đến sản phẩm xanh.', 'Nội dung chi tiết về xu hướng tiêu dùng xanh...', 'green_consumption.jpg'),
('Cách tái chế sản phẩm tre đúng cách', 'Hướng dẫn tái chế sản phẩm tre để bảo vệ môi trường.', 'Nội dung chi tiết về tái chế sản phẩm tre...', 'bamboo_recycling.jpg'),
('Trạm pin xanh', 'Đổi pin cũ, tặng quà xanh', 'Nội dung chi tiết về chương trình trạm pin xanh...', 'green_battery_station.jpg'),
('Quà tặng doanh nghiệp thân thiện với môi trường', 'Lựa chọn quà tặng xanh cho doanh nghiệp.', 'Nội dung chi tiết về quà tặng doanh nghiệp...', 'eco_friendly_gifts.jpg'),
('Sử dụng túi vải thay thế túi nylon', 'Lợi ích của việc sử dụng túi vải.', 'Nội dung chi tiết về túi vải...', 'fabric_bags.jpg'),
('Chia sẻ từ khách hàng về sản phẩm xanh', 'Khách hàng nói gì về sản phẩm thân thiện với môi trường?', 'Nội dung chi tiết về chia sẻ khách hàng...', 'customer_sharing.jpg'),
('Hướng dẫn chăm sóc sản phẩm tre', 'Cách bảo quản và chăm sóc sản phẩm tre.', 'Nội dung chi tiết về chăm sóc sản phẩm tre...', 'bamboo_care.jpg'),
('Sự kiện trồng cây xanh cộng đồng', 'Tham gia sự kiện trồng cây xanh cùng chúng tôi.', 'Nội dung chi tiết về sự kiện trồng cây xanh...', 'community_tree_planting.jpg'),
('Tái chế rác thải nhựa', 'Cách tái chế rác thải nhựa hiệu quả.', 'Nội dung chi tiết về tái chế rác thải nhựa...', 'plastic_recycling.jpg'),
('Lợi ích của việc sử dụng nến thơm thiên nhiên', 'Nến thơm từ thiên nhiên mang lại nhiều lợi ích.', 'Nội dung chi tiết về nến thơm thiên nhiên...', 'natural_scented_candles.jpg'),
('Sản phẩm từ lục bình - Giải pháp xanh cho ngôi nhà bạn', 'Lục bình là vật liệu tự nhiên tuyệt vời.', 'Nội dung chi tiết về sản phẩm từ lục bình...', 'water_hyacinth_products.jpg'),
('Ra mắt bộ sưu tập ống hút mới', 'Bộ sưu tập ống hút tre đa dạng mẫu mã.', 'Nội dung chi tiết về bộ sưu tập ống hút...', 'new_bamboo_straw_collection.jpg'),
('Chương trình khuyến mãi tháng 6', 'Ưu đãi hấp dẫn cho khách hàng trong tháng 6.', 'Nội dung chi tiết về chương trình khuyến mãi...', 'june_promotion.jpg'),
('Ra mắt túi xách bồn bồn thổ cẩm', 'Túi xách bồn bồn - Sự kết hợp hoàn hảo giữa thời trang và thiên nhiên.', 'Nội dung chi tiết về túi xách bồn bồn...', 'bong_bong_bag_launch.jpg'),
('Chương trình giảm giá đặc biệt cho sinh viên', 'Ưu đãi hấp dẫn dành riêng cho sinh viên.', 'Nội dung chi tiết về chương trình giảm giá sinh viên...', 'student_discount.jpg');

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