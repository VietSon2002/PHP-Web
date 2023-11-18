<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Kiểm tra xem giỏ hàng có tồn tại trong session không
    if (isset($_SESSION["cart"])) {
        $bookId = $_POST["book_id"];

        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
        if (!in_array($bookId, $_SESSION["cart"])) {
            // Nếu chưa tồn tại, thêm vào giỏ hàng
            $_SESSION["cart"][] = $bookId;
        }
    } else {
        // Nếu giỏ hàng chưa tồn tại, tạo mới và thêm sản phẩm vào
        $bookId = $_POST["book_id"];
        $_SESSION["cart"] = [$bookId];
    }

    // Hiển thị thông báo hoặc chuyển hướng người dùng đến giỏ hàng
    echo "<p>Sản phẩm đã được thêm vào giỏ hàng.</p>";
    echo '<a href="cart.php">Xem giỏ hàng</a>';
}
?>
<br>
<a href="index.php">Quay lại</a>
