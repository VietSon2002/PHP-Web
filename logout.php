<?php
// Khởi động phiên làm việc
session_start();

// Hủy bỏ tất cả các biến phiên làm việc
session_unset();

// Hủy phiên làm việc
session_destroy();

// Chuyển hướng người dùng về trang đăng nhập hoặc trang chủ
header("Location: login.php"); // Thay đổi trang đích nếu cần
exit();
?>
