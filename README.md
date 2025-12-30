# 🚗 Parking Management Web System

## 📌 Giới thiệu
Đây là một **ứng dụng web quản lý bãi đỗ xe** được xây dựng bằng **HTML, CSS và PHP**, hỗ trợ quản lý hoạt động xe ra/vào, thông tin bãi đỗ và dữ liệu liên quan thông qua giao diện web trực quan.  
Dự án phù hợp cho **mục đích học tập, demo hệ thống quản lý** hoặc làm nền tảng mở rộng trong tương lai.

---

## 🛠️ Công nghệ sử dụng
- **Frontend:** HTML5, CSS3  
- **Backend:** PHP  
- **Cơ sở dữ liệu:** MySQL  
- **Quản lý thư viện:** Composer  
- **Kiến trúc:** MVC đơn giản (Model – View – Controller)

---

## 📁 Cấu trúc thư mục
├── admin/ # Chức năng quản trị hệ thống \n
├── dao/ # Data Access Object – xử lý truy vấn CSDL\n
├── layout/ # Các thành phần layout dùng chung\n
├── sql/ # File SQL khởi tạo cơ sở dữ liệu\n
├── vendor/ # Thư viện cài đặt qua Composer\n
├── view/ # Giao diện hiển thị (HTML/PHP)\n
├── index.php # Điểm khởi chạy chính của ứng dụng\n
├── composer.json # Cấu hình Composer\n
├── composer.lock # Phiên bản thư viện\n
├── IMAGES.docx # Hình ảnh chụp màn hình giao diện web\n
└── .DS_Store # File hệ thống (có thể bỏ qua)


---

## 🖥️ Chức năng chính
- Quản lý thông tin bãi đỗ xe  
- Quản lý xe ra/vào  
- Quản lý người dùng (Admin)  
- Hiển thị dữ liệu thông qua giao diện web  
- Tách biệt xử lý dữ liệu và giao diện hiển thị

---

## 🖼️ Hình ảnh minh họa
Tập tin **`IMAGES.docx`** chứa **các ảnh chụp màn hình giao diện của hệ thống**, bao gồm:
- Trang quản trị (Admin Dashboard)
- Các trang chức năng quản lý
- Giao diện hiển thị dữ liệu

> 📎 File này giúp người xem nhanh chóng hình dung **cách hoạt động và giao diện thực tế** của ứng dụng mà không cần chạy source code.

---

## 🚀 Hướng dẫn cài đặt & chạy dự án
1. Clone repository:
2. Import file SQL trong thư mục sql/ vào MySQL

Cấu hình kết nối CSDL trong thư mục dao/

Chạy project bằng XAMPP / WAMP / Laragon

Truy cập trình duyệt:

http://localhost/<ten-project>
   ```bash
   git clone <repository-url>
