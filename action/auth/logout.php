<?php
// koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if (isset($_POST['btnLogout'])) {
    session_destroy();
    header("Location: ../../index.php");
}
