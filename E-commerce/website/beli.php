<?php
session_start();
include '../koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit();
}

if (!isset($_GET['id']) || intval($_GET['id']) == 0) {
    $_SESSION['message'] = 'Produk Tidak di temukan';
    header("Location: dashboard.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$item_id = intval($_GET['id']);
file_put_contents('debug_log.txt', "Item ID: " . $item_id . "\n", FILE_APPEND);

// Cek apakah item sudah ada di daftar keinginan
$query_check = "SELECT * FROM tbl_wishlist WHERE user_id = ? AND produk_id = ?";
$stmt_check = $conn->prepare($query_check);
$stmt_check->bind_param("ii", $user_id, $item_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$is_in_wishlist = $result_check->num_rows > 0;

file_put_contents('debug_log.txt', "Is in Wishlist: " . ($is_in_wishlist ? 'Yes' : 'No') . "\n", FILE_APPEND);


if (isset($_POST['daftar_keinginan']) && isset($_GET['id'])) {
    if ($is_in_wishlist) {
        // Item sudah ada di daftar keinginan, maka hapus
        $query_delete = "DELETE FROM tbl_wishlist WHERE user_id = ? AND produk_id = ?";
        $stmt_delete = $conn->prepare($query_delete);
        $stmt_delete->bind_param("ii", $user_id, $item_id);
        $stmt_delete->execute();
        file_put_contents('debug_log.txt', "Item removed from wishlist.\n", FILE_APPEND);
    } else {
        // Item belum ada di daftar keinginan, maka tambahkan
        $query_add = "INSERT INTO tbl_wishlist (user_id, produk_id) VALUES (?, ?)";
        $stmt_add = $conn->prepare($query_add);
        $stmt_add->bind_param("ii", $user_id, $item_id);
        $stmt_add->execute();
        file_put_contents('debug_log.txt', "Item added to wishlist.\n", FILE_APPEND);
    }

    // Redirect ke halaman yang sama
    header("Location: beli.php?id=" . urlencode($item_id));
    exit();
}


// Menambahkan item ke keranjang
if (isset($_POST['beli_produk']) && isset($_GET['id'])) {
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $ukuran = isset($_POST['ukuran']) ? $_POST['ukuran'] : null;
    $warna = isset($_POST['warna']) ? $_POST['warna'] : null;

    // Ambil harga berdasarkan ukuran yang dipilih
    $harga = null;
    if ($ukuran) {
        $query = "SELECT harga FROM ukuran WHERE produk_id = ? AND ukuran = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $item_id, $ukuran);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $harga = $result->fetch_assoc()['harga'];
        }
    } else {
        $query = "SELECT harga FROM tbl_produk WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $harga = $result->num_rows > 0 ? $result->fetch_assoc()['harga'] : null;
    }

    if (!empty($ukuran) && $warna) {
        // Cek apakah sudah ada transaksi yang belum selesai
        $query = "SELECT id FROM tbl_transaksi WHERE user_id = ? AND status = 'pending'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $transaksi_id = $result->fetch_assoc()['id'];

            $query = "SELECT id FROM tbl_detail_transaksi WHERE transaksi_id = ? AND produk_id = ? AND ukuran = ? AND warna = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiss", $transaksi_id, $item_id, $ukuran, $warna);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $query = "UPDATE tbl_detail_transaksi SET quantity = quantity + ?, harga = ? WHERE transaksi_id = ? AND produk_id = ? AND ukuran = ? AND warna = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iiiss", $quantity, $harga, $transaksi_id, $item_id, $ukuran, $warna);
                $stmt->execute();
            } else {
                $query = "INSERT INTO tbl_detail_transaksi (transaksi_id, produk_id, quantity, ukuran, warna, harga) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iiissd", $transaksi_id, $item_id, $quantity, $ukuran, $warna, $harga);
                $stmt->execute();
                $detail_transaksi_id = $stmt->insert_id;
            }
        } else {
            $query = "INSERT INTO tbl_transaksi (user_id) VALUES (?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $transaksi_id = $stmt->insert_id;

            $query = "INSERT INTO tbl_detail_transaksi (transaksi_id, produk_id, quantity, ukuran, warna, harga) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiissd", $transaksi_id, $item_id, $quantity, $ukuran, $warna, $harga);
            $stmt->execute();
            $detail_transaksi_id = $stmt->insert_id;
        }

        // Tambah Kedalam Pesanan
        if (isset($detail_transaksi_id)) {
            $query_add = "INSERT INTO tbl_pesanan (user_id, produk_id, transaksi_id, detail_transaksi_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query_add);
            $stmt->bind_param("iiii", $user_id, $item_id, $transaksi_id, $detail_transaksi_id);
            $stmt->execute();
        }
    } else {
        // Cek apakah sudah ada transaksi yang belum selesai
        $query = "SELECT id FROM tbl_transaksi WHERE user_id = ? AND status = 'pending'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $transaksi_id = $result->fetch_assoc()['id'];

            $query = "SELECT id FROM tbl_detail_transaksi WHERE transaksi_id = ? AND produk_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $transaksi_id, $item_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $query = "UPDATE tbl_detail_transaksi SET quantity = quantity + ? WHERE transaksi_id = ? AND produk_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iii", $quantity, $transaksi_id, $item_id);
                $stmt->execute();
            } else {
                $query = "INSERT INTO tbl_detail_transaksi (transaksi_id, produk_id, quantity, harga) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iiid", $transaksi_id, $item_id, $quantity, $harga);
                $stmt->execute();
                $detail_transaksi_id = $stmt->insert_id;
            }
        } else {
            $query = "INSERT INTO tbl_transaksi (user_id) VALUES (?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $transaksi_id = $stmt->insert_id;

            $query = "INSERT INTO tbl_detail_transaksi (transaksi_id, produk_id, quantity, harga) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiid", $transaksi_id, $item_id, $quantity, $harga);
            $stmt->execute();
            $detail_transaksi_id = $stmt->insert_id;
        }

        // Tambah Kedalam Pesanan
        if (isset($detail_transaksi_id)) {
            $query_add = "INSERT INTO tbl_pesanan (user_id, produk_id, transaksi_id, detail_transaksi_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query_add);
            $stmt->bind_param("iiii", $user_id, $item_id, $transaksi_id, $detail_transaksi_id);
            $stmt->execute();
        }
    }

    $_SESSION['message'] = 'Produk Berhasil Ditambahkan';
    header("Location: dashboard.php?id=" . urlencode($item_id));
    exit();
}

if (isset($_POST['submit_komentar'])) {
    $userId = $_POST['userId'];
    $idProduk = $_POST['idProduk'];
    $komentar = $_POST['komentar'];

    // Sanitasi input untuk mencegah XSS
    $komentar = htmlspecialchars($komentar);

    // Simpan komentar ke database (asumsikan ada tabel komentar)
    $query = "INSERT INTO tbl_ulasan_produk (user_id, produk_id, komentar) VALUES ('$userId', '$idProduk', '$komentar')";

    if (mysqli_query($conn, $query)) {
        file_put_contents('debug_log.txt', "Inserted into : $query\n", FILE_APPEND);
    } else {
        file_put_contents('debug_log.txt', "Error inserting into Komentar: " . mysqli_error($conn) . "\n", FILE_APPEND);
    }
    header("Location: beli.php?id=" . urlencode($item_id));
    exit();
}

if (isset($_POST['hapus_komentar'])) {
    $komentarId = $_POST['id_komentar'];

    // Hapus komentar dari database
    $query = "DELETE FROM tbl_ulasan_produk WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $komentarId);

    if ($stmt->execute()) {
        // Penghapusan berhasil, redirect kembali ke halaman sebelumnya
        header('Location: beli.php?id=' . $item_id);
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beli Produk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .product-container {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .product-image {
            width: 600px;
            height: 300px;
        }

        .thumbnail {
            width: 100px;
            height: 100px;
            object-fit: cover;
            cursor: pointer;
        }

        .product-details {
            margin-left: 50px;
        }

        .heart-button.active .fa-heart {
            color: red;
        }
    </style>
    <script>
        function changeImage(imageSrc) {
            document.getElementById('mainImage').src = imageSrc;
        }
    </script>
</head>

<body>
    <header>
        <?php include 'header/navbar.php'; ?>
    </header>

    <div class="product-container">
        <?php
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = mysqli_real_escape_string($conn, $_GET['id']);
            $view = mysqli_query($conn, "SELECT p.*, u.nama, u.alamat, u.no_telepon FROM tbl_produk p JOIN tbl_user u ON p.user_id = u.id WHERE p.id = $id");

            if ($view && mysqli_num_rows($view) > 0) {
                $result = mysqli_fetch_array($view);
                $kategori_id = intval($result['id_kategori']);

                $kategori_query = mysqli_query($conn, "SELECT nama_kategori FROM tbl_kategori WHERE id = $kategori_id");
                $kategori_result = mysqli_fetch_array($kategori_query);

                if ($kategori_result) {
                    $kategori_name = $kategori_result['nama_kategori'];
                } else {
                    $kategori_name = 'Kategori tidak ditemukan';
                    exit();
                }
            } else {
                echo "Produk tidak ditemukan.";
                exit();
            }
        } else {
            echo "ID produk tidak ditemukan.";
            exit();
        }
        ?>
        <div class="col-md-5">
            <?php
            $view_gambar = mysqli_query($conn, "SELECT * FROM tbl_gambar WHERE produk_id = " . $result['id']);

            if (!$view_gambar) {
                die("Query gagal: " . mysqli_error($conn));
            }

            // Simpan gambar dalam array
            $gambar_array = [];
            while ($row = mysqli_fetch_array($view_gambar)) {
                $gambar_array[] = $row;
            }
            if (count($gambar_array) > 0) {
                $gambar_utama = $gambar_array[0];
            }
            ?>
            <img id="mainImage" class="product-image" src="http://localhost/E-commerce/E-commerce/website/gambardetail/<?php echo $gambar_utama['gambar_detail']; ?>" alt="">
            <div class="d-flex justify-content-center mt-3">
                <?php

                foreach ($gambar_array as $gambar) {
                ?>
                    <img src="http://localhost/E-commerce/E-commerce/website/gambardetail/<?php echo $gambar['gambar_detail']; ?>" width="100px" height="100px" class="img-thumbnail mb-2" alt="Product Image Thumbnail" onclick="changeImage('http://localhost/E-commerce/E-commerce/website/gambardetail/<?php echo $gambar['gambar_detail']; ?>')">
                <?php } ?>
            </div>
        </div>

        <div class="col-md-4 px-2">
            <form method="post" action="beli.php?id=<?php echo urlencode($_GET['id']); ?>">
                <h1><?php echo htmlspecialchars($result['nama_produk']); ?></h1>
                <!-- /// -->
                <?php include 'pilihkategoriJS_PHP/belikategori.php'; ?>
                <!-- Stok -->
                <div class="mb-3">
                    <label for="quantity" class="form-label">Qty</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" min="1" value="1" required>
                </div>
                <div class="d-flex">
                    <?php
                    $user_idProdukId = intval($result['user_id']);
                    if ($user_id === $user_idProdukId) {
                    ?>
                        <button type="submit" name="beli_produk" class="btn btn-danger me-2" disabled>Tambahkan ke keranjang</button>
                    <?php
                    } else {
                    ?>
                        <button type="submit" name="beli_produk" class="btn btn-danger me-2">Tambahkan ke keranjang</button>
                    <?php
                    }
                    ?>

            </form>

            <form method="post" action="beli.php?id=<?php echo urlencode($item_id); ?>" style="display: inline;">
                <?php
                $user_idProdukId = intval($result['user_id']);
                if ($user_id === $user_idProdukId) {
                ?>
                    <button type="submit" name="daftar_keinginan" class="btn heart-button border-danger <?php echo $is_in_wishlist ? 'active' : ''; ?>" disabled>
                        <i class="fas fa-heart checkbox-icon"></i> Tambahkan Ke Daftar Keinginan
                    </button>
                <?php
                } else {
                ?>
                    <button type="submit" name="daftar_keinginan" class="btn heart-button border-danger <?php echo $is_in_wishlist ? 'active' : ''; ?>">
                        <i class="fas fa-heart checkbox-icon"></i> Tambahkan Ke Daftar Keinginan
                    </button>
                    <?php
                    // Log status tombol di HTML
                    file_put_contents('debug_log.txt', "Button status for item ID " . $item_id . ": " . ($is_in_wishlist ? 'active' : 'inactive') . "\n", FILE_APPEND);
                    ?>
                <?php
                }
                ?>
            </form>

        </div>
    </div>

    </div>

    <!-- Tab Content -->
    <div class="container mt-3">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#home">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#menu1">Tambahan Deskripsi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#menu2">Review</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="home" class="container tab-pane active"><br>
                <h3></h3>
                <p>Pemilik Iklan: <?php echo htmlspecialchars($result['nama']); ?></p>
                <p>Alamat: <?php echo htmlspecialchars($result['alamat']); ?></p>
                <p>No Telepon: <?php echo htmlspecialchars($result['no_telepon']); ?> </p>
            </div>
            <div id="menu1" class="container tab-pane fade d-flex flex-wrap"><br>
                <p><?php echo nl2br(htmlspecialchars($result['deskripsi'])); ?></p>
            </div>
            <div id="menu2" class="container tab-pane fade"><br>
                <!-- Your review section -->
                <div class="container-fluid overflow-auto">
                    <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                        <?php
                        // Mengambil semua komentar untuk produk tertentu
                        $query = "SELECT * FROM tbl_ulasan_produk WHERE produk_id = $item_id ORDER BY date DESC";
                        $result = mysqli_query($conn, $query);

                        if (!$result) {
                            die("Query gagal: " . mysqli_error($conn));
                        }

                        // Cek apakah ada komentar
                        if (mysqli_num_rows($result) == 0) {
                            echo "<p>Belum ada komentar</p>";
                        } else {
                            while ($rowss = mysqli_fetch_assoc($result)) {
                                $userId = $rowss['user_id'];

                                // Mengambil data pengguna untuk menampilkan nama dan foto profil
                                $userQuery = "SELECT * FROM tbl_user WHERE id = $userId";
                                $userResult = mysqli_query($conn, $userQuery);
                                $user = mysqli_fetch_assoc($userResult);
                        ?>

                                <div class="d-flex align-items-start border mb-3">
                                    <img class="rounded-circle shadow-1-strong me-3" src="http://localhost/E-commerce/E-commerce/website/fotosampul/<?php echo $user['foto_profil']; ?>" alt="avatar" width="60" height="60" />
                                    <div class="d-flex flex-column justify-content-start">
                                        <h6 class="fw-bold text-primary mb-0"><?php echo htmlspecialchars($user['nama']); ?></h6>
                                        <p class="text-muted small mb-2"><?php $tanggal = strtotime($rowss['date']);
                                                                            echo date('l, d F Y', $tanggal); ?></p>
                                        <?php
                                        $user_ulasanProduk = intval($rowss['user_id']);
                                        if ($user_id === $user_ulasanProduk) {
                                        ?>
                                            <form action="" method="post" style="display: inline;">
                                                <input type="hidden" name="id_komentar" value="<?php echo $rowss['id'] ?>">
                                                <button type="submit" name="hapus_komentar" class="border-0 bg-transparent" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                    </svg>
                                                </button>
                                            </form>

                                        <?php
                                        }
                                        ?>
                                        <p class="mt-2 mb-3"><?php echo htmlspecialchars($rowss['komentar']); ?></p>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <?php
                    $query = "SELECT * FROM tbl_user WHERE id = $user_id";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <form action="" method="post">
                        <input type="hidden" name="userId" value="<?php echo $user_id; ?>">
                        <input type="hidden" name="idProduk" value="<?php echo $item_id; ?>">
                        <div class="card-footer py-3 border-0">
                            <div class="d-flex flex-start w-100">
                                <img class="rounded-circle shadow-1-strong me-3" src="http://localhost/E-commerce/E-commerce/website/fotosampul/<?php echo $row['foto_profil']; ?>" alt="avatar" width="40" height="40" />
                                <div data-mdb-input-init class="form-outline w-100">
                                    <textarea class="form-control" id="textAreaExample" rows="4" style="background: #fff;" name="komentar"></textarea>
                                </div>
                            </div>
                            <div class="float-end mt-2 pt-1">
                                <button type="submit" name="submit_komentar" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-sm">Post comment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-5 bg-dark mt-5">
        <div class="container-fluid">
            <p class="m-0 text-center text-white">Copyright &copy; E-Commerce 2024</p>
        </div>
    </footer>


    <script>
        document.querySelectorAll('input[name="ukuran"]').forEach((input) => {
            input.addEventListener('change', function() {
                const harga = this.dataset.harga;
                const stok = this.dataset.stok;
                document.getElementById('harga-info').textContent = harga ? `Rp.${harga}` : 'Tidak tersedia';
                document.getElementById('stok-info').textContent = stok ? stok : 'Tidak tersedia';
                document.getElementById('harga_ukuran').value = harga; // Set hidden field
                document.getElementById('stok_ukuran').value = stok; // Set hidden field
            });
        });
    </script>

</body>

</html>