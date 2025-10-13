<?php

$host = "localhost";
$user = "root";
$pass = "";     
$db = "db_topup_uc";

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}
?>