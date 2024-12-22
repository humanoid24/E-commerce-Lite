<?php
include __DIR__ . '/../../koneksi.php';
if (!isset($_SESSION['user_id'])) {
  header("Location: login/login.php");
  exit();
}


$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM tbl_user WHERE id = $user_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $nama_pengguna = $row['nama'];


  $user_id = $_SESSION['user_id'];

  // Mendapatkan ID transaksi yang belum selesai
  $query = "SELECT id FROM tbl_transaksi WHERE user_id = ? AND status = 'pending'";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $transaksi_id = $result->num_rows > 0 ? $result->fetch_assoc()['id'] : null;

  // Ambil jumlah item dari keranjang
  $cart_total = 0;
  if ($transaksi_id) {
    $query = "SELECT SUM(quantity) as total_quantity FROM tbl_detail_transaksi WHERE transaksi_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $transaksi_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $cart_total = $data['total_quantity'];
  }

  $jumlah_wishlist = 0;
  $query_wishlist = "SELECT * FROM tbl_wishlist WHERE user_id = ?";
  $stmt = $conn->prepare($query_wishlist);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result_wishlist = $stmt->get_result();
  $jumlah_wishlist = $result_wishlist->num_rows;
?>
  <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-primary border border-3 rounded  border-warning">
    <div class="container-fluid bg-primary">
      <img class="navbar-brand" src="fotologo/e-commerce.png" width="100px" height="50px">
      <ul class="navbar-nav col-lg-6 justify-content-lg-center">
        <li class="nav-item position-relative">
          <a class="nav-link" aria-current="page" href="cart12.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
              <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
            </svg>
            <span class="badge rounded-pill badge-notification bg-danger position-absolute" style="top: -5px; right: -10px;"><?php echo $cart_total; ?></span>
          </a>
        </li>
        <li class="nav-item ps-4 position-relative">
          <a class="nav-link" aria-current="page" href="daftarkeinginan.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
              <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
            </svg>
            <span class="badge rounded-pill badge-notification bg-danger position-absolute" style="top: -5px; right: -10px;"><?php echo $jumlah_wishlist; ?></span>
          </a>
        </li>
      </ul>
      <a class="navbar-brand">
        <div class="btn-group d-lg-flex col-lg-3 justify-content-lg-end">
          <a class="bg-transparent rounded-pill d-grid gap-2 d-md-flex justify-content-md-end text-decoration-none" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="http://localhost/E-commerce/E-commerce/website/fotosampul/<?php echo $row['foto_profil']; ?>" alt="Logo" style="width: 40px;" class="rounded-pill  me-md-2">
            <h1 class="navbar-brand text-light mb-0">
              <?php echo $nama_pengguna; ?>
            </h1>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
            <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="cart12.php">Keranjang saya</a></li>
            <li><a class="dropdown-item" href="daftarkeinginan.php">Daftar keinginan</a></li>
            <li><a class="dropdown-item" href="pesanansaya.php">Pesanan saya</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="pengaturanakun.php">Pengaturan akun</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="tambahproduk.php">Tambah Produk</a></li>
            <li><a class="dropdown-item" href="jual.php">Penjualan Saya</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="login/loggout.php">Logout</a></li>
          </ul>
        </div>
      </a>
    </div>
  </nav>

<?php
} else {
  echo "Pengguna tidak ditemukan.";
}
?>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->