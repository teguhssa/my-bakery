<?php
// koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if (isset($_POST['btnLogout'])) {
    // session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
    unset($_SESSION['email']);
    unset($_SESSION['isValidated']);
    header("Location: ../../index.php");
    exit;
}
