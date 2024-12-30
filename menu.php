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
        <title>Cửa hàng - Vườn Hoa Tươi</title> 
    </head>
    <body>
    <?php include 'components/user_header.php'; ?>

    <div class="banner">  
        <div class="detail">  
            <h1>sản phẩm mới nhất</h1>  
            <p>Chúng tôi cung cấp những bó hoa tươi đẹp, được lựa chọn kỹ càng từ những vườn hoa chất lượng cao. Mỗi bông hoa đều được chăm sóc tỉ mỉ để mang đến vẻ đẹp tự nhiên và sự tươi mới lâu dài.    
            <br>Hãy để chúng tôi mang đến cho bạn những sản phẩm hoa tuyệt vời nhất để làm đẹp không gian sống.</p>  
            <span><a href="home.php"><b>Trang chủ</b></a><i class="bx bx-right-arrow-alt"></i><b>sản phẩm mới nhất</b></span>  
        </div>  
    </div>
    
    <div class="heading">  
        <p style="text-align: center; font-size: 40px; font-weight: bold; margin-top: 50px;">Vườn Hoa Tươi</p>
                <img src="image/separator.png">  
    </div> 

        <!-- -------------------guerentee section end------------------->  
    <div class="products">
        <div class="box-container">
        <?php
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE status =?");
            $select_products->execute(['active']);

            if ($select_products->rowCount() > 0) {
                while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){

                        
        ?>

        <form action="" method="post" class="box" <?php if($fetch_products['stock'] == 0){echo 'disabled';} ?>>  

            <img src="image/products/<?= $fetch_products['image']; ?>" class="image">  
            <?php if ($fetch_products['stock'] > 9) { ?>  
                    <span class="stock" style="color:green;">Còn Hàng</span>  
            <?php } elseif ($fetch_products['stock'] == 0) { ?>  
                    <span class="stock" style="color:red;">Hết hàng</span>  
            <?php } else { ?>  
                <span class="stock" style="color:red;">Chỉ còn lại <?= $fetch_products['stock']; ?> Sản phẩm</span>  
                <?php } ?> 
                <p class="price">Giá VND <?= $fetch_products['price']; ?>/-</p>  
                <div class="content">
                    <div class="button">  
                        <div><h3><?= $fetch_products['name']; ?></h3></div>  
                        <div>  
                            <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>  
                            <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>  
                            <a href="view_page.php? pid=<?= $fetch_products['id']; ?>" class="bx bxs-show"></a>  
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
                }else{
                    echo ' 
                    <div class="empty">  
                                <p>Chưa có sản phẩm nào được thêm vào! </p>  
                    </div>  
                        ';  
                }
            ?>
            
        </div>
    </div>



    <?php include 'components/user_footer.php'; ?>

        <!-- sweetalert cdnlink -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <!-- cusstom js link -->
         <script type="text/javascript" src="js/user_script.js"></script>
        <!-- alert -->
        <?php include 'components/alert.php'; ?>

    </body>
</html>