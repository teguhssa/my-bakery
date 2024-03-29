<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../config/index.php');
// memulai session
session_start();

if (isset($_POST['btnEditAddress'])) {
    // menangkap data yang dikirim
    $edit_id = $_POST['edit_id'];
    $fullname = $_POST['fullname_edit'];
    $phone_number = $_POST['phone_number_edit'];
    $district_id = $_POST['district_id_edit'];
    $full_address = $_POST['full_address_edit'];
    $modifiedAt = date('Y-m-d H:i:s');

    if ($fullname !== "" && $phone_number !== "" && $district_id !== "" && $full_address !== "" && $edit_id !== "") {
        // query edit
        $sql = "UPDATE user_addresses SET fullname = '$fullname', phone_number = '$phone_number', district_id = '$district_id', full_address = '$full_address', modified_at = '$modifiedAt' WHERE id = '$edit_id' ";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            echo '<script>alert("Address updated!"); window.location.href="../../profile.php"</script>';
        } else {
            echo '<script>alert("Field is required!"); window.location.href="../../profile.php"</script>';
            exit;
        }
    } else {
        echo '<script>alert("Field is required!"); window.location.href="../../profile.php"</script>';
        exit;
    }
}
