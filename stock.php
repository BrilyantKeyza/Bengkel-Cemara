<?php
$current_page = basename($_SERVER['PHP_SELF']);
require 'function.php';
require 'cek.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="stock.php">
        Cemara Admin
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fa-solid fa-bars-staggered"></i></button>
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
                    <h1 class="mt-4">Stock Barang</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Stock Barang</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Barang
                            </button>
                        </div>
                        <div class="card-body">

                            <?php
                            $ambildatastock = mysqli_query($conn, "select * from stockbarang where stock < 1");

                            while ($fetch = mysqli_fetch_array($ambildatastock)) {
                                $barang = $fetch['namabarang'];
                            ?>
                                <!-- Alert -->
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    <strong>Peringatan!</strong> Stock Barang <?= $barang; ?> Habis
                                </div>

                            <?php
                            }
                            ?>

                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Deskripsi</th>
                                        <th>Kode</th>
                                        <th>Stock</th>
                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Menampilkan data -->
                                    <?php
                                    $ambildatastock = mysqli_query($conn, "select * from stockbarang");
                                    $i = 1;
                                    while ($data = mysqli_fetch_array($ambildatastock)) {
                                        $namabarang = $data['namabarang'];
                                        $deskripsi = $data['deskripsi'];
                                        $kode = $data['kode'];
                                        $stock = $data['stock'];
                                        $idb = $data['id_barang'];

                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $namabarang; ?></td>
                                            <td><?= $deskripsi; ?></td>
                                            <td><?= $kode; ?></td>
                                            <td><?= $stock; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $idb; ?>">
                                                    Edit
                                                </button>

                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $idb; ?>">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?= $idb; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Barang</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <input type="text" name="namabarang" value="<?= $namabarang; ?>" class="form-control" required>
                                                            <br>
                                                            <input type="text" name="deskripsi" value="<?= $deskripsi; ?>" class="form-control" required>
                                                            <br>
                                                            <input type="number" name="kode" value="<?= $kode; ?>" class="form-control" required>
                                                            <br>
                                                            <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                            <button type="submit" class="btn btn-primary" name="updatebarang">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete<?= $idb; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Barang</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin mengapus <?= $namabarang; ?> ?
                                                            <br>
                                                            <br>
                                                            <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                            <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    };

                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Barang</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control" required>
                    <br>
                    <input type="text" name="deskripsi" placeholder="Deskripsi" class="form-control" required>
                    <br>
                    <input type="number" name="kode" placeholder="Kode" class="form-control" required>
                    <br>
                    <input type="number" name="stock" placeholder="Stock" class="form-control" required>
                    <br>
                    <button type="submit" class="btn btn-primary" name="tambahbarangbaru">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

</html>