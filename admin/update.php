<?php 
      include '../components/connect.php';
    
      if (isset($_COOKIE['seller_id'])) {  
        $seller_id = $_COOKIE['seller_id'];  
    } else {  
        $seller_id = '';  
        header('location:login.php');  
    }

      if (isset($_POST['update'])) {
        $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE id = ? LIMIT 1");  
        $select_seller->execute([$seller_id]);  
        $fetch_seller = $select_seller->fetch(PDO::FETCH_ASSOC);  

        $prev_pass = $fetch_seller['password'];  
        $prev_image = $fetch_seller['image'];  

        $name = $_POST['name'];  
        $name = filter_var($name, FILTER_SANITIZE_STRING);  

        $email = $_POST['email'];  
        $email = filter_var($email, FILTER_SANITIZE_STRING);  

        // update user name  
        if (!empty($name)) {  
            $update_name = $conn->prepare("UPDATE `sellers` SET name = ? WHERE id = ?");  
            $update_name->execute([$name, $seller_id]);  
            $success_msg[] = 'Cập nhật tên thành  công';  
        }  

        // update user mail address  
        if (!empty($email)) {  
            $select_email = $conn->prepare("SELECT email FROM `sellers` WHERE id = ? AND email = ?"); 
            $select_email->execute([$seller_id, $email]);
            
            if ($select_email->rowCount() > 0) {
                $warning_msg[] = 'Email đã tồn tại!';
            }else{
                $update_email = $conn->prepare("UPDATE `sellers` SET email =? WHERE id =?");  
                $update_email->execute([$email, $seller_id]);  
                $success_msg[] = 'Cập nhật Email thành công';
            }
        }
        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = unique_id(). '.'. $ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_files/' .$rename;

        if (!empty($image)) {
            if ($image_size >2000000) {
                $warning_msg[] = 'Kích thước ảnh quá lớn';
            }else{
                $update_image = $conn->prepare("UPDATE `sellers` SET `image` =? WHERE id = ?");
                $update_image->execute([$rename, $seller_id]);
                move_uploaded_file($image_tmp_name, $image_folder);

                if ($prev_image != '' AND $prev_image !=$rename){
                    unlink('../uploaded_files/'. $prev_image);
                }
                $success_msg[] = 'Cập nhật ảnh thành công';

            }
        }
        //update password
        $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
        $old_pass = sha1($_POST['old_pass']);
        $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);

        $new_pass = sha1($_POST['new_pass']);
        $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);

        $cpass = sha1($_POST['cpass']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

        if ($old_pass != $empty_pass) { 
            if ($old_pass != $prev_pass) {
                $warning_msg[] = 'Mật khẩu cũ không khớp';
            }elseif ($new_pass != $cpass) {
                $warning_msg[] = 'Xác nhận mật khẩu không khớp';
            }else{
                if ($new_pass != $empty_pass) {
                    $update_pass = $conn->prepare("UPDATE `sellers` SET password = ? WHERE id= ?");
                    $update_pass->execute([$cpass, $seller_id]);
                    $success_msg[] = 'mật khẩu được cập nhật thành công';
                }else{
                    $warning_msg[] = 'vui lòng nhập mật khẩu mới';
                }
            }
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
        <title>Cửa hàng - Vườn Hoa Tươi- Cập nhật hồ sơ người bán</title>
    </head>
    <body>

        <?php include '../components/admin_header.php'; ?>
        <div class="banner">  
            <div class="detail">  
                <h1>Cập nhật hồ sơ</h1>  
                <p>Vui lòng cập nhật thông tin cá nhân và cửa hàng của bạn. Các thông tin này sẽ giúp khách hàng dễ dàng tìm thấy cửa hàng của bạn và mua sắm sản phẩm hoa yêu thích.</p>  
                <span><a href="dashboard.php">admin</a><i class="bx bx-right-arrow-alt"></i>Cập nhật hồ sơ</span>  
            </div>  
        </div>

            
        <section class="form-container">
            <form action=""method="post" enctype="multipart/form-data" class="register">
                <div class="img-box">
                    <img src="../uploaded_files/<?= $fetch_profile['image']; ?>">
                </div>
                <h3>Cập nhật hồ sơ</h3>
                <div class="flex">
                    <div class="col">
                        <div class="input-field">
                            <p>Tên của bạn</p>
                            <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>"class="box">
                        </div>

                        <div class="input-field">
                            <p>Email của bạn</p>
                            <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>"class="box">
                        </div>
                    </div>

                    <div class="input-field">
                            <p>Cập nhật hồ sơ</p>
                            <input type="file" name="image" accept="image/*" class="box">
                        </div>
                    </div>

                    <div class="col">
                        <div class="input-field">
                            <p>Mật Khẩu cũ</p>
                            <input type="password" name="old_pass" placeholder="Nhập mật khẩu củ" class="box">
                        </div>

                        <div class="input-field">
                            <p>mật khẩu mới</p>
                            <input type="password" name="new_pass" placeholder="Nhập mật khẩu mới" class="box">
                        </div>

                        <div class="input-field">
                            <p>Nhập lại mật khẩu</p>
                            <input type="password" name="cpass" placeholder="Nhập lại mật khẩu mới" class="box">
                        </div>

                    </div>
                </div>

                <input type="submit" name="update" class="btn" value="Cập nhật hồ sơ">
            </form>
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