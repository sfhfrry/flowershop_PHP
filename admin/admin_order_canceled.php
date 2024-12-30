<?php   
include '../components/connect.php';  

if (isset($_COOKIE['seller_id'])) {  
    $seller_id = $_COOKIE['seller_id'];  
} else {  
    $seller_id = '';  
    header('location:login.php');  
}  

// Xóa đơn hàng từ cơ sở dữ liệu   
if (isset($_POST['delete_order'])) {  
    $delete_id = $_POST['order_id'];  
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);  
    
    $verify_delete = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");  
    $verify_delete->execute([$delete_id]);  
    
    if ($verify_delete->rowCount() > 0) {  
        $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");  
        $delete_order->execute([$delete_id]);  
    
        $success_msg[] = 'Đơn hàng đã bị xóa';  
    } else {  
        $warning_msg[] = 'Đơn hàng không tồn tại';  
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
    <title>Cửa hàng - Vườn Hoa Tươi - Admin</title>  
    <style>  
        body {  
            font-family: 'Arial', sans-serif;  
            background-color: #f4f4f4;  
            margin: 0;  
            padding: 0;  
        }  

        .banner {  
            background-color: #f44336;  
            color: white;  
            padding: 20px;  
            text-align: center;  
        }  

        .banner h1 {  
            margin: 0;  
            font-size: 2.5rem;  
        }  

        .banner p {  
            margin: 5px 0;  
        }  

        .order-container {  
            max-width: 1200px;  
            margin: 20px auto;  
            padding: 20px;  
            background-color: white;  
            border-radius: 8px;  
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);  
        }  

        .heading {  
            text-align: center;  
            margin-bottom: 20px;  
        }  

        .heading h1 {  
            font-size: 2rem;  
            color: #333;  
        }  

        .heading img {  
            width: 100px;  
            margin: 10px auto;  
        }  
        .box-container {  
    display: flex;  
    justify-content: center; /* Căn giữa các box */  
}  


.box-container .box {  
    background-color: var(--white-alfa-25);  
    border: 2px solid var(--white-alfa-40);  
    backdrop-filter: var(--backdrop-filter);  
    box-shadow: var(--box-shadow);  
    margin: 1rem;  
    border-radius: 0.5rem;  
    padding: 20px; /* Giữ padding để nội dung không chạm vào viền */  
    width: 100%; /* Đặt chiều rộng box */  
    box-sizing: border-box; /* Để.padding và border không vượt quá kích thước */  
}  

        .box:hover {  
            transform: scale(1.02);  
        }  

        .status {  
            font-weight: bold;  
            font-size: 1.2rem;  
            width: 100%; 
            margin-bottom: 10px;  
            color: red;  
        }  

        .detail {  
            margin: 10px 0;  
        }  

        .detail p {  
            margin: 5px 0;  
            color: #555;  
        }  

        .detail span {  
            font-weight: bold;  
            color: #333;  
        }  

        .empty {  
            text-align: center;  
            color: #999;  
            font-size: 1.2rem;  
            margin: 20px 0;  
        }  

        .flex-btn {  
            display: flex;  
            justify-content: space-between;  
        }  

        .btn {  
            background-color: #f44336;  
            color: white;  
            border: none;  
            padding: 10px 15px;  
            border-radius: 5px;  
            cursor: pointer;  
            transition: background-color 0.3s;  
        }  

        .btn:hover {  
            background-color: #d32f2f;  
        }  
    </style>  
</head>  
<body>  

<?php include '../components/admin_header.php'; ?>  
<div class="banner">  
    <div class="detail">  
    <h1>Đơn hàng bị hủy</h1>  
    <p>Danh sách các đơn hàng đã bị hủy.</p>  
    <span><a href="dashboard.php">Admin</a><i class="bx bx-right-arrow-alt"></i> Đơn hàng bị hủy</span>  
    </div>  
</div>  

<section class="order-container">  
    <div class="heading">  
        <h1>Danh sách đơn hàng bị hủy</h1>  
        <img src="../image/separator.png">  
    </div>  

    <div class="box-container">  
        <?php   
        $select_order = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ? AND status = 'Đã hủy'");  
        $select_order->execute([$seller_id]);  

        if ($select_order->rowCount() > 0) {  
            while ($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)) {  
                ?>  
                <div class="box">  
                    <div class="status">Đơn hàng đã bị hủy</div>  
                    <div class="detail">  
                        <p>Tên người dùng: <span><?= htmlentities($fetch_order['name']); ?></span></p>  
                        <p>ID người dùng: <span><?= htmlentities($fetch_order['user_id']); ?></span></p>  
                        <p>Ngày đặt: <span><?= htmlentities($fetch_order['date']); ?></span></p>  
                        <p>Số lượng: <span><?= htmlentities($fetch_order['number']); ?></span></p>  
                        <p>Email: <span><?= htmlentities($fetch_order['email']); ?></span></p>  
                        <p>Tổng giá: <span><?= htmlentities($fetch_order['price']); ?></span></p>  
                        <p>Địa chỉ: <span><?= htmlentities($fetch_order['address']); ?></span></p>  
                    </div>  
                    <form action="" method="post">  
                        <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">  
                        <div class="flex-btn">  
                            <button type="submit" name="delete_order" class="btn">Xóa đơn hàng</button>  
                        </div>  
                    </form>  
                </div>    
                <?php   
            }  
        } else {  
            echo '  
            <div class="empty" style="margin: 2rem auto;">  
                <p>Chưa có đơn hàng nào bị hủy</p>  
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