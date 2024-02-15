<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../../config/index.php');
// memulai session
session_start();

if (isset($_POST['btnEditKategori']))
{
    $id = $_POST['id'];
    $categoryName = $_POST['nama_kategori_edit'];
    $slug = strtolower(str_replace('', '-', $categoryName));
    $updated_at = date('Y-m-d H:i:s');

    $query = "UPDATE bakery_category SET category_name = '$categoryName', slug = '$slug', updated_at = '$updated_at' WHERE id = '$id' ";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['flash_msg'] = "Berhasil Edit kategori!";
        header("Location: ../../kategori-roti.php");
    } else {
        $_SESSION['flash_msg'] = "Terjadi kesalahan!";
        header("Location: ../../kategori-roti.php");
        exit();
    }
}