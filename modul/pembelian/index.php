<?php
// 1. Pastikan file koneksi.php benar-benar ada di root: C:\xampp\htdocs\app_sia\koneksi.php
include_once $_SERVER['DOCUMENT_ROOT'] . "/app_sia/koneksi.php";

// 2. Hanya panggil session_start() kalau belum ada session aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- FORM UNTUK MENAMBAH DATA PEMBELIAN -->
<form action="modul/pembelian/aksi_pembelian.php?act=insert" method="post">
  <div class="card mb-3">
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-4">
          <label for="invoice" class="form-label">Invoice</label>
          <input type="text" class="form-control" name="invoice_pembelian" id="invoice" required>
        </div>
        <div class="col-md-4">
          <label for="tanggal" class="form-label">Tanggal</label>
          <input type="date" class="form-control" name="tanggal_pembelian" id="tanggal" required>
        </div>
        <div class="col-md-4">
          <label for="supplier" class="form-label">Supplier</label>
          <select name="supplier_id" class="form-select" id="supplier" required>
            <option value="">-- Pilih Supplier --</option>
            <?php
            // Ambil data supplier dari tabel supplier
            $q_sup = "SELECT supplier_id, nama_supplier FROM supplier";
            $exec_sup = mysqli_query($koneksi, $q_sup);
            while ($r_sup = mysqli_fetch_assoc($exec_sup)) {
                echo "<option value=\"{$r_sup['supplier_id']}\">{$r_sup['nama_supplier']}</option>";
            }
            ?>
          </select>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-4">
          <label for="jumlah" class="form-label">Jumlah</label>
          <input type="number" class="form-control" name="jumlah_pembelian" id="jumlah" oninput="hitungTotal();" required>
        </div>
        <div class="col-md-4">
          <label for="harga" class="form-label">Harga</label>
          <div class="input-group">
            <span class="input-group-text">Rp.</span>
            <input type="number" class="form-control" name="harga_pembelian" id="harga" oninput="hitungTotal();" required>
          </div>
        </div>
        <div class="col-md-4">
          <label for="total" class="form-label">Total</label>
          <div class="input-group">
            <span class="input-group-text">Rp.</span>
            <input type="number" class="form-control" name="total_pembelian" id="total" readonly>
          </div>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-12">
          <label for="keterangan" class="form-label">Keterangan</label>
          <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
        </div>
      </div>

      <div class="d-flex">
        <span class="me-auto text-gray">
          <?php
          if (isset($_SESSION['pesan'])) {
            echo $_SESSION['pesan'];
            unset($_SESSION['pesan']);
          }
          if (isset($_SESSION['error'])) {
            echo "<span class='text-danger'>" . $_SESSION['error'] . "</span>";
            unset($_SESSION['error']);
          }
          ?>
        </span>
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</form>

<!-- TABEL DATA PEMBELIAN -->
<div class="card mt-4">
  <div class="card-header">
    <h3>Data Pembelian</h3>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Invoice</th>
            <th>Tanggal</th>
            <th>Supplier</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Keterangan</th>
            <th><i class="bi bi-gear-fill"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Query sudah diperbaiki: gunakan a.pembelian_id, join ON a.supplier_id = b.supplier_id
          $query = "
            SELECT 
              a.pembelian_id      AS id_pembelian,
              a.invoice_pembelian AS invoice,
              a.tanggal_pembelian AS tanggal,
              b.supplier_id       AS id_supplier,
              b.nama_supplier     AS nama_supplier,
              a.jumlah_pembelian  AS jumlah,
              a.harga_pembelian   AS harga,
              a.total_pembelian   AS total,
              a.keterangan        AS keterangan
            FROM pembelian a
            INNER JOIN supplier b 
              ON a.supplier_id = b.supplier_id
          ";
          $exec = mysqli_query($koneksi, $query);
          $no = 0;
          while ($row = mysqli_fetch_assoc($exec)) {
            $no++;
          ?>
            <tr>
              <td><?= $no ?></td>
              <td><?= htmlspecialchars($row['invoice']) ?></td>
              <td><?= htmlspecialchars($row['tanggal']) ?></td>
              <td><?= htmlspecialchars($row['nama_supplier']) ?></td>
              <td><?= htmlspecialchars($row['jumlah']) ?></td>
              <td><?= "Rp. " . number_format($row['harga'], 2, ',', '.') ?></td>
              <td><?= "Rp. " . number_format($row['total'], 2, ',', '.') ?></td>
              <td><?= htmlspecialchars($row['keterangan']) ?></td>
              <td>
                <!-- Tombol Edit: memanggil modal dengan id unik -->
                <a href="#editPembelian<?= $row['id_pembelian'] ?>" class="text-decoration-none" data-bs-toggle="modal">
                  <i class="bi bi-pencil-square text-success"></i>
                </a>
                <!-- Tombol Delete: menuju aksi delete -->
                <a href="modul/pembelian/aksi_pembelian.php?act=delete&id=<?= $row['id_pembelian'] ?>" class="text-decoration-none" onclick="return confirm('Yakin ingin hapus data?');">
                  <i class="bi bi-trash text-danger"></i>
                </a>
              </td>
            </tr>

            <!-- Modal Edit untuk baris ini -->
            <div class="modal fade" id="editPembelian<?= $row['id_pembelian'] ?>" tabindex="-1" aria-labelledby="editPembelianLabel<?= $row['id_pembelian'] ?>" aria-hidden="true">
              <form action="modul/pembelian/aksi_pembelian.php?act=update&id=<?= $row['id_pembelian'] ?>" method="post">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editPembelianLabel<?= $row['id_pembelian'] ?>">Edit Data Pembelian</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row mb-3">
                        <div class="col-md-4">
                          <label class="form-label">Invoice</label>
                          <!-- Invoice readonly, tidak bisa diubah -->
                          <input type="text" class="form-control" name="invoice_pembelian" value="<?= htmlspecialchars($row['invoice']) ?>" readonly>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Tanggal</label>
                          <input type="date" class="form-control" name="tanggal_pembelian" value="<?= htmlspecialchars($row['tanggal']) ?>" required>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Supplier</label>
                          <select name="supplier_id" class="form-select" required>
                            <?php
                            // Tampilkan semua supplier, pilih yang sesuai dengan $row['id_supplier']
                            $q_sup2 = "SELECT supplier_id, nama_supplier FROM supplier";
                            $exec_sup2 = mysqli_query($koneksi, $q_sup2);
                            while ($r_sup2 = mysqli_fetch_assoc($exec_sup2)) {
                              $selected = ($r_sup2['supplier_id'] == $row['id_supplier']) ? 'selected' : '';
                              echo "<option value=\"{$r_sup2['supplier_id']}\" $selected>{$r_sup2['nama_supplier']}</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-md-4">
                          <label class="form-label">Jumlah</label>
                          <input type="number" class="form-control" name="jumlah_pembelian" id="jumlah_edit_<?= $row['id_pembelian'] ?>" value="<?= htmlspecialchars($row['jumlah']) ?>" oninput="hitungTotalEdit(<?= $row['id_pembelian'] ?>);" required>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Harga</label>
                          <div class="input-group">
                            <span class="input-group-text">Rp.</span>
                            <input type="number" class="form-control" name="harga_pembelian" id="harga_edit_<?= $row['id_pembelian'] ?>" value="<?= htmlspecialchars($row['harga']) ?>" oninput="hitungTotalEdit(<?= $row['id_pembelian'] ?>);" required>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Total</label>
                          <div class="input-group">
                            <span class="input-group-text">Rp.</span>
                            <input type="number" class="form-control" name="total_pembelian" id="total_edit_<?= $row['id_pembelian'] ?>" value="<?= htmlspecialchars($row['total']) ?>" readonly>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <label class="form-label">Keterangan</label>
                          <textarea name="keterangan" class="form-control"><?= htmlspecialchars($row['keterangan']) ?></textarea>
                        </div>
                      </div>
                    </div> <!-- /.modal-body -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </div> <!-- /.modal-content -->
                </div> <!-- /.modal-dialog -->
              </form>
            </div> <!-- /.modal -->
          <?php } // End while ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
// Fungsi untuk hitung total di form tambah
function hitungTotal() {
  let jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
  let harga  = parseFloat(document.getElementById('harga').value)  || 0;
  document.getElementById('total').value = jumlah * harga;
}

// Fungsi untuk hitung total di form edit (setiap baris memiliki id unik)
function hitungTotalEdit(id) {
  let jumlah = parseFloat(document.getElementById('jumlah_edit_' + id).value) || 0;
  let harga  = parseFloat(document.getElementById('harga_edit_' + id).value)  || 0;
  document.getElementById('total_edit_' + id).value = jumlah * harga;
}
</script>
