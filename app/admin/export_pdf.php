<?php
require('fpdf/fpdf.php');
require '../controller/controller.php';

// require('your_data_source.php'); // Ganti dengan sumber data nilai siswa Anda

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Daftar Siswa Berprestasi', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 6);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);

// Ambil data nilai siswa dari sumber data Anda
$id_kelas = $_GET['id_kelas'];
$bobotFirst = [0.25, 0.20, 0.15, 0.15, 0.25];
                                            
$dataSiswa = mysqli_query($koneksi, "SELECT tb_siswa.id_siswa,(tb_rating_kecocokan.rating_kecocokan_rata * $bobotFirst[0]  + tb_rating_kecocokan.rating_kecocokan_rangking * $bobotFirst[1] + tb_rating_kecocokan.rating_kecocokan_sikap * $bobotFirst[2] + tb_rating_kecocokan.rating_kecocokan_ekstrakurikuler * $bobotFirst[3] + tb_rating_kecocokan.rating_kecocokan_prestasi * $bobotFirst[4]) as 'total', tb_siswa.nisn_siswa as 'nisn_siswa', tb_siswa.nama_siswa as 'nama_siswa' FROM tb_siswa INNER JOIN tb_nilai ON tb_siswa.id_siswa = tb_nilai.id_siswa INNER JOIN tb_rating_kecocokan ON tb_siswa.id_siswa = tb_rating_kecocokan.id_siswa WHERE tb_siswa.id_kelas='$id_kelas' ORDER BY total DESC");


$pdf->Cell(10,8, 'NO', 1,0,'C');
$pdf->Cell(35,8, 'NISN', 1,0,'C');
$pdf->Cell(70,8, 'NAMA', 1,0,'C');
$pdf->Cell(30,8, 'HASIL', 1,0,'C');
$pdf->Cell(30,8, 'STATUS', 1,0,'C');
$pdf->Ln();

$no = 1;
foreach ($dataSiswa as $siswa) {
    $pdf->Cell(10, 8, $no++, 1, 0, 'C');    
    $pdf->Cell(35, 8, $siswa['nisn_siswa'], 1, 0, 'C');    
    $pdf->Cell(70, 8, $siswa['nama_siswa'], 1, 0, 'L');
    $pdf->Cell(30, 8, (double) $siswa['total'], 1, 0, 'C');
    if($no <= 5) {
        $pdf->Cell(30, 8, 'prestasi', 1, 0, 'C');
        
    } else {
        $pdf->Cell(30, 6, '-', 1, 0, 'C');

    }
    $pdf->Ln();
    // $pdf->Cell(40, 10, $siswa['nilai'], 1, 1, 'C');
}

$pdf->Output();
?>