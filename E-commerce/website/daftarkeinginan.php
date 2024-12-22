<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit();

    $user_id = $_SESSION['user_id'];
}

if (isset($_GET['id_del'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id_del']);

    $query_hapus = "DELETE FROM tbl_wishlist WHERE id = '$id'";
    $result_hapus_produk = mysqli_query($conn, $query_hapus);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Keinginan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <?php include 'header/navbar.php'; ?>
    </header>

    <section class="mt-8 mb-14 pt-3">
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-8">
                        <!-- heading -->
                        <h1 class="mb-1">Daftar Keinginan</h1>
                    </div>
                    <br>
                    <div>
                        <!-- table -->
                        <div class="table-responsive">
                            <table class="table text-nowrap table-with-checkbox">
                                <thead class="table-light">
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Beli</th>
                                        <th>Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include '../koneksi.php';
                                    $view = mysqli_query($conn, "SELECT p.*, w.* FROM tbl_wishlist w 
                                                                JOIN tbl_produk p ON w.produk_id = p.id WHERE w.user_id = '$user_id'");
                                    while ($rows = mysqli_fetch_array($view)) {
                                        $id_produk = mysqli_real_escape_string($conn, $rows['produk_id']); ?>
                                        <tr>
                                            <td class="align-middle">
                                                <a href="beli.php?id=<?php echo $id_produk; ?>"><img src="http://localhost/E-commerce/E-commerce/website/gambar/<?php echo $rows['gambar']; ?>" class="img-thumbnail img-fluid w-25" alt=""></a>
                                            </td>
                                            <td class="align-middle">
                                                <div>
                                                    <h5 class="fs-6 mb-0"><?php echo $rows['nama_produk']; ?></h5>
                                                </div>
                                            </td>
                                            <td class="align-middle">Rp.<?php echo number_format($rows['harga'], 0, ',', '.'); ?></td>
                                            <td class="align-middle">
                                                <a href="beli.php?id=<?php echo $id_produk; ?>" class="btn btn-primary btn-sm">Beli
                                            </td>
                                            <td class="align-middle">
                                                <a href="?id_del=<?php echo $rows['id']; ?>" onclick="return confirm('Yakin kamu ingin menghapus Product?')" class="text-muted" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete" data-bs-original-title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>