<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu đăng nhập và loại bỏ các ký tự đặc biệt
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $password = $_POST["password"];
    
    // Kiểm tra dữ liệu nhập vào
    if (empty($username) || empty($password)) {
        echo "Vui lòng điền đầy đủ thông tin đăng nhập.";
        exit();
    }
    
    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "bookstore";
    
    $conn = mysqli_connect($servername, $db_username, $db_password, $database);
    
    // Kiểm tra kết nối
    if (!$conn) {
        die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
    }
    
    // Tránh sử dụng câu truy vấn trực tiếp để ngăn chặn tấn công SQL Injection
    $stmt = mysqli_prepare($conn, "SELECT id, username, password, role FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    
    // Lấy kết quả từ câu truy vấn
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Kiểm tra mật khẩu bằng hàm password_verify
        if (password_verify($password, $row["password"])) {
            // Đăng nhập thành công
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["logged_in"] = true; // Đánh dấu đã đăng nhập
            
            // Kiểm tra quyền admin
            if ($row["role"] == "admin") {
                $_SESSION["is_admin"] = true;
            } else {
                $_SESSION["is_admin"] = false;
            }
            
            header("Location: index.php"); // Chuyển hướng đến trang chính
            exit();
        } else {
            echo "Mật khẩu không đúng.";
        }
    } else {
        echo "Tài khoản không tồn tại.";
    }
    
    // Đóng kết nối cơ sở dữ liệu và câu truy vấn
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
