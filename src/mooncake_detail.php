<?php
// Kết nối với cơ sở dữ liệu
include '../src/connect.php';
include '../src/header.php';

// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id > 0) {
    try {
        // Lấy thông tin chi tiết sản phẩm từ cơ sở dữ liệu
        $stmt = $conn->prepare("SELECT * FROM mooncake WHERE id = :id");
        $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Kiểm tra nếu sản phẩm tồn tại
        if (!$product) {
            echo "Sản phẩm không tồn tại.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Lỗi khi truy xuất dữ liệu: " . $e->getMessage();
        exit;
    }
} else {
    echo "ID sản phẩm không hợp lệ.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm - <?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="../style/product-detail.css">
</head>
<body>

<<div class="product-detail-container">
    <div class="product-detail-slider">
        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
    </div>
    <div class="product-detail-info">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <p class="product-description"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        <p class="product-price">Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
        
        <!-- Thêm vào giỏ hàng và mua ngay -->
        <a class="add-to-card" href="../src/product-detail.php?id=<?php echo $product['id']; ?>" onclick="addToCart(event, <?php echo $product['id']; ?>)">Thêm vào giỏ hàng</a>
        <button class="buy-now" onclick="buyNow(<?php echo $product['id']; ?>)">Mua ngay</button>
      <a href="../src/mooncake.php"> <button class="continue-buy">Tiếp tục mua hàng</button> </a>
        <div class="product-promotion">
            <h3>Khuyến mãi đặc biệt:</h3>
            <ul>
                <li><ul>Tặng kèm 1 hộp đường phèn + 1 túi táo đỏ</ul></li>
                <li>Sản phẩm đi kèm hộp + túi đựng cao cấp</li>
                <li>Tổ yến tinh chế được làm sạch thủ công, tổ đẹp, sợi dài và dày khít chặt</li>
                <li><b>Yến sào Bửu Yến được kiểm nghiệm đạt tiêu chuẩn ISO/IEC 17025:2005 VILAS 357</b></li>
                <li style="color:green">Bửu Yến cam kết 100% hàng chất lượng, được kiểm định và quản lý nghiêm ngặt; dịch vụ khách hàng chuyên nghiệp; hỗ trợ đổi/trả nhanh cho bất kỳ sai sót nào</li>
                <li style="color:green">Tặng kèm bộ chén muỗng sứ Minh Long hoặc 1 hộp saffron với hoá đơn trên 3.000.000 VND (chương trình có thể kết thúc sớm – số lượng có hạn)</li>
            </ul>
        </div>
    </div>
    
</div>


<script>
   function buyNow(productId) {
    window.location.href = "../src/card.php?add_to_card=" + productId;
}

function addToCart(event, productId) {
    event.preventDefault();  // Ngừng hành động mặc định của liên kết

    let button = event.target;
    button.style.backgroundColor = 'green';  // Thay đổi màu nền của nút
    button.innerHTML = 'Đã thêm vào giỏ hàng';  // Thay đổi nội dung của nút

    // Gửi yêu cầu AJAX đến server để thêm sản phẩm vào giỏ hàng
    fetch('../src/card.php?add_to_card=' + productId)
        .then(response => response.json())  // Giả sử server trả về JSON
        .then(data => {
            // Có thể xử lý thêm thông tin từ server nếu cần (ví dụ: cập nhật số lượng trong giỏ hàng)
            setTimeout(() => {
                button.style.backgroundColor = '';  // Đặt lại màu nền của nút
                button.innerHTML = 'Thêm vào giỏ hàng';  // Đặt lại nội dung của nút
            }, 2000);  // Chờ 2 giây để nút trở lại trạng thái ban đầu
        })
        .catch(error => console.error('Error:', error));
}

</script>

<style>
.add-to-card {
    padding: 10px 20px;
    background-color: #ff9900;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-right: 10px;
}

.add-to-card:hover {
    background-color: #e68a00;
}

.add-to-card:active {
    background-color: #cc7a00;
}
</style>

</body>
</html>

<?php 
include '../src/footer.php';
?>