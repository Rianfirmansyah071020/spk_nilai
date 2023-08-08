<?php


$koneksi = mysqli_connect('localhost', 'root', '', 'siswa_prestasi');

// mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//ini sesuaikan foldernya ke file 3 ini
require '../admin/PHPMailer/src/Exception.php';
require '../admin/PHPMailer/src/PHPMailer.php';
require '../admin/PHPMailer/src/SMTP.php';

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
            $_SESSION['level'] = $dataPenggunaArray['level_user'];
            $_SESSION['login'] = true;

            header('location:../admin/dashboard.php');
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



function lupa_password($data)
{
    global $koneksi;

    $username = htmlspecialchars($data['username']);   

    $cekJumlahData = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$username'"));

    if($cekJumlahData === 1) {

        session_start();
        $dataPengguna = mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$username'");
        $dataPenggunaArray = mysqli_fetch_array($dataPengguna);       


        $judul = 'Akun untuk login ke webiste SMAN Negeri 13 Merangin';
        $pesan = 'Anda dapat bergabung pada webiste kami berikut akun yang dapat anda gunakan untuk login username : ' . $dataPenggunaArray["username"] .' password : ' . $dataPenggunaArray["password_reel"];


       try {
        $mail = new PHPMailer(true);
        //Server settings
        // $mail->SMTPDebug = 2; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPSecure = 'ssl'; //Enable implicit TLS encryption
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
         $mail->Username = 'smanmerangin73@gmail.com'; //SMTP username
        $mail->Password = 'ttpmuvddjqplkoyn'; //SMTP password

        //pengirim
        $mail->setFrom('smanmerangin73@gmail.com', 'SMAN 13 Merangin');
        $mail->addAddress($dataPenggunaArray['email']); //Add a recipient        

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = $judul;
        $mail->Body = $pesan;
        $mail->AltBody = '';
        //$mail->AddEmbeddedImage('gambar/logo.png', 'logo'); //abaikan jika tidak ada logo
        //$mail->addAttachment(''); 

        $mail->send();

            return true;
            
       } catch (\Throwable $th) {
        //throw $th;
       }



    }

}


// tambah siswa
function tambah_siswa($data)  
{
    global $koneksi;

    $nama_siswa = htmlspecialchars($data['nama_siswa']);
    $nisn_siswa = htmlspecialchars($data['nisn_siswa']);
    $id_kelas = htmlspecialchars($data['id_kelas']);

    if($id_kelas == null) {

        return false;
    }

    $query = mysqli_query($koneksi, "SELECT max(id_siswa) as id_siswa FROM tb_siswa");
    $data = mysqli_fetch_array($query);
    $idBaru = $data['id_siswa'];    
    $urutan = (int) substr($idBaru, 8, 8);    
    $urutan++;    
    $huruf = "SW". date('ymd');
    $idBaru = $huruf . sprintf("%08s", $urutan);

    $tambahSiswa = mysqli_query($koneksi, "INSERT INTO tb_siswa (id_siswa,id_kelas,nama_siswa,nisn_siswa) VALUES ('$idBaru', '$id_kelas','$nama_siswa', '$nisn_siswa')");

    return mysqli_affected_rows($koneksi);
}



// edit siswa
function edit_siswa($data, $id_siswa)  
{
    global $koneksi;

    $nama_siswa = htmlspecialchars($data['nama_siswa']);
    $nisn_siswa = htmlspecialchars($data['nisn_siswa']);
    $id_kelas = htmlspecialchars($data['id_kelas']);

    $editSiswa = mysqli_query($koneksi, "UPDATE tb_siswa SET nama_siswa='$nama_siswa',id_kelas='$id_kelas', nisn_siswa='$nisn_siswa' WHERE id_siswa='$id_siswa'");

    return mysqli_affected_rows($koneksi);
}

function edit_kelas($data, $id_kelas)  
{
    global $koneksi;

    $nama_kelas = htmlspecialchars($data['nama_kelas']);        

    $editKelas = mysqli_query($koneksi, "UPDATE kelas SET nama_kelas='$nama_kelas' WHERE id_kelas='$id_kelas'");

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

    
    // proses nilai rata-rata
    if($nilai_rata_rata === "91-100"){
        
        $nilai_skala_rata_rata = 5;
        $nilai_bobot_rata_rata = 1;
    
    }else if($nilai_rata_rata === "81-90") {

        $nilai_skala_rata_rata = 4;
        $nilai_bobot_rata_rata = 0.8;
    
    }else if($nilai_rata_rata === "71-80") {

        $nilai_skala_rata_rata = 3;
        $nilai_bobot_rata_rata = 0.6;
    
    }else if($nilai_rata_rata === "51-70") {

        $nilai_skala_rata_rata = 2;
        $nilai_bobot_rata_rata = 0.4;
    
    }else if($nilai_rata_rata === "0-50") {

        $nilai_skala_rata_rata = 1;
        $nilai_bobot_rata_rata = 0.2;
    }




    // proses nilai rangking
    if($nilai_rangking === "Sangat Tinggi"){
                
        $nilai_bobot_rangking = 1;        
    
    }else if($nilai_rangking === "Tinggi") {
        
        $nilai_bobot_rangking = 0.8;        
    
    }else if($nilai_rangking === "Menengah") {
        
        $nilai_bobot_rangking = 0.6;        
    
    }else if($nilai_rangking === "Rendah") {

        $nilai_bobot_rangking = 0.4;        
    
    }else if($nilai_rangking === "Sangat Rendah" ) {
        
        $nilai_bobot_rangking = 0.2;        
    }



    // proses nilai sikap
    if($nilai_sikap === "A"){
                
        $nilai_bobot_sikap = 1;        
    
    }else if($nilai_sikap === "B") {
        
        $nilai_bobot_sikap = 0.8;        
    
    }else if($nilai_sikap === "C") {
        
        $nilai_bobot_sikap = 0.6;        
    
    }else if($nilai_sikap === "D") {

        $nilai_bobot_sikap = 0.4;        
    
    }else if($nilai_sikap === "E") {
        
        $nilai_bobot_sikap = 0.2;        
    }


    if($nilai_ekstrakurikuler === "A"){
                
        $nilai_bobot_ekstrakurikuler = 1;        
    
    }else if($nilai_ekstrakurikuler === "B") {
        
        $nilai_bobot_ekstrakurikuler = 0.8;        
    
    }else if($nilai_ekstrakurikuler === "C") {
        
        $nilai_bobot_ekstrakurikuler = 0.6;        
    
    }else if($nilai_ekstrakurikuler === "D") {

        $nilai_bobot_ekstrakurikuler = 0.4;        
    
    }else if($nilai_ekstrakurikuler === "E" ) {
        
        $nilai_bobot_ekstrakurikuler = 0.2;        
    }




    // proses nilai prestasi
    if($nilai_prestasi === "Sangat banyak"){
                
        $nilai_bobot_prestasi = 1;        
    
    }else if($nilai_prestasi === "Banyak") {
        
        $nilai_bobot_prestasi = 0.75;        
    
    }else if($nilai_prestasi === "Cukup") {
        
        $nilai_bobot_prestasi = 0.55;        
    
    }else if($nilai_prestasi === "Kurang") {

        $nilai_bobot_prestasi = 0.35;        
    
    }else if($nilai_prestasi === "Tidak ada" ) {
        
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

    
    // proses nilai rata-rata
    if($nilai_rata_rata === "91-100"){
        
        $nilai_skala_rata_rata = 5;
        $nilai_bobot_rata_rata = 1;
    
    }else if($nilai_rata_rata === "81-90") {

        $nilai_skala_rata_rata = 4;
        $nilai_bobot_rata_rata = 0.8;
    
    }else if($nilai_rata_rata === "71-80") {

        $nilai_skala_rata_rata = 3;
        $nilai_bobot_rata_rata = 0.6;
    
    }else if($nilai_rata_rata === "51-70") {

        $nilai_skala_rata_rata = 2;
        $nilai_bobot_rata_rata = 0.4;
    
    }else if($nilai_rata_rata === "0-50") {

        $nilai_skala_rata_rata = 1;
        $nilai_bobot_rata_rata = 0.2;
    }




    // proses nilai rangking
    if($nilai_rangking === "Sangat Tinggi"){
                
        $nilai_bobot_rangking = 1;        
    
    }else if($nilai_rangking === "Tinggi") {
        
        $nilai_bobot_rangking = 0.8;        
    
    }else if($nilai_rangking === "Menengah") {
        
        $nilai_bobot_rangking = 0.6;        
    
    }else if($nilai_rangking === "Rendah") {

        $nilai_bobot_rangking = 0.4;        
    
    }else if($nilai_rangking === "Sangat Rendah" ) {
        
        $nilai_bobot_rangking = 0.2;        
    }



    // proses nilai sikap
    if($nilai_sikap === "A"){
                
        $nilai_bobot_sikap = 1;        
    
    }else if($nilai_sikap === "B") {
        
        $nilai_bobot_sikap = 0.8;        
    
    }else if($nilai_sikap === "C") {
        
        $nilai_bobot_sikap = 0.6;        
    
    }else if($nilai_sikap === "D") {

        $nilai_bobot_sikap = 0.4;        
    
    }else if($nilai_sikap === "E") {
        
        $nilai_bobot_sikap = 0.2;        
    }


    if($nilai_ekstrakurikuler === "A"){
                
        $nilai_bobot_ekstrakurikuler = 1;        
    
    }else if($nilai_ekstrakurikuler === "B") {
        
        $nilai_bobot_ekstrakurikuler = 0.8;        
    
    }else if($nilai_ekstrakurikuler === "C") {
        
        $nilai_bobot_ekstrakurikuler = 0.6;        
    
    }else if($nilai_ekstrakurikuler === "D") {

        $nilai_bobot_ekstrakurikuler = 0.4;        
    
    }else if($nilai_ekstrakurikuler === "E" ) {
        
        $nilai_bobot_ekstrakurikuler = 0.2;        
    }




    // proses nilai prestasi
    if($nilai_prestasi === "Sangat banyak"){
                
        $nilai_bobot_prestasi = 1;        
    
    }else if($nilai_prestasi === "Banyak") {
        
        $nilai_bobot_prestasi = 0.75;        
    
    }else if($nilai_prestasi === "Cukup") {
        
        $nilai_bobot_prestasi = 0.55;        
    
    }else if($nilai_prestasi === "Kurang") {

        $nilai_bobot_prestasi = 0.35;        
    
    }else if($nilai_prestasi === "Tidak ada" ) {
        
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
    $email = htmlspecialchars($data['email']);
    $username = htmlspecialchars($data['username']);
    $password = htmlspecialchars($data['password']);
    $password = password_hash($password, PASSWORD_DEFAULT);

    // kirim mailer
    $judul = 'Akun untuk login ke webiste SMAN Negeri 13 Merangin';
    $pesan = 'Selamat bergabung ' . $data["nama_admin"] .  ' di website kami berikut akun yang dapat anda gunakan untuk login username : ' . $data["username"] .' password : ' . $data["password"];

        try {
            $mail = new PHPMailer(true);
        //Server settings
        // $mail->SMTPDebug = 2; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPSecure = 'ssl'; //Enable implicit TLS encryption
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->Username = 'smanmerangin73@gmail.com'; //SMTP username
        $mail->Password = 'ttpmuvddjqplkoyn'; //SMTP password

        //pengirim
        $mail->setFrom('smanmerangin73@gmail.com', 'SMAN 13 Merangin');
        $mail->addAddress($email); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = $judul;
        $mail->Body = $pesan;
        $mail->AltBody = '';
        //$mail->AddEmbeddedImage('gambar/logo.png', 'logo'); //abaikan jika tidak ada logo
        //$mail->addAttachment(''); 

        $mail->send();


        $query = mysqli_query($koneksi, "SELECT max(id_admin) as id_admin FROM admin");
        $data = mysqli_fetch_array($query);
        $idBaru = $data['id_admin'];
        $urutan = (int) substr($idBaru, 8, 8);
        $urutan++;
        $huruf = "ADM" . date('ymd');
        $idBaru = $huruf . sprintf("%08s", $urutan);

        $tambahadmin = mysqli_query($koneksi, "INSERT INTO admin (id_admin,level_user ,nama_admin,nip_admin, email, username,password) VALUES ('$idBaru','admin', '$nama_admin', '$nip_admin', '$email','$username' ,'$password')");

        return mysqli_affected_rows($koneksi);
        } catch (\Throwable $th) {
            
            return false;
        }   
}


function tambah_guru($data)  
{
    global $koneksi;

    $nama_guru = htmlspecialchars($data['nama_guru']);
    $nip_guru = htmlspecialchars($data['nip_guru']);
    $email = htmlspecialchars($data['email']);
    $username = htmlspecialchars($data['username']);
    $password = htmlspecialchars($data['password']);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $judul = 'Akun untuk login ke webiste SMAN Negeri 13 Merangin';
    $pesan = 'Selamat bergabung ' . $data["nama_guru"] .  ' di website kami berikut akun yang dapat anda gunakan untuk login username : ' . $data["username"] .' password : ' . $data["password"];

    
    try {
        $mail = new PHPMailer(true);
        //Server settings
        // $mail->SMTPDebug = 2; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPSecure = 'ssl'; //Enable implicit TLS encryption
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
         $mail->Username = 'smanmerangin73@gmail.com'; //SMTP username
        $mail->Password = 'ttpmuvddjqplkoyn'; //SMTP password

        //pengirim
        $mail->setFrom('smanmerangin73@gmail.com', 'SMAN 13 Merangin');
        $mail->addAddress($email); //Add a recipient
        $mail->addAddress($email); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = $judul;
        $mail->Body = $pesan;
        $mail->AltBody = '';
        //$mail->AddEmbeddedImage('gambar/logo.png', 'logo'); //abaikan jika tidak ada logo
        //$mail->addAttachment(''); 

        $mail->send();

    $query = mysqli_query($koneksi, "SELECT max(id_admin) as id_admin FROM admin");
    $data = mysqli_fetch_array($query);
    $idBaru = $data['id_admin'];    
    $urutan = (int) substr($idBaru, 8, 8);    
    $urutan++;    
    $huruf = "ADM". date('ymd');
    $idBaru = $huruf . sprintf("%08s", $urutan);

    $tambahguru = mysqli_query($koneksi, "INSERT INTO admin (id_admin,level_user ,nama_admin,nip_admin, email, username,password) VALUES ('$idBaru','guru', '$nama_guru', '$nip_guru', '$email','$username', '$password')");

    return mysqli_affected_rows($koneksi);
    } catch (\Throwable $th) {
        
        return false;
    }        
}


function tambah_kepsek($data)  
{
    global $koneksi;

    $nama_kepsek = htmlspecialchars($data['nama_kepsek']);
    $nip_kepsek = htmlspecialchars($data['nip_kepsek']);
    $email = htmlspecialchars($data['email']);
    $username = htmlspecialchars($data['username']);
    $password = htmlspecialchars($data['password']);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $judul = 'Akun untuk login ke webiste SMAN Negeri 13 Merangin';
    $pesan = 'Selamat bergabung ' . $data["nama_kepsek"] .  ' di website kami berikut akun yang dapat anda gunakan untuk login username : ' . $data["username"] .' password : ' . $data["password"];

    
    
        try {
            $mail = new PHPMailer(true);
        //Server settings
        // $mail->SMTPDebug = 2; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPSecure = 'ssl'; //Enable implicit TLS encryption
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
         $mail->Username = 'smanmerangin73@gmail.com'; //SMTP username
        $mail->Password = 'ttpmuvddjqplkoyn'; //SMTP password

        //pengirim
        $mail->setFrom('smanmerangin73@gmail.com', 'SMAN 13 Merangin');
        $mail->addAddress($email); //Add a recipient
        $mail->addAddress($email); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = $judul;
        $mail->Body = $pesan;
        $mail->AltBody = '';
        //$mail->AddEmbeddedImage('gambar/logo.png', 'logo'); //abaikan jika tidak ada logo
        //$mail->addAttachment(''); 

        $mail->send();

    $query = mysqli_query($koneksi, "SELECT max(id_admin) as id_admin FROM admin");
    $data = mysqli_fetch_array($query);
    $idBaru = $data['id_admin'];    
    $urutan = (int) substr($idBaru, 8, 8);    
    $urutan++;    
    $huruf = "ADM". date('ymd');
    $idBaru = $huruf . sprintf("%08s", $urutan);

    $tambahkepsek = mysqli_query($koneksi, "INSERT INTO admin (id_admin,level_user ,nama_admin,nip_admin, email,username ,password) VALUES ('$idBaru','kepsek', '$nama_kepsek', '$nip_kepsek', '$email', '$username','$password')");

    return mysqli_affected_rows($koneksi);
        } catch (\Throwable $th) {

        return false;
        }
}



function tambah_kelas($data)  
{
    global $koneksi;

    $nama_kelas = htmlspecialchars($data['nama_kelas']);    

    $query = mysqli_query($koneksi, "SELECT max(id_kelas) as id_kelas FROM kelas");
    $data = mysqli_fetch_array($query);
    $idBaru = $data['id_kelas'];    
    $urutan = (int) substr($idBaru, 8, 8);    
    $urutan++;    
    $huruf = "KLS". date('ymd');
    $idBaru = $huruf . sprintf("%08s", $urutan);

    $tambahguru = mysqli_query($koneksi, "INSERT INTO kelas (id_kelas,nama_kelas) VALUES ('$idBaru', '$nama_kelas')");

    return mysqli_affected_rows($koneksi);
}