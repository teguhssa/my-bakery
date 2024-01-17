<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../../config/index.php');
// memulai session
session_start();


if ($_POST['action'] === 'approvePayment') {
    $order_id = $_POST['order_id'];
    $user_id = $_SESSION['user_id'];
    $createdAt = date('Y-m-d H:i:s');
    $response = array();

    $qApproveOrder = "UPDATE receipt SET isApprove = 1, approve_date = '$createdAt' WHERE order_id = '$order_id' ";
    $result =  mysqli_query($conn, $qApproveOrder);

    if ($result) {
        mysqli_query($conn, "UPDATE orders SET status_order = 'ready to ship' WHERE id = '$order_id' ");
        $qBakeryId = mysqli_query($conn, "SELECT GROUP_CONCAT(order_detail.bakery_id) AS bakery_ids, GROUP_CONCAT(order_detail.qty) AS qty
        FROM orders
        JOIN order_detail ON orders.id = order_detail.order_id
        WHERE orders.id = '$order_id' ");
        $val = mysqli_fetch_assoc($qBakeryId);

        $quentities = explode(',', $val['qty']);
        $targetId = explode(',', $val['bakery_ids']);

        $query = "UPDATE bakeries SET stock = CASE ";

        foreach ($targetId as $index => $id) {
            $quantity = isset($quentities[$index]) ? $quentities[$index] : 0;
            $query .= "WHEN id LIKE '%$id%' THEN stock - $quantity ";
        }

        $query .= "ELSE stock END";

        $res = mysqli_query($conn, $query);
        if (!$res) {
            die('error');
        }
        $response['status'] = true;
        $response['message'] = "Pembayaran di Approve!";
    } else {
        $response['status'] = false;
        $response['message'] = 'Something went wrong!';
    }

    echo json_encode($response);
}
