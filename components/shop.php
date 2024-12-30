<div class="box-container">
    <?php
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE status =? LIMIT 6");
        $select_products->execute(['active']);

        if ($select_products->rowCount() > 0) {
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){

                    
    ?>

    <form action="" method="post" class="box" <?php if($fetch_products['stock'] == 0){echo 'disabled';} ?>>  

        <img src="image/products/<?= $fetch_products['image']; ?>" class="image">  
        <?php if ($fetch_products['stock'] > 9) { ?>  
                <span class="stock" style="color:green;">Còn Hàng</span>  
         <?php } elseif ($fetch_products['stock'] == 0) { ?>  
                <span class="stock" style="color:red;">hết hàng</span>  
        <?php } else { ?>  
              <span class="stock" style="color:red;">Còn lại chỉ <?= $fetch_products['stock']; ?> Bó Hoa</span>  
            <?php } ?> 
            <p class="price">Giá  <?= $fetch_products['price']; ?>.000</p>  
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
            }else{
                echo ' 
                <div class="empty">  
                            <p>chưa có sản phẩm nào được thêm vào! </p>  
                </div>  
                    ';  
            }
        ?>
        
</div>

<div class="more">
    <a href="menu.php" class="btn">tải thêm</a>
</div>

