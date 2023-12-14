<?php
// memulai session
session_start();
// validasi jika user mempunyai session
if (isset($_SESSION['user_id_admin'])) {
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tag -->
    <?php include('partials/meta.php') ?>

    <title>Login Admin</title>

    <!-- styling -->
    <link href="../assets/template/css/styles.css" rel="stylesheet" />
    <link href="../assets/template/js/font-awesome.js" rel="stylesheet" />
</head>

<body style="background: #f2f2f2;">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center align-items-center vh-100">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg">
                                <div class="d-flex flex-column align-items-center my-4">
                                    <h3 class="text-center font-weight-bold my-2">HI!, Welcome back 👋</h3>
                                    <p>Please insert your credential</p>
                                </div>

                                <div class="card-body">
                                    <?php
                                    if (isset($_SESSION['flash_msg_error']) && !empty($_SESSION['flash_msg_error'])) {
                                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>' . $_SESSION['flash_msg_error'] . '</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';

                                        $_SESSION['flash_msg_error'] = '';
                                    }
                                    ?>

                                    <form action="action/auth.php" method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="username" type="text" placeholder="Username here.." name="username" required />
                                            <label for="username">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="password" required />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="d-flex mt-4 mb-4">
                                            <button class="btn btn-primary w-100" name="btnLogin">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="../assets/template/js/bootstrap-bundle.min.js"></script>
    <script src="../assets/template/js/scripts.js"></script>
</body>

</html>