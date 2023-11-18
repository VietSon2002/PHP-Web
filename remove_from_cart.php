<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["book_id"])) {
    $bookIdToRemove = $_GET["book_id"];

    if (isset($_SESSION["cart"])) {
        // Tìm vị trí của sách trong giỏ hàng
        $index = array_search($bookIdToRemove, $_SESSION["cart"]);

        if ($index !== false) {
            // Xóa sản phẩm khỏi giỏ hàng
            array_splice($_SESSION["cart"], $index, 1);

            // Hiển thị thông báo hoặc chuyển hướng người dùng đến giỏ hàng
            echo "<p>Sản phẩm đã được xóa khỏi giỏ hàng.</p>";
            echo '<a href="cart.php">Xem giỏ hàng</a>';
        } else {
            echo "<p>Sản phẩm không tồn tại trong giỏ hàng.</p>";
        }
    } else {
        echo "<p>Giỏ hàng của bạn trống.</p>";
    }
} else {
    echo "<p>Yêu cầu không hợp lệ.</p>";
}
?>
<br>
<a href="index.php">Quay lại</a>
