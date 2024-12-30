<?php   
include '../components/connect.php';  

if (isset($_COOKIE['seller_id'])) {  
    $seller_id = $_COOKIE['seller_id'];  
} else {  
    $seller_id = '';  
    header('location:login.php');  
}  

// Xóa tin nhắn  
if (isset($_POST['delete'])) {  
    $delete_id = $_POST['delete_id'];  
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);  
    
    $verify_delete = $conn->prepare("SELECT * FROM `message` WHERE id = ?");  
    $verify_delete->execute([$delete_id]);  
    
    if ($verify_delete->rowCount() > 0) {  
        $delete_message = $conn->prepare("DELETE FROM `message` WHERE id = ?");  
        $delete_message->execute([$delete_id]);  
        
        $success_msg[] = 'Tin nhắn đã bị xóa';  
    } else {  
        $warning_msg[] = 'Tin nhắn không tồn tại';  
    }  
}  

// Phản hồi tin nhắn  
if (isset($_POST['respond'])) {  
    $message_id = $_POST['message_id'];  
    $response = $_POST['response'];  
    $response = filter_var($response, FILTER_SANITIZE_STRING);  
    
    if (!empty($response)) {  
        $insert_response = $conn->prepare("INSERT INTO `responses` (message_id, response) VALUES (?, ?)");  
        $insert_response->execute([$message_id, $response]);  
        
        $success_msg[] = 'Phản hồi đã được gửi';  
    } else {  
        $warning_msg[] = 'Vui lòng nhập phản hồi';  
    }  
}  
?>  

<!DOCTYPE html>  
<html>  
<head>  
    <meta charset="utf-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>  
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css?v=<?php echo time(); ?>">  
    <title>Cửa hàng - Vườn Hoa Tươi</title>  
</head>  
<body>  

    <?php include '../components/admin_header.php'; ?>  
    <div class="banner">  
        <div class="detail">  
            <h1>Tin nhắn người dùng</h1>  
            <p>Chúng tôi luôn sẵn sàng lắng nghe ý kiến từ khách hàng và cải thiện dịch vụ của mình. Hãy chia sẻ với chúng tôi những trải nghiệm của bạn để chúng tôi có thể phục vụ bạn tốt hơn.</p>  
            <span><a href="dashboard.php">Quản trị viên</a><i class="bx bx-right-arrow-alt"></i> Tin nhắn người dùng</span>  
        </div>  
    </div>  
    <div></div>  
    <section class="message-container">  
        <div class="heading">  
            <h1>Tin nhắn người dùng</h1>  
            <img src="../image/separator.png">  
        </div>  

        <div class="box-container">  
            <?php  
                $select_message = $conn->prepare("SELECT * FROM `message`");  
                $select_message->execute();  

                if ($select_message->rowCount() > 0) {  
                    while($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)){  
            ?>   
            <div class="box">  
                <h3 class="name"><?= $fetch_message['name']; ?></h3>  
                <h4><?= $fetch_message['subject']; ?></h4>  
                <p><?= $fetch_message['message']; ?></p>  

                <!-- Phản hồi tin nhắn -->  
                <form action="" method="post">  
                    <input type="hidden" name="message_id" value="<?= $fetch_message['id']; ?>">  
                    <textarea name="response" placeholder="Nhập phản hồi của bạn" required></textarea>  
                    <button type="submit" name="respond" class="btn">Gửi phản hồi</button>  
                </form>  

                <form action="" method="post">  
                    <input type="hidden" name="delete_id" value="<?= $fetch_message['id']; ?>">  
                    <button type="submit" name="delete" class="btn" onclick="return confirm('Bạn có chắc chắn muốn xóa tin nhắn này không?');">Xóa tin nhắn</button>  
                </form>  
            </div>   
            <?php  
                    }   
                } else {  
                    echo '  
                    <div class="empty" style="margin: 2rem auto;">  
                        <p>Không có tin nhắn nào</p>  
                    </div>';  
                }  
            ?>  
        </div>  
    </section>  

    <?php include '../components/admin_footer.php'; ?>  

    <!-- sweetalert cdnlink -->  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>  
    <!-- custom js link -->  
    <script type="text/javascript" src="../js/admin_script.js"></script>  
    <!-- alert -->  
    <?php include '../components/alert.php'; ?>  

</body>  
</html>