<?php
include_once('../config/index.php');
// memulai session
session_start();

include('../helper/index.php');
// validasi user jika tidak mempunyai session
if (!isset($_SESSION['user_id_admin'])) {
    header('Location: login.php');
    exit();
}

$qTableLaporan = "SELECT o.created_at, o.no_order, d.total_price 
FROM orders o
JOIN order_detail d ON o.id = d.order_id
WHERE o.status_order = 'done'
GROUP BY o.id, o.no_order
ORDER BY o.created_at DESC ";

$result = mysqli_query($conn, $qTableLaporan);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tag -->
    <?php include('partials/meta.php') ?>

    <title>Roti - My Bakery</title>

    <!-- styling -->
    <link href="../assets/template/css/datatable-style.css" rel="stylesheet" />
    <link href="../assets/template/css/styles.css" rel="stylesheet" />
    <link href="../assets/template/css/custom.css" rel="stylesheet" />
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
                    <h1 class="mt-4">Laporan Penjualan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Penjualan</li>
                    </ol>
                    <?php
                    if ($_SESSION['flash_msg']) {
                        echo '<div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                               <strong>' . $_SESSION['flash_msg'] . '</strong>
                               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                             </div>';

                        $_SESSION['flash_msg'] = '';
                    }
                    ?>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalExportLaporan"><i class="fas fa-file-export"></i> Export Laporan</button>
                    <div class="card my-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Penjualan
                        </div>
                        <div class="card-body">
                            <table id="tableLaporan">
                                <thead>
                                    <tr>
                                        <th>No order</th>
                                        <th>Tanngal order</th>
                                        <th>Total order</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $orderDate = date("d F Y", strtotime($row['created_at']));
                                        echo "<tr>";
                                        echo "<td>" . $row['no_order'] . "</td>";
                                        echo "<td>" . $orderDate . "</td>";
                                        echo "<td>" . rupiah($row['total_price']) . "</td>";
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

    <?php include('partials/modal/ExportLapoaran.php') ?>

    <script src="../assets/template/js/bootstrap-bundle.min.js"></script>
    <script src="../assets/template/js/scripts.js"></script>
    <!-- <script src="../assets/template/js/jquery-3.7.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

    <script>
        // inisialisasi table
        window.addEventListener('DOMContentLoaded', e => {
            const dataTable = document.getElementById('tableLaporan');
            if (dataTable) {
                new simpleDatatables.DataTable(dataTable);
            }
        })

        const filterReports = document.querySelectorAll('input[name="filterReport"]');
        const filterContainer = document.querySelector('.filter-container')
        const dateFrom = document.querySelector('.date-from')
        const dateToContainer = document.querySelector('.date-to-container')
        const monthContainer = document.querySelector('.month-container')
        const filterType = document.querySelector('input[name="filterType"]')


        filterReports.forEach(function(filterReport) {
            filterReport.addEventListener("change", function() {
                filterContainer.classList.remove('d-none')
                dateFrom.classList.toggle('d-none', this.value === "month")
                dateToContainer.classList.toggle('d-none', this.value === 'day' || this.value === 'month');
                monthContainer.classList.toggle('d-none', this.value === "day" || this.value === "week")

                filterType.value = this.value
            })
        })

        const modalExport = document.querySelector('#modalExportLaporan')
        const formFilter = document.querySelector("#form-filter-report")

        modalExport.addEventListener('hidden.bs.modal', function() {
            filterContainer.classList.add('d-none')
            formFilter.reset()

            filterReports.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkbox.checked = false;
                }
            });
        })
    </script>
</body>

</html>