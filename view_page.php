<?php 
include 'components/connect.php';

if (isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else {
    $user_id = '' ;
}


$pid = $_GET['pid'];

include 'components/add_wishlist.php';
include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content=" width=device-width, initial-scale=1">
        <!-- box icon cdn link -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
        <title>Cửa hàng - Vườn Hoa Tươi </title> 
    </head>
    <body>
    <?php include 'components/user_header.php'; ?>

    <div class="banner">  
        <div class="detail">  
        <h1>Chi tiết sản phẩm</h1>  
        <p>Khám phá những sản phẩm hoa tươi tuyệt đẹp của chúng tôi, được chọn lọc kỹ càng để mang đến cho bạn những bó hoa rực rỡ, tươi mới nhất. Mỗi sản phẩm đều được thiết kế tinh tế, phù hợp với nhiều dịp lễ và sự kiện đặc biệt.</p>
            <span><a href="home.php">Trang Chủ</a><i class="bx bx-right-arrow-alt"></i>Chi tiết sản phẩm</span>  
        </div>  
    </div>
     

        <!-- -------------------products detail section start------------------->  
    
    <section class="view_page">
        <div class="heading">
            <h1>Chi tiết sản phẩm</h1>
            <img src="image/separator.png">
        </div>
        <?php 
            if(isset($_GET['pid'])) {
                $pid= $_GET['pid'];
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = '$pid'");   
                $select_product->execute();  

                if ($select_product->rowCount() > 0) {  
                    while ($fetch_products = $select_product->fetch(PDO::FETCH_ASSOC)) {  


                ?>  

                <form action="" method="post" class="box">  
                    <div class="img-box">  
                        <img src="image/products/<?= $fetch_products['image']; ?>">  
                    </div>  
                    <div class="detail">  
                        <?php if ($fetch_products['stock'] > 9) { ?>  
                            <span class="stock" style="color: green;">Còn hàng</span>  
                        <?php } elseif ($fetch_products['stock'] == 0) { ?>  
                            <span class="stock" style="color: red;">Hết hàng</span>  
                        <?php } else { ?>  
                            <span class="stock" style="color: red;">Chỉ còn <?=  $fetch_products['stock']; ?> Sản phẩm</span>  
                        <?php } ?>  

                        <div class="price">VND <?= $fetch_products['price']; ?> </div>  
                        <div class="name"><?= $fetch_products['name']; ?></div>  
                        <p class="product-detail"><?= $fetch_products['product_detail']; ?></p>  
                        <input type="hidden" name="product_id" value="<? $fetch_products['id']; ?>">  

                        <div class="button">  
                            <button type="submit" name="add_to_wishlist" class="btn">Thêm vào danh sách yêu thích <i class="bx bx-heart"></i></button>  
                            <input type="hidden" name="qty" min="0" value="0" class="quantity">  
                            <button type="submit" name="add_to_cart" class="btn">Thêm vào giỏ hàng<i class="bx bx-cart"></i></button>  
                        </div>

                    </div>  
                </form>  

                    <?php 


                    }
                }   

            }else{
                echo'
                    <div class="empty">  
                        <p>Chưa có sản phẩm nào được thêm vào! </p>  
                    </div>  
                
                ';
            }

        ?>
    </section>

    <section class="products">  
        <div class="heading">  
        <h1>Sản phẩm tương tự</h1>  
        <p>Khám phá thêm những sản phẩm hoa tuyệt đẹp khác từ chúng tôi. Mỗi bó hoa đều được chọn lọc kỹ lưỡng, mang đến vẻ đẹp tươi mới và phù hợp với mọi dịp. Tìm kiếm sự kết hợp hoàn hảo cho không gian của bạn.</p>

            <img src="image/separator.png">  
        </div>  
        <?php include 'components/shop.php'; ?>  
    </section>


    <?php include 'components/user_footer.php'; ?>

        <!-- sweetalert cdnlink -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <!-- cusstom js link -->
         <script type="text/javascript" src="js/user_script.js"></script>
        <!-- alert -->
        <?php include 'components/alert.php'; ?>

    </body>
</html>