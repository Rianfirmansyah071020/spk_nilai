<?php
session_start();

error_reporting(0);

    if($_SESSION['login'] !== true) {

    header('location:../logout/index.php');
    exit;
    }

require "../controller/controller.php";

$id_kelas = $_SESSION['id_kelas'];
$kelasById = mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$id_kelas'");
$kelasById = mysqli_fetch_array($kelasById);    

?>

<?php
        include "layouts.php";
        ?>
<!-- Sidebar -->
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content" style="background-image: url(../../assets_home/img/bac5.jpg); background-size:cover;">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
            <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <ul class="navbar-nav ml-auto">
                <div class="topbar-divider d-none d-sm-block"></div>
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="ml-2 d-none d-lg-inline text-white small"><?= $_SESSION['nama'] ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal"
                            data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Data Hasil Nilai Siswa <span
                        class="text-white"><?= $kelasById['nama_kelas'] ?></span></h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="siswa.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data hasil nilai siswa <span
                            class="text-white"><?= $kelasById['nama_kelas'] ?></span></li>
                </ol>
            </div>

            <div class="row">
                <!-- Datatables -->
                <div class="col-lg-12">
                    <div class="card mb-4 p-3">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Data Hasil Nilai Siswa <span
                                    class="text-dark"><?= $kelasById['nama_kelas'] ?></span></h6>
                            <a href="export_pdf.php?id_kelas=<?= $id_kelas ?>&&nama_kelas=<?= $kelasById['nama_kelas'] ?>"
                                target="_blank" class="btn btn-success">Export PDF</a>
                        </div>
                        <div class="table-responsive p-3">
                            <table class="table table-bordered align-items-center" id="dataTable"
                                style="font-size:small;">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">NISN</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Hasil</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">NISN</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Hasil</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    <?php                                            

                                            $bobotFirst = [0.25, 0.20, 0.15, 0.15, 0.25];
                                            
                                            $dataSiswa = mysqli_query($koneksi, "SELECT tb_siswa.id_siswa,(tb_rating_kecocokan.rating_kecocokan_rata * $bobotFirst[0]  + tb_rating_kecocokan.rating_kecocokan_rangking * $bobotFirst[1] + tb_rating_kecocokan.rating_kecocokan_sikap * $bobotFirst[2] + tb_rating_kecocokan.rating_kecocokan_ekstrakurikuler * $bobotFirst[3] + tb_rating_kecocokan.rating_kecocokan_prestasi * $bobotFirst[4]) as 'total' FROM tb_siswa INNER JOIN tb_nilai ON tb_siswa.id_siswa = tb_nilai.id_siswa INNER JOIN tb_rating_kecocokan ON tb_siswa.id_siswa = tb_rating_kecocokan.id_siswa WHERE tb_siswa.id_kelas='$id_kelas' ORDER BY total DESC");

                                            $arr = [];
                                            $hasil = [];
                                            $bobot = [0.25, 0.20, 0.15, 0.15, 0.25];

                                            foreach ($dataSiswa as $key => $siswa) {

                                                $id_siswa = $siswa['id_siswa'];
                                                $ratingNilaiSiswa = mysqli_query($koneksi, "SELECT * FROM tb_rating_kecocokan INNER JOIN tb_siswa ON tb_rating_kecocokan.id_siswa = tb_siswa.id_siswa WHERE tb_rating_kecocokan.id_siswa='$id_siswa'");    
                                                
                                                $nilaiSiswa = mysqli_fetch_assoc($ratingNilaiSiswa);

                                                foreach ([
                                                    'rating_kecocokan_rata',
                                                    'rating_kecocokan_rangking',
                                                    'rating_kecocokan_sikap',
                                                    'rating_kecocokan_ekstrakurikuler',
                                                    'rating_kecocokan_prestasi'
                                                ] as $i => $value) {
                                                    $arr[$key][$i] = $nilaiSiswa[$value] * $bobot[$i];
                                                }
                                                
                                                $hasil[$key] = $nilaiSiswa;

                                                $arr[$key]['hasil'] = 0;
                                                for ($i=0; $i < count($bobot); $i++) {
                                                    $hasil[$key]['hasil'] = ($hasil[$key]['hasil'] ?? 0) + $arr[$key][$i];
                                                }    
                                            }

                                            $jumlahSiswa = mysqli_num_rows($dataSiswa);

                                            $i = 0;
                                            $no = 1;

                                            if($i < $jumlahSiswa) {

                                                foreach ($hasil as $data) { ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td class="text-start"><?= $data['nisn_siswa'] ?></td>
                                        <td class="text-start"><?= $data['nama_siswa'] ?></td>
                                        <td class="text-center"><?= $data['hasil'] ?></td>
                                        <td class="text-center">
                                            <?php if ($i < 5) { ?>
                                            prestasi
                                            <?php } else { ?>

                                            <?php echo "-";
                                            } ?>
                                        </td>
                                    </tr>

                                    <?php  $i++;
                                                }
                                            }
                                            ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Logout -->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Anda yakin keluar dari aplikasi ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                            <a href="../logout/index.php" class="btn btn-primary">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---Container Fluid-->
    </div>
    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>copyright &copy; <script>
                    document.write(new Date().getFullYear());
                    </script>
                </span>
            </div>
        </div>
    </footer>
    <!-- Footer -->
</div>
</div>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script src="../../vendor/jquery/jquery.min.js"></script>
<script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../../js/ruang-admin.min.js"></script>
<!-- Page level plugins -->
<script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script>
$(document).ready(function() {
    $('#dataTable').DataTable(); // ID From dataTable 
    $('#dataTableHover').DataTable(); // ID From dataTable with Hover
});
</script>
</body>

</html>