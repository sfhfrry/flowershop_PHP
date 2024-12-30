<?php 
if (isset($_POST['add_to_cart'])) {  
    if ($user_id != '') {  

        $id = unique_id();  
        $product_id = $_POST['product_id'];  
        $qty = $_POST['qty'];  
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);  

        $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");  
        $verify_cart->execute([$user_id, $product_id]);  

        $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");  
        $max_cart_items->execute([$user_id]);  

        if ($verify_cart->rowCount() > 0) {  
            $warning_msg[] = 'Sản phẩm đã tồn tại trong giỏ hàng của bạn';  
        } else if ($max_cart_items->rowCount() > 20) {  
            $warning_msg[] = 'Giỏ hàng đã đầy';  
        } else {  
            $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");  
            $select_price->execute([$product_id]);  
            $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);  

            if (!$fetch_price || empty($fetch_price['price'])) {
                $warning_msg[] = 'Thiếu giá sản phẩm hoặc không tìm thấy sản phẩm';
                return;
            }

            try {
                $insert_cart = $conn->prepare("INSERT INTO `cart`(id, user_id, product_id, price, qty) VALUES(?,?,?,?,?)");  
                $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);  
                $success_msg[] = 'Sản phẩm được thêm vào giỏ hàng thành công';   
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
                return;
            }
        }
    } else {
        $warning_msg[] = 'Vui lòng đăng nhập trước';
    }  
}
?>
