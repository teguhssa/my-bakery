<?php
include_once('../config/index.php');
// memulai session
session_start();
// validasi user jika tidak mempunyai session
if (!isset($_SESSION['user_id_admin'])) {
    header('Location: login.php');
    exit();
}

// define('APP_ROOT', dirname(__FILE__));

// menampilkan roti yang sudah dipilih

$id = $_GET['id'];

// fetch roti berdasarkan id
$sql = "SELECT * FROM bakeries WHERE id = '$id' ";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    $nama_roti = $row['bakery_name'];
    $gambar_roti = $row['bakery_img'];
    $deskripsi = $row['description'];
    $harga_roti = $row['price'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- meta tag -->
    <?php include('partials/meta.php') ?>

    <title>Roti - Tambah Roti</title>

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
                    <h1 class="mt-4">Roti</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="roti.php">Roti</a></li>
                        <li class="breadcrumb-item active">Edit Roti</li>
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

                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <form action="action/roti/edit.php" method="post" id="formUpdateRoti" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="nama_roti" class="form-label">Nama Roti</label>
                                    <input type="text" name="nama_roti" id="nama_roti" class="form-control" placeholder="Nama Roti..." value="<?php echo $nama_roti ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="harga_roti" class="form-label">Harga Roti</label>
                                    <input type="number" name="harga_roti" id="harga_roti" class="form-control" placeholder="Harga Roti..." value="<?php echo $harga_roti ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" placeholder="Deskripsi.." required><?php echo htmlspecialchars($deskripsi) ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="gambar_roti">Gambar Roti</label>
                                    <input type="file" name="gambar_roti" id="gambar_roti" class="form-control" accept="image/png, image/jpg, image/jpeg">
                                    <div class="thumbnail" id="wrapper_thumbnail">
                                        <img src="../assets/upload/<?php echo $gambar_roti; ?>"  alt="thumbnail" name="thumbnail" id="thumbnail">
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $id ?>" name="id" />
                                <button class="btn btn-primary w-100" name="btnUpdateRoti" type="submit">Update</button>
                            </form>
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
        // preview gambar sebelum upload
        const elFile = document.getElementById('gambar_roti')
        const thumbnail = document.getElementById('thumbnail')
        const wrapperThumbnail = document.getElementById('wrapper_thumbnail')

        elFile.addEventListener('change', (e) => {
            const reader = new FileReader()
            reader.onload = function() {
                thumbnail.src = reader.result
            }
            reader.readAsDataURL(e.target.files[0])

        })
    </script>
</body>

</html>