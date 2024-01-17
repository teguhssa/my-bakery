<div class="modal fade" id="modalPayOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pay Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="border mb-3 p-2">
                    <p>To finish this order you can transfer to MyBakery bank <span class="fw-bold">58323043480</span></p>
                </div>
                <form action="action/checkout/order.php" method="post" class="w-100" id="form-payment" enctype="multipart/form-data">
                    <input type="hidden" name="address_id" value="<?php echo $dataAddress['address_id'] ?>">
                    <input type="hidden" name="cart_id" value="<?php echo $cart_id ?>">
                    <div class="mb-3">
                        <input type="file" name="receipt-file" id="receipt-file" class="mb-3 form-control" accept="image/png, image/jpg, image/jpeg" />
                        <div class="preview-receipt-wrapper d-none">
                            <img alt="receipt-img" id="receipt-thumbnail" />
                        </div>
                    </div>
                    <?php
                    foreach ($dataInput as $d) {
                        echo '
                                <input type="hidden" name="bakery_id[]" value="' . $d['bakery_id'] . '" />
                                <input type="hidden" name="qty[]" value="' . $d['qty'] . '" />
                                <input type="hidden" name="subtotal[]" value="' . $d['price'] . '"/>
                                <input type="hidden" name="total_payment[]" value="' . $total_payment . '" />
                                ';
                    }

                    ?>
                    <?php if ($dataAddress !== null) {
                        echo '<button class="btnPlaceOrder" name="placeOrder">Pay</button>';
                    } ?>
                </form>
            </div>
        </div>
    </div>
</div>