<?php
$current_page = basename($_SERVER['PHP_SELF']); //Mengambil nama file dari halaman yang sedang diakses.
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
    <title>Barang Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="masuk.php">
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
                            Stok Barang
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
                    <h1 class="mt-4">Barang Masuk</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Barang Masuk</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Barang Masuk
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Menampilkan data -->
                                    <?php
                                    $ambildatastock = mysqli_query($conn, "select * from barangmasuk m, stockbarang s where s.id_barang = m.id_barang");
                                    while ($data = mysqli_fetch_array($ambildatastock)) {
                                        $tanggal = $data['tanggal'];
                                        $namabarang = $data['namabarang'];
                                        $qty = $data['qty'];
                                        $keterangan = $data['keterangan'];
                                        $idb = $data['id_barang'];
                                        $idm = $data['id_masuk'];

                                    ?>
                                        <tr>
                                            <td><?= $tanggal; ?></td>
                                            <td><?= $namabarang; ?></td>
                                            <td><?= $qty; ?></td>
                                            <td><?= $keterangan; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $idm; ?>">
                                                    Edit
                                                </button>

                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $idm; ?>">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?= $idm; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Barang</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body p-3 pt-0">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="inputKeterangan" name="keterangan" value="<?= $keterangan; ?>" placeholder="Keterangan" required>
                                                                <label for="inputKeterangan">Keterangan</label>
                                                            </div>

                                                            <div class="form-floating mb-3">
                                                                <input type="number" class="form-control" id="inputQty" name="qty" value="<?= $qty; ?>" placeholder="Quantity" required>
                                                                <label for="inputQty">Quantity</label>
                                                            </div>

                                                            <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                            <input type="hidden" name="idm" value="<?= $idm; ?>">
                                                            <div class="d-flex justify-content-end">
                                                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary" name="updatebarangmasuk">Edit</button>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete<?= $idm; ?>">
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
                                                            <p class="mb-3">Apakah kamu yakin ingin menghapus <strong><?= $namabarang; ?></strong>?</p>
                                                            <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                            <input type="hidden" name="kty" value="<?= $qty; ?>">
                                                            <input type="hidden" name="idm" value="<?= $idm; ?>">

                                                            <div class="d-flex justify-content-end">
                                                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-danger" name="hapusbarangmasuk">Hapus</button>
                                                            </div>
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
                <h4 class="modal-title">Tambah Barang Masuk</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <select name="barangnya" id="barangnya" class="form-select" required>
                            <option value="" disabled selected>Pilih Barang</option>
                            <?php
                            $ambildata = mysqli_query($conn, "SELECT * FROM stockbarang");
                            while ($fetcharray = mysqli_fetch_array($ambildata)) {
                                $namabarangnya = $fetcharray['namabarang'];
                                $idbarangnya = $fetcharray['id_barang'];
                            ?>
                                <option value="<?= $idbarangnya; ?>"><?= $namabarangnya; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="inputQty" name="qty" placeholder="Quantity" required>
                        <label for="inputQty">Quantity</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="inputKeterangan" name="keterangan" placeholder="Keterangan" required>
                        <label for="inputKeterangan">Keterangan</label>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" name="tambahbarangmasuk">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</html>