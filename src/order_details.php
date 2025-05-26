<?php
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include('connect.php');

// Lấy thông tin đơn hàng từ URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Truy vấn để lấy thông tin đơn hàng bao gồm tên khách hàng và số điện thoại
    $query_order = "SELECT * FROM orders WHERE id = :order_id AND user_id = :user_id";
    $stmt_order = $conn->prepare($query_order);
    $stmt_order->bindParam(':order_id', $order_id);
    $stmt_order->bindParam(':user_id', $_SESSION['id']);
    $stmt_order->execute();
    $order = $stmt_order->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra nếu đơn hàng không tồn tại
    if (!$order) {
        echo "Đơn hàng không tồn tại.";
        exit();
    }

    // Truy vấn để lấy các sản phẩm trong đơn hàng từ cả bảng products và mooncake
    $query_order_items = "
        SELECT oi.*, p.name AS product_name, p.price AS product_price, p.image AS product_image 
        FROM order_items oi 
        JOIN (
            SELECT id, name, price, image FROM products
            UNION ALL
            SELECT id, name, price, image FROM mooncake
        ) AS p ON oi.product_id = p.id 
        WHERE oi.order_id = :order_id";
                         
    $stmt_order_items = $conn->prepare($query_order_items);
    $stmt_order_items->bindParam(':order_id', $order_id);
    $stmt_order_items->execute();
    $order_items = $stmt_order_items->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Không tìm thấy ID đơn hàng.";
    exit();
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="style/order_details.css">
</head>
<body>
    <?php include('header.php'); ?> <!-- Bao gồm header -->

    <div class="container">
        <a href="account.php"><button class="btn-back">Quay lại </button><br></a>
        <h2>Chi tiết đơn hàng</h2>

        <h3>Thông tin khách hàng</h3>
        <p><strong>Tên khách hàng:</strong> <?php echo $order['customer_name']; ?></p>
        <p><strong>Số điện thoại:</strong> <?php echo $order['customer_phone']; ?></p>

        <h3>Thông tin đơn hàng</h3>
        <p><strong>Ngày đặt:</strong> <?php echo date("d/m/Y", strtotime($order['created_at'])); ?></p>
        <p><strong>Trạng thái:</strong> <?php echo $order['status']; ?></p>
        <p><strong>Tổng cộng:</strong> <span class="total-price"><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VNĐ</span></p>


        <h3>Danh sách sản phẩm</h3>
        <?php if (count($order_items) > 0): ?>
            <table>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                </tr>
                <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td>
                            <img src="<?php echo $item['product_image']; ?>" alt="product-image" style="width: 80px; height: 80px; object-fit: cover;">
                        </td>
                        <td><?php echo $item['product_name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo number_format($item['product_price'], 0, ',', '.'); ?> VNĐ</td>
                        <td><?php echo number_format($item['quantity'] * $item['product_price'], 0, ',', '.'); ?> VNĐ</td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Đơn hàng này không có sản phẩm nào.</p>
        <?php endif; ?>
    </div>

    <?php include('footer.php'); ?> <!-- Bao gồm footer -->
</body>
</html>
