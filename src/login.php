<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include('../src/connect.php'); // Kết nối cơ sở dữ liệu

$message = ""; // Biến chứa thông báo

if (isset($_POST['dangnhap'])) {
    $username = trim($_POST['txtUsername']);
    $password = trim($_POST['txtPassword']);

    if (!$username || !$password) {
        $message = "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT id, username, password, role, avatar FROM members WHERE username = ?");
            $stmt->execute([$username]);

            if ($stmt->rowCount() == 0) {
                $message = "Tên đăng nhập này không tồn tại. Vui lòng kiểm tra lại.";
            } else {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $db_password = $row['password'];
                $role = $row['role'];
                $user_id = $row['id'];
                $avatar = $row['avatar'];

                if (!password_verify($password, $db_password)) {
                    $message = "Mật khẩu không đúng. Vui lòng nhập lại.";
                } else {
                    $_SESSION['id'] = $user_id;
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;
                    $_SESSION['avatar'] = $avatar;

                    if ($role === 'admin') {
                        header("Location: maneger_product.php");
                    } else {
                        header("Location: user_home.php");
                    }
                    exit();
                }
            }
        } catch (PDOException $e) {
            $message = "Lỗi truy vấn: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yến Chưng Tươi - Nguyên Vị - Bửu Yến</title>
    <link rel="stylesheet" href="../style/login-background.css">
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
}</style>
</head>
<body>
    <div class="wrapper">
        <form action="../src/login.php" method="POST">
            <h1>Login</h1>

            <!-- Phần thông báo lỗi hoặc thành công -->
            <?php if ($message): ?>
                <div class="message-box">
                    <p><?php echo $message; ?></p>
                </div>
            <?php endif; ?>

            <div class="input-box">
                <input type="text" name="txtUsername" placeholder="Enter your username" required>
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-box">
                <input type="password" name="txtPassword" placeholder="Enter your password" required>
                <i class="fa-solid fa-lock"></i>
            </div>

            <div class="remember-forgot">
                <label>
                    <input type="checkbox" name="remember">Remember me
                </label>
                <a href="#">Forgot password</a>
            </div>

            <input type="submit" name="dangnhap" value="Login" class="btn" />

            <div class="register-link">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>
