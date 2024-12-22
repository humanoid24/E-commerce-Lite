<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="login.css">
    <?php
        session_start(); 
    ?>
</head>
<body>
    <div class="container">
        <h1>Daftar</h1>
        <form action="daftarconfig.php" method="post">
            <?php 
                if (isset($_SESSION['pesan_error'])) {
                    echo '<p class="error" style="color: red;">' . $_SESSION['pesan_error'] . '</p>';
                    unset($_SESSION['pesan_error']); // Hapus pesan setelah ditampilkan
                    echo '<script>hideErrorMessage();</script>'; // Panggil fungsi JavaScript untuk menyembunyikan pesan
                }
            ?>
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="<?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : ''; ?>" required><br>
            <label>Username</label>
            <input type="text" name="username" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>" required><br>
            <label>Password</label>
            <input type="password" name="password" value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ''; ?>" required><br>
            <label>Konfirmasi password</label>
            <input type="password" name="konfirmasipassword"  value="<?php echo isset($_SESSION['konfirmasipassword']) ? $_SESSION['konfirmasipassword'] : ''; ?>" required><br>
            <label>Alamat</label>
            <input type="text" name="alamat" value="<?php echo isset($_SESSION['alamat']) ? $_SESSION['alamat'] : ''; ?>" required><br>
            <label>No telepon</label>
            <input type="text" name="notelp" value="<?php echo isset($_SESSION['notelp']) ? $_SESSION['notelp'] : ''; ?>" required><br>
            <button type="submit">Daftar</button>
            <br>
            <br>
            <p style="color: white;">Sudah punya akun?<a href="../login/login.php"> Login</a></p>
            <a href="../../homeles.php">Kembali ke home</a>
        </form>
    </div>

    <script>
        // Fungsi untuk menyembunyikan pesan kesalahan setelah 3 detik
        function hideErrorMessage() {
            var errorElement = document.querySelector('.error');
            if (errorElement) {
                setTimeout(function() {
                    errorElement.style.display = 'none';
                }, 3000); // 3000 milidetik (3 detik)
            }
        }
            // Panggil fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function () {
        hideErrorMessage();
    });
    </script>
</body>
</html>