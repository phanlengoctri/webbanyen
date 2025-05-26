<?php
// Thông tin cấu hình cơ sở dữ liệu
$host = "localhost";         // Tên máy chủ (thường là localhost)
$dbname = "buuyen"; // Tên cơ sở dữ liệu
$username = "root";          // Tên người dùng MySQL
$password = "";              // Mật khẩu MySQL (để trống nếu không có)

try {
    // Tạo kết nối PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Thiết lập chế độ lỗi PDO để phát hiện lỗi ngoại lệ
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Thông báo lỗi nếu kết nối thất bại
    echo "Kết nối thất bại: " . $e->getMessage();
}
?>
