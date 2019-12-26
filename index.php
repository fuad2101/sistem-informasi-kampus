<?php
session_start();
if (isset($_SESSION['nama'])) {
    header("Location: tabel_mahasiswa.php");
}
if (isset($_POST{'submit'})) {

    $pesan_error = "";
    $user = htmlentities(strip_tags(trim($_POST['username'])));
    $pass = htmlentities(strip_tags(trim($_POST['password'])));

    if (empty($user) AND empty($pass)) {
        $pesan_error = "Masukkan Username dan Password !";
    }elseif (empty($user)) {
        $pesan_error = "Masukkan Username !";
    }elseif (empty($pass)) {
        $pesan_error = "Masukkan Password !";
    }


    // koneksi database
    include("connection.php");
    $user = mysqli_real_escape_string($dblink,$user);
    $pass = mysqli_real_escape_string($dblink,$pass);
    $pass_sha1 = sha1($pass);
    $query = "SELECT * FROM admin WHERE user='$user' AND password='$pass_sha1';";
    $result = mysqli_query($dblink,$query);



    if (mysqli_num_rows($result) == 0){
        $pesan_error= "Username atau password salah";
    }


    if ($pesan_error === ""){
        session_start();
        $_SESSION['nama'] = $user;
        header("Location: tabel_mahasiswa.php");
    }

    mysqli_free_result($result);
    mysqli_close($dblink);


    
} else {
    $pesan_error = "";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <style>
        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url(img/full-image9.jpg);
            /* height: 50vh; */
            /* background-color: rgba(0, 0, 0, 0.1); */
        }
        .overlay{
            /* padding: 0;
            margin: 0;
            background-color: rgba(0, 0, 0,0.3);
            height: 200vh; */
        }
        .container{
            width: 30%;
            margin: 20vh auto;
            box-shadow: -1px 2px 20px -3px;
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.8);
        }
        h1,h3{
            text-align: center;
        }
        label{
            display: inline-block;
            width:100px;
        }
        p,legend{
            text-align: center;
        }
        input[type="submit"]{
            padding: 10px;
            width: 30%;
            display: block;
            margin: 0 auto;
        }


    </style>
</head>
<body>
    <!-- <div class="overlay"> -->

<div class="container">

<h1>Selamat Datang</h1>
<h3>Sistem informasi Kampusku</h3>
    <form action="" method="post">
        <fieldset>
            <legend>Login</legend>
            <?php echo "<p style=\"color:red;\"> $pesan_error</p>";?>
            <p>
                <label for="username">Username</label>
                <input type="text" name="username" id="">
            </p>

            <p>
                <label for="password">Password</label>
                <input type="password" name="password" id="">
            </p>

            <input type="submit" value="Login" name="submit">
        </fieldset>
    </form>

</div>
<!-- </div> -->


</body>
</html>