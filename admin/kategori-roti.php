<?php
include_once('../config/index.php');
// memulai session
session_start();
// validasi user jika tidak mempunyai session
if (!isset($_SESSION['user_id_admin'])) {
    header('Location: login.php');
    exit();
}

$qCategory = "SELECT * FROM bakery_category WHERE is_deleted = 0 ORDER BY created_at DESC";
$result = mysqli_query($conn, $qCategory);

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
                    <h1 class="mt-4">Kategori roti</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Kategori roti</li>
                    </ol>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddKategori"><i class="fas fa-plus" style="color: #ffffff;"></i> Tambah Kategori</button>
                    <div class="card my-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Kategori Roti
                        </div>
                        <div class="card-body">
                            <table id="categoryTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($data = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo '<td>' . $no++ . '</td>';
                                        echo '<td>' . $data['category_name'] . '</td>';
                                        echo "<td> <button class='btn btnEditCategory' value=" . $data['id'] . " data-bs-toggle='modal' data-bs-target='#EditKategori'><i class='fas fa-edit' style='color: #fde808;'></i></button> | <a href='action/kategori-roti/hapus.php?id=" . $data['id'] . "' class='btn' onclick='return confirmHapus()'><i class='fas fa-trash' style='color: #ff0000;'></i></a> </td>";
                                        echo '</tr>';
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
    <?php include('partials/modal/TambahKategori.php') ?>
    <?php include('partials/modal/EditKategori.php') ?>


    <script src="../assets/template/js/bootstrap-bundle.min.js"></script>
    <script src="../assets/template/js/scripts.js"></script>
    <script src="../assets/template/js/jquery-3.7.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

    <script>
        $(".btnEditCategory").on("click", function() {
            const id = $(this).val()

            $.ajax({
                url: 'action/kategori-roti/fetchKategori.php',
                method: 'post',
                data: {
                    id: id
                },
                dataType: "json",
                success: function(res) {
                    const {
                        data
                    } = res
                    if (res.status) {
                        $("#nama_kategori_edit").val(data.category_name)
                        $("#id").val(data.id)
                    }
                }
            })
        })
        // inisialisasi table
        window.addEventListener('DOMContentLoaded', e => {
            const dataTable = document.getElementById('categoryTable');
            if (dataTable) {
                new simpleDatatables.DataTable(dataTable);
            }
        })

        function confirmHapus() {
            return confirm("Apa anda yakin?")
        }
    </script>
</body>

</html>