<?php
session_start();
include_once('../../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama_supplier = $_POST['nama_supplier'] ?? '';
  $alamat        = $_POST['alamat'] ?? '';
  $telepon       = $_POST['telepon'] ?? '';
  $email         = $_POST['email'] ?? '';

  if ($_GET['act'] == 'insert') {
    // Cegah email duplikat
    $cek = mysqli_query($koneksi, "SELECT * FROM supplier WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
      $_SESSION['pesan'] = "❌ Email sudah digunakan!";
    } else {
      $sql = "INSERT INTO supplier (nama_supplier, alamat, telepon, email)
              VALUES ('$nama_supplier', '$alamat', '$telepon', '$email')";
      $exec = mysqli_query($koneksi, $sql);
      $_SESSION['pesan'] = $exec ? "✅ Supplier berhasil ditambahkan" : "❌ Gagal menambahkan supplier";
    }
    header('Location: ../../dashboard.php?modul=suplier');
    exit;

  } elseif ($_GET['act'] == 'update' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE supplier SET 
            nama_supplier='$nama_supplier',
            alamat='$alamat',
            telepon='$telepon',
            email='$email'
            WHERE supplier_id='$id'";
    $exec = mysqli_query($koneksi, $sql);
    $_SESSION['pesan'] = $exec ? "✅ Supplier berhasil diubah" : "❌ Gagal mengubah supplier";
    header('Location: ../../dashboard.php?modul=suplier');
    exit;
  }

} elseif ($_GET['act'] == 'delete' && isset($_GET['id'])) {
  $id = $_GET['id'];
  $exec = mysqli_query($koneksi, "DELETE FROM supplier WHERE supplier_id='$id'");
  $_SESSION['pesan'] = $exec ? "🗑️ Supplier berhasil dihapus" : "❌ Gagal menghapus supplier";
  header('Location: ../../dashboard.php?modul=suplier');
  exit;

} else {
  header('Location: ../../index.php');
  exit;
}
