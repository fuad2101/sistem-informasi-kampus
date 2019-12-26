<?php

// KONEKSI dengan mySQL
$dbbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dblink = mysqli_connect($dbbhost,$dbuser,$dbpass);
// tampilkan pesan kesalahan jika gagal koneksi
if (!$dblink){
    echo"Koneksi database gagal ! <br>".mysqli_connect_errno($dblink).mysqli_connect_error($dblink);
}else {
    echo"Koneksi database berhasil ! <br>";
}

// BUAT DATABASE JIKA BELUM ADA
$query = "CREATE DATABASE IF NOT EXISTS kampusku";
$proses = mysqli_query($dblink,$query);
if ($proses) {
    echo"Pembuatan database berhasil ! <br>";
}else {
    echo"Pembuatan database gagal ! <br>".mysqli_errno($dblink).mysqli_error($dblink);
}

$proses = mysqli_select_db($dblink,"kampusku");

// HAPUS TABEL 
$query = "DROP TABLE IF EXISTS mahasiswa";
$proses = mysqli_query ($dblink,$query);
if ($proses) {
    echo"Tabel terhapus ! <br>";
}else {
    echo"Hapus tabel gagal ! <br>".mysqli_errno($dblink).mysqli_error($dblink);
}


// BUAT TABLE
$proses = mysqli_select_db($dblink,"kampusku");
$query = "CREATE TABLE mahasiswa (nim CHAR(10),nama VARCHAR(50),tempat_lahir VARCHAR(50),tanggal_lahir DATE,fakultas VARCHAR(50),jurusan VARCHAR(100),ipk DECIMAL (3,2),foto VARCHAR(10)PRIMARY KEY (nim));";
$proses = mysqli_query($dblink,$query);

if ($proses) {
    echo"Pembuatan tabel berhasil ! <br>";
}else {
    echo"Pembuatan tabel gagal ! <br>".mysqli_errno($dblink).mysqli_error($dblink);
}

// QUERY INSERT DATA
$query = "INSERT INTO mahasiswa VALUES ('D0213072','Muhammad Fuad','Mekkah','1994-05-24','Teknik','Teknik Informatika',4.0),('D0845793','Nur Supianto','Majene','1995-03-03','Teknik','Teknik Informatika',3.5),('D0385490','Rahtul Hayani Faisal','Ambon','1985-07-17','Pertanian','Agribisnis',4.5),('F4890985','Rahmat Ahmad','Polewali','1645-06-13','Sospol','Hubungan Internasional',5.0),('D9386450','Juliet','Jakarta','1990-09-26','Teknik','Teknik Sipil',4.7),('D9846758','Megawati','Lembang','1994-02-18','Manajemen','Akuntansi',4.2),('A9848702','Muhammad Haidir','Makassar','1992-07-5','Hukum','Hukum Syariat Islam',3.8);";
$proses = mysqli_query($dblink,$query);

if ($proses) {
    $jumlah = mysqli_affected_rows($dblink);
    echo"Insert data berhasil ! $jumlah data dimasukkan ke tabel mahasiswa<br>";
}else {
    echo"Insert data gagal ! <br>".mysqli_errno($dblink).mysqli_error($dblink);
}

// Hapus tabel admin
$query = "DROP TABLE IF EXISTS admin";
$proses = mysqli_query($dblink,$query);

if($proses){
    echo "Tabel Admin berhasil dihapus <br>";
}else {
    "Query Error".mysqli_errno($proses).mysqli_error($proses);
}
// Buat tabel admin
$query = "CREATE TABLE admin (user VARCHAR(50),password VARCHAR(50))";
$proses = mysqli_query($dblink,$query);
if($proses){
    echo "Tabel Admin dibuat <br>";
}else {
    "Query Error".mysqli_errno($dblink).mysqli_error($dblink);
}

// Insert Data
$username = "fuad2101";
$password = sha1("yudistar");

$query = "INSERT INTO admin VALUES('$username','$password')";
$proses = mysqli_query($dblink,$query);

if ($proses) {
    $jumlah = mysqli_affected_rows($dblink);
    echo"Insert data berhasil ! $jumlah data dimasukkan ke tabel Admin<br>";
}else {
    echo"Insert data user gagal ! <br>".mysqli_errno($dblink).mysqli_error($dblink);
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

</body>
</html>