<?php 
include '../components/connect.php';

if (isset($_POST['login'])) {  
    
    $email = $_POST['email'];  
    $email = filter_var($email, FILTER_SANITIZE_STRING);  

    $pass = sha1($_POST['pass']);  
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);  
    
    $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE email=? AND password=? LIMIT 1");  
    $select_seller->execute([$email, $pass]);  
    $row = $select_seller->fetch(PDO::FETCH_ASSOC);  
    
    if ($select_seller->rowCount() > 0) {  
        setcookie('seller_id', $row['id'], time() + 60*60*24*30, '/');  
        header('location:dashboard.php');  
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
        <link rel="stylesheet" type="text/css" href="../css/admin_style.css?v=<?php echo time(); ?>">
        <title>Cửa hàng - Vườn Hoa Tươi - Đăng Nhập</title> 
    </head>
    <body>
    <div class="form-container">  
            <form action="" method="post" enctype="multipart/form-data" class="login"> 
                <h3>Đăng nhập ngay</h3>  
                    <div class="input-field">  
                        <p>Email của bạn <span>*</span></p>  
                        <input type="email" name="email" placeholder="Nhập Email của bạn" maxlength="50" required class="box">  
                    </div>  
                    <div class="input-field">  
                        <p>Mật khẩu của bạn <span>*</span></p>  
                        <input type="password" name="pass" placeholder="Nhập Mật khẩu của bạn" maxlength="50" required class="box">  
                    </div>  
                    <p class="link">Chưa có tài khoản?? <a href="register.php">Đăng ký ngay</a></p>  
                    <input type="submit" name="login" class="btn" value="login now">
            </form>  
    </div>  






        <!-- sweetalert cdnlink -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <!-- cusstom js link -->
         <script type="text/javascript" src="../js/admin_script.js"></script>
        <!-- alert -->
        <?php include '../components/alert.php'; ?>

    </body>
</html>