<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../../config/index.php');
// memulai session
session_start();
// root dari file ke lokasi upload

if ($_POST['action'] === "btnDetail") {
    $order_id = $_POST['order_id'];
    $response = array();

    $qDetailPesanan = "SELECT 
        orders.id AS order_id,
        orders.user_id,
        orders.status_order,
        orders.created_at,
        user_addresses.full_address,
        user_addresses.city,
        user_addresses.postal_code,
        user_addresses.phone_number,
        users.username,
        GROUP_CONCAT(bakeries.bakery_name) AS bakery_names,
        GROUP_CONCAT(order_detail.qty) AS total_qty,
        order_detail.total_price
        FROM orders
        JOIN order_detail ON orders.id = order_detail.order_id
        JOIN bakeries ON order_detail.bakery_id = bakeries.id
        JOIN user_addresses ON orders.address_id = user_addresses.id
        JOIN users ON orders.user_id = users.id
        WHERE orders.id = '$order_id'
        GROUP BY orders.id, orders.user_id, orders.status_order, orders.created_at, user_addresses.full_address, users.username;";
    $r = mysqli_query($conn, $qDetailPesanan);

    if ($r) {
        $dataDetailPesanan = mysqli_fetch_assoc($r);
        $response['status'] = true;
        $response['data'] = $dataDetailPesanan;
    } else {
        $response['status'] = false;
        $response['data'] = null;
    }

    echo json_encode($response);
}
