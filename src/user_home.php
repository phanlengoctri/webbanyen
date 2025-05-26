<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa và vai trò có phải là user không
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php"); // Nếu không phải user hoặc không có session, chuyển hướng về trang login
    exit();
}
?>
<?php
if (isset($_POST["submit"])){
    $name =$_POST["name"];
    $email =$_POST["email"];
    $message = $_POST["message"];

    $query = "INSERT INTO tb_contact VALUES('$name', '$email','$message')";

    mysqli_query($conn, $query);
}
include('../src/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yến Chưng Tươi - Nguyên Vị - Bửu Yến</title>
    <link rel="stylesheet" href="../style/home.css">
    <link rel='shortcut icon' href='..\image\Logo\Web-BuuYen-P-1-1-04.png' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../style/products.css">

</head>
<body >
        <div class="slider-wrapper">
    <div class="slider">
        <img src="../image/Sliders/imageyensao2.jpg" alt="Slide 1">
        <img src="../image/Sliders/imageyensao3.jpg" alt="Slide 2">
        <img src="../image/Sliders/imageyensao4.jpg" alt="Slide 3">
    </div>    
    <!-- Nút mũi tên -->
    <button class="prev" onclick="showPrevSlide()">&#10094;</button>
    <button class="next" onclick="showNextSlide()">&#10095;</button>
</div>

        <div class="products-list-3" >
            <h1 class="title"><i class="fa-brands fa-blogger-b"></i>Blogs Yến Sào</h1>    
            <h1 class="title-3">Giới Thiệu Về Bửu Yến</h1> 
                   
            <h4 class="content-3">Bửu Yến là thương hiệu chuyên cung cấp các dòng tổ yến & yến chưng cao cấp, đậm chất tinh hoa yến Việt. Được khai thác, chọn lọc, tinh chế và kiểm định qua các quy trình nghiêm ngặt.</h4>    
            <h4 class="content-3">Với hơn 10 năm kinh doanh trong lĩnh vực thực phẩm & quà tặng cao cấp.</h4>
            <h4 class="content-3">Bửu Yến tự tin là thương hiệu cung cấp sản phẩm chất lượng; dịch vụ quà tặng chuyên nghiệp, tinh tế, chỉn chu trong từng chi tiết. Quý khách hàng, doanh nghiệp có thể hoàn toàn yên tâm khi chọn các sản phẩm quà tặng Bửu Yến gửi đến gia đình, người thân, bạn bè, đối tác,….</h4>
                <div id="text-center">
                    <img src="..\image\Logo\thu-ngo-buu-yen.jpg" alt="">   
                </div>
            <h4 class="content-3">Sản phẩm yến chưng sẵn Bửu Yến nổi bật với 30% yến thật mỗi hủ vượt trội, đảm bảo uy tín và an toàn cho người tiêu dùng. </h4>
            <h4 class="content-3">Đặc biệt, sản phẩm đã được kiểm nghiệm và chứng nhận bởi Bureau Veritas, một công ty hàng đầu của Pháp chuyên thẩm định và kiểm soát chất lượng quốc tế. </h4>
            <h4 class="content-3">Với quy trình kiểm định nghiêm ngặt, Bửu Yến tự tin mang đến sản phẩm yến chưng sẵn không chỉ thơm ngon, bổ dưỡng mà còn đáp ứng các tiêu chuẩn an toàn thực phẩm cao nhất.</h4>
                <div id="text-center">
                    <img src="../image/Logo/giay-chung-nhan-yen-1.jpg" alt="">   
                </div>
            <h1 class="title-4">Thành phần của Yến Sào</h1> 

            <h4 class="content-3">Theo các nghiên cứu, thành phần yến sào chính là protein chiếm hàm lượng dinh dưỡng cực lớn với hơn 50%, còn lại là các loại axit amin và vi khoáng chất thiết yếu cho cơ thể.</h4>
            <h4 class="content-3">Cụ thể, trong 100gr tổ yến có chất dinh dưỡng gì đã được Bửu Yến tổng hợp chi tiết trong bảng sau:</h4>
  
                <div id="text-center">
                    <img src="../image/Logo/thanh-phan-yen-sao-100g.jpg" alt="">   
                </div>

            <h1 class="title-5">Tại sao chọn yến sào Bửu Yến?</h1> 
                <div id="text-center">
                    <img src="" alt="">
                </div> 
            <h4 class="content-3">Trải qua thời gian, sự thành công của yến sào Bửu Yến dần được khẳng định bởi chính sự yêu thương, trân trọng của khách hàng dành cho Bửu Yến.</h4>
            <h4 class="content-3">Để có được thành quả như ngày hôm nay, chính là sự tận tâm, nhiệt tình của cán bộ nhân viên Bửu Yến trong phong cách phục vụ cũng như sự chân thật, chất lượng cao, sang trọng, đẳng cấp của từng dòng sản phẩm yến sào Bửu Yến.</h4>
            <h4 class="content-3">Để đáp lại tình yêu thương mà khách hàng dành cho mình, Yến sào Bửu Yến luôn không ngừng nỗ lực để tạo ra những sản phẩm ngày càng tốt hơn, trở thành món quà ý nghĩa dành tặng cho mọi người.</h4>
            <p>
                <h4 class="content-3"><b>Con người:</b> Với đội ngũ nhân viên tài năng, chuyên nghiệp, và sự tận tâm trong phong cách phục vụ. Chúng tôi cam kết làm hài lòng mọi khách hàng dù là khách hàng khó tính nhất.</h4>
            </p>
            <p>
                <h4 class="content-3"><b>Chất lượng tuyệt vời:</b> Được lựa chọn kỹ lưỡng trước khi trải qua quy trình chế biến nghiêm ngặt. Những sản phẩm của yến sào Bửu Yến đáp ứng được những yêu cầu cao nhất về một sản phẩm thượng hạng.</h4>
            </p>
            <p>
                <h4 class="content-3"><b>Phát triển bền vững:</b> Để đạt được mục tiêu phát triển bền vững, chúng tôi đặc biệt hướng tới trách nhiệm lớn hơn trong việc cung cấp sản phẩm giá trị bền vững cho khách hàng. Tạo ra những tác động tích cực cho cộng đồng, xã hội và môi trường.</h4>
            </p>
            <p>
                <h4 class="content-3"><b>Chính sách bán hàng:</b>Ở yến sào Bửu Yến chúng tôi luôn có những chính sách bán hàng tốt dành cho khách hàng mua với số lượng lớn. Đặc biệt quan tâm đến giá trị cá nhân nếu khách hàng có nhu cầu thể hiện cá tính bản thân trên sản phẩm.</h4>
            </p>
            <p>
                <h4 class="content-3"><b>Dịch vụ quà tặng:</b> Để đáp ứng nhu cầu không chỉ sử dụng thông thường, yến sào Bửu Yến còn đáp ứng được nhu cầu làm quà biếu, quà tặng thể hiện tình yêu thương của khách hàng dành cho người thân, gia đình, khách hàng và đối tác.</h4>
            </p>
            <h1 class="title-5">Sản phẩm yến sào Bửu Yến</h1> 
            <h4 class="content-3">Hiện nay trên thị trường, yến sào Bửu Yến đang cung cấp những dòng sản phẩm từ <b>yến sào</b> như: yến chưng sẵn,<b>yến sào tinh chế, yến rút lông nguyên tổ, yến sào thô</b>,….</h4>
            <h4 class="content-3">Trong đó phải kể đến dòng sản phẩm nước yến chưng sẵn nổi trội rất được khách hàng yêu thích như: Yến chưng đông trùng hạ thảo, yến chưng hạt sen, yến chưng nhụy hoa nghệ tây, yến chưng táo đỏ, kỷ tử,…Để được tư vấn về sản phẩm, dịch vụ của yến sào Bửu Yến.</h4>
        </div> 


        <script>// Biến lưu chỉ số slide hiện tại
let currentSlide = 0; // Slide hiện tại
const slides = document.querySelectorAll('.slider img'); // Lấy tất cả các ảnh trong slider
const totalSlides = slides.length; // Tổng số ảnh

// Hàm chuyển đến slide tiếp theo
function nextSlide() {
  slides[currentSlide].classList.remove('active'); // Ẩn slide hiện tại
  currentSlide = (currentSlide + 1) % totalSlides; // Tăng chỉ số slide và quay về đầu nếu hết
  slides[currentSlide].classList.add('active'); // Hiển thị slide mới
}

// Hàm chuyển đến slide trước đó
function prevSlide() {
  slides[currentSlide].classList.remove('active'); // Ẩn slide hiện tại
  currentSlide = (currentSlide - 1 + totalSlides) % totalSlides; // Giảm chỉ số slide và quay về cuối nếu nhỏ hơn 0
  slides[currentSlide].classList.add('active'); // Hiển thị slide mới
}

// Tự động chuyển slide sau mỗi 3 giây
let slideInterval = setInterval(nextSlide, 3000);

// Thêm sự kiện cho các nút mũi tên
document.querySelector('.next').addEventListener('click', () => {
  clearInterval(slideInterval); // Ngừng tự động khi nhấp
  nextSlide();
  slideInterval = setInterval(nextSlide, 3000); // Khởi động lại
});

document.querySelector('.prev').addEventListener('click', () => {
  clearInterval(slideInterval); // Ngừng tự động khi nhấp
  prevSlide();
  slideInterval = setInterval(nextSlide, 3000); // Khởi động lại
});


</script>
</body>

</html>
<?php include('footer.php'); ?>