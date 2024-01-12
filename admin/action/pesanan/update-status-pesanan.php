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

    if ($status == "ready to ship") {
        $qBakeryId = mysqli_query($conn, "SELECT GROUP_CONCAT(order_detail.bakery_id) AS bakery_ids, GROUP_CONCAT(order_detail.qty) AS qty
        FROM orders
        JOIN order_detail ON orders.id = order_detail.order_id
        WHERE orders.id = '$order_id' ");
        $val = mysqli_fetch_assoc($qBakeryId);

        $quentities = explode(',', $val['qty']);
        $targetId = explode(',', $val['bakery_ids']);

        $query = "UPDATE bakeries SET stock = CASE ";

        foreach($targetId as $index => $id) {
            $quantity = isset($quentities[$index]) ? $quentities[$index] : 0;
            $query .= "WHEN id LIKE '%$id%' THEN stock - $quantity ";
        }

        $query .= "ELSE stock END";

        $res = mysqli_query($conn, $query);
        if (!$res) {
            die('error');
        }
    }

    $sql  = "UPDATE orders SET status_order = '$status' WHERE id = '$order_id' ";
    $r = mysqli_query($conn, $sql);

    if ($r) {
        $response['status'] = true;
    } else {
        $response['status'] = false;
    }

    echo json_encode($response);
}
