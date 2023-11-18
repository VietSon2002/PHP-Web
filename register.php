<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Add your custom CSS file if needed -->
</head>

<body>

  <section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

              <h3 class="mb-5">Đăng ký</h3>

              <?php
              // Kiểm tra nếu có thông báo lỗi từ trang trước
              if (isset($_GET["error"])) {
                echo "<p style='color: red;'>" . $_GET["error"] . "</p>";
              }
              ?>

              <!-- Thêm form để bao quanh các trường nhập và nút đăng ký -->
              <form method="post" action="register_process.php">
                <div class="form-outline mb-4"> 
                    <label class="form-label" for="username">Tên đăng nhập</label>
                    <input type="text" id="username" class="form-control form-control-lg" name="username" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" class="form-control form-control-lg" name="email" required />
                  
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="password">Mật khẩu</label>
                    <input type="password" id="password" class="form-control form-control-lg" name="password" required />
                  
                </div>

                <!-- Nút đăng ký -->
                <button class="btn btn-primary btn-lg btn-block" type="submit">Đăng ký</button>
              </form>

              <hr class="my-4">

              <!-- Liên kết đăng nhập -->
              <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Add your script tags or include JS files if needed -->

</body>

</html>
