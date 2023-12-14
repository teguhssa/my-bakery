<?php
// import koneksi untuk ke databse
include_once('config/index.php');
// import helper function
include_once('helper/index.php');
// memulai session
session_start();
// mengambil session user
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
// megambil user id
$user_id = $_SESSION['user_id'];

// fetching data cart
$sql = "SELECT carts.id, carts.bakery_id, bakery_img, bakery_name, price, qty, total_price
FROM bakeries
INNER JOIN carts
ON bakeries.id = carts.bakery_id
WHERE carts.user_id = '$user_id' AND carts.is_complete = 0 AND carts.is_deleted = 0";

$res = mysqli_query($conn, $sql);

// menghitung total harga
$qTotalPrice = "SELECT SUM(total_price) as total FROM carts WHERE is_complete = 0 AND is_deleted = 0 AND user_id = '$user_id' ";
$r = mysqli_query($conn, $qTotalPrice);

$total_price = mysqli_fetch_assoc($r);


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
    <!-- owl carousel -->
    <link rel="stylesheet" href="assets/user/css/owl.carousel.css">
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

    <!-- cart -->
    <div class="cart-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="cart-table-wrap">
                        <table class="cart-table">
                            <thead class="cart-table-head">
                                <tr class="table-head-row">
                                    <th class="product-remove"></th>
                                    <th class="product-image">Product Image</th>
                                    <th class="product-name">Name</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-total">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($data = mysqli_fetch_assoc($res)) {
                                    echo '
                                            <tr class="table-body-row">
                                                <td class="product-remove">
                                                    <form action="action/cart/delete.php" method="post">
                                                        <input type="hidden" value="' . $data['id'] . '"  name="id">
                                                        <button class="border-0 bg-body" name="btnRemoveCart" id="btnRemoveCart" onclick="return confirmHapus()"><i class="far fa-window-close"></i></button>
                                                    </form>
                                                </td>
                                                <td class="product-image"><img src="assets/upload/' . $data['bakery_img'] . '" alt=""></td>
                                                <td class="product-name">' . $data['bakery_name'] . '</td>
                                                <td class="product-price">' . rupiah($data['price']) . '</td>
                                                <td class="cart-product-quantity">
                                                    <form action="action/cart/update-qty.php" method="post">
                                                        <input type="hidden" name="bakery_id" value='.$data['bakery_id'].'>
                                                        <input type="hidden" name="price" id="price" value='.$data['price'].'>
                                                        <input type="hidden" name="qty" id="qty" value='.$data['qty'].'>
                                                        <input type="hidden" name="total_price" id="total_price" value='.$data['total_price'].'>
                                                        <button class="cart-qty-btn" id="cart-plus" name="btnMinQtyCart">-</button>
                                                    </form>
                                                    <input type="number" value=' . $data['qty'] . ' disabled>
                                                    <form action="action/cart/update-qty.php" method="post">
                                                        <input type="hidden" name="bakery_id" value='.$data['bakery_id'].'>
                                                        <input type="hidden" name="price" id="price" value='.$data['price'].'>
                                                        <button class="cart-qty-btn" id="cart-plus" name="btnAddQtyCart">+</button>
                                                    </form>
                                                </td>
                                                <td class="product-total">' . rupiah($data['total_price']) . '</td>
                                            </tr>
                                        ';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="total-section">
                        <table class="total-table">
                            <thead class="total-table-head">
                                <tr class="table-total-row">
                                    <th>Total</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="total-data">
                                    <td><strong>Total: </strong></td>
                                    <td><?php echo rupiah($total_price['total'])  ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="cart-buttons">
                            <?php
                                if($res->num_rows > 0) {
                                    echo '<a href="checkout.php" class="boxed-btn black">Check Out</a>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end cart -->

    <!-- footer -->
    <?php include('partials/footer.php') ?>
    <!-- end footer -->


    <!-- jquery -->
    <!-- <script src="assets/user/js/jquery-1.11.3.min.js"></script> -->
    <script src="assets/template/js/jquery-3.7.min.js"></script>
    <!-- bootstrap -->
    <script src="assets/template/js/bootstrap-bundle.min.js"></script>
    <!-- waypoints -->
    <!-- <script src="assets/user/js/waypoints.js"></script> -->
    <!-- magnific popup -->
    <script src="assets/user/js/jquery.magnific-popup.min.js"></script>
    <!-- mean menu -->
    <script src="assets/user/js/jquery.meanmenu.min.js"></script>
    <!-- sticker js -->
    <script src="assets/user/js/sticker.js"></script>
    <!-- main js -->
    <script src="assets/user/js/main.js"></script>

    <script>
        function confirmHapus () {
            return confirm('Are you sure?')
        }
    </script>

</body>

</html>