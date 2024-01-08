<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if (isset($_POST['btnUpdateInfoUser'])) {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $modifiedAt = date('Y-m-d H:i:s');

    if ($username !== "" && $name !== "" && $email !== "") {
        $sql = "UPDATE users SET username = '$username', name = '$name',email = '$email' , modified_at = '$modifiedAt' WHERE id = '$user_id' ";
        $res = mysqli_query($conn, $sql);
    } else {
        echo '<script>alert("Profile cannot be empty!"); window.location.href="../../profile.php";</script>';
        exit;
    }

    echo '<script>alert("Saved!"); window.location.href="../../profile.php";</script>';
}
