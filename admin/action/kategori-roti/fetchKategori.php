<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../../config/index.php');
// memulai session
session_start();

if ($_POST['id']) {
    $id = $_POST['id'];
    $response = array();

    $query = "SELECT id, category_name FROM bakery_category WHERE id = '$id' ";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        $response['status'] = true;
        $response['data'] = $data;
    } else {
        $response['status'] = false;
        $response['data'] = null;
    }

    echo json_encode($response);
}
