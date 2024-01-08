<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if (isset($_POST['btnRegis'])) {
    // menangkap value yang dikirm
    $username = $_POST['username'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    // encripsi password
    $password = hash('sha256', $_POST['password']);
    $createdAt = date('Y-m-d H:i:s');

    // validasi data yang dikirim tidak kosong
    if ($username !== '' && $email !== '' && $password !== '' && $name !== '') {
        // validasi email unik
        $emailIsExt = "SELECT email FROM users WHERE email = '$email' ";
        $result = mysqli_query($conn, $emailIsExt);

        if ($result->num_rows > 0) {
            echo "<script>alert('Email sudah terdaftar!'); window.location.href = '../../registration.php'</script>";
            return;
        }
        // masukan data ke database
        $sql = "INSERT INTO users (name, email, username, password, created_at) VALUE ('$name', '$email', '$username', '$password', '$createdAt')";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            echo "<script>alert('Account created!'); window.location.href = '../../registration.php'</script>";
        } else {
            echo "<script>alert('Failed create account!'); window.location.href = '../../registration.php'</script>";
        }
    } else {
        echo "<script>alert('Field cannot be empty!'); window.location.href = '../../registration.php'</script>";
        return;
    }
}
