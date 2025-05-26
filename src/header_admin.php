<?php
include '../src/connect.php'; // Kết nối đến cơ sở dữ liệu
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} // Bắt đầu session để lấy thông tin user đăng nhập

// Giả sử bạn lưu ID người dùng vào session khi họ đăng nhập
$user_id = $_SESSION['id'];

// Truy vấn avatar từ bảng `members`
$sql = "SELECT avatar FROM members WHERE id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch();

// Nếu có ảnh avatar trong cơ sở dữ liệu, lưu vào biến, ngược lại dùng ảnh mặc định
$avatar = !empty($user['avatar']) ? $user['avatar'] : 'path/to/default-avatar.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/header_admin.css">
    <link rel="shortcut icon" href="../image/Logo/Web-BuuYen-P-1-1-04.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Admin - Quản lý sản phẩm</title>
</head>
<body>

<div class="content">
    <header>
        <div class="logo">
            <a href="../src/admin_home.php"><img src="../image/Logo/cropped-678.png"></a>
        </div>

        <div class="category">
            <ul>
                <li class="category-item">
                    <a class="category-list" href="../src/maneger_product.php">Quản lí sản phẩm</a>
                </li>
                <li class="category-item">
                    <a class="category-list" href="../src/add_product.php">Thêm sản phẩm</a>
                </li>
                <li class="category-item">
                    <a class="category-list" href="../src/orders_management.php">Quản lí đơn hàng</a>
                </li>
            </ul>
        </div>    
            
        <div class="search">
            <input placeholder="Text in here..." type="text">
            <button type="submit">Search</button>
        </div>

        <div class="user">
           
            <a href="#"><i class="fa-solid fa-circle-dollar-to-slot"></i></a>
            <div class="avatar-container">
                <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" class="avatar-image" onclick="toggleDropdown()">
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="../src/account_admin.php" class="icon-account"><i class="fa-solid fa-user"></i> Account</a>
                    <a href="../src/login.php" class="icon-logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                </div>
            </div>
        </div>

        <script>
            // Hiển thị hoặc ẩn menu thả xuống
            function toggleDropdown() {
                const dropdownMenu = document.getElementById('dropdownMenu');
                dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
            }

            // Ẩn menu khi nhấp ra ngoài
            window.onclick = function(event) {
                const dropdownMenu = document.getElementById('dropdownMenu');
                if (!event.target.matches('.avatar-image')) {
                    dropdownMenu.style.display = 'none';
                }
            }
        </script>
    </header>
</div>

</body>
</html>
