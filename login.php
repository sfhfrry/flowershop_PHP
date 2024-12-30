<?php 
include 'components/connect.php';

if (isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else {
    $user_id = '' ;
}

if (isset($_POST['login'])) {  
    
    $email = $_POST['email'];  
    $email = filter_var($email, FILTER_SANITIZE_STRING);  

    $pass = sha1($_POST['pass']);  
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);  
    
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email=? AND password=? LIMIT 1");  
    $select_user->execute([$email, $pass]);  
    $row = $select_user->fetch(PDO::FETCH_ASSOC);  
    
    if ($select_user->rowCount() > 0) {  
        setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');  
        header('location:home.php');  
    } else {  
        $warning_msg[] = 'email hoặc mật khẩu không chính xác !';  
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
        <title>Cửa hàng - Vườn Hoa Tươi - Đăng Kí</title> 
    </head>
    <body>
    <?php include 'components/user_header.php'; ?>

    <div class="banner">  
        <div class="detail">  
        <h1>Đăng Ký</h1>  
        <p>Chào mừng bạn đến với cửa hàng hoa của chúng tôi! Hãy hoàn tất thông tin dưới đây để tạo tài khoản và bắt đầu mua sắm các sản phẩm hoa tuyệt vời.</p>
            <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Đăng Ký</span>  
        </div>  
    </div>
     





        <!-- -------------------register form section end------------------->  
      
        <div class="form-container">  
            <form action="" method="post" enctype="multipart/form-data" class="login"> 
                <h3>Đăng nhập ngay</h3>  
                    <div class="input-field">  
                        <p>Email của bạn <span>*</span></p>  
                        <input type="email" name="email" placeholder="Nhập Email" maxlength="50" required class="box">  
                    </div>  
                    <div class="input-field">  
                        <p>Mật khẩu của Bạn <span>*</span></p>  
                        <input type="password" name="pass" placeholder="Nhập Mật Khẩu " maxlength="50" required class="box">  
                    </div>  
                    <p class="link">Bạn chưa có tài khoảng ? <a href="register.php">Đăng kí ngay</a></p>  
                    <input type="submit" name="login" class="btn" value="Đăng nhập  ">
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