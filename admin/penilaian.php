<?php
include_once('../config/index.php');
// memulai session
session_start();
// validasi user jika tidak mempunyai session
if (!isset($_SESSION['user_id_admin'])) {
    header('Location: login.php');
    exit();
}

$qReviews = "SELECT users.name, users.username, bakeries.bakery_img, bakeries.bakery_name, reviews.rating, reviews.review_description
FROM bakeries
JOIN reviews ON bakeries.id = reviews.bakery_id
JOIN users ON reviews.user_id = users.id
ORDER BY reviews.created_at DESC
";

$res = mysqli_query($conn, $qReviews);

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
                    <?php
                    if ($_SESSION['flash_msg']) {
                        echo '<div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                               <strong>' . $_SESSION['flash_msg'] . '</strong>
                               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                             </div>';

                        $_SESSION['flash_msg'] = '';
                    }
                    ?>
                    <h1 class="mt-4">Penilaian</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Penilaian</li>
                    </ol>
                    <div class="card my-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Penilaian order
                        </div>
                        <div class="card-body">
                            <table id="tablePenilaian">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Gambar Roti</th>
                                        <th>Nama Roti</th>
                                        <th>Rating</th>
                                        <th>Deskripsi penilaian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            echo "<tr>";
                                            echo "<td>".$row['name']."</td>";
                                            echo "<td>".$row['username']."</td>";
                                            echo "<td><img src='../assets/upload/".$row['bakery_img']."' width='50' /></td>";
                                            echo "<td>".$row['bakery_name']."</td>";
                                            echo "<td> <i class='fas fa-star text-warning me-2'></i>".$row['rating']."</td>";
                                            echo "<td>".$row['review_description']."</td>";
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
    <!-- <script src="../assets/template/js/jquery-3.7.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

    <script>
        // inisialisasi table
        window.addEventListener('DOMContentLoaded', e => {
            const dataTable = document.getElementById('tablePenilaian');
            if (dataTable) {
                new simpleDatatables.DataTable(dataTable);
            }
        })
    </script>
</body>

</html>