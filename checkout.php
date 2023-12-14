<?php
// import koneksi untuk ke databse
include_once('config/index.php');
// import helper function
include_once('helper/index.php');
// memulai session
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// user id
$user_id = $_SESSION['user_id'];

// fetching data cart
$sql = "SELECT carts.id, carts.bakery_id, bakery_img, bakery_name, price, qty, total_price
FROM bakeries
INNER JOIN carts
ON bakeries.id = carts.bakery_id
WHERE carts.user_id = '$user_id' AND carts.is_complete = 0 AND carts.is_deleted = 0";
$res = mysqli_query($conn, $sql);

// menampung id alamat saat ini
$dataAddress;

// fetch semua alamat untuk modal
$qAddress = "SELECT * FROM user_addresses WHERE user_id = '$user_id' AND is_deleted = 0 ORDER BY is_default = 1 DESC ";
$allAddress = mysqli_query($conn, $qAddress);

// validasi alamat yang ditampilkan
if (isset($_GET['address_id'])) {
    $address_id = $_GET['address_id'];
    $s = mysqli_query($conn, "SELECT * FROM user_addresses WHERE id = '$address_id' AND is_deleted = 0 AND user_id = '$user_id' ");
    $dataAddress = mysqli_fetch_assoc($s);
} else {
    // fetching alamat default
    $qAlamat = "SELECT * FROM user_addresses WHERE is_default = 1 AND is_deleted = 0 AND user_id = '$user_id' ";
    $r = mysqli_query($conn, $qAlamat);
    $dataAddress = mysqli_fetch_assoc($r);
}

// menjumlahkan subtotal dan total
// menghitung total harga
$qTotalPrice = "SELECT SUM(total_price) as total FROM carts WHERE is_complete = 0 AND is_deleted = 0 AND user_id = '$user_id' ";
$r = mysqli_query($conn, $qTotalPrice);

$subtotal = mysqli_fetch_assoc($r);
$total_payment = $subtotal['total'] + 12000 + 3000;

// menampung id yang akan di kirim untuk checkout
$cart_id;
$bakery_id;
$qty;

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
                        <h1>Checkout</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- cart -->
    <div class="cart-section mt-150 mb-150">
        <div class="container">
            <!-- alamat pengiriman -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title text-lg fs-5"><i class="fas fa-map-marker-alt me-3"></i> Delivey Address</div>
                            <div class="container">
                                <div class="row">
                                    
                                    <?php
                                    if ($dataAddress !== null) {
                                        echo '
                                                <div class="d-flex flex-column">
                                                    <p class="m-0"><span class="fw-bold">' . $dataAddress['fullname'] . '</span> ' . $dataAddress['phone_number'] . '</p>
                                                    <p>' . $dataAddress['full_address'] . ' , ' . $dataAddress['city'] . ' , ' . $dataAddress['postal_code'] . '</p>
                                                </div>';

                                        if ($allAddress->num_rows > 1) {
                                            echo '
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <button class="btnActiviedAddress" data-bs-toggle="modal" data-bs-target="#modalChangeAddress">Change Address</button>
                                                    </div>';
                                        }
                                    } else {
                                        echo '
                                                <div class="col-md-12">
                                                    <p>Please add your address to continue this order</p>
                                                    <a href="profile.php" class="redirect-link">Add Address</a>
                                                </div>
                                            ';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- akhir alamat pengiriman -->
            <!-- pesanan yang diorder -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title text-lg fs-5">Ordered Bread</div>
                            <div class="container">
                                <div class="row">
                                    <div class="cart-table-wrap">
                                        <table class="cart-table">
                                            <thead class="cart-table-head">
                                                <tr class="table-head-row">
                                                    <th class="product-image">Image</th>
                                                    <th class="product-name">Name</th>
                                                    <th class="product-price">Price</th>
                                                    <th class="product-quantity">Quantity</th>
                                                    <th class="product-tota-price">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($data = mysqli_fetch_assoc($res)) {
                                                    $dataInput[] = $data;
                                                    $cart_id = $data['id'];
                                                    echo '
                                                        <tr class="table-body-row">
                                                            <td class="product-image"><img src="assets/upload/' . $data['bakery_img'] . '" alt=""></td>
                                                            <td class="product-name">' . $data['bakery_name'] . '</td>
                                                            <td class="product-price">' . rupiah($data['price']) . '</td>
                                                            <td class="product-quantity">' . $data['qty'] . '</td>
                                                            <td class="product-subtotal">' . rupiah($data['total_price']) . '</td>
                                                        </tr>
                                                        ';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- akkhir pesanan yang diorder -->
            <!-- info pesanan -->
            <div class="info-orders mt-4 w-100">
                <div class="card-body detail-orders">
                    <h5>Subtotal:</h5>
                    <p><?php echo rupiah($subtotal['total']) ?></p>
                    <h5>Total Shipping:</h5>
                    <p>Rp. 12.000</p>
                    <h5>Service Fee:</h5>
                    <p>Rp. 3000</p>
                    <h5>Total Payment: </h5>
                    <p class="total-payment"><?php echo rupiah($total_payment) ?></p>
                    <div class="button-payment-wrapper">
                        <form action="action/checkout/order.php" method="post" class="w-100">
                            <input type="hidden" name="address_id" value="<?php echo $dataAddress['id'] ?>">
                            <input type="hidden" name="cart_id" value="<?php echo $cart_id ?>">
                            <?php
                            foreach ($dataInput as $d) {
                                echo '
                                <input type="hidden" name="bakery_id[]" value="' . $d['bakery_id'] . '" />
                                <input type="hidden" name="qty[]" value="' . $d['qty'] . '" />
                                <input type="hidden" name="subtotal[]" value="' . $d['price'] . '"/>
                                <input type="hidden" name="total_payment[]" value="' . $total_payment . '" />
                                ';
                            }

                            ?>
                            <?php if ($dataAddress !== null) {
                                echo '<button class="btnPlaceOrder" name="placeOrder">Place order</button>';
                            } ?>
                        </form>
                    </div>
                </div>
            </div>
            <!-- akhirinfo pesanan -->
        </div>
    </div>
    <!-- end cart -->

    <!-- modal ganti alamat -->
    <div class="modal fade" id="modalChangeAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">My Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    while ($address = mysqli_fetch_assoc($allAddress)) {
                        echo '
                            <div class="card border-0 mb-3">
                                <div class="card-title mb-2">
                                    <div class="row">
                                        <div class="col-9">
                                            <p class="fs-6 fw-bold">' . $address['fullname'] . ' | ' . $address['phone_number'] . '</p>
                                        </div>';
                        if ($address['is_default']) {
                            echo '<div class="col-3">
                                            <div class="badge bg-danger">Default</div>
                                        </div>';
                        }
                        echo '</div>
                            </div>
                            <div class="card-body p-0">
                                <p class="mb-2">' . $address['full_address'] . '</p>
                            </div>
                            <div>
                                <a href="checkout.php?address_id=' . $address['id'] . '" class="btnChooseAddress">Choose</a>
                            </div>
                            <hr>
                        </div>
                            ';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- modal ganti alamat -->

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
        function confirmHapus() {
            return confirm('Are you sure?')
        }
    </script>

</body>

</html>