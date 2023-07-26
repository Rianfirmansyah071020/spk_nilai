<?php
session_start();

    if($_SESSION['login'] !== true) {

    header('location:../logout/index.php');
    exit;
    }

require "../controller/controller.php";

$id_nilai = $_GET['id_nilai'];
$dataNilaiById = mysqli_query($koneksi, "SELECT * FROM tb_nilai WHERE id_nilai = '$id_nilai'");
$dataNilaiById = mysqli_fetch_array($dataNilaiById);

if(isset($_POST['simpan'])) {
    
    if(edit_nilai($_POST, $id_nilai) > 0) {

        echo "<script>
        alert('Data berhasil di edit');
        document.location.href='nilai.php';
        </script>";
    }else {
        echo "<script>
        alert('Data gagal di edit');
        document.location.href='nilai.php';
        </script>";
    }
}

?>

<?php
        include "layouts.php";
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
                <div class="topbar-divider d-none d-sm-block"></div <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="ml-2 d-none d-lg-inline text-white small"><?= $_SESSION['nama'] ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
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
                <h1 class="h3 mb-0 text-gray-800">Edit Data Nilai Siswa</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="siswa.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Data nilai siswa</li>
                </ol>
            </div>

            <div class="row">
                <div class="card col-12 shadow p-4">
                    <form action="" method="post">
                        <div class="row mt-3">
                            <div class="col-lg-2 col-md-2 col-12">
                                <label for="id_siswa">Siswa</label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <select name="id_siswa" id="select2Single" class="select2-single form-control" required>
                                    <?php
                                        $dataSiswa = mysqli_query($koneksi, "SELECT * FROM tb_siswa ORDER BY id_siswa ASC");
                                        foreach ($dataSiswa as $siswa) : ?>
                                    <option value="<?= $siswa['id_siswa'] ?>"
                                        <?php if($dataNilaiById['id_siswa'] == $siswa['id_siswa']) echo "selected" ?>>
                                        <?= $siswa['nama_siswa'] ?>
                                    </option>

                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-2 col-md-2 col-12">
                                <label for="nilai_rata_rata">Rata-Rata</label>
                            </div>
                            <div class="col-lg-3 col-md-3 col-12">
                                <input type="number" step="any" value="<?= $dataNilaiById['nilai_rata_rata'] ?>"
                                    name="nilai_rata_rata" id="nilai_rata_rata" class="form-control"
                                    placeholder="nilai rata-rata: xxxxx" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-2 col-md-2 col-12">
                                <label for="nilai_rangking">Rangking</label>
                            </div>
                            <div class="col-lg-3 col-md-3 col-12">
                                <input type="number" name="nilai_rangking" id="nilai_rangking"
                                    value="<?= $dataNilaiById['nilai_rangking'] ?>" class="form-control"
                                    placeholder="nilai rangking: xxxxx" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-2 col-md-2 col-12">
                                <label for="nilai_sikap">Sikap</label>
                            </div>
                            <div class="col-lg-3 col-md-3 col-12">
                                <input type="number" name="nilai_sikap" id="nilai_sikap"
                                    value="<?= $dataNilaiById['nilai_sikap'] ?>" class="form-control"
                                    placeholder="nilai sikap: xxxxx" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-2 col-md-2 col-12">
                                <label for="nilai_ekstrakurikuler">Ekstrakurikuler</label>
                            </div>
                            <div class="col-lg-3 col-md-3 col-12">
                                <input type="number" name="nilai_ekstrakurikuler" id="nilai_ekstrakurikuler"
                                    class="form-control" value="<?= $dataNilaiById['nilai_ekstrakurikuler'] ?>"
                                    placeholder="nilai ekstrakurikuler: xxxx" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-2 col-md-2 col-12">
                                <label for="nilai_prestasi">Prestasi</label>
                            </div>
                            <div class="col-lg-3 col-md-3 col-12">
                                <input type="number" name="nilai_prestasi" id="nilai_prestasi" class="form-control"
                                    value="<?= $dataNilaiById['nilai_prestasi'] ?>" placeholder="nilai prestasi: xxxxx"
                                    required>
                            </div>
                        </div>
                        <div class="mt-5 row">
                            <div>
                                <button type="submit" name="simpan" class="btn btn-success m-3">simpan</button>
                            </div>
                            <div>
                                <a href="nilai.php" class="btn btn-warning m-3">kembali</a>
                            </div>

                        </div>
                    </form>
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
<!-- Select2 -->
<script src="../../vendor/select2/dist/js/select2.min.js"></script>
<!-- Bootstrap Datepicker -->
<script src="../../vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap Touchspin -->
<script src="../../vendor/bootstrap-touchspin/js/jquery.bootstrap-touchspin.js"></script>
<!-- ClockPicker -->
<script src="../../vendor/clock-picker/clockpicker.js"></script>

<!-- Page level custom scripts -->
<script>
$(document).ready(function() {
    $('#dataTable').DataTable(); // ID From dataTable 
    $('#dataTableHover').DataTable(); // ID From dataTable with Hover
});
</script>
<script>
$(document).ready(function() {


    $('.select2-single').select2();

    // Select2 Single  with Placeholder
    $('.select2-single-placeholder').select2({
        placeholder: "Select a Province",
        allowClear: true
    });

    // Select2 Multiple
    $('.select2-multiple').select2();

    // Bootstrap Date Picker
    $('#simple-date1 .input-group.date').datepicker({
        format: 'dd/mm/yyyy',
        todayBtn: 'linked',
        todayHighlight: true,
        autoclose: true,
    });

    $('#simple-date2 .input-group.date').datepicker({
        startView: 1,
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true,
        todayBtn: 'linked',
    });

    $('#simple-date3 .input-group.date').datepicker({
        startView: 2,
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true,
        todayBtn: 'linked',
    });

    $('#simple-date4 .input-daterange').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true,
        todayBtn: 'linked',
    });

    // TouchSpin

    $('#touchSpin1').TouchSpin({
        min: 0,
        max: 100,
        boostat: 5,
        maxboostedstep: 10,
        initval: 0
    });

    $('#touchSpin2').TouchSpin({
        min: 0,
        max: 100,
        decimals: 2,
        step: 0.1,
        postfix: '%',
        initval: 0,
        boostat: 5,
        maxboostedstep: 10
    });

    $('#touchSpin3').TouchSpin({
        min: 0,
        max: 100,
        initval: 0,
        boostat: 5,
        maxboostedstep: 10,
        verticalbuttons: true,
    });

    $('#clockPicker1').clockpicker({
        donetext: 'Done'
    });

    $('#clockPicker2').clockpicker({
        autoclose: true
    });

    let input = $('#clockPicker3').clockpicker({
        autoclose: true,
        'default': 'now',
        placement: 'top',
        align: 'left',
    });

    $('#check-minutes').click(function(e) {
        e.stopPropagation();
        input.clockpicker('show').clockpicker('toggleView', 'minutes');
    });

});
</script>
</body>

</html>