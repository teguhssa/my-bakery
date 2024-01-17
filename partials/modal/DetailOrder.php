<div class="modal fade" id="modalDetailOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel">Detail order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="badge bg-success mb-2" id="status_order"></div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-0">Date Order</p>
                            <p class="mb-0" id="orderDate"></p>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="mb-0"><i class="fas fa-map-marker-alt me-3"></i> Delivey Address</p>
                        <p class="mb-0 fw-bold" id="fullAddress"></p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <p class="fs-5">Bread Info</p>
                        <div class="address-info d-flex align-items-center gap-2 mb-3">
                            <div class="d-flex flex-grow-1">
                                <img id="imgBread" alt="bread" width="100" />
                                <div class="d-flex flex-column" style="margin-left: 20px;">
                                    <p class="m-0 fw-bold" id="breadName"></p>
                                    <p class="m-0">x <span id="breadQty"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <p class="m-0 total-amount" id="total-amount"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>