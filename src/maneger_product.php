<?php
include '../src/connect.php';
include '../src/header_admin.php';

// Xử lý yêu cầu xóa sản phẩm
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_type = $_POST['delete_type']; // Lấy loại bảng để xóa chính xác

    try {
        if ($delete_type === 'products') {
            $sql = "DELETE FROM products WHERE id = :id";
        } else {
            $sql = "DELETE FROM mooncake WHERE id = :id";
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $delete_id);
        $stmt->execute();
        $message = "Sản phẩm đã được xóa thành công!";
    } catch (PDOException $e) {
        $message = "Lỗi khi xóa sản phẩm: " . $e->getMessage();
    }
}

// Lấy danh sách sản phẩm từ bảng products
$sql_products = "SELECT *, 'Yến tinh chế cao cấp' AS category FROM products";
$stmt = $conn->prepare($sql_products);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Lấy danh sách sản phẩm từ bảng mooncake
$sql_mooncake = "SELECT *, 'Bánh trung thu' AS category FROM mooncake";
$stmt = $conn->prepare($sql_mooncake);
$stmt->execute();
$mooncakes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kết hợp hai danh sách sản phẩm
$all_products = array_merge($products, $mooncakes);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Quản lý sản phẩm</title>
    <link rel="stylesheet" href="../style/maneger_product.css">
</head>
<body>
<div class="table-container">
<h2 style="text-align: center;">Quản lý sản phẩm</h2>

<!-- Hiển thị thông báo nếu có -->
<?php if (isset($message)): ?>
    <script>alert("<?php echo $message; ?>");</script>
<?php endif; ?>

<!-- Hiển thị danh sách sản phẩm -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Mô tả</th>
            <th>Hình ảnh</th>
            <th>Loại sản phẩm</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($all_products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['id']); ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</td>
                <td><?php echo htmlspecialchars($product['description']); ?></td>
                <td><img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Image" width="100"></td>
                <td><?php echo htmlspecialchars($product['category']); ?></td>
                <td>
                    <!-- Form Xóa Sản phẩm -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="delete_type" value="<?php echo $product['category'] === 'Yến tinh chế cao cấp' ? 'products' : 'mooncake'; ?>">
                        <button type="submit" class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</button>
                    </form>
                    <!-- Nút Cập nhật -->
                    <button class="btn-update">
                        <a href="update_product.php?id=<?php echo $product['id']; ?>&type=<?php echo $product['category'] === 'Yến tinh chế cao cấp' ? 'products' : 'mooncake'; ?>">Cập nhật</a>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</body>
</html>
<?php
// include 'footer.php';
?>
