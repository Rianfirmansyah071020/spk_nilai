<?php


$koneksi = mysqli_connect('localhost', 'root', '', 'siswa_prestasi');

// login pengguna
function login_pengguna($data)
{
    global $koneksi;

    $username = htmlspecialchars($data['username']);
    $password = htmlspecialchars($data['password']);    

    $cekJumlahData = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$username'"));

    if($cekJumlahData === 1) {

        session_start();
        $dataPengguna = mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$username'");
        $dataPenggunaArray = mysqli_fetch_array($dataPengguna);

        if(password_verify($password, $dataPenggunaArray['password'])){

            $_SESSION['username'] = $dataPenggunaArray['username'];
            $_SESSION['nama'] = $dataPenggunaArray['nama_admin'];
            $_SESSION['login'] = true;

            header('location:../admin/siswa.php');
            exit;
            
        }else {

            echo "<h6 style='color:red; padding=20px;'>maaf data anda tidak ada pada sistem kami</h6>";
            echo "<script>
            alert('maaf data anda tidak ada pada sistem kami');
            cocument.location.href='';
            </script>";
        }

    }else {
        echo "<h6 style='color:red;'>maaf data anda tidak ada pada sistem kami</h6>";
        echo "<script>
        alert('maaf data anda tidak ada pada sistem kami');
        cocument.location.href='';
        </script>";
    }

}


// tambah siswa
function tambah_siswa($data)  
{
    global $koneksi;

    $nama_siswa = htmlspecialchars($data['nama_siswa']);
    $nisn_siswa = htmlspecialchars($data['nisn_siswa']);

    $query = mysqli_query($koneksi, "SELECT max(id_siswa) as id_siswa FROM tb_siswa");
    $data = mysqli_fetch_array($query);
    $idBaru = $data['id_siswa'];    
    $urutan = (int) substr($idBaru, 8, 8);    
    $urutan++;    
    $huruf = "SW". date('ymd');
    $idBaru = $huruf . sprintf("%08s", $urutan);

    $tambahSiswa = mysqli_query($koneksi, "INSERT INTO tb_siswa (id_siswa,nama_siswa,nisn_siswa) VALUES ('$idBaru', '$nama_siswa', '$nisn_siswa')");

    return mysqli_affected_rows($koneksi);
}



// edit siswa
function edit_siswa($data, $id_siswa)  
{
    global $koneksi;

    $nama_siswa = htmlspecialchars($data['nama_siswa']);
    $nisn_siswa = htmlspecialchars($data['nisn_siswa']);

    $editSiswa = mysqli_query($koneksi, "UPDATE tb_siswa SET nama_siswa='$nama_siswa', nisn_siswa='$nisn_siswa' WHERE id_siswa='$id_siswa'");

    return mysqli_affected_rows($koneksi);
}


// tambah nilai
function tambah_nilai($data) {

    global $koneksi;

    $id_siswa = htmlspecialchars($data['id_siswa']);
    $nilai_rata_rata = htmlspecialchars($data['nilai_rata_rata']);
    $nilai_rangking = htmlspecialchars($data['nilai_rangking']);
    $nilai_sikap = htmlspecialchars($data['nilai_sikap']);
    $nilai_ekstrakurikuler = htmlspecialchars($data['nilai_ekstrakurikuler']);
    $nilai_prestasi = htmlspecialchars($data['nilai_prestasi']);


    if($nilai_rata_rata > 100) {

        echo "<script>
        alert('Mohon perhatikan lagi nilai yang anda masukan, nilai maksimal 100');
        document.location.href='';        
        </script>";
        return false;
    }    

    
    // proses nilai rata-rata
    if($nilai_rata_rata >= 91 && $nilai_rata_rata <= 100){
        
        $nilai_skala_rata_rata = 5;
        $nilai_bobot_rata_rata = 1;
    
    }else if($nilai_rata_rata >= 81 && $nilai_rata_rata <= 90) {

        $nilai_skala_rata_rata = 4;
        $nilai_bobot_rata_rata = 0.8;
    
    }else if($nilai_rata_rata >= 71 && $nilai_rata_rata <= 80) {

        $nilai_skala_rata_rata = 3;
        $nilai_bobot_rata_rata = 0.6;
    
    }else if($nilai_rata_rata >= 51 && $nilai_rata_rata <= 70) {

        $nilai_skala_rata_rata = 2;
        $nilai_bobot_rata_rata = 0.4;
    
    }else if($nilai_rata_rata >= 0 && $nilai_rata_rata <= 50) {

        $nilai_skala_rata_rata = 1;
        $nilai_bobot_rata_rata = 0.2;
    }




    // proses nilai rangking
    if($nilai_rangking == 1){
                
        $nilai_bobot_rangking = 1;
        $rangking = 'Sangat Tinggi';
    
    }else if($nilai_rangking >= 2 && $nilai_rangking <= 4) {
        
        $nilai_bobot_rangking = 0.8;
        $rangking = 'Tinggi';
    
    }else if($nilai_rangking >= 5 && $nilai_rangking <= 7) {
        
        $nilai_bobot_rangking = 0.6;
        $rangking = 'Menengah';
    
    }else if($nilai_rangking >= 8 && $nilai_rangking <= 10) {

        $nilai_bobot_rangking = 0.4;
        $rangking = 'Rendah';
    
    }else if($nilai_rangking >= 11 ) {
        
        $nilai_bobot_rangking = 0.2;
        $rangking = 'Sangat Rendah';
    }



    // proses nilai sikap
    if($nilai_sikap == 5){
                
        $nilai_bobot_sikap = 1;        
    
    }else if($nilai_sikap == 4) {
        
        $nilai_bobot_sikap = 0.8;        
    
    }else if($nilai_sikap == 3) {
        
        $nilai_bobot_sikap = 0.6;        
    
    }else if($nilai_sikap == 2) {

        $nilai_bobot_sikap = 0.4;        
    
    }else if($nilai_sikap <= 1 ) {
        
        $nilai_bobot_sikap = 0.2;        
    }


    if($nilai_ekstrakurikuler == 5){
                
        $nilai_bobot_ekstrakurikuler = 1;        
    
    }else if($nilai_ekstrakurikuler == 4) {
        
        $nilai_bobot_ekstrakurikuler = 0.8;        
    
    }else if($nilai_ekstrakurikuler == 3) {
        
        $nilai_bobot_ekstrakurikuler = 0.6;        
    
    }else if($nilai_ekstrakurikuler == 2) {

        $nilai_bobot_ekstrakurikuler = 0.4;        
    
    }else if($nilai_ekstrakurikuler <= 1 ) {
        
        $nilai_bobot_ekstrakurikuler = 0.2;        
    }




    // proses nilai prestasi
    if($nilai_prestasi >= 9){
                
        $nilai_bobot_prestasi = 1;        
    
    }else if($nilai_prestasi >= 6 && $nilai_prestasi <= 8) {
        
        $nilai_bobot_prestasi = 0.75;        
    
    }else if($nilai_prestasi >= 3 && $nilai_prestasi <= 5) {
        
        $nilai_bobot_prestasi = 0.55;        
    
    }else if($nilai_prestasi >= 1 && $nilai_prestasi <= 2) {

        $nilai_bobot_prestasi = 0.35;        
    
    }else if($nilai_prestasi <= 0 ) {
        
        $nilai_bobot_prestasi = 0;        
    }


    $query = mysqli_query($koneksi, "SELECT max(id_nilai) as id_nilai FROM tb_nilai");
    $data = mysqli_fetch_array($query);
    $idBaru = $data['id_nilai'];    
    $urutan = (int) substr($idBaru, 8, 8);    
    $urutan++;    
    $huruf = "NL". date('ymd');
    $kodeBaruNilai = $huruf . sprintf("%08s", $urutan);

    $tambahNilai = mysqli_query($koneksi, "INSERT INTO tb_nilai (id_nilai, id_siswa, nilai_rata_rata,nilai_rangking,nilai_sikap,nilai_ekstrakurikuler,nilai_prestasi) VALUES ('$kodeBaruNilai', '$id_siswa','$nilai_rata_rata','$nilai_rangking','$nilai_sikap','$nilai_ekstrakurikuler', '$nilai_prestasi')");



    $query = mysqli_query($koneksi, "SELECT max(id_rating_kecocokan) as id_rating_kecocokan FROM tb_rating_kecocokan");
    $data = mysqli_fetch_array($query);
    $idBaru = $data['id_rating_kecocokan'];    
    $urutan = (int) substr($idBaru, 8, 8);    
    $urutan++;    
    $huruf = "RK". date('ymd');
    $idBaruRating = $huruf . sprintf("%08s", $urutan);
    
    
    $tambahNilaiKecocokan = mysqli_query($koneksi, "INSERT INTO tb_rating_kecocokan (id_rating_kecocokan,id_nilai ,id_siswa, rating_kecocokan_rata,rating_kecocokan_rangking,rating_kecocokan_sikap,rating_kecocokan_ekstrakurikuler,rating_kecocokan_prestasi) VALUES ('$idBaruRating', '$kodeBaruNilai' ,'$id_siswa','$nilai_bobot_rata_rata','$nilai_bobot_rangking','$nilai_bobot_sikap','$nilai_bobot_ekstrakurikuler', '$nilai_bobot_prestasi')");

    if($tambahNilai && $tambahNilaiKecocokan)  {
        return mysqli_affected_rows($koneksi);
    }

    return false;
}






// edit nilai
function edit_nilai($data, $id_nilai) {

    global $koneksi;

    $id_siswa = htmlspecialchars($data['id_siswa']);
    $nilai_rata_rata = htmlspecialchars($data['nilai_rata_rata']);
    $nilai_rangking = htmlspecialchars($data['nilai_rangking']);
    $nilai_sikap = htmlspecialchars($data['nilai_sikap']);
    $nilai_ekstrakurikuler = htmlspecialchars($data['nilai_ekstrakurikuler']);
    $nilai_prestasi = htmlspecialchars($data['nilai_prestasi']);


    if($nilai_rata_rata > 100) {

        echo "<script>
        alert('Mohon perhatikan lagi nilai yang anda masukan, nilai maksimal 100');
        document.location.href='';        
        </script>";
        return false;
    }    

    
    // proses nilai rata-rata
    if($nilai_rata_rata >= 91 && $nilai_rata_rata <= 100){
        
        $nilai_skala_rata_rata = 5;
        $nilai_bobot_rata_rata = 1;
    
    }else if($nilai_rata_rata >= 81 && $nilai_rata_rata <= 90) {

        $nilai_skala_rata_rata = 4;
        $nilai_bobot_rata_rata = 0.8;
    
    }else if($nilai_rata_rata >= 71 && $nilai_rata_rata <= 80) {

        $nilai_skala_rata_rata = 3;
        $nilai_bobot_rata_rata = 0.6;
    
    }else if($nilai_rata_rata >= 51 && $nilai_rata_rata <= 70) {

        $nilai_skala_rata_rata = 2;
        $nilai_bobot_rata_rata = 0.4;
    
    }else if($nilai_rata_rata >= 0 && $nilai_rata_rata <= 50) {

        $nilai_skala_rata_rata = 1;
        $nilai_bobot_rata_rata = 0.2;
    }




    // proses nilai rangking
    if($nilai_rangking == 1){
                
        $nilai_bobot_rangking = 1;
        $rangking = 'Sangat Tinggi';
    
    }else if($nilai_rangking >= 2 && $nilai_rangking <= 4) {
        
        $nilai_bobot_rangking = 0.8;
        $rangking = 'Tinggi';
    
    }else if($nilai_rangking >= 5 && $nilai_rangking <= 7) {
        
        $nilai_bobot_rangking = 0.6;
        $rangking = 'Menengah';
    
    }else if($nilai_rangking >= 8 && $nilai_rangking <= 10) {

        $nilai_bobot_rangking = 0.4;
        $rangking = 'Rendah';
    
    }else if($nilai_rangking >= 11 ) {
        
        $nilai_bobot_rangking = 0.2;
        $rangking = 'Sangat Rendah';
    }



    // proses nilai sikap
    if($nilai_sikap == 5){
                
        $nilai_bobot_sikap = 1;        
    
    }else if($nilai_sikap == 4) {
        
        $nilai_bobot_sikap = 0.8;        
    
    }else if($nilai_sikap == 3) {
        
        $nilai_bobot_sikap = 0.6;        
    
    }else if($nilai_sikap == 2) {

        $nilai_bobot_sikap = 0.4;        
    
    }else if($nilai_sikap <= 1 ) {
        
        $nilai_bobot_sikap = 0.2;        
    }


    if($nilai_ekstrakurikuler == 5){
                
        $nilai_bobot_ekstrakurikuler = 1;        
    
    }else if($nilai_ekstrakurikuler == 4) {
        
        $nilai_bobot_ekstrakurikuler = 0.8;        
    
    }else if($nilai_ekstrakurikuler == 3) {
        
        $nilai_bobot_ekstrakurikuler = 0.6;        
    
    }else if($nilai_ekstrakurikuler == 2) {

        $nilai_bobot_ekstrakurikuler = 0.4;        
    
    }else if($nilai_ekstrakurikuler <= 1 ) {
        
        $nilai_bobot_ekstrakurikuler = 0.2;        
    }




    // proses nilai prestasi
    if($nilai_prestasi >= 9){
                
        $nilai_bobot_prestasi = 1;        
    
    }else if($nilai_prestasi >= 6 && $nilai_prestasi <= 8) {
        
        $nilai_bobot_prestasi = 0.75;        
    
    }else if($nilai_prestasi >= 3 && $nilai_prestasi <= 5) {
        
        $nilai_bobot_prestasi = 0.55;        
    
    }else if($nilai_prestasi >= 1 && $nilai_prestasi <= 2) {

        $nilai_bobot_prestasi = 0.35;        
    
    }else if($nilai_prestasi <= 0 ) {
        
        $nilai_bobot_prestasi = 0;        
    }


    $query = mysqli_query($koneksi, "SELECT max(id_nilai) as id_nilai FROM tb_nilai");
    $data = mysqli_fetch_array($query);
    $idBaru = $data['id_nilai'];    
    $urutan = (int) substr($idBaru, 8, 8);    
    $urutan++;    
    $huruf = "NL". date('ymd');
    $kodeBaruNilai = $huruf . sprintf("%08s", $urutan);

    $editNilai = mysqli_query($koneksi, "UPDATE tb_nilai SET id_siswa='$id_siswa', nilai_rata_rata='$nilai_rata_rata', nilai_rangking='$nilai_rangking', nilai_sikap='$nilai_sikap', nilai_ekstrakurikuler='$nilai_ekstrakurikuler', nilai_prestasi='$nilai_prestasi' WHERE id_nilai='$id_nilai' ");    



    $query = mysqli_query($koneksi, "SELECT max(id_rating_kecocokan) as id_rating_kecocokan FROM tb_rating_kecocokan");
    $data = mysqli_fetch_array($query);
    $idBaru = $data['id_rating_kecocokan'];    
    $urutan = (int) substr($idBaru, 8, 8);    
    $urutan++;    
    $huruf = "RK". date('ymd');
    $idBaruRating = $huruf . sprintf("%08s", $urutan);
    
    
    $editKecocokan = mysqli_query($koneksi, "UPDATE tb_rating_kecocokan SET id_siswa='$id_siswa', rating_kecocokan_rata='$nilai_bobot_rata_rata', rating_kecocokan_rangking='$nilai_bobot_rangking', rating_kecocokan_sikap='$nilai_bobot_sikap', rating_kecocokan_ekstrakurikuler='$nilai_bobot_ekstrakurikuler', rating_kecocokan_prestasi='$nilai_bobot_prestasi' WHERE id_nilai='$id_nilai' ");    

    if($editNilai && $editKecocokan)  {
        return mysqli_affected_rows($koneksi);
    }

    return false;
}



function tambah_admin($data)  
{
    global $koneksi;

    $nama_admin = htmlspecialchars($data['nama_admin']);
    $nip_admin = htmlspecialchars($data['nip_admin']);
    $username = htmlspecialchars($data['username']);
    $password = htmlspecialchars($data['password']);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = mysqli_query($koneksi, "SELECT max(id_admin) as id_admin FROM tb_admin");
    $data = mysqli_fetch_array($query);
    $idBaru = $data['id_admin'];    
    $urutan = (int) substr($idBaru, 8, 8);    
    $urutan++;    
    $huruf = "GR". date('ymd');
    $idBaru = $huruf . sprintf("%08s", $urutan);

    $tambahadmin = mysqli_query($koneksi, "INSERT INTO tb_admin (id_admin,nama_admin,nip_admin, username, password) VALUES ('$idBaru', '$nama_admin', '$nip_admin', '$username', '$password')");

    return mysqli_affected_rows($koneksi);
}