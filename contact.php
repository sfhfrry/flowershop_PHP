<?php 
    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else {
        $user_id = '' ;
    }

if (isset($_POST['send_message'])) {  

    if ($user_id != ''){
        $id = unique_id();

        $name = $_POST['name'];  
        $name = filter_var($name, FILTER_SANITIZE_STRING);  

        $email = $_POST['email'];  
        $email = filter_var($email, FILTER_SANITIZE_STRING);  

        $subject = $_POST['subject'];  
        $subject = filter_var($subject, FILTER_SANITIZE_STRING);  

        $message = $_POST['message'];  
        $message = filter_var($message, FILTER_SANITIZE_STRING);

        $verify_message = $conn->prepare("SELECT * FROM `message` WHERE user_id = ? AND name = ? AND email = ? AND subject = ? AND message = ?");  
        $verify_message->execute([$user_id, $name, $email, $subject, $message]);  

        if ($verify_message->rowCount() > 0) {  
            $warning_msg[] = 'tin nhắn đã gửi thành công';  
        } else {  
            $insert_message = $conn->prepare("INSERT INTO `message` (id, user_id, name, email,subject, message) VALUES (?, ?, ?, ?, ?,?)");  
            $insert_message->execute([$id, $user_id, $name, $email, $subject, $message]);  

            $success_msg[] = 'tin nhắn gửi thành công';
        }
    }else{
        $warning_msg[] = 'vui lòng đăng nhập trước';  
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
        <title>Cửa hàng - Vườn Hoa Tươi - liên hệ</title> 
    </head>
    <body>
    <?php include 'components/user_header.php'; ?>

    <div class="banner">  
        <div class="detail">  
            <h1>Liên hệ với chúng tôi</h1>  
            <p>Hãy để lại lời nhắn, và chúng tôi sẽ liên hệ lại với bạn sớm nhất có thể.  
            <br>Đội ngũ của chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn.</p>
            <span><a href="home.php">Trang chủ</a><i class="bx bx-right-arrow-alt"></i>Liên hệ với chúng tôi</span>  
        </div>  
    </div>
  
    <div class="service">
        <div class="heading">
            <h1>Dịch Vụ </h1>
            <p>Chúng tôi cung cấp những bó hoa tươi đẹp, được lựa chọn kỹ càng từ những vườn hoa chất lượng cao. Mỗi bông hoa đều được chăm sóc tỉ mỉ để mang đến vẻ đẹp tự nhiên và sự tươi mới lâu dài.    
            <br>Hãy để chúng tôi mang đến cho bạn những sản phẩm hoa tuyệt vời nhất để làm đẹp không gian sống.</p>  
            <img src="image/separator.png">
        </div>   
        <div class="box-container">
            <div class="box">
                <img src="image/delivery.png">
                <div>
                <h1>Giao hàng miễn phí, nhanh chóng</h1>
                <p>Chúng tôi luôn đặt sự hài lòng của khách hàng lên hàng đầu, cam kết giao hoa đúng giờ và miễn phí, giúp bạn lan tỏa yêu thương một cách dễ dàng nhất.</p>
            </div>
        </div>

            <div class="box">
                <img src="image/return.png">
                <div>
                <h1>Đảm bảo hoàn tiền</h1>
                <p>Chúng tôi cam kết hoàn tiền nếu sản phẩm không đạt yêu cầu, mang đến sự an tâm tuyệt đối cho khách hàng.</p>

                </div>
            </div>  

            <div class="box">
                <img src="image/discount.png">
                <div>
                <h1>Hỗ trợ trực tuyến 24/7</h1>
                <p>Đội ngũ của chúng tôi luôn sẵn sàng hỗ trợ bạn mọi lúc, mọi nơi để đảm bảo trải nghiệm mua sắm tốt nhất.</p>
                </div>
            </div>
        </div>
    </div>
        <!-- -------------------service form section end------------------->  
    <div class="contact">
        <div class="heading">
        <h1>Liên hệ với chúng tôi</h1>
        <p>Hãy để lại lời nhắn, và chúng tôi sẽ liên hệ lại với bạn sớm nhất có thể.  
        <br>Đội ngũ của chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn.</p>

            <img src="image/separator.png">
        </div>
        <div class="form-container">  
            <form action="" method="post" enctype="multipart/form-data" class="login"> 
                    <div class="input-field">  
                        <p>Tên của bạn <span>*</span></p>  
                        <input type="text" name="name" placeholder="Nhập tên của bạn" maxlength="50" required class="box">  
                    </div> 
                    <div class="input-field">  
                        <p>Email <span>*</span></p>  
                        <input type="email" name="email" placeholder="nhập email" maxlength="50" required class="box">  
                    </div>  
                    <div class="input-field">  
                        <p>Chủ đề<span>*</span></p>  
                        <input type="text" name="subject" placeholder="nhập chủ đề" maxlength="50" required class="box">  
                    </div>  

                    <div class="input-field">  
                        <p>Tin nhắn <span>*</span></p>  
                        <textarea name="message"  class="box"></textarea>
                    </div>  

                    <button type="submit" name="send_message" class="btn">Gửi tin nhắn</button>

                </form>  
        </div>  
    </div>
       
    <!-- -------------------contact forrm form section end------------------->  
    <div class="address">  
        <div class="heading">  
        <h1>Thông tin liên hệ của chúng tôi</h1>  
        <p>Chúng tôi luôn sẵn sàng kết nối với bạn. Hãy liên hệ với chúng tôi để được hỗ trợ và giải đáp thắc mắc.<p>
        <img src="image/separator.png">  
        </div>  
        <div class="box-container">  
            <div class="box">  
                <i class="bx bxs-map-alt"></i>  
                <div>  
                    <h4>Địa chỉ</h4>
                    <p>78 Võ Văn Tần, Phường 6, Quận 3, <br>Thành Phố Hồ Chí Minh , 7000 </p>
                </div>  
            </div> 
            
            <div class="box">  
                <i class="bx bxs-phone-incoming"></i>  
                <div>  
                    <h4>Liên hệ</h4>
                    <p>+84-338524157 </p>
                    <p>+84-348751185</p>
                </div>  
            </div>  

            <div class="box">  
                <i class="bx bxs-envelope"></i>  
                <div>  
                    <h4>email</h4>
                    <p>2200004138@nttu.edu.vn</p>
                    <p>2200005215@nttu.edu.vn</p>
                </div>  
            </div>  
        </div>  
    </div>
    <!-- -------------------address form section end------------------->  


    <?php include 'components/user_footer.php'; ?>

        <!-- sweetalert cdnlink -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <!-- cusstom js link -->
         <script type="text/javascript" src="js/user_script.js"></script>
        <!-- alert -->
        <?php include 'components/alert.php'; ?>

    </body>
</html>