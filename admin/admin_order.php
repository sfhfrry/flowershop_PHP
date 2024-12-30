<?php 
      include '../components/connect.php';
    
      if (isset($_COOKIE['seller_id'])) {  
        $seller_id = $_COOKIE['seller_id'];  
    } else {  
        $seller_id = '';  
        header('location:login.php');  
    }


    // update payment status from database 
       
    if (isset($_POST['update_order'])) {  
        $order_id = $_POST['order_id'];  
        $order_id = filter_var($order_id, FILTER_SANITIZE_STRING);  
    
        $update_payment = $_POST['update_payment'];  
        $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);  
    
        $update_pay = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");  
        $update_pay->execute([$update_payment, $order_id]);  
    
        $success_msg[] = 'thanh toán đơn hàng đã cập nhật trạng thái';  
    }

        // delete order from database 

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
                $warning_msg[] = 'Đơn hàng đã bị xóa';  
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
        <title>Cửa hàng - Vườn Hoa Tươi - Admin</title>
        <style>
            body {  
    font-family: 'Arial', sans-serif;  
    background-color: #f4f4f4;  
    margin: 0;  
    padding: 0;  
}  

.banner {  
    background-color: #4CAF50;  
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
    flex-wrap: wrap;  
    justify-content: space-between;  
}  

.box {  
    flex: 0 0 30%;  
    background-color: #f9f9f9;  
    border: 1px solid #ddd;  
    border-radius: 8px;  
    margin: 10px;  
    padding: 15px;  
    transition: transform 0.3s;  
}  

.box:hover {  
    transform: scale(1.02);  
}  

.status {  
    font-weight: bold;  
    font-size: 1.2rem;  
    margin-bottom: 10px;  
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

select {  
    width: 100%;  
    padding: 10px;  
    margin: 10px 0;  
    border: 1px solid #ccc;  
    border-radius: 4px;  
}  

.flex-btn {  
    display: flex;  
    justify-content: space-between;  
}  

.btn {  
    background-color: #4CAF50;  
    color: white;  
    border: none;  
    padding: 10px 15px;  
    border-radius: 5px;  
    cursor: pointer;  
    transition: background-color 0.3s;  
}  

.btn:hover {  
    background-color: #45a049;  
}  

.empty {  
    text-align: center;  
    color: #999;  
    font-size: 1.2rem;  
    margin: 20px 0;  
}
        </style>
    </head>
    <body>

 <?php include '../components/admin_header.php'; ?>
        <div class="banner">  
            <div class="detail">  
            <h1>Chi tiết đơn hàng</h1>  
            <p>Thông tin chi tiết về đơn hàng của bạn sẽ được hiển thị ở đây. Hãy kiểm tra kỹ lưỡng và theo dõi trạng thái đơn hàng của mình.</p>  
            <span><a href="dashboard.php">Admin</a><i class="bx bx-right-arrow-alt"></i> Chi tiết đơn hàng</span>

            </div>  
        </div>
     
        <section class="order-container">
            <div class="heading">
                <h1>tổng số đơn đặt hàng</h1>
                <img src="../image/separator.png">
            </div>

            <div class="box-container">  
                <?php 

                    $select_order = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ?");  
                    $select_order->execute([$seller_id]);  

                    if ($select_order->rowCount() > 0) {  
                        while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)){  

                    ?>  
                    <div class="box">  
                    <div class="status" style="color: <?php if($fetch_order['status']=='active'){  
                            echo "limegreen";}else{echo "red";} ?>;">
                            <?= $fetch_order['status'] == 'active' ? 'Hoạt động' : 'Không hoạt động'; ?>
                        </div>

                    </div>  
                        <div class="detail">  
                            <p>Tên người dùng: <span><?= $fetch_order['name']; ?></span></p>  
                            <p>ID người dùng: <span><?= $fetch_order['user_id']; ?></span></p>  
                            <p>Ngày đặt: <span><?= $fetch_order['date']; ?></span></p>  
                            <p>Số lượng: <span><?= $fetch_order['number']; ?></span></p>  
                            <p>Email: <span><?= $fetch_order['email']; ?></span></p>  
                            <p>Tổng giá: <span><?= $fetch_order['price']; ?></span></p>  
                            <p>Địa chỉ: <span><?= $fetch_order['address']; ?></span></p>  
                        </div>
                        <form action="" method="post">  
                            <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">  
                            <select name="update_payment" class="box" style="width:90%;">  
                                <option disabled selected><?= $fetch_order['payment_status']; ?></option>  
                                <option value="Đang chờ xử lí">Đang chờ xử lý</option>  
                                <option value="Hoàn thành">Hoàn thành</option>

                            </select>  
                        </div>  
                        <div class="flex-btn">  
                            <button type="submit" name="update_order" class="btn">Cập nhật thanh toán</button>  
                            <button type="submit" name="delete_order" class="btn">Xóa đơn hàng</button>
                        </div>  
                        </form>

                    </div>    
                <?php   

                    }  
                }else {  
                    echo '  
                    <div class="empty" style="margin: 2rem auto;">  
                        <p>chưa có đơn hàng nào được đặt  </p>  
                    </div>  
                    ';  
                }
                ?>
            </div>
            
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