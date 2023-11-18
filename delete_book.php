<?php
session_start();

if (isset($_GET["book_id"])) {
    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "bookstore";

    $conn = mysqli_connect($servername, $db_username, $db_password, $database);

    if (!$conn) {
        die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
    }

    // Lấy book_id từ biểu mẫu GET
    $book_id = $_GET["book_id"];

    // Thực hiện mã xóa sách
    $sql = "DELETE FROM books WHERE id = $book_id";

    if (mysqli_query($conn, $sql)) {
        // Sách đã được xóa thành công
        header("Location: index.php"); // Chuyển hướng về trang index.php
        exit();
    } else {
        echo "Lỗi xóa sách: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    // Nếu không có book_id, chuyển hướng hoặc hiển thị thông báo lỗi
    header("Location: index.php"); // Chuyển hướng về trang index.php
    exit();
}
?>
