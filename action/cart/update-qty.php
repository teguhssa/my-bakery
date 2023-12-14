<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if (isset($_POST['btnAddQtyCart'])) {
    $bakery_id = $_POST['bakery_id'];
    $price = $_POST['price'];
    $modifiedAt = date('Y-m-d H:i:s');

    $bakeryIdExist = "SELECT * FROM carts WHERE bakery_id = '$bakery_id' AND is_deleted = 0 LIMIT 1 ";
    $res = mysqli_query($conn, $bakeryIdExist);
    $dataExist = mysqli_fetch_assoc($res);

    $new_price = $dataExist['total_price'] += $price;
    $new_qty = $dataExist['qty'] += 1;
    $updatePrice = "UPDATE carts SET qty = '$new_qty', total_price = '$new_price', modified_at = '$modifiedAt' WHERE bakery_id = '$bakery_id' ";
    $res = mysqli_query($conn, $updatePrice);

    if ($res) {
        echo '<script>alert("Cart updated!"); window.location.href="../../cart.php";</script>';
    } else {
        echo '<script>alert("Failed update cart!"); window.location.href="../../cart.php";</script>';
        exit;
    }
}

if (isset($_POST['btnMinQtyCart'])) {
    $bakery_id = $_POST['bakery_id'];
    $price = $_POST['price'];
    $modifiedAt = date('Y-m-d H:i:s');
    $qty = (int)$_POST['qty'];
    $total_price = $_POST['total_price'];

    if ($qty - 1 === 0) {
        $updatePrice = "UPDATE carts SET modified_at = '$modifiedAt', is_deleted = 1 WHERE bakery_id = '$bakery_id' ";
        $res = mysqli_query($conn, $updatePrice);

        if ($res) {
            echo '<script>alert("Cart deleted!"); window.location.href="../../cart.php";</script>';
        } else {
            echo '<script>alert("Failed update cart!"); window.location.href="../../cart.php";</script>';
            exit;
        }
    } else {
        $new_price = $total_price -= $price;
        $new_qty = $qty - 1;
        $updatePrice = "UPDATE carts SET qty = '$new_qty', total_price = '$new_price', modified_at = '$modifiedAt' WHERE bakery_id = '$bakery_id' ";
        $res = mysqli_query($conn, $updatePrice);

        if ($res) {
            echo '<script>alert("Cart updated!"); window.location.href="../../cart.php";</script>';
        } else {
            echo '<script>alert("Failed update cart!"); window.location.href="../../cart.php";</script>';
            exit;
        }
    }
}
