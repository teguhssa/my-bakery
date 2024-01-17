<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if (isset($_POST['btnValidateOrder'])) {
    $bakery_id = $_POST['bakery_id'];
    $qty = $_POST['qty'];

    $sql = "SELECT id, stock FROM bakeries WHERE id IN (" . implode(',', $bakery_id) . ")";
    $result = mysqli_query($conn, $sql);

    $insufficientStock = false;

    while ($row = mysqli_fetch_assoc($result)) {
        $currentStock = $row['stock'];
        
        $reqQty = $qty[array_search($row['id'], $bakery_id)];

        if ($reqQty > $currentStock) {
            $insufficientStock = true;
            break;   
        }
    }

    if ($insufficientStock) {
        echo '<script>alert("Not enough stock available!"); window.location.href="../../cart.php";</script>';
    } else {
        $_SESSION['isValidated'] = true;
        header("Location: ../../checkout.php");
        exit;
    }
}
