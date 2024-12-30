<?php 
      include '../components/connect.php';
    
      if (isset($_COOKIE['seller_id'])) {  
        $seller_id = $_COOKIE['seller_id'];  
    } else {  
        $seller_id = '';  
        header('location:login.php');  
    }

    $get_id = $_GET['post_id'];

    if (isset($_POST['delete'])) {  
        $p_id = $_POST['product_id'];  
        $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);  
        
        $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");  
        $delete_image->execute([$p_id]);  
        $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);  
        
        if ($fetch_delete_image['image'] != '') {  
            unlink('../uploaded_files/' . $fetch_delete_image['image']);  
        }  
        
        $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");  
        $delete_product->execute([$p_id]);  
        
        header('location:view_products.php');  
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
        <title>Cửa hàng - Vườn Hoa Tươi </title>
    </head>
    <body>

        <?php include '../components/admin_header.php'; ?>
        <div class="banner">  
            <div class="detail">  
                <h1>Xem sản phẩm</h1>  
                <p>Đây là phần chi tiết của sản phẩm, nơi bạn có thể tìm thấy thông tin về sản phẩm, mô tả, giá cả và các đặc điểm nổi bật. Hãy khám phá các lựa chọn hoa đẹp để làm cho không gian của bạn thêm phần tươi mới.</p>  
                <span><a href="dashboard.php">admin</a><i class="bx bx-right-arrow-alt"></i>Xem sản phẩm</span>  
            </div>  
        </div>
        <div></div>
        <section class="read_product">
            <div class="heading">
                <h1>Chi tiết sản phẩm</h1>
                <img src="../image/separator.png">
            </div>

            <div class="box-container">  
                 <?php
                 $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");  
                 $select_product->execute([$get_id]);  
                 
                 if ($select_product->rowCount() > 0) {  
                     while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){  
                 ?>  
                 <form action="" method="post" class="box">  
                     <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>"> 

                     <div class="status" style="color: <?php if($fetch_product['status'] == 'active') {echo 'limegreen';} else {echo 'red';} ?>;">
                        <?= $fetch_product['status'] == 'active' ? 'Hoạt động' : 'Không hoạt động'; ?>
                    </div>

                <?php if($fetch_product['image'] != '') { ?>  
                    <img src="../image/products/<?= $fetch_product['image']; ?>"  class="image">   
                <?php } ?>
                <div class="price">VND<?= $fetch_product['price']; ?></div>  
                <div class="title"><?= $fetch_product['name']; ?></div>  
                <div class="content"><?= $fetch_product['product_detail']; ?></div>  
                <div class="flex-btn">  
                    <a href="edit_product.php?id=<?=$fetch_product['id']; ?>" class="btn">Sửa</a>  
                    <button type="submit" name="delete" class="btn" onclick="return confirm('xóa sản phẩm này');">Xóa</button>  
                    <a href="view_products.php?post_id=<?=$fetch_product['id']; ?>" class="btn">Trờ về</a>  
                </div>
                 </form>  
                 <?php  

                     }  
                    }else{  
                        echo '  
                            <div class="empty">  
                            <p>chưa có sản phẩm nào được thêm vào! <br> <a href="add_product.php" class="btn" style="margin-top: 1rem;">Thêm sản phẩm</a></p>  
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