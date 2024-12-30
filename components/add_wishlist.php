<?php
if (isset($_POST['add_to_wishlist'])) {  
    if ($user_id != '') {   

        $id = unique_id();  
        $product_id = $_POST['product_id'];  
        $product_id = filter_var($product_id, FILTER_SANITIZE_STRING); // Lọc dữ liệu đầu vào
        
        // Kiểm tra sản phẩm có trong wishlist không
        $verify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");  
        $verify_wishlist->execute([$user_id, $product_id]);  

        // Kiểm tra sản phẩm có trong giỏ hàng không
        $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");  
        $cart_num->execute([$user_id, $product_id]);  

        if ($verify_wishlist->rowCount() > 0) {  
            $warning_msg[] = 'Sản phẩm đã tồn tại trong danh sách yêu thích của bạn';  
        } else if ($cart_num->rowCount() > 0) {     
            $warning_msg[] = 'Sản phẩm đã tồn tại trong giỏ hàng của bạn';  
        } else {  
            // Truy vấn giá sản phẩm
            $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");  
            $select_price->execute([$product_id]);  
            $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);  

            if (!$fetch_price || empty($fetch_price['price'])) {
                $warning_msg[] = 'Thiếu giá sản phẩm hoặc không tìm thấy sản phẩm';
                return;
            }

            try {
                // Thêm sản phẩm vào wishlist
                $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(id, user_id, product_id, price) VALUES(?,?,?,?)");  
                $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);  
                $success_msg[] = 'Sản phẩm được thêm vào danh sách yêu thích thành công';
            } catch (PDOException $e) {
                $warning_msg[] = 'Lỗi thêm sản phẩm vào danh sách yêu thích: ' . $e->getMessage();
                return;
            }
        }  
    } else {  
        $warning_msg[] = 'Vui lòng đăng nhập trước ! ';  
    }
}
?>
