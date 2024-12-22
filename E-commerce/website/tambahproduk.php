<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit();
}
include '../koneksi.php';

if (isset($_POST['submit'])) {
    // Ambil data form
    $user_id = $_SESSION['user_id'];
    $name = mysqli_real_escape_string($conn, $_POST['namaproduk']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);

    // Validasi input
    if (empty($name) || empty($deskripsi) || empty($kategori)) {
        $_SESSION['pesan'] = "Semua field harus diisi!";
        header("Location: tambahproduk.php");
        exit();
    }

    // Upload gambar utama
    $gambar = $_FILES['foto']['name'];
    $gambar_tmp = $_FILES['foto']['tmp_name'];
    $gambar_error = $_FILES['foto']['error'];
    $gambar_size = $_FILES['foto']['size'];

    $izinkan = ['image/jpeg', 'image/jpg', 'image/png'];
    $file_type = mime_content_type($gambar_tmp);

    if ($gambar_error === UPLOAD_ERR_OK) {
        if (in_array($file_type, $izinkan)) {
            if ($gambar_size < 8000000) {
                // Simpan gambar utama
                $simpan = 'gambar/' . $gambar;
                move_uploaded_file($gambar_tmp, $simpan);

                // Ambil harga dan stok satuan
                $harga_satuan = !empty($_POST['harga_barang']) ? $_POST['harga_barang'] : null;
                $stok_satuan = !empty($_POST['stok_barang']) ? $_POST['stok_barang'] : null;

                $harga_list = !empty($_POST['harga']) ? $_POST['harga'] : [];
                $stok_list = !empty($_POST['stok']) ? $_POST['stok'] : [];
                $harga_pertama = !empty($harga_list[0]) ? $harga_list[0] : 0;
                $stok_pertama = !empty($stok_list[0]) ? $stok_list[0] : 0;

                // Tentukan harga dan stok yang akan digunakan
                $harga = !empty($harga_pertama) ? $harga_pertama : $harga_satuan;
                $stok = !empty($stok_pertama) ? $stok_pertama : $stok_satuan;

                // Validasi input
                if ($harga !== null && $stok !== null) {
                    // Persiapkan query
                    $query = "INSERT INTO tbl_produk (user_id, id_kategori, nama_produk, deskripsi, harga, gambar, stok) VALUES (?, ?, ?, ?, ?, ?, ?)";

                    // Gunakan prepared statements
                    $stmt = $conn->prepare($query);
                    if ($stmt === false) {
                        die("Prepared statement failed: " . $conn->error);
                    }

                    // Bind parameter
                    $stmt->bind_param("iissisi", $user_id, $kategori, $name, $deskripsi, $harga, $gambar, $stok);

                    // Eksekusi query
                    if ($stmt->execute()) {
                        // Redirect atau pesan sukses jika perlu
                    } else {
                        $_SESSION['pesan'] = "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
                        header("Location: tambahproduk.php");
                        exit();
                    }

                    $stmt->close();
                } else {
                    $_SESSION['pesan'] = "Masukan harga dan stok terlebih dahulu";
                    header("Location: tambahproduk.php");
                    exit();
                }

                $id_baru = mysqli_insert_id($conn);

                include 'dynamic_form.php';

                if (!empty($_FILES['fotodetail']['name'][0])) {
                    $gambardetail = $_FILES['fotodetail'];
                    $total = count($gambardetail['name']);
                    for ($i = 0; $i < $total; $i++) {
                        // Inisialisasi variabel di dalam loop
                        $gambardetail_name = $gambardetail['name'][$i];
                        $gambardetail_tmp = $gambardetail['tmp_name'][$i];
                        $gambar_error_detail = $gambardetail['error'][$i];
                        $gambar_size_detail = $gambardetail['size'][$i];
                        $file_type_detail = mime_content_type($gambardetail_tmp);

                        if ($gambar_error_detail === UPLOAD_ERR_OK) {
                            if (in_array($file_type_detail, $izinkan)) {
                                if ($gambar_size_detail < 8000000) {
                                    $nama_baru_lagi = uniqid() . basename($gambardetail_name);
                                    $simpandetail = 'gambardetail/' . $nama_baru_lagi;

                                    if (move_uploaded_file($gambardetail_tmp, $simpandetail)) {
                                        $query_detail = "INSERT INTO tbl_gambar (produk_id, gambar_detail) VALUES ('$id_baru', '$nama_baru_lagi')";
                                        if (!mysqli_query($conn, $query_detail)) {
                                            error_log("Error inserting into tbl_gambar: " . mysqli_error($conn));
                                        }
                                    } else {
                                        $_SESSION['pesan'] = "Terjadi kesalahan saat mengupload gambar detail";
                                    }
                                } else {
                                    $_SESSION['pesan'] = "Ukuran file gambar detail terlalu besar";
                                }
                            } else {
                                $_SESSION['pesan'] = "Format file gambar detail tidak valid";
                            }
                        } else {
                            $_SESSION['pesan'] = "Terjadi kesalahan saat mengupload gambar detail";
                        }
                    }
                }

                // Redirect setelah berhasil
                header("Location: dashboard.php");
                exit();
            } else {
                $_SESSION['pesan'] = "Ukuran file terlalu besar";
            }
        } else {
            $_SESSION['pesan'] = "Format File gambar tidak valid";
        }
    } else {
        $_SESSION['pesan'] = "Terjadi kesalahan saat mengupload gambar";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<header>
    <?php include 'header/navbar.php'; ?>
</header>

<body class="bg-primary">
    <div class="d-flex align-items-center justify-content-center my-3">
        <h1>Tambah Produk</p>
    </div>
    <div class="container-fluid bg-primary">
        <div class="container bg-primary d-flex align-items-center justify-content-center">
            <?php
            if (isset($_SESSION['pesan'])) {
                echo '<div class="alert alert-info">' . $_SESSION['pesan'] . '</div>';
                unset($_SESSION['pesan']); // Hapus pesan setelah ditampilkan
            }
            ?>
            <form action="" method="post" enctype="multipart/form-data">
                <p class="d-flex justify-content-center">Tambahkan Foto Sampul</p>
                <div class="upload-container" id="dropZoneMain">
                    <p>Drag & Drop Your File(s) Here To Upload</p>
                    <input type="file" id="fotoUtama" name="foto">
                </div>
                <br>
                <div id="previewUtama" class="uploaded-images d-flex justify-content-center"></div>
                <br>
                <p class="d-flex justify-content-center">Tambahkan Foto Lainnya</p>
                <div class="upload-container" id="dropZoneDetail">
                    <p>Drag & Drop Your File(s) Here To Upload</p>
                    <input type="file" id="fotoDetail" name="fotodetail[]" accept="image/" class="form-control" multiple>
                </div>
                <br>
                <div id="fileList" class="uploaded-images">
                    <ul class="uploaded-images"></ul>
                </div>
                <br>
                <div class="mb-3">
                    <label for="kategori" class="form-label d-flex justify-content-center">Pilih Kategori</label>
                    <select class="form-select" id="kategori" name="kategori" aria-label="Default select example" required>
                        <option value="">Pilih Kategori</option>
                        <?php
                        include '../koneksi.php';
                        $view_option = mysqli_query($conn, "SELECT * FROM tbl_kategori");
                        while ($rows = mysqli_fetch_array($view_option)) { ?>
                            <option value="<?php echo $rows['id']; ?>"><?php echo $rows['nama_kategori']; ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="NamaProduk" class="form-label d-flex justify-content-center">Nama Produk</label>
                    <input type="text" class="form-control" id="NamaProduk" name="namaproduk" placeholder="Masukan Nama Produk" required>
                </div>
                <div class="mb-3">
                    <label for="Deskripsi" class="form-label d-flex justify-content-center">Deskripsi</label>
                    <textarea class="form-control" id="Deskripsi" name="deskripsi" placeholder="Masukan Deskripsi" rows="3" required></textarea>
                </div>
                <div id="additionalFields"></div>
                <br>
                <button type="submit" class="btn btn-danger" name="submit">Submit</button>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Handle photo utama
            const dropZoneMain = document.getElementById('dropZoneMain');
            const fileInputMain = dropZoneMain.querySelector('input[type="file"]');
            const previewUtama = document.getElementById('previewUtama');
            let objectUrlMain = null;

            // Handle drag over for main photo
            dropZoneMain.addEventListener('dragover', (event) => {
                event.preventDefault();
                dropZoneMain.classList.add('dragover');
            });

            // Handle drag leave for main photo
            dropZoneMain.addEventListener('dragleave', () => {
                dropZoneMain.classList.remove('dragover');
            });

            // Handle drop for main photo
            dropZoneMain.addEventListener('drop', (event) => {
                event.preventDefault();
                dropZoneMain.classList.remove('dragover');
                const files = event.dataTransfer.files;
                addFileMain(files);
            });

            // Handle click to open file selector for main photo
            dropZoneMain.addEventListener('click', () => {
                fileInputMain.click();
            });

            fileInputMain.addEventListener('change', () => {
                const files = fileInputMain.files;
                addFileMain(files);
            });

            // Add file to the main photo preview
            function addFileMain(files) {
                const file = files[0];
                if (file) {
                    if (file.type.startsWith('image/')) { // Memeriksa jika file adalah gambar
                        if (objectUrlMain) {
                            URL.revokeObjectURL(objectUrlMain); // Revoke old URL jika ada
                        }
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            previewUtama.innerHTML = ''; // Clear existing preview
                            const imgElement = document.createElement('img');
                            imgElement.src = event.target.result;
                            imgElement.alt = file.name;
                            previewUtama.appendChild(imgElement);

                            const deleteButton = document.createElement('button');
                            deleteButton.innerHTML = '&times;';
                            deleteButton.classList.add('delete-btn');
                            deleteButton.onclick = function() {
                                previewUtama.innerHTML = ''; // Clear preview
                                fileInputMain.value = ''; // Clear file input
                                if (objectUrlMain) {
                                    URL.revokeObjectURL(objectUrlMain); // Revoke object URL
                                    objectUrlMain = null;
                                }
                            };

                            var imageWrapper = document.createElement('div');
                            imageWrapper.classList.add('image-wrapper');
                            imageWrapper.appendChild(imgElement);
                            imageWrapper.appendChild(deleteButton);
                            previewUtama.appendChild(imageWrapper);
                        };

                        reader.readAsDataURL(file);
                        objectUrlMain = URL.createObjectURL(file);
                    } else {
                        // Buat elemen untuk menampilkan pesan kesalahan
                        const errorMessage = document.createElement('div');
                        errorMessage.className = 'uploaded-images error-message';
                        errorMessage.textContent = `bukan file gambar.`;

                        previewUtama.appendChild(errorMessage);
                        setTimeout(() => {
                            previewUtama.removeChild(errorMessage);
                        }, 3000);
                    }
                }
            }

            // Handle photo detail
            const dropZoneDetail = document.getElementById('dropZoneDetail');
            const fileInputDetail = dropZoneDetail.querySelector('input[type="file"]');
            const fileList = document.getElementById('fileList').querySelector('ul');
            let objectUrlsDetail = [];
            let filesArrayDetail = [];

            // Handle drag over for detail photos
            dropZoneDetail.addEventListener('dragover', (event) => {
                event.preventDefault();
                dropZoneDetail.classList.add('dragover');
            });

            // Handle drag leave for detail photos
            dropZoneDetail.addEventListener('dragleave', () => {
                dropZoneDetail.classList.remove('dragover');
            });

            // Handle drop for detail photos
            dropZoneDetail.addEventListener('drop', (event) => {
                event.preventDefault();
                dropZoneDetail.classList.remove('dragover');
                const files = event.dataTransfer.files;
                addFilesDetail(files);
            });

            // Handle click to open file selector for detail photos
            dropZoneDetail.addEventListener('click', () => {
                fileInputDetail.click();
            });

            fileInputDetail.addEventListener('change', () => {
                const files = fileInputDetail.files;
                addFilesDetail(files);
            });

            // Add files to the detail photo list
            function addFilesDetail(files) {
                Array.from(files).forEach(file => {
                    if (!filesArrayDetail.some(f => f.name === file.name && f.size === file.size)) {
                        filesArrayDetail.push(file);

                        const li = document.createElement('li');
                        li.className = 'list-group-item image-wrapper';

                        if (file.type.startsWith('image/')) {
                            const img = document.createElement('img');
                            const objectUrl = URL.createObjectURL(file);
                            img.src = objectUrl;
                            img.alt = file.name;
                            li.appendChild(img);

                            // Save the object URL for revocation later
                            objectUrlsDetail.push(objectUrl);

                            li.dataset.objectUrl = objectUrl;

                            // Delete Gambar
                            const deleteButton = document.createElement('button');
                            deleteButton.innerHTML = '&times;';
                            deleteButton.classList.add('delete-btn');
                            deleteButton.onclick = function() {
                                fileList.removeChild(li);
                                filesArrayDetail = filesArrayDetail.filter(f => f !== file);

                                const objectUrl = li.dataset.objectUrl;
                                if (objectUrl) {
                                    URL.revokeObjectURL(objectUrl);
                                    // Remove the object URL from the list
                                    objectUrlsDetail = objectUrlsDetail.filter(url => url !== objectUrl);
                                }
                                // Update file input
                                const dataTransfer = new DataTransfer();
                                filesArrayDetail.forEach(file => dataTransfer.items.add(file));
                                fileInputDetail.files = dataTransfer.files;
                            };

                            li.appendChild(deleteButton);

                            fileList.appendChild(li);
                        } else {
                            // Buat elemen untuk menampilkan pesan kesalahan
                            const errorMessage = document.createElement('li');
                            errorMessage.className = 'list-group-item error-message';
                            errorMessage.textContent = `bukan file gambar.`;

                            fileList.appendChild(errorMessage);
                            setTimeout(() => {
                                fileList.removeChild(errorMessage);
                            }, 3000);
                        }

                        // const span = document.createElement('span');
                        // span.textContent = file.name;
                        // li.appendChild(span);


                    }
                });

                // Update file input
                const dataTransfer = new DataTransfer();
                filesArrayDetail.forEach(file => dataTransfer.items.add(file));
                fileInputDetail.files = dataTransfer.files;
            }

            // Cleanup function to revoke old object URLs
            function cleanup() {
                objectUrlsDetail.forEach(url => URL.revokeObjectURL(url));
                objectUrlsDetail = [];
            }

            // Perform cleanup on page unload
            window.addEventListener('beforeunload', cleanup);
        });
    </script>
    <script src="pilihkategoriJS_PHP/formkategori.js"></script>
    <script src="pilihkategoriJS_PHP/pilihanukuran.js"></script>

</body>

</html>