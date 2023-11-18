<?php
session_start();

if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) {
    // Kiểm tra xem người dùng có quyền admin hay không, nếu không, chuyển họ điều hướng về trang chính hoặc trang khác.
    header("Location: index.php");
    exit;
}

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$db_username = "root";
$db_password = "";
$database = "bookstore";

$conn = mysqli_connect($servername, $db_username, $db_password, $database);

if (!$conn) {
    die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["book_id"])) {
        // Lấy thông tin từ biểu mẫu và xử lý câu truy vấn cập nhật
        $book_id = $_POST["book_id"];
        $new_title = $_POST["new_title"];
        $new_author = $_POST["new_author"];
        $new_description = $_POST["new_description"];
        $new_price = $_POST["new_price"];

        // Cập nhật thông tin sách trong cơ sở dữ liệu
        $update_sql = "UPDATE books SET title = '$new_title', author = '$new_author', description = '$new_description', price = '$new_price' WHERE id = '$book_id'";

        if (mysqli_query($conn, $update_sql)) {
            echo "Cập nhật thông tin sách thành công.";
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }
    }
}

// Lấy thông tin sách dựa trên book_id (ID của cuốn sách được chỉnh sửa)
if (isset($_GET["book_id"])) {
    $book_id = $_GET["book_id"];
    $sql = "SELECT * FROM books WHERE id = $book_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Không tìm thấy sách.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin sách</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="navbar">
        <!-- Navbar code here (as in your previous code) -->
    </div>

    <h2>Chỉnh sửa thông tin sách</h2>
    <form method="POST" action="edit_book.php">
        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
        <label for="new_title">Tiêu đề:</label>
        <input type="text" name="new_title" value="<?php echo $row["title"]; ?>"><br>
        <label for="new_author">Tác giả:</label>
        <input type="text" name="new_author" value="<?php echo $row["author"]; ?>"><br>
        <label for="new_description">Mô tả:</label>
        <textarea name="new_description"><?php echo $row["description"]; ?></textarea><br>
        <label for="new_price">Giá tiền:</label>
        <input type="text" name="new_price" value="<?php echo $row["price"]; ?>"><br>
        <input type="submit" value="Lưu thay đổi">
        <a href="index.php">Quay lại</a>
    </form>
</body>
</html>
