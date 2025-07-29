<form action="modul/akun/aksi_akun.php?act=insert" method="post">
  <div class="card mb-3">
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-4">
          <label class="form-label" for="nama_akun">Nama akun</label>
          <input type="text" class="form-control" name="nama_akun" required>
        </div>
        <div class="col-md-4">
          <label class="form-label" for="jenis_akun">Jenis akun</label>
          <input type="text" class="form-control" name="jenis_akun" required>
        </div>
        <div class="col-md-4">
          <label class="form-label" for="type_saldo">Tipe Saldo</label>
          <select class="form-select" name="type_saldo" required>
            <option value="debit">Debit</option>
            <option value="kredit">Kredit</option>
          </select>
        </div>
      </div>
      <hr class="text-secondary">
      <div class="text-end">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</form>

<div class="card">
  <div class="card-header">
    <h3>Data Akun</h3>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Akun</th>
            <th>Jenis Akun</th>
            <th>Tipe Saldo</th>
            <th><i class="bi bi-gear-fill"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT * FROM akun";
          $exec = mysqli_query($koneksi, $query);
          $no = 1;
          while ($data = mysqli_fetch_array($exec)) {
          ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $data['nama_akun'] ?></td>
              <td><?= $data['jenis_akun'] ?></td>
              <td><?= $data['tipe_saldo'] ?></td>
              <td>
                <a href="#editAkun<?= $data['akun_id'] ?>" class="text-decoration-none" data-bs-toggle="modal">
                  <i class="bi bi-pencil-square text-success"></i>
                </a>
                <a href="modul/akun/aksi_akun.php?act=delete&id=<?= $data['akun_id'] ?>" class="text-decoration-none" onclick="return confirm('Yakin hapus data?')">
                  <i class="bi bi-trash text-danger"></i>
                </a>
              </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="editAkun<?= $data['akun_id'] ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
              <form action="modul/akun/aksi_akun.php?act=update&id=<?= $data['akun_id'] ?>" method="post">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5">Edit Data Akun</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label class="form-label" for="nama_akun">Nama akun</label>
                        <input type="text" class="form-control" name="nama_akun" value="<?= $data['nama_akun'] ?>" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="jenis_akun">Jenis akun</label>
                        <input type="text" class="form-control" name="jenis_akun" value="<?= $data['jenis_akun'] ?>" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="type_saldo">Tipe Saldo</label>
                        <select class="form-select" name="type_saldo" required>
                          <option value="debit" <?= $data['tipe_saldo'] == 'debit' ? 'selected' : '' ?>>Debit</option>
                          <option value="kredit" <?= $data['tipe_saldo'] == 'kredit' ? 'selected' : '' ?>>Kredit</option>
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
