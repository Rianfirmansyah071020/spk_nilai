<?php
require "../controller/controller.php";

$id_nilai = $_GET['id_nilai'];

$hapusNilai = mysqli_query($koneksi, "DELETE FROM tb_nilai WHERE id_nilai='$id_nilai'");
$hapusRating = mysqli_query($koneksi, "DELETE FROM tb_rating_kecocokan WHERE id_nilai='$id_nilai'");

if(mysqli_affected_rows($koneksi)) {

    echo "<script>
        alert('Data berhasil di hapus');
        document.location.href='nilai.php';
        </script>";
} else {
    echo "<script>
        alert('Data gagal di hapus');
        document.location.href='nilai.php';
        </script>";
}

?>