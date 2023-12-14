<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if (isset($_POST['placeOrder'])) {
    // menangkap data yang dikirim
    $user_id = $_SESSION['user_id'];
    $address_id = $_POST['address_id'];
    $cart_id = $_POST['cart_id'];
    $bakery_id = $_POST['bakery_id'];
    $qty = $_POST['qty'];
    $subtotal = $_POST['subtotal'];
    $total_payment = $_POST['total_payment'];
    $createdAt = date('Y-m-d H:i:s');

    // $param = array("subtotal" => $subtotal, "total_payment" => $total_payment);
    // var_dump($param);
    // die;


    $sql = "INSERT INTO orders (user_id, address_id, created_at) VALUE ('$user_id', '$address_id', '$createdAt') ";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $order_id = mysqli_insert_id($conn);
        $qOrderDetail = "INSERT INTO order_detail (order_id, bakery_id, qty, subtotal, total_price, created_at) VALUE ";
        $valuesArr = array();
        $valuesUpdate = array();

        foreach ($bakery_id as $key => $n) {
            $bi = $bakery_id[$key];
            $quan = $qty[$key];
            $sub = $subtotal[$key];
            $tot = $total_payment[$key];

            $valuesArr[] = "('$order_id', '$bi', '$quan', '$sub', '$tot', '$createdAt')";
            $valuesUpdate[] = "$bi";
        }

        $qOrderDetail .= implode(',', $valuesArr);
        mysqli_query($conn, $qOrderDetail);

        // query update cart
        $qUpdateCart = "UPDATE carts SET is_complete = 1 WHERE is_complete = 0 AND user_id = '$user_id' AND bakery_id IN (";

        $qUpdateCart .= implode(',', $valuesUpdate);
        $qUpdateCart .= ")";
        
        mysqli_query($conn, $qUpdateCart);  

        echo '<script>alert("Order placed!"); window.location.href="../../profile.php"</script>';
    } else {
        echo '<script>alert("Order failed!"); window.location.href="../../checkout.php"</script>';
        exit;
    }
}
