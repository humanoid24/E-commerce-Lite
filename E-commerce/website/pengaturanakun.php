<?php
    include '../koneksi.php';
    session_start();
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: login/login.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
        $nama_lengkap = mysqli_real_escape_string($conn, $_POST['namalengkap']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
        $notlp = mysqli_real_escape_string($conn, $_POST['notelepon']);
        
        // Handle file upload
        if (!empty($_FILES['fotoprofil']['name'])) {
            $foto_profil = $_FILES['fotoprofil']['name'];
            $foto_tmp = $_FILES['fotoprofil']['tmp_name'];
            $uploadDir = 'fotosampul/'; // Lokasi penyimpanan file di server
            $simpan = $uploadDir . $foto_profil;
            
            // Pindahkan file ke direktori yang ditentukan
            if (move_uploaded_file($foto_tmp, $simpan)) {
                // Query UPDATE dengan tambahan kolom foto_profil
                $queryUpdate = "UPDATE tbl_user SET 
                                nama = '$nama_lengkap',
                                username = '$username',
                                password = '$password',
                                alamat = '$alamat',
                                no_telepon = '$notlp',
                                foto_profil = '$foto_profil' WHERE id = '$id' ";
                
                $result = mysqli_query($conn, $queryUpdate);
                if (!$result) {
                    die("Query gagal dijalankan: " . mysqli_error($conn));
                }
            } else {
                echo "Gagal mengupload file.";
            }
        } else {
            // Jika tidak ada file di-upload, jalankan query UPDATE tanpa foto_profil
            $queryUpdate = "UPDATE tbl_user SET 
                            nama = '$nama_lengkap',
                            username = '$username',
                            password = '$password',
                            alamat = '$alamat',
                            no_telepon = '$notlp' WHERE id = '$id' ";
            
            $result = mysqli_query($conn, $queryUpdate);
            if (!$result) {
                die("Query gagal dijalankan: " . mysqli_error($conn));
            }
        }
    }

    // Ambil data user untuk ditampilkan di form
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM tbl_user WHERE id = $user_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nama_pengguna = $row['nama'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<header>
    <?php include 'header/navbar.php'; ?>
</header>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark pt-4">
            <!-- Sidebar -->
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <h1 class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Pengaturan Akun</span>
                </h1>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <!-- Daftar Menu Sidebar -->
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="cart12.php" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Keranjang Saya</span></a>
                    </li>
                    <li>
                        <a href="daftarkeinginan.php" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Daftar Keinginan</span></a>
                    </li>
                    <li>
                        <a href="pesanansaya.php" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Pesanan Saya</span></a>
                    </li>
                    <li>
                        <a href="tambahproduk.php" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Tambah Produk</span></a>
                    </li>
                    <li>
                        <a href="jual.php" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Penjualan Saya</span></a>
                    </li>
                    <li>
                        <a href="login/loggout.php" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Log out</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Form Edit User -->
        <span class="border border-2 border-secondary col py-3 mx-2 mt-2 mb-2 p-2">
            <div class="col py-3 mx-auto p-2 text-center">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <h1>Edit User</h1>
                    <div class="col-md-7 col-lg-8 mx-auto p-2 pt-2">
                        <div class="row g-3 pt-2">
                            <div class="col-12">
                                <img id="selectedAvatar" src="fotosampul/<?php echo($row['foto_profil']); ?>"
                                class="rounded-circle" style="width: 200px; height: 200px; object-fit: cover;" alt="Foto Profil"/>
                            </div>
                            <div class="col-12">
                                <div data-mdb-ripple-init class="btn btn-primary btn-rounded">
                                    <label class="form-label text-white m-1" for="fotoprofil">Pilih Foto Profil</label>
                                    <input type="file" class="form-control d-none" name="fotoprofil" id="fotoprofil" onchange="displaySelectedImage(event, 'selectedAvatar')" />
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="namalengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="namalengkap" name="namalengkap" placeholder="Nama Lengkap" value="<?php echo htmlspecialchars($nama_pengguna); ?>" required>
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
                                <div class="invalid-feedback">
                                    Your username is required.
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo htmlspecialchars($row['password']); ?>" required>
                                <div class="invalid-feedback">
                                    Your Password is required.
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat Rumah" value="<?php echo htmlspecialchars($row['alamat']); ?>" required>
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="notelepon" class="form-label">No telepon</label>
                                <input type="text" class="form-control" id="notelepon" name="notelepon" placeholder="No Telepon" value="<?php echo htmlspecialchars($row['no_telepon']); ?>">
                            </div>
                            <hr class="my-4">
                            <button class="w-100 btn btn-primary btn-lg" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </span>
    </div>
</div>

<!-- JavaScript Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  function displaySelectedImage(event, elementId) {
    const selectedImage = document.getElementById(elementId);
    const fileInput = event.target;

    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            selectedImage.src = e.target.result;
        };

        reader.readAsDataURL(fileInput.files[0]);
    }
}
</script>
</body>
</html>
<?php
    } else {
        echo "Pengguna tidak ditemukan.";
    }
    mysqli_close($conn);
?>
