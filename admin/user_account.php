<?php   
include '../components/connect.php';  

// Kiểm tra nếu người dùng đã đăng nhập với quyền admin  
if (isset($_COOKIE['seller_id'])) {  
    $seller_id = $_COOKIE['seller_id'];  
} else {  
    $seller_id = '';  
    header('location:login.php');  
}  

// Xóa người dùng khỏi cơ sở dữ liệu  
if (isset($_POST['delete'])) {  
    $delete_id = $_POST['delete_id'];  
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);  
    
    $verify_delete = $conn->prepare("SELECT * FROM `users` WHERE id = ?");  
    $verify_delete->execute([$delete_id]);  
    
    if ($verify_delete->rowCount() > 0) {  
        $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");  
        $delete_user->execute([$delete_id]);  
        
        $success_msg[] = 'Người dùng đã bị xóa';  
    } else {  
        $warning_msg[] = 'Người dùng không tồn tại';  
    }  
}  
?>  

<!DOCTYPE html>  
<html>  
<head>  
    <meta charset="utf-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>  
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css?v=<?php echo time(); ?>">  
    <title>Cửa Hàng - Vườn Hoa Tươi - Trang Người Dùng Đã Đăng Ký</title>  
</head>  
<body>  

    <?php include '../components/admin_header.php'; ?>  
    <div class="banner">  
        <div class="detail">  
            <h1>Người Dùng Đã Đăng Ký</h1>  
            <p>Chào mừng bạn đến với 'Vườn Hoa Tươi'. Bạn đã đăng ký thành công và giờ có thể khám phá các sản phẩm hoa tươi tuyệt vời của chúng tôi. Hãy cập nhật thông tin cá nhân và bắt đầu trải nghiệm mua sắm ngay hôm nay!</p>  
            <span><a href="dashboard.php">admin</a><i class="bx bx-right-arrow-alt"></i> Người Dùng Đã Đăng Ký</span>  
        </div>  
    </div>  
    <div></div>  
    <section class="user-container">  
        <div class="heading">  
            <h1>Người Dùng Đã Đăng Ký</h1>  
            <img src="../image/separator.png">  
        </div>  

        <div class="box-container">  
        <?php  
            $select_users = $conn->prepare("SELECT * FROM `users`");  
            $select_users->execute();  
            if ($select_users->rowCount() > 0) {  
                while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)) {  
                    $user_id = $fetch_users['id'];  
        ?>  
        <div class="box">  
            <img src="../uploaded_files/<?= $fetch_users['image']; ?>">  
            <div class="detail">  
                <p>ID người dùng : <span><?= $user_id; ?></span></p>  
                <p>Tên người dùng : <span><?= $fetch_users['name']; ?></span></p>  
                <p>Email người dùng : <span><?= $fetch_users['email']; ?></span></p>  
                <form action="" method="post" style="margin-top: 10px;">  
                    <input type="hidden" name="delete_id" value="<?= $user_id; ?>">  
                    <button type="submit" name="delete" class="btn" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">Xóa</button>  
                </form>  
            </div>  
        </div>  
        <?php  
                }  
            } else {  
                echo '  
                <div class="empty" style="margin: 2rem auto;">  
                    <p>Chưa có người dùng nào đăng ký</p>  
                </div>';  
            }  
        ?>  
        </div>  
        
    </section>  

    <?php include '../components/admin_footer.php'; ?>  

    <!-- alert -->  
    <?php if (isset($success_msg)): ?>  
        <script>  
            alert("<?= implode('\n', $success_msg); ?>");  
        </script>  
    <?php endif; ?>  
    <?php if (isset($warning_msg)): ?>  
        <script>  
            alert("<?= implode('\n', $warning_msg); ?>");  
        </script>  
    <?php endif; ?>  

</body>  
</html>