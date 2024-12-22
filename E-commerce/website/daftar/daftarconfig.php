<?php 
session_start();
include '../../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namalengkap = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasipassword'];
    $alamat = $_POST['alamat'];
    $notlp = $_POST['notelp'];

    // Validasi sederhana
    if (empty($namalengkap) || empty($username) || empty($password) || empty($konfirmasi) || ($password != $konfirmasi)|| empty($alamat) || empty($notlp)) {
        $_SESSION['nama'] = $namalengkap;
        $_SESSION['username'] = $username;
        $_SESSION['alamat'] = $alamat;
        $_SESSION['notelp'] = $notlp;
        $_SESSION['pesan_error'] = "Password dan konfirmasi password tidak cocok";
        // die("Username sudah digunakan oleh orang lain");
        header("location: daftar.php");
        die("Konfirmasi password salah");
    }

    $cek_username = $conn->prepare("SELECT username FROM tbl_user WHERE username = ?");
    $cek_username->bind_param("s",$username);
    $cek_username->execute();
    $cek_username->store_result();

    if ($cek_username->num_rows > 0) {
        $_SESSION['nama'] = $namalengkap;
        $_SESSION['alamat'] = $alamat;
        $_SESSION['notelp'] = $notlp;
        $_SESSION['password'] = $password;
        $_SESSION['konfirmasipassword'] = $konfirmasi;
        $_SESSION['pesan_error'] = "Username sudah digunakan orang lain";
        // die("Username sudah digunakan oleh orang lain");
        header("location: daftar.php");
        exit;
    }

    // Prepare statement untuk menghindari SQL Injection
    $query = $conn->prepare("INSERT INTO tbl_user (nama, username, password, alamat, no_telepon) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("sssss", $namalengkap, $username, $password, $alamat, $notlp);

    if ($query->execute()) {
        // Hapus data yang dimasukkan sebelumnya dari sesi (jika ada)
        unset($_SESSION['nama']);
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['konfirmasipassword']);
        unset($_SESSION['alamat']);
        unset($_SESSION['notelp']);
        // Simpan pesan berhasil jika sudah melakukan pendaftaran
        $_SESSION['pesan_berhasil'] = "Pendaftaran Telah Berhasil. Silahkan Login";
        // Alihkan pengguna ke login
        header('Location: ../login/login.php');
        exit;
    } else {
        echo "Pendaftaran gagal: " . $query->error;
    }

    $query->close();
    $conn->close();
}
?>
