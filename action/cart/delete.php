<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if(isset($_POST['btnRemoveCart'])) {
    // menangkap data yang dikirim
    $id = $_POST['id'];
    $modifiedAt = date('Y-m-d H:i:s');

    // query delete
    $sql = "UPDATE carts SET is_deleted = 1, modified_at = '$modifiedAt' WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '<script>alert("Removed!"); window.location.href="../../cart.php";</script>';
    } else {
        echo '<script>alert("Failed remove!"); window.location.href="../../cart.php";</script>';
    }
}