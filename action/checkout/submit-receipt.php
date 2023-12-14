<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();
// root dari file ke lokasi upload
define("ROOT_APP", dirname(__FILE__) . '/../../');

if (isset($_POST['btnSendReceipt'])) {
    // menangkap data yang dikirim
    $user_id = $_SESSION['user_id'];
    $order_id = $_POST['order_id'];
    $receipt_img = $_FILES['receipt_img']['name'];
    $submitted_at = date('Y-m-d H:i:s');
    $maxSize = 2097152;
    $status = false;

    // $params = array('img' => $receipt_img, 'order_id' => $order_id);
    // var_dump($params);
    // die;

    // validasi semua input tidak kosong
    if ($receipt_img !== "" && $order_id !== "") {

        // validasi ukuran file
        if ($_FILES['receipt_img']['size'] >= $maxSize) {
            echo '<script>alert("File size cannot be more than 200KB!"); window.location.href="../../profile.php"</script>';
            exit;
        }

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
            // die('stop sini');
            echo '<script>alert("Extention file is not allowed!"); window.location.href="../../profile.php"</script>';
            exit;
        }

        // mengubah nama file
        $newName = "receipt-" . $order_id . $order_id . date('YmdHis') . '.' . $ext;

        // lokasi upload
        $locationDir = $upDir . $newName;

        if ($status) {
            $sql = "INSERT INTO receipt (order_id, user_id, payment_img, submitted_at) VALUES ('$order_id', '$user_id', '$newName', '$submitted_at') ";
            mysqli_query($conn, "UPDATE orders SET status_order = 'in process' WHERE status_order = 'waiting for payment' AND id = '$order_id' ");
            $res =  mysqli_query($conn, $sql);

            if ($res) {
                move_uploaded_file($_FILES['receipt_img']['tmp_name'], $locationDir);
                echo '<script>alert("Receipt submmitted!"); window.location.href="../../profile.php"</script>';
                // die("stop sini");
            } else {
                echo '<script>alert("Failed submit receipt!"); window.location.href="../../profile.php"</script>';
                exit;
            }
        } else {
            echo '<script>alert("Somthing went wrong!"); window.location.href="../../profile.php"</script>';
            exit;
        }
    } else {
        echo '<script>alert("Field is required!"); window.location.href="../../profile.php"</script>';
        exit;
    }
}
