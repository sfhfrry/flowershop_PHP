<?php 
      include '../components/connect.php';
    
      if (isset($_COOKIE['seller_id'])) {  
        $seller_id = $_COOKIE['seller_id'];  
    } else {  
        $seller_id = '';  
        header('location:login.php');  
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
        <title>Admin -  Quản lý cửa hàng</title>
    </head>
    <body>

        <?php include '../components/admin_header.php'; ?>
        <div class="banner">  
            <div class="detail">   
                <h1>Thông điệp của chúng tôi</h1>
                <p>Chúng tôi luôn cam kết mang đến cho bạn những bông hoa đẹp nhất, tươi mới và chất lượng. Mỗi bó hoa là một tác phẩm nghệ thuật, được lựa chọn và chăm sóc tỉ mỉ để bạn có thể cảm nhận được sự tinh tế trong từng cánh hoa.</p>
                <span><a href="dashboard.php">Quản Trị Viên</a><i class="bx bx-right-arrow-alt"></i> Quản lý cửa hàng</span>  
            </div>  
        </div>

        <section class="dashboard">
            <div class="heading">
                <h1> Quản lý cửa hàng</h1>
                <img src="../image/separator.png" width="100">
            </div>
            <div class="box-container">  
                <div class="box">  
                    <h3>Chào mừng bạn!</h3>  
                    <p><?= $fetch_profile['name']; ?></p>  
                    <a href="update.php" class="btn">Cập nhật hồ sơ</a>   
                </div>  
                
                <div class="box">  
                    <?php  
                    $select_message = $conn->prepare("SELECT * FROM `message`");  
                    $select_message->execute();  
                    $number_of_msg = $select_message->rowCount();  
                    ?>  
                    <h3><?=  $number_of_msg; ?></h3>  
                    <p>tin nhắn chưa đọc</p>  
                    <a href="admin_message.php" class="btn">xem tin nhắn</a>  
                </div>  

                <div class="box">  
                <?php  
                    $select_product = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ?");  
                    $select_product->execute([$seller_id]);  
                    $num_of_product = $select_product->rowCount();  
                    ?>  
                    <h3><?= $num_of_product; ?></h3>  
                    <p>sản phẩm đã thêm</p>  
                    <a href="add_product.php" class="btn">thêm sản phẩm mới</a>  

                </div> 
                
                <div class="box">  
                <?php  
                    $select_active_product = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ? AND status=?");  
                    $select_active_product->execute([$seller_id, 'active']);  
                    $num_of_active_product = $select_active_product->rowCount();  
                    ?>  
                    <h3><?= $num_of_active_product; ?></h3>  
                    <p>số sản phẩm đang hoạt động</p>  
                    <a href="view_products.php" class="btn">xem sản phẩm đang hoạt động</a>  

                </div>  

                <div class="box">  
                <?php  
                    $select_deactive_product = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ? AND status=?");  
                    $select_deactive_product->execute([$seller_id, 'deactive']);  
                    $num_of_deactive_product = $select_deactive_product->rowCount();  
                    ?>  
                    <h3><?= $num_of_deactive_product; ?></h3>  
                    <p>số sản phẩm không hoạt động</p>  
                    <a href="view_products.php" class="btn">xem sản phẩm không hoạt động</a>

                </div>  

                <div class="box">  
                <?php  
                    $select_users = $conn->prepare("SELECT * FROM `users` ");  
                    $select_users->execute();  
                    $num_of_users = $select_users->rowCount();  
                    ?>  
                    <h3><?= $num_of_users; ?></h3>  
                    <p>số lượng người dùng đã đăng ký</p>  
                    <a href="user_account.php" class="btn">xem người dùng</a>

                </div>  

                <div class="box">  
                <?php  
                    $select_sellers = $conn->prepare("SELECT * FROM `sellers` ");  
                    $select_sellers->execute();  
                    $num_of_sellers = $select_sellers->rowCount();  
                    ?>  
                    <h3><?= $num_of_sellers; ?></h3>  
                    <p>số lượng người bán đã đăng ký</p>  
                    <a href="seller_account.php" class="btn">xem người bán</a>

                </div>
                <div class="box">  
                    <?php  
                        // Giả định rằng $seller_id đã được thiết lập trước  
                        $select_cancel_order = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ? AND status = ?");       
                        $select_cancel_order->execute([$seller_id, 'Đã Hủy']);  
                        $total_cancel_order = $select_cancel_order->rowCount();  
                    ?>  
                    <h3><?= htmlspecialchars($total_cancel_order); ?></h3>  
                    <p>đơn hàng đã hủy</p>  
                    <a href="admin_order_canceled.php" class="btn">Xem đơn hàng đã hủy</a>  
                </div>
                <div class="box">  
                <?php  
                    $select_confirm_orders = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ?");  
                    $select_confirm_orders->execute([$seller_id]);  
                    $total_confirm_orders = $select_confirm_orders->rowCount();  
                    ?>  
                    <h3><?= $total_confirm_orders; ?></h3>  
                    <p>Đơn hàng được xác nhận</p>  
                    <a href="admin_order.php" class="btn">Đơnn hàng được xác nhận</a>
                </div> 

                
                <div class="box">  
                <?php  
                    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ?");  
                    $select_orders->execute([$seller_id]);  
                    $total_orders = $select_orders->rowCount();  
                    ?>  
                    <h3><?= $total_orders; ?></h3>  
                    <p>tổng số đơn đặt hàng</p>  
                    <a href="admin_order.php" class="btn">tổng số đơn đặt hàng</a>
                </div> 
                
                <div class="box">  
                    <?php  
                    $select_subscriber = $conn->prepare("SELECT * FROM `subscribers`");  
                    $select_subscriber->execute();  
                    $number_of_sub = $select_subscriber->rowCount();  
                    ?>  
                    <h3><?=  $number_of_sub; ?></h3>  
                    <p>Emai nhận bản tin</p>  
                    <a href="admin_subscribers.php" class="btn">Eamil nhận bảng tin</a>  
                </div>  

                
                <div class="box">  
                    <?php  
                    // Giả sử $conn là kết nối PDO đã được thiết lập trước đó  
                    $select_orders = $conn->prepare("SELECT * FROM `orders`");  
                    $select_orders->execute();  
                    $number_of_orders = $select_orders->rowCount();  
                    ?>  
                    <p>Thống kê hóa đơn</p>  
                    <a href="sales_stats.php" class="btn">Xem chi tiết</a>  
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