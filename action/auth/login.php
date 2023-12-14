<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if (isset($_POST['btnLogin'])) {
    // menangkap data yang dikirim
    $cred = mysqli_escape_string($conn, $_POST['cred']);
    $password = hash('sha256', $_POST['password']);

    if ($cred !== '' && $password !== '') {
        $sql = "SELECT * FROM users WHERE (email = '$cred' OR username = '$cred') AND password = '$password' ";
        $result = mysqli_query($conn, $sql);
    
        if ($result->num_rows > 0) {

            $row = mysqli_fetch_assoc($result);

            if ($row === null) {
               echo '<script>alert("Email not found!"); window.location.href= "../../login.php" </script>';
               exit;
            }

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];

            echo '<script>alert("Welcome!, '.$row['username'].'"); window.location.href= "../../index.php" </script>';
        } else {
            echo '<script>alert("Email or password is wrong!"); window.location.href= "../../login.php" </script>';
            exit;
        }
    } else {
        echo '<script>alert("Field cannot be empty!"); window.location.href= "../../login.php" </script>';
        exit;
    }
}
