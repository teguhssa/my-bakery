<?php
// memasukan koneksi
include_once('../config/index.php');
// helper function
include('../helper/index.php');
// memulai session
session_start();
// validasi user jika tidak mempunyai session
if (!isset($_SESSION['user_id_admin'])) {
    header('Location: login.php');
    exit();
}

// menghitung semua pesanan
$qSemuuaPesanan = mysqli_query($conn, "SELECT * FROM orders");
$semuaPesanan = $qSemuuaPesanan->num_rows;

// menghitung pesanan yang selesai
$qPesananSelesai = mysqli_query($conn, "SELECT * FROM orders WHERE status_order = 'done' ");
$pesananSelesai = $qPesananSelesai->num_rows;

// menghitung pendapatan semua waktu
$qRevenue = mysqli_query($conn, "SELECT SUM(subtotal) AS revenue FROM order_detail;");
$revenue = mysqli_fetch_assoc($qRevenue);

// menghitung pendapatan bulan ini
$qRevenue = "SELECT SUM(subtotal) AS revenue_this_month
FROM order_detail
WHERE MONTH(created_at) = MONTH(CURRENT_DATE())
AND YEAR(created_at) = YEAR(CURRENT_DATE());";
$res = mysqli_query($conn, $qRevenue);
$revenueBulanIni = mysqli_fetch_assoc($res);

// menghitung jumlah data roti
$qJumlahRoti = mysqli_query($conn, "SELECT * FROM bakeries WHERE is_deleted = '0' ");
$jumlahRoti = $qJumlahRoti->num_rows;

// mendapatkan pesanan aktif
$qPesananAktif = "SELECT orders.no_order, orders.created_at AS order_time, users.username, orders.status_order
FROM orders
JOIN users ON orders.user_id = users.id
WHERE orders.status_order <> 'done' ORDER BY order_time DESC";
$r = mysqli_query($conn, $qPesananAktif);

$qAvarageReviews = "SELECT * FROM reviews ORDER BY created_at DESC";
$dataRating = mysqli_query($conn, $qAvarageReviews);
$avgRating = 0;
$totalReview = 0;
$totalRating = 0;

foreach($dataRating as $rating) {
    $totalReview++;
    $totalRating = $totalRating + $rating['rating'];
    $avgRating = $totalRating / $totalReview;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tag -->
    <?php include('partials/meta.php') ?>

    <title>Dashboard - My Bakery</title>

    <!-- styling -->
    <link href="../assets/template/css/datatable-style.css" rel="stylesheet" />
    <link href="../assets/template/css/styles.css" rel="stylesheet" />
    <!-- <link href="../assets/template/js/font-awesome.js" rel="stylesheet" /> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <!-- header -->
    <?php include('partials/header.php') ?>

    <div id="layoutSidenav">

        <!-- sidebar -->
        <?php include('partials/sidebar.php') ?>


        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <?php
                    if ($_SESSION['flash_msg']) {
                        echo '<div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                               Hi!, Welcome back <strong>' . $_SESSION['flash_msg'] . '</strong>
                               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                             </div>';

                        $_SESSION['flash_msg'] = '';
                    }
                    ?>
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex flex-column">
                                        <h5>Jumlah Pesanan</h5>
                                        <div class="d-flex align-items-center justify-content-between fs-4 mb-2">
                                            <i class="fas fa-shopping-cart"></i>
                                            <p class="mb-0 fw-bold"><?php echo $semuaPesanan ?></p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <p class="mb-0">Pesanan yang selesai</p>
                                            <p class="mb-0 fw-bold"><?php echo $pesananSelesai ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex flex-column">
                                        <h5>Jumlah Pendapatan</h5>
                                        <div class="d-flex align-items-center justify-content-between fs-4 mb-2">
                                            <i class="fas fa-money-bill-wave-alt"></i>
                                            <p class="mb-0 fw-bold"><?php echo rupiah($revenue['revenue'])  ?></p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <p class="mb-0">Pendapatan bulan ini</p>
                                            <p class="mb-0 fw-bold"><?php echo rupiah($revenueBulanIni['revenue_this_month']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex flex-column">
                                        <h5>Jumlah Roti</h5>
                                        <div class="d-flex align-items-center justify-content-between fs-4 mb-2">
                                            <i class="fas fa-bread-slice"></i>
                                            <p class="mb-0 fw-bold"><?php echo $jumlahRoti ?></p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="roti.php">Kelola</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex flex-column">
                                        <h5>Jumlah user aktif</h5>
                                        <div class="d-flex align-items-center justify-content-between fs-4 mb-2">
                                            <i class="fas fa-user"></i>
                                            <p class="mb-0 fw-bold">10</p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="user.php">Kelola</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex flex-column">
                                        <h5>Rata-rata reviews</h5>
                                        <div class="d-flex align-items-center justify-content-between fs-4 mb-2">
                                            <i class="fas fa-star"></i>
                                            <p class="mb-0 fw-bold"><?php echo number_format($avgRating, 1)?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Pesanan aktif
                        </div>
                        <div class="card-body">
                            <table id="tabelPesananAktif">
                                <thead>
                                    <tr>
                                        <th>No. Order</th>
                                        <th>Waktu Order</th>
                                        <th>Username</th>
                                        <th>Status Order</th>
                                        <th>Kelola</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        while($row = mysqli_fetch_assoc($r)) {
                                            echo "<tr>";
                                            echo "<td>".$row['no_order']."</td>";
                                            echo "<td>".$row['order_time']."</td>";
                                            echo "<td>".$row['username']."</td>";
                                            echo "<td><div class='badge bg-success'>".$row['status_order']."</div></td>";
                                            echo "<td><a href='pesanan.php'>Kelola</a></td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <!-- footer -->
            <?php include('partials/footer.php') ?>
        </div>
    </div>

    <script src="../assets/template/js/bootstrap-bundle.min.js"></script>
    <script src="../assets/template/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

    <script>
          // inisialisasi table
          window.addEventListener('DOMContentLoaded', e => {
            const dataTable = document.getElementById('tabelPesananAktif');
            if (dataTable) {
                new simpleDatatables.DataTable(dataTable);
            }
        })
    </script>
</body>

</html>