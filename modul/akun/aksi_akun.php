<?php
session_start();
include_once('../../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_akun = $_POST['nama_akun'];
    $jenis_akun = $_POST['jenis_akun'];
    $type_saldo = $_POST['type_saldo'];

    if ($_GET['act'] == "insert") {
        $query = "INSERT INTO akun (nama_akun, jenis_akun, tipe_saldo) VALUES ('$nama_akun', '$jenis_akun', '$type_saldo')";
        $exec = mysqli_query($koneksi, $query);

        $_SESSION['pesan'] = $exec ? "Data akun telah ditambahkan" : "Data akun gagal ditambahkan";
        header('location:../../dashboard.php?modul=akun');
        exit;
    }

    elseif ($_GET['act'] == "update") {
        $id = $_GET['id'];
        $query = "UPDATE akun SET nama_akun='$nama_akun', jenis_akun='$jenis_akun', tipe_saldo='$type_saldo' WHERE akun_id='$id'";
        $exec = mysqli_query($koneksi, $query);

        $_SESSION['pesan'] = $exec ? "Data akun telah diubah" : "Data akun gagal diubah";
        header('location:../../dashboard.php?modul=akun');
        exit;
    }
}

else {
    if ($_GET['act'] == "delete") {
        $id = $_GET['id'];
        $query = "DELETE FROM akun WHERE akun_id='$id'";
        $exec = mysqli_query($koneksi, $query);

        $_SESSION['pesan'] = $exec ? "Data akun telah dihapus" : "Data akun gagal dihapus";
        header('location:../../dashboard.php?modul=akun');
        exit;
    } else {
        header('location:../../index.php');
        exit;
    }
}
