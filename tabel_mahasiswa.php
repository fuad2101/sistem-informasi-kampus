<?php
session_start();
if (!isset($_SESSION['nama'])) {
    header("Location: index.php");
}

if (isset($_POST['search']) ) {
    include ("connection.php");

    $nama = htmlentities(strip_tags(trim($_GET['cari_nama'])));
    if (isset($nama)) {
        $query = "SELECT * FROM mahasiswa WHERE nama LIKE '%$nama%'";
        $result = mysqli_query ($dblink,$query);
        $nama = mysqli_real_escape_string($dblink,$nama);

    }

}else {
    $nama = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tabel Mahasiswa</title>
    <link rel="icon" href="img/favicon.ico">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="container">
        
    <?php include("header.php"); ?>

            <h3>Data Mahasiswa</h3>
            <?php 
            if (isset($_GET['message'])) {
                $success_message = $_GET['message'];
                echo "<div class=\"success_message\">".$success_message."</div>";
            }
            ?>

            <table border=1>

            <thead>
                
                <th>Nim</th>
                <th>Nama</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Fakultas</th>
                <th>Jurusan</th>
                <th>Ipk</th>
            </thead>

                <?php
                    if (isset($_GET['search']) ) {
                        include ("connection.php");
                        $nama = htmlentities(strip_tags(trim($_GET['cari_nama'])));
                        if (isset($nama)) {
                            $query = "SELECT * FROM mahasiswa WHERE nama LIKE '%$nama%'";
                            $result = mysqli_query ($dblink,$query);
                            $nama = mysqli_real_escape_string($dblink,$nama);
                        }
                }else {
                    include ("connection.php");
                    $query = "SELECT * FROM mahasiswa";
                    $result =  mysqli_query($dblink,$query);
                }

                if ($result) {
                    $jumlah_data = mysqli_num_rows($result);
                    for ($i=0; $i < $jumlah_data ; $i++) { 
                    $data = mysqli_fetch_assoc($result);
                        echo "<tr>";
                        echo "<td>{$data['nim']} </td>";
                        echo "<td>{$data['nama']}</td>";
                        echo "<td>{$data['tempat_lahir']}</td>";
                        echo "<td>{$data['tanggal_lahir']}</td>";
                        echo "<td>{$data['fakultas']}</td>";
                        echo "<td>{$data['jurusan']}</td>";
                        echo "<td>{$data['ipk']}</td>";
                        echo"</tr>";

                    }
                }

                mysqli_free_result($result);
                mysqli_close($dblink);

                ?>


            </table>
            <p class="copy"><small>Copyright &copy 2019 DuniaIlkom</small></p>

    </div>

    
</body>
</html>