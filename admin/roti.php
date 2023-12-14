<?php
include_once('../config/index.php');
// memulai session
session_start();
// validasi user jika tidak mempunyai session
if (!isset($_SESSION['user_id_admin'])) {
    header('Location: login.php');
    exit();
}

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
                    <h1 class="mt-4">Roti</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Roti</li>
                    </ol>
                    <a href="tambah-roti.php" class="btn btn-primary"><i class="fas fa-plus" style="color: #ffffff;"></i> Tambah Roti</a>
                    <div class="card my-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Roti
                        </div>
                        <div class="card-body">
                            <table id="tableRoti">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Gambar</th>
                                        <th>Desktripsi</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $sql = "SELECT * FROM bakeries WHERE is_deleted = 0";
                                    $result = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['bakery_name'] . "</td>";
                                        echo "<td> 
                                        <img src='../assets/upload/" . $row['bakery_img'] . "' alt='kuasong' width='50'>
                                        </td>";
                                        echo "<td>" . $row['description'] . "</td>";
                                        echo "<td>" . $row['price'] . "</td>";
                                        echo "<td> <a href='edit-roti.php?id=". $row['id'] ."' class='btn'><i class='fas fa-edit'  style='color: #fde808;'></i></a> | <a href='action/roti/hapus.php?id=" . $row['id'] . "' class='btn' onclick='return confirmHapus()'><i class='fas fa-trash' style='color: #ff0000;'></i></a> </td>";
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

    <!-- modal tamabh roti -->
    <div class="modal fade" id="modalAddRoti" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Roti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="action/roti/tambah.php" method="post" id="formTambahRoti" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama_roti" class="form-label">Nama Roti</label>
                            <input type="text" name="nama_roti" id="nama_roti" class="form-control" placeholder="Nama Roti..." required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_roti" class="form-label">Harga Roti</label>
                            <input type="number" name="harga_roti" id="harga_roti" class="form-control" placeholder="Harga Roti..." required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" placeholder="Deskripsi.." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gambar_roti">Gambar Roti</label>
                            <input type="file" name="gambar_roti" id="gambar_roti" class="form-control" required>
                            <div class="thumbnail d-none" id="wrapper_thumbnail">
                                <img alt="thumbnail" name="thumbnail" id="thumbnail">
                            </div>
                        </div>
                        <button class="btn btn-primary w-100" name="btnTambahRoti" type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/template/js/bootstrap-bundle.min.js"></script>
    <script src="../assets/template/js/scripts.js"></script>
    <!-- <script src="../assets/template/js/jquery-3.7.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

    <script>
        // inisialisasi table
        window.addEventListener('DOMContentLoaded', e => {
            const dataTable = document.getElementById('tableRoti');
            if (dataTable) {
                new simpleDatatables.DataTable(dataTable);
            }
        })

        // preview gambar sebelum updload
        const elFile = document.getElementById('gambar_roti')
        const thumbnail = document.getElementById('thumbnail')
        const wrapperThumbnail = document.getElementById('wrapper_thumbnail')

        elFile.addEventListener('change', (e) => {
            const reader = new FileReader()
            reader.onload = function() {
                thumbnail.src = reader.result
            }
            wrapperThumbnail.classList.remove('d-none')
            reader.readAsDataURL(e.target.files[0])

        })

        // clear value form saat modal ditutup
        const form = document.getElementById('formTambahRoti')
        const modal = document.querySelector('.modal')
        modal.addEventListener('hidden.bs.modal', () => {
            wrapperThumbnail.classList.add('d-none')
            form.reset()
        })

        // confirm dialog sebelum hapus
        function confirmHapus() {
            return confirm("Apa anda yakin?")
        }
    </script>
</body>

</html>