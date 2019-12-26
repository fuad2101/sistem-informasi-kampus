<?php
session_start();
if (!isset($_SESSION['nama'])) {
    header("Location: index.php");
}

if (isset($_POST['edit'])){
    include("connection.php");
    $nim = htmlentities(strip_tags(trim($_GET['nim'])));
    $nim = mysqli_real_escape_string($dblink,$nim);
    header("Location: form_edit.php?nim='$nim'");

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Mahasiswa</title>
    <link rel="icon" href="img/favicon.ico">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="container">
        <?php include("header.php"); ?>

            <h3>Edit Mahasiswa</h3>
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
                <th></th>
            </thead>

                <?php
                if (isset($_POST['search']) ) {
                    include ("connection.php");
                    $nama = htmlentities(strip_tags(trim($_POST['cari_nama'])));
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

                    while ($data = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$data['nim']} </td>";
                        echo "<td>{$data['nama']}</td>";
                        echo "<td>{$data['tempat_lahir']}</td>";
                        echo "<td>{$data['tanggal_lahir']}</td>";
                        echo "<td>{$data['fakultas']}</td>";
                        echo "<td>{$data['jurusan']}</td>";
                        echo "<td>{$data['ipk']}</td>";
                        ?>
                        <td>
                              <form action="form_edit.php" method="get">
                                <input type="submit" value="Edit" name="edit">
                                <input type="hidden" name="nim" value="<?php echo $data['nim']; ?>">
                            </form>
                        </td>
                <?php
                echo"</tr>";
            }
                mysqli_free_result($result);
            }
                ?>
            </table>
            <p class="copy"><small>Copyright &copy 2019 DuniaIlkom</small></p>

    </div>

    
</body>
</html>
<?php mysqli_close($dblink); ?>
