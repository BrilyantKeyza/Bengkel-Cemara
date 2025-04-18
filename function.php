<?php
session_start();
//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "stockbarangbengkel");

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';


if (isset($_POST['tambahbarangbaru'])) {
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $kode = $_POST['kode'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];

    $addtotable = mysqli_query($conn, "INSERT INTO stockbarang (namabarang, deskripsi, kode, stock, harga) VALUES('$namabarang', '$deskripsi', '$kode', '$stock', '$harga')");

    if ($addtotable) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: "Barang berhasil ditambahkan",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#0d6efd"
                }).then(() => {
                    window.location.href = "stock.php";
                });
            });
        </script>';
    } else {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: "Barang gagal ditambahkan",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#dc3545"
                }).then(() => {
                    window.location.href = "stock.php";
                });
            });
        </script>';
    }
}


if (isset($_POST['tambahbarangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $cekstockbarang = mysqli_query($conn, "select * from stockbarang where id_barang= '$barangnya'");
    $ambildata = mysqli_fetch_array($cekstockbarang);

    $stocksekarang = $ambildata['stock'];
    $tambahstockdenganquantity = $stocksekarang + $qty;

    $addtomasuk = mysqli_query($conn, "insert into barangmasuk (id_barang, keterangan, qty) values('$barangnya', '$keterangan', '$qty')");
    $updatestockmasuk = mysqli_query($conn, "update stockbarang set stock= '$tambahstockdenganquantity' where id_barang='$barangnya'");
    if ($addtomasuk && $updatestockmasuk) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: "Stock berhasil ditambahkan",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#0d6efd"
                }).then(() => {
                    window.location.href = "masuk.php";
                });
            });
        </script>';
    } else {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: "Stock gagal ditambahkan",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#dc3545"
                }).then(() => {
                    window.location.href = "masuk.php";
                });
            });
        </script>';
    }
}



if (isset($_POST['tambahbarangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstockbarang = mysqli_query($conn, "select * from stockbarang where id_barang= '$barangnya'");
    $ambildata = mysqli_fetch_array($cekstockbarang);

    $stocksekarang = $ambildata['stock'];

    if ($stocksekarang >= $qty) {
        $tambahstockdenganquantity = $stocksekarang - $qty;

        $addtokeluar = mysqli_query($conn, "insert into barangkeluar (id_barang, penerima, qty) values('$barangnya', '$penerima', '$qty')");
        $updatestockkeluar = mysqli_query($conn, "update stockbarang set stock= '$tambahstockdenganquantity' where id_barang='$barangnya'");
        if ($addtokeluar && $updatestockkeluar) {
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: "Stok berhasil dikurangi!",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#0d6efd"
                    }).then(() => {
                        window.location.href = "keluar.php";
                    });
                });
            </script>';
        } else {
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal!",
                        text: "Stok gagal dikurangi!",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#dc3545"
                    }).then(() => {
                        window.location.href = "keluar.php";
                    });
                });
            </script>';
        }
    } else {
        // Jika stok tidak mencukupi
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "warning",
                    title: "Gagal!",
                    text: "Stock saat ini tidak mencukupi",
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    confirmButtonColor: "#dc3545"
                }).then(() => {
                    window.location.href = "keluar.php";
                });
            });
        </script>';
    }
}


//Edit stock
if (isset($_POST['updatebarang'])) {
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $kode = $_POST['kode'];
    $harga = $_POST['harga'];

    $update = mysqli_query($conn, "update stockbarang set namabarang='$namabarang', deskripsi='$deskripsi', kode='$kode', harga='$harga' where id_barang = '$idb'");
    if ($update) {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "Barang berhasil diedit",
                confirmButtonText: "OK",
                confirmButtonColor: "#0d6efd"
            }).then(() => {
                window.location.href = "stock.php";
            });
        });
    </script>';
    } else {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: "Barang gagal diedit",
                confirmButtonText: "OK",
                confirmButtonColor: "#dc3545"
            }).then(() => {
                window.location.href = "stock.php";
            });
        });
    </script>';
    }
}

//hapus stock
if (isset($_POST['hapusbarang'])) {
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from stockbarang where id_barang='$idb'");
    if ($hapus) {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "Barang berhasil dihapus",
                confirmButtonText: "OK",
                confirmButtonColor: "#0d6efd"
            }).then(() => {
                window.location.href = "stock.php";
            });
        });
    </script>';
    } else {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: "Barang gagal dihapus",
                confirmButtonText: "OK",
                confirmButtonColor: "#dc3545"
            }).then(() => {
                window.location.href = "stock.php";
            });
        });
    </script>';
    }
};



//Edit barang masuk
if (isset($_POST['updatebarangmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    //Melihat stock sekarang
    $lihatstock = mysqli_query($conn, "select * from stockbarang where id_barang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stocknow = $stocknya['stock'];

    //Melihat qty sekarang
    $qtynow = mysqli_query($conn, "select * from barangmasuk where id_masuk='$idm'");
    $qtynya = mysqli_fetch_array($qtynow);
    $qtynow = $qtynya['qty'];

    //Mengurangi stock di stockbarang
    if ($qty > $qtynow) {
        $selisih = $qty - $qtynow;
        $kurangin = $stocknow + $selisih; //
        $kuranginstock = mysqli_query($conn, "update stockbarang set stock='$kurangin' where id_barang='$idb'");
        $updatenya = mysqli_query($conn, "update barangmasuk set qty='$qty', keterangan='$deskripsi' where id_masuk='$idm'");
        if ($kuranginstock && $updatenya) {
            echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "Barang berhasil diedit",
                confirmButtonText: "OK",
                confirmButtonColor: "#0d6efd"
            }).then(() => {
                window.location.href = "masuk.php";
            });
        });
    </script>';
        } else {
            echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: "Barang gagal diedit",
                confirmButtonText: "OK",
                confirmButtonColor: "#dc3545"
            }).then(() => {
                window.location.href = "masuk.php";
            });
        });
    </script>';
        }
    } else {
        $selisih = $qtynow - $qty;
        $kurangin = $stocknow - $selisih;
        $kuranginstock = mysqli_query($conn, "update stockbarang set stock='$kurangin'where id_barang='$idb'");
        $updatenya = mysqli_query($conn, "update barangmasuk set qty='$qty', keterangan='$deskripsi' where id_masuk='$idm'");
        if ($kuranginstock && $updatenya) {
            echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: "Barang berhasil diedit",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#0d6efd"
                }).then(() => {
                    window.location.href = "masuk.php";
                });
            });
        </script>';
        } else {
            echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: "Barang gagal diedit",
                confirmButtonText: "OK",
                confirmButtonColor: "#dc3545"
            }).then(() => {
                window.location.href = "masuk.php";
            });
        });
    </script>';
        }
    }
}



//Menghapus barang masuk
if (isset($_POST['hapusbarangmasuk'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "select * from stockbarang where id_barang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok - $qty;

    $update = mysqli_query($conn, "update stockbarang set stock='$selisih' where id_barang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from barangmasuk where id_masuk='$idm'");

    if ($update && $hapusdata) {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "Barang berhasil dihapus",
                confirmButtonText: "OK",
                confirmButtonColor: "#0d6efd"
            }).then(() => {
                window.location.href = "masuk.php";
            });
        });
    </script>';
    } else {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: "Barang gagal dihapus",
                confirmButtonText: "OK",
                confirmButtonColor: "#dc3545"
            }).then(() => {
                window.location.href = "masuk.php";
            });
        });
    </script>';
    }
}



//Edit barang keluar 
if (isset($_POST['updatebarangkeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    //Melihat stock sekarang
    $lihatstock = mysqli_query($conn, "select * from stockbarang where id_barang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stocknow = $stocknya['stock'];

    //Melihat qty sekarang
    $qtynow = mysqli_query($conn, "select * from barangkeluar where id_keluar='$idk'");
    $qtynya = mysqli_fetch_array($qtynow);
    $qtynow = $qtynya['qty'];

    //Mengurangi stock di stockbarang
    if ($qty > $qtynow) {
        $selisih = $qty - $qtynow;
        $kurangin = $stocknow - $selisih;
        $kuranginstock = mysqli_query($conn, "update stockbarang set stock='$kurangin' where id_barang='$idb'");
        $updatenya = mysqli_query($conn, "update barangkeluar set qty='$qty', penerima='$penerima' where id_keluar='$idk'");
        if ($kuranginstock && $updatenya) {
            echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "Barang berhasil diedit",
                confirmButtonText: "OK",
                confirmButtonColor: "#0d6efd"
            }).then(() => {
                window.location.href = "keluar.php";
            });
        });
    </script>';
        } else {
            echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: "Barang gagal diedit",
                confirmButtonText: "OK",
                confirmButtonColor: "#dc3545"
            }).then(() => {
                window.location.href = "masuk.php";
            });
        });
    </script>';
        }
    } else {
        $selisih = $qtynow - $qty;
        $kurangin = $stocknow + $selisih;
        $kuranginstock = mysqli_query($conn, "update stockbarang set stock='$kurangin' where id_barang='$idb'");
        $updatenya = mysqli_query($conn, "update barangkeluar set qty='$qty', penerima='$penerima' where id_keluar='$idk'");
        if ($kuranginstock && $updatenya) {
            echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "Barang berhasil diedit",
                confirmButtonText: "OK",
                confirmButtonColor: "#0d6efd"
            }).then(() => {
                window.location.href = "keluar.php";
            });
        });
    </script>';
        } else {
            echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: "Barang gagal diedit",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#dc3545"
                }).then(() => {
                    window.location.href = "masuk.php";
                });
            });
        </script>';
        }
    }
}



//Menghapus barang keluar
if (isset($_POST['hapusbarangkeluar'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn, "select * from stockbarang where id_barang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok + $qty;

    $update = mysqli_query($conn, "update stockbarang set stock='$selisih' where id_barang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from barangkeluar where id_keluar='$idk'");

    if ($update && $hapusdata) {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "Barang berhasil dihapus",
                confirmButtonText: "OK",
                confirmButtonColor: "#0d6efd"
            }).then(() => {
                window.location.href = "keluar.php";
            });
        });
    </script>';
    } else {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: "Barang gagal dihapus",
                confirmButtonText: "OK",
                confirmButtonColor: "#dc3545"
            }).then(() => {
                window.location.href = "keluar.php";
            });
        });
    </script>';
    }
}
