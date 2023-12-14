<?php
// import koneksi untuk ke databse
include_once('config/index.php');
// import helper function
include_once('helper/index.php');
// memulai session
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
// query untuk mendapatkan data user
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

// query untuk mendapatkan data alamat
$getAddress = "SELECT * FROM user_addresses WHERE user_id = '$user_id' AND is_deleted = 0 ORDER BY is_default = 1 DESC ";
$userInfo = mysqli_query($conn, $getAddress);

//  menapilkan data pembelian
$qOrder = "SELECT 
orders.id AS order_id,
orders.user_id,
orders.status_order,
orders.created_at,
user_addresses.full_address,
GROUP_CONCAT(bakeries.bakery_name) AS bakery_names,
SUM(order_detail.qty) AS total_qty,
order_detail.total_price
FROM orders
JOIN order_detail ON orders.id = order_detail.order_id
JOIN bakeries ON order_detail.bakery_id = bakeries.id
JOIN user_addresses ON orders.address_id = user_addresses.id
WHERE orders.user_id = '$user_id'
GROUP BY orders.id, orders.user_id, orders.status_order, orders.created_at
ORDER BY orders.created_at DESC";
$res = mysqli_query($conn, $qOrder);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tag -->
    <?php include('partials/meta.php') ?>

    <!-- title -->
    <title>My Bakery</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="assets/user/img/favicon.png">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="assets/user/css/all.min.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- owl carousel -->
    <link rel="stylesheet" href="assets/user/css/owl.carousel.css">
    <!-- magnific popup -->
    <link rel="stylesheet" href="assets/user/css/magnific-popup.css">
    <!-- animate css -->
    <link rel="stylesheet" href="assets/user/css/animate.css">
    <!-- mean menu css -->
    <link rel="stylesheet" href="assets/user/css/meanmenu.min.css">
    <!-- main style -->
    <link rel="stylesheet" href="assets/user/css/main.css">
    <!-- responsive -->
    <link rel="stylesheet" href="assets/user/css/responsive.css">

</head>

<body>

    <!--PreLoader-->
    <?php include('partials/loader.php') ?>
    <!--PreLoader Ends-->

    <!-- header -->
    <?php include('partials/navbar.php') ?>
    <!-- header end -->

    <!-- search area -->
    <?php include('partials/searchArea.php') ?>
    <!-- end search area -->

    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Profile</p>
                        <h1>Hi!, <?php echo ($data['name'] !== null ? $data['name'] : $_SESSION['username']) ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <div class="profile-section mt-150 mb-150">
        <div class="container">
            <!-- tab -->
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-tab="#profile-tab" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="true">Profile</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="addresses-tab" data-tab="#address-tab" data-bs-toggle="tab" data-bs-target="#addresses-tab-pane" type="button" role="tab" aria-controls="addresses-tab-pane" aria-selected="false">Addresses</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="purchase-tab" data-tab="#purchase-tab" data-bs-toggle="tab" data-bs-target="#purchase-tab-pane" type="button" role="tab" aria-controls="purchase-tab-pane" aria-selected="false">My Purchase</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <!-- tab profile -->
                        <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-lg-8 col-md-12">
                                    <div class="card my-4" style="height: 300px">
                                        <div class="card-body">
                                            <div class="card-title">
                                                <h4>My Profile</h4>
                                                <div class="row justify-content-center align-items-center">
                                                    <div class="col-md-8">
                                                        <div class="my-info">
                                                            <form action="action/user/update.php" method="post">
                                                                <table>
                                                                    <tr>
                                                                        <td class="placeholder-info"><label>Username</label></td>
                                                                        <td class="placeholder-value">
                                                                            <p><?php echo $data['username'] ?></p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="placeholder-info"><label>Name</label></td>
                                                                        <td class="placeholder-value-input">
                                                                            <input type="text" name="name" placeholder="Your name.." class="form-control" value="<?php echo $data['name'] ?>">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="placeholder-info"><label>Email</label></td>
                                                                        <td class="placeholder-value">
                                                                            <p><?php echo $data['email'] ?></p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><button class="btnUpdateInfoUser w-100" name="btnUpdateInfoUser">Save</button></td>
                                                                    </tr>
                                                                </table>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end table profile -->
                        <!-- tab address -->
                        <div class="tab-pane fade" id="addresses-tab-pane" role="tabpanel" aria-labelledby="addresses-tab" tabindex="0">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-lg-8 col-md-12">
                                    <button class="btnModalAddAddress py-2" data-bs-toggle="modal" data-bs-target="#modalTambahAlamat"><i class="fas fa-plus"></i> Add new address</button>
                                    <div class="address-wrapper">
                                        <?php
                                        if ($userInfo->num_rows > 0) {
                                            while ($row = mysqli_fetch_assoc($userInfo)) {
                                                echo '
                                                    <div class="card my-4">
                                                    <div class="card-body">
                                                        <div class="card-title d-flex align-items-center gap-2">
                                                            <h5 class="m-0">' . $row['fullname'] . '</h5>';
                                                if ($row['is_default']) {
                                                    echo ' <div class="badge bg-warning">Default</div>';
                                                }
                                                echo '</div>
                                                                <div class="address-info d-flex flex-column gap-2 mb-3">
                                                                    <p class="m-0">' . $row['phone_number'] . '</p>
                                                                    <p class="m-0">' . $row['full_address'] . '</p>
                                                                    <div class="btnAddres d-flex align-items-center gap-2">';
                                                if (!$row['is_default']) {
                                                    echo '<a href="action/address/set-default.php?id=' . $row['id'] . '&is_default=' . $row['is_default'] . '" class="btnActiviedAddress text-white">Set as default</a>';
                                                }
                                                echo '<button value=' . $row['id'] . ' class="btnEditAddress" id="btnFetchAlamat" data-bs-toggle="modal" data-bs-target="#modalEditAlamat">Edit</button>
                                                        <a href="action/address/delete.php?id=' . $row['id'] . '" onclick="return confirmHapus()">Delete</a>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>';
                                            }
                                        } else {
                                            echo '
                                                <div class="card my-4">
                                                    <div class="card-body">
                                                        <p>Not address saved, you can add your address up there</p>
                                                    </div>
                                                </div>';
                                        }
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end tab address -->
                        <!-- tab order -->
                        <div class="tab-pane fade" id="purchase-tab-pane" role="tabpanel" aria-labelledby="purchase-tab" tabindex="0">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-lg-8 col-md-12">
                                    <?php
                                    if ($res->num_rows > 0) {
                                        while ($dataOrder = mysqli_fetch_assoc($res)) {
                                            $orderDate = date("d F Y", strtotime($dataOrder['created_at']));
                                            echo '
                                                <div class="card my-4">
                                                    <div class="card-body">
                                                        <div class="card-title d-flex align-items-center gap-2">
                                                            <p class="m-0 fw-bold">' . $orderDate . '</p>
                                                            <div class="badge bg-success">' . $dataOrder['status_order'] . '</div>
                                                        </div>
                                                        <div class="d-flex flex-column gap-2 mb-3">
                                                            <p class="m-0 fw-bold">Bakery: ' . $dataOrder['bakery_names'] . '</p>
                                                            <p class="m-0">Total Qty: x ' . $dataOrder['total_qty'] . '</p>
                                                            <p class="m-0">to: ' . $dataOrder['full_address'] . '</p>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <p class="fw-bold" style="margin-bottom: 0; margin-right: 20px;">Total Price</p>
                                                            <p class="m-0 total-amount">' . rupiah($dataOrder['total_price']) . '</p>
                                                        </div>
                                                        <div class="d-flex justify-content-end gap-3">
                                                            <button class="btnPostReceipt" data-order-id=' . $dataOrder['order_id'] . ' id="btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailOrder">Detail Order</button>
                                                        </div>
                                                    </div>
                                                </div>';
                                        }
                                    } else {
                                        echo '
                                            <div class="card my-4">
                                                <div class="card-body">
                                                    <p>No order, you can buy some bread</p>
                                                    <a href="all-bread.php" class="redirect-link">Buy some bread</a>
                                                </div>
                                            </div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end tab -->
            <div class="d-flex justify-content-end">
                <form action="action/auth/logout.php" method="post">
                    <input type="hidden" value="<?php echo $_SESSION['user_id']  ?>" name="user_id" />
                    <button class="btn btn-danger" name="btnLogout">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <?php include('partials/modal/AddAddress.php') ?>

    <?php include('partials/modal/DetailOrder.php') ?>

    <?php include('partials/modal/EditAddress.php') ?>


    <!-- footer -->
    <?php include('partials/footer.php') ?>
    <!-- end footer -->


    <!-- jquery -->
    <!-- <script src="assets/user/js/jquery-1.11.3.min.js"></script> -->
    <script src="assets/template/js/jquery-3.7.min.js"></script>
    <!-- bootstrap -->
    <script src="assets/template/js/bootstrap-bundle.min.js"></script>
    <!-- waypoints -->
    <!-- <script src="assets/user/js/waypoints.js"></script> -->
    <!-- magnific popup -->
    <script src="assets/user/js/jquery.magnific-popup.min.js"></script>
    <!-- mean menu -->
    <script src="assets/user/js/jquery.meanmenu.min.js"></script>
    <!-- sticker js -->
    <script src="assets/user/js/sticker.js"></script>
    <!-- main js -->
    <script src="assets/user/js/main.js"></script>
    <!-- helper -->
    <script src="helper/index.js"></script>

    <script>
        $(document).ready(function() {

            // mengirim order_id untuk detail order
            $(".btnPostReceipt").on("click", function() {
                const order_id = $(this).data('order-id')

                $.ajax({
                    url: "action/order/detail.php",
                    data: {
                        action: "orderDetail",
                        order_id: order_id
                    },
                    method: "post",
                    dataType: "json",
                    success: function(res) {
                        if (res.status) {
                            let {
                                data
                            } = res

                            $("#order-date").text(res.date_order)
                            // buat element untuk ditampilkan
                            const detailElement = data.map((item, index) => (
                                ` <div class="card-body">
                                    <div class="address-info d-flex align-items-center gap-2 mb-3">
                                        <div class="d-flex flex-grow-1">
                                            <img src="assets/upload/${item.bakery_img}" alt="bread" width="100" />
                                            <div class="d-flex flex-column" style="margin-left: 20px;">
                                                <p class="m-0 fw-bold">${item.bakery_name}</p>
                                                <p class="m-0">x ${item.qty}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <p class="fw-bold" style="margin-bottom: 0; margin-right: 20px;">Total Price</p>
                                        <p class="m-0 total-amount">${rupiah(item.subtotal)}</p>
                                    </div>
                                </div>`
                            ))

                            $("#order-detail-wrapper").html(detailElement)
                        }
                    }
                })
            })

            // Pilih elemen dengan ID btnFetchAlamat
            $("#btnFetchAlamat").on("click", function() {
                const id = $(this).val()

                $.ajax({
                    url: "action/address/fetch-address.php",
                    data: {
                        action: "btnFetchAlamat",
                        id: id
                    },
                    method: "post",
                    dataType: "json",
                    success: function(res) {

                        const {
                            data
                        } = res

                        $("#fullname_edit").val(data.fullname)
                        $("#phone_number_edit").val(data.phone_number)
                        $("#city_edit").val(data.city)
                        $("#postal_code_edit").val(data.postal_code)
                        $("#full_address_edit").text(data.full_address)
                        $("#edit_id").val(data.id)
                    }
                })
            });
        });

        // confirm dialog sebelum hapus
        function confirmHapus() {
            return confirm("Are you sure??")
        }

        // 
    </script>

</body>

</html>