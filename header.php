<p class="time">
        <?php $time = date('d M Y'); echo $time;?>

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
                    <form class="search_form" action="edit_mahasiswa.php" method="post">
                        <label for="cari_nama">Nama:</label>
                        <input type="search" name="cari_nama" id="">
                        <input type="submit" value="Search" name="search">
                    </form>
        </div>