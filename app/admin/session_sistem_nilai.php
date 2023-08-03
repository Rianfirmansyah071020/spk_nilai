<?php

session_start();

if($_SESSION['akses'] === 'menu_admin') {

    $_SESSION['akses'] = null;
}

$_SESSION['akses'] = 'sistem_nilai';

header('Location:dashboard.php')

?>