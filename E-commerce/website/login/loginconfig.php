<?php
session_start();
include '../../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi sederhana
    if (empty($username) || empty($password)) {
        die("Username dan password harus diisi!");
    }

    // Prepare statement untuk menghindari SQL Injection
    $query = $conn->prepare("SELECT id, username, password FROM tbl_user WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // echo "Password di database: " . $row['password'] . "<br>";
        // echo "Password yang dimasukkan: " . $password . "<br>";
        // Verifikasi password (tanpa hashing)
        if ($password === $row['password']) {
            // Login berhasil
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header('Location: ../dashboard.php'); // Ganti dengan halaman dashboard Anda
            exit;
        } else {
            unset($_SESSION['pesan_error']);
            $_SESSION['pesan_error'] = "Login Gagal. ID atau password salah.";
            header('Location:login.php');
            exit();
        }
    } else {
        unset($_SESSION['pesan_error']);
        $_SESSION['pesan_error'] = "Login Gagal. ID atau password salah.";
        header('Location:login.php');
    }

    $query->close();
    $conn->close();
}
?>
