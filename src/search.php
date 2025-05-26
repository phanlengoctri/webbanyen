<?php
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style\search.css">
    <title>Search Results</title>
</head>
<body>

<div class="content">
    <h2>Kết quả tìm kiếm:</h2>
    <div class="search-results">
    <?php
    include 'connect.php';

    // Kiểm tra nếu có từ khóa tìm kiếm
    if (isset($_GET['search_term'])) {
        $search_term = $_GET['search_term']; // Lấy từ khóa tìm kiếm từ URL

        // Tránh SQL injection bằng cách sử dụng prepared statements
        $query = "SELECT * FROM products WHERE name LIKE :search_term";
        $stmt = $conn->prepare($query);
        $stmt->execute(['search_term' => '%' . $search_term . '%']); // Tìm kiếm các sản phẩm có tên chứa từ khóa

        $results = $stmt->fetchAll();

        if ($results) {
            echo "<h2>Kết quả tìm kiếm:</h2>";
            echo "<div class='product-list'>"; // Thêm một thẻ div để chứa danh sách sản phẩm
            foreach ($results as $result) {
                $product_id = htmlspecialchars($result['id']); // Lấy id sản phẩm
                $product_name = htmlspecialchars($result['name']);
                $product_image = htmlspecialchars($result['image']);
                $product_description = htmlspecialchars($result['description']);
                $product_price = htmlspecialchars($result['price']);

                echo "<div class='product'>";
                echo "<a href='product-detail.php?id=$product_id'>"; // Thêm liên kết đến trang chi tiết sản phẩm
                echo "<img src='$product_image' alt='$product_name' class='product-image'>";
                echo "</a>";
                echo "<h3 class='product-name'>$product_name</h3>";
                echo "<p class='product-description'>$product_description</p>";
                echo "<p class='product-price'>Giá: $product_price VND</p>";
                echo "</div>"; // Đóng thẻ product
            }
            echo "</div>"; // Đóng thẻ product-list
        } else {
            echo "<p>Không tìm thấy sản phẩm nào với từ khóa '$search_term'.</p>";
        }
    } else {
        echo "<p>Vui lòng nhập từ khóa tìm kiếm.</p>";
    }
    ?>

    </div>
</div>

</body>
</html>
