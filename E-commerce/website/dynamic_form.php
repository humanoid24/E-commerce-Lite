<?php
// Menyimpan data tambahan berdasarkan kategori
switch ($kategori) {
    case 1: // Asumsi ID 1 untuk Elektronik
        $brand = mysqli_real_escape_string($conn, $_POST['brand']);
        $model = mysqli_real_escape_string($conn, $_POST['model']);
        $screen_size = mysqli_real_escape_string($conn, $_POST['screen_size']);
        $resolution = mysqli_real_escape_string($conn, $_POST['resolution']);
        $battery_type = mysqli_real_escape_string($conn, $_POST['battery_type']);
        $operating_system = mysqli_real_escape_string($conn, $_POST['operating_system']);
        $special_features = mysqli_real_escape_string($conn, $_POST['special_features']);

        // Tambah Ukuran
        if (!empty($_POST['size']) && !empty($_POST['harga']) && !empty($_POST['stok'])) {
            $ukuran_list = $_POST['size'];

            // Pastikan bahwa jumlah elemen ukuran, harga, dan stok sama
            if (count($harga_list) === count($stok_list) && count($stok_list) === count($ukuran_list)) {
                // Menangani stok dan harga tambahan
                foreach ($ukuran_list as $index => $ukuran_elektronik) {
                    $ukuranElektronik = mysqli_real_escape_string($conn, $ukuran_elektronik);
                    $harga = isset($harga_list[$index]) ? mysqli_real_escape_string($conn, $harga_list[$index]) : 0;
                    $stok = isset($stok_list[$index]) ? mysqli_real_escape_string($conn, $stok_list[$index]) : 0;

                    // Insert data variasi produk
                    $query_variasi = "INSERT INTO ukuran (produk_id, ukuran, harga, stok) VALUES ('$id_baru', '$ukuranElektronik', '$harga', '$stok')";
                    mysqli_query($conn, $query_variasi);
                }
            } else {
                $_SESSION['pesan'] = "Jumlah ukuran, harga, dan stok tidak sesuai!";
                header("Location: tambahproduk.php");
                exit();
            }
        }



        if (!empty($_POST['warna'])) {
            $warna = $_POST['warna'];
            foreach ($warna as $warna_elektronik) {
                $warnaElektronik = mysqli_real_escape_string($conn, $warna_elektronik);
                $query_warnaElektronik = "INSERT INTO warna (produk_id, warna) VALUES ('$id_baru','$warnaElektronik')";
                if (!mysqli_query($conn, $query_warnaElektronik)) {
                    file_put_contents('debug_log.txt', "Error inserting into warna Elektronik: " . mysqli_error($conn) . "\n", FILE_APPEND);
                } else {
                    file_put_contents('debug_log.txt', "Inserted into Elektronik : $query_warnaElektronik\n", FILE_APPEND);
                }
            }
        }


        // Insert data ke tabel tbl_elektronik
        $query_elektronik = "INSERT INTO elektronik (nama, brand, model, screen_size, resolution, battery_type, operating_system, spesial_fitur, kategori_id, produk_id)
                                                 VALUES ('$name', '$brand', '$model', '$screen_size', '$resolution', '$battery_type', '$operating_system', '$special_features', '$kategori', '$id_baru')";
        if (!mysqli_query($conn, $query_elektronik)) {
            file_put_contents('debug_log.txt', "Error inserting into elektronik: " . mysqli_error($conn) . "\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "Inserted into elektronik: $query_elektronik\n", FILE_APPEND);
        }


        break;

    case 2: // Asumsi ID 2 untuk Pakaian
        $nama_pakaian = mysqli_real_escape_string($conn, $_POST['nama']);
        $bahan_pakaian = mysqli_real_escape_string($conn, $_POST['bahan']);
        $perawatan_pakaian = mysqli_real_escape_string($conn, $_POST['perawatan']);

        // Tambah Ukuran
        if (!empty($_POST['size']) && !empty($_POST['harga']) && !empty($_POST['stok'])) {
            $ukuran_list = $_POST['size'];

            // Pastikan bahwa jumlah elemen ukuran, harga, dan stok sama
            if (count($harga_list) === count($stok_list) && count($stok_list) === count($ukuran_list)) {
                // Menangani stok dan harga tambahan
                foreach ($ukuran_list as $index => $ukuran_pakaian) {
                    $ukuranPakaian = mysqli_real_escape_string($conn, $ukuran_pakaian);
                    $harga = isset($harga_list[$index]) ? mysqli_real_escape_string($conn, $harga_list[$index]) : 0;
                    $stok = isset($stok_list[$index]) ? mysqli_real_escape_string($conn, $stok_list[$index]) : 0;

                    // Insert data variasi produk
                    $query_variasi = "INSERT INTO ukuran (produk_id, ukuran, harga, stok) VALUES ('$id_baru', '$ukuranPakaian', '$harga', '$stok')";
                    mysqli_query($conn, $query_variasi);
                }
            } else {
                $_SESSION['pesan'] = "Jumlah ukuran, harga, dan stok tidak sesuai!";
                header("Location: tambahproduk.php");
                exit();
            }
        }

        if (!empty($_POST['warna'])) {
            $warna = $_POST['warna'];
            foreach ($warna as $warna_pakaian) {
                $warnaPakaian = mysqli_real_escape_string($conn, $warna_pakaian);
                $query_warnaPakaian = "INSERT INTO warna (produk_id, warna) VALUES ('$id_baru','$warnaPakaian')";
                if (!mysqli_query($conn, $query_warnaPakaian)) {
                    file_put_contents('debug_log.txt', "Error inserting into ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                } else {
                    file_put_contents('debug_log.txt', "Inserted into : $query_warnaPakaian\n", FILE_APPEND);
                }
            }
        }

        // Tambah Pakaian
        $query_pakaian = "INSERT INTO pakaian (kategori_id, produk_id, nama, type, instruksi_perawatan) 
                                              VALUES ('$kategori', '$id_baru', '$nama_pakaian', '$bahan_pakaian','$perawatan_pakaian')";
        if (!mysqli_query($conn, $query_pakaian)) {
            $_SESSION['pesan'] = "Gagal menyimpan data pakaian: " . mysqli_error($conn);
        }
        break;

        // Perlengkapan Rumah Tangga
    case 3:
        $jenis_perlengkapan = mysqli_real_escape_string($conn, $_POST['jenis']);
        $merek_perlengkapan = mysqli_real_escape_string($conn, $_POST['merk']);
        $bahan_perlengkapan = mysqli_real_escape_string($conn, $_POST['bahanPerlengkapan']);

        // Tambah Ukuran
        if (!empty($_POST['size']) && !empty($_POST['harga']) && !empty($_POST['stok'])) {
            $ukuran_list = $_POST['size'];

            // Pastikan bahwa jumlah elemen ukuran, harga, dan stok sama
            if (count($harga_list) === count($stok_list) && count($stok_list) === count($ukuran_list)) {
                // Menangani stok dan harga tambahan
                foreach ($ukuran_list as $index => $ukuran_perlengkapan) {
                    $ukuranPerlengkapan = mysqli_real_escape_string($conn, $ukuran_perlengkapan);
                    $harga = isset($harga_list[$index]) ? mysqli_real_escape_string($conn, $harga_list[$index]) : 0;
                    $stok = isset($stok_list[$index]) ? mysqli_real_escape_string($conn, $stok_list[$index]) : 0;

                    // Insert data variasi produk
                    $query_variasi = "INSERT INTO ukuran (produk_id, ukuran, harga, stok) VALUES ('$id_baru', '$ukuranPerlengkapan', '$harga', '$stok')";
                    mysqli_query($conn, $query_variasi);
                }
            } else {
                $_SESSION['pesan'] = "Jumlah ukuran, harga, dan stok tidak sesuai!";
                header("Location: tambahproduk.php");
                exit();
            }
        }

        if (!empty($_POST['warna'])) {
            $warna = $_POST['warna'];
            foreach ($warna as $warna_perlengkapan) {
                $warnaPerlengkapan = mysqli_real_escape_string($conn, $warna_perlengkapan);
                $query_warnaPerlengkapan = "INSERT INTO warna (produk_id, warna) VALUES ('$id_baru','$warnaPerlengkapan')";
                if (!mysqli_query($conn, $query_warnaPerlengkapan)) {
                    file_put_contents('debug_log.txt', "Error inserting into ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                } else {
                    file_put_contents('debug_log.txt', "Inserted into : $query_warnaPerlengkapan\n", FILE_APPEND);
                }
            }
        }

        // Tambah Perlengkapan Rumah tangga
        $query_perlengkapan = "INSERT INTO perlengkapan_rumah_tangga (produk_id, kategori_id, jenis, merk, bahan) 
                                              VALUES ('$id_baru', '$kategori', '$jenis_perlengkapan', '$merek_perlengkapan','$bahan_perlengkapan')";
        if (!mysqli_query($conn, $query_perlengkapan)) {
            $_SESSION['pesan'] = "Gagal menyimpan data perlengkapan_rumah_tangga: " . mysqli_error($conn);
        }
        break;


        // Kesehatan dan Kecantikan
    case 4:
        $kategori_kesehatan = mysqli_real_escape_string($conn, $_POST['kategori_kesehatan']);
        $merk_kesehatan = mysqli_real_escape_string($conn, $_POST['merk']);
        $jenis_kesehatan = mysqli_real_escape_string($conn, $_POST['jenis']);
        $vitamin_kesehatan = mysqli_real_escape_string($conn, $_POST['vitamin']);
        $isi_kesehatan = mysqli_real_escape_string($conn, $_POST['isi']);

        $query_kesehatan = "INSERT INTO kesehatan_kecantikan (produk_id, kategori_id, kategori, merk, jenis, bahan_aktif, volume) 
                                                VALUES ('$id_baru', '$kategori', '$kategori_kesehatan', '$merk_kesehatan', '$jenis_kesehatan', '$vitamin_kesehatan', '$isi_kesehatan')";
        if (!mysqli_query($conn, $query_kesehatan)) {
            file_put_contents('debug_log.txt', "Error inserting into kesehatan_kecantikan: " . mysqli_error($conn) . "\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "Inserted into : $query_kesehatan\n", FILE_APPEND);
        }
        break;

        // Otomotif
    case 5:
        $kategori_otomotif = mysqli_real_escape_string($conn, $_POST['kategori_otomotif']);
        $merk_otomotif = mysqli_real_escape_string($conn, $_POST['merk']);
        $model_otomotif = mysqli_real_escape_string($conn, $_POST['model']);
        $jenis_kendaraan_otomotif = mysqli_real_escape_string($conn, $_POST['jenis']);

        $query_otomotif = "INSERT INTO otomotif (produk_id, kategori_id, jenis, merk, model, jenis_kendaraan) 
                                                VALUES ('$id_baru', '$kategori', '$kategori_otomotif', '$merk_otomotif', '$model_otomotif', '$jenis_kendaraan_otomotif')";
        if (!mysqli_query($conn, $query_otomotif)) {
            file_put_contents('debug_log.txt', "Error inserting into otomotif: " . mysqli_error($conn) . "\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "Inserted into : $query_otomotif\n", FILE_APPEND);
        }
        break;

        // Mainan dan Hobi
    case 6:
        $kategori_mainan = mysqli_real_escape_string($conn, $_POST['kategori_anak']);
        $merk_mainan = mysqli_real_escape_string($conn, $_POST['merk']);
        $jenis_mainan = mysqli_real_escape_string($conn, $_POST['jenis']);
        $bahan_mainan = mysqli_real_escape_string($conn, $_POST['bahan']);

        $query_mainan = "INSERT INTO mainan_hobi (produk_id, kategori_id, kategori, merk, jenis, bahan) 
                                             VALUES ('$id_baru', '$kategori', '$kategori_mainan','$merk_mainan','$jenis_mainan','$bahan_mainan')";
        if (!mysqli_query($conn, $query_mainan)) {
            file_put_contents('debug_log.txt', "Error inserting into mainan_hobi: " . mysqli_error($conn) . "\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "Inserted into : $query_mainan\n", FILE_APPEND);
        }
        break;


        // Makanan dan minuman
    case 7:
        $kategori_makanan = mysqli_real_escape_string($conn, $_POST['kategori_makanan']);
        $merk_makanan = mysqli_real_escape_string($conn, $_POST['merk']);
        $jenis_makanan = mysqli_real_escape_string($conn, $_POST['jenis']);
        $berat_makanan = mysqli_real_escape_string($conn, $_POST['berat']);
        $tanggal_makanan = mysqli_real_escape_string($conn, $_POST['tanggalkadaluarsa']);

        $query_makanan = "INSERT INTO makanan_minuman (produk_id, kategori_id, kategori, merk, jenis, berat_volume, tanggal_kadaluarsa) 
                                             VALUES ('$id_baru', '$kategori', '$kategori_makanan','$merk_makanan','$jenis_makanan','$berat_makanan','$tanggal_makanan')";
        if (!mysqli_query($conn, $query_makanan)) {
            file_put_contents('debug_log.txt', "Error inserting into Makanan: " . mysqli_error($conn) . "\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "Inserted into : $query_makanan\n", FILE_APPEND);
        }
        break;
        // Tambahkan case untuk kategori lain jika diperlukan


        // Perhiasan
    case 8:
        $kategori_perhiasan = mysqli_real_escape_string($conn, $_POST['kategori_perhiasan']);
        $merk_perhiasan = mysqli_real_escape_string($conn, $_POST['merk']);
        $bahan_perhiasan = mysqli_real_escape_string($conn, $_POST['bahan']);
        $jenisBatu_perhiasan = mysqli_real_escape_string($conn, $_POST['jenisbatu']);

        // Tambah Ukuran
        if (!empty($_POST['size']) && !empty($_POST['harga']) && !empty($_POST['stok'])) {
            $ukuran_list = $_POST['size'];

            // Pastikan bahwa jumlah elemen ukuran, harga, dan stok sama
            if (count($harga_list) === count($stok_list) && count($stok_list) === count($ukuran_list)) {
                // Menangani stok dan harga tambahan
                foreach ($ukuran_list as $index => $ukuran_perhiasan) {
                    $ukuranPerhiasan = mysqli_real_escape_string($conn, $ukuran_perhiasan);
                    $harga = isset($harga_list[$index]) ? mysqli_real_escape_string($conn, $harga_list[$index]) : 0;
                    $stok = isset($stok_list[$index]) ? mysqli_real_escape_string($conn, $stok_list[$index]) : 0;

                    // Insert data variasi produk
                    $query_variasi = "INSERT INTO ukuran (produk_id, ukuran, harga, stok) VALUES ('$id_baru', '$ukuranPerhiasan', '$harga', '$stok')";
                    mysqli_query($conn, $query_variasi);
                }
            } else {
                $_SESSION['pesan'] = "Jumlah ukuran, harga, dan stok tidak sesuai!";
                header("Location: tambahproduk.php");
                exit();
            }
        }

        $query_perhiasan = "INSERT INTO perhiasan (produk_id, kategori_id, kategori, merk, bahan, jenis_batu) 
                                             VALUES ('$id_baru', '$kategori', '$kategori_perhiasan','$merk_perhiasan','$bahan_perhiasan','$jenisBatu_perhiasan')";
        if (!mysqli_query($conn, $query_perhiasan)) {
            file_put_contents('debug_log.txt', "Error inserting into Perhiasan: " . mysqli_error($conn) . "\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "Inserted into : $query_perhiasan\n", FILE_APPEND);
        }
        break;


        // Alat Musik
    case 9:
        $kategori_musik = mysqli_real_escape_string($conn, $_POST['kategori_alat']);
        $merk_musik = mysqli_real_escape_string($conn, $_POST['merk']);
        $model_musik = mysqli_real_escape_string($conn, $_POST['model']);
        $jenis_musik = mysqli_real_escape_string($conn, $_POST['jenis']);
        $query_musik = "INSERT INTO alat_musik (produk_id, kategori_id, kategori, merk, model, jenis) 
                                             VALUES ('$id_baru', '$kategori', '$kategori_musik','$merk_musik','$model_musik','$jenis_musik')";
        if (!mysqli_query($conn, $query_musik)) {
            file_put_contents('debug_log.txt', "Error inserting into Musik: " . mysqli_error($conn) . "\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "Inserted into : $query_musik\n", FILE_APPEND);
        }
        break;

        // Furniture
    case 10:
        $kategori_furniture = mysqli_real_escape_string($conn, $_POST['kategori_furniture']);
        $merk_furniture = mysqli_real_escape_string($conn, $_POST['merk']);
        $bahan_furniture = mysqli_real_escape_string($conn, $_POST['bahan']);

        // Tambah Ukuran
        if (!empty($_POST['size']) && !empty($_POST['harga']) && !empty($_POST['stok'])) {
            $ukuran_list = $_POST['size'];

            // Pastikan bahwa jumlah elemen ukuran, harga, dan stok sama
            if (count($harga_list) === count($stok_list) && count($stok_list) === count($ukuran_list)) {
                // Menangani stok dan harga tambahan
                foreach ($ukuran_list as $index => $ukuran_furniture) {
                    $ukuranFurniture = mysqli_real_escape_string($conn, $ukuran_furniture);
                    $harga = isset($harga_list[$index]) ? mysqli_real_escape_string($conn, $harga_list[$index]) : 0;
                    $stok = isset($stok_list[$index]) ? mysqli_real_escape_string($conn, $stok_list[$index]) : 0;

                    // Insert data variasi produk
                    $query_variasi = "INSERT INTO ukuran (produk_id, ukuran, harga, stok) VALUES ('$id_baru', '$ukuranFurniture', '$harga', '$stok')";
                    mysqli_query($conn, $query_variasi);
                }
            } else {
                $_SESSION['pesan'] = "Jumlah ukuran, harga, dan stok tidak sesuai!";
                header("Location: tambahproduk.php");
                exit();
            }
        }

        if (!empty($_POST['warna'])) {
            $warna = $_POST['warna'];
            foreach ($warna as $warna_Furniture) {
                $warnaFurniture = mysqli_real_escape_string($conn, $warna_Furniture);
                $query_warnaFurniture = "INSERT INTO warna (produk_id, warna) VALUES ('$id_baru','$warnaFurniture')";
                if (!mysqli_query($conn, $query_warnaFurniture)) {
                    file_put_contents('debug_log.txt', "Error inserting into ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                } else {
                    file_put_contents('debug_log.txt', "Inserted into : $query_warnaFurniture\n", FILE_APPEND);
                }
            }
        }

        // Tambah Furniture
        $query_furniture = "INSERT INTO furniture (produk_id, kategori_id, kategori, merk, bahan) 
                                              VALUES ('$id_baru', '$kategori', '$kategori_furniture', '$merk_furniture','$bahan_furniture')";
        if (!mysqli_query($conn, $query_furniture)) {
            $_SESSION['pesan'] = "Gagal menyimpan data Furniture: " . mysqli_error($conn);
        }
        break;


        // Buku
    case 12:
        $kategori_buku = mysqli_real_escape_string($conn, $_POST['kategori_buku']);
        $penulis_buku = mysqli_real_escape_string($conn, $_POST['penulis']);
        $penerbit_buku = mysqli_real_escape_string($conn, $_POST['penerbit']);
        $tanggal_terbit = mysqli_real_escape_string($conn, $_POST['tanggalterbit']);
        $isbn_buku = mysqli_real_escape_string($conn, $_POST['isbn']);

        $query_buku = "INSERT INTO buku_media (produk_id, kategori_id, kategori, penulis, penerbit, tahun_terbit, isbn) 
                                             VALUES ('$id_baru', '$kategori', '$kategori_buku','$penulis_buku','$penerbit_buku','$tanggal_terbit','$isbn_buku')";
        if (!mysqli_query($conn, $query_buku)) {
            file_put_contents('debug_log.txt', "Error inserting into buku_media: " . mysqli_error($conn) . "\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "Inserted into : $query_buku\n", FILE_APPEND);
        }
        break;

    case 13:
        // Tambah Ukuran
        if (!empty($_POST['size']) && !empty($_POST['harga']) && !empty($_POST['stok'])) {
            $ukuran_list = $_POST['size'];

            // Pastikan bahwa jumlah elemen ukuran, harga, dan stok sama
            if (count($harga_list) === count($stok_list) && count($stok_list) === count($ukuran_list)) {
                // Menangani stok dan harga tambahan
                foreach ($ukuran_list as $index => $ukuran_lain) {
                    $ukuranLain = mysqli_real_escape_string($conn, $ukuran_lain);
                    $harga = isset($harga_list[$index]) ? mysqli_real_escape_string($conn, $harga_list[$index]) : 0;
                    $stok = isset($stok_list[$index]) ? mysqli_real_escape_string($conn, $stok_list[$index]) : 0;

                    // Insert data variasi produk
                    $query_variasi = "INSERT INTO ukuran (produk_id, ukuran, harga, stok) VALUES ('$id_baru', '$ukuranLain', '$harga', '$stok')";
                    mysqli_query($conn, $query_variasi);
                }
            } else {
                $_SESSION['pesan'] = "Jumlah ukuran, harga, dan stok tidak sesuai!";
                header("Location: tambahproduk.php");
                exit();
            }
        }

        if (!empty($_POST['warna'])) {
            $warna = $_POST['warna'];
            foreach ($warna as $warna_lain) {
                $warnaLain = mysqli_real_escape_string($conn, $warna_lain);
                $query_warnaLain = "INSERT INTO warna (produk_id, warna) VALUES ('$id_baru','$warnaLain')";
                if (!mysqli_query($conn, $query_warnaLain)) {
                    file_put_contents('debug_log.txt', "Error inserting into ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                } else {
                    file_put_contents('debug_log.txt', "Inserted into : $query_warnaLain\n", FILE_APPEND);
                }
            }
        }
        break;

        // Tambahkan case untuk kategori lain jika diperlukan
}

?>