<header class="header">  
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <section class="flex">  
        <a href="home.php"><img src="image/logo2.png" width="170px"></a>  
        <nav class="navbar">
            <a href="home.php"><i class="fas fa-home"></i> Trang Chủ</a>
            <a href="menu.php"><i class="fas fa-list"></i> Sản phẩm</a>
            <a href="order.php"><i class="fas fa-cart-arrow-down"></i> Đặt Hàng</a>
            <a href="contact.php"><i class="fas fa-envelope"></i> Liên hệ</a>
            <a href="about.php"><i class="fas fa-blog"></i> Blog</a>
        </nav>
        <form action="search_product.php" method="post" class="search-form">  
            <input type="text" name="search_product" placeholder="nhập sản phẩm cần tìm..." required maxlength="100">  
             <button type="submit" class="bx bx-search-alt-2" name="search_product_btn"></button>  
        </form>  
         <div class="icons">  
            <div id="menu-btn" class="bx bx-list-plus"></div>  
            <div id="search-btn" class="bx bx-search-alt-2"></div>  


            <?php  
                $count_wishlist_item = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");  
                $count_wishlist_item->execute([$user_id]);  
                $total_wishlist_item = $count_wishlist_item->rowCount();  
            ?>  
                <a href="wishlist.php" class="cart-btn"><i class="bx bx-heart"></i><sup><?=$total_wishlist_item ?></sup></a>  
            <?php  
                $count_cart_item = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");  
                $count_cart_item->execute([$user_id]);  
                $total_cart_item = $count_cart_item->rowCount();  
            ?>  
                <a href="cart.php" class="cart-btn"><i class="bx bx-cart"></i><sup><?= $total_cart_item ?></sup></a>  
                <div id="user-btn" class="bx bxs-user"></div>
        </div>  
      <div class="profile">  
        <?php  
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");  
            $select_profile->execute([$user_id]);  

            if ($select_profile->rowCount() > 0) {  
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);  
        ?>  
        <img src="uploaded_files/<?= $fetch_profile['image']; ?>">  
        <h3 style="margin-bottom: 1rem;"><?= $fetch_profile['name']; ?></h3>  
        <div class="flex-btn">  
            <a href="profile.php" class="btn">Xem hồ sơ</a>  
            <a href="components/user_logout.php" onclick="return confirm('Đăng xuất khỏi trang web này');" class="btn">Đăng Xuất</a>  
        </div>  
        <?php   
        } else {   
?>  
        <img src="image/user.jpg" alt="">  
        <h3 style="margin-bottom: 1rem;">vui lòng đăng nhập hoặc đăng ký</h3>  
        <div class="flex-btn">  
            <a href="login.php" class="btn">Đăng Nhập</a>  
            <a href="register.php"  class="btn">Đăng kí</a>  
        </div>  
        <?php  }  ?>  
                  
        </div>
    </section>  
</header>