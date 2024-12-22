<?php
session_start();

include '../koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<?php
if (isset($_GET['search'])) {
    $cari = $_GET['search'];
}
?>

<body>
    <?php include 'header/navbarsearch.php'; ?>

    <!-- Tampilkan flash message jika ada -->
    <?php
    if (isset($_SESSION['pesan'])) {
        echo '<div class="alert alert-info">' . $_SESSION['pesan'] . '</div>';
        unset($_SESSION['pesan']); // Hapus pesan setelah ditampilkan
    }
    ?>
    <?php if (isset($_SESSION['message'])) : ?>
        <div id="alertMessage" class="alert alert-success alert-dismissible fade show alert-temporary" role="alert">
            <strong>Success!</strong> <?php echo htmlspecialchars($_SESSION['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); // Hapus pesan setelah ditampilkan 
        ?>
    <?php endif; ?>

    <div class="d-flex justify-content-center pb-3">
        <!-- Carousel -->
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div id="demo" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="gambarkategori/KesehatanKecantikan.jpg" alt="kesehatan" width="900px" height="300px" class="d-block w-20">
                    </div>
                    <div class="carousel-item">
                        <img src="gambarkategori/Perhiasan.jpg" alt="Chicago" width="900px" height="300px" class="d-block w-20">
                    </div>
                    <div class="carousel-item">
                        <img src="gambarkategori/alatmusik.jpg" alt="New York" width="900px" height="300px" class="d-block w-20">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-primary pt-4 pb-3">
        <h1 class="text-center">Kategori</h1>
        <div class="row row-cols-1 row-cols-md-6 g-4 pt-3">
            <?php
            include '../koneksi.php';
            $view_kategori = mysqli_query($conn, "SELECT * FROM tbl_kategori WHERE id");
            while ($row = mysqli_fetch_array($view_kategori)) {
                $id_kategori = $row['id'];
                $nama_kategori = $row['nama_kategori'];
                $gambar_kategori = $row['gambar_kategori']; ?>
                <a href="dashboardkategori.php?id=<?php echo $id_kategori; ?>" class="col text-decoration-none">
                    <div class="card h-100">
                        <img src="http://localhost/E-commerce/E-commerce/website/gambarkategori/<?php echo $row['gambar_kategori']; ?>" class="card-img-top border-bottom" alt="Foto Produk" height="200px">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['nama_kategori']; ?></h5>
                        </div>
                    </div>
                </a>
            <?php }
            ?>
        </div>
    </div>
    <br>
    <div class="container-fluid bg-light pt-4 pb-3">
        <h1 class="text-center">Rekomendasi</h1>
        <div class="row row-cols-1 row-cols-md-6 g-4 pt-3">
            <?php
            include '../koneksi.php';
            $view = mysqli_query($conn, "SELECT tbl_produk.*, tbl_kategori.nama_kategori FROM tbl_produk 
                                    LEFT JOIN tbl_kategori ON tbl_produk.id_kategori = tbl_kategori.id");
            while ($rows = mysqli_fetch_array($view)) {
                $id_produk = mysqli_real_escape_string($conn, $rows['id']); ?>
                <a href="beli.php?id=<?php echo $id_produk; ?>" class="text-decoration-none">
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