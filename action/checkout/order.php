<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();
// root dari file ke lokasi upload
define("ROOT_APP", dirname(__FILE__) . '/../../');

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
    $receipt_img = $_FILES['receipt-file']['name'];
    $status = false;

    if ($receipt_img !== "") {
        // validation receipt

        // upload directory
        $upDir = ROOT_APP . "assets/upload/receipt/";

        if (!file_exists($upDir)) {
            mkdir($upDir, 0777, true);
        }

        // mendapatkan extention gambar
        $ext = pathinfo($receipt_img, PATHINFO_EXTENSION);
        // menentukan extensi yang valid
        $validExt = array('jpg', 'jpeg', 'png');


        if (in_array(strtolower($ext), $validExt)) {
            $status = true;
        } else {
            echo '<script>alert("Extention file is not allowed!"); window.location.href="../../checkout.php"</script>';
            exit;
        }


        // insert to order
        $sql = "INSERT INTO orders (user_id, address_id, created_at) VALUE ('$user_id', '$address_id', '$createdAt') ";
        $res = mysqli_query($conn, $sql);
        $order_id = mysqli_insert_id($conn);

        // mengubah nama file
        $newName = "receipt-" . $order_id . date('YmdHis') . '.' . $ext;

        // lokasi upload
        $locationDir = $upDir . $newName;

        if ($res) {

            // insert receipt
            $qReceipt = "INSERT INTO receipt (order_id, user_id, payment_img, submitted_at) VALUE ('$order_id', '$user_id', '$newName', '$createdAt')";
            mysqli_query($conn, $qReceipt);
            move_uploaded_file($_FILES['receipt-file']['tmp_name'], $locationDir);


            // insert order_detail
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
    } else {
        // die("stop");
        echo '<script>alert("Receipt is required!"); window.location.href="../../checkout.php"</script>';
        exit;    
    }
}
