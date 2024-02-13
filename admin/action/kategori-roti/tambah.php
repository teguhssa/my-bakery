<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../../config/index.php');
// memulai session
session_start();

if (isset($_POST['btnAddKategori'])) {
    $categoryName = $_POST['nama_kategori'];
    $createdAt = date('Y-m-d H:i:s');

    $query = "INSERT INTO bakery_category (category_name, created_at) VALUES ('$categoryName', '$createdAt')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['flash_msg'] = "Berhasil tambah kategori!";
        header("Location: ../../kategori-roti.php");
    } else {
        $_SESSION['flash_msg'] = "Terjadi kesalahan!";
        header("Location: ../../kategori-roti.php");
        exit();
    }
}
