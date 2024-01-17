<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if ($_POST['action'] === "btnFecthOrder") {
    $user_id = $_SESSION['user_id'];
    $bakery_id = $_POST['bakery_id'];
    $order_id = $_POST['order_id'];
    $response = array();
    $data = array();
    $createdAt = date('Y-m-d H:i:s');
    $dataRating = array();


    $sql = "SELECT bakeries.id AS bakery_id, bakeries.bakery_name, bakeries.bakery_img, order_detail.qty, order_detail.order_id AS order_id
    FROM bakeries
    JOIN order_detail ON bakeries.id = order_detail.bakery_id
    WHERE order_detail.order_id = '$order_id' AND bakeries.id = '$bakery_id' ";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }

        $qIsReviewed = "SELECT rating, review_description FROM reviews WHERE order_id = '$order_id' AND bakery_id = '$bakery_id' ";
        $result = mysqli_query($conn, $qIsReviewed);

        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $dataRating[] = $row;
            }
        }

        $response['status'] = true;
        $response['data'] = $data;
        $response['data_rating'] = $dataRating;
    } else {
        $response['status'] = false;
        $response['data'] = null;
    }

    echo json_encode($response);
}
