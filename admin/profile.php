<?php 
      include '../components/connect.php';
    
      if (isset($_COOKIE['seller_id'])) {  
        $seller_id = $_COOKIE['seller_id'];  
    } else {  
        $seller_id = '';  
        header('location:login.php');  
    }

        $select_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id=?");  
        $select_products->execute([$seller_id]);  
        $total_products = $select_products->rowCount();  

        $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE seller_id=?");  
        $select_orders->execute([$seller_id]);  
        $total_orders = $select_orders->rowCount();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content=" width=device-width, initial-scale=1">
        <!-- box icon cdn link -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" type="text/css" href="../css/admin_style.css?v=<?php echo time(); ?>">
        <title>Cửa hàng - Vườn Hoa Tươi - Hồ Sơ</title>
    </head>
    <body>

        <?php include '../components/admin_header.php'; ?>
        <div class="banner">  
            <div class="detail">  
                <h1>Hồ sơ người bán</h1>  
                <p>Quản lý thông tin cá nhân và các sản phẩm của bạn trên hệ thống, cập nhật hồ sơ và theo dõi hoạt động bán hàng của mình.</p>
                <span><a href="dashboard.php">admin</a><i class="bx bx-right-arrow-alt"></i>Hồ Sơ</span>  
            </div>  
        </div>
        <div></div>
        <section class="seller_profile">
            <div class="heading">
                <h1>Hồ sơ người bán</h1>
                <img src="../image/separator.png" width="100">
            </div>


            <div class="detail"> 
                <div class="seller">  
                    <img src="../uploaded_files/<?= $fetch_profile['image']; ?>">  
                    <h3><?= $fetch_profile['name']; ?></h3>  
                    <span>Quản lý cửa hàng của bạn</span>  
                    <a href="update.php" class="btn">Cập nhật thông tin cửa hàng</a>  
                </div>  
                
                <div class="flex">  
                        <div class="box">  
                            <span><?= $total_products; ?></span>  
                            <p>Tổng sản phẩm</p>  
                            <a href="view_products.php" class="btn">Xem sản phẩm</a>  
                        </div>  
                    <div class="box">  
                            <span><?= $total_orders; ?></span>  
                            <p>Tổng số đơn hàng đã đặt</p>  
                            <a href="admin_order.php" class="btn">Xem đơn hàng</a>  
                    </div>  
                </div>

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