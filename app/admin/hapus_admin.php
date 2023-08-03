<?php
require "../controller/controller.php";

$id_admin = $_GET['id_admin'];

$hapusadmin = mysqli_query($koneksi, "DELETE FROM tb_admin WHERE id_admin='$id_admin'");

if(mysqli_affected_rows($koneksi)) {

    echo "<script>
        alert('Data berhasil di hapus');
        document.location.href='admin.php';
        </script>";
} else {
    echo "<script>
        alert('Data gagal di hapus');
        document.location.href='admin.php';
        </script>";
}

?>