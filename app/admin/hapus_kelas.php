<?php
require "../controller/controller.php";

$id_kelas = $_GET['id_kelas'];

$hapuskelas = mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas='$id_kelas'");

if(mysqli_affected_rows($koneksi)) {

    echo "<script>
        alert('Data berhasil di hapus');
        document.location.href='kelas.php';
        </script>";
} else {
    echo "<script>
        alert('Data gagal di hapus');
        document.location.href='kelas.php';
        </script>";
}

?>