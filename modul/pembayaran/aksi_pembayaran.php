<?php
session_start();
require_once '../../koneksi.php'; // sesuaikan path koneksi.php kamu

// Fungsi untuk membersihkan input
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $invoice_pembayaran = cleanInput($_POST['invoice_pembayaran']);
    $tanggal_pembayaran = cleanInput($_POST['tanggal_pembayaran']);
    $total_pembayaran = cleanInput($_POST['total_pembayaran']);
    $keterangan = cleanInput($_POST['keterangan']);
    
    // Validasi input
    if(empty($invoice_pembayaran) || empty($tanggal_pembayaran) || empty($total_pembayaran)) {
        $_SESSION['error'] = "Invoice, tanggal, dan total harus diisi!";
        header('location:../../dashboard.php?modul=pembayaran');
        exit();
    }
    
    if(!is_numeric($total_pembayaran) || $total_pembayaran <= 0) {
        $_SESSION['error'] = "Total pembayaran harus berupa angka positif!";
        header('location:../../dashboard.php?modul=pembayaran');
        exit();
    }
    
    if($_GET['act'] == "insert"){
        // Cek apakah invoice sudah ada
        $check_query = "SELECT * FROM pembayaran WHERE invoice_pembayaran = ?";
        $check_stmt = mysqli_prepare($koneksi, $check_query);
        mysqli_stmt_bind_param($check_stmt, "s", $invoice_pembayaran);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);
        
        if(mysqli_num_rows($check_result) > 0) {
            $_SESSION['error'] = "Invoice sudah ada! Gunakan invoice yang berbeda.";
            header('location:../../dashboard.php?modul=pembayaran');
            exit();
        }
        
        $query = "INSERT INTO pembayaran (invoice_pembayaran, tanggal_pembayaran, total_pembayaran, keterangan) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "ssds", $invoice_pembayaran, $tanggal_pembayaran, $total_pembayaran, $keterangan);
        $exec = mysqli_stmt_execute($stmt);
        
        if($exec){
            $_SESSION['pesan'] = "Data pembayaran telah ditambahkan";
            header('location:../../dashboard.php?modul=pembayaran');
        }else{
            $_SESSION['error'] = "Data pembayaran gagal ditambahkan: " . mysqli_error($koneksi);
            header('location:../../dashboard.php?modul=pembayaran');
        }
        mysqli_stmt_close($stmt);
        
    }elseif($_GET['act'] == "update"){
        $id = cleanInput($_GET['id']);
        
        if(!is_numeric($id)) {
            $_SESSION['error'] = "ID tidak valid!";
            header('location:../../dashboard.php?modul=pembayaran');
            exit();
        }
        
        $query = "UPDATE pembayaran SET tanggal_pembayaran = ?, total_pembayaran = ?, keterangan = ? WHERE pembayaran_id = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "sdsi", $tanggal_pembayaran, $total_pembayaran, $keterangan, $id);
        $exec = mysqli_stmt_execute($stmt);
        
        if($exec){
            if(mysqli_stmt_affected_rows($stmt) > 0) {
                $_SESSION['pesan'] = "Data pembayaran telah diubah";
            } else {
                $_SESSION['error'] = "Tidak ada perubahan data atau data tidak ditemukan";
            }
            header('location:../../dashboard.php?modul=pembayaran');
        }else{
            $_SESSION['error'] = "Data pembayaran gagal diubah: " . mysqli_error($koneksi);
            header('location:../../dashboard.php?modul=pembayaran');
        }
        mysqli_stmt_close($stmt);
    }
}else{
    if(isset($_GET['act']) && $_GET['act'] == "delete"){
        $id = cleanInput($_GET['id']);
        
        if(!is_numeric($id)) {
            $_SESSION['error'] = "ID tidak valid!";
            header('location:../../dashboard.php?modul=pembayaran');
            exit();
        }
        
        $query = "DELETE FROM pembayaran WHERE pembayaran_id = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        $exec = mysqli_stmt_execute($stmt);
        
        if($exec){
            if(mysqli_stmt_affected_rows($stmt) > 0) {
                $_SESSION['pesan'] = "Data pembayaran telah dihapus";
            } else {
                $_SESSION['error'] = "Data tidak ditemukan atau sudah terhapus";
            }
            header('location:../../dashboard.php?modul=pembayaran');
        }else{
            $_SESSION['error'] = "Data pembayaran gagal dihapus: " . mysqli_error($koneksi);
            header('location:../../dashboard.php?modul=pembayaran');
        }
        mysqli_stmt_close($stmt);
    }
}

// Tutup koneksi database
mysqli_close($koneksi);
?>