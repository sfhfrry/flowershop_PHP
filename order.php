<?php  
include 'components/connect.php';  

if (!isset($_COOKIE['user_id'])) {  
    header('Location: login.php');  
    exit;  
} else {  
    $user_id = $_COOKIE['user_id'];  
}  

// Kiểm tra nếu có yêu cầu hủy đơn hàng  
if (isset($_POST['cancel_order'])) {  
    $order_id = $_POST['order_id'];  
    $cancel_order = $conn->prepare("UPDATE `orders` SET `status` = 'Đã Hủy' WHERE `id` = ? AND `user_id` = ?");  
    $cancel_order->execute([$order_id, $user_id]);  
    echo "<script>alert('Đơn hàng đã được hủy!');</script>";  
}  

// Kiểm tra nếu có yêu cầu đặt lại sản phẩm  
if (isset($_POST['reorder_product'])) {  
    $product_id = $_POST['product_id'];  
    $qty = $_POST['quantity']; // Lấy số lượng từ đơn hàng trước  
    $price = $_POST['price']; // Lấy giá từ đơn hàng trước  

    // Thêm đơn hàng mới  
    $add_order = $conn->prepare("INSERT INTO `orders` (user_id, product_id, qty, price, status) VALUES (?, ?, ?, ?, 'Chờ xử lý')");  
    $add_order->execute([$user_id, $product_id, $qty, $price]);  

    echo "<script>alert('Sản phẩm đã được đặt lại thành công!');</script>";  
}  

// Kiểm tra nếu có yêu cầu xóa đơn hàng  
if (isset($_POST['delete_order'])) {  
    $order_id = $_POST['order_id'];  
    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE `id` = ? AND `user_id` = ?");  
    $delete_order->execute([$order_id, $user_id]);  
    echo "<script>alert('Đơn hàng đã được xóa!');</script>";  
}  

// Kiểm tra nếu có yêu cầu xác nhận đã nhận hàng  
if (isset($_POST['confirm_received'])) {  
    $order_id = $_POST['order_id'];  
    $confirm_received = $conn->prepare("UPDATE `orders` SET `status` = 'Đã Nhận' WHERE `id` = ? AND `user_id` = ?");  
    $confirm_received->execute([$order_id, $user_id]);  
    echo "<script>alert('Đơn hàng đã được xác nhận nhận thành công!');</script>";  
}  

// Lấy tất cả các đơn hàng của người dùng và sắp xếp theo trạng thái  
$fetch_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY   
    CASE   
        WHEN status = 'Chờ xử lý' THEN 1   
        WHEN status = 'Đã Hủy' THEN 2   
        WHEN status = 'Đã Nhận' THEN 3   
    END, date DESC");  
$fetch_orders->execute([$user_id]);  
?>  

<!DOCTYPE html>  
<html lang="vi">  
<head>  
    <meta charset="utf-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>  
    <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">  
    <title>Đơn Hàng - Vườn Hoa Tươi</title>  
    <style>  
        body {  
            font-family: Arial, sans-serif;  
            background-color: #f8f8f8;  
            margin: 0;  
            padding: 20px;  
        }  

        .order-container {  
            max-width: 1200px;  
            margin: 0 auto;  
            padding: 20px;  
            background-color: #ffffff;  
            border-radius: 8px;  
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);  
        }  

        .order-container h1 {  
            text-align: center;  
            color: #333;  
        }  

        .order-card {  
            display: flex;  
            align-items: center;  
            background-color: #f9f9f9;  
            border: 1px solid #e0e0e0;  
            border-radius: 8px;  
            margin: 15px 0;  
            padding: 15px;  
            transition: transform 0.2s;  
        }  

        .order-card:hover {  
            transform: scale(1.02);  
        }  

        .product-image {  
            width: 150px;  
            height: auto;  
            border-radius: 8px;  
            margin-right: 20px;  
        }  

        .order-info {  
            flex: 1;  
        }  

        .order-info h3 {  
            margin: 0;  
            font-size: 20px;  
            color: #555;  
        }  

        .order-info p {  
            margin: 5px 0;  
            color: #777;  
        }  

        .order-info p:last-child {  
            font-weight: bold;  
            color: #e67e22;  
        }  

        .empty {  
            text-align: center;  
            color: #999;  
            font-size: 18px;  
        }  

        .btn {  
            background-color: #e74c3c;  
            color: white;  
            border: none;  
            padding: 10px 15px;  
            border-radius: 5px;  
            cursor: pointer;  
            margin: 5px 0;  
        }  

        .btn:hover {  
            background-color: #c0392b;  
        }  

        .btn-reorder {  
            background-color: #3498db;  
        }  

        .btn-reorder:hover {  
            background-color: #2980b9;  
        }  

        .btn-delete {  
            background-color: #e67e22;  
        }  

        .btn-delete:hover {  
            background-color: #d35400;  
        }  

        .btn-confirm {  
            background-color: #2ecc71; /* Màu xanh cho xác nhận */  
        }  

        .btn-confirm:hover {  
            background-color: #27ae60; /* Màu xanh đậm khi hover */  
        }  
    </style>  
</head>  
<body>  

<?php include 'components/user_header.php'; ?>  

<div class="order-container">  
    <h1>Đơn Hàng Của Bạn</h1>  
    
    <?php   
    if ($fetch_orders->rowCount() > 0) {  
        while ($fetch_order = $fetch_orders->fetch(PDO::FETCH_ASSOC)) {  
            $order_id = $fetch_order['id'];  
            $product_id = $fetch_order['product_id'];  
            $qty = $fetch_order['qty'];  
            $status = $fetch_order['status'];  
            $date = date('Y-m-d', strtotime($fetch_order['date']));  
            $price = $fetch_order['price'];  
            $address = $fetch_order['address'];
            $name = $fetch_order['name'];

            // Lấy thông tin sản phẩm từ bảng products  
            $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");  
            $select_product->execute([$product_id]);  
            $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);  

            $product_name = $fetch_product ? $fetch_product['name'] : "Sản phẩm không tìm thấy";  
            $product_image = $fetch_product ? $fetch_product['image'] : "default.jpg";  

            // Hiển thị thông tin đơn hàng  
            ?>  
            <div class="order-card">  
                <a href="view_order.php?getid=<?= htmlspecialchars($order_id); ?>">  
                    <img src="image/products/<?= htmlspecialchars($product_image); ?>" alt="<?= htmlspecialchars($product_name); ?>" class="product-image">  
                    <div class="order-info">  
                        <h3>Thông tin sản phẩm: <?= htmlspecialchars($product_name); ?></h3>
                        <p>Tên người đặt: <?= htmlspecialchars($name); ?></p>  
                        <p>Số lượng: <?= htmlspecialchars($qty); ?></p>  
                        <p>Giá: <?= htmlspecialchars($price); ?> VNĐ</p>  
                        <p>Ngày đặt: <?= htmlspecialchars($date); ?></p>  
                        <p>Địa chỉ: <?= htmlspecialchars($address); ?></p>
                        <p>Trạng thái: 
                            <?php 
                                if ($status === 'in progress') {
                                    echo 'Đang xử lý'; // Thay đổi thành tiếng Việt
                                } elseif ($status === 'Completed') {
                                    echo 'Hoàn thành';
                                } elseif ($status === 'Cancelled') {
                                    echo 'Đã hủy';
                                } else {
                                    echo htmlspecialchars($status); // Hiển thị các trạng thái khác
                                }
                            ?>
                        </p>                    
            </div>  
                </a>  
                <form action="" method="POST" style="margin-left: 15px; display: flex; flex-direction: column;">  
    <input type="hidden" name="order_id" value="<?= htmlspecialchars($fetch_order['id']); ?>">  
    <?php if ($status === 'Đã Hủy') { ?>  
        <button type="submit" name="delete_order" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');" class="btn btn-delete">Xóa đơn hàng</button>  
    <?php } elseif ($status !== 'Đã Nhận') { ?>  
        <button type="submit" name="cancel_order" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?');" class="btn">Hủy đơn hàng</button>  
    <?php } ?>  
    
    <?php if ($status !== 'Đã Nhận' && $status !== 'Đã Hủy') { ?>  
        <button type="submit" name="confirm_received" onclick="return confirm('Bạn có chắc chắn đã nhận hàng?');" class="btn btn-confirm">Đã Nhận Hàng</button>  
    <?php } ?>  
    
    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id); ?>">  
    <input type="hidden" name="quantity" value="<?= htmlspecialchars($qty); ?>"> <!-- Số lượng sẽ được đặt lại -->  
    <input type="hidden" name="price" value="<?= htmlspecialchars($price); ?>"> <!-- Lấy giá để đặt lại -->  
    <?php if ($status === 'Đã Nhận') { ?>  
        <strong style="color: green;">Đã nhận hàng</strong>  
    <?php } else { ?>  
        <button type="submit" name="reorder_product" class="btn btn-reorder">Đặt lại sản phẩm</button>  
    <?php } ?>  
</form>
            </div>  
            <?php  
        }  
    } else {  
        echo '<div class="empty">  
                <p>Chưa có sản phẩm nào được đặt!</p>  
              </div>';  
    }  
    ?>  
</div>  

<?php include 'components/user_footer.php'; ?>  
</body>  
</html>