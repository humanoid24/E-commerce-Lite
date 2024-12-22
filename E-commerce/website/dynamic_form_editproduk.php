<?php
// Menyimpan data tambahan berdasarkan kategori
switch ($id_kategori) {
    case 1: // Asumsi ID 1 untuk Elektronik
        $brand = mysqli_real_escape_string($conn, $_POST['brand']);
        $model = mysqli_real_escape_string($conn, $_POST['model']);
        $screen_size = mysqli_real_escape_string($conn, $_POST['screen_size']);
        $resolution = mysqli_real_escape_string($conn, $_POST['resolution']);
        $battery_type = mysqli_real_escape_string($conn, $_POST['battery_type']);
        $operating_system = mysqli_real_escape_string($conn, $_POST['operating_system']);
        $special_features = mysqli_real_escape_string($conn, $_POST['special_features']);

        // Update ukuran
        if (!empty($_POST['size']) && !empty($_POST['harga']) && !empty($_POST['stok'])) {
            $ukuran_list = $_POST['size'];

            // Pastikan bahwa jumlah elemen ukuran, harga, dan stok sama
            if (count($harga_list) === count($stok_list) && count($stok_list) === count($ukuran_list)) {
                // Hapus data ukuran lama
                $query_delete_ukuran = "DELETE FROM ukuran WHERE produk_id = '$id'";
                if (!mysqli_query($conn,
                    $query_delete_ukuran
                )) {
                    file_put_contents('debug_log.txt', "Error deleting ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                }

                // Masukkan data ukuran baru
                foreach ($ukuran_list as $index => $ukuran_elektronik) {
                    $ukuranElektronik = mysqli_real_escape_string($conn, $ukuran_elektronik);
                    $harga = isset($harga_list[$index]) ? mysqli_real_escape_string($conn, $harga_list[$index]) : 0;
                    $stok = isset($stok_list[$index]) ? mysqli_real_escape_string($conn, $stok_list[$index]) : 0;

                    $query_variasi = "INSERT INTO ukuran (produk_id, ukuran, harga, stok) VALUES ('$id', '$ukuranElektronik', '$harga', '$stok')";
                    if (!mysqli_query($conn, $query_variasi)) {
                        file_put_contents('debug_log.txt', "Error inserting ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                    }
                }
            } else {
                $_SESSION['pesan'] = "Jumlah ukuran, harga, dan stok tidak sesuai!";
                header("Location: tambahproduk.php");
                exit();
            }
        }

        // Update warna
        if (!empty($_POST['warna'])) {
            $warna = $_POST['warna'];

            // Hapus data warna lama
            $query_delete_warna = "DELETE FROM warna WHERE produk_id = '$id'";
            if (!mysqli_query($conn, $query_delete_warna)) {
                file_put_contents('debug_log.txt', "Error deleting warna: " . mysqli_error($conn) . "\n", FILE_APPEND);
            }

            // Masukkan data warna baru
            foreach ($warna as $warna_elektronik) {
                $warnaElektronik = mysqli_real_escape_string($conn, $warna_elektronik);
                $query_warnaElektronik = "INSERT INTO warna (produk_id, warna) VALUES ('$id', '$warnaElektronik')";
                if (!mysqli_query($conn, $query_warnaElektronik)) {
                    file_put_contents('debug_log.txt', "Error inserting warna: " . mysqli_error($conn) . "\n", FILE_APPEND);
                } else {
                    file_put_contents('debug_log.txt', "Inserted warna: $query_warnaElektronik\n", FILE_APPEND);
                }
            }
        }


        // Insert data ke tabel tbl_elektronik
        $query_elektronik = "UPDATE elektronik SET 
                            nama = '$nama_produk',
                            brand = '$brand',
                            model = '$model',
                            screen_size = '$screen_size',
                            resolution = '$resolution',
                            battery_type = '$battery_type',
                            operating_system = '$operating_system',
                            spesial_fitur = '$special_features'
                            WHERE produk_id = '$id'";
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

        // Update ukuran
        if (!empty($_POST['size']) && !empty($_POST['harga']) && !empty($_POST['stok'])) {
            $ukuran_list = $_POST['size'];

            // Pastikan bahwa jumlah elemen ukuran, harga, dan stok sama
            if (count($harga_list) === count($stok_list) && count($stok_list) === count($ukuran_list)) {
                // Hapus data ukuran lama
                $query_delete_ukuran = "DELETE FROM ukuran WHERE produk_id = '$id'";
                if (!mysqli_query($conn,
                    $query_delete_ukuran
                )) {
                    file_put_contents('debug_log.txt', "Error deleting ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                }

                // Masukkan data ukuran baru
                foreach ($ukuran_list as $index => $ukuran_elektronik) {
                    $ukuranElektronik = mysqli_real_escape_string($conn, $ukuran_elektronik);
                    $harga = isset($harga_list[$index]) ? mysqli_real_escape_string($conn, $harga_list[$index]) : 0;
                    $stok = isset($stok_list[$index]) ? mysqli_real_escape_string($conn, $stok_list[$index]) : 0;

                    $query_variasi = "INSERT INTO ukuran (produk_id, ukuran, harga, stok) VALUES ('$id', '$ukuranElektronik', '$harga', '$stok')";
                    if (!mysqli_query($conn, $query_variasi)) {
                        file_put_contents('debug_log.txt', "Error inserting ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                    }
                }
            } else {
                $_SESSION['pesan'] = "Jumlah ukuran, harga, dan stok tidak sesuai!";
                header("Location: tambahproduk.php");
                exit();
            }
        }

        if (!empty($_POST['warna'])) {
            $warna = $_POST['warna'];

            $query_delete_warna_pakaian = "DELETE FROM warna WHERE produk_id = '$id'";
            if (!mysqli_query($conn, $query_delete_warna_pakaian)) {
                file_put_contents('debug_log.txt', "Error Delete into ukuran_delete_warna_pakaian: " . mysqli_error($conn) . "\n", FILE_APPEND);
            }

            foreach ($warna as $warna_pakaian) {
                $warnaPakaian = mysqli_real_escape_string($conn, $warna_pakaian);
                $query_warnaPakaian = "INSERT INTO warna (produk_id, warna) VALUES ('$id','$warnaPakaian')";
                if (!mysqli_query($conn, $query_warnaPakaian)) {
                    file_put_contents('debug_log.txt', "Error inserting into warna pakaian: " . mysqli_error($conn) . "\n", FILE_APPEND);
                } else {
                    file_put_contents('debug_log.txt', "Inserted into warna pakaian : $query_warnaPakaian\n", FILE_APPEND);
                }
            }
        }

        // Tambah Pakaian
        $query_pakaian_update = "UPDATE pakaian SET
                                nama = '$nama_pakaian',
                                type = '$bahan_pakaian',
                                instruksi_perawatan = '$perawatan_pakaian'
                                WHERE produk_id = '$id'";
        if (!mysqli_query($conn, $query_pakaian_update)) {
            $_SESSION['pesan'] = "Gagal menyimpan data pakaian: " . mysqli_error($conn);
        }
        break;









        // Perlengkapan Rumah Tangga
    case 3:
        $jenis_perlengkapan = mysqli_real_escape_string($conn, $_POST['jenis']);
        $merek_perlengkapan = mysqli_real_escape_string($conn, $_POST['merk']);
        $bahan_perlengkapan = mysqli_real_escape_string($conn, $_POST['bahanPerlengkapan']);


        // Update ukuran
        if (!empty($_POST['size']) && !empty($_POST['harga']) && !empty($_POST['stok'])) {
            $ukuran_list = $_POST['size'];

            // Pastikan bahwa jumlah elemen ukuran, harga, dan stok sama
            if (count($harga_list) === count($stok_list) && count($stok_list) === count($ukuran_list)) {
                // Hapus data ukuran lama
                $query_delete_ukuran = "DELETE FROM ukuran WHERE produk_id = '$id'";
                if (!mysqli_query(
                    $conn,
                    $query_delete_ukuran
                )) {
                    file_put_contents('debug_log.txt', "Error deleting ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                }

                // Masukkan data ukuran baru
                foreach ($ukuran_list as $index => $ukuran_elektronik) {
                    $ukuranElektronik = mysqli_real_escape_string($conn, $ukuran_elektronik);
                    $harga = isset($harga_list[$index]) ? mysqli_real_escape_string($conn, $harga_list[$index]) : 0;
                    $stok = isset($stok_list[$index]) ? mysqli_real_escape_string($conn, $stok_list[$index]) : 0;

                    $query_variasi = "INSERT INTO ukuran (produk_id, ukuran, harga, stok) VALUES ('$id', '$ukuranElektronik', '$harga', '$stok')";
                    if (!mysqli_query($conn, $query_variasi)) {
                        file_put_contents('debug_log.txt', "Error inserting ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                    }
                }
            } else {
                $_SESSION['pesan'] = "Jumlah ukuran, harga, dan stok tidak sesuai!";
                header("Location: tambahproduk.php");
                exit();
            }
        }


        if (!empty($_POST['warna'])) {
            $warna = $_POST['warna'];

            $query_delete_warna_perlengkapan = "DELETE FROM warna WHERE produk_id = '$id'";
            if (!mysqli_query($conn, $query_delete_warna_perlengkapan)) {
                file_put_contents('debug_log.txt', "Error Delete into ukuran_delete_pakaian " . mysqli_error($conn) . "\n", FILE_APPEND);
            }

            foreach ($warna as $warna_perlengkapan) {
                $warnaPerlengkapan = mysqli_real_escape_string($conn, $warna_perlengkapan);
                $query_warnaPerlengkapan = "INSERT INTO warna (produk_id, warna) VALUES ('$id','$warnaPerlengkapan')";
                if (!mysqli_query($conn, $query_warnaPerlengkapan)) {
                    file_put_contents('debug_log.txt', "Error inserting into ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                } else {
                    file_put_contents('debug_log.txt', "Inserted into : $query_warnaPerlengkapan\n", FILE_APPEND);
                }
            }
        }

        // Tambah Perlengkapan Rumah tangga
        $query_perlengkapan_update = "UPDATE perlengkapan_rumah_tangga SET
                                jenis = '$jenis_perlengkapan',
                                merk = '$merek_perlengkapan',
                                bahan = '$bahan_perlengkapan'
                                WHERE produk_id = '$id'";
        if (!mysqli_query($conn, $query_perlengkapan_update)) {
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

        $query_kesehatan_update = "UPDATE kesehatan_kecantikan SET
                            kategori = '$kategori_kesehatan',
                            merk = '$merk_kesehatan',
                            jenis = '$jenis_kesehatan',
                            bahan_aktif = '$vitamin_kesehatan',
                            volume = '$isi_kesehatan'
                            WHERE produk_id = '$id'";
        if (!mysqli_query($conn, $query_kesehatan_update)) {
            file_put_contents('debug_log.txt', "Error Update into kesehatan_kecantikan: " . mysqli_error($conn) . "\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "Update Set : $query_kesehatan_update\n", FILE_APPEND);
        }
        break;














        // Otomotif
    case 5:
        $kategori_otomotif = mysqli_real_escape_string($conn, $_POST['kategori_otomotif']);
        $merk_otomotif = mysqli_real_escape_string($conn, $_POST['merk']);
        $model_otomotif = mysqli_real_escape_string($conn, $_POST['model']);
        $jenis_kendaraan_otomotif = mysqli_real_escape_string($conn, $_POST['jenis']);

        $query_otomotif = "UPDATE otomotif SET
                           jenis = '$kategori_otomotif',
                           merk = '$merk_otomotif',
                           model = '$model_otomotif',
                           jenis_kendaraan = '$jenis_kendaraan_otomotif'
                           WHERE produk_id = '$id'";
        if (!mysqli_query($conn, $query_otomotif)) {
            file_put_contents('debug_log.txt', "Error Update otomotif: " . mysqli_error($conn) . "\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "Update Set : $query_otomotif\n", FILE_APPEND);
        }
        break;













        // Mainan dan Hobi
    case 6:
        $kategori_mainan = mysqli_real_escape_string($conn, $_POST['kategori_anak']);
        $merk_mainan = mysqli_real_escape_string($conn, $_POST['merk']);
        $jenis_mainan = mysqli_real_escape_string($conn, $_POST['jenis']);
        $bahan_mainan = mysqli_real_escape_string($conn, $_POST['bahan']);

        $query_mainan = "UPDATE mainan_hobi SET
                        kategori = '$kategori_mainan',
                        merk = '$merk_mainan',
                        jenis = '$jenis_mainan',
                        bahan = '$bahan_mainan'
                        WHERE produk_id = '$id'";
        if (!mysqli_query($conn, $query_mainan)) {
            file_put_contents('debug_log.txt', "Error Update mainan_hobi: " . mysqli_error($conn) . "\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "Update Set : $query_mainan\n", FILE_APPEND);
        }
        break;














        // Makanan dan minuman
    case 7:
        $kategori_makanan = mysqli_real_escape_string($conn, $_POST['kategori_makanan']);
        $merk_makanan = mysqli_real_escape_string($conn, $_POST['merk']);
        $jenis_makanan = mysqli_real_escape_string($conn, $_POST['jenis']);
        $berat_makanan = mysqli_real_escape_string($conn, $_POST['berat']);
        $tanggal_makanan = mysqli_real_escape_string($conn, $_POST['tanggalkadaluarsa']);

        $query_makanan = "UPDATE makanan_minuman SET
                          kategori = '$kategori_makanan',
                          merk = '$merk_makanan',
                          jenis = '$jenis_makanan',
                          berat_volume = '$berat_makanan',
                          tanggal_kadaluarsa = '$tanggal_makanan'
                          WHERE produk_id = '$id' ";
        if (!mysqli_query($conn, $query_makanan)) {
            file_put_contents('debug_log.txt', "Error Update Makanan: " . mysqli_error($conn) . "\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "Update Set : $query_makanan\n", FILE_APPEND);
        }
        break;
        // Tambahkan case untuk kategori lain jika diperlukan


















        // Perhiasan
    case 8:
        $kategori_perhiasan = mysqli_real_escape_string($conn, $_POST['kategori_perhiasan']);
        $merk_perhiasan = mysqli_real_escape_string($conn, $_POST['merk']);
        $bahan_perhiasan = mysqli_real_escape_string($conn, $_POST['bahan']);
        $jenisBatu_perhiasan = mysqli_real_escape_string($conn, $_POST['jenisbatu']);


        // Update ukuran
        if (!empty($_POST['size']) && !empty($_POST['harga']) && !empty($_POST['stok'])) {
            $ukuran_list = $_POST['size'];

            // Pastikan bahwa jumlah elemen ukuran, harga, dan stok sama
            if (count($harga_list) === count($stok_list) && count($stok_list) === count($ukuran_list)) {
                // Hapus data ukuran lama
                $query_delete_ukuran = "DELETE FROM ukuran WHERE produk_id = '$id'";
                if (!mysqli_query(
                    $conn,
                    $query_delete_ukuran
                )) {
                    file_put_contents('debug_log.txt', "Error deleting ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                }

                // Masukkan data ukuran baru
                foreach ($ukuran_list as $index => $ukuran_elektronik) {
                    $ukuranElektronik = mysqli_real_escape_string($conn, $ukuran_elektronik);
                    $harga = isset($harga_list[$index]) ? mysqli_real_escape_string($conn, $harga_list[$index]) : 0;
                    $stok = isset($stok_list[$index]) ? mysqli_real_escape_string($conn, $stok_list[$index]) : 0;

                    $query_variasi = "INSERT INTO ukuran (produk_id, ukuran, harga, stok) VALUES ('$id', '$ukuranElektronik', '$harga', '$stok')";
                    if (!mysqli_query($conn, $query_variasi)) {
                        file_put_contents('debug_log.txt', "Error inserting ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                    }
                }
            } else {
                $_SESSION['pesan'] = "Jumlah ukuran, harga, dan stok tidak sesuai!";
                header("Location: tambahproduk.php");
                exit();
            }
        }

        $query_perhiasan = "UPDATE perhiasan SET
                            kategori = '$kategori_perhiasan',
                            merk = '$merk_perhiasan',
                            bahan = '$bahan_perhiasan',
                            jenis_batu = '$jenisBatu_perhiasan'
                            WHERE produk_id = '$id'";
        if (!mysqli_query($conn, $query_perhiasan)) {
            file_put_contents('debug_log.txt', "Error Update Set Perhiasan: " . mysqli_error($conn) . "\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "Update Set : $query_perhiasan\n", FILE_APPEND);
        }
        break;



















        // Alat Musik
    case 9:
        $kategori_musik = mysqli_real_escape_string($conn, $_POST['kategori_alat']);
        $merk_musik = mysqli_real_escape_string($conn, $_POST['merk']);
        $model_musik = mysqli_real_escape_string($conn, $_POST['model']);
        $jenis_musik = mysqli_real_escape_string($conn, $_POST['jenis']);
        $query_musik = "UPDATE alat_musik SET
                        kategori = '$kategori_musik',
                        merk = '$merk_musik',
                        model = '$model_musik',
                        jenis = '$jenis_musik'
                        WHERE produk_id = '$id'";
        if (!mysqli_query($conn, $query_musik)) {
            file_put_contents('debug_log.txt', "Error Update Set Musik: " . mysqli_error($conn) . "\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "Update Set : $query_musik\n", FILE_APPEND);
        }
        break;

















        // Furniture
    case 10:
        $kategori_furniture = mysqli_real_escape_string($conn, $_POST['kategori_furniture']);
        $merk_furniture = mysqli_real_escape_string($conn, $_POST['merk']);
        $bahan_furniture = mysqli_real_escape_string($conn, $_POST['bahan']);

        // Update ukuran
        if (!empty($_POST['size']) && !empty($_POST['harga']) && !empty($_POST['stok'])) {
            $ukuran_list = $_POST['size'];

            // Pastikan bahwa jumlah elemen ukuran, harga, dan stok sama
            if (count($harga_list) === count($stok_list) && count($stok_list) === count($ukuran_list)) {
                // Hapus data ukuran lama
                $query_delete_ukuran = "DELETE FROM ukuran WHERE produk_id = '$id'";
                if (!mysqli_query(
                    $conn,
                    $query_delete_ukuran
                )) {
                    file_put_contents('debug_log.txt', "Error deleting ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                }

                // Masukkan data ukuran baru
                foreach ($ukuran_list as $index => $ukuran_elektronik) {
                    $ukuranElektronik = mysqli_real_escape_string($conn, $ukuran_elektronik);
                    $harga = isset($harga_list[$index]) ? mysqli_real_escape_string($conn, $harga_list[$index]) : 0;
                    $stok = isset($stok_list[$index]) ? mysqli_real_escape_string($conn, $stok_list[$index]) : 0;

                    $query_variasi = "INSERT INTO ukuran (produk_id, ukuran, harga, stok) VALUES ('$id', '$ukuranElektronik', '$harga', '$stok')";
                    if (!mysqli_query($conn, $query_variasi)) {
                        file_put_contents('debug_log.txt', "Error inserting ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                    }
                }
            } else {
                $_SESSION['pesan'] = "Jumlah ukuran, harga, dan stok tidak sesuai!";
                header("Location: tambahproduk.php");
                exit();
            }
        }



        if (!empty($_POST['warna'])) {
            $warna = $_POST['warna'];

            $query_delete_warna_furniture = "DELETE FROM warna WHERE produk_id = '$id'";
            if (!mysqli_query($conn, $query_delete_warna_furniture)) {
                file_put_contents('debug_log.txt', "Error Delete into warna_furniture: " . mysqli_error($conn) . "\n", FILE_APPEND);
            }

            foreach ($warna as $warna_Furniture) {
                $warnaFurniture = mysqli_real_escape_string($conn, $warna_Furniture);
                $query_warnaFurniture = "INSERT INTO warna (produk_id, warna) VALUES ('$id','$warnaFurniture')";
                if (!mysqli_query($conn, $query_warnaFurniture)) {
                    file_put_contents('debug_log.txt', "Error inserting into ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                } else {
                    file_put_contents('debug_log.txt', "Inserted into : $query_warnaFurniture\n", FILE_APPEND);
                }
            }
        }

        // Tambah Furniture
        $query_furniture = "UPDATE furniture SET
                            kategori = '$kategori_furniture',
                            merk = '$merk_furniture',
                            bahan = '$bahan_furniture'
                            WHERE produk_id = '$id'";
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

        $query_buku = "UPDATE buku_media SET
                       kategori = '$kategori_buku',
                       penulis = '$penulis_buku',
                       penerbit = '$penerbit_buku',
                       tahun_terbit = '$tanggal_terbit',
                       isbn = '$isbn_buku'
                       WHERE produk_id = '$id'";
        if (!mysqli_query($conn, $query_buku)) {
            file_put_contents('debug_log.txt', "Error Update Set buku_media: " . mysqli_error($conn) . "\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "Update Set : $query_buku\n", FILE_APPEND);
        }
        break;















    case 13:

        // Update ukuran
        if (!empty($_POST['size']) && !empty($_POST['harga']) && !empty($_POST['stok'])
        ) {
            $ukuran_list = $_POST['size'];

            // Pastikan bahwa jumlah elemen ukuran, harga, dan stok sama
            if (count($harga_list) === count($stok_list) && count($stok_list) === count($ukuran_list)
            ) {
                // Hapus data ukuran lama
                $query_delete_ukuran = "DELETE FROM ukuran WHERE produk_id = '$id'";
                if (!mysqli_query(
                    $conn,
                    $query_delete_ukuran
                )) {
                    file_put_contents('debug_log.txt', "Error deleting ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                }

                // Masukkan data ukuran baru
                foreach ($ukuran_list as $index => $ukuran_elektronik) {
                    $ukuranElektronik = mysqli_real_escape_string($conn, $ukuran_elektronik);
                    $harga = isset($harga_list[$index]) ? mysqli_real_escape_string($conn, $harga_list[$index]) : 0;
                    $stok = isset($stok_list[$index]) ? mysqli_real_escape_string($conn, $stok_list[$index]) : 0;

                    $query_variasi = "INSERT INTO ukuran (produk_id, ukuran, harga, stok) VALUES ('$id', '$ukuranElektronik', '$harga', '$stok')";
                    if (!mysqli_query($conn, $query_variasi)) {
                        file_put_contents('debug_log.txt', "Error inserting ukuran: " . mysqli_error($conn) . "\n", FILE_APPEND);
                    }
                }
            } else {
                $_SESSION['pesan'] = "Jumlah ukuran, harga, dan stok tidak sesuai!";
                header("Location: tambahproduk.php");
                exit();
            }
        }


        if (!empty($_POST['warna'])) {
            $warna = $_POST['warna'];

            $query_delete_warna_lain = "DELETE FROM warna WHERE produk_id = '$id'";
            if (!mysqli_query($conn, $query_delete_warna_lain)) {
                file_put_contents('debug_log.txt', "Error Delete into ukuran_delete_lain " . mysqli_error($conn) . "\n", FILE_APPEND);
            }


            foreach ($warna as $warna_lain) {
                $warnaLain = mysqli_real_escape_string($conn, $warna_lain);
                $query_warnaLain = "INSERT INTO warna (produk_id, warna) VALUES ('$id','$warnaLain')";
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