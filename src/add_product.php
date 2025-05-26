<?php
include '../src/connect.php'; 
include '../src/header_admin.php'; 

$message = ""; // Biến chứa thông báo

// Kiểm tra nếu là yêu cầu POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Lấy dữ liệu từ form
        $productType = $_POST['product_type'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        
        // Xử lý tải lên hình ảnh
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $fileName = uniqid() . '-' . basename($_FILES['image']['name']);
            $uploadFilePath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFilePath)) {
                // Kiểm tra loại sản phẩm và chuẩn bị câu lệnh SQL tương ứng
                if ($productType === 'yentinhche') {
                    $sql = "INSERT INTO products (name, price, description, image) VALUES (:name, :price, :description, :image)";
                } elseif ($productType === 'mooncake') {
                    $sql = "INSERT INTO mooncake (name, price, description, image) VALUES (:name, :price, :description, :image)";
                }

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':image', $uploadFilePath);
                $stmt->execute();

                // Gán thông báo thành công
                $message = "Sản phẩm đã được thêm thành công!";
            } else {
                $message = "Lỗi khi tải lên hình ảnh.";
            }
        } else {
            $message = "Vui lòng chọn một tệp hình ảnh để tải lên.";
        }
    } catch (PDOException $e) {
        $message = "Lỗi khi thêm sản phẩm: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Quản lý sản phẩm</title>
    <link rel="stylesheet" href="../style/add_product.css">
</head>
<body>
    <div class="container">
        <h2>Thêm sản phẩm mới</h2>

        <!-- Hiển thị thông báo nếu có -->
        <?php if ($message): ?>
            <div id="successMessage"><?php echo $message; ?></div>
        <?php endif; ?>

        <form id="productForm" enctype="multipart/form-data" method="POST">
            <label for="product_type">Loại sản phẩm</label>
            <select name="product_type" id="product_type" required>
                <option value="yentinhche">Yến tinh chế cao cấp</option>
                <option value="mooncake">Bánh trung thu</option>
            </select>

            <label for="name">Tên sản phẩm</label>
            <input type="text" name="name" id="name" required>

            <label for="price">Giá sản phẩm</label>
            <input type="text" name="price" id="price" required>

            <label for="description">Mô tả</label>
            <textarea name="description" id="description" required></textarea>

            <label for="image">Hình ảnh</label>
            <input type="file" name="image" id="image" accept="image/*">

            <button type="submit">Thêm sản phẩm</button>
        </form>
    </div>
</body>
</html>
