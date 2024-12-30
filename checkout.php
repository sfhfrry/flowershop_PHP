<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    } else {
        $user_id = 'home.php';  
    }      

if (isset($_POST['place_order'])) {  

    if ($user_id != '') {
        $id = unique_id();

        $name = $_POST['name'];  
        $name = filter_var($name, FILTER_SANITIZE_STRING);  

        $email = $_POST['email'];  
        $email = filter_var($email, FILTER_SANITIZE_STRING);  

        $number = $_POST['number'];  
        $number = filter_var($number, FILTER_SANITIZE_STRING);  

        $address = $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ', ' . $_POST['pin'];  
        $address = filter_var($address, FILTER_SANITIZE_STRING);  

        $address_type = isset($_POST['address_type']) ? $_POST['address_type'] : '';  
        $address_type = filter_var($address_type, FILTER_SANITIZE_STRING);  

        $method = $_POST['method'];  
        $method = filter_var($method, FILTER_SANITIZE_STRING);  

        $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");  
        $verify_cart->execute([$user_id]);  

        if (isset($_GET['get_id'])) {  
            $get_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");  
            $get_product->execute([$_GET['get_id']]);  
            
            if ($get_product->rowCount() > 0) {  
                while ($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)) {  
                    $seller_id = $fetch_p['seller_id'];  
                    $insert_order = $conn->prepare("INSERT INTO `orders` (id, user_id, seller_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");  
                    $insert_order->execute([$id, $user_id, $seller_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'], $fetch_p['price'], 1]);  
                   header("location:order.php");  
                }
            } else {
                $warning_msg[] = 'Đã xảy ra sự cố';
            }
        } elseif ($verify_cart->rowCount() > 0) {
            while ($f_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)) {
                $s_products = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");  
                $s_products->execute([$f_cart['product_id']]);  
                $f_product = $s_products->fetch(PDO::FETCH_ASSOC);  
                $seller_id = $f_product['seller_id'];  
                $insert_order = $conn->prepare("INSERT INTO `orders` (id, user_id, seller_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");  
                $insert_order->execute([$id, $user_id, $seller_id, $name, $number, $email, $address, $address_type, $method, $f_cart['product_id'], $f_cart['price'], $f_cart['qty']]);  
                header("location:order.php");  
            }
            if ($insert_order) {  
                $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");  
                $delete_cart_id->execute([$user_id]);  
                header("location:order.php");  
            }
        } else {  
            $warning_msg[] = 'Đã xảy ra sự cố';  
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- box icon cdn link -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
        <title>Cửa hàng - Vườn Hoa Tươi - Thanh Toán</title> 
    </head>
    <body>
    <?php include 'components/user_header.php'; ?>

    <div class="banner">  
        <div class="detail">  
        <h1>Thanh Toán</h1>  
        <p>Chào mừng bạn đến với trang thanh toán của chúng tôi. Vui lòng kiểm tra thông tin và hoàn tất giao dịch của bạn.</p>

            <span><a href="home.php">Trang Chủ</a><i class="bx bx-right-arrow-alt"></i> Thanh Toán</span>  
        </div>  
    </div>

    <!-- -------------------address form section end------------------->  

    <section class="checkout">
        <div class="heading">
            <h1>Tóm tắt thanh toán</h1>
            <img src="image/separator.png">
        </div>
        <div class="row">
            <div class="form-container">
                <form action="" method="post" class="register">
                    <input type="hidden" name="p_id" value="<?= isset($_GET['get_id']) ? $_GET['get_id'] : ''; ?>">
                    <h3>Chi tiết thanh toán</h3>
                    <div class="flex">
                        <div class="col">  
                                <div class="input-field">  
                                    <p>Tên của bạn<span>*</span></p>  
                                    <input type="text" name="name" placeholder="Nhập tên của bạn" maxlength="50" required class="box">  
                                </div>  
                                <div class="input-field">  
                                    <p>Số điện thoại  <span>*</span></p>  
                                    <input type="number" name="number" placeholder="Nhập số" maxlength="50" required class="box">  
                                </div> 

                                <div class="input-field">  
                                    <p>Email của bạn <span>*</span></p>  
                                    <input type="email" name="email" placeholder="Nhập Email của bạn" maxlength="50" required class="box">  
                                </div> 
                                <div class="input-field">  
                                <p>Trạng thái thanh toán<span>*</span></p>
                                    <select name="method" class="box">
                                        <option value="cash on delivery">Thanh toán khi nhận hàng</option>
                                        <option value="credit or debit card">Thẻ tín dụng hoặc thẻ ghi nợ</option>
                                        <option value="net banking">Ngân hàng trực tuyến</option>
                                        <option value="UPI or RuPay">VNPay hoặc Momo</option>
                                        <option value="paytm">PayTM</option>
                                    </select>
                                </div> 

                                <div class="input-field">  
                                <p>Loại địa chỉ<span>*</span></p>
                                    <select name="address_type" class="box">
                                        <option value="home">Nhà</option>
                                        <option value="office">Văn phòng</option>
                                    </select>
                                </div> 
                        </div> 
                        
                        <div class="col">  
                                <div class="input-field">  
                                    <p>Tên Đường/Số nhà<span>*</span></p>  
                                    <input type="text" name="flat" placeholder="ví dụ:đường/số nhà "maxlength="50" required class="box">  
                                </div>  
                                <div class="input-field">   
                                    <p>Phường/Xã<span>*</span></p>  
                                    <input type="text" name="street" placeholder="ví dụ: xã an chấn" maxlength="50" required class="box">  
                                </div>  
                                <div class="input-field">  
                                    <p>Quận/Huyện <span>*</span></p>  
                                    <input type="text" name="city" placeholder="ví dụ: quận 3" maxlength="50" required class="box">  
                                </div> 

                                <div class="input-field">  
                                    <p>Tên thành phố <span>*</span></p>  
                                    <input type="text" name="city" placeholder="nhập tên thành phố của bạn" maxlength="50" required class="box">  
                                </div> 
                                <div class="input-field">  
                                    <p>Tên quốc gia <span>*</span></p>  
                                    <input type="text" name="country" placeholder="nhập tên quốc gia của bạn" maxlength="50" required class="box">  
                                </div> 
                                <div class="input-field">  
                                    <p>Mã bưu điện <span>*</span></p>  
                                    <input type="number" name="pin" placeholder="110099" maxlength="6" required class="box">  
                                </div> 
                        </div>  
                    </div>
                    <button type="submit" name="place_order" class="btn">Đặt hàng</button>
                </form>
            </div>
            <div class="summary">
                <h3>Ví của tôi</h3>
                <div class="box-container">
                    <?php 
                        $grand_total = 0;
                        if (isset($_GET['get_id'])) {  
                            $select_get = $conn->prepare("SELECT * FROM `products` WHERE id = ?");  
                            $select_get->execute([$_GET['get_id']]);  
                            
                            while($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)){  
                                $sub_total = $fetch_get['price'];  
                                $grand_total += $sub_total;
                            ?>
                                <div class="flex">  
                                    <img src="image/products/<?=$fetch_get['image']; ?>" class="image">  
                                    <div>  
                                        <h3 class="name"><?= $fetch_get['name']; ?></h3>  
                                        <p class="price"><?= $fetch_get['price']; ?>.000.VND</p>  
                                    </div>  
                                </div>
                            <?php
                            }   
                        } else {
                            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");  
                            $select_cart->execute([$user_id]);  
                            if ($select_cart->rowCount() > 0) {  
                                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){  
                                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");  
                                    $select_products->execute([$fetch_cart['product_id']]);  
                                    $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);  
                                    $sub_total = $fetch_product['price'] * $fetch_cart['qty'];  
                                    $grand_total += $sub_total;
                                    ?>  
                                    <div class="flex">  
                                        <img src="image/products/<?= $fetch_product['image']; ?>" class="image">  
                                        <div>  
                                            <h3 class="name"><?= $fetch_product['name']; ?></h3>  
                                            <p class="price"><?= $fetch_product['price']; ?>/-</p>  
                                        </div>  
                                    </div>
                                    <?php 
                                }
                            }else{
                                echo'
                                <div class="empty">
                                <p>không có sản phẩm nào!</p>
                                </div>
                                ';
                            }
                        }  
                    ?>
                </div> 
                <div class="grand-total">  
                    <p>Tổng tiền: <span><?= $grand_total; ?>.000VND</span></p>  
                </div>
            </div>  
        </div>
    </section>

    </body>
</html>
