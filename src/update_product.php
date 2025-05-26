<?php
include 'connect.php';
include 'header_admin.php';

// Kiểm tra nếu có ID sản phẩm cần cập nhật
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Lấy thông tin sản phẩm từ bảng products
    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch();

    // Nếu sản phẩm không có trong bảng products, kiểm tra bảng mooncake
    if (!$product) {
        $sql = "SELECT * FROM mooncake WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $product_id);
        $stmt->execute();
        $product = $stmt->fetch();

        // Nếu sản phẩm không có trong cả hai bảng, chuyển hướng về trang quản lý sản phẩm
        if (!$product) {
            header("Location:admin_home.php");
            exit();
        } else {
            $table = 'mooncake';  // Lưu bảng mà sản phẩm đang nằm
        }
    } else {
        $table = 'products';  // Nếu sản phẩm nằm trong bảng products
    }
}

// Cập nhật thông tin sản phẩm
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    try {
        // Lấy thông tin từ form
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        // Xử lý hình ảnh
        if ($_FILES['image']['error'] == 0) {
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            $image_path = '../uploads/' . $image_name;

            // Di chuyển file hình ảnh vào thư mục 'uploads'
            if (!move_uploaded_file($image_tmp, $image_path)) {
                throw new Exception('Không thể tải lên hình ảnh.');
            }
        } else {
            $image_path = $product['image'];
        }

        // Cập nhật thông tin sản phẩm vào bảng tương ứng
        $sql = "UPDATE $table SET name = :name, price = :price, description = :description, image = :image WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image_path);
        $stmt->bindParam(':id', $product_id);
        $stmt->execute();

        // Thông báo thành công
        $message = "Cập nhật sản phẩm thành công!";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'maneger_product.php';
                }, 3000);
              </script>";
        
    } catch (PDOException $e) {
        $message = "Lỗi khi cập nhật sản phẩm: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật sản phẩm</title>
    <link rel="stylesheet" href="../style/update_product.css">
</head>
<body>

<h2>Cập nhật sản phẩm</h2>
<hr>

<!-- Hiển thị thông báo sau khi bấm nút Cập nhật -->
<?php if ($message != ''): ?>
    <div style="color: green; font-weight: bold; text-align: center; margin: 20px;">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<!-- Form Cập nhật sản phẩm -->
<form method="POST" enctype="multipart/form-data">
    <div class="container">
        <label for="name">Tên sản phẩm</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

        <label for="price">Giá sản phẩm</label>
        <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>

        <label for="description">Mô tả</label>
        <textarea name="description" id="description" rows="10" cols="50" required><?php echo htmlspecialchars($product['description']); ?></textarea>

        <label for="image">Hình ảnh</label>
        <input type="file" name="image" id="image" accept="image/*">
        <div>
            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Current Product Image" width="100">
        </div>

        <div style="text-align: center;">
            <button type="submit" name="update">Cập nhật sản phẩm</button>
            <a href="../src/maneger_product.php" class="back-button">Quay lại</a>
        </div>
    </div>
</form>

</body>
</html>
