<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "UPDATE user_addresses SET is_deleted = 1 WHERE id = '$id' ";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo '<script>alert("Address deleted!"); window.location.href="../../profile.php"</script>';
    } else {
        echo '<script>alert("Failed!"); window.location.href="../../profile.php"</script>';
        exit;
    }
}
