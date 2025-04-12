# 📘 WordPress Demo Project

> Đây là mã nguồn WordPress dùng để trình bày dự án cá nhân. Tất cả dữ liệu, nội dung, hình ảnh đều là **giả lập** và không liên quan đến dữ liệu thật.

---

## 🚀 Tính năng chính

- Xây dựng với WordPress CMS
- Tích hợp WooCommerce
- Giao diện tùy chỉnh (tự thiết kế hoặc sử dụng theme)
- Một số plugin hỗ trợ chức năng nâng cao (xem bên dưới)
- Đã cấu hình `.gitignore` để loại trừ các file nhạy cảm

---

## 📦 Công nghệ & Plugin sử dụng

- WordPress
- WooCommerce
- Elementor (Pro)
- Contact Form 7
- Polylang (đa ngôn ngữ)
- WP Mail SMTP
- VietQR (thanh toán bằng mã QR ngân hàng Việt Nam)
- Và nhiều plugin khác

---

## 💻 Yêu cầu hệ thống

- PHP >= 7.4
- MySQL/MariaDB >= 5.7
- Apache hoặc Nginx
- XAMPP / Laragon / LocalWP (nên dùng để setup nhanh)
- phpMyAdmin hoặc công cụ import SQL

---

## 🛠 Hướng dẫn cài đặt

1. Clone source code từ GitHub:

```bash
git clone https://github.com/your-username/your-repo.git
cd your-repo

2. Tạo database mới
Tạo một database mới bằng phpMyAdmin hoặc MySQL command.
3. Import database
4. Tạo wp-config.php
Dự án này đã bỏ qua wp-config.php để bảo mật. Tạo file mới dựa theo mẫu:
define( 'DB_NAME', 'your_database_name' );
define( 'DB_USER', 'your_username' );
define( 'DB_PASSWORD', 'your_password' );
define( 'DB_HOST', 'localhost' );
