<!DOCTYPE html>
<html>
<head>
    <title>Thêm sách mới</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h1>Thêm sách mới</h1>

    <?php
    session_start();
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
        // Nếu đã đăng nhập, hiển thị form thêm sách
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $author = $_POST["author"];
            $description = $_POST["description"];
            $image = $_FILES["image"]["name"];
            $price = $_POST["price"];

            // Xử lý tải lên hình ảnh và lưu vào thư mục "uploads"
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

            // Kết nối đến cơ sở dữ liệu
            $servername = "localhost";
            $db_username = "root";
            $db_password = "";
            $database = "bookstore";

            $conn = mysqli_connect($servername, $db_username, $db_password, $database);

            if (!$conn) {
                die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
            }
        
            // Thực hiện truy vấn để thêm sách vào cơ sở dữ liệu
            $sql = "INSERT INTO books (title, author, description, image, price) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssd", $title, $author, $description, $image, $price);
        
            if (mysqli_stmt_execute($stmt)) {
                echo "Thêm sách thành công.";
            } else {
                echo "Lỗi khi thêm sách: " . mysqli_error($conn);
            }
        
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        } else {
            // Hiển thị biểu mẫu thêm sách
            echo '<form method="post" action="add_book.php" enctype="multipart/form-data">';
            echo '<label for="title">Tiêu đề:</label>';
            echo '<input type="text" id="title" name="title" required><br><br>';
            echo '<label for="author">Tác giả:</label>';
            echo '<input type="text" id="author" name="author" required><br><br>';
            echo '<label for="description">Mô tả:</label>';
            echo '<textarea id="description" name="description" required></textarea><br><br>';
            echo '<label for="image">Hình ảnh:</label>';
            echo '<input type="file" id="image" name="image" accept="image/*" required><br><br>';
            echo '<label for="price">Giá:</label>';
            echo '<input type="number" id="price" name="price" required><br><br>';
            echo '<input type="submit" value="Thêm sách">';
            echo '</form>';
        }
    } else {
        echo "Bạn phải đăng nhập để thêm sách.";
    }
    ?>

    <p><a href="index.php">Quay lại trang chính</a></p>
</body>
</html>
