<?php
session_start();
if (isset($_SESSION["NIP"])) {
    header("Location: dashboardPage.php");
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Login Page</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border border-0 rounded-5 p-3 bg-white shadow box-area" style="height: ">
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
                style="background: #0a52c7;">
                <div class="featured-image mb-3">
                    <img src="./image_pg/loginImage.png" class="img-fluid" style="width: 250px;">
                </div>
                <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600">
                    Please Login
                </p>
                <p class="text-white text-wrap text-center fs-6"
                    style="width: 17rem; font-family: 'Courier New', Courier, monospace;">Service your device with us
                    EBi Service Desk</p>
            </div>

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2>Hello, User!</h2>
                        <p>We are happy to service your device.</p>
                    </div>
                    <form action="login.php" method="post">
                        <div class="mb-4">
                            <p class="mb-3">NIP Address</p>
                            <input type="text" class="form-control form-control-lg bg-light fs-6" id="NIPbox"
                                placeholder="Exxxx" name="NIP" type="text" maxlength="5" required>
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Password" name='Password' required>
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe">
                                <label for="rememberMe" class="form-check-label text-secondary"><small>Remember
                                        Me</small></label>
                            </div>
                            <div class="forgot">
                                <small><a href="#">Forgot Password?</a></small>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" class="btn btn-lg btn-success w-100 fs-6">Login</button>
                        </div>
                        <?php
                        if (isset($_GET["isError"])) {
                            echo "<div class='alert alert-danger text-center text-center m-auto' style='padding: 8px 20px;'>
                                      <strong>Error!</strong> Check Your NIP or Password.</div>";
                        } else {
                            echo "<div style='height:41.6px;'></div>";
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="./chart.js"></script>
</body>

</html>