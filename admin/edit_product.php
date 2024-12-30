<?php 
      include '../components/connect.php';
    
      if (isset($_COOKIE['seller_id'])) {  
        $seller_id = $_COOKIE['seller_id'];  
    } else {  
        $seller_id = '';  
        header('location:login.php');  
    }

// update product
    if (isset($_POST['update'])) {
        $product_id = $_POST['product_id'];
        $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);
        
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        
        $content = $_POST['content'];
        $content = filter_var($content, FILTER_SANITIZE_STRING);
        
        $stock = $_POST['stock'];
        $stock = filter_var($stock, FILTER_SANITIZE_STRING);
        
        $status = $_POST['status'];
        $status = filter_var($status, FILTER_SANITIZE_STRING);
        
        $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, product_detail = ?, stock = ?, status = ? WHERE id = ?");
        $update_product->execute([$name, $price, $content, $stock, $status, $product_id]);
        
        $success_msg[]='cập nhật sản phẩm!';

        $old_image = $_POST['old_image'];
        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../image/products/'.$image;

        $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ? AND seller_id = ?");
        $select_image->execute([$image, $seller_id]);

        if (!empty($image)) {
            if ($image_size > 200000) {
                $warning_msg[] = 'Kích thước ảnh quá lớn';
            } elseif ($select_image->rowCount() > 0 AND $image != '') {
                $warning_msg[] = 'Vui lòng nhập tên ảnh';
            } else {
                $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
                $update_image->execute([$image, $product_id]);
                
                move_uploaded_file($image_tmp_name, $image_folder);
                if ($old_image != $image AND $old_image != '') {
                    unlink('../uploaded_files/'.$old_image);
                }
                $success_msg[] = 'cập nhật hình ảnh';
            }
            }


        }

        
        //delete product
        if (isset($_POST['delete'])) {
            $product_id = $_POST['product_id'];
            $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);
            
            $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $delete_image->execute([$product_id]);
            $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
            
            if ($fetch_delete_image['image'] != '') {  
                unlink('../image/products/'.$fetch_delete_image['image']);  
            }  
            $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");  
            $delete_product->execute([$product_id]);  
            $success_msg[] = 'sản phẩm đã được xóa thành công';
        }
            
    ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content=" width=device-width, initial-scale=1">
        <!-- box icon cdn link -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" type="text/css" href="../css/admin_style.css?v=<?php echo time(); ?>">
        <title>Cửa hàng - Vườn Hoa Tươi - Sửa Sản Phẩm</title>
    </head>
    <body>

        <?php include '../components/admin_header.php'; ?>
        <div class="banner">  
            <div class="detail">  
                <h1>chỉnh sửa sản phẩm</h1>  
                <p>Chúng tôi luôn cam kết mang đến cho bạn những bông hoa đẹp nhất, tươi mới và chất lượng. Mỗi bó hoa là một tác phẩm nghệ thuật, được lựa chọn và chăm sóc tỉ mỉ để bạn có thể cảm nhận được sự tinh tế trong từng cánh hoa.</p> 
                <span><a href="dashboard.php">admin</a><i class="bx bx-right-arrow-alt"></i>chỉnh sửa sản phẩm</span>  
            </div>  
        </div>
        <div></div>
        <section class="post-editor">
            <div class="heading">
                <h1> chỉnh sửa sản phẩm </h1>
                <img src="../image/separator.png">
            </div>

            <div class="box-container">  
                <?php
                $product_id = $_GET['id'];  
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");  
                $select_product->execute([$product_id]);  

                if ($select_product->rowCount() > 0) {  
                    while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){  
                ?>  

                <div class="form-container">  
                    <form action="" method="post" enctype="multipart/form-data" class="register">  
                        <input type="hidden" name="old_image" value="<?= $fetch_product['image']; ?>">  
                        <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">  
                        
                        <div class="input-field">  
                            <p>Trạng thái sản phẩm<span>*</span></p>  
                            <select name="status" class="box">  
                                <option selected value="<?= $fetch_product['status']; ?>"><?= $fetch_product['status']; ?></option>  
                                <option value="active">Hoạt động</option>  
                                <option value="deactive">Không hoạt động</option>
                            </select>  
                        </div>  

                    <div class="input-field">  
                        <p>Tên sản phẩm <span>*</span></p>  
                        <input type="text" name="name" value="<?= $fetch_product['name']; ?>" class="box">  
                    </div>
                     
                    <div class="input-field">  
                        <p>Giá sản phẩm <span>*</span></p>  
                        <input type="number" name="price" value="<?= $fetch_product['price']; ?>" class="box">  
                    </div>

                    <div class="input-field">  
                        <p>Mô tả sản phẩm <span>*</span></p>  
                        <textarea name="content" class="box"><?= $fetch_product['product_detail']; ?></textarea>  
                    </div>

                    <div class="input-field">  
                        <p>Tổng số lượng trong kho <span>*</span></p>  
                        <input type="number" name="stock" value="<?= $fetch_product['stock']; ?>" class="box" maxlength="10" min="0" max="9999999999">  
                    </div>  
                    <div class="input-field">  
                        <p> Hình ảnh sản phẩm<span>*</span></p>  
                        <input type="file" name="image" accept="image/*" class="box">  
                        <?php if($fetch_product['image'] != '') { ?>  
                        <img src="../image/products/<?= $fetch_product['image']; ?>" class="image">  
                        <?php } ?>  
                    </div>
                            <div class="flex-btn">
                        <input type="submit" name="update" value="Cập nhật sản phẩm" class="btn">
                        <input type="submit" name="delete" value="Xóa sản phẩm" class="btn" onclick="return confirm('xóa sản phẩm này');">


                    </form>  
                </div>

                <?php  
                    }  
                } else {  
                    echo '  
                    <div class="empty" style="margin: 2rem auto;">  
                        <p>chưa có sản phẩm nào được thêm vào ! <br> <a href="add_product.php" class="btn" style="margin-top: 1rem;">Thêm sản phẩm</a></p>  
                    </div>  
                    ';  
                }
                ?>
            </div>  
            
        </section>


        <?php include '../components/admin_footer.php'; ?>

        <!-- sweetalert cdnlink -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <!-- cusstom js link -->
         <script type="text/javascript" src="../js/admin_script.js"></script>
        <!-- alert -->
        <?php include '../components/alert.php'; ?>

    </body>
</html>