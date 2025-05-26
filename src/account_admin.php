<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

// Kết nối tới database
include('../src/connect.php');
include('../src/header_admin.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Nếu chưa đăng nhập, chuyển hướng về trang login
    exit();
}

// Lấy ID người dùng từ session
$user_id = $_SESSION['id'];

// Truy vấn thông tin người dùng từ bảng members
$stmt = $conn->prepare("SELECT first_name, last_name, phone, birthdate, avatar FROM members WHERE id = ?");
$stmt->execute([$user_id]);

// Kiểm tra nếu tìm thấy thông tin người dùng
if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $first_name = $user['first_name'];
    $last_name = $user['last_name'];
    $phone = $user['phone'];
    $birthdate = $user['birthdate'];
    $avatar = $user['avatar']; // Lấy avatar người dùng
} else {
    echo "Không tìm thấy thông tin người dùng.";
    exit();
}


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản</title>
    <style>
        /* Cấu trúc tổng thể của trang */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}



/* Thông tin tài khoản */
h1 {
    text-align: center;
    color: #333;
    margin-top: 20px;
}

/* Nội dung chính của trang */
main {
    padding: 20px;
    background-color: #fff;
    margin-top: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Phần thông tin cá nhân */
section {
    margin-bottom: 20px;
}

section h2 {
    color: #333;
    font-size: 1.5em;
    margin-bottom: 10px;
}

/* Thông tin người dùng */
.user-info {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.user-info img.avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    margin-right: 20px;
}

.user-details p {
    margin: 5px 0;
}

.user-details strong {
    color: #555;
}

/* Nút cập nhật thông tin */
.btn-update {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
    transition: background-color 0.3s;
}

.btn-update:hover {
    background-color: #45a049;
}

/* Đảm bảo khoảng cách giữa nội dung và header */
main {
    margin-top: 60px;
}
.container{
    padding-top: 50px;
}
    </style>
</head>
<body>
   
        <div class="container">
        <h1>Thông tin tài khoản</h1>
    
    <main>
    <section>
    <h2>Thông tin cá nhân</h2>
    <div class="user-info">
        <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" class="avatar">
        <div class="user-details">
            <p><strong>Họ:</strong> <?php echo htmlspecialchars($first_name); ?></p>
            <p><strong>Tên:</strong> <?php echo htmlspecialchars($last_name); ?></p>
            <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($phone); ?></p>
            <p><strong>Ngày sinh:</strong> <?php echo htmlspecialchars($birthdate); ?></p>
        </div>
    </div>
    <a href="../src/update_account_admin.php" class="btn-update">Cập nhật thông tin</a>
</section>


        
    </main>
        </div>
    
</body>
</html>
