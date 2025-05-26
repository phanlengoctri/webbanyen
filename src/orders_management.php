<?php
include('../src/connect.php');  // Kết nối tới cơ sở dữ liệu
include('../src/header_admin.php');  

// Truy vấn danh sách đơn hàng
$query = "SELECT * FROM orders";
$stmt = $conn->query($query);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đơn Hàng</title>
    <link rel="stylesheet" href="../style/orders_management.css"> <!-- Liên kết CSS nếu có -->
</head>
<body>
    <h1>Quản lý Đơn Hàng</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Mã Đơn Hàng</th>
                <th>Tên Khách Hàng</th>
                <th>Email</th>
                <th>Số Điện Thoại</th>
                <th>Địa Chỉ</th>
                <th>Phương Thức Thanh Toán</th>
                <th>Tổng Giá Trị</th>
                <th>Trạng Thái</th>
                <th>Ngày Tạo</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['customer_name']; ?></td>
                    <td><?php echo $order['customer_email']; ?></td>
                    <td><?php echo $order['customer_phone']; ?></td>
                    <td><?php echo $order['customer_address']; ?></td>
                    <td><?php echo $order['payment_method']; ?></td>
                    <td><?php echo $order['total_amount']; ?></td>
                    <td><?php echo $order['status']; ?></td>
                    <td><?php echo $order['created_at']; ?></td>
                    <td class="orders">
                        <a href="../src/order_detail_admin.php?order_id=<?php echo $order['id']; ?>">Xem Chi Tiết</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
