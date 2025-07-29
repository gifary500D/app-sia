<?php
include_once "koneksi.php";
$password = password_hash('123', PASSWORD_BCRYPT);
$query = "INSERT INTO pengguna (
    username,
    password,
    nama_lengkap,
    email,
    jabatan,
    hak_akses
    )
    VALUES (
        'melva',
        '$password',
        'melva',
        'melva@gmail.com',
        'admn',
        'admin'
    ), 
    (
        'Nur_siti',
        '$password',
        'Siti',
        'Sitin@gmail.com',
        'admn',
        'admin'
        ),
         (
        'Inka',
        '$password',
        'Inka',
        'Inka@gmail.com',
        'admn',
        'admin'
        ),
         (
        'Cindy',
        '$password',
        'Cindy',
        'Cindu@gmail.com',
        'admn',
        'admin'
        )
    ";
    if($koneksi->query($query)){
        echo "Data user berhasil di tambah";
    }else{
        echo "Data user gagal di tambah";
    }
    mysqli_close($koneksi);
    ?>