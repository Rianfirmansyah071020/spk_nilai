<?php
require('fpdf/fpdf.php');
require '../controller/controller.php';
$id_kelas = $_GET['id_kelas'];
$kelasById = mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$id_kelas'");
$kelasById = mysqli_fetch_array($kelasById);    


// require('your_data_source.php'); // Ganti dengan sumber data nilai siswa Anda

class PDF extends FPDF
{

    
    function Header()
    {        
        $this->Image('assets/sekolah.jpeg',20,6,22);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 5, 'PEMERINTAHAN KABUPATEN MERANGIN ', 0, 1, 'C');
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(0, 6, 'SMA NEGERI 13 MERANGIN ', 0, 1, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 6, 'Jln,Pendidikan No. 1, Suko Rejo, Kec.Margo Tabir, Kab.Merangin Prov.Jambi ', 0, 1, 'C');
        $this->Cell(0, 3, '___________________________________________________________________________________', 0, 1, 'C');
        $this->Ln(7);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 6, 'DAFTAR SISWA BERPRESTASI '. $_GET['nama_kelas'], 0, 1, 'C');
        $this->Ln(7);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 6);
        $this->Cell(30, 10, 'SMA NEGERI 13 MERANGIN', 0, 0, 'L');
        // $this->Cell(80, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'R');
        $this->Ln();
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);

// Ambil data nilai siswa dari sumber data Anda
$id_kelas = $_GET['id_kelas'];
$kelasById = mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$id_kelas'");
$kelasById = mysqli_fetch_array($kelasById);    

$bobotFirst = [0.25, 0.20, 0.15, 0.15, 0.25];
                                            
$dataSiswa = mysqli_query($koneksi, "SELECT tb_siswa.id_siswa,(tb_rating_kecocokan.rating_kecocokan_rata * $bobotFirst[0]  + tb_rating_kecocokan.rating_kecocokan_rangking * $bobotFirst[1] + tb_rating_kecocokan.rating_kecocokan_sikap * $bobotFirst[2] + tb_rating_kecocokan.rating_kecocokan_ekstrakurikuler * $bobotFirst[3] + tb_rating_kecocokan.rating_kecocokan_prestasi * $bobotFirst[4]) as 'total', tb_siswa.nisn_siswa as 'nisn_siswa', tb_siswa.nama_siswa as 'nama_siswa' FROM tb_siswa INNER JOIN tb_nilai ON tb_siswa.id_siswa = tb_nilai.id_siswa INNER JOIN tb_rating_kecocokan ON tb_siswa.id_siswa = tb_rating_kecocokan.id_siswa WHERE tb_siswa.id_kelas='$id_kelas' ORDER BY total DESC");


$pdf->Cell(10,8, 'NO', 1,0,'C');
$pdf->Cell(35,8, 'NISN', 1,0,'C');
$pdf->Cell(70,8, 'NAMA', 1,0,'C');
$pdf->Cell(30,8, 'HASIL', 1,0,'C');
$pdf->Cell(40,8, 'STATUS', 1,0,'C');
$pdf->Ln();

$no = 1;
foreach ($dataSiswa as $siswa) {
    $pdf->Cell(10, 8, $no++, 1, 0, 'C');    
    $pdf->Cell(35, 8, $siswa['nisn_siswa'], 1, 0, 'C');    
    $pdf->Cell(70, 8, $siswa['nama_siswa'], 1, 0, 'L');
    $pdf->Cell(30, 8, (double) $siswa['total'], 1, 0, 'C');
    if($no <= 6) {
        $pdf->Cell(40, 8, 'prestasi', 1, 0, 'C');
        
    } else if($no > 6) {
        $pdf->Cell(40, 8, '-', 1, 0, 'C');

    }
    $pdf->Ln();
    // $pdf->Cell(40, 10, $siswa['nilai'], 1, 1, 'C');
}
$pdf->Ln(10);
$pdf->Cell(170, 8, 'Margo Tabir  ' . date('d-m-Y'), 0, 0, 'R');
$pdf->Ln(7);
$pdf->Cell(30, 8, 'Wali Kelas', 0, 0, 'R');
$pdf->Cell(128, 8, 'Kepala Sekolah', 0, 0, 'R');
$pdf->Ln(20);
$pdf->Cell(38, 3, '_____________', 0, 0, 'R');
$pdf->Cell(121, 3, '_____________', 0, 0, 'R');
$pdf->Ln();
$pdf->Cell(24, 8, 'NIP : ', 0, 0, 'R');
$pdf->Cell(121, 8, 'NIP : ', 0, 0, 'R');
// $pdf->Ln(10);
// $pdf->Cell(60, 8, 'Wali Kelas', 0, 0, 'L');
// $pdf->Ln(20);
// $pdf->Cell(60, 8, 'Nip:', 0, 0, 'L');
// $pdf->Cell(80, 8, 'Margo Tabir  ' . date('d-m-Y'), 0, 0, 'R');
// $pdf->Ln();
// $pdf->Cell(174, 8, 'Kepala Sekolah', 0, 0, 'R');
// $pdf->Ln(20);
// $pdf->Cell(160, 8, 'Nip:', 0, 0, 'R');

$pdf->Output('Siswa Berprestasi' . $_GET['nama_kelas'].'.pdf', 'I');
?>