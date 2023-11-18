<!DOCTYPE html>
<html>
<head>
    <title>Kết quả tìm kiếm</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h1>Kết quả tìm kiếm</h1>
    
    <?php
    // Kiểm tra đăng nhập (nếu cần)
    session_start();
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
        // Nếu đã đăng nhập, hiển thị thông tin người dùng và nút đăng xuất
        echo "<p>Xin chào, " . $_SESSION["username"] . "!</p>";
        echo '<a href="logout.php">Đăng xuất</a>';
    } else {
        // Nếu chưa đăng nhập, hiển thị nút đăng nhập và đăng ký
        echo '<a href="login.php">Đăng nhập</a>';
        echo '<p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>';
    }
    ?>
    
    <?php
    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "bookstore";

    $conn = mysqli_connect($servername, $db_username, $db_password, $database);

    if (!$conn) {
        die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
    }

    // Xử lý tìm kiếm sách
    if (isset($_GET["query"])) {
        $keyword = $_GET["query"];
        $sql = "SELECT * FROM books WHERE title LIKE '%$keyword%' OR author LIKE '%$keyword%'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '<div class="books">';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="book">';
                echo '<img src="uploads/' . $row["image"] . '" alt="' . $row["title"] . '">';
                echo '<h3>' . $row["title"] . '</h3>';
                echo '<p>Tác giả: ' . $row["author"] . '</p>';
                echo '<p>' . $row["description"] . '</p>';
                echo '<p>Giá tiền: ' .$row["price"] .' VND'. '</p>';
                echo '<a href="purchase.php?id=' . $row["id"] . '">Mua sách</a>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo "Không có kết quả tìm kiếm nào.";
        }
    } else {
        echo "Vui lòng nhập từ khóa tìm kiếm.";
    }

    mysqli_close($conn);
    ?>
</body>
</html>
