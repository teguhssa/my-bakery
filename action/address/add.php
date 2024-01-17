<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if (isset($_POST['btnAddress'])) {
    $user_id = $_SESSION['user_id'];
    $fullname = $_POST['fullname'];
    $phone_number = $_POST['phone_number'];
    $city = "bogor";
    $district_id = $_POST['district_id'];
    $postal_code = $_POST['postal_code'];
    $full_address = $_POST['full_address'];
    $createdAt = date('Y-m-d H:i:s');
    $result;

    if ($fullname !== "" && $phone_number !== "" && $city !== "" && $postal_code !== "" && $full_address !== "") {  

        $checkIsDefault = "SELECT * FROM user_addresses WHERE is_default = 1 AND user_id = '$user_id' LIMIT 1";
        $res = mysqli_query($conn, $checkIsDefault);

        if ($res->num_rows > 0) {
            $sql = "INSERT INTO user_addresses (user_id, fullname, city, district_id, full_address, postal_code, phone_number, is_default, created_at) VALUES ('$user_id', '$fullname', '$city', '$district_id' ,'$full_address', '$postal_code', '$phone_number', 0 ,'$createdAt')";
            $result = mysqli_query($conn, $sql);
        } else {
            $sql = "INSERT INTO user_addresses (user_id, fullname, city, district_id, full_address, postal_code, phone_number, is_default, created_at) VALUES ('$user_id', '$fullname', '$city', '$district_id' ,'$full_address', '$postal_code', '$phone_number',  1 ,'$createdAt')";
            $result = mysqli_query($conn, $sql);
        }

        if ($result) {
            echo '<script>alert("Address added!"); window.location.href="../../profile.php"</script>';
        } else {
            echo '<script>alert("Failed add address!"); window.location.href="../../profile.php"</script>';
            exit;
        }
    } else {
        echo '<script>alert("Field is required!"); window.location.href="../../profile.php"</script>';
        exit;
    }
}
