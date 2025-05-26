<?php
// Kiểm tra nếu session chưa được khởi tạo
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Chỉ gọi session_start() nếu session chưa được khởi tạo
}

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['id'])) {
    include('../src/connect.php');  // Bao gồm tệp kết nối cơ sở dữ liệu

    $user_id = $_SESSION['id'];

    // Truy vấn để lấy thông tin người dùng, đặc biệt là avatar
    $query_user_info = "SELECT avatar FROM members WHERE id = :user_id";
    $stmt_user_info = $conn->prepare($query_user_info);
    $stmt_user_info->bindParam(':user_id', $user_id);
    $stmt_user_info->execute();
    $user_info = $stmt_user_info->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra và lấy avatar, nếu không có thì sử dụng avatar mặc định
    if ($user_info && !empty($user_info['avatar'])) {
        $avatar = $user_info['avatar']; // Avatar người dùng đã tải lên
    } else {
        $avatar = '../image/avatars/avartardefault.png'; // Avatar mặc định nếu không có
    }
} else {
    // Nếu người dùng chưa đăng nhập, sử dụng avatar mặc định
    $avatar = '../image/avatars/avartardefault.png';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/home.css">
    <link rel="shortcut icon" href="../image/Logo/Web-BuuYen-P-1-1-04.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Yến Chưng Tươi - Nguyên Vị - Bửu Yến</title>
</head>
<body>

<div class="content">
    <header>
        <div class="logo">
            <a href="../src/user_home.php"><img src="../image/Logo/cropped-678.png" alt="Logo"></a>
        </div>

        <div class="category">
            <ul>
                <li class="category-item"><a class="category-list" href="user_home.php">Giới thiệu</a></li>
                <li class="category-item"><a class="category-list" href="products.php">Cửa Hàng</a></li>
                <li class="category-item"><a class="category-list" href="mooncake.php">Bánh Trung Thu</a></li>
                <li class="category-item"><a class="category-list" href="contact.php">Liên Hệ</a></li>
            </ul>
        </div>    

        <form action="../src/search.php" method="GET">
            <div class="search">
                <input name="search_term" placeholder="Nhập từ khóa tìm kiếm sản phẩm" type="text">
                <button type="submit" name="search_button">Search</button>
            </div>
        </form>

        <div class="user">
    <a href="../src/card.php">
        <i class="fa-solid fa-cart-shopping"></i>
        <span id="cart-count"><?php echo count($_SESSION['card']); ?></span> <!-- Hiển thị số lượng sản phẩm trong giỏ -->
    </a>
    <a href="#"><i class="fa-solid fa-circle-dollar-to-slot"></i></a>

    <!-- Avatar và menu người dùng -->
    <div class="avatar-container">
        <img src="<?php echo $avatar; ?>" alt="Avatar" class="avatar-image" onclick="toggleDropdown()">
        <div class="dropdown-menu" id="dropdownMenu">
            <a href="../src/account.php" class="icon-account"><i class="fa-solid fa-user"></i> Account</a>
            <a href="../src/login.php" class="icon-logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>
</div>
  
    </header>

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
</body>
</html>
