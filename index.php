<?php
session_start();
if(isset($_SESSION['username'])){
    header('location:dashboard.php');
    exit();
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SIA | Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
    </head>
    <body class="bg-secondary">
        <div class="container">
            <div class="row">
                <div class="col-md-4 m-auto mt-5 shadow p-3 bg-white">
                    <form action="authentication.php" method="post">
                        <h3 class="text-center">Login System</h3>
                        <hr>
                        <?php
                        if(isset($_SESSION['pesan'])){
                            echo '<div class="alert alert-danger">' . $_SESSION['pesan'] . '</div>';
                            unset($_SESSION['pesan']); // Hapus pesan setelah ditampilkan
                        }
                        ?>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="bi bi-key-fill"></i>
                            </span>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="mb-3 d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <small>Aplikasi Sistem Informasi Akuntansi | 2024</small>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>