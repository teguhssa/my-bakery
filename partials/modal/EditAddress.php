 <!-- modal Edit address -->
 <div class="modal fade" id="modalEditAlamat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header border-0">
                 <h5 class="modal-title" id="exampleModalLabel">Edit Address</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form action="action/address/update.php" method="post">
                     <div class="row">
                         <div class="col-lg-6 col-md-12 mb-3">
                             <input type="text" name="fullname_edit" id="fullname_edit" placeholder="Your name.." class="form-control p-3" required />
                         </div>
                         <div class="col-lg-6 col-md-12">
                             <input type="text" name="phone_number_edit" id="phone_number_edit" placeholder="Your Phone Number.." class="form-control p-3" min="0" required />
                         </div>
                     </div>
                     <div class="mb-3">
                         <select name="district_id_edit" id="district_id_edit" class="form-control district_id_edit">
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
                         <textarea name="full_address_edit" id="full_address_edit" cols="20" rows="10" class="form-control" required></textarea>
                     </div>
                     <input type="hidden" name="edit_id" id="edit_id">
                     <button class="btnAddAddress" name="btnEditAddress">Save</button>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- modal Edit address -->