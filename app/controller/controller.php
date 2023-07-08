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

            echo "<h5 style='color:red; padding=20px;'>maaf data anda tidak ada pada sistem kami</h5>";
        }

    }else {
        echo "<h5 style='color:red;'>maaf data anda tidak ada pada sistem kami</h5>";
    }

}