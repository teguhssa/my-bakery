<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

// action login
if (isset($_POST['btnLogin'])) {

    // tangkap hasil dari input
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = hash('sha256', $_POST['password']);

    // query validasi email, password, role
    $sql = "SELECT * FROM users WHERE username = '$username' && password = '$password' && role = 'admin' ";
    $result = mysqli_query($conn, $sql);

    // cek jika hasil dari validasi valid
    if ($result->num_rows > 0) {
        // menagambil data
        $row = mysqli_fetch_assoc($result);
        // menyimpan data user kedalam session
        $_SESSION['user_id_admin'] = $row['id'];
        $_SESSION['username_admin'] = $row['username'];
        $_SESSION['flash_msg'] = $row['username'];
        // redirect kehalaman selanjutnya
        header('Location: ../index.php');
        exit();
    } else {
        // menyimpan pesan kesalahan kedalam session
        $_SESSION['flash_msg_error'] = "Email atau Password salah!";
        header('Location: ../login.php');
    }
}

// action logout
if (isset($_POST['btnLogout'])) {
    // unset($_SESSION['username']);
    // session_destroy();
    unset($_SESSION['user_id_admin']);
    unset($_SESSION['username_admin']);
    unset($_SESSION['flash_msg']);
    header("Location: ../login.php");
    exit;
}
