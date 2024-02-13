<div class="modal fade" id="AddKategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="action/kategori-roti/tambah.php" method="post">
            <div class="mb-3">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" class="form-control" name="nama_kategori" required />
            </div>
            <button name="btnAddKategori" class="btn btn-success">Simpan Kategori</button>
        </form>
      </div>
    </div>
  </div>
</div>  