<?php
session_start();

// Kiểm tra nếu giỏ hàng chưa được khởi tạo
if (!isset($_SESSION['card'])) {
    $_SESSION['card'] = []; // Khởi tạo giỏ hàng nếu chưa có
}

// Kiểm tra xem có yêu cầu thêm sản phẩm vào giỏ hàng không
if (isset($_GET['add_to_card'])) {
    $productId = $_GET['add_to_card'];

    // Kết nối cơ sở dữ liệu để lấy thông tin sản phẩm
    include('../src/connect.php');
    
    try {
        // Lấy thông tin sản phẩm từ cơ sở dữ liệu
        $query = "SELECT * FROM products WHERE id = :productId";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();

        // Kiểm tra nếu tìm thấy sản phẩm
        if ($stmt->rowCount() > 0) {
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $found = false;
            foreach ($_SESSION['card'] as &$cartProduct) {
                if ($cartProduct['id'] == $product['id']) {
                    $cartProduct['quantity']++; // Nếu có, tăng số lượng lên
                    $found = true;
                    break;
                }
            }

            // Nếu sản phẩm chưa có trong giỏ, thêm mới và gán quantity là 1
            if (!$found) {
                $product['quantity'] = 1; // Mặc định là 1 khi thêm mới
                $_SESSION['card'][] = $product;
            }

            header("Location: ../src/card.php"); // Sau khi thêm vào giỏ hàng, chuyển đến trang giỏ hàng
            exit();
        }
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
// Kiểm tra xem có yêu cầu thêm sản phẩm vào giỏ hàng không mooncake
if (isset($_GET['add_to_card'])) {
    $productId = $_GET['add_to_card'];

    // Kết nối cơ sở dữ liệu để lấy thông tin sản phẩm
    include('../src/connect.php');
    
    try {
        // Lấy thông tin sản phẩm từ cơ sở dữ liệu
        $query = "SELECT * FROM mooncake WHERE id = :productId";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();

        // Kiểm tra nếu tìm thấy sản phẩm
        if ($stmt->rowCount() > 0) {
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $found = false;
            foreach ($_SESSION['card'] as &$cartProduct) {
                if ($cartProduct['id'] == $product['id']) {
                    $cartProduct['quantity']++; // Nếu có, tăng số lượng lên
                    $found = true;
                    break;
                }
            }

            // Nếu sản phẩm chưa có trong giỏ, thêm mới và gán quantity là 1
            if (!$found) {
                $product['quantity'] = 1; // Mặc định là 1 khi thêm mới
                $_SESSION['card'][] = $product;
            }

            header("Location: ../src/card.php"); // Sau khi thêm vào giỏ hàng, chuyển đến trang giỏ hàng
            exit();
        }
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}

// Cập nhật số lượng sản phẩm trong giỏ hàng khi người dùng nhấn cộng hoặc trừ
if (isset($_GET['update_quantity'])) {
    $productId = $_GET['product_id'];
    $action = $_GET['action'];

    foreach ($_SESSION['card'] as &$product) {
        if ($product['id'] == $productId) {
            if ($action == 'increase') {
                $product['quantity']++;
            } elseif ($action == 'decrease' && $product['quantity'] > 1) {
                $product['quantity']--;
            }

            // Nếu số lượng bằng 0, xóa sản phẩm khỏi giỏ hàng
            if ($product['quantity'] == 0) {
                unset($product);
            }
            break;
        }
    }
    $_SESSION['card'] = array_values($_SESSION['card']); // Đảm bảo giỏ hàng không chứa các mục null
    header("Location: ../src/card.php"); // Sau khi cập nhật, chuyển đến trang giỏ hàng
    exit();
}

// Kiểm tra xem có yêu cầu xóa sản phẩm không
if (isset($_GET['remove_from_card'])) {
    $productId = $_GET['remove_from_card'];

    // Tìm sản phẩm trong giỏ hàng và xóa nó
    foreach ($_SESSION['card'] as $key => $product) {
        if ($product['id'] == $productId) {
            unset($_SESSION['card'][$key]); // Xóa sản phẩm khỏi giỏ hàng
            break; // Dừng vòng lặp sau khi đã xóa
        }
    }

    // Đảm bảo các mục không chứa các giá trị null
    $_SESSION['card'] = array_values($_SESSION['card']);
    // Chuyển hướng lại trang giỏ hàng
    header("Location: ../src/card.php?message=removed");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="../style/card.css">
</head>
<body>
    <?php include('../src/header.php'); ?>

    <div class="container">
        <h2>Giỏ hàng của bạn</h2>

        <?php if (empty($_SESSION['card'])): ?>
            <p>Giỏ hàng của bạn trống!</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                    <th>Thao tác</th>
                </tr>

                <?php
                $total = 0; // Tổng giá trị giỏ hàng
                foreach ($_SESSION['card'] as $product) {
                    // Tính tổng cho mỗi sản phẩm
                    $productTotal = $product['price'] * $product['quantity'];
                    $total += $productTotal;
                ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="100"></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</td>
                    <td>
                        <a href="../src/card.php?update_quantity=1&product_id=<?php echo $product['id']; ?>&action=increase">+</a>
                        <?php echo $product['quantity']; ?>
                        <a href="../src/card.php?update_quantity=1&product_id=<?php echo $product['id']; ?>&action=decrease">-</a>
                    </td>
                    <td><?php echo number_format($product['price'] * $product['quantity'], 0, ',', '.'); ?> VNĐ</td>
                    <td>
                        <a href="javascript:void(0);" onclick="removeFromCart(<?php echo $product['id']; ?>)" class="remove-btn">Xóa</a>
                    </td>
                </tr>
                <?php } ?>
            </table>

            <div class="total">
                <h3>Tổng cộng: <?php echo number_format($total, 0, ',', '.'); ?> VNĐ</h3>
            </div>

            <div class="checkout">
                <button onclick="location.href='../src/checkout.php'">Tiến hành đặt hàng</button>
            </div>
        <?php endif; ?>
    </div>

    <?php include('../src/footer.php'); ?>

    <div class="alert" id="alert">Sản phẩm đã được xóa khỏi giỏ hàng!</div>

    <script>
        // Kiểm tra xem có thông báo xóa không
        <?php if (isset($_GET['message']) && $_GET['message'] == 'removed'): ?>
            showAlert();
        <?php endif; ?>

        // Xử lý sự kiện xóa sản phẩm
        function removeFromCart(productId) {
            if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?")) {
                window.location.href = "../src/card.php?remove_from_card=" + productId;
            }
        }

        function showAlert() {
            const alertBox = document.getElementById("alert");
            alertBox.style.display = "block";
            setTimeout(() => {
                alertBox.style.display = "none";
            }, 2000); // Ẩn thông báo sau 2 giây
        }
    </script>
</body>
</html>
