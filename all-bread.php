<?php
session_start();
// import koneksi untuk ke databse
include_once('config/index.php');
// import helper function
include_once('helper/index.php');

$category = "";
if (isset($_GET['category'])) {
    $category = $_GET['category'];
}

// jumlah per halaman
$items_per_page = 5;

// mendapatkan jumlah total data dari databse
$total_item_query = "SELECT COUNT(*) AS total
                    FROM bakeries b
                    JOIN bakery_category c ON c.id = b.category_id
                    WHERE b.is_deleted = 0";

if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $total_item_query .= " AND c.slug = '$category'";
}
$total_item_result = mysqli_query($conn, $total_item_query);
$total_items = mysqli_fetch_assoc($total_item_result)['total'];

// mennghitung jumlah halaman
$total_pages = ceil($total_items / $items_per_page);
// mendapatkan halaman saat ini
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// menghitung offset
$offset = ($current_page - 1) * $items_per_page;

// data dengan batas halaman
$sql = "SELECT b.id AS bakery_id, b.bakery_name, b.bakery_img, b.stock, b.description, b.price, c.slug
        FROM bakeries b
        JOIN bakery_category c ON c.id = b.category_id
        WHERE b.is_deleted = 0";

if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $sql .= " AND c.slug = '$category'";
}

$sql .= " ORDER BY b.created_at DESC LIMIT $offset, $items_per_page";

$result = mysqli_query($conn, $sql);
$dataProduct = array();

while ($data = mysqli_fetch_assoc($result)) {
    $dataProduct[] = $data;
}

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


    <!-- products -->
    <div class="product-section mt-150 mb-150">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center">
                        <h3><span class="orange-text">Our</span> Products</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="product-filters">
                        <ul>
                            <li><a class="text-dark" href="all-bread.php">All</a></li>
                            <?php
                            $qCategry = "SELECT category_name, slug FROM bakery_category WHERE is_deleted = 0 ORDER BY created_at DESC";
                            $categories = mysqli_query($conn, $qCategry);

                            while ($data = mysqli_fetch_assoc($categories)) {
                                echo '
                                <li class="' . ($data['slug'] === $category ? 'active' : '') . '">
                                    <a class="text-dark " href="all-bread.php?category=' . $data['slug'] . '">
                                    ' . $data['category_name'] . '
                                    </a>
                                </li>
                            ';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row product-lists">

                <?php
                $row_count = mysqli_num_rows($result);

                if ($row_count > 0) {
                    foreach ($dataProduct as $data) {
                        echo '
                            <div class="col-lg-4 col-md-6 text-center">
                                <div class="single-product-item">
                                    <div class="product-image">
                                        <a href="bread.php?id=' . $data['bakery_id'] . '"><img src="assets/upload/' . $data['bakery_img'] . '" alt="product thumbnail"></a>
                                    </div>
                                    <div class="' . ($data['stock'] == 0 ? 'out-of-stock' : '') . '"></div>
                                    <h3>' . $data['bakery_name'] . '</h3>
                                    <p>' . $data['description'] . '</p>
                                    <p class="product-price">' . rupiah($data['price']) . '</p>
                                </div>
                            </div>
                            ';
                    }
                } else {
                    echo '
                    <div class="text-center">
                        <h4>Tidak ada Roti yang tersedia</h4>
                    </div>
                    ';
                }
                ?>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="pagination-wrap">
                        <ul>
                            <?php
                            for ($page = 1; $page <= $total_pages; $page++) {
                                if ($category !== "") {
                                    echo '<li><a ' . ($page == $current_page ? 'class="active text-white"' : '') . ' href="category?=' . $category . '?page=' . $page . '">' . $page . '</a></li>';
                                } else {
                                    echo '<li><a ' . ($page == $current_page ? 'class="active text-white"' : '') . ' href="?page=' . $page . '">' . $page . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end products -->

    <!-- footer -->
    <?php include('partials/footer.php') ?>
    <!-- end footer -->


    <!-- jquery -->
    <script src="assets/template/js/jquery-3.7.min.js"></script>
    <!-- bootstrap -->
    <script src="assets/template/js/bootstrap-bundle.min.js"></script>
    <!-- isotope -->
    <script src="assets/user/js/jquery.isotope-3.0.6.min.js"></script>
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


</body>

</html>