<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" type="text/css" href="stylee.css">
</head>

<body>

    <div class="navbar">
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>
        <div class="nav-links">
            <a href="#">Trang chủ</a>
            <a href="#">Sách</a>
            <a href="#">Liên hệ</a>
        </div>
        <div class="auth">
            <?php
            // Kiểm tra đăng nhập
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
        </div>
        <?php
            // Đếm số sản phẩm trong giỏ hàng
            $cartItemCount = isset($_SESSION["cart"]) ? count($_SESSION["cart"]) : 0;
        ?>
        <div class="cart-button">
            <a href="cart.php">Giỏ hàng (<?php echo $cartItemCount; ?>)</a>
        </div>
    </div>

    <h2>Danh sách sách</h2>
    <form method="GET" action="search.php">
        <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm">
        <input type="submit" value="Tìm kiếm">
    </form>
    
    <?php
        // Kiểm tra xem người dùng có quyền admin hay không
        if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] === true) {
            echo '<a href="add_book.php">Thêm sách</a><br>';
        }
    ?>

    <div class="books">
        <?php
        // Kết nối đến cơ sở dữ liệu và hiển thị danh sách sách
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $database = "bookstore";

        $conn = mysqli_connect($servername, $db_username, $db_password, $database);

        if (!$conn) {
            die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM books";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="book">';
                echo '<img src="uploads/' . $row["image"] . '" alt="' . $row["title"] . '">';
                echo '<h3 class="title">' . $row["title"] . '</h3>';
                echo '<p>Tác giả: ' . $row["author"] . '</p>';
                echo '<p class="description">' . $row["description"] . '</p>';
                echo '<p>Giá tiền: ' .$row["price"] .' VND'. '</p>';
                echo '<form method="POST" action="add_to_cart.php">';
                echo '<input type="hidden" name="book_id" value="' . $row["id"] . '">';
                echo '<input type="submit" value="Thêm vào giỏ hàng"><br>';
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] === true) {
                        echo '<a href="edit_book.php?book_id=' . $row["id"] . '">Chỉnh sửa</a>';
                        echo '<a href="delete_book.php?book_id=' . $row["id"] . '">Xóa sách</a>';
                }
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo "Không có sách nào.";
        }

        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
