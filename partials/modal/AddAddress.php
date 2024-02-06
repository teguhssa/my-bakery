 <!-- modal tambah address -->
 <div class="modal fade" id="modalTambahAlamat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header border-0">
                 <h5 class="modal-title" id="exampleModalLabel">New Address</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form action="action/address/add.php" method="post">
                     <div class="row">
                         <div class="col-lg-6 col-md-12 mb-3">
                             <input type="text" name="fullname" id="fullname" placeholder="Your name.." class="form-control p-3" required />
                         </div>
                         <div class="col-lg-6 col-md-12">
                             <input type="number" name="phone_number" id="phone_number" placeholder="Your Phone Number.." class="form-control" required />
                         </div>
                     </div>
                     <div class="mb-3">
                         <input type="text" name="city" id="city" class="form-control p-3" placeholder="Your City..." value="bogor" disabled />
                     </div>
                     <div class="mb-3">
                         <select name="district_id" id="district_id" class="form-control">
                             <?php
                                foreach ($dataDistrict as $data) {
                                    echo "
                                        <option value=" . $data['id'] . ">" . $data['district'] . "</option>
                                        ";
                                }
                                ?>
                         </select>
                     </div>
                     <div class="mb-3">
                         <textarea name="full_address" id="full_address" cols="20" rows="10" class="form-control" required></textarea>
                     </div>
                     <button class="btnAddAddress" name="btnAddress">Save</button>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- modal tambah address -->