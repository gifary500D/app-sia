<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/app_sia/koneksi.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$act = isset($_GET['act']) ? $_GET['act'] : '';
$id  = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($act === 'insert') {
    $invoice   = $_POST['invoice_pembelian'];
    $tanggal   = $_POST['tanggal_pembelian'];
    $supplier  = intval($_POST['supplier_id']);
    $jumlah    = intval($_POST['jumlah_pembelian']);
    $harga     = floatval($_POST['harga_pembelian']);
    $total     = floatval($_POST['total_pembelian']);
    $keterangan= $_POST['keterangan'];

    // Cek duplicate invoice (opsional)
    $cek = mysqli_query($koneksi, "SELECT * FROM pembelian WHERE invoice_pembelian='$invoice'");
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['error'] = "Invoice sudah ada!";
        header("Location: ../../dashboard.php?modul=pembelian");
        exit;
    }

    $query = "
      INSERT INTO pembelian
        (invoice_pembelian, tanggal_pembelian, supplier_id,
         jumlah_pembelian, harga_pembelian, total_pembelian, keterangan)
      VALUES
        ('$invoice', '$tanggal', $supplier, $jumlah, $harga, $total, '$keterangan')
    ";
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['pesan'] = "Data berhasil disimpan.";
    } else {
        $_SESSION['error'] = "Gagal menyimpan: " . mysqli_error($koneksi);
    }
    // **Redirect ke halaman dashboard dengan modul=pembelian**
    header("Location: ../../dashboard.php?modul=pembelian");
    exit;
}

elseif ($act === 'update' && $id > 0) {
    $tanggal   = $_POST['tanggal_pembelian'];
    $supplier  = intval($_POST['supplier_id']);
    $jumlah    = intval($_POST['jumlah_pembelian']);
    $harga     = floatval($_POST['harga_pembelian']);
    $total     = floatval($_POST['total_pembelian']);
    $keterangan= $_POST['keterangan'];

    $query = "
      UPDATE pembelian SET
        tanggal_pembelian = '$tanggal',
        supplier_id       = $supplier,
        jumlah_pembelian  = $jumlah,
        harga_pembelian   = $harga,
        total_pembelian   = $total,
        keterangan        = '$keterangan'
      WHERE pembelian_id = $id
    ";
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['pesan'] = "Data berhasil diubah.";
    } else {
        $_SESSION['error'] = "Gagal mengubah: " . mysqli_error($koneksi);
    }
    header("Location: ../../dashboard.php?modul=pembelian");
    exit;
}

elseif ($act === 'delete' && $id > 0) {
    $query = "DELETE FROM pembelian WHERE pembelian_id = $id";
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['pesan'] = "Data berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal hapus: " . mysqli_error($koneksi);
    }
    header("Location: ../../dashboard.php?modul=pembelian");
    exit;
}

else {
    $_SESSION['error'] = "Aksi tidak valid.";
    header("Location: ../../dashboard.php?modul=pembelian");
    exit;
}
