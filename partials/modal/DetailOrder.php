<?php
$sql = "SELECT 
orders.id AS order_id,
orders.user_id,
orders.status_order,
orders.created_at,
bakeries.bakery_name,
bakeries.bakery_img,
order_detail.qty,
order_detail.qty * order_detail.subtotal AS subtotal,
order_detail.total_price

FROM orders
JOIN order_detail ON orders.id = order_detail.order_id
JOIN bakeries ON order_detail.bakery_id = bakeries.id
WHERE orders.user_id = '$user_id'";
$d = mysqli_query($conn, $sql);

// tanggal pemesanan
$orderDate;
?>

<div class="modal fade" id="modalDetailOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel">Detail order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <p class="mb-0 fw-bold">Order Date: <?php echo $orderDate ?></p>
                </div>
                <?php
                    while ($row = mysqli_fetch_assoc($d)) {
                        $orderDate = date("d F Y", strtotime($row['created_at']));
                        echo '
                        <div class="card-body">
                            <div class="address-info d-flex align-items-center gap-2 mb-3">
                                <div class="d-flex flex-grow-1">
                                    <img src="assets/upload/'.$row['bakery_img'].'" alt="bread" width="100" />
                                    <div class="d-flex flex-column" style="margin-left: 20px;">
                                        <p class="m-0 fw-bold">'.$row['bakery_name'].'</p>
                                        <p class="m-0">x '.$row['qty'].'</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <p class="fw-bold" style="margin-bottom: 0; margin-right: 20px;">Total Price</p>
                                <p class="m-0 total-amount">'.rupiah($row['subtotal']).'</p>
                            </div>
                        </div>
                        ';
                    }
                ?>
            </div>
        </div>
    </div>
</div>