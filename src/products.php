<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa và vai trò có phải là user không
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: ../src/login.php");
    exit();
}

include('../src/connect.php'); // Kết nối cơ sở dữ liệu

try {
    $query = "SELECT * FROM products";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $products = [];
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if (!isset($_SESSION['card'])) {
    $_SESSION['card'] = []; // Khởi tạo giỏ hàng rỗng nếu chưa có
}

include('../src/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm - Yến Chưng Tươi</title>
    <link rel="stylesheet" href="../style/products.css">
</head>
<body>
<div class="slider-wrapper">
    <div class="slider">
        <img src="../image/Sliders/imageyensao2.jpg" alt="Slide 1">
        <img src="../image/Sliders/imageyensao3.jpg" alt="Slide 2">
        <img src="../image/Sliders/imageyensao4.jpg" alt="Slide 3">
    </div>    
    <button class="prev" onclick="showPrevSlide()">&#10094;</button>
    <button class="next" onclick="showNextSlide()">&#10095;</button>
</div>

<div class="container">
    <div class="title-product">
        <h2><i class="fa-solid fa-fire"></i>YẾN TINH CHẾ CAO CẤP LOẠI I</h2>
        <hr>
    </div>

    <div class="products-list">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                    <p style="color:red">Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                    <a class="detail-button" href="../src/product-detail.php?id=<?php echo $product['id']; ?>">Xem chi tiết</a>
                    <a class="add-to-card" href="../src/card.php?add_to_card=<?php echo $product['id']; ?>" onclick="addToCart(event, <?php echo $product['id']; ?>)">Thêm vào giỏ hàng</a>
                    <button class="buy-now" onclick="buyNow(<?php echo $product['id']; ?>)">Mua ngay</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không có sản phẩm nào.</p>
        <?php endif; ?>
    </div>
</div>

<script>
let currentSlide = 0;
const slides = document.querySelectorAll('.slider img');
const totalSlides = slides.length;

function nextSlide() {
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + 1) % totalSlides;
    slides[currentSlide].classList.add('active');
}

function prevSlide() {
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    slides[currentSlide].classList.add('active');
}

let slideInterval = setInterval(nextSlide, 3000);

document.querySelector('.next').addEventListener('click', () => {
    clearInterval(slideInterval);
    nextSlide();
    slideInterval = setInterval(nextSlide, 3000);
});

document.querySelector('.prev').addEventListener('click', () => {
    clearInterval(slideInterval);
    prevSlide();
    slideInterval = setInterval(nextSlide, 3000);
});

function buyNow(productId) {
    window.location.href = "card.php?add_to_card=" + productId;
}

function addToCart(event, productId) {
    event.preventDefault();
    
    let button = event.target;
    button.style.backgroundColor = 'green';
    button.innerHTML = 'Đã thêm vào giỏ hàng';
    
    fetch('../src/card.php?add_to_card=' + productId)
        .then(response => {
            setTimeout(() => {
                button.style.backgroundColor = '';
                button.innerHTML = 'Thêm vào giỏ hàng';
            }, 2000);
        });
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

<?php include('../src/footer.php'); ?>
