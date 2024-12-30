<?php   
include '../components/connect.php';  

// Kiểm tra nếu người dùng đã đăng nhập với quyền admin  
if (isset($_COOKIE['admin_id'])) {  
    $admin_id = $_COOKIE['admin_id'];  
} 

// Xóa người đăng ký  
if (isset($_POST['delete'])) {  
    $delete_id = $_POST['delete_id'];  
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);  
    
    $verify_delete = $conn->prepare("SELECT * FROM `subscribers` WHERE id = ?");  
    $verify_delete->execute([$delete_id]);  
    
    if ($verify_delete->rowCount() > 0) {  
        $delete_subscriber = $conn->prepare("DELETE FROM `subscribers` WHERE id = ?");  
        $delete_subscriber->execute([$delete_id]);  
        
        $success_msg[] = 'Người đăng ký đã bị xóa';  
    } else {  
        $warning_msg[] = 'Người đăng ký không tồn tại';  
    }  
}  
?>  

<!DOCTYPE html>  
<html lang="vi">  
<head>  
    <meta charset="utf-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css?v=<?php echo time(); ?>">  
    <title>Quản Lý Người Đăng Ký Nhận Bản Tin</title>  
</head>  
<body>  

    <?php include '../components/admin_header.php'; ?>  
    
    <div class="banner">  
        <div class="detail">  
            <h1>Người Đăng Ký Nhận Bản Tin</h1>  
            <p>Quản lý danh sách người dùng đã đăng ký nhận bản tin.</p>  
            <span><a href="dashboard.php">Quản trị viên</a><i class="bx bx-right-arrow-alt"></i> Người Đăng Ký</span>  
        </div>  
    </div>  

    <section class="message-container">  
        <div class="heading">  
            <h1>Danh Sách Người Đăng Ký Nhận Bản Tin</h1>  
            <img src="../image/separator.png">  
        </div>  

        <div class="box-container">  
            <?php  
                $select_subscribers = $conn->prepare("SELECT * FROM `subscribers`");  
                $select_subscribers->execute();  

                if ($select_subscribers->rowCount() > 0) {  
                    while($fetch_subscriber = $select_subscribers->fetch(PDO::FETCH_ASSOC)){  
            ?>   
            <div class="box">  
                <h3 class="name"><?= htmlspecialchars($fetch_subscriber['email']); ?></h3>  
                <p>Ngày đăng ký: <?= htmlspecialchars($fetch_subscriber['created_at']); ?></p>  
                <form action="" method="post">  
                    <input type="hidden" name="delete_id" value="<?= $fetch_subscriber['id']; ?>">  
                    <button type="submit" name="delete" class="btn" onclick="return confirm('Bạn có chắc chắn muốn xóa người đăng ký này không?');">Xóa</button>  
                </form>  
            </div>   
            <?php  
                    }   
                } else {  
                    echo '<div class="empty" style="margin: 2rem auto;">  
                            <p>Không có người đăng ký nào</p>  
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