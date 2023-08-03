<?php
require "../controller/controller.php";

$id_guru = $_GET['id_guru'];

$hapusadmin = mysqli_query($koneksi, "DELETE FROM admin WHERE id_admin='$id_guru'");

if(mysqli_affected_rows($koneksi)) {

    echo "<script>
        alert('Data berhasil di hapus');
        document.location.href='guru.php';
        </script>";
} else {
    echo "<script>
        alert('Data gagal di hapus');
        document.location.href='guru.php';
        </script>";
}

?>