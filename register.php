<?php 
include 'components/connect.php';

if (isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else {
    $user_id = '' ;
}

if (isset($_POST['register'])) {  

    $id = unique_id();  
    $name = $_POST['name'];  
    $name = filter_var($name, FILTER_SANITIZE_STRING);  
    
    // Sửa key 'mail' thành 'email' cho đồng nhất
    $email = $_POST['email'];  
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    // Gán biến $pass đúng cách
    $pass = sha1($_POST['pass']);  
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);  

    $cpass = sha1($_POST['cpass']);  
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);  
    
    $image = $_FILES['image']['name'];  
    $image = filter_var($image, FILTER_SANITIZE_STRING);  
    $ext = pathinfo($image, PATHINFO_EXTENSION);  
    $rename = unique_id(). '.' . $ext;  
    $image_size = $_FILES['image']['size'];  
    $image_tmp_name = $_FILES['image']['tmp_name'];  
    $image_folder = 'uploaded_files/' .$rename;  

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email=?");  
    $select_user->execute([$email]);  

    if ($select_user->rowCount() > 0) {  
        $warning_msg[] = 'Email đã tồn tại';  
    } else {  
        if ($pass != $cpass) {  
            $warning_msg[] = 'Xác nhận mật khẩu không khớp';  
        } else {  
            $insert_user = $conn->prepare("INSERT INTO `users`(id, name, email, password, image) VALUES(?,?,?,?,?)");  
            $insert_user->execute([$id, $name, $email, $pass, $rename]);  
            move_uploaded_file($image_tmp_name, $image_folder);  
            $success_msg[] = 'Người dùng mới đã đăng ký! Vui lòng đăng nhập ngay bây giờ';  
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
        <title>Cửa hàng - Vườn Hoa tươi - Đăng ký</title> 
    </head>
    <body>
    <?php include 'components/user_header.php'; ?>

    <div class="banner">  
        <div class="detail">  
            <h1>Đăng Ký</h1>  
            <p>Chào mừng bạn đến với trang đăng ký của chúng tôi! Để bắt đầu mua sắm những sản phẩm hoa tươi đẹp, vui lòng điền thông tin cá nhân của bạn vào biểu mẫu dưới đây. Sau khi đăng ký, bạn có thể theo dõi đơn hàng, lưu trữ thông tin giao hàng và nhận ưu đãi đặc biệt từ chúng tôi.</p>
            <span><a href="home.php">Trang Chủ</a><i class="bx bx-right-arrow-alt"></i>Đăng Ký </span>  
        </div>  
    </div>
     
        <!-- -------------------register form section end------------------->  
        <div class="form-container">  
            <form action="" method="post" enctype="multipart/form-data" class="register"> 
                <h3>Đăng ký ngay</h3> 
                <div class="flex">  
                    <div class="col">  
                        <div class="input-field">  
                            <p>Tên của bạn <span>*</span></p>  
                            <input type="text" name="name" placeholder="Nhập tên của bạn" maxlength="50" required class="box">  
                        </div>  
                        <div class="input-field">  
                            <p>Email của bạn <span>*</span></p>  
                            <input type="email" name="email" placeholder="Nhập Email" maxlength="50" required class="box">  
                        </div> 
                    </div>  
                    <div class="col">  
                        <div class="input-field">  
                            <p>Mật khẩu của bạn<span>*</span></p>  
                            <input type="passord" name="pass" placeholder="Nhập mật khẩu" maxlength="50" required class="box">  
                        </div>  
                        <div class="input-field">  
                            <p>Xác nhận mật khẩu <span>*</span></p>  
                            <input type="passord" name="cpass" placeholder="Nhập lại mật khẩu" maxlength="50" required class="box">  
                        </div>  
                    </div>  
                </div> 
                <div class="input-field">  
                            <p>Chọn ảnh đại diện <span>*</span></p>  
                            <input type="file" name="image" accept="image/*" required class="box">  
                </div>   
                <p class="link">Đã có tài khoản ?<a href="login.php">Đăng nhập ngay</a></p>
                <input type="submit" name="register" class="btn" value="Đăng kí ngay">
            </form>  
        </div>  



    <?php include 'components/user_footer.php'; ?>

        <!-- sweetalert cdnlink -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <!-- cusstom js link -->
         <script type="text/javascript" src="js/user_script.js"></script>
        <!-- alert -->
        <?php include 'components/alert.php'; ?>

    </body>
</html>