<?php
require "../controller/controller.php";

$id_siswa = $_GET['id_siswa'];

$hapusSiswa = mysqli_query($koneksi, "DELETE FROM tb_siswa WHERE id_siswa='$id_siswa'");

if(mysqli_affected_rows($koneksi)) {

    echo "<script>
        alert('Data berhasil di hapus');
        document.location.href='siswa.php';
        </script>";
} else {
    echo "<script>
        alert('Data gagal di hapus');
        document.location.href='siswa.php';
        </script>";
}

?>