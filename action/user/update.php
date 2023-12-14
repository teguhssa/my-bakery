<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if (isset($_POST['btnUpdateInfoUser'])) {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $modifiedAt = date('Y-m-d H:i:s');
    
    $sql = "UPDATE users SET name = '$name', modified_at = '$modifiedAt' WHERE id = '$user_id' ";
    $res = mysqli_query($conn, $sql);


    if ($res) {
        echo '<script>alert("Saved!"); window.location.href="../../profile.php";</script>';
    } else {
        echo '<script>alert("Failed update data!"); window.location.href="../../profile.php";</script>';
    }
}