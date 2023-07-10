<?php


$koneksi = mysqli_connect('localhost', 'root', '', 'peringkat_siswa');

// login pengguna
function login_pengguna($data)
{
    global $koneksi;

    $username = htmlspecialchars($data['username']);
    $password = htmlspecialchars($data['password']);    

    $cekJumlahData = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tb_guru WHERE username = '$username'"));

    if($cekJumlahData === 1) {

        session_start();
        $dataPengguna = mysqli_query($koneksi, "SELECT * FROM tb_guru WHERE username = '$username'");
        $dataPenggunaArray = mysqli_fetch_array($dataPengguna);

        if(password_verify($password, $dataPenggunaArray['password'])){

            $_SESSION['username'] = $dataPenggunaArray['username'];
            $_SESSION['nama'] = $dataPenggunaArray['nama_guru'];
            $_SESSION['login'] = true;

            header('location:../guru/siswa.php');
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
}