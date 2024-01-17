<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../../config/index.php');
// memulai session
session_start();
// root dari file ke lokasi upload

if ($_POST['action'] === "updateStatus") {
    $status = $_POST['status'];
    $order_id = $_POST['order_id'];
    $response = array();

    $sql  = "UPDATE orders SET status_order = '$status' WHERE id = '$order_id' ";
    $r = mysqli_query($conn, $sql);

    if ($r) {
        $response['status'] = true;
    } else {
        $response['status'] = false;
    }

    echo json_encode($response);
}
