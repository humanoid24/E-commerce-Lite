<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<header>
    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-primary">
        <div class="container-fluid bg-primary">
            <img class="navbar-brand" src="website/fotologo/e-commerce.png" width="100px" height="50px">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="website/login/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="website/daftar/daftar.php">Daftar</a>
                    </li>
                </ul>
            </div>
            <ul class="navbar-nav col-lg-7 justify-content-lg-start">
                <li class="nav-item position-relative">
                    <a class="nav-link" aria-current="page" href="website/login/"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                        </svg><span class="badge rounded-pill badge-notification bg-danger position-absolute" style="top: -5px; right: -10px;"></a>
                </li>
                <li class="nav-item ps-4 position-relative">
                    <a class="nav-link" aria-current="page" href="daftarkeinginan.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                        </svg><span class="badge rounded-pill badge-notification bg-danger position-absolute" style="top: -5px; right: -10px;"></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

</header>

<body>
    <div class="d-flex justify-content-center pb-3 pt-3">
        <!-- Carousel -->
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div id="demo" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="website/gambarkategori/KesehatanKecantikan.jpg" alt="kesehatan" width="900px" height="300px" class="d-block w-20">
                    </div>
                    <div class="carousel-item">
                        <img src="website/gambarkategori/Perhiasan.jpg" alt="Chicago" width="900px" height="300px" class="d-block w-20">
                    </div>
                    <div class="carousel-item">
                        <img src="website/gambarkategori/alatmusik.jpg" alt="New York" width="900px" height="300px" class="d-block w-20">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid bg-light pt-4 pb-3">
        <h1 class="text-center">Rekomendasi</h1>
        <div class="row row-cols-1 row-cols-md-6 g-4 pt-3">
            <?php
            include 'koneksi.php';
            $view = mysqli_query($conn, "SELECT tbl_produk.*, tbl_kategori.nama_kategori FROM tbl_produk 
                                    LEFT JOIN tbl_kategori ON tbl_produk.id_kategori = tbl_kategori.id");
            while ($rows = mysqli_fetch_array($view)) {
                $id_produk = mysqli_real_escape_string($conn, $rows['id']); ?>
                <a href="website/login/login.php" class="text-decoration-none">
                    <div class="card h-100">
                        <img src="http://localhost/E-commerce/E-commerce/website/gambar/<?php echo $rows['gambar']; ?>" class="card-img-top border-bottom" alt="Foto Produk" style="height: 200px; width: 100%; object-fit: contain;">
                        <div class="card-body">
                            <p class="card-text"><?php echo $rows['nama_kategori']; ?></p>
                            <h5 class="card-title"><?php echo $rows['nama_produk']; ?></h5>
                            <p class="card-text" style="color: orange;">Rp.<?php echo number_format($rows['harga'], 0, ',', '.'); ?></p>
                        </div>
                    </div>
                </a>
            <?php }
            ?>
        </div>
    </div>
    <footer class="py-5 bg-dark">
        <div class="container-fluid">
            <p class="m-0 text-center text-white">Copyright &copy; E-Commerce 2024</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alertMessage = document.getElementById('alertMessage');
            if (alertMessage) {
                // Tampilkan alert
                alertMessage.classList.add('show');
                alertMessage.classList.remove('fade');

                // Setelah 5 detik, hilangkan alert secara bertahap
                setTimeout(function() {
                    alertMessage.classList.remove('show');
                    alertMessage.classList.add('fade');

                    // Setelah efek fade selesai, hapus elemen dari DOM
                    setTimeout(function() {
                        alertMessage.remove();
                    }, 1500); // Durasi efek fade
                }, 5000); // 5000 milliseconds = 5 seconds
            }

        });
    </script>

</body>

</html>