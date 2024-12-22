<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit();
}
include '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Penjualan Saya</title>
</head>
<style>
    .table th{
        text-align: center;
    }
    
</style>
<header>
    <?php 
        include 'header/navbar.php';
    ?>
</header>
<body>
    <div class="container-fluid bg-primary p-2">
    <h1 style="text-align: center;">Barang Yang di jual</h1>
    <br>
        <div class="container-lg">
        <table class="table table-bordered border-primary">
            <?php
                include '../koneksi.php';

                if (isset($_GET['id_del'])) {
                    $id = mysqli_real_escape_string($conn,$_GET['id_del']);

                    // Menghapus gambar sampul
                    $query_hapus = "DELETE FROM tbl_produk WHERE id = '$id'";
                    $result_hapus_produk = mysqli_query($conn, $query_hapus);

                    if ($result_hapus_produk) {
                        $query_pilih_gambar = "SELECT gambar FROM tbl_produk WHERE id = '$id'";
                        $result_pilih_gambar = mysqli_query($conn,$query_pilih_gambar);
                        $data_pilih_gambar = mysqli_fetch_assoc($result_pilih_gambar);

                        if (!empty($data_pilih_gambar['gambar'])) {
                            $path_gambar = 'gambar/'.$data_pilih_gambar['gambar'];
                            if (file_exists($path_gambar)) {
                                unlink($path_gambar);
                            }
                        }

                        // Menghapus Gambar Detail
                        $query_hapus_detail = "SELECT gambar_detail FROM tbl_gambar WHERE produk_id = '$id'";
                        $result_hapus_detail = mysqli_query($conn,$query_hapus_detail);

                        while ($row = mysqli_fetch_assoc($result_hapus_detail)) {
                            $gambar_detail_lama[] = $row['gambar_detail'];
                        }

                        if (!empty($gambar_detail_lama)) {
                            foreach ($gambar_detail_lama as $gambar_lama) {
                                $path_gambar_lama = 'gambardetail/' . $gambar_lama;
                                if (file_exists($path_gambar_lama)) {
                                    unlink($path_gambar_lama); // Hapus file dari direktori server
                                }
                                // Hapus entri dari database
                                $query_delete_detail = "DELETE FROM tbl_gambar WHERE produk_id = '$id' AND gambar_detail = '$gambar_lama'";
                                mysqli_query($conn, $query_delete_detail);
                            }
                        }
                    }
                    
                }
            ?>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Kategori</th>
                    <th>Nama Produk</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Jumlah Stok</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
                    $view = mysqli_query($conn, "SELECT tbl_produk.id, tbl_produk.gambar, tbl_kategori.nama_kategori, tbl_produk.nama_produk, tbl_produk.deskripsi, tbl_produk.harga, tbl_produk.stok FROM tbl_produk 
                                        INNER JOIN tbl_kategori ON tbl_produk.id_kategori = tbl_kategori.id
                                        WHERE tbl_produk.user_id = '$user_id'");
                    while ($rows = mysqli_fetch_array($view)) {?>
                        <tr>
                            <td><?php echo $rows['id']; ?></td>
                            <td><img src="http://localhost/E-commerce/E-commerce/website/gambar/<?php echo $rows['gambar'];?>" alt="gambar" width="100px" height="100px" ></td>
                            <td><?php echo $rows['nama_kategori'] ?></td>
                            <td><?php echo $rows['nama_produk'];?></td>
                            <td><?php echo $rows['deskripsi'];?></td>
                            <td><?php echo $rows['harga'];?></td>
                            <td><?php echo $rows['stok'];?></td>
                            <td><a href="editproduk.php?id=<?php echo $rows['id']; ?>" class="btn btn-primary">Edit</a> |
                                <a href="?id_del=<?php echo $rows['id']; ?>" onclick="return confirm('Yakin kamu ingin menghapus Product?')" class="btn btn-danger">Hapus</a></td>
                        </tr>
                <?php }
                ?>
            </tbody>
        </table>
        </div>
    </div>
    <footer class="py-5 bg-dark">
            <div class="container-fluid p-5"><p class="m-0 text-center text-white">Copyright &copy; E-Commerce 2024</p></div>
    </footer>
</body>
</html>

<?php mysqli_close($conn); ?>
