<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css">  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<?php
    if (isset($_GET['search'])) {
        $cari = $_GET['search'];
    }
?>
<body>
    <?php
        include 'header/navbarsearch.php';
    ?>
    <?php
        include '../koneksi.php'; // Hubungkan ke database

        // Cek apakah user telah login
        if (!isset($_SESSION['user_id'])) {
            header("Location: login/login.php");
            exit();
        }

        // Tangkap kata kunci pencarian dari URL jika ada
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = mysqli_real_escape_string($conn, $_GET['search']);

            // Buat query pencarian
            $query = "SELECT tbl_produk.*, tbl_kategori.nama_kategori 
                    FROM tbl_produk 
                    LEFT JOIN tbl_kategori ON tbl_produk.id_kategori = tbl_kategori.id
                    WHERE tbl_produk.nama_produk LIKE '%$search%'";

            $result = mysqli_query($conn, $query);
    ?>
    <div class="container-fluid bg-light pt-4 pb-3">
        <h1 class="text-center">Berdasarkan Pencarian</h1>
        <div class="row row-cols-1 row-cols-md-6 g-4 pt-3">
        <?php 
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id_produk = $row['id'];
                    // Tampilkan produk sesuai hasil pencarian
                    ?>
                    <a href="beli.php?id=<?php echo $id_produk; ?>" class="col text-decoration-none">
                        <div class="card h-100 ">
                            <img src="http://localhost/E-commerce/E-commerce/website/gambar/<?php echo $row['gambar'];?>" class="card-img-top border-bottom" alt="Foto Produk" height="200px">
                            <div class="card-body">
                                <p class="card-text"><?php echo $row['nama_kategori'];?></p>
                                <h5 class="card-title"><?php echo $row['nama_produk'];?></h5>
                                <p class="card-text" style="color: orange;">Rp.<?php echo number_format($row['harga'],0,',','.'); ?></p>
                            </div>
                        </div>
                    </a>
            <?php 
            }
        } else {
            ?>
        </div>
        <div class="container vh-100">
            <div class="row h-100">
                <div class="col d-flex justify-content-center align-items-center">
                    <h1>Produk Tidak Ditemukan</h1>
                </div>
            </div>
        </div>

        <?php
    }
    ?>
    </div>
    <?php
} else {
    // Jika tidak ada pencarian, tampilkan semua produk seperti biasa
    $query = "SELECT tbl_produk.*, tbl_kategori.nama_kategori 
              FROM tbl_produk 
              LEFT JOIN tbl_kategori ON tbl_produk.id_kategori = tbl_kategori.id";

    $result = mysqli_query($conn, $query);
    ?>
    <div class="d-flex justify-content-center">
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div id="demo" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://www.exabytes.co.id/blog/wp-content/uploads/2021/10/sorabel-1024x512.png" alt="Los Angeles" width="900px" height="300px" class="d-block w-20">
                    </div>
                    <div class="carousel-item">
                        <img src="https://www.exabytes.co.id/blog/wp-content/uploads/2021/10/hijabenka-e-commerce-fashion-indonesia-1024x492.png" alt="Chicago" width="900px" height="300px" class="d-block w-20">
                    </div>
                    <div class="carousel-item">
                        <img src="https://cdn.popmama.com/content-images/community/20221009/community-f0432ac71b4a89220fe5fab3fbcacdbe.jpg?1665307299" alt="New York" width="900px" height="300px" class="d-block w-20">
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
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id_produk = $row['id'];
                // Tampilkan produk seperti biasa
                ?>
            <a href="beli.php?id=<?php echo $id_produk; ?>" class="col text-decoration-none">
                <div class="card h-100 ">
                    <img src="http://localhost/E-commerce/E-commerce/website/gambar/<?php echo $row['gambar'];?>" class="card-img-top border-bottom" alt="Foto Produk" height="200px">
                    <div class="card-body">
                        <p class="card-text"><?php echo $row['nama_kategori'];?></p>
                        <h5 class="card-title"><?php echo $row['nama_produk'];?></h5>
                        <p class="card-text" style="color: orange;">Rp.<?php echo number_format($row['harga'],0,',','.'); ?></p>
                    </div>
                </div>
            </a>
            <?php 
            }
        }else {
            echo "Belom ada Produk";
        }
        ?>
        </div>
    </div>
    <?php   
}
mysqli_close($conn);
?>
    <footer class="py-5 bg-dark">
            <div class="container-fluid"><p class="m-0 text-center text-white">Copyright &copy; E-Commerce 2024</p></div>
    </footer>
</body>
</html>
