<?php

require "../controller/controller.php";


$dataSiswa = mysqli_query($koneksi, "SELECT * FROM tb_siswa");


foreach ($dataSiswa as $siswa) {

    $id_siswa = $siswa['id_siswa'];
    $ratingNilaiSiswa = mysqli_query($koneksi, "SELECT * FROM tb_rating_kecocokan INNER JOIN tb_siswa ON tb_rating_kecocokan.id_siswa = tb_siswa.id_siswa WHERE tb_rating_kecocokan.id_siswa='$id_siswa'");    
    
    $nilaiSiswa = mysqli_fetch_array($ratingNilaiSiswa);
    
    
}





?>