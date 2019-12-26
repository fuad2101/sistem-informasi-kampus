<?php
session_start();
if (!isset($_SESSION['nama'])) {
    header("Location: index.php");
}

if (isset($_POST['update'])) {
    
    include("connection.php");
    $nim = htmlentities(strip_tags(trim(strtoupper($_POST['nim']))));
    $nama = htmlentities(strip_tags(trim(strtoupper($_POST['nama']))));
    $tempat_lahir = htmlentities(strip_tags(trim( strtoupper($_POST['tempat_lahir']))));
    $tanggal_lahir = htmlentities(strip_tags(trim(strtoupper($_POST['tanggal_lahir']))));
    $fakultas = htmlentities(strip_tags(trim(strtoupper($_POST['fakultas']))));
    $jurusan = htmlentities(strip_tags(trim(strtoupper($_POST['jurusan']))));
    $ipk = htmlentities(strip_tags(trim($_POST['ipk'])));
    
    $query = "UPDATE mahasiswa SET nama='$nama',tempat_lahir='$tempat_lahir',tanggal_lahir='$tanggal_lahir',fakultas='$fakultas',jurusan='$jurusan',ipk=$ipk WHERE nim='$nim';";
    $result = mysqli_query($dblink,$query);
        
    
    if ($result) {

        $nim = mysqli_real_escape_string($dblink,strtoupper($_POST['nim']));
        $nama = mysqli_real_escape_string($dblink,strtoupper($_POST['nama']));
        $tempat_lahir = mysqli_real_escape_string($dblink,strtoupper($_POST['tempat_lahir']));
        $tanggal_lahir = mysqli_real_escape_string($dblink,strtoupper($_POST['tanggal_lahir']));
        $fakultas = mysqli_real_escape_string($dblink,strtoupper($_POST['fakultas']));
        $jurusan = mysqli_real_escape_string($dblink,strtoupper($_POST['jurusan']));
        $ipk = mysqli_real_escape_string($dblink,$_POST['ipk']);
        
        $affect = mysqli_affected_rows($result);
        $success_message = "Perubahan Data $nama berhasil";
        $success_message = urlencode($success_message);
        echo "$affect data terupdate";
        header("Location: edit_mahasiswa.php?message=$success_message");
    }

    }else {

        include("connection.php");
        $nim = $_GET['nim'];
        $query = "SELECT  * FROM mahasiswa WHERE nim='$nim';";
        $result = mysqli_query($dblink,$query);
        $data = mysqli_fetch_assoc($result);

        $nim =$data['nim'];
        $nama =$data['nama'];
        $tempat_lahir =$data['tempat_lahir'];
        $tanggal_lahir =$data['tanggal_lahir'];
        $fakultas =$data['fakultas'];
        $jurusan =$data['jurusan'];
        $ipk =$data['ipk'];
        }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Mahasiswa | Kampusku</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="all.css">
    <style>
        .input_form label{
            display: inline-block;
            width: 120px;
        }
    </style>
</head>
<body>
    <div class="container">

        <p class="time">
        <?php $time = date('d M Y');
        echo $time;
        ?>
        </p>

        <h1>Sistem Informasi <span style="color: seagreen;">Kampusku</span> </h1>
        <hr>
        <div class="navigation">
            <ul>
                <li> <a href="tabel_mahasiswa.php">Tampil</a> </li>
                <li> <a href="tambah_mahasiswa.php">Tambah</a> </li>
                <li> <a href="edit_mahasiswa.php">Edit</a> </li>
                <li> <a href="hapus_mahasiswa.php">Hapus</a> </li>
                <li> <a href="logout.php">Logout</a> </li>
            </ul>
        </div>
            <h3>Form Edit Mahasiswa</h3>
            <form class="input_form" action="form_edit.php" method="post">
                <fieldset>
                    <!-- <legend>Mahasiswa Baru</legend> -->
                    <p>
                        <label for="">NIM:</label>
                        <input type="text" name="nim" maxlength="8" style="width:70px;text-align:center;" value="<?php if (isset($nim)) {echo $nim;} ?>" readonly disable>
                        <!-- <small style="color:grey;">Contoh: A1234567</small> -->
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
                            <option value="Teknik" $select_teknik >Teknik</option>
                            <option value="Manajemen" $select_manajemen>Manajemen</option>
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
                    </p>
                </fieldset>
                <input type="submit" value="Update" name="update">
            </form>
            <footer>
                <p class="copy"><small>Copyright &copy 2019 DuniaIlkom</small></p>
            </footer>
    </div>

<script src="js/all.js"></script>
</body>
</html>

<?php
    include("connection.php");
    mysqli_close($dblink);
?>