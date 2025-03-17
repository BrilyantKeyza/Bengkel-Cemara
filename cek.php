<?php

//agar tidak bisa langsung ke halaman admin sebelum login
if(isset($_SESSION['log'])){

}
else {
    header('location:login.php');
}

?>