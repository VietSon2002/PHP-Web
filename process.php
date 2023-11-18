<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu
    $title = $_POST["title"];
    $author = $_POST["author"];
    $price = $_POST["price"];
    
    // Kết nối cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "bookstore";
    $conn = mysqli_connect($servername, $username, $password, $database);
    
    // Kiểm tra kết nối
    if (!$conn) {
        die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
    }
    
    // Thêm dữ liệu vào cơ sở dữ liệu
    $sql = "INSERT INTO books (title, author, price) VALUES ('$title', '$author', '$price')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Sách đã được thêm thành công";
    } else {
        echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    // Đóng kết nối cơ sở dữ liệu
    mysqli_close($conn);
}
?>
