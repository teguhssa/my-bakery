<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if ($_POST['action'] === "orderDetail") {
    $user_id = $_SESSION['user_id'];
    $order_id = $_POST['order_id'];
    // $bakery_id = $_POST['bakery_id'];
    $response = array();
    // $data = array();
    $dateOrder;

    $sql = "SELECT orders.status_order, orders.created_at AS order_date, order_detail.total_price, order_detail.qty, user_addresses.full_address, bakeries.bakery_name, bakeries.bakery_img
    FROM orders
    JOIN order_detail ON orders.id = order_detail.order_id
    JOIN bakeries ON order_detail.bakery_id = bakeries.id
    JOIN user_addresses ON orders.address_id = user_addresses.id
    WHERE orders.id = '$order_id' ";

    $d = mysqli_query($conn, $sql);

    if ($d) {
        $data = mysqli_fetch_assoc($d);
        $orderDate = date("d F Y", strtotime($data['order_date']));
        $response['status'] = true;
        $response['data'] = $data;
        $response['date_order'] = $orderDate;
    } else {
        $response['status'] = false;
        $response['data'] = null;
    }

    echo json_encode($response);
}
