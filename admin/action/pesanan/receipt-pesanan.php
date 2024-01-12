<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../../config/index.php');
// memulai session
session_start();
// root dari file ke lokasi upload

if ($_POST['action'] === "btnReceipt") {
    $order_id = $_POST['order_id'];
    $response = array();

    $query = "SELECT receipt.payment_img
    FROM orders
    JOIN receipt ON receipt.order_id = orders.id
    WHERE orders.id = '$order_id'
    ";

    $res = mysqli_query($conn, $query);

    if ($res) {
        $data = mysqli_fetch_assoc($res);
        $response['status'] = true;
        $response['data'] = $data;
    } else {
        $response = false;
        $response = null;
    }

    echo json_encode($response);
}
