<div class="modal fade" id="EditKategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="action/kategori-roti/edit.php" method="post">
            <div class="mb-3">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" class="form-control" name="nama_kategori_edit" id="nama_kategori_edit" required />
                <input type="hidden" name="id" id="id">
            </div>
            <button name="btnEditKategori" class="btn btn-success">Edit Kategori</button>
        </form>
      </div>
    </div>
  </div>
</div>  