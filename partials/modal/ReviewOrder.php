<div class="modal fade" id="modalReview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Review Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="d-flex flex-grow-1">
                            <img id="bakeryImg" alt="bakery_img" width="100" />
                            <div class="d-flex flex-column" style="margin-left: 20px;">
                                <p class="m-0 fw-bold" id="bakeryName"></p>
                                <p class="m-0">x <span id="bakeryQty"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="star-wrapper"></div>
                <div id="review-wrapper">
                    <h4 class="text-center">
                        <p class="mb-0">Your Star</p>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                    </h4>
                    <textarea rows="3" class="form-control mb-3 review-desc" placeholder="Your review..." name="desc"></textarea>
                    <input type="hidden" name="order_id" class="order_id" id="order_id" />
                    <input type="hidden" name="bakery_id" id="bakery_id" class="bakery_id" />
                    <button class="btn btn-warning text-white w-100 btnSubmitReview" id="btnSubmitReview">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>