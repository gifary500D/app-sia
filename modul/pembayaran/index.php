<div class="card mb-3">
    <div class="card-body">
        <form action="modul/pembayaran/aksi_pembayaran.php?act=insert" method="post">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="invoice_pembayaran" class="form-label">Invoice</label>
                    <input type="text" class="form-control" name="invoice_pembayaran" id="invoice_pembayaran" required>
                </div>
                <div class="col-md-6">
                    <label for="tanggal_pembayaran" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal_pembayaran" id="tanggal_pembayaran" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="total_pembayaran" class="form-label">Total</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input type="number" class="form-control" name="total_pembayaran" id="total_pembayaran" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" name="keterangan" id="keterangan">
                </div>
            </div>
            <div class="row">
                <div class="d-flex">
                    <span class="me-auto text-gray">
                        <?php
                        if (isset($_SESSION['pesan'])) {
                            echo '<span class="text-success">' . $_SESSION['pesan'] . '</span>';
                            unset($_SESSION['pesan']);
                        }
                        if (isset($_SESSION['error'])) {
                            echo '<span class="text-danger">' . $_SESSION['error'] . '</span>';
                            unset($_SESSION['error']);
                        }
                        ?>
                    </span>
                    <button type="reset" class="btn btn-secondary me-2">Reset</button>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Data Pembayaran</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Keterangan</th>
                        <th><i class="bi bi-gear-fill"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($koneksi, "SELECT * FROM pembayaran ORDER BY pembayaran_id DESC");
                    $no = 0;
                    while ($row = mysqli_fetch_array($query)) {
                        $no++;
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= htmlspecialchars($row['invoice_pembayaran']) ?></td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal_pembayaran'])) ?></td>
                        <td><?= "Rp. " . number_format($row['total_pembayaran'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($row['keterangan']) ?></td>
                        <td>
                            <a href="#editPembayaran<?= $row['pembayaran_id'] ?>" class="text-decoration-none me-2" data-bs-toggle="modal">
                                <i class="bi bi-pencil-square text-success"></i>
                            </a>
                            <a href="modul/pembayaran/aksi_pembayaran.php?act=delete&id=<?= $row['pembayaran_id']; ?>" class="text-decoration-none" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="bi bi-trash text-danger"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editPembayaran<?= $row['pembayaran_id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['pembayaran_id'] ?>" aria-hidden="true">
                        <form action="modul/pembayaran/aksi_pembayaran.php?act=update&id=<?= $row['pembayaran_id'] ?>" method="post">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editModalLabel<?= $row['pembayaran_id'] ?>">Edit Data Pembayaran</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="edit_invoice_pembayaran<?= $row['pembayaran_id'] ?>" class="form-label">Invoice</label>
                                                <input type="text" class="form-control" name="invoice_pembayaran" id="edit_invoice_pembayaran<?= $row['pembayaran_id'] ?>" value="<?= htmlspecialchars($row['invoice_pembayaran']) ?>" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="edit_tanggal_pembayaran<?= $row['pembayaran_id'] ?>" class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" name="tanggal_pembayaran" id="edit_tanggal_pembayaran<?= $row['pembayaran_id'] ?>" value="<?= $row['tanggal_pembayaran'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="edit_total_pembayaran<?= $row['pembayaran_id'] ?>" class="form-label">Total</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="number" class="form-control" name="total_pembayaran" id="edit_total_pembayaran<?= $row['pembayaran_id'] ?>" value="<?= $row['total_pembayaran'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="edit_keterangan<?= $row['pembayaran_id'] ?>" class="form-label">Keterangan</label>
                                                <input type="text" class="form-control" name="keterangan" id="edit_keterangan<?= $row['pembayaran_id'] ?>" value="<?= htmlspecialchars($row['keterangan']) ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="update" class="btn btn-primary">Simpan</button>
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