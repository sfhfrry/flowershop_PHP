<?php 
include 'components/connect.php';

    if (isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else {
        $user_id = '' ;
    }

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
        <title>Cửa hàng - Vườn hoa tươi - Tìm kiếm</title> 
    </head>
    <body>
    <?php include 'components/user_header.php'; ?>

    <div class="banner">  
        <div class="detail">  
            <h1> Tìm kiếm sản phẩm </h1>  
            <p>Chào mừng bạn đến với cửa hàng hoa trực tuyến của chúng tôi! Hãy tìm kiếm những sản phẩm hoa tươi tuyệt vời để làm đẹp cho không gian sống của bạn hoặc dành tặng những người thân yêu. Chỉ cần nhập tên sản phẩm vào ô tìm kiếm để khám phá những lựa chọn tuyệt vời. Chúng tôi cam kết cung cấp các sản phẩm hoa tươi, chất lượng cao và giao hàng nhanh chóng đến tận tay bạn.</p>
            <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Tìm kiếm Sản phẩm</span>  
        </div>  
    </div>
     
        <!-- -------------------products detail section start------------------->  
    
<section class="products">
    <div class="heading">
        <h1>Tìm kiếm sản phẩm</h1>
        <img src="image/separator.png">
    </div>

    <div class="box-container">
        <?php
            if (isset($_POST['search_product']) or isset($_POST['search_product_btn']))  
        {  
                $search_products = $_POST['search_product'];  
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%{$search_products}%' AND status = ?");  
                $select_products->execute(['active']);  

                if ($select_products->rowCount() > 0) {  
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC))  
                    {  
                        $product_id = $fetch_products['id'];  

        ?>
             <form action="" method="post" class="box" <?php if($fetch_products['stock'] == 0){echo 'disabled';} ?>>  

                <img src="image/products/<?= $fetch_products['image']; ?>" class="image">  
                <?php if ($fetch_products['stock'] > 9) { ?>  
                        <span class="stock" style="color:green;">Còn hàng</span>  
                <?php } elseif ($fetch_products['stock'] == 0) { ?>  
                        <span class="stock" style="color:red;">hết hàng</span>  
                <?php } else { ?>  
                    <span class="stock" style="color:red;">Chỉ còn <?= $fetch_products['stock']; ?> Sản phẩm</span>  
                    <?php } ?> 
                    <p class="price">Giá: <?= $fetch_products['price']; ?>.000VND</p>  
                    <div class="content">
                        <div class="button">  
                            <div><h3><?= $fetch_products['name']; ?></h3></div>  
                            <div>  
                                <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>  
                                <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>  
                                <a href="view_page.php?id=<?= $fetch_products['id']; ?>" class="bx bxs-show"></a>  
                            </div>  
                        </div> 
                        <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">  
                        <div class="flex-btn">  
                            <a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn">Mua Ngay</a>  
                            <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">  
                        </div>
                    </div>
            </form>
        <?php
                    }  
                }  else{
                        echo '
                        <div class="empty">
                            <p>Không tìm thấy sản phẩm nào!</p>
                        </div>
                    ';
                }
            }else{
                echo '
                <div class="empty">
                    <p>Không tìm thấy sản phẩm nào!</p>
                </div>
            ';
            }
        ?>
    </div>
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