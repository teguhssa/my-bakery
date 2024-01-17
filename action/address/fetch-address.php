<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();


// fetching single alamat
if ($_POST['action'] === "btnFetchAlamat") {
    $id = $_POST['id'];
    $response = array();

    $sql = "SELECT user_addresses.id AS address_id, user_addresses.user_id, user_addresses.fullname, user_addresses.full_address, user_addresses.postal_code, user_addresses.phone_number, user_addresses.is_default, districts.id AS district_id, districts.district
    FROM user_addresses
    JOIN districts ON user_addresses.district_id = districts.id
    WHERE user_addresses.id = '$id' ";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $data = mysqli_fetch_assoc($res);
        $response['status'] = true;
        $response['data'] = $data;
        echo json_encode($response);
    } else {
        $response['status'] = false;
        $response['data'] = null;
        echo json_encode($response);
    }
}
