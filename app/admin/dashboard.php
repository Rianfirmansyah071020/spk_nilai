<?php
session_start();

    if($_SESSION['login'] !== true) {

    header('location:../logout/index.php');
    exit;
    }

require "../controller/controller.php";

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
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>

            <div class="row p-3 justify-content-center align-content-center">
                <?php if($_SESSION['level'] === 'admin') : ?>
                <div
                    class="col-lg-4 col-12 card p-4 m-2 <?php if($_SESSION['akses'] == 'menu_admin'){ ?> bg-info  <?php } ?>">

                    <a href="session_admin.php"
                        class="text-decoration-none <?php if($_SESSION['akses'] == 'menu_admin'){ ?> text-light   <?php } ?>">Menu
                        Admin</a>
                </div>
                <?php endif ?>
                <div
                    class="col-lg-4 col-12 card p-4 m-2 <?php if($_SESSION['akses'] == 'sistem_nilai'){ ?> bg-info  <?php } ?>">
                    <a href="session_sistem_nilai.php"
                        class="text-decoration-none <?php if($_SESSION['akses'] == 'sistem_nilai'){ ?> text-light  <?php } ?>">Sistem
                        Nilai</a>

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