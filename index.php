<?php
$current_page = basename($_SERVER['PHP_SELF']); //Mengambil nama file dari halaman yang sedang diakses.
require 'function.php';
require 'cek.php';

// Mengambil jumlah barang berdasarkan ID barang
$ambildatabarang = mysqli_query($conn, "SELECT COUNT(id_barang) as jumlah_barang FROM stockbarang");
$data = mysqli_fetch_assoc($ambildatabarang);
$jumlahBarang = $data['jumlah_barang'];


// Query untuk menghitung jumlah data transaksi barang masuk
$queryJumlahDataMasuk = "SELECT COUNT(*) AS total_data_masuk FROM barangmasuk";
$result = mysqli_query($conn, $queryJumlahDataMasuk);
$row = mysqli_fetch_assoc($result);
$jumlahDataMasuk = $row['total_data_masuk'];

// Query untuk menghitung jumlah data transaksi barang keluar
$queryJumlahDataKeluar = "SELECT COUNT(*) AS total_data_keluar FROM barangkeluar";
$result = mysqli_query($conn, $queryJumlahDataKeluar);
$row = mysqli_fetch_assoc($result);
$jumlahDataKeluar = $row['total_data_keluar'];



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">
        <i class="fa-solid fa-screwdriver-wrench"></i> Cemara Admin
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fa-solid fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Perintah</div>
                        <a class="nav-link <?= ($current_page == 'stock.php') ? 'active' : '' ?>" href="stock.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-box"></i></div>
                            Stock Barang
                        </a>
                        <a class="nav-link <?= ($current_page == 'masuk.php') ? 'active' : '' ?>" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-fw fa-sign-in-alt"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link <?= ($current_page == 'keluar.php') ? 'active' : '' ?>" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-fw fa-sign-out-alt"></i></div>
                            Barang Keluar
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>

                    <div class="row">

                        <!-- Kartu Jumlah Barang -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Jumlah Barang :</h5>
                                    <h2 class="mb-0"><?= $jumlahBarang; ?></h2> <!-- Menampilkan jumlah barang -->
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="stock.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <!-- Kartu Jumlah Barang Masuk -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Barang Masuk :</h5>
                                    <h2 class="mb-0"><?= $jumlahDataMasuk; ?></h2> <!-- Menampilkan jumlah barang masuk -->
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="masuk.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Barang Keluar :</h5>
                                    <h2 class="mb-0"><?= $jumlahDataKeluar; ?></h2> <!-- Menampilkan jumlah barang keluar -->
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="keluar.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>