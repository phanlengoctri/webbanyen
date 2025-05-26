<?php
session_start();

// Bao gồm file kết nối cơ sở dữ liệu
include('connect.php'); 

// Kiểm tra nếu giỏ hàng trống
if (empty($_SESSION['card'])) {
    header("Location: card.php");
    exit();
}

// Kiểm tra nếu người dùng đã gửi thông tin thanh toán
if (isset($_POST['submit'])) {
    // Lấy thông tin thanh toán từ form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $paymentMethod = $_POST['payment_method']; // Lấy phương thức thanh toán

    // Tính toán tổng số tiền từ giỏ hàng
    $totalAmount = 0;
    foreach ($_SESSION['card'] as $product) {
        $totalAmount += $product['price'] * $product['quantity'];
    }

    try {
        // Bắt đầu giao dịch
        $conn->beginTransaction();

        // Thêm thông tin vào bảng orders
        $query = "INSERT INTO orders (user_id,customer_name, customer_email, customer_phone, customer_address, payment_method, total_amount) 
                  VALUES (:user_id,:customer_name, :customer_email, :customer_phone, :customer_address, :payment_method, :total_amount)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':customer_name', $name);
        $stmt->bindParam(':customer_email', $email);
        $stmt->bindParam(':customer_phone', $phone);
        $stmt->bindParam(':customer_address', $address);
        $stmt->bindParam(':payment_method', $paymentMethod);
        $stmt->bindParam(':total_amount', $totalAmount); 
        $stmt->bindParam(':user_id', $_SESSION['id']);

        $stmt->execute();

        // Lấy ID của đơn hàng vừa thêm
        $orderId = $conn->lastInsertId();

        // Thêm các sản phẩm vào bảng order_items
        foreach ($_SESSION['card'] as $product) {
            $productId = $product['id'];
            $productName = $product['name'];
            $productPrice = $product['price'];
            $quantity = $product['quantity'];

            $query = "INSERT INTO order_items (order_id, product_id, product_name, product_price, quantity) 
                      VALUES (:order_id, :product_id, :product_name, :product_price, :quantity)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':order_id', $orderId);
            $stmt->bindParam(':product_id', $productId);
            $stmt->bindParam(':product_name', $productName);
            $stmt->bindParam(':product_price', $productPrice);
            $stmt->bindParam(':quantity', $quantity);

            $stmt->execute();
        }

        // Xác nhận giao dịch
        $conn->commit();

        // Xóa giỏ hàng sau khi đặt hàng
        unset($_SESSION['card']);

        // Chuyển hướng lại trang giỏ hàng sau khi thành công
        header("Location: checkout.php?success=true"); 
        exit();
    } catch (PDOException $e) {
        // Nếu có lỗi, hủy bỏ giao dịch
        $conn->rollBack();
        echo "Lỗi: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="style/checkout.css">
    <style>
        /* CSS để hiển thị thông báo */
        .alert-success {
            background-color: #d4edda;
            color: black;  /* Đổi màu chữ thành đen */
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            font-size: 16px;
            display: none; /* Ẩn thông báo mặc định */
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container">
        <h2>Thông tin đặt hàng</h2>

        <form action="checkout.php" method="POST">
            <div class="form-content">
                <div class="form-group">
                    <label for="name"><b>Họ và tên:</b></label>
                    <input type="text" name="name" id="name" required>
                </div>

                <div class="form-group">
                    <label for="email"><b>Email:</b></label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="form-group">
                    <label for="phone"><b>Số điện thoại:</b></label>
                    <input type="text" name="phone" id="phone" required>
                </div>

                <div class="form-group">
                    <label for="address"><b>Địa chỉ giao hàng:</b></label>
                    <input type="text" name="address" id="address" required>
                </div>
                <!-- Chọn phương thức thanh toán -->
                <div class="form-group">
                    <label for="payment_method"><b>Hình thức thanh toán:</b></label>
                    <select name="payment_method" id="payment_method" required>
                        <option value="Tiền mặt">Tiền mặt</option>
                        <option value="Chuyển khoản ngân hàng">Chuyển khoản ngân hàng</option>
                        <option value="Thanh toán trực tuyến">Thanh toán trực tuyến</option>
                    </select>
                </div>
            </div>

            <div class="order-summary">
                <h3>Tóm tắt đơn hàng</h3>
                <table>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>

                    <?php
                    $total = 0;
                    foreach ($_SESSION['card'] as $product) {
                        $productTotal = $product['price'] * $product['quantity'];
                        $total += $productTotal;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</td>
                        <td><?php echo $product['quantity']; ?></td>
                        <td><?php echo number_format($productTotal, 0, ',', '.'); ?> VNĐ</td>
                    </tr>
                    <?php } ?>
                </table>

                <div class="total">
                    <h3>Tổng cộng: <?php echo number_format($total, 0, ',', '.'); ?> VNĐ</h3>
                </div>
            </div>

            <div class="checkout-btn">
                <button type="submit" name="submit">Đặt hàng</button>
            </div>
        </form>
    </div>

    <?php include('footer.php'); ?>

    <script>
        // Kiểm tra nếu có success trong URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success') && urlParams.get('success') === 'true') {
            // Hiển thị thông báo thành công
            const successMessage = document.createElement('div');
            successMessage.classList.add('alert-success');
            successMessage.textContent = "Đơn hàng của bạn đã được đặt thành công!";
            document.body.appendChild(successMessage);

            // Hiển thị thông báo
            setTimeout(() => {
                successMessage.style.display = 'block';
            }, 100);

            // Ẩn thông báo sau 5 giây
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 5000);
        }
    </script>
</body>
</html>
