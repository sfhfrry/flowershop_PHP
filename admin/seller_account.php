<?php 
      include '../components/connect.php';
    
      if (isset($_COOKIE['seller_id'])) {  
        $seller_id = $_COOKIE['seller_id'];  
    } else {  
        $seller_id = '';  
        header('location:login.php');  
    }


    // delete message from database  
        if (isset($_POST['delete'])) {  
            $delete_id = $_POST['delete_id'];  
            $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);  
            
            $verify_delete = $conn->prepare("SELECT * FROM `message` WHERE id = ?");  
            $verify_delete->execute([$delete_id]);  
            
            if ($verify_delete->rowCount() > 0) {  
                $delete_message = $conn->prepare("DELETE FROM `message` WHERE id = ?");  
                $delete_message->execute([$delete_id]);  
                
                $success_msg[] = 'tin nhắn đã bị xóa';  
            } else {  
                $warning_msg[] = 'tin nhắn đã bị xóa';  
            }  
        }
                    
    ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content=" width=device-width, initial-scale=1">
        <!-- box icon cdn link -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" type="text/css" href="../css/admin_style.css?v=<?php echo time(); ?>">
        <title>Của Hàng -Vườn Hoa Tươi - Trang Người Dùng Đã Đăng Ký</title>
    </head>
    <body>

        <?php include '../components/admin_header.php'; ?>
        <div class="banner">  
            <div class="detail">  
                <h1>Người Bán Đăng Ký</h1>  
                <p>Chào mừng bạn đến với 'Vườn Hoa Tươi' Bạn đã đăng ký thành công và giờ có thể khám phá các sản phẩm hoa tươi tuyệt vời của chúng tôi. Hãy cập nhật thông tin cá nhân và bắt đầu trải nghiệm mua sắm ngay hôm nay!</p>  
                <span><a href="dashboard.php">admin</a><i class="bx bx-right-arrow-alt"></i> Người Bán Đã Đăng Ký</span>  
            </div>  
        </div>
        <div></div>
        <section class="seller-container">
            <div class="heading">
                <h1>Người Bán Đã Đăng Ký</h1>
                <img src="../image/separator.png">
            </div>

            <div class="box-container">  
            <?php  
                $select_seller = $conn->prepare("SELECT * FROM `sellers`");  
                $select_seller->execute();  
                if ($select_seller->rowCount() > 0) {  
                    while ($fetch_seller = $select_seller->fetch(PDO::FETCH_ASSOC)) {  
                        $seller_id = $fetch_seller['id'];  
            ?>
            <div class="box">  
                <img src="../uploaded_files/<?= $fetch_seller['image']; ?>">  
                <div class="detail">  
                    <p>ID Bán : <span><?= $seller_id; ?></span></p>  
                    <p>Tên người Bán : <span><?= $fetch_seller['name']; ?></span></p>  
                    <p>Email người bán : <span><?= $fetch_seller['email']; ?></span></p>  
                </div>  
            </div>
            <?php
                    }  
                }else {  
                    echo '  
                    <div class="empty" style="margin: 2rem auto;">  
                        <p>chưa có người dùng nào đăng ký </p>  
                    </div>  
                    ';  
                }  
                ?>  
            </div>
            
        </section>


        <?php include '../components/admin_footer.php'; ?>

        <!-- sweetalert cdnlink -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <!-- cusstom js link -->
         <script type="text/javascript" src="../js/admin_script.js"></script>
        <!-- alert -->
        <?php include '../components/alert.php'; ?>

    </body>
</html>