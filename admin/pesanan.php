<?php
include_once('../config/index.php');
// memulai session
session_start();
// validasi user jika tidak mempunyai session
if (!isset($_SESSION['user_id_admin'])) {
    header('Location: login.php');
    exit();
}
// menampilkan semua pesanan
$qPesanan = "SELECT orders.id AS order_id, users.name, users.username, orders.status_order, orders.created_at, receipt.isApprove
FROM orders
JOIN receipt ON receipt.order_id  = orders.id
JOIN users ON users.id = orders.user_id ORDER BY orders.created_at DESC";
$res = mysqli_query($conn, $qPesanan);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tag -->
    <?php include('partials/meta.php') ?>

    <title>Pesanan - My Bakery</title>

    <link href="../assets/template/css/datatable-style.css" rel="stylesheet" />
    <link href="../assets/template/css/styles.css" rel="stylesheet" />
    <link href="../assets/template/css/custom.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <!-- header -->
    <?php include('partials/header.php') ?>

    <div id="layoutSidenav">

        <!-- sidebar -->
        <?php include('partials/sidebar.php') ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Pesanan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Pesanan</li>
                    </ol>

                    <div class="card my-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Pesanan
                        </div>
                        <div class="card-body">
                            <table id="tabelPesanan">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Waktu order</th>
                                        <th>Status Order</th>
                                        <th>Detail order</th>
                                        <th>Bukti Transfer</th>
                                        <th>Ubah status</th>
                                        <th>Setujui pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $orderDate = date("d F Y", strtotime($row['created_at']));
                                        echo "<tr>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>" . $orderDate . "</td>";
                                        echo "<td><div class='badge bg-success'>" . $row['status_order'] . "</div></td>";
                                        echo '<td><button class="btnDetail" id="btnDetail" value=' . $row['order_id'] . ' type="button" data-bs-toggle="modal" data-bs-target="#modalDetailPesanan">Lihat pesanan</button></td>';
                                        echo '<td><button type="button" class="btn btn-warning text-white btnReceipt" id="btnReceipt" value=' . $row['order_id'] . ' data-bs-toggle="modal" data-bs-target="#modalReceipt"><i class="fas fa-eye"></i></button></td>';
                                        echo "<td>";
                                        if ($row['isApprove']) {
                                            echo "<select class='form-select pilih-status' id='pilih-status'>
                                                <option selected>Pilih status</option>
                                                <option value='cancel' data-order-id='" . $row['order_id'] . "'>Cancel</option>
                                                <option value='shipping' data-order-id='" . $row['order_id'] . "'>Dalam perjalanan</option>
                                                <option value='done' data-order-id='" . $row['order_id'] . "'>Selesai</option>
                                                </select>";
                                        } else {
                                            echo 'Approve pembayaran untuk ubah status';
                                        }

                                        "</td>";
                                        if ($row['isApprove']) {
                                            echo "<td><div class='badge bg-success'>Sudah di Approve</div></td>";
                                        } else {
                                            echo "<td><button type='button' class='btn btn-success text-white btnApprove' id='btnApprove' data-order-id='" . $row['order_id'] . "'><i class='fas fa-check'></i></button></td>";
                                        }
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- modal detail pesanan -->
    <?php include('partials/modal/DetailPesanan.php') ?>
    <!-- modal detail pesanan -->
    <!-- modal receipt -->
    <?php include('partials/modal/ReceiptImg.php') ?>

    <script src="../assets/template/js/bootstrap-bundle.min.js"></script>
    <script src="../assets/template/js/scripts.js"></script>
    <script src="../assets/template/js/jquery-3.7.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

    <script>
        $(function() {
            $(".btnDetail").on("click", function() {
                const order_id = $(this).val()

                $.ajax({
                    url: "action/pesanan/detail-pesanan.php",
                    method: "post",
                    data: {
                        action: "btnDetail",
                        order_id: order_id
                    },
                    dataType: "JSON",
                    success: function(res) {
                        const {
                            data
                        } = res

                        if (res.status) {
                            $("#info-nama-produk").text(data.bakery_names)
                            $("#info-qty").text(data.total_qty)
                            $("#info-nama").text(data.name)
                            $("#info-username").text(data.username)
                            $("#info-alamat").text(data.full_address)
                            $("#info-kota").text(data.city)
                            $("#info-nomor-hp").text(data.phone_number)
                            $("#info-tanggal-pesan").text(data.created_at)
                            $("#info-total").text(data.total_price)
                        }
                    }
                })
            })

            $(".btnReceipt").on("click", function() {
                let order_id = $(this).val()

                $.ajax({
                    url: "action/pesanan/receipt-pesanan.php",
                    method: "post",
                    data: {
                        action: "btnReceipt",
                        order_id: order_id
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.status) {
                            const {
                                data
                            } = res
                            $('.img-receipt').attr('src', '../assets/upload/receipt/' + data.payment_img);
                        }
                    }
                })
            })

            $(".btnApprove").on('click', function() {
                const order_id = $(this).data('order-id');

                $.ajax({
                    url: "action/pesanan/approve-pembayaran.php",
                    method: "post",
                    dataType: "json",
                    data: {
                        action: "approvePayment",
                        order_id: order_id
                    },
                    beforeSend: function() {
                        confirm('Approve pembayaran ini?')
                    },
                    success: function(res) {
                        if (res.status) {
                            alert('Pembayaran di approve')
                            window.location.href = 'pesanan.php'
                        }
                    }
                })
            })

            $(".pilih-status").on("change", function() {
                const status = $(this).find(":selected").val()
                const order_id = $(this).find(":selected").data("order-id");

                $.ajax({
                    url: "action/pesanan/update-status-pesanan.php",
                    method: "post",
                    data: {
                        action: "updateStatus",
                        order_id: order_id,
                        status: status
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if (res.status) {
                            window.location.href = 'pesanan.php'
                        }
                    }
                })
            })
        })

        // inisialisasi table
        window.addEventListener('DOMContentLoaded', e => {
            const dataTable = document.getElementById('tabelPesanan');
            if (dataTable) {
                new simpleDatatables.DataTable(dataTable);
            }
        })
    </script>
</body>

</html>