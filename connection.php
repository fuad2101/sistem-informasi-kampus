<?php

$dbbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "kampusku";
$dblink = mysqli_connect("$dbbhost","$dbuser","$dbpass","$dbname");

// tampilkan pesan kesalahan jika gagal koneksi
// if (!$dblink){
//     echo"Koneksi database gagal ! <br>".mysqli_connect_errno($dblink).mysqli_connect_error($dblink);
// }else {
//     echo"Koneksi database berhasil ! <br>";
// }



?>