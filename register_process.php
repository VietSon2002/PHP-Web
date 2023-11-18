<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
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
    
    // Kiểm tra xem tên đăng nhập đã tồn tại trong cơ sở dữ liệu hay chưa
    $check_query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($result) > 0) {
        echo "Tên đăng nhập đã tồn tại.";
    } else {
        // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu (bạn nên sử dụng mã hóa mạnh hơn)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Thêm tài khoản mới vào cơ sở dữ liệu
        $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        if (mysqli_query($conn, $insert_query)) {
            echo "Đăng ký thành công.";
        } else {
            echo "Lỗi khi đăng ký: " . mysqli_error($conn);
        }
    }
    
    // Đóng kết nối cơ sở dữ liệu
    mysqli_close($conn);
}
?>
