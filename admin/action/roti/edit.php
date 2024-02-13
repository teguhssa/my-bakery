<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../../config/index.php');
// memulai session
session_start();
// root dari file ke lokasi upload
define("ROOT_APP", dirname(__FILE__) . '/../../../');


// update roti
if (isset($_POST['btnUpdateRoti'])) {

    // tangkap value
    $id = $_POST['id'];
    $nama_roti = $_POST['nama_roti'];
    $category_id = $_POST['kategori_roti'];
    $harga_roti = $_POST['harga_roti'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $gambar = $_FILES['gambar_roti']['name'];
    $modifiedAt = date('Y-m-d H:i:s');
    $maxSize = 204800;
    $status = false;

    if ($gambar !== '') {

        // validasi ukuran gambar
        if ($_FILES['gambar_roti']['size'] >= $maxSize) {
            // simpan pesan kesalaha pada session
            $_SESSION['flash_msg'] = 'ukuran gambar tidak boleh dari 2MB!';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // menginisialisasi tempat upload
        $uploadDir = ROOT_APP . "assets/upload/";

        // mendapatkan extention gambar
        $ext = pathinfo($gambar, PATHINFO_EXTENSION);
        // menentukan extensi yang valid
        $validExt = array('jpg', 'jpeg', 'png');

        // validasi extention file
        if (in_array(strtolower($ext), $validExt)) {
            // ubah status menjadi true
            $status = true;
        } else {
            // simpan pesan kesalahan pada session
            $_SESSION['flash_msg'] = 'Extensi file tidak didukung!';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }


        // mengubah nama gambar
        $newName = "upload-" . date('YmdHis') . '.' . $ext;

        // lokasi upload gambar
        $locationDir = $uploadDir . $newName;

        if ($status) {
            $sql = "UPDATE bakeries SET bakery_name = '$nama_roti', bakery_img = '$newName', description  = '$deskripsi', price = '$harga_roti', stock = '$stock', modified_at = '$modifiedAt' WHERE id = '$id' ";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                if (move_uploaded_file($_FILES['gambar_roti']['tmp_name'], $locationDir)) {
                    $_SESSION['flash_msg'] = "Berhasil edit roti!";
                    header("Location: ../../roti.php");
                } else {
                    $_SESSION['flash_msg'] = "Terjadi kesalahan!";
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                }
            } else {
                throw new Error('Gagal excute query!');
            }
        }
    } else {
        $sql = "UPDATE bakeries SET category_id = '$category_id', bakery_name = '$nama_roti', description = '$deskripsi', price = '$harga_roti', stock = '$stock', modified_at = '$modifiedAt' WHERE id = '$id' ";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $_SESSION['flash_msg'] = 'Data berhasil diupdate!';
            header("Location: ../../roti.php");
        } else {
            $_SESSION['flash_msg'] = 'Terjadi kesalahan!';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
}
