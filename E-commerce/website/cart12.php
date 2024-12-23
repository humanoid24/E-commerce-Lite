<?php
session_start();
include '../koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Mendapatkan ID transaksi yang belum selesai
$query = "SELECT id FROM tbl_transaksi WHERE user_id = ? AND status = 'pending'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$transaksi_id = $result->num_rows > 0 ? $result->fetch_assoc()['id'] : null;


// Update Barang
if (isset($_POST['update'])) {
    foreach ($_POST['quantity'] as $produk_id => $quantity) {
        $produk_id = intval($produk_id);
        $quantity = intval($quantity);

        $query_update = "UPDATE tbl_detail_transaksi SET quantity = ? WHERE transaksi_id = ? AND produk_id = ?";
        $stmt_update = $conn->prepare($query_update);
        $stmt_update->bind_param("iii", $quantity, $transaksi_id, $produk_id);
        $stmt_update->execute();

        // Periksa jika query berhasil
        if ($stmt_update->error) {
            echo "Error: " . $stmt_update->error;
            exit();
        }
    }

    header("Location: cart12.php");
    exit();
}

// Proses penghapusan item dari keranjang
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);

    if ($transaksi_id) {
        // Hapus item dari detail transaksi
        $query = "DELETE FROM tbl_detail_transaksi WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $remove_id);
        $stmt->execute();

        // Cek apakah ada item lain dalam transaksi ini
        $query_check = "SELECT COUNT(*) as count FROM tbl_detail_transaksi WHERE transaksi_id = ?";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bind_param("i", $transaksi_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $row_check = $result_check->fetch_assoc();

        // Jika tidak ada item tersisa, hapus transaksi utama
        if ($row_check['count'] == 0) {
            $query_delete = "DELETE FROM tbl_transaksi WHERE id = ?";
            $stmt_delete = $conn->prepare($query_delete);
            $stmt_delete->bind_param("i", $transaksi_id);
            $stmt_delete->execute();
        }
    }

    header("Location: cart12.php");
    exit();
}

// Ambil item keranjang dari database
$cart_items = array();
if ($transaksi_id) {
    $query = "SELECT dt.*, p.nama_produk, p.gambar, p.stok, p.user_id
              FROM tbl_detail_transaksi dt
              JOIN tbl_produk p ON dt.produk_id = p.id
              WHERE dt.transaksi_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $transaksi_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
    }
}

$user_id_produk = isset($cart_items[0]['user_id']) ? $cart_items[0]['user_id'] : null;

// Hitung total harga
$total = 0;
foreach ($cart_items as $item) {
    $subtotal = $item['harga'] * $item['quantity'];
    $total += $subtotal;
}
$total_tax = 3000;
$total_all = $total + $total_tax;

// Ambil nilai duit dari tabel tbl_user
$query_user = "SELECT duit FROM tbl_user WHERE id = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$duit_row = $result_user->fetch_assoc();
$duit = $duit_row['duit'];

if (isset($_POST['beli'])) {
    $tipe_transaksi = $_POST['tipe_transaksi'] ?? null;

    if (empty($tipe_transaksi)) {
        $_SESSION['pilih_pembayaran'] = "Silahkan Pilih Metode Pembayaran Tersebut";
        header('Location: cart12.php');
        exit();
    } else {
        if ($tipe_transaksi === 'credit') {
            $_SESSION['credit'] = "Belum Bisa Digunakan";
            header("Location: cart12.php");
            exit();
        }
        if ($tipe_transaksi === 'duitku') {
            if ($duit < $total_all) {
                $_SESSION['pesanan'] = "Saldo Duitku Tidak Mencukupi";
                header("Location: cart12.php");
                exit();
            }
            // Kurangi saldo Duitku
            $query_update_duit = "UPDATE tbl_user SET duit = duit - ? WHERE id = ?";
            $stmt_update_duit = $conn->prepare($query_update_duit);
            $stmt_update_duit->bind_param("di", $total_all, $user_id);
            $stmt_update_duit->execute();

            if ($transaksi_id) {
                // Pastikan Transaksi ada
                $query_update_transaksi = "UPDATE tbl_transaksi SET status = 'completed' WHERE id = ?";
                $stmt_update_transaksi = $conn->prepare($query_update_transaksi);
                $stmt_update_transaksi->bind_param("i", $transaksi_id);
                $stmt_update_transaksi->execute();

                // Update stok produk dan ukuran
                foreach ($_POST['quantity'] as $produk_id => $quantity) {
                    $produk_id = intval($produk_id);
                    $quantity = intval($quantity);

                    $query_ukuran = "SELECT ukuran FROM tbl_detail_transaksi WHERE produk_id = ? AND transaksi_id = ?";
                    $stmt_ukuran = $conn->prepare($query_ukuran);
                    $stmt_ukuran->bind_param("ii", $produk_id, $transaksi_id);
                    $stmt_ukuran->execute();
                    $result_ukuran = $stmt_ukuran->get_result();

                    if ($result_ukuran->num_rows > 0) {
                        // Jika ada ukuran yang ditemukan, ambil nilai ukuran tersebut
                        $row_ukuran = $result_ukuran->fetch_assoc();
                        $ukuran = $row_ukuran['ukuran'];

                        if (!empty($ukuran)) {
                            // Jika ukuran tidak kosong, lanjutkan memeriksa stok ukuran
                            $query_ukuran_stok = "SELECT stok FROM ukuran WHERE produk_id = ? AND ukuran = ?";
                            $stmt_ukuran_stok = $conn->prepare($query_ukuran_stok);
                            $stmt_ukuran_stok->bind_param("is", $produk_id, $ukuran);
                            $stmt_ukuran_stok->execute();
                            $result_ukuran_stok = $stmt_ukuran_stok->get_result();

                            if ($result_ukuran_stok->num_rows > 0) {
                                // Jika stok ukuran ditemukan, ambil jumlah stok
                                $row_ukuran_stok = $result_ukuran_stok->fetch_assoc();
                                $stok_ukuran = $row_ukuran_stok['stok'];

                                // Kurangi stok ukuran jika cukup
                                if ($stok_ukuran >= $quantity) {
                                    $query_update_ukuran = "UPDATE ukuran SET stok = stok - ? WHERE produk_id = ? AND ukuran = ?";
                                    $stmt_update_ukuran = $conn->prepare($query_update_ukuran);
                                    $stmt_update_ukuran->bind_param("iis", $quantity, $produk_id, $ukuran);
                                    $stmt_update_ukuran->execute();
                                } else {
                                    // Jika stok ukuran tidak cukup, beri pesan error
                                    throw new Exception("Stok ukuran tidak mencukupi.");
                                }
                            } else {
                                // Jika stok ukuran tidak ditemukan, beri pesan error
                                throw new Exception("Ukuran tidak ditemukan.");
                            }
                        } else {
                            // Jika ukuran kosong (produk tidak memerlukan ukuran), update stok produk secara langsung
                            $query_update_produk = "UPDATE tbl_produk SET stok = stok - ? WHERE id = ?";
                            $stmt_update_produk = $conn->prepare($query_update_produk);
                            $stmt_update_produk->bind_param("ii", $quantity, $produk_id);
                            $stmt_update_produk->execute();
                        }
                    } else {
                        // Jika produk tidak memiliki ukuran, update stok produk langsung
                        // Ini untuk produk yang tidak memerlukan ukuran atau warna
                        $query_update_produk = "UPDATE tbl_produk SET stok = stok - ? WHERE id = ?";
                        $stmt_update_produk = $conn->prepare($query_update_produk);
                        $stmt_update_produk->bind_param("ii", $quantity, $produk_id);
                        $stmt_update_produk->execute();
                    }

                }

                // Jika perlu menambah saldo pengguna yang menjual produk (pastikan logika ini benar)
                if ($user_id_produk) {
                    $query_update_beli = "UPDATE tbl_user SET duit = duit + ? WHERE id = ?";
                    $stmt_update_beli = $conn->prepare($query_update_beli);
                    $stmt_update_beli->bind_param("di", $total, $user_id_produk);
                    $stmt_update_beli->execute();
                }

                header("Location: pesanansaya.php");
                exit();
            } else {
                echo "Transaksi gagal";
            }
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<header>
    <?php include 'header/navbar.php'; ?>
</header>

<body>
    <section class="h-100 h-custom">
        <div class="container h-100 py-5">
            <div class="row">
                <div class="col-md-4">
                    <h1>Keranjang Belanja</h1>
                    <a class="text-decoration-none" href="dashboard.php">Kembali Belanja</a>
                </div>
            </div>
            <?php if (empty($cart_items)) : ?>
                <p>Keranjang Anda Kosong</p>
            <?php else : ?>
                <form id="cart-form" method="post" action="cart12.php">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="h5">Nama Produk</th>
                                            <th scope="col">Harga Satuan</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Total Harga</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cart_items as $item) : ?>
                                            <tr id="item-<?php echo $item['produk_id']; ?>">
                                                <th scope="row">
                                                    <div class="d-flex align-items-center">
                                                        <img src="http://localhost/E-commerce/E-commerce/website/gambar/<?php echo htmlspecialchars($item['gambar']); ?>" class="img-fluid rounded-3" style="width: 120px; height: 178px;" alt="Gambar Produk">
                                                        <div class="flex-column ms-4">
                                                            <p class="mb-2">
                                                                <?php echo htmlspecialchars($item['nama_produk']); ?>
                                                                <?php if (!empty($item['ukuran']) && !empty($item['warna'])): ?>
                                                                    <?php echo htmlspecialchars($item['ukuran']); ?>/<?php echo htmlspecialchars($item['warna']); ?>
                                                                <?php elseif (!empty($item['ukuran'])): ?>
                                                                    <?php echo htmlspecialchars($item['ukuran']); ?>
                                                                <?php elseif (!empty($item['warna'])): ?>
                                                                    <?php echo htmlspecialchars($item['warna']); ?>
                                                                <?php else: ?>
                                                                    <!-- Kosong jika tidak ada ukuran atau warna -->
                                                                <?php endif; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </th>
                                                <td class="align-middle">
                                                    <p class="mb-0" style="font-weight: 500;">Rp.<?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex flex-row">
                                                        <input id="quantity-<?php echo $item['produk_id']; ?>" name="quantity[<?php echo $item['produk_id']; ?>]" value="<?php echo htmlspecialchars($item['quantity']); ?>" type="number" class="form-control form-control-sm quantity" min="1" data-stok="<?php echo htmlspecialchars($item['stok']); ?>" required />
                                                    </div>
                                                </td>
                                                <td class="align-middle subtotal" id="subtotal-<?php echo $item['produk_id']; ?>">
                                                    <p class="mb-0">Rp.<?php echo number_format($item['harga'] * $item['quantity'], 0, ',', '.'); ?></p>
                                                </td>
                                                <td class="align-middle">
                                                    <a href="cart12.php?remove=<?php echo $item['id']; ?>" class="btn btn-danger">Hapus</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card shadow-2-strong mb-5 mb-lg-0" style="border-radius: 16px;">
                                <?php
                                if (isset($_SESSION['pilih_pembayaran'])) {
                                    echo '<p class="mb-2" id="pesan" style="color: red;">' . $_SESSION['pilih_pembayaran'] . '</p>';
                                    unset($_SESSION['pilih_pembayaran']);
                                }
                                if (isset($_SESSION['credit'])) {
                                    echo '<p class="mb-2" id="pesan" style="color: red;">' . $_SESSION['credit'] . '</p>';
                                    unset($_SESSION['credit']);
                                }
                                ?>
                                <div class="card-body p-4">

                                    <div class="row">
                                        <div class="col-md-6 col-lg-4 col-xl-3 mb-4 mb-md-0">
                                            <div class="d-flex flex-row pb-3">
                                                <div class="d-flex align-items-center pe-2">
                                                    <input class="form-check-input" type="radio" name="tipe_transaksi" id="credit" value="credit" aria-label="..." />
                                                </div>
                                                <div class="rounded border w-100 p-3">
                                                    <p class="d-flex align-items-center mb-0">
                                                        <i class="fab fa-cc-mastercard fa-2x text-body pe-2"></i> Credit Card
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row pb-3">
                                                <div class="d-flex align-items-center pe-2">
                                                    <input class="form-check-input" type="radio" name="tipe_transaksi" id="duitku" value="duitku" aria-label="..." />
                                                </div>
                                                <div class="rounded border w-100 p-3">
                                                    <p class="d-flex align-items-center mb-0">
                                                        <i class="fab fa-2x fa-lg text-body pe-2"><img src="fotosampul/foto.jpg" width="20px" height="20px" alt=""></i>Duitku
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-xl-6" id="form-fields">
                                        </div>
                                        <div class="col-lg-4 col-xl-3">
                                            <div class="d-flex justify-content-between" style="font-weight: 500;">
                                                <p class="mb-2">Subtotal</p>
                                                <p id="total-subtotal" class="mb-2">Rp.<?php echo number_format($total, 0, ',', '.'); ?></p>
                                            </div>

                                            <div class="d-flex justify-content-between" style="font-weight: 500;">
                                                <p class="mb-0">Pajak</p>
                                                <p class="mb-0">Rp.<?php echo number_format($total_tax, 0, ',', '.'); ?></p>
                                            </div>

                                            <hr class="my-4">

                                            <div class="d-flex justify-content-between mb-4" style="font-weight: 500;">
                                                <p class="mb-2">Total Belanja Semua</p>
                                                <p id="total-all" class="mb-2">Rp.<?php echo number_format($total_all, 0, ',', '.'); ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between" style="font-weight: 500;">
                                                <?php
                                                if (isset($_SESSION['pesanan'])) {
                                                    echo '<p class="mb-2" id="pesan" style="color: red;">' . $_SESSION['pesanan'] . '</p>';
                                                    unset($_SESSION['pesanan']);
                                                }
                                                if (isset($_SESSION['saldo_berhasil'])) {
                                                    echo '<p class="mb-2" id="pesan" style="color: red;">' . $_SESSION['saldo_berhasil'] . '</p>';
                                                    unset($_SESSION['saldo_berhasil']);
                                                }
                                                if (isset($_SESSION['saldo_gagal'])) {
                                                    echo '<p class="mb-2" id="pesan" style="color: red;">' . $_SESSION['saldo_gagal'] . '</p>';
                                                    unset($_SESSION['saldo_gagal']);
                                                }
                                                ?>
                                            </div>
                                            <div class="d-flex justify-content-between pt-3">
                                                <button type="submit" name="update" class="btn btn-primary btn-block btn-lg mb-2">Update Qty</button>
                                                <!-- Input tersembunyi untuk ID transaksi -->
                                                <input type="hidden" name="transaksi_id" value="<?php echo htmlspecialchars($transaksi_id); ?>" />
                                                <button type="submit" class="btn btn-primary btn-lg btn-block mb-2" name="beli">Beli Sekarang</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk memperbarui subtotal dan total harga
            function updateCart() {
                let total = 0;

                // Update subtotal untuk setiap item
                document.querySelectorAll('.quantity').forEach(function(input) {
                    const itemId = input.id.replace('quantity-', '');
                    const quantity = parseInt(input.value) || 0;

                    // Validasi kuantitas tidak melebihi stok
                    const stock = parseInt(input.getAttribute('data-stok'));
                    if (quantity > stock) {
                        input.value = stock;
                        alert('Jumlah melebihi stok yang tersedia');
                    }

                    const priceElement = document.querySelector(`#item-${itemId} td:nth-child(2) p`);
                    if (!priceElement) return; // Jika elemen tidak ada, lewati

                    const priceText = priceElement.innerText.replace('Rp.', '').replace(/\./g, '').trim();
                    const price = parseFloat(priceText);
                    const subtotal = price * quantity;

                    const subtotalElement = document.querySelector(`#subtotal-${itemId} p`);
                    if (subtotalElement) {
                        subtotalElement.innerText = `Rp.${subtotal.toLocaleString('id-ID')}`;
                    }

                    total += subtotal;
                });

                // Hitung total keseluruhan
                const tax = 3000;
                const totalAll = total + tax;

                // Update total subtotal dan total keseluruhan di UI
                const totalSubtotalElement = document.querySelector('#total-subtotal');
                const totalAllElement = document.querySelector('#total-all');

                if (totalSubtotalElement) {
                    totalSubtotalElement.innerText = `Rp.${total.toLocaleString('id-ID')}`;
                }

                if (totalAllElement) {
                    totalAllElement.innerText = `Rp.${totalAll.toLocaleString('id-ID')}`;
                }
            }

            // Tambahkan event listener pada setiap input kuantitas
            document.querySelectorAll('.quantity').forEach(function(input) {
                input.addEventListener('input', updateCart);
            });

            // Panggil updateCart saat halaman dimuat
            updateCart();

            // Mengatur form input sesuai dengan tipe transaksi
            document.querySelectorAll('input[name="tipe_transaksi"]').forEach((radio) => {
                radio.addEventListener('change', function() {
                    const formFields = document.getElementById('form-fields');
                    if (formFields) {
                        formFields.innerHTML = '';

                        if (this.value === 'credit') {
                            formFields.innerHTML = `
                            <div class="row">
                                <div class="col-12 col-xl-6">
                                    <div data-mdb-input-init class="form-outline mb-4 mb-xl-5">
                                        <input type="text" id="typeName" class="form-control form-control-lg"
                                            placeholder="John Smith" />
                                        <label class="form-label" for="typeName">Name on card</label>
                                    </div>
                                    <div data-mdb-input-init class="form-outline mb-4 mb-xl-5">
                                        <input type="text" id="typeExp" class="form-control form-control-lg" placeholder="MM/YY"
                                            size="7" minlength="7" maxlength="7" />
                                        <label class="form-label" for="typeExp">Expiration</label>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-6">
                                    <div data-mdb-input-init class="form-outline mb-4 mb-xl-5">
                                        <input type="text" id="typeCardNumber" class="form-control form-control-lg"
                                            placeholder="1111 2222 3333 4444" minlength="19" maxlength="19" />
                                        <label class="form-label" for="typeCardNumber">Card Number</label>
                                    </div>
                                    <div data-mdb-input-init class="form-outline mb-4 mb-xl-5">
                                        <input type="password" id="typeCvv" class="form-control form-control-lg"
                                            placeholder="&#9679;&#9679;&#9679;" size="1" minlength="3" maxlength="3" />
                                        <label class="form-label" for="typeCvv">Cvv</label>
                                    </div>
                                </div>
                            </div>
                        `;
                        } else if (this.value === 'duitku') {
                            formFields.innerHTML = `
                            <div class="mb-3">
                                <label for="credit-amount" class="form-label">Saldo Duitku</label>
                                <h1 name="duitku">Rp.<?php echo number_format($duit, 2, ',', '.'); ?></h1>
                            </div>
                        `;
                        }
                    }
                });
            });

            // Menyembunyikan pesan error atau sukses setelah 5 detik
            function hideMessages() {
                const errorPesan = document.getElementById("pesan");
                if (errorPesan) {
                    setTimeout(function() {
                        errorPesan.style.display = "none";
                    }, 5000);
                }

                const success = document.getElementById("sukses");
                if (success) {
                    setTimeout(function() {
                        success.style.display = "none";
                    }, 5000);
                }
            }

            // Panggil fungsi untuk menyembunyikan pesan saat halaman dimuat
            hideMessages();
        });
    </script>

</body>

</html>