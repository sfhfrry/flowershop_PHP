<header >
    <div class="logo">  
        <img src="../image/logo2.png" width="170px">  
    </div>

    <div class="right">  
        <div class="bx bxs-user" id="user-btn"></div>  
        <div class="toggle-btn"><i class="bx bx-menu"></i></div>  
        
</div>  
<div class="profile-detail">  
    <?php  
        $select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id=?");  
        $select_profile->execute([$seller_id]);  

        if ($select_profile->rowCount() > 0) {  
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);  

    ?>  
    <div class="profile">  
        <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" class="logo-img">  
        <p><?= $fetch_profile['name']; ?></p>  
    </div>  
    <div class="flex-btn">  
        <a href="profile.php" class="btn">Hồ Sơ</a>  
        <a href="../components/admin_logout.php" onclick="return confirm('đăng xuất khỏi trang web này');" class="btn">Đăng Xuất</a>  
    </div>  
    <?php } ?>
    </div>
</header>

<div class="sidebar">
    <?php   
            $select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id=?");  
            $select_profile->execute([$seller_id]);  

            if ($select_profile->rowCount() > 0) {  
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC    );  

        ?>  
            <div class="profile">  
                <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" class="logo-img">  
                <p><?= $fetch_profile['name']; ?></p>  
            </div>      
        <?php } ?>

        <h5> menu </h5>
        <div class="navbar">
            <ul>
                <li><a href="dashboard.php"><i class="bx bxs-home-smile"></i> Trang chủ</a></li>
                <li><a href="add_product.php"><i class="bx bxs-shopping-bags"></i> Thêm sản phẩm</a></li>
                <li><a href="view_products.php"><i class="bx bxs-food-menu"></i> Xem sản phẩm</a></li>
                <li><a href="user_account.php"><i class="bx bxs-user-detail"></i> Tài khoản người dùng</a></li>
                <li><a href="../components/admin_logout.php" onclick="return confirm('đăng xuất khỏi trang web này');"> <i class="bx bx-log-out"></i> Đăng Xuất</a></li>   
            </ul>
        </div>

        <h5>Liên hệ với chúng tôi</h5>
        <div class="social-links">
            <i class="bx bxl-facebook"></i>
            <i class="bx bxl-instagram-alt"></i>
            <i class="bx bxl-linkedin"></i>
            <i class="bx bxl-twitter"></i>
            <i class="bx bxl-pinterest-alt"></i>
        </div>
</div>