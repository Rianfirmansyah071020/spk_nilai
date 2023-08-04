<?php

session_start();
$id_kelas = $_GET['id_kelas'];

$_SESSION['id_kelas'] = $id_kelas;

header('Location:pilih_kelas.php');

?>