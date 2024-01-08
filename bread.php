<?php
// import koneksi untuk ke databse
include_once('config/index.php');
// import helper function
include_once('helper/index.php');
// memulai session
session_start();
// mendapatkan id dari roti yang dipilih
$bakery_id = $_GET['id'];
// fetching data dari database
$sql = "SELECT * FROM bakeries WHERE id = '$bakery_id' AND is_deleted = 0 ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tag -->
    <?php include('partials/meta.php') ?>

    <!-- title -->
    <title>My Bakery</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="assets/user/img/favicon.png">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="assets/user/css/all.min.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- magnific popup -->
    <link rel="stylesheet" href="assets/user/css/magnific-popup.css">
    <!-- animate css -->
    <link rel="stylesheet" href="assets/user/css/animate.css">
    <!-- mean menu css -->
    <link rel="stylesheet" href="assets/user/css/meanmenu.min.css">
    <!-- main style -->
    <link rel="stylesheet" href="assets/user/css/main.css">
    <!-- responsive -->
    <link rel="stylesheet" href="assets/user/css/responsive.css">

</head>

<body>

    <!--PreLoader-->
    <?php include('partials/loader.php') ?>
    <!--PreLoader Ends-->

    <!-- header -->
    <?php include('partials/navbar.php') ?>
    <!-- header end -->

    <!-- search area -->
    <?php include('partials/searchArea.php') ?>
    <!-- end search area -->

    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Fresh and Flacky</p>
                        <h1>Our Bread</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- single product -->
    <div class="single-product mt-150 mb-150">
        <div class="container">
            <div class="link-back">
                <a href="index.php">Home</a> /
                <a href="all-bread.php">All Bread</a>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="single-product-img">
                        <img src="assets/upload/<?php echo $data['bakery_img'] ?>" alt="single bread">
                    </div>
                </div>
                <div class="col-md-7 d-flex align-items-center justify-items-center">
                    <div class="single-product-content">
                        <h3><?php echo $data['bakery_name'] ?></h3>
                        <p class="single-product-pricing"><?php echo rupiah($data['price']) ?></p>
                        <p class="mb-0">Sisa Stock : <?php echo '<span class="fw-bold">'.$data['stock'].'</span>' ?></p>
                        <p><?php echo $data['description'] ?></p>
                        <div class="single-product-form">
                            <form action="action/cart/add.php" method="post">
                                <div class="qty-control">
                                    <button class="btn-qty" id="btnMin" type="button">-</button>
                                    <input type="number" placeholder="1" min="1" oninput="this.value = Math.abs(this.value)" value="1" name="qty" id="qty">
                                    <button class="btn-qty" id="btnPlus" type="button">+</button>
                                    <input type="hidden" name="bakery_id" id="bakery_id" value="<?php echo $bakery_id ?>">
                                    <input type="hidden" name="price" id="price" value="<?php echo $data['price'] ?>">
                                </div>
                                <button class="cart-btn" name="addCart"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end single product -->

    <!-- footer -->
    <?php include('partials/footer.php') ?>
    <!-- end footer -->


    <!-- jquery -->
    <script src="assets/user/js/jquery-1.11.3.min.js"></script>
    <!-- bootstrap -->
    <script src="assets/template/js/bootstrap-bundle.min.js"></script>
    <!-- waypoints -->
    <script src="assets/user/js/waypoints.js"></script>
    <!-- magnific popup -->
    <script src="assets/user/js/jquery.magnific-popup.min.js"></script>
    <!-- mean menu -->
    <script src="assets/user/js/jquery.meanmenu.min.js"></script>
    <!-- sticker js -->
    <script src="assets/user/js/sticker.js"></script>
    <!-- main js -->
    <script src="assets/user/js/main.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const btnPlus = document.querySelector("#btnPlus")
            const btnMinus = document.querySelector("#btnMin")
            let qty = document.querySelector("#qty")


            btnPlus.addEventListener("click", function() {
                let parsedQty = parseInt(qty.value);
                qty.value = parsedQty + 1
            })

            btnMinus.addEventListener("click", function() {
                let parsedQty = parseInt(qty.value);
                let result = qty.value = parsedQty - 1

                if (result <= 1) {
                    qty.value = 1
                }
            })
        })
    </script>

</body>

</html>