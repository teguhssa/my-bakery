<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../../config/index.php');
// memulai session
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "UPDATE bakery_category SET is_deleted = 1 WHERE id = '$id' ";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['flash_msg'] = "Berhasil hapus kategori!";
        header('Location: ../../kategori-roti.php');
        exit();
    } else {
        $_SESSION['flash_msg'] = "Terjadi kesalahan!";
        header("Location: ../../kategori-roti.php");
        exit();
    }
}
