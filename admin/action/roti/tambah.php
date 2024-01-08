<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../../config/index.php');
// memulai session
session_start();
// root dari file ke lokasi upload
define("ROOT_APP", dirname(__FILE__) . '/../../../');


// tambah roti
if (isset($_POST['btnTambahRoti'])) {
    $nama_roti = $_POST['nama_roti'];
    $harga_roti = $_POST['harga_roti'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $gambar = $_FILES['gambar_roti']['name'];
    $createdAt = date('Y-m-d H:i:s');
    $maxSize = 204800;
    $status = false;

    // validasi semua input tidak kosong
    if ($nama_roti !== '' && $harga_roti !== '' && $deskripsi !== '' && $gambar !== '' && $stock !== '') {

        // validasi ukuran gambar
        if ($_FILES['gambar_roti']['size'] >= $maxSize) {
            // simpan pesan kesalaha pada session
            $_SESSION['flash_msg'] = 'ukuran gambar tidak boleh dari 2MB!';
            header("Location: ../../tambah-roti.php");
            return;
        }

        // menginisialisasi tempat upload
        $uploadDir = ROOT_APP . "assets/upload/";

        // validasi jika folder tidak ada maka folder dibuat
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // mendapatkan extention gambar
        $ext = pathinfo($gambar, PATHINFO_EXTENSION);
        // menentukan extensi yang valid
        $validExt = array('jpg', 'jpeg', 'png');

        // validasi extention file
        if (in_array(strtolower($ext), $validExt)) {
            // ubah status menjadi true
            $status = true;
        } else {
            // simpan pesan kesalahan pada session
            $_SESSION['flash_msg'] = 'Extensi file tidak didukung!';
            header("Location: ../../tambah-roti.php");
        }

        // mengubah nama gambar
        $newName = "upload-" . date('YmdHis') . '.' . $ext;

        // lokasi upload gambar
        $locationDir = $uploadDir . $newName;

        // validasi jika status bernilai true
        if ($status) {
            $sql = "INSERT INTO bakeries (bakery_name, bakery_img, description, price, stock, created_at) VALUES ('$nama_roti', '$newName', '$deskripsi', '$harga_roti', '$stock', '$createdAt')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                if (move_uploaded_file($_FILES['gambar_roti']['tmp_name'], $locationDir)) {
                    $_SESSION['flash_msg'] = "Berhasil tambah roti!";
                    header("Location: ../../roti.php");
                } else {
                    $_SESSION['flash_msg'] = "Terjadi kesalahan!";
                    header("Location: ../../tambah-roti.php");
                    exit();
                }
            } else {
                throw new Error('Gagal excute query!');
            }
        }
    } else {
        $_SESSION['flash_msg'] = 'Form tidak boleh kosong!';
        header("Location: ../../tambah-roti.php");
    }
}
