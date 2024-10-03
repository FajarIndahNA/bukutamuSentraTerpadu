<?php 
    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "db_bukutamu";
    $koneksi = mysqli_connect($server,$user,$password,$db) or die(mysqli_error($koneksi));
?>