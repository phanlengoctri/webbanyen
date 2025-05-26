<?php
// Bắt đầu phiên làm việc (session)
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include('connect.php');  // Bao gồm tệp kết nối cơ sở dữ liệu

// Lấy thông tin người dùng từ session
$user_id = $_SESSION['id'];

// Truy vấn để lấy thông tin người dùng từ cơ sở dữ liệu
$query_user_info = "SELECT first_name, last_name, phone, birthdate, avatar FROM members WHERE id = :user_id";
$stmt_user_info = $conn->prepare($query_user_info);
$stmt_user_info->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_user_info->execute();
$user_info = $stmt_user_info->fetch(PDO::FETCH_ASSOC);

// Kiểm tra nếu không có thông tin người dùng
if (!$user_info) {
    echo "Không tìm thấy thông tin người dùng.";
    exit;
}

// Nếu form được submit, cập nhật thông tin người dùng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthdate'];

    // Xử lý upload avatar nếu có
    $avatar = $user_info['avatar']; // Giữ nguyên avatar cũ nếu không thay đổi

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $avatar_dir = 'image/avatars/';
        $avatar_file = $avatar_dir . basename($_FILES['avatar']['name']);
        
        // Kiểm tra loại file và kích thước file
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB
        
        if (in_array($_FILES['avatar']['type'], $allowed_types) && $_FILES['avatar']['size'] <= $max_size) {
            // Xóa avatar cũ nếu có và lưu avatar mới
            if ($user_info['avatar'] && file_exists($user_info['avatar'])) {
                unlink($user_info['avatar']);  // Xóa file avatar cũ
            }
            // Di chuyển ảnh mới vào thư mục avatars
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_file)) {
                $avatar = $avatar_file; // Cập nhật avatar mới
            }
        } else {
            echo "<script>alert('Chỉ chấp nhận hình ảnh JPEG, PNG hoặc GIF với dung lượng tối đa 2MB.');</script>";
        }
    }

    // Cập nhật thông tin vào cơ sở dữ liệu
    $query_update_info = "UPDATE members SET first_name = :first_name, last_name = :last_name, phone = :phone, birthdate = :birthdate, avatar = :avatar WHERE id = :user_id";
    $stmt_update_info = $conn->prepare($query_update_info);
    $stmt_update_info->bindParam(':first_name', $first_name);
    $stmt_update_info->bindParam(':last_name', $last_name);
    $stmt_update_info->bindParam(':phone', $phone);
    $stmt_update_info->bindParam(':birthdate', $birthdate);
    $stmt_update_info->bindParam(':avatar', $avatar);
    $stmt_update_info->bindParam(':user_id', $user_id);
    
    if ($stmt_update_info->execute()) {
        // Thông báo cập nhật thành công
        echo "<script>alert('Thông tin tài khoản đã được cập nhật thành công!'); window.location.href = 'account.php';</script>";
    } else {
        // Thông báo lỗi
        echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại sau.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin tài khoản</title>
    <link rel="stylesheet" href="style/edit_profile.css">
</head>
<body>
    <?php include('header.php'); ?> <!-- Bao gồm header -->

    <div class="container">
        <h2>Chỉnh sửa thông tin tài khoản</h2>
        
        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
            <div class="user-info">
                <div class="info-field">
                    <label for="first_name">Tên</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                <div class="info-field">
                    <label for="last_name">Họ</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
                <div class="info-field">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
                <div class="info-field">
                    <label for="birthdate">Ngày sinh</label>
                    <input type="date" id="birthdate" name="birthdate" required>
                </div>

                <!-- Avatar -->
                <div class="info-field">
                    <label for="avatar">Ảnh đại diện</label>
                    <input type="file" id="avatar" name="avatar" accept="image/*">
                </div>
            </div>

            <button type="submit" class="submit-btn">Cập nhật thông tin</button>

            <!-- Nút Quay lại -->
            <a href="account.php" class="back-btn">Quay lại</a>
        </form>
    </div>

    <?php include('footer.php'); ?> <!-- Bao gồm footer -->
</body>
</html>
