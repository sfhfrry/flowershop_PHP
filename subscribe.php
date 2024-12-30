<?php   
include 'components/connect.php';  

// Kiểm tra nếu thư viện đã được cài đặt  
if (file_exists('vendor/autoload.php')) {  
    require 'vendor/autoload.php'; // Nếu bạn đã cài đặt PHPMailer với Composer  
} elseif (file_exists('PHPMailer/src/PHPMailer.php')) {  
    require 'PHPMailer/src/PHPMailer.php'; // Nếu bạn đã tải xuống PHPMailer thủ công  
    require 'PHPMailer/src/SMTP.php';  
    require 'PHPMailer/src/Exception.php';  
} else {  
    die('PHPMailer library not found. Please check your installation.');  
}  

use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;  

$user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : '';  
?>  
<!DOCTYPE html>  
<html lang="vi">  
<head>  
    <meta charset="utf-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>  
    <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">  
    <title>Cửa hàng - Vườn Hoa Tươi</title>   
    <style>  
        .subscribe-container{  
            width: 100%;  
            background-image: url('image/—Pngtree.jpg');  
            animation: banner 3s infinite alternate;  
            background-size: cover;  
            background-repeat: no-repeat;  
            background-position: center;  
            min-height: 100vh;  
            display: flex;  
            justify-content: flex-start;  
            align-items: center;  
            padding: 0 5%;  
        }    
        .subscribe-container h2 {  
            text-transform: capitalize;  
        }  

        .subscribe-container p{  
            font-size: 25px;  
            line-height: 1.5;  
            color: #18131e;  
            margin: 1rem 0;  
        }  
        .subscribe-container input[type="email"] {  
            width: 40rem;  
            padding: 1.5rem;  
            border: none;  
        }  
        .newsletter .box-detail .icons i {  
            background-color: var(--pink-opacity);  
            border: 2px solid var(--main-color);  
            backdrop-filter: var(--backdrop-filter);  
            box-shadow: var(--box-shadow);  
            width: 50px;  
            height: 50px;  
            border-radius: 50%;  
            color: var(--main-color);  
            line-height: 50px;  
            text-align: center;  
            transition: .5s;  
            font-size: 1.5rem;  
            cursor: pointer;  
            margin: 1rem;  
        }  
        .subscribe-container button {  
            border: none;  
        }  
       
    </style>  
</head>  
<body>  
<?php include 'components/user_header.php'; ?>  

<div class="subscribe-container">  
    <h2>Đăng Ký Nhận Bản Tin</h2>  
    <form action="" method="POST">  
        <input type="email" name="email" placeholder="Your email..." required>  
        <button type="submit" class="btn">Đăng Ký</button>  
    </form>  
</div>  

<?php  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    $email = $_POST['email'];  

    // Kiểm tra định dạng email  
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
        echo "<script>alert('Sai email. Vui lòng nhập lại email chính xác.');</script>";  
        exit;  
    }  

    // Kiểm tra xem email đã tồn tại chưa  
    $stmt = $conn->prepare("SELECT * FROM subscribers WHERE email = ?");  
    $stmt->execute([$email]);  

    if ($stmt->rowCount() > 0) {  
        echo "<script>alert('Email này đã được đăng ký. Hãy nhập Email khác');</script>";  
    } else {  
        // Thêm email vào cơ sở dữ liệu  
        $insert = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");  
        if ($insert->execute([$email])) {  
            // Gửi email xác thực  
            $mail = new PHPMailer(true);  
            try {  
                //Server settings  
                $mail->isSMTP();  
                $mail->Host = 'smtp.gmail.com';  
                $mail->SMTPAuth = true;  
                $mail->Username = 'your_email@gmail.com'; // Thay đổi với địa chỉ email của bạn  
                $mail->Password = 'your_email_password'; // Mật khẩu ứng dụng Gmail  
                $mail->SMTPSecure = 'tls';  
                $mail->Port = 587;  

                //Recipients  
                $mail->setFrom('your_email@gmail.com', 'Tên Cửa Hàng');  
                $mail->addAddress($email);  

                // Content  
                $mail->isHTML(true);  
                $mail->Subject = 'Cảm ơn bạn đã đăng ký!';  
                $mail->Body = 'Chào bạn,<br><br>Cảm ơn bạn đã đăng ký nhận bản tin từ chúng tôi.<br><br>Trân trọng, <br>Cửa hàng Hoa Tươi';  

                $mail->send();  
                echo "<script>alert('Đăng ký thành công! Chúng tôi sẽ gửi thông tin đến email của bạn.');</script>";  
            } catch (Exception $e) {  
                echo "<script>alert('Đăng kí nhận thông báo thành công {$mail->ErrorInfo}');</script>";  
            }  
        } else {  
            echo "<script>alert('Đã xảy ra lỗi, vui lòng thử lại.');</script>";  
        }  
    }  
}  
?>  
<footer>  
    <div class="content">  
        <div class="box">  
            <img src="image/logo2.png" alt="Logo">  
            <p>Điều quan trọng nhất là chăm sóc khách hàng tận tâm, đảm bảo chất lượng sản phẩm và tuân thủ mọi quy trình phục vụ.</p>  
            <a href="contact.php" class="btn">Liên hệ với chúng tôi</a>  
        </div>  

        <div class="box">  
            <h4>Tài khoản của tôi</h4>     
            <a href="https://www.facebook.com/profile.php?id=100046405071690"><i class="bx bx-chevron-right"></i>Tài khoản của tôi</a>  
            <a href="cart.php"><i class="bx bx-chevron-right"></i>Lịch sử đơn hàng</a>  
            <a href="wishlist.php"><i class="bx bx-chevron-right"></i>Danh sách</a>  
            <a href="about.php"><i class="bx bx-chevron-right"></i>Bản Tin</a>  
        </div>   

        <div class="box">   
            <h4>Thông tin</h4>  
            <a href="#"><i class="bx bx-chevron-right"></i>Giới thiệu về chúng tôi</a>  
            <a href="#"><i class="bx bx-chevron-right"></i>Thông tin giao hàng</a>  
            <a href="#"><i class="bx bx-chevron-right"></i>Chính sách bảo mật</a>  
            <a href="#"><i class="bx bx-chevron-right"></i>Điều khoản và điều kiện</a>   
        </div>  

        <div class="box">   
            <h4>Khác</h4>  
            <a href="#"><i class="bx bx-chevron-right"></i>Thương hiệu</a>  
            <a href="#"><i class="bx bx-chevron-right"></i>Phiếu quà tặng</a>  
            <a href="#"><i class="bx bx-chevron-right"></i>Cộng tác viên</a>  
            <a href="#"><i class="bx bx-chevron-right"></i>Khuyến mãi</a>  
        </div>  

        <div class="box">   
            <h4>Liên hệ với Chúng Tôi</h4>  
            <p><i class="bx bxs-phone"></i> +84-0348751185</p>  
            <p><i class="bx bxs-envelope"></i>2200004138@nttu.edu.vn</p>  
            <p><i class="bx bxs-envelope"></i>2200005120@nttu.edu.vn</p>  
            <p><i class="bx bxs-location-plus"></i>TPHCM - VietNam</p>  
            <div class="icons">  
                <i class="bx bxl-facebook"></i>  
                <i class="bx bxl-instagram-alt"></i>  
                <i class="bx bxl-linkedin"></i>  
                <i class="bx bxl-twitter"></i>  
                <i class="bx bxl-pinterest-alt"></i>  
            </div>  
        </div>  
    </div>  

    <div class="bottom">  
        <p>Copyright @2024 Code With HoangVan. All Rights Reserved</p>  
        <a href="admin/login.php" class="btn">Trở thành người bán</a>  
    </div>  
</footer>   

<!-- sweetalert cdnlink -->  
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>  
<!-- custom js link -->  
<script type="text/javascript" src="js/user_script.js"></script>  
<!-- alert -->  
<?php include 'components/alert.php'; ?>  

</body>  
</html>