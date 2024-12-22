<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login/login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data pesanan untuk pengguna saat ini
$query = "SELECT p.*, pr.nama_produk, pr.harga, pr.gambar, dt.quantity, t.status, dt.ukuran, dt.warna, dt.harga
              FROM tbl_pesanan p
              JOIN tbl_produk pr ON p.produk_id = pr.id
              JOIN tbl_detail_transaksi dt ON p.detail_transaksi_id = dt.id
              JOIN tbl_transaksi t ON p.transaksi_id = t.id
              WHERE p.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$pesanan_items = array();
while ($row = $result->fetch_assoc()) {
  // Tambahkan total_harga ke data pesanan
  $row['total_harga'] = isset($row['quantity']) ? $row['harga'] * $row['quantity'] : 0;
  $pesanan_items[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengiriman</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<header>
  <?php include 'header/navbar.php'; ?>
</header>

<body>
  <section class="vh-100" style="background-color: #fdccbc;">
    <div class="container h-50">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
          <p><span class="h2">Pesanan Saya </span><span class="h4"></span></p>
          <?php
          if (isset($_SESSION['saldo_berhasil'])) {
            echo '<p class="mb-2" id="pesan" style="color: red;">' . $_SESSION['saldo_berhasil'] . '</p>';
          }
          if (isset($_SESSION['saldo_gagal'])) {
            echo '<p class="mb-2" id="pesan" style="color: red;">' . $_SESSION['saldo_gagal'] . '</p>';
          }
          ?>
          <div class="card mb-4">
            <div class="card-body p-4">
              <div class="row align-items-center">
                <div class="col-md-2">
                  <p class="small text-muted mb-4 pb-2">Gambar Produk</p>
                </div>
                <div class="col-md-2 d-flex justify-content-center">
                  <p class="small text-muted mb-4 pb-2">Nama Produk</p>
                </div>
                <div class="col-md-2 d-flex justify-content-center">
                  <p class="small text-muted mb-4 pb-2">Quantity</p>
                </div>
                <div class="col-md-2 d-flex justify-content-center">
                  <p class="small text-muted mb-4 pb-2">Total Harga</p>
                </div>
                <div class="col-md-2 d-flex justify-content-center">
                  <p class="small text-muted mb-4 pb-2">Status Pembayaran</p>
                </div>
                <div class="col-md-2 d-flex justify-content-center">
                  <p class="small text-muted mb-4 pb-2">Estimasi Pengiriman</p>
                </div>
              </div>

              <!--  -->
              <div class="card mb-4">
                <?php foreach ($pesanan_items as $item) : ?>
                  <div class="card-body p-4">
                    <div class="row align-items-center">
                      <div class="col-md-2">
                        <img src="http://localhost/E-commerce/E-commerce/website/gambar/<?php echo htmlspecialchars($item['gambar']); ?>" class="img-fluid" alt="Generic placeholder image">
                      </div>
                      <div class="col-md-2 d-flex justify-content-center">
                        <div>
                          <p class="lead fw-normal mb-0">
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
                      <div class="col-md-2 d-flex justify-content-center">
                        <div>
                          <p class="lead fw-normal mb-0"><?php echo htmlspecialchars($item['quantity']); ?></p>
                        </div>
                      </div>
                      <div class="col-md-2 d-flex justify-content-center">
                        <div>
                          <p class="lead fw-normal mb-0">Rp.<?php echo number_format($item['total_harga'], 0, ',', '.'); ?></p>
                        </div>
                      </div>
                      <div class="col-md-2 d-flex justify-content-center">
                        <div>
                          <p class="lead fw-normal mb-0"><?php echo ($item['status']); ?></p>
                        </div>
                      </div>
                      <div class="col-md-2 d-flex justify-content-center">
                        <?php
                        if (isset($item['status']) && $item['status'] === 'completed') {
                        ?>
                          <div>
                            <p class="lead fw-normal mb-0">7 Hari <a href="" class="btn btn-danger">Hapus</a></p>
                          </div>
                        <?php
                        } else {
                        ?>
                          <div>
                            <p class="lead fw-normal mb-0"></p>
                          </div>
                        <?php
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
  </section>
</body>

</html>