<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if (isset($_POST['addCart'])) {
    // mengambil data yang dikirimkan dari form
    $user_id = $_SESSION['user_id'];
    $bakery_id = $_POST['bakery_id'];
    $qty = (int)$_POST['qty'];
    $price = $_POST['price'];
    $createdAt = date('Y-m-d H:i:s');
    // menjumlahkan harga dengan kuantitas
    $total_price = (int)$qty * $price;


    if ($user_id !==  null) {
        $bakeryIdExist = "SELECT * FROM carts WHERE bakery_id = '$bakery_id' AND user_id = '$user_id' AND is_complete = 0 AND is_deleted = 0 LIMIT 1 ";
        $res = mysqli_query($conn, $bakeryIdExist);
        $dataExist = mysqli_fetch_assoc($res);

        if ($res->num_rows > 0) {
            $new_price = $dataExist['total_price'] += $price;
            $new_qty = $dataExist['qty'] += 1;
            $updatePrice = "UPDATE carts SET qty = '$new_qty', total_price = '$new_price' WHERE user_id = '$user_id' ";
            $res = mysqli_query($conn, $updatePrice);

            if ($res) {
                echo '<script>alert("Added to cart!"); window.location.href="../../bread.php?id=' . $bakery_id . '";</script>';
            } else {
                echo '<script>alert("Failed add to cart!"); window.location.href="../../bread.php?id=' . $bakery_id . '";</script>';
                exit;
            }
        } else {
            $sql = "INSERT INTO carts (user_id, bakery_id, qty, total_price, created_at) VALUES ('$user_id', '$bakery_id', '$qty', '$total_price', '$createdAt')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo '<script>alert("Added to cart!"); window.location.href="../../bread.php?id=' . $bakery_id . '";</script>';
                // die("tambah roti baru");
            } else {
                echo '<script>alert("Failed add to cart!"); window.location.href="../../bread.php?id=' . $bakery_id . '";</script>';
                exit;
            }
        }
    } else {
        header("Location: ../../login.php");
        exit;
    }
}
