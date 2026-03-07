# 🛒 The Greenmart Vietnam - PHP MVC E-Commerce Platform

Một dự án website thương mại điện tử các sản phẩm thân thiện với môi trường được xây dựng hoàn toàn từ đầu (from scratch) dựa trên kiến trúc **MVC (Model-View-Controller)** sử dụng PHP thuần, không phụ thuộc vào bất kỳ framework PHP nào (như Laravel hay CodeIgniter).

## 🚀 Các tính năng nổi bật (Key Features)

Dự án được chia thành 2 phần chính: **Trang Khách hàng (Client)** và **Trang Quản trị (Admin Dashboard)**.

### 👥 Dành cho Khách hàng (Client)
* **Xác thực người dùng:** Đăng ký, Đăng nhập, Đổi mật khẩu, Cập nhật hồ sơ & Upload Avatar cá nhân.
* **Mua sắm:** Xem danh sách sản phẩm, Tìm kiếm sản phẩm, Phân trang, Xem chi tiết sản phẩm.
* **Giỏ hàng & Thanh toán:** Thêm/sửa/xóa sản phẩm trong giỏ hàng, đặt hàng.
* **Tin tức & Tương tác:** Đọc tin tức công nghệ (có phân trang & tìm kiếm), bình luận dưới bài viết.
* **Hỗ trợ khách hàng:** Xem trang Giới thiệu, Hỏi đáp (FAQ) dạng Accordion, Gửi form Liên hệ.

### 🛡️ Dành cho Quản trị viên (Admin)
* **Dashboard Thống kê:** Hiển thị doanh thu, số lượng đơn hàng mới, tổng sản phẩm và người dùng.
* **Quản lý Đơn hàng (Role 3):** Xem chi tiết đơn hàng, cập nhật trạng thái đơn hàng (Pending, Processing, Completed, Cancelled).
* **Quản lý Sản phẩm (Role 3):** Thêm, sửa, xóa sản phẩm và hình ảnh minh họa.
* **Quản lý Tin tức & Bình luận (Role 4):** Soạn thảo bài viết, kiểm duyệt (ẩn/hiện/xóa) bình luận của người dùng.
* **Quản lý Liên hệ & Cấu hình (Role 1):** Đọc hộp thư liên hệ, đánh dấu trạng thái, thay đổi thông tin website (Tên, Logo, Địa chỉ, SĐT) tự động cập nhật lên View.
* **Quản lý Hỏi đáp - FAQ (Role 2):** Cập nhật danh sách câu hỏi thường gặp theo thứ tự ưu tiên.

## 🛠️ Công nghệ sử dụng
* **Back-end:** PHP 8.x (Pure/Vanilla PHP), kiến trúc Custom MVC.
* **Cơ sở dữ liệu:** MySQL (Giao tiếp qua PDO để chống SQL Injection).
* **Front-end Client:** HTML5, CSS3, JavaScript, Bootstrap 5, FontAwesome.
* **Front-end Admin:** Tabler UI Framework.
* **Bảo mật:** Password Hashing (`password_hash`), Chống XSS (`htmlspecialchars`).

---

## ⚙️ Hướng dẫn Cài đặt (Installation & Setup)

Để chạy dự án này trên máy tính cá nhân (Localhost), hãy làm theo các bước sau:

### 1. Yêu cầu hệ thống
* Đã cài đặt [XAMPP](https://www.apachefriends.org/) hoặc WAMP/MAMP (Hỗ trợ PHP >= 8.0 và MySQL).

### 2. Các bước triển khai
1. **Clone/Tải Source Code:**
   * Tải mã nguồn về và giải nén vào thư mục `htdocs` của XAMPP (VD: `C:\xampp\htdocs\The-Greenmart-Vietnam`).

2. **Cài đặt Cơ sở dữ liệu (Database):**
   * Mở XAMPP Control Panel, khởi động **Apache** và **MySQL**.
   * Truy cập vào `http://localhost/phpmyadmin`.
   * Tạo một database mới có tên là `database` (Collation: `utf8mb4_general_ci`).
   * Chọn tab **Import**, tải lên file `database.sql` (nằm trong thư mục gốc của dự án) và bấm **Import**.

3. **Cấu hình Kết nối (Config):**
   * Mở file `config/database.php`.
   * Kiểm tra và thay đổi thông tin kết nối cho phù hợp với máy của bạn:
     ```php
     private $host = "localhost";
     private $db_name = "database";
     private $username = "root";
     private $password = ""; // Mặc định của XAMPP là rỗng
     ```

4. **Khởi chạy Website:**
   * Truy cập trang khách hàng: `http://localhost/The-Greenmart-Vietnam/index.php`
   * Truy cập trang Admin: Đăng nhập bằng tài khoản quản trị viên.

### 🔑 Tài khoản Test mặc định
* **Quyền Admin:**
  * Email: `admin@gmail.com`
  * Mật khẩu: `123456`
* **Quyền User:**
  * Email: `user@gmail.com`
  * Mật khẩu: `123456`

---

## 📂 Cấu trúc Thư mục (Folder Structure)

```text
/techstore
│
├── assets/           # Chứa CSS, JS, Fonts và thư mục uploads (ảnh sản phẩm, avatar)
├── config/           # Chứa file kết nối Database (database.php)
├── controllers/      # Chứa các Controller xử lý logic (BaseController, ProductController...)
├── models/           # Chứa các Model tương tác với Database (BaseModel, UserModel...)
├── views/            # Chứa giao diện (HTML/PHP trộn lẫn)
│   ├── admin/        # Giao diện trang quản trị
│   ├── client/       # Giao diện trang khách hàng
│   └── layouts/      # Header và Footer dùng chung
│
├── index.php         # Entry point (Router chính của ứng dụng)
└── database.sql     # File xuất Database để import
