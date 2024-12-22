<?php
session_start();
include '../koneksi.php';

// Ambil ID kategori dari URL
$id_kategori = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data kategori untuk judul halaman
$kategori_query = mysqli_query($conn, "SELECT * FROM tbl_kategori WHERE id = $id_kategori");
$kategori = mysqli_fetch_array($kategori_query);
$nama_kategori = $kategori ? $kategori['nama_kategori'] : 'Kategori';

// Query untuk mengambil produk berdasarkan ID kategori
$produk_query = mysqli_query($conn, "SELECT * FROM tbl_produk WHERE id_kategori = $id_kategori");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk <?php echo htmlspecialchars($nama_kategori); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php include 'header/navbarsearch.php'; ?>

    <div class="container-fluid bg-light pt-4 pb-3">
        <h1 class="text-center">Produk Kategori <?php echo htmlspecialchars($nama_kategori); ?></h1>
        <div class="row row-cols-1 row-cols-md-6 g-4 pt-3">
            <?php
                while ($row = mysqli_fetch_array($produk_query)) {
                    $id_produk = $row['id'];
                    $nama_produk = $row['nama_produk'];
                    $gambar_produk = $row['gambar'];
                    $harga = $row['harga'];
            ?>
                <a href="beli.php?id=<?php echo $id_produk; ?>" class="col text-decoration-none">
                    <div class="card h-100">
                        <img src="http://localhost/E-commerce/E-commerce/website/gambar/<?php echo $gambar_produk; ?>" class="card-img-top border-bottom" alt="Foto Produk" height="200px">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($nama_produk); ?></h5>
                            <p class="card-text" style="color: orange;">Rp.<?php echo number_format($harga,0,',','.'); ?></p>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>

    <footer class="py-5 bg-dark">
        <div class="container-fluid">
            <p class="m-0 text-center text-white">Copyright &copy; E-Commerce 2024</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
