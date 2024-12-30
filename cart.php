<?php 
include 'components/connect.php';

    if (isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else {
        $user_id = 'login.php' ;
    }

    //remove product from wishlist  
    if (isset($_POST['delete_item'])) {  

        $cart_id = $_POST['cart_id'];  
        $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);  
        
        $verify_delete = $conn->prepare("SELECT * FROM `cart` WHERE id = ?");  
        $verify_delete->execute([$cart_id]);  

        if ($verify_delete->rowCount() > 0) {  
            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE id=?");  
            $delete_cart->execute([$cart_id]);  
            $success_msg[] = 'giỏ hàng xóa mục thành công';  
        } else {  
            $warning_msg[] = 'mặt hàng trong giỏ hàng đã bị xóa';  
        }
    }


    //update quantity
    if (isset($_POST['qty'])) {
        $cart_id = $_POST['cart_id'];  
        $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);  

        $qty = $_POST['qty'];  
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);  

        $update_qty = $conn->prepare("UPDATE `cart` SET qty = ? WHERE id = ?");  
        $update_qty->execute([$qty, $cart_id]);  

        $success_msg[] = 'số lượng giỏ hàng được cập nhật';

    }

    //empty cart  
    if (isset($_POST['empty_cart'])) {  

        $verify_empty_item = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");  
        $verify_empty_item->execute([$user_id]); 
         
       if ($verify_empty_item->rowCount() > 0) {  
            $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");  
            $delete_cart_item->execute([$user_id]);  
            $success_msg[] = 'giỏ hàng trống thành công';  
        } else {  
            $warning_msg[] = 'giỏ hàng của bạn đã trống';  
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
        <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
        <title>Cửa hàng - Vườn Hoa Tươi - Giỏ Hàng</title> 
    </head>
    <body>
    <?php include 'components/user_header.php'; ?>

    <div class="banner">  
        <div class="detail">  
            <h1>Giỏ Hàng</h1>  
            <p>Chào bạn, đây là giỏ hàng của bạn. Kiểm tra các sản phẩm hoa đã chọn và hoàn tất quy trình mua hàng để nhận được những bông hoa tươi đẹp nhất.</p>
 
            <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Giỏ Hàng</span>  
        </div>  
    </div>
     
        <!-- -------------------products detail section start------------------->  
    
<section class="products">
    <div class="heading">
        <h1>Sản phẩm được thêm vào giỏ hàng của bạn</h1>
        <img src="image/separator.png">
    </div>

    <div class="box-container">
        <?php 
            $grand_total = 0;

            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");   
            $select_cart->execute([$user_id]);   

            if ($select_cart->rowCount() > 0) {   
                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {   
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");   
                    $select_products->execute([$fetch_cart['product_id']]);   

                    if ($select_products->rowCount() > 0) {   
                        $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);   
            ?>   
            <form action="" method="post" class="box <?php if($fetch_products['stock'] == 0) {echo 'disabled';} ?>">   
              
            <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">  
            <img src="image/products/<?= $fetch_products['image']; ?>" class="image">  
            <?php if($fetch_products['stock'] > 9) { ?>  
                <span class="stock" style="color: green;">Còn hàng</span>  
            <?php } elseif($fetch_products['stock'] == 0) { ?>  
                <span class="stock" style="color: red;">Hết Hàng</span>  
            <?php } else { ?>  
                <span class="stock" style="color: red;">Còn lại chỉ <?= $fetch_products['stock']; ?> Sản Phẩm</span>  
            <?php } ?>
            <p class="price">Giá: <?= $fetch_products['price']; ?>.000VND</p>
            <div class="content cart-content">  
                <div class="flex-btn">  
                    <h3 class="name"><?= $fetch_products['name']; ?></h3>  
                    <p class="sub-total">Tạm tính : <?= $sub_total = ($fetch_cart['qty'] * $fetch_cart['price']); ?></p>  
                </div>  
              
                <div class="flex-btn">  
                    <input type="number" name="qty" required min="1" value="<?= $fetch_cart['qty']; ?>" max="99" maxlength="2" class="qty">  
                    <button type="submit" name="update_cart" class="bx bxs-edit" style="box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.40)">
                    <i class="bx bx-edit"></i> </button>
                    <button type="submit" name="delete_item" onclick="return confirm('Xóa sản phẩm');" class="btn">Xóa</button>  
                </div>
            </div>
            </form>   
            <?php   

                 $grand_total += $sub_total;
                }else{
                    echo '
                    <div class="empty">
                        <p>Không tìm thấy sản phẩm nào!</p>
                    </div>
                ';
                }   
            }   
                }else{
                    echo '
                    <div class="empty">
                        <p>Không có sản phẩm nào!</p>
                    </div>
                ';
        }   
        ?>  
    </div>
    <?php
        if ($grand_total != 0) {  
    ?>  
        <div class="cart-total">  
            <p>tổng số tiền phải trả : <span><?= $grand_total; ?>.000VND</span></p>  
            <div class="button">  
                <form action="" method="post">  
                <button type="submit" name="empty_cart" onclick="return confirm('bạn có chắc chắn bỏ giỏ hàng trống không');" class="btn"> Xóa tất cả</button>  
                <a href="checkout.php" class="btn">tiến hành thanh toán</a>  
                </form>  
            </div>  
        </div>  
    <?php } ?>
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