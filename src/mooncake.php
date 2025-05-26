<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa và vai trò có phải là user không
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

include('../src/connect.php'); // Kết nối cơ sở dữ liệu

try {
    $query = "SELECT * FROM mooncake";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $mooncake = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $mooncake = [];
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
        <h2><i class="fa-solid fa-fire"></i>Nhân Bánh Trung Thu Yến Sào
Bửu Yến Mooncake
</h2>
<img src="../image/Others/moocake-banner.jpg" class="moon-cake"alt="MoonCake">
      
    </div>

    <div class="products-list">
        <?php if (!empty($mooncake)): ?>
            <?php foreach ($mooncake as $mooncake): ?>
                <div class="product">
                    <img src="<?php echo htmlspecialchars($mooncake['image']); ?>" alt="<?php echo htmlspecialchars($mooncake['name']); ?>">
                    <h2><?php echo htmlspecialchars($mooncake['name']); ?></h2>
                    <p style="color:red">Giá: <?php echo number_format($mooncake['price'], 0, ',', '.'); ?> VNĐ</p>
                    <a class="detail-button" href="../mooncake_detail.php?id=<?php echo $mooncake['id']; ?>">Xem chi tiết</a>
                    <a class="add-to-card" href="../card.php?add_to_card=<?php echo $mooncake['id']; ?>" onclick="addToCart(event, <?php echo $mooncake['id']; ?>)">Thêm vào giỏ hàng</a>
                    <button class="buy-now" onclick="buyNow(<?php echo $mooncake['id']; ?>)">Mua ngay</button>
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
    window.location.href = "../src/card.php?add_to_card=" + productId;
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



</body>
</html>

<?php include('footer.php'); ?>
