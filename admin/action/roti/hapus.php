<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../../config/index.php');
// memulai session
session_start();
// root dari file ke lokasi upload
define("ROOT_APP", dirname(__FILE__) . '/../../../');

if (isset($_GET['id'])) {
    // mengambil id yang ada di url
    $id = $_GET['id'];

    // query mengubah is_deleted menjadi true
    $sql = "UPDATE bakeries SET is_deleted = 1 WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['flash_msg'] = "Berhasil hapus roti!";
        header('Location: ../../roti.php');
        exit();
    } else {
        throw new Error('Gagal excute query!');
    }
}