<?php 
      include 'components/connect.php';
    
    if (isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else {
        $user_id = 'login.php' ;
    }

      if (isset($_POST['update'])) {
        $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");  
        $select_user->execute([$user_id]);  
        $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);  

        $prev_pass = $fetch_user['password'];  
        $prev_image = $fetch_user['image'];  

        $name = $_POST['name'];  
        $name = filter_var($name, FILTER_SANITIZE_STRING);  

        $email = $_POST['email'];  
        $email = filter_var($email, FILTER_SANITIZE_STRING);  

        // update user name  
        if (!empty($name)) {  
            $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");  
            $update_name->execute([$name, $user_id]);  
            $success_msg[] = 'tên người dùng được cập nhật thành công';  
        }  

        // update user mail address  
        if (!empty($email)) {  
            $select_email = $conn->prepare("SELECT email FROM `users` WHERE id = ? AND email = ?"); 
            $select_email->execute([$user_id, $email]);
            
            if ($select_email->rowCount() > 0) {
                $warning_msg[] = 'Email đã tồn tại!';
            }else{
                $update_email = $conn->prepare("UPDATE `users` SET email =? WHERE id =?");  
                $update_email->execute([$email, $user_id]);  
                $success_msg[] = 'email được cập nhật thành công';
            }
        }
        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = unique_id(). '.'. $ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_files/' .$rename;

        if (!empty($image)) {
            if ($image_size >2000000) {
                $warning_msg[] = 'Kích thước hình ảnh quá lớn';
            }else{
                $update_image = $conn->prepare("UPDATE `users` SET `image` =? WHERE id = ?");
                $update_image->execute([$rename, $user_id]);
                move_uploaded_file($image_tmp_name, $image_folder);

                if ($prev_image != '' AND $prev_image !=$rename){
                    unlink('uploaded_files/'. $prev_image);
                }
                $success_msg[] = 'hình ảnh được cập nhật thành công';

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
                    $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id= ?");
                    $update_pass->execute([$cpass, $user_id]);
                    $success_msg[] = 'Mật khẩu được cập nhật thành công';
                }else{
                    $warning_msg[] = 'vui lòng nhập mật khẩu mới !';
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
        <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
        <title>Cửa hàng -  Vườn Hoa Tươi - Cập Nhật</title>
    </head>
    <body>

        <?php include 'components/user_header.php'; ?>
        <div class="banner">  
            <div class="detail">  
                <h1>Cập nhật hồ sơ</h1>
                <p>Chào mừng bạn đến với trang cập nhật hồ sơ của chúng tôi! Tại đây, bạn có thể thay đổi thông tin cá nhân như tên, email, số điện thoại, và ảnh đại diện của mình. Hãy đảm bảo rằng tất cả thông tin của bạn luôn được cập nhật chính xác để trải nghiệm dịch vụ của chúng tôi trở nên thuận tiện và nhanh chóng hơn.</p>

                <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Cập nhật hồ sơ</span>  
            </div>  
        </div>

            
        <section class="form-container">
            <form action=""method="post" enctype="multipart/form-data" class="register">
                <div class="img-box">
                    <img src="uploaded_files/<?= $fetch_profile['image']; ?>">
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
                            <p>Mật khẩu cũ</p>
                            <input type="password" name="old_pass" placeholder="Nhập mật khẩu cũ "class="box">
                        </div>

                        <div class="input-field">
                            <p>Mật khẩu mới</p>
                            <input type="password" name="new_pass" placeholder="Nhập mật khẩu mới" class="box">
                        </div>

                        <div class="input-field">
                            <p>Xác nhận mật khẩu</p>
                            <input type="password" name="cpass" placeholder="Xác nhận mật khẩu" class="box">
                        </div>

                    </div>
                </div>

                <input type="submit" name="update" class="btn" value="update profile">
            </form>
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