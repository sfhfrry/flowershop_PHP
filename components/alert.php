<?php 
// Khởi tạo các biến nếu chưa được định nghĩa
if (!isset($success_msg)) $success_msg = [];
if (!isset($warning_msg)) $warning_msg = [];
if (!isset($info_msg)) $info_msg = [];
if (!isset($error_msg)) $error_msg = [];

    // Hiển thị thông báo thành công
    if (isset($success_msg) && !empty($success_msg)) {
        foreach ($success_msg as $msg){
            echo '<script>swal("'.$msg.'", "", "success");</script>';
        }
    }
    // Hiển thị thông báo cảnh báo
    if (isset($warning_msg) && !empty($warning_msg)) {
        foreach ($warning_msg as $msg){
            echo '<script>swal("'.$msg.'", "", "warning");</script>';
        }
    }
    // Hiển thị thông báo thông tin
    if (isset($info_msg) && !empty($info_msg)) {
        foreach ($info_msg as $msg){
            echo '<script>swal("'.$msg.'", "", "info");</script>';
        }
    }
    // Hiển thị thông báo lỗi
    if (isset($error_msg) && !empty($error_msg)) {
        foreach ($error_msg as $msg){
            echo '<script>swal("'.$msg.'", "", "error");</script>';
        }
    }
?>
