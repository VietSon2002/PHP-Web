<?php
session_start();

// Kiểm tra xem giỏ hàng có tồn tại trong session không
if (isset($_SESSION["cart"])) {
    $cartItems = $_SESSION["cart"];

    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "bookstore";

    $conn = mysqli_connect($servername, $db_username, $db_password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Tính tổng giá trị
    $totalPrice = 0;
    foreach ($cartItems as $bookId) {
        $sql = "SELECT * FROM books WHERE id = $bookId";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $totalPrice += $row['price'];
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Giỏ hàng</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous">
            <link rel="stylesheet" type="text/css" href="stylecart.css">
        <style>
            /* Thêm đoạn CSS để định dạng */
            .form-outline .form-label {
                width: auto; /* Đặt chiều rộng cho nhãn */
                margin-right: 10px; /* Khoảng cách giữa nhãn và trường nhập */
                white-space: nowrap; /* Ngăn chặn quá trình ngắt dòng */
            }

            /* Điều chỉnh độ rộng của input */
            .form-outline .form-control {
                flex: 1; /* Sử dụng phần còn lại của không gian */
            }
        </style>
    </head>

    <body>

        <section class="h-100 h-custom" style="background-color: #d2c9ff;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12">
                        <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    <div class="col-lg-8">
                                        <div class="p-5">
                                            <div class="d-flex justify-content-between align-items-center mb-5">
                                                <h1 class="fw-bold mb-0 text-black">Giỏ hàng</h1>
                                            </div>
                                            <hr class="my-4">
                                            <?php
                                            foreach ($cartItems as $bookId) {
                                                $sql = "SELECT * FROM books WHERE id = $bookId";
                                                $result = mysqli_query($conn, $sql);

                                                if (mysqli_num_rows($result) > 0) {
                                                    $row = mysqli_fetch_assoc($result);
                                                    ?>
                                                    <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                        <div class="col-md-2 col-lg-2 col-xl-2">
                                                            <img src="uploads/<?php echo $row['image']; ?>"
                                                                class="img-fluid rounded-3" alt="<?php echo $row['title']; ?>">
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                                            <h6 class="text-black mb-0"><?php echo $row['title']; ?></h6>
                                                            <p>Tác giả: <?php echo $row['author']; ?></p>
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                            <button class="btn btn-link px-2"
                                                                onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input name="quantity" data-book-id="<?php echo $row['id']; ?>"
                                                                id="form1" min="0" value="1"
                                                                type="number" class="form-control form-control-sm" />
                                                            <button class="btn btn-link px-2"
                                                                onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                                            <h6 class="mb-0"><?php echo $row['price'] . ' VND'; ?></h6>
                                                        </div>
                                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                            <a href="remove_from_cart.php?book_id=<?php echo $row['id']; ?>" class="text-muted">X<i class="fas fa-times"></i></a>
                                                        </div>

                                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                            <a href="#!" class="text-muted"><i
                                                                    class="fas fa-times"></i></a>
                                                        </div>
                                                    </div>
                                                    <hr class="my-4">
                                                <?php
                                                } else {
                                                    echo "Không tìm thấy thông tin sách.";
                                                }
                                            }
                                            ?>
                                            <!-- Hiển thị tổng giá trị -->
                                            <div class="row mb-4">
                                                <div class="col-lg-8">
                                                </div>
                                            </div>
                                            <a href="index.php" class="btn btn-primary">Quay lại trang chủ</a>
                                            <a href="#" class="btn btn-primary">Thanh toán</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 bg-grey">
                                        <div class="p-5">
                                            <h3 class="fw-bold mb-5 mt-2 pt-1">Tóm lược</h3>
                                            <hr class="my-4">
                                            <div class="d-flex justify-content-between mb-4">
                                            <h6 class="text-uppercase">Số lượng: <?php echo  $cartItemCount = count($cartItems); ?></h6>
                                            <h6 class="fw-bold mb-0 text-black"> <?php echo $totalPrice . '.000 VND'; ?></h6>
                                        </div>
                                        <button type="button" class="btn btn-dark btn-block btn-lg" data-mdb-ripple-color="dark">Register</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </body>

    </html>
    <?php
    mysqli_close($conn);
} else {
    echo "Giỏ hàng trống.";
}
?>
