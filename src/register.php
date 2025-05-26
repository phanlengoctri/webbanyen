<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

// Kết nối tới database
include('connect.php');

// Biến để chứa thông báo
$message = "";

// Kiểm tra nếu người dùng đã gửi form đăng ký
if (isset($_POST['dangky'])) {
    // Lấy dữ liệu từ form
    $firstName = trim($_POST['txtFirstName']);
    $lastName = trim($_POST['txtLastName']);
    $username = trim($_POST['txtUsername']);
    $password = trim($_POST['txtPassword']);
    $confirmPassword = trim($_POST['txtConfirmPassword']);
    $phone = trim($_POST['txtPhone']);
    $birthdate = trim($_POST['txtBirthdate']);
    $role = 'user'; // Gán vai trò cố định là "user"
    $avatar = 'image/avatars/avartardefault.png'; // Avatar mặc định đã có trong thư mục

    // Kiểm tra nếu các trường không được để trống
    if (!$username || !$password || !$confirmPassword || !$firstName || !$lastName || !$phone || !$birthdate) {
        $message = "Vui lòng nhập đầy đủ thông tin.";
    } else {
        // Kiểm tra nếu mật khẩu và xác nhận mật khẩu khớp nhau
        if ($password !== $confirmPassword) {
            $message = "Mật khẩu xác nhận không khớp. Vui lòng thử lại.";
        } else {
            try {
                // Kiểm tra tên đăng nhập đã tồn tại chưa
                $stmt = $conn->prepare("SELECT username FROM members WHERE username = ?");
                $stmt->execute([$username]);
                if ($stmt->rowCount() > 0) {
                    $message = "Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.";
                } else {
                    // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Lưu thông tin người dùng vào cơ sở dữ liệu, bao gồm cả avatar mặc định
                    $stmt = $conn->prepare("INSERT INTO members (first_name, last_name, username, password, phone, birthdate, role, avatar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$firstName, $lastName, $username, $hashedPassword, $phone, $birthdate, $role, $avatar]);

                    // Đăng ký thành công
                    $message = "Đăng ký thành công. <a href='login.php'>Đăng nhập ngay</a>";
                }

            } catch (PDOException $e) {
                $message = "Lỗi: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link rel="stylesheet" href="style/login-background.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .message-box {
    margin: 10px 0;
    padding: 10px;
    border: 1px solid #ff5c5c;
    color: #d8000c;
    border-radius: 5px;
    font-size: 1em;
    text-align: center;
}

    </style>
</head>
<body>
    <div class="wrapper">
        <form action="register.php" method="POST">
            <h1>Register</h1>

            <!-- Phần thông báo lỗi hoặc thành công -->
            <?php if ($message): ?>
                <div class="message-box">
                    <p><?php echo $message; ?></p>
                </div>
            <?php endif; ?>

            <div class="input-box">
                <input type="text" name="txtFirstName" placeholder="First Name" required>
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-box">
                <input type="text" name="txtLastName" placeholder="Last Name" required>
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-box">
                <input type="text" name="txtUsername" placeholder="Username" required>
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-box">
                <input type="password" name="txtPassword" placeholder="Password" required>
                <i class="fa-solid fa-lock"></i>
            </div>
            <div class="input-box">
                <input type="password" name="txtConfirmPassword" placeholder="Confirm Password" required>
                <i class="fa-solid fa-lock"></i>
            </div>
            <div class="input-box">
                <input type="text" name="txtPhone" placeholder="Phone Number" required>
                <i class="fa-solid fa-phone"></i>
            </div>
            <div class="input-box">
                <input type="date" name="txtBirthdate" placeholder="Birthdate" required>
                <i class="fa-solid fa-calendar"></i>
            </div>

            <input type="submit" name="dangky" value="Register" class="btn" />

            <div class="register-link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>

