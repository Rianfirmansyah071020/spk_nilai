<?php

session_start();

if($_SESSION['akses'] === 'sistem_nilai') {

    $_SESSION['akses'] = null;
}

$_SESSION['akses'] = 'menu_admin';

header('Location:dashboard.php');

?>