<?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        // Jika belum login, arahkan kembali ke halaman login
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <?php
            if(isset($_SESSION['pesan_berhasil'])){
                echo'<div class="pesan_berhasil" id="sukses" style="color: blue;">'. $_SESSION['pesan_berhasil'] .'</div>';
                unset($_SESSION['pesan_berhasil']);
            } 
            if (isset($_SESSION['pesan_error'])) {
                echo '<p id="pesan" style="color: red;">' . $_SESSION['pesan_error'] . '</p>';
                unset($_SESSION['pesan_error']);
            }
        ?>
        <h1>Login</h1>
        <form action="loginconfig.php" method="post">
            <label>Username</label>
            <input type="text" name="username" required><br>
            <label>Password</label>
            <input type="password" name="password" required><br>
            <button type="submit">Log in</button>
            <br>
            <br>
            <p style="color: white;">Belum punya akun?<a href="../daftar/daftar.php"> Daftar</a></p>
            <a href="../../homeles.php">Kembali ke home</a>
        </form>
    </div>

<script>
    var errorpesan =document.getElementById("pesan");
    if(errorpesan){
        setTimeout(function(){
            errorpesan.style.display = "none";
        }, 5000);
    }
    var succes =document.getElementById("sukses");
    if(succes){
        setTimeout(function(){
            succes.style.display = "none";
        }, 5000);
    }
</script>
</body>
</html>