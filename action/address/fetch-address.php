<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();


// fetching single alamat
if ($_POST['action'] === "btnFetchAlamat") {
    $id = $_POST['id'];
    $response = array();

    $sql = "SELECT * FROM user_addresses WHERE id = '$id' ";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $data = mysqli_fetch_assoc($res);
        $response['status'] = true;
        $response['data'] = $data;
        echo json_encode($response);
    } else {
        $response['status'] = false;
        $response['data'] = null;
        echo json_encode($response);
    }
}