<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit();
}
include '../koneksi.php';

$id = "";
$id_kategori = "";
$nama_produk = "";
$deskripsi = "";
$harga = "";
$stok = "";
$gambar_produk = "";
$gambar_detail = array();

//Proses form jika ada data yang disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $id_kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $nama_produk = mysqli_real_escape_string($conn, $_POST['namaproduk']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $user_id = $_SESSION['user_id'];
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

    //simpan gambar dahulu
    if ($_FILES['foto']['name'] != '') {
        // Ambil nama gambar lama untuk dihapus dari sistem file
        $query_get_old_image = "SELECT gambar FROM tbl_produk WHERE id = '$id' AND user_id = '$user_id'";
        $result = mysqli_query($conn, $query_get_old_image);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $old_image = $row['gambar'];
            // Hapus gambar dari sistem file
            $path_to_delete = 'gambar/' . $old_image;
            if (file_exists($path_to_delete)) {
                unlink($path_to_delete);
            }
        }

        // Upload gambar baru
        $gambar = $_FILES['foto']['name'];
        $gambar_tmp = $_FILES['foto']['tmp_name'];
        $simpan = 'gambar/' . $gambar;
        move_uploaded_file($gambar_tmp, $simpan);

        // Update nama file gambar di database
        $query_update_gambar = "UPDATE tbl_produk SET gambar = '$gambar' WHERE id = '$id' AND user_id = '$user_id'";
        mysqli_query($conn, $query_update_gambar);
    } else {
        // Jika tidak ada perubahan gambar, tetap update data lainnya
        $query_update = "UPDATE tbl_produk SET nama_produk = '$nama_produk', deskripsi = '$deskripsi', harga = '$harga', stok = '$stok' WHERE id = '$id' AND user_id = '$user_id'";
        mysqli_query($conn, $query_update);
    }


    // Query untuk mendapatkan gambar detail yang sudah ada
    $query_select_detail = "SELECT gambar_detail FROM tbl_gambar WHERE produk_id = '$id'";
    $result_select_detail = mysqli_query($conn, $query_select_detail);
    while ($row = mysqli_fetch_assoc($result_select_detail)) {
        $gambar_detail_lama[] = $row['gambar_detail'];
    }

    // Proses untuk foto detail
    if (!empty($_FILES['fotodetail']['name'][0])) {
        $total = count($_FILES['fotodetail']['name']);

        // Hapus gambar-gambar detail lama terlebih dahulu
        foreach ($gambar_detail_lama as $gambar_lama) {
            $path_gambar_lama = 'gambardetail/' . $gambar_lama;
            if (file_exists($path_gambar_lama)) {
                unlink($path_gambar_lama); // Hapus file dari direktori server
            }
            // Hapus entri dari database
            $query_delete_detail = "DELETE FROM tbl_gambar WHERE produk_id = '$id' AND gambar_detail = '$gambar_lama'";
            mysqli_query($conn, $query_delete_detail);
        }

        // Loop untuk mengunggah setiap gambar detail
        for ($i = 0; $i < $total; $i++) {
            $gambar_detail = $_FILES['fotodetail']['name'][$i];
            $gambar_detail_tmp = $_FILES['fotodetail']['tmp_name'][$i];
            $simpan_detail = 'gambardetail/' . $gambar_detail;
            move_uploaded_file($gambar_detail_tmp, $simpan_detail);

            // Insert nama file gambar detail ke database
            $query_insert_detail = "INSERT INTO tbl_gambar (produk_id, gambar_detail) VALUES ('$id', '$gambar_detail')";
            mysqli_query($conn, $query_insert_detail);
        }
    }

    include 'dynamic_form_editproduk.php';
    // Query untuk melakukan update produk
    if ($harga !== null && $stok !== null) {
        $query_update_produk = "UPDATE tbl_produk SET 
                            id_kategori = '$id_kategori',
                            nama_produk = '$nama_produk',
                            deskripsi = '$deskripsi',
                            harga = '$harga',
                            stok = '$stok'
                            WHERE id = '$id' AND user_id = '$user_id'";

        if (mysqli_query($conn, $query_update_produk)) {
            // Redirect ke halaman penjualan setelah berhasil diupdate
            header("Location: jual.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Jika tidak ada data yang disubmit, ambil data produk dari database untuk ditampilkan dalam form
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);

    // Query untuk memilih produk berdasarkan id_produk dan user_id
    $result = mysqli_query($conn, "SELECT * FROM tbl_produk WHERE id = '$id' AND user_id = '$user_id'");
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // Data produk
        $id_kategori = $row['id_kategori'];
        $nama_produk = $row['nama_produk'];
        $deskripsi = $row['deskripsi'];
        $harga = $row['harga'];
        $stok = $row['stok'];
        $gambar_produk = $row['gambar']; // Menyimpan nama gambar produk untuk ditampilkan atau diedit
    } else {
        // Produk tidak ditemukan atau bukan milik pengguna ini, lakukan redirect atau tindakan lain
        header("Location: jual.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <header>
        <?php include 'header/navbar.php'; ?>
    </header>
    <div class="d-flex align-items-center justify-content-center my-3">
        <h1>Edit Produk</p>
    </div>
    <div class="container-fluid bg-primary px-0">
        <div class="container bg-primary d-flex align-items-center justify-content-center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <!-- Update Tabel -->
                <p class="d-flex justify-content-center">Tambahkan Foto Sampul</p>
                <div class="upload-container" id="dropZoneMain">
                    <p>Drag & Drop Your File(s) Here To Upload</p>
                    <input type="file" id="fotoUtama" name="foto">
                </div>
                <br>
                <div id="previewUtama" class="uploaded-images d-flex justify-content-center"></div>
                <br>
                <p class="d-flex justify-content-center">Tambahkan Foto</p>
                <div class="upload-container" id="dropZoneDetail">
                    <p>Drag & Drop Your File(s) Here To Upload</p>
                    <input type="file" id="fotoDetail" name="fotodetail[]" class="form-control" multiple>
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
                    <textarea type="text" class="form-control" id="Deskripsi" name="deskripsi" placeholder="Masukan Deskripsi" rows="3" required></textarea>
                </div>
                <div id="additionalFields"></div>
                <br>
                <button type="submit" class="btn btn-danger" name="submit">Submit</button>
                <a href="jual.php" class="btn btn-secondary">Batal</a>
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