<?php
session_start();
if (!isset($_SESSION['nama'])) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
    echo"<pre>";
    print_r($_FILES);
    echo"</pre>";

    $nim = htmlentities(strip_tags(trim($_GET['nim'])));
    $nama = htmlentities(strip_tags(trim($_GET['nama'])));
    $tempat_lahir = htmlentities(strip_tags(trim($_GET['tempat_lahir'])));
    $tanggal_lahir = htmlentities(strip_tags(trim($_GET['tanggal_lahir'])));
    $fakultas = htmlentities(strip_tags(trim($_GET['fakultas'])));
    $jurusan = htmlentities(strip_tags(trim($_GET['jurusan'])));
    $ipk = htmlentities(strip_tags(trim($_GET['ipk'])));
    
    $error_message = "";
    
    include("connection.php");
    if (empty($nim)) {
        $error_message .= "<i class=\"fas fa-times-circle\"></i> NIM belum diisi ";
    }elseif (strlen($nim) > 8) {
        $error_message .= "Panjang NIM lebih dari 8 karakter ";
    }elseif (!preg_match("/[A-z]{1}[0-9]{7}/",$nim)) {
        $error_message .= "<i class=\"fas fa-times-circle\"></i> Format NIM tidak sesuai ";
    }
    $nim = mysqli_real_escape_string($dblink, strtoupper($_GET['nim']));
    $query = "SELECT * FROM mahasiswa WHERE nim='$nim'";
    $result = mysqli_query($dblink,$query);
    $jumlah_baris = mysqli_num_rows($result);

    if ( $jumlah_baris === 1){
        $error_message .= "<i class=\"fas fa-times-circle\"></i> NIM sudah ada ! ";
    }

    if (empty($nama)) {
        $error_message .= "<i class=\"fas fa-times-circle\"></i> Nama belum diisi";
    }
    if (!is_numeric($ipk) OR $ipk < 0 OR $ipk > 4) {
        $error_message .= " <i class=\"fas fa-times-circle\"></i> IPK tidak sesuai";
    }

    if (isset($fakultas)) {
        switch ($fakultas) {
            case 'teknik':
                $select_teknik = "selected";
                break;
            case 'manajemen':
                $select_manajemen = "selected";
                break;
        }
    }

    if (isset($_FILES['foto'])) {
        $folder_name = "img/";
        $filename = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp,"$folder_name,$filename");
    }


    if ($error_message === "") {
        include("connection.php");
        $nim = mysqli_real_escape_string($dblink, strtoupper($_GET['nim']));
        $nama = mysqli_real_escape_string($dblink, strtoupper ($_GET['nama']));
        $tempat_lahir = mysqli_real_escape_string($dblink,strtoupper($_GET['tempat_lahir']));
        $tanggal_lahir = mysqli_real_escape_string($dblink,strtoupper($_GET['tanggal_lahir']));
        $fakultas = mysqli_real_escape_string($dblink,strtoupper($_GET['fakultas']));
        $jurusan = mysqli_real_escape_string($dblink,strtoupper($_GET['jurusan']));
        $ipk = mysqli_real_escape_string($dblink,$_GET['ipk']);
        $foto = $_FILES['foto']['name'];


        $query = "INSERT INTO mahasiswa VALUES('$nim','$nama','$tempat_lahir','$tanggal_lahir','$fakultas','$jurusan',$ipk)";
        $result = mysqli_query($dblink,$query);

        if ($result) {
            $success_message =  "<b>$nama</b> berhasil dimasukkan dalam database";
            $success_message = urlencode($success_message);
            header("Location: tabel_mahasiswa.php?message=$success_message");
        }
    }

    
} elseif (isset($_POST['search'])) {
    include ("connection.php");
    $nama = htmlentities(strip_tags(trim($_GET['cari_nama'])));
    $nama = mysqli_real_escape_string($dblink,$nama);
    $query = "SELECT * FROM mahasiswa WHERE nama LIKE '%$nama%'";
    $result = mysqli_query ($dblink,$query);
    header("Location: tabel_mahasiswa.php");
} else {
    $error_message = "";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Mahasiswa | Kampusku</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="all.css">
    <style>
        .input_form label{
            display: inline-block;
            width: 120px;
        }
        div.form{
            float: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include("header.php"); ?>
            <h3>Tambah Mahasiswa</h3>
            <form class="input_form" action="tambah_mahasiswa.php" method="post" enctype="multipart/form-data">
                <fieldset>
                    <div class="form" style="">
                    <?php
                    if (!$error_message == "") {
                        echo "<div class=\"pesan_error\"> $error_message </div>"; }
                    ?>
                    <!-- <legend>Mahasiswa Baru</legend> -->
                    <p>
                        <label for="">NIM:</label>
                        <input type="text" name="nim" maxlength="8" style="width:70px;text-align:center;" value="<?php if (isset($nim)) {echo $nim;}?>">
                        <small style="color:grey;">Contoh: A1234567</small>
                    </p>

                    <p>
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="" value="<?php if (isset($nama)) {echo $nama;}?>" value="Dummy Text">
                    </p>

                    <p>
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="" value="<?php if (isset($tempat_lahir)) {echo $tempat_lahir;}?>" value="Dummy Text">
                    </p>
                    <p>
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="" value="<?php if (isset($tanggal_lahir)) {echo $tanggal_lahir;}?>">
                    </p>
                    <p>
                        <label for="fakultas">Fakultas</label>
                        <select name="fakultas" id="">
                            <option value="teknik" $select_teknik >Teknik</option>
                            <option value="manajemen" $select_manajemen>Manajemen</option>
                        </select>
                    </p>
                    <p>
                        <label for="jurusan">Jurusan</label>
                        <input type="text" name="jurusan" id="" value="<?php if (isset($jurusan)) {echo $jurusan;}?>" value="Dummy Text">
                        <!-- <select name="jurusan" id="">
                            <?php
                            $array_teknik = ['Teknik Informatika','Teknik Sipil'];
                            $array_ekonomi = ['Manajemen','Akuntansi'];
                            if (!empty($_GET['fakultas'])) {
                                $fakultas = $_GET['fakultas'];
                                switch ($fakultas) {
                                    case 'teknik':
                                        foreach ($array_teknik as $value) {
                                            echo "<option value=\"$value\">$value</option>";
                                        }
                                        break;
                                    case 'manajemen':
                                        foreach ($array_ekonomi as $value) {
                                            echo "<option value=\"$value\">$value</option>";
                                        }
                                        break;
                                }
                            }else {
                                $fakultas = "";
                            }
                            ?>
                        </select> -->
                    </p>
                    <p>
                        <label for="ipk">IPK</label>
                        <input type="text" name="ipk" id="" maxlength="3" style="width:50px;text-align:center;" value="">
                        <small>(Nilai Desimal dipisah dengan tanda titik. Contoh : 4.0)</small>
                    </p>
                    <p>
                            <label for="foto">Upload Foto</label>
                            <input type="file" name="foto" id="" value="Upload Foto" accept="image/*">
                    </p>
                </div>
                    <!-- <div class="frame" style="background-color: grey;width:200px;height: 250px;display: inline-block;float: right;">

                    </div> -->
                    
                </fieldset>
                <input type="submit" value="Tambah Data" name="submit">
            </form>


            <footer>
                <p class="copy"><small>Copyright &copy 2019 DuniaIlkom</small></p>
            </footer>

    </div>
    <?php
    include("connection.php");
    mysqli_close($dblink);
    ?>

<script src="js/all.js"></script>

</body>
</html>