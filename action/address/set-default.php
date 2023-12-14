<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();


// tandai alamat sebagai alamat default
if (isset($_GET['id']) && isset($_GET['is_default'])) {
    $id = $_GET['id'];
    $is_default = $_GET['is_default'];
    $user_id = $_SESSION['user_id'];

    // cek apakah ada alamaat default
    $checkIsDefault = "SELECT * FROM user_addresses WHERE is_default = 1 AND user_id = '$user_id' LIMIT 1";
    $res = mysqli_query($conn, $checkIsDefault);

    if ($res->num_rows > 0) {
        $row = mysqli_fetch_assoc($res);
        $defaultId = $row['id'];

        // update alamat sebagai alamat default
        mysqli_query($conn, "UPDATE user_addresses SET is_default = 1 WHERE id = '$id'");

        // update alamat default sebelumnya menjadi tidak default
        mysqli_query($conn, "UPDATE user_addresses SET is_default = 0 WHERE id = '$defaultId' ");
        echo '<script>alert("Default address changed!"); window.location.href="../../profile.php"</script>';
    } else {
        echo '<script>alert("Failed change default address!"); window.location.href="../../profile.php"</script>';
    }
}