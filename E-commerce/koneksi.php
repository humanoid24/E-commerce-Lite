<?php 
    $host = "localhost";
    $name = "root";
    $pass = "";
    $db = "commercer";
    
    $conn = mysqli_connect($host,$name,$pass,$db);

    // if (!$conn) {
    //     die("koneksi gagal: ".mysqli_connect_error());
    // }
    // echo "Koneksi berhasil";
?>