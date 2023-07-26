<?php
error_reporting(0);
require "../controller/controller.php";

?>

<?php
        include "layouts_view.php";
        ?>
<!-- Sidebar -->
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
            <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <ul class="navbar-nav ml-auto">
                <div class="topbar-divider d-none d-sm-block"></div>
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="../../index.php">
                        <span class="ml-2 d-none d-lg-inline text-white small">kembali</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Data Prestasi Siswa</h1>
            </div>

            <div class="row">
                <!-- Datatables -->
                <div class="col-lg-12">
                    <div class="card mb-4 p-3">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Data Prestasi Siswa</h6>
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


                                            $dataSiswa = mysqli_query($koneksi, "SELECT * FROM tb_siswa");

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
                                            <?php if ($data['hasil'] > 0.5) { ?>
                                            prestasi
                                            <?php } ?>
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