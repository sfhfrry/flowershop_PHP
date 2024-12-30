<?php  
$db_name = 'mysql:host=localhost;dbname=flowershop_db';  
$user_name = 'root';  
$user_password = '';  

try {  
    $conn = new PDO($db_name, $user_name, $user_password);  
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
} catch (PDOException $e) {  
    echo "Kết nối thất bại: " . $e->getMessage();  
}  

// Khởi tạo ngày hôm nay  
$today = new DateTime();  
$days = [];  
$sales = [];  

// Truy vấn doanh số cho ngày hôm nay  
$todayDate = $today->format('Y-m-d');  
$select_today_sales = $conn->prepare("SELECT SUM(price) FROM `orders` WHERE DATE(date) = ?");  
$select_today_sales->execute([$todayDate]);  
$today_sales = $select_today_sales->fetchColumn();  
$sales[] = $today_sales ? (float)$today_sales : 0; // Gán 0 nếu không có hóa đơn  
$days[] = $todayDate; // Thêm ngày hôm nay vào mảng ngày  

// Lấy doanh số cho 29 ngày trước đó (30 ngày tổng cộng)  
for ($i = 1; $i <= 29; $i++) {  
    $date = $today->sub(new DateInterval('P1D'))->format('Y-m-d');  
    $days[] = $date;  

    // Truy vấn để lấy tổng doanh thu từ bảng orders  
    $select_sales = $conn->prepare("SELECT SUM(price) FROM `orders` WHERE DATE(date) = ?");  
    $select_sales->execute([$date]);  
    
    $total_sales = $select_sales->fetchColumn();  
    $sales[] = $total_sales ? (float)$total_sales : 0;  // Nếu không có hóa đơn, gán 0  
}  

// Lấy doanh số theo tháng  
$months = [];  
$monthly_sales = [];  
$today = new DateTime(); // Reset lại ngày hôm nay  

for ($i = 0; $i < 12; $i++) {  
    $month = $today->sub(new DateInterval('P1M'))->format('Y-m');  
    $months[] = $month;  

    // Truy vấn tổng doanh thu theo tháng  
    $select_monthly_sales = $conn->prepare("SELECT SUM(price) FROM `orders` WHERE DATE_FORMAT(date, '%Y-%m') = ?");  
    $select_monthly_sales->execute([$month]);  

    $total_monthly_sales = $select_monthly_sales->fetchColumn();  
    $monthly_sales[] = $total_monthly_sales ? (float)$total_monthly_sales : 0; // Gán 0 nếu không có hóa đơn  
}  

// Lấy doanh số theo năm  
$years = [];  
$yearly_sales = [];  
for ($i = 0; $i < 5; $i++) {  
    $year = date('Y', strtotime("-$i year"));  
    $years[] = $year;  

    // Truy vấn tổng doanh thu theo năm  
    $select_yearly_sales = $conn->prepare("SELECT SUM(price) FROM `orders` WHERE YEAR(date) = ?");  
    $select_yearly_sales->execute([$year]);  

    $total_yearly_sales = $select_yearly_sales->fetchColumn();  
    $yearly_sales[] = $total_yearly_sales ? (float)$total_yearly_sales : 0; // Gán 0 nếu không có hóa đơn  
}  
?>  
<!DOCTYPE html>  
<html lang="vi">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Thống Kê Doanh Số Bán Hàng</title>  
    <link rel="stylesheet" href="style.css"> <!-- Đảm bảo đường dẫn đúng -->  
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  
    <style>  
        body {  
            font-family: 'Arial', sans-serif;  
            background-color: #f9f9f9;  
            margin: 0;  
            padding: 0;  
            color: #333;  
        }  

        .banner {  
            background-color: #ff8a80; /* Màu nền banner */  
            padding: 40px;  
            text-align: center;  
            color: white;  
        }  

        .charts {  
            display: flex;  
            flex-direction: column;  
            align-items: center;  
            margin: 30px;  
        }  

        .chart-container {  
            width: 80%;  
            margin: 20px 0;  
        }  
        canvas {  
            background-color: #fff;  
            border: 1px solid #ddd;  
        }  

        .total-sales {  
            font-size: 1.2em;  
            margin-top: 10px;  
            text-align: center;  
        }  

        .statistic {  
            font-weight: bold;  
            margin-top: 10px;  
            font-size: 1.4em;  
            color: #333;  
            text-align: center;  
        }  
    </style>  
</head>  
<body>  

<div class="banner">  
    <h1>Thống Kê Doanh Số Bán Hàng</h1>  
    <span><a href="dashboard.php">Quản Trị viên</a><i class="bx bx-right-arrow-alt"></i> </span>  
</div>  
<div class="charts">  
    <!-- Biểu đồ doanh số hàng ngày -->  
    <div class="chart-container">  
        <h2>Doanh Số Hàng Ngày (30 Ngày Qua)</h2>  
        <canvas id="dailySalesChart"></canvas>  
        <div class="statistic" id="totalDailySales"></div> <!-- Thống kê tổng doanh số hàng ngày -->  
    </div>  

    <!-- Biểu đồ doanh số hàng tháng -->  
    <div class="chart-container">  
        <h2>Doanh Số Hàng Tháng</h2>  
        <canvas id="monthlySalesChart"></canvas>  
        <div class="statistic" id="totalMonthlySales"></div> <!-- Thống kê tổng doanh số hàng tháng -->  
    </div>  

    <!-- Biểu đồ doanh số hàng năm -->  
    <div class="chart-container">  
        <h2>Doanh Số Hàng Năm</h2>  
        <canvas id="yearlySalesChart"></canvas>  
        <div class="statistic" id="totalYearlySales"></div> <!-- Thống kê tổng doanh số hàng năm -->  
    </div>  
</div>  

<script>  
    const formatCurrency = (amount) => {  
        return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });  
    };  

    // Biểu đồ doanh số hàng ngày  
    const ctxDaily = document.getElementById('dailySalesChart').getContext('2d');  
    const dailySalesChart = new Chart(ctxDaily, {  
        type: 'line',  
        data: {  
            labels: <?php echo json_encode(array_reverse($days)); ?>,  
            datasets: [{  
                label: 'Doanh Số',  
                data: <?php echo json_encode(array_reverse($sales)); ?>,  
                borderColor: 'rgba(75, 192, 192, 1)',  
                backgroundColor: 'rgba(75, 192, 192, 0.2)',  
                borderWidth: 2,  
            }]  
        },  
        options: {  
            scales: {  
                y: {  
                    beginAtZero: true  
                }  
            }  
        }  
    });  

    // Tính tổng doanh số hàng ngày và hiển thị  
    const totalDailySales = <?php echo json_encode(array_sum($sales)); ?>;  
    document.getElementById('totalDailySales').innerText = 'Tổng doanh số: ' + formatCurrency(totalDailySales);  

    // Biểu đồ doanh số hàng tháng  
    const ctxMonthly = document.getElementById('monthlySalesChart').getContext('2d');  
    const monthlySalesChart = new Chart(ctxMonthly, {  
        type: 'bar',  
        data: {  
            labels: <?php echo json_encode(array_reverse($months)); ?>,  
            datasets: [{  
                label: 'Doanh Số',  
                data: <?php echo json_encode(array_reverse($monthly_sales)); ?>,  
                backgroundColor: 'rgba(153, 102, 255, 0.2)',  
                borderColor: 'rgba(153, 102, 255, 1)',  
                borderWidth: 1,  
            }]  
        },  
        options: {  
            scales: {  
                y: {  
                    beginAtZero: true  
                }  
            }  
        }  
    });  

    // Tính tổng doanh số hàng tháng và hiển thị  
    const totalMonthlySales = <?php echo json_encode(array_sum($monthly_sales)); ?>;  
    document.getElementById('totalMonthlySales').innerText = 'Tổng doanh số: ' + formatCurrency(totalMonthlySales);  

    // Biểu đồ doanh số hàng năm  
    const ctxYearly = document.getElementById('yearlySalesChart').getContext('2d');  
    const yearlySalesChart = new Chart(ctxYearly, {  
        type: 'bar',  
        data: {  
            labels: <?php echo json_encode(array_reverse($years)); ?>,  
            datasets: [{  
                label: 'Doanh Số',  
                data: <?php echo json_encode(array_reverse($yearly_sales)); ?>,  
                backgroundColor: 'rgba(255, 159, 64, 0.2)',  
                borderColor: 'rgba(255, 159, 64, 1)',  
                borderWidth: 1,  
            }]  
        },  
        options: {  
            scales: {  
                y: {  
                    beginAtZero: true  
                }  
            }  
        }  
    });  

    // Tính tổng doanh số hàng năm và hiển thị  
    const totalYearlySales = <?php echo json_encode(array_sum($yearly_sales)); ?>;  
    document.getElementById('totalYearlySales').innerText = 'Tổng doanh số: ' + formatCurrency(totalYearlySales);  
</script>  

</body>  
</html>