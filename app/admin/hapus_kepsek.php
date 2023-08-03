<?php
require "../controller/controller.php";

$id_kepsek = $_GET['id_kepsek'];

$hapusadmin = mysqli_query($koneksi, "DELETE FROM admin WHERE id_admin='$id_kepsek'");

if(mysqli_affected_rows($koneksi)) {

    echo "<script>
        alert('Data berhasil di hapus');
        document.location.href='kepsek.php';
        </script>";
} else {
    echo "<script>
        alert('Data gagal di hapus');
        document.location.href='kepsek.php';
        </script>";
}

?>