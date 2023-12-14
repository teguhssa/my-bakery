<?php
// cek session
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tag -->
    <?php include('partials/meta.php') ?>
    <title>My Bakery - Registration</title>
    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="assets/user/img/favicon.png">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- main style -->
    <link rel="stylesheet" href="assets/user/css/main.css">
    <!-- animate css -->
	<link rel="stylesheet" href="assets/user/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="assets/user/css/meanmenu.min.css">
    <!-- magnific popup -->
	<link rel="stylesheet" href="assets/user/css/magnific-popup.css">
    <!-- responsive -->
    <link rel="stylesheet" href="assets/user/css/responsive.css">
</head>

<body>

    <!--PreLoader-->
    <?php include('partials/loader.php') ?>
    <!--PreLoader Ends-->

    <div class="login-page d-flex">
        <div class="content-right">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-6 col-sm-8">
                    <div class="header-form">
                        <h1>Create an <span>account!</span></h1>
                        <p>Please insert your credentials</p>
                    </div>
                    <div class="form-auth">
                        <form action="action/auth/register.php" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="username" name="username" id="username" class="form-control" placeholder="Your username here..." required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Your Email here..." required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Your password here..." required>
                            </div>
                            <p>Already have account? <a href="login.php">come here!</a></p>
                            <button class="btnAuth" name="btnRegis">Create account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-left">
            <img src="assets/user/img/login-page/bg-login-page.jpg" alt="login-bg">
        </div>
    </div>

   <!-- bootstrap -->
   <script src="assets/template/js/bootstrap-bundle.min.js"></script>
    <!-- jqury -->
    <script src="assets/template/js/jquery-3.7.min.js"></script>
    <!-- magnific popup -->
	<script src="assets/user/js/jquery.magnific-popup.min.js"></script>
    <!-- mean menu -->
	<script src="assets/user/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="assets/user/js/sticker.js"></script>
    <!-- main js -->
    <script src="assets/user/js/main.js"></script>
</body>

</html>