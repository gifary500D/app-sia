<?php
if (isset($_SESSION['pesan'])) {
  echo "<div class='alert alert-info'>" . $_SESSION['pesan'] . "</div>";
  unset($_SESSION['pesan']);
}
?>

<form action="modul/suplier/aksi_suplier.php?act=insert" method="post">
  <div class="card mb-3">
    <div class="card-body">
      <div class="row">
        <div class="mb-3 col-md-6">
          <label for="nama_supplier" class="form-label">Nama Supplier</label>
          <input type="text" class="form-control" name="nama_supplier" required>
        </div>
        <div class="mb-3 col-md-6">
          <label for="alamat" class="form-label">Alamat</label>
          <input type="text" class="form-control" name="alamat" required>
        </div>
      </div>

      <div class="row">
        <div class="mb-3 col-md-6">
          <label for="telepon" class="form-label">Telepon</label>
          <input type="text" class="form-control" name="telepon" required>
        </div>
        <div class="mb-3 col-md-6">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" name="email" required>
        </div>
      </div>

      <div class="row">
        <div class="d-flex">
          <button type="reset" class="btn btn-secondary me-2">Reset</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</form>

<div class="card">
  <div class="card-header"><h3>Data Supplier</h3></div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Email</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT * FROM supplier";
          $exec = mysqli_query($koneksi, $query);
          $no = 1;
          while ($data = mysqli_fetch_assoc($exec)) {
          ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $data['nama_supplier'] ?></td>
              <td><?= $data['alamat'] ?></td>
              <td><?= $data['telepon'] ?></td>
              <td><?= $data['email'] ?></td>
              <td>
                <a href="#edit<?= $data['supplier_id'] ?>" data-bs-toggle="modal" class="text-success">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <a href="modul/suplier/aksi_suplier.php?act=delete&id=<?= $data['supplier_id'] ?>" class="text-danger" onclick="return confirm('Yakin hapus?')">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="edit<?= $data['supplier_id'] ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <form action="modul/suplier/aksi_suplier.php?act=update&id=<?= $data['supplier_id'] ?>" method="post">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Supplier</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label>Nama Supplier</label>
                        <input type="text" name="nama_supplier" class="form-control" value="<?= $data['nama_supplier'] ?>" required>
                      </div>
                      <div class="mb-3">
                        <label>Alamat</label>
                        <input type="text" name="alamat" class="form-control" value="<?= $data['alamat'] ?>" required>
                      </div>
                      <div class="mb-3">
                        <label>Telepon</label>
                        <input type="text" name="telepon" class="form-control" value="<?= $data['telepon'] ?>" required>
                      </div>
                      <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $data['email'] ?>" required>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
