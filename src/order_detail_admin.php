<?php
include('connect.php');  // Kết nối cơ sở dữ liệu
include('header_admin.php');  // Kết nối cơ sở dữ liệu

// Lấy order_id từ URL
$order_id = $_GET['order_id'];

// Kiểm tra nếu có yêu cầu cập nhật trạng thái
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $new_status = $_POST['status'];
    $updateQuery = "UPDATE orders SET status = :status WHERE id = :order_id";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bindParam(':status', $new_status);
    $updateStmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $updateStmt->execute();
    echo "<div class='message success'>Trạng thái đơn hàng đã được cập nhật thành công.</div>";
}

// Lấy thông tin chi tiết đơn hàng và sản phẩm trong đơn hàng
$query = "SELECT oi.*, o.customer_name, o.customer_email, o.customer_phone, o.customer_address, o.payment_method, o.total_amount, o.status, o.created_at 
          FROM order_items oi
          JOIN orders o ON oi.order_id = o.id
          WHERE oi.order_id = :order_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$stmt->execute();
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$order_items) {
    die("Không tìm thấy đơn hàng.");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng</title>
    <link rel="stylesheet" href="style\order_detail_admin.css">

    
</head>
<body>
    <div class="order-container">
        <h1>Chi Tiết Đơn Hàng</h1>
    <p><strong>Tên Khách Hàng:</strong> <?php echo $order_items[0]['customer_name']; ?></p>
    <p><strong>Email:</strong> <?php echo $order_items[0]['customer_email']; ?></p>
    <p><strong>Số Điện Thoại:</strong> <?php echo $order_items[0]['customer_phone']; ?></p>
    <p><strong>Địa Chỉ:</strong> <?php echo $order_items[0]['customer_address']; ?></p>
    <p><strong>Phương Thức Thanh Toán:</strong> <?php echo $order_items[0]['payment_method']; ?></p>
    <p><strong>Tổng Giá Trị:</strong> <?php echo $order_items[0]['total_amount']; ?></p>
    <p><strong>Trạng Thái:</strong> <?php echo $order_items[0]['status']; ?></p>
    <p><strong>Ngày Tạo:</strong> <?php echo $order_items[0]['created_at']; ?></p>

    <!-- Form cập nhật trạng thái -->
    <h2>Cập Nhật Trạng Thái Đơn Hàng</h2>
    <form method="POST">
        <div class="form-group">
            <label for="status">Trạng Thái Mới:</label>
            <select name="status" id="status">
                <option value="Pending" <?php echo ($order_items[0]['status'] === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Processing" <?php echo ($order_items[0]['status'] === 'Processing') ? 'selected' : ''; ?>>Processing</option>
                <option value="Completed" <?php echo ($order_items[0]['status'] === 'Completed') ? 'selected' : ''; ?>>Completed</option>
                <option value="Cancelled" <?php echo ($order_items[0]['status'] === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select>
            <button type="submit">Cập Nhật Trạng Thái</button>
        </div>
    </form>

    <h2>Sản Phẩm Trong Đơn Hàng</h2>
    <table>
        <thead>
            <tr>
                <th>Mã Sản Phẩm</th>
                <th>Tên Sản Phẩm</th>
                <th>Giá</th>
                <th>Số Lượng</th>
                <th>Tổng Giá</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_items as $item): ?>
                <tr>
                    <td><?php echo $item['product_id']; ?></td>
                    <td><?php echo $item['product_name']; ?></td>
                    <td><?php echo number_format($item['product_price'], 0, ',', '.'); ?> VND</td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($item['product_price'] * $item['quantity'], 0, ',', '.'); ?> VND</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Nút Quay lại -->
    <a href="javascript:history.back()" class="back-button">Quay lại</a></div>
</body>
</html>
