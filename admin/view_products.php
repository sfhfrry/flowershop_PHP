<?php 
      include '../components/connect.php';
    
      if (isset($_COOKIE['seller_id'])) {  
        $seller_id = $_COOKIE['seller_id'];  
    } else {  
        $seller_id = '';  
        header('location:login.php');  
    }

    if (isset($_POST['delete'])) {  
        $p_id = $_POST['product_id'];  
        $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);  
        $delete_product = $conn->prepare("DELETE FROM `products` WHERE id=?");  
        $delete_product->execute([$p_id]);  
        $success_msg[] = 'Sản phẩm đã được xóa thành công';  
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
        <title>Cửa hàng - Vườn Hoa Tươi - Xem sản phẩm hoa</title>
    </head>
    <body>

        <?php include '../components/admin_header.php'; ?>
        <div class="banner">  
            <div class="detail">  
                <h1>Xem Sản Phẩm</h1>
                <p>Khám phá bộ sưu tập hoa tươi tuyệt đẹp của chúng tôi! Chúng tôi cung cấp nhiều loại hoa phù hợp với mọi dịp và sự kiện. Hãy chọn lựa những bó hoa yêu thích của bạn ngay hôm nay!</p>

                <span><a href="dashboard.php">admin</a><i class="bx bx-right-arrow-alt"></i>Xem sản phẩm</span>  
            </div>  
        </div>
        <div></div>
        <section class="show_products">
            <div class="heading">
                <h1>Sản Phẩm của bạn</h1>
                <img src="../image/separator.png">
            </div>

            <div class="box-container">  
                    <?php  
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ?");  
                    $select_products->execute([$seller_id]); 

                    if($select_products->rowCount() > 0){  
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {  

                    ?>  
                    <form action="" method="post" class="box">  
                        <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">  
                        <?php if($fetch_products['image'] != '') { ?>  
                            <img src="../image/products/<?= $fetch_products['image']; ?>"  class="image">   
                        <?php } ?> 
                   
                        <div class="status" style="color: <?php if($fetch_products['status']=='active'){echo "limegreen";}else{echo "red";} ?>">
                            <?= $fetch_products['status'] == 'active' ? 'Hoạt động' : 'Không hoạt động'; ?>
                        </div>        
                            
                    <p class="price"><?= $fetch_products['price']; ?> </p>  
                    <div class="content">  
                        <div class="title"><?= $fetch_products['name']; ?></div>  
                        <div class="flex-btn">  
                            <a href="edit_product.php?id=<?= $fetch_products['id']; ?>" class="btn">Sửa</a>  
                            <button type="submit" name="delete" class="btn" onclick="confirm('xóa sản phẩm này');">Xóa</button>  
                            <a href="read_product.php?post_id=<?= $fetch_products['id']; ?>" class="btn">Xem sản phẩm</a>  
                        </div>  
                    </div>
 
                    </form>  
                    <?php
                            }
                        }else{  
                    echo '  
                        <div class="empty">  
                        <p>chưa có sản phẩm nào được thêm vào ! <br> <a href="add_product.php" class="btn" style="margin-top: 1rem;">Thêm Sản Phẩm</a></p>  
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