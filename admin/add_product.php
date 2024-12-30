<?php 
      include '../components/connect.php';
    
      if (isset($_COOKIE['seller_id'])) {  
        $seller_id = $_COOKIE['seller_id'];  
    } else {  
        $seller_id = '';  
        header('location:login.php');  
    }

    if (isset($_POST['publish'])) { 
        $id = unique_id();

        $name = $_POST['title'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);

        $content = $_POST['content'];
        $content = filter_var($content, FILTER_SANITIZE_STRING);
    
        $stock = $_POST['stock'];
        $stock = filter_var($stock, FILTER_SANITIZE_STRING);
        $status = 'active';

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tpm_name'];
        $image_folder = '../uploaded_files/' .$image;

        $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ? AND seller_id = ?");
        $select_image->execute([$image, $seller_id]);  

        if (isset($image)){
            if ($select_image->rowCount() > 0) {
                $warning_msg[] = 'tên ảnh lặp lại';
            }elseif($image_size >2000000) {
                $warning_msg[] = 'kích thước hình ảnh quá lớn';
            }else{
                move_uploaded_file($image_tmp_name, $image_folder);
            }
    
        }else{
            $image = '' ;
        }
        if ($select_image->rowCount() > 0 AND $image != ''){
            $warning_msg[] = 'vui lòng đổi tên hình ảnh của bạn';
        }else{
            $insert_product = $conn->prepare("INSERT INTO `products` (id, seller_id, name, price, image, stock, product_detail, status)VALUES(?,?,?,?,?,?,?,?)");
            $insert_product->execute([$id, $seller_id, $name, $price, $image, $stock, $content, $status]);
        
            $success_msg[] = 'sản phẩm được thêm thành công' ;
        
        }
    }
    
    //save products as draft

    if (isset($_POST['draft'])) { 
        $id = unique_id();

        $name = $_POST['title'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);

        $content = $_POST['content'];
        $content = filter_var($content, FILTER_SANITIZE_STRING);
    
        $stock = $_POST['stock'];
        $stock = filter_var($stock, FILTER_SANITIZE_STRING);
        $status = 'deactive';

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tpm_name'];
        $image_folder = '../uploaded_files/' .$image;

        $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ? AND seller_id = ?");
        $select_image->execute([$image, $seller_id]);  

        if (isset($image)){
            if ($select_image->rowCount() > 0) {
                $warning_msg[] = 'tên ảnh lặp lại';
            }elseif($image_size >2000000) {
                $warning_msg[] = 'kích thước ảnh quá lớn';
            }else{
                move_uploaded_file($image_tmp_name, $image_folder);
            }       
    
        }else{
            $image = '' ;
        }
        if ($select_image->rowCount() > 0 AND $image != ''){
            $warning_msg[] = 'vui lòng đổi tên hình ảnh của bạn';
        }else{
            $insert_product = $conn->prepare("INSERT INTO `products` (id, seller_id, name, price, image, stock, product_detail, status)VALUES(?,?,?,?,?,?,?,?)");
            $insert_product->execute([$id, $seller_id, $name, $price, $image, $stock, $content, $status]);
        
            $success_msg[] = 'lưu sản phẩm dưới dạng bản nháp thành công' ;
        
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
        <link rel="stylesheet" type="text/css" href="../css/admin_style.css?v=<?php echo time(); ?>">
        <title>Cửa hàng - Vườn Hoa Tươi</title>
    </head>
    <body>

        <?php include '../components/admin_header.php'; ?>
        <div class="banner">  
            <div class="detail">  
                <h1>Thêm Sản Phẩm Hoa</h1>  
                <p>
                    Hãy làm phong phú thêm bộ sưu tập của bạn với những sản phẩm hoa tươi đẹp. Khám phá nhiều loại hoa tươi và thơm ngát để mang thiên nhiên vào không gian sống của bạn. Chúng tôi luôn sẵn sàng mang đến vẻ đẹp của thiên nhiên đến gần bạn hơn.
                </p>
                <span><a href="dashboard.php">admin</a><i class="bx bx-right-arrow-alt"></i>Thêm Sản Phẩm</span>  
            </div>  
        </div>
        
        <section class="add-product">
            <div class="heading">
                <h1>Thêm Sản Phẩm </h1>
                <img src="../image/separator.png">
            </div>
            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data" class="register">
                    <div class="input-field">
                        <P>Tên sản phẩm <span>*</span></P>
                        <input type="text" name="title" maxlength="100" placeholder="Nhập Tên sản phẩm " required class="box">
                    </div>

                    <div class="input-field">
                        <P>Giá sản phẩm <span>*</span></P>
                        <input type="number" name="price" maxlength="100" placeholder="Nhập Giá sản phẩm" required class="box">
                    </div>

                    <div class="input-field">
                        <P>Mô tả sản phẩm  <span>*</span></P>
                        <textarea name="content" required maxlength="10000"placeholder="Nhập mô tả sản phẩm" class="box"></textarea>

                        <div class="input-field">
                        <P>Tổng số lượng <span>*</span></P>
                        <input type="number" name="stock" maxlength="10" placeholder="Số lượng sản phẩm hiện có" min="0" max="9999999999" required class="box">
                    </div>

                    <div class="input-field">
                        <P>Hình ảnh sản phẩm <span>*</span></P>
                        <input type="file" name="image" accept="image/*" required class="box">
                    </div>
                    <div class="flex-btn">
                        <input type="submit" name="publish" value="Xuất bản" class="btn">
                        <input type="submit" name="draft" value="Lưu bản nháp" class="btn">


                    </div>
                    </div>
                </form>
            </div>
        
        </section>
       
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