<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

// Kết nối tới database
include('../src/connect.php');
include('../src/header.php');

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

// Truy vấn lịch sử đơn hàng từ bảng orders
$order_stmt = $conn->prepare("SELECT id, total_amount, status, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$order_stmt->execute([$user_id]);

// Lấy tất cả đơn hàng của người dùng
$orders = $order_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản</title>
    <link rel="stylesheet" href="../style/account.css">
</head>
<body>
   
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
    <a href="src/edit_profile.php" class="btn-update">Cập nhật thông tin</a>
</section>


        <section>
            <h2>Lịch sử đơn hàng</h2>
            <?php if (count($orders) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['id']); ?></td>
                                <td><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VND</td>
                                <td><?php echo htmlspecialchars($order['status']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                <td><a href="../src/order_details.php?order_id=<?php echo $order['id']; ?>">Xem chi tiết</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Chưa có đơn hàng nào.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Website của bạn</p>
    </footer>
</body>
</html>
<?php
include('../src/footer.php');
?>