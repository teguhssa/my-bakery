<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if ($_POST['action'] === "btnPostReview") {
    $user_id = $_SESSION['user_id'];
    $bakery_id = $_POST['bakery_id'];
    $order_id = $_POST['order_id'];
    $reviewDesc = $_POST['reviewDesc'];
    $rating = $_POST['rating'];
    $createdAt = date('Y-m-d H:i:s');
    $response = array();

    $sql = "INSERT INTO reviews (order_id, user_id, bakery_id, review_description, rating, created_at)
    VALUE ('$order_id', '$user_id', '$bakery_id', '$reviewDesc', '$rating', '$createdAt') ";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        $response['status'] = true;
        $response['message'] = "Review submitted!";
    } else {
        $response['status'] = false;
        $response['message'] = "Review not submitted!";
    }

    echo json_encode($response);
}
