<?php   
include 'components/connect.php';  

if (isset($_COOKIE['user_id'])) {  
    $user_id = $_COOKIE['user_id'];  
} else {  
    header('Location: login.php'); // Chuyển hướng đến trang đăng nhập nếu không có user_id  
    exit;  
}  

// Lấy thông tin người dùng  
$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");  
$select_profile->execute([$user_id]);  
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);  

// Lấy đơn hàng của người dùng  
$select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");  
$select_orders->execute([$user_id]);  
$total_orders = $select_orders->rowCount();  

// Lấy tin nhắn của người dùng  
$select_message = $conn->prepare("SELECT * FROM `message` WHERE user_id = ?");  
$select_message->execute([$user_id]);  
$total_message = $select_message->rowCount();  

// Lấy phản hồi cho người dùng  
$responses = $conn->prepare("SELECT r.response, r.created_at   
                              FROM responses r   
                              JOIN message m ON r.message_id = m.id   
                              WHERE m.user_id = ?   
                              ORDER BY r.created_at DESC");  
$responses->execute([$user_id]);  
$feedbacks = $responses->fetchAll(PDO::FETCH_ASSOC);  
?>  

<!DOCTYPE html>  
<html>  
<head>  
    <meta charset="utf-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>  
    <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">  
    <title>Cửa hàng - Vườn Hoa Tươi - Hồ Sơ</title>   
</head>  
<body>  
    <?php include 'components/user_header.php'; ?>  

    <div class="banner">  
        <div class="detail">  
            <h1>Hồ sơ của bạn</h1>  
            <p>Chào mừng bạn đến với trang hồ sơ của bạn. Tại đây, bạn có thể cập nhật thông tin cá nhân, theo dõi đơn hàng, và quản lý các sản phẩm bạn đã mua hoặc bán. Hãy đảm bảo rằng thông tin của bạn luôn được cập nhật để trải nghiệm dịch vụ tốt nhất.</p>  
            <span><a href="home.php">Trang Chủ</a><i class="bx bx-right-arrow-alt"></i>Hồ sơ</span>  
        </div>  
    </div>  

    <section class="profile">  
        <div class="heading">  
            <h1>Chi tiết Hồ Sơ</h1>  
            <img src="image/separator.png">  
        </div>  
        <div class="details">  
            <div class="user">  
                <img src="uploaded_files/<?= $fetch_profile['image']; ?>">  
                <h3><?php echo $fetch_profile['name']; ?></h3>  
                <p>Người dùng</p>  
                <a href="update.php" class="btn">Cập nhật Hồ Sơ</a>  
            </div>  

            <div class="box-container">  
                <div class="box">  
                    <div class="flex">  
                        <i class="bx bxs-food-menu"></i>  
                        <h3><?= $total_orders; ?></h3>  
                    </div>  
                    <a href="order.php" class="btn">Xem Hồ Sơ</a>  
                </div>  
                <div class="box">  
                    <div class="flex">  
                        <i class="bx bxs-chat"></i>  
                        <h3><?= $total_message; ?></h3>  
                    </div>  
                    <a href="contact.php" class="btn">Gửi tin nhắn</a>  
                </div>  
            </div>  
        </div>  
    </section>  

    <section class="feedbacks">  
        <div class="heading">  
            <h1>Phản hồi từ quản trị viên</h1>  
            <img src="image/separator.png">  
        </div>  
        <?php if (count($feedbacks) > 0): ?>  
            <ul>  
                <?php foreach ($feedbacks as $feedback): ?>  
                    <li>  
                        <strong>Ngày: <?php echo date('d/m/Y H:i', strtotime($feedback['created_at'])); ?></strong>  
                        <p><?php echo htmlspecialchars($feedback['response']); ?></p>  
                    </li>  
                <?php endforeach; ?>  
                <a href="contact.php" class="btn">Trả lời phản hồi</a>
            </ul>
        <?php else: ?>  
            <p>Chưa có phản hồi nào từ quản trị viên.</p>  
        <?php endif; ?>  
    </section>  

    <?php include 'components/user_footer.php'; ?>  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>  
    <script type="text/javascript" src="js/user_script.js"></script>  
    <?php include 'components/alert.php'; ?>  
</body>  
</html>