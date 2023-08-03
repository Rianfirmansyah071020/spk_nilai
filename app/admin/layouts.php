<?php

error_reporting(false);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SMAN 13 Merangin</title>
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../../css/ruang-admin.min.css" rel="stylesheet">
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../vendor/select2/dist/css/select2.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul style="background-image: url(../../assets_home/img/bac2.jpg); background-size:cover;"
            class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <img src="../../assets_home/img/sekolah.jpeg">
                </div>
                <div class="sidebar-brand-text mx-3">Sistem Nilai</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <?php if($_SESSION['akses'] === 'menu_admin' && $_SESSION['level'] === 'admin')  : ?>

            <li class="nav-item active">
                <a class="nav-link" href="admin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Admin</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="siswa.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Siswa</span></a>
            </li>
            <hr class="sidebar-divider my-0">
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="kepsek.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Kepala Sekolah</span></a>
            </li>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="guru.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Guru</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="kelas.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Kelas</span></a>
            </li>
            <?php endif ?>

            <?php if($_SESSION['akses'] === 'sistem_nilai' && $_SESSION['level'] === 'admin') : ?>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Nilai
            </div>

            <li class="nav-item">
                <a class="nav-link" href="nilai.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Nilai Siswa</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="rating_kecocokan.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Rating Kecocokan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="hasil.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Hasil</span>
                </a>
            </li>
            <hr class="sidebar-divider">

            <?php endif ?>



            <?php if($_SESSION['akses'] === 'sistem_nilai' && $_SESSION['level'] === 'guru') : ?>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Nilai
            </div>
            <li class="nav-item">
                <a class="nav-link" href="hasil.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Hasil</span>
                </a>
            </li>
            <hr class="sidebar-divider">

            <?php endif ?>


            <?php if($_SESSION['akses'] === 'sistem_nilai' && $_SESSION['level'] === 'kepsek') : ?>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Nilai
            </div>
            <li class="nav-item">
                <a class="nav-link" href="hasil.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Hasil</span>
                </a>
            </li>
            <hr class="sidebar-divider">

            <?php endif ?>
            <div class="version" id="version-ruangadmin"></div>
        </ul>