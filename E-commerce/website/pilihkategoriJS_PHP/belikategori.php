<?php
// Elektronik
if ($kategori_name === 'Elektronik') {
    // Query untuk mendapatkan spesifikasi elektronik
    $view_spek_query = "
    SELECT e.*, u.ukuran, u.harga, u.stok, w.warna
    FROM elektronik e
    LEFT JOIN ukuran u ON e.produk_id = u.produk_id
    LEFT JOIN warna w ON e.produk_id = w.produk_id
    WHERE e.produk_id = " . $result['id'];;
    $view_spek = mysqli_query($conn, $view_spek_query);

    if (!$view_spek) {
        die("Query gagal: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($view_spek) > 0) {
        $row = mysqli_fetch_assoc($view_spek);
?>
        <!-- HTML untuk detail produk -->
        <p>Nama: <?php echo htmlspecialchars($row['nama']); ?></p>
        <p>Brand: <?php echo htmlspecialchars($row['brand']); ?></p>
        <p>Model: <?php echo htmlspecialchars($row['model']); ?></p>
        <p>Screen Size: <?php echo htmlspecialchars($row['screen_size']); ?></p>
        <p>Resolusi: <?php echo htmlspecialchars($row['resolution']); ?></p>
        <p>Tipe Baterai: <?php echo htmlspecialchars($row['battery_type']); ?></p>
        <p>Sistem Operasi: <?php echo htmlspecialchars($row['operating_system']); ?></p>
        <p>Spesial Fitur: <?php echo htmlspecialchars($row['spesial_fitur']); ?></p>
        <p>Spesifikasi</p>

        <?php
        // Query untuk mendapatkan ukuran
        $view_ukuran_query = "
        SELECT DISTINCT u.ukuran, u.harga, u.stok 
        FROM ukuran u 
        WHERE u.produk_id = " . $result['id'];
        $view_ukuran = mysqli_query($conn, $view_ukuran_query);

        if (!$view_ukuran) {
            die("Query gagal: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($view_ukuran) > 0) {
            echo '<div id="ukuran-options">';
            while ($ukuran_row = mysqli_fetch_assoc($view_ukuran)) {
                $unique_id = "ukuran-" . htmlspecialchars($ukuran_row['ukuran']);
                $harga = htmlspecialchars($ukuran_row['harga']);
                $stok = htmlspecialchars($ukuran_row['stok']);
        ?>
                <input type="radio" class="btn-check" name="ukuran" id="<?php echo $unique_id; ?>"
                    value="<?php echo htmlspecialchars($ukuran_row['ukuran']); ?>"
                    data-harga="<?php echo $harga; ?>"
                    data-stok="<?php echo $stok; ?>"
                    autocomplete="off" required>
                <label class="btn btn-outline-success me-2" for="<?php echo $unique_id; ?>"><?php echo htmlspecialchars($ukuran_row['ukuran']); ?></label>
        <?php
            }
            echo '</div>';
        }
        ?>

        <br><br>
        <input type="hidden" id="harga_ukuran" name="harga_ukuran" value="">
        <input type="hidden" id="stok_ukuran" name="stok" value="">
        <!-- Placeholder untuk harga dan stok -->
        <div id="harga-stok-info">
            <p>Stok: <span id="stok-info">Pilih ukuran terlebih dahulu</span></p>
            <h4>Harga: <span class="text-danger" id="harga-info">Pilih ukuran terlebih dahulu</span></h4>
        </div>
        <?php
        $view_warna_elektronik = mysqli_query($conn, "SELECT DISTINCT warna FROM warna WHERE produk_id =" . $result['id']);
        if ($view_warna_elektronik && mysqli_num_rows($view_warna_elektronik)) {
        ?>
            <p>Warna:</p>
            <?php
            while ($row_warna_elektronik = mysqli_fetch_assoc($view_warna_elektronik)) {
                $unique_id = "warna-" . $row_warna_elektronik['warna'];
            ?>
                <input type="radio" class="btn-check" name="warna" id="<?php echo htmlspecialchars($unique_id); ?>" value="<?php echo htmlspecialchars($row_warna_elektronik['warna']); ?>" autocomplete="off" required>
                <label class="btn btn-outline-success me-2" for="<?php echo htmlspecialchars($unique_id); ?>"><?php echo htmlspecialchars($row_warna_elektronik['warna']); ?></label>
        <?php
            }
        }
        ?>
        <br>
        <br>
    <?php
        // Query untuk mendapatkan warna (jika diperlukan)
        // ...
    } else {
        echo "<p>Spesifikasi elektronik tidak ditemukan.</p>";
    }



    // Pakaian
} elseif ($kategori_name === 'Pakaian') {
    // Query untuk mendapatkan spesifikasi elektronik
    $view_spek_pakaian = mysqli_query($conn, "SELECT pk.*, p.stok , p.harga
                                              FROM pakaian pk
                                              LEFT JOIN tbl_produk p ON pk.produk_id = p.id
                                              WHERE pk.produk_id = " . $result['id']);

    if (!$view_spek_pakaian) {
        die("Query gagal: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($view_spek_pakaian) > 0) {
        $row_pakaian = mysqli_fetch_assoc($view_spek_pakaian);
    ?>
        <!-- HTML untuk detail produk -->
        <p>Nama: <?php echo htmlspecialchars($row_pakaian['nama']); ?></p>
        <p>Tipe: <?php echo htmlspecialchars($row_pakaian['type']); ?></p>
        <p>Instruksi Perawatan: <?php echo htmlspecialchars($row_pakaian['instruksi_perawatan']); ?></p>
        <p>Ukuran</p>

        <?php
        // Query untuk mendapatkan ukuran
        $view_ukuran_pakaian = mysqli_query($conn, "SELECT * FROM ukuran WHERE produk_id = " . $result['id']);

        if (!$view_ukuran_pakaian) {
            die("Query gagal: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($view_ukuran_pakaian) > 0) {
            echo '<div id="ukuran-options">';
            while ($ukuran_row_pakaian = mysqli_fetch_assoc($view_ukuran_pakaian)) {
                $unique_id = "ukuran-" . htmlspecialchars($ukuran_row_pakaian['ukuran']);
                $harga = htmlspecialchars($ukuran_row_pakaian['harga']);
                $stok = htmlspecialchars($ukuran_row_pakaian['stok']);
        ?>
                <input type="radio" class="btn-check" name="ukuran" id="<?php echo $unique_id; ?>"
                    value="<?php echo htmlspecialchars($ukuran_row_pakaian['ukuran']); ?>"
                    data-harga="<?php echo $harga; ?>"
                    data-stok="<?php echo $stok; ?>"
                    autocomplete="off" required>
                <label class="btn btn-outline-success me-2" for="<?php echo $unique_id; ?>"><?php echo htmlspecialchars($ukuran_row_pakaian['ukuran']); ?></label>
        <?php
            }
            echo '</div>';
        }
        ?>

        <br><br>

        <!-- Placeholder untuk harga dan stok -->
        <div id="harga-stok-info">
            <p>Stok: <span id="stok-info">Pilih ukuran terlebih dahulu</span></p>
            <h4>Harga: <span class="text-danger" id="harga-info">Pilih ukuran terlebih dahulu</span></h4>
        </div>
        <?php
        $view_warna_pakaian = mysqli_query($conn, "SELECT warna FROM warna WHERE produk_id =" . $result['id']);
        if ($view_warna_pakaian && mysqli_num_rows($view_warna_pakaian)) {
        ?>
            <p>Warna:</p>
            <?php
            while ($row_warna_pakaian = mysqli_fetch_assoc($view_warna_pakaian)) {
                $unique_id = "warna-" . $row_warna_pakaian['warna'];
            ?>
                <input type="radio" class="btn-check" name="warna" id="<?php echo htmlspecialchars($unique_id); ?>" value="<?php echo htmlspecialchars($row_warna_pakaian['warna']); ?>" autocomplete="off" required>
                <label class="btn btn-outline-success me-2" for="<?php echo htmlspecialchars($unique_id); ?>"><?php echo htmlspecialchars($row_warna_pakaian['warna']); ?></label>
        <?php
            }
        }
        ?>
        <br>
        <br>
    <?php
        // Query untuk mendapatkan warna (jika diperlukan)
        // ...
    } else {
        echo "<p>Spesifikasi Pakaian tidak ditemukan.</p>";
    }



    // Perlengkapan Rumah Tangga
} elseif ($kategori_name === 'Perlengkapan Rumah Tangga') {
    $view_perlengkapan = mysqli_query($conn, "SELECT prt.* , u.ukuran, w.warna
                                            FROM perlengkapan_rumah_tangga prt
                                            LEFT JOIN ukuran u ON prt.produk_id = u.produk_id 
                                            LEFT JOIN warna w ON prt.produk_id = w.produk_id
                                            WHERE prt.produk_id =" . $result['id']);

    if ($view_perlengkapan && mysqli_num_rows($view_perlengkapan) > 0) {
        $row_perlengkapan = mysqli_fetch_array($view_perlengkapan);
    ?>
        <p>Jenis: <?php echo $row_perlengkapan['jenis']; ?></p>
        <p>Merk: <?php echo $row_perlengkapan['merk']; ?></p>
        <p>Bahan: <?php echo $row_perlengkapan['bahan']; ?></p>
        <p>Ukuran:</p>

        <?php

        // Query untuk mendapatkan ukuran
        $view_ukuran_perlengkapanRumahTangga = mysqli_query($conn, "SELECT * FROM ukuran WHERE produk_id = " . $result['id']);

        if (!$view_ukuran_perlengkapanRumahTangga) {
            die("Query gagal: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($view_ukuran_perlengkapanRumahTangga) > 0) {
            echo '<div id="ukuran-options">';
            while ($ukuran_row_perlengkapanRumahTangga = mysqli_fetch_assoc($view_ukuran_perlengkapanRumahTangga)) {
                $unique_id = "ukuran-" . htmlspecialchars($ukuran_row_perlengkapanRumahTangga['ukuran']);
                $harga = htmlspecialchars($ukuran_row_perlengkapanRumahTangga['harga']);
                $stok = htmlspecialchars($ukuran_row_perlengkapanRumahTangga['stok']);
        ?>
                <input type="radio" class="btn-check" name="ukuran" id="<?php echo $unique_id; ?>"
                    value="<?php echo htmlspecialchars($ukuran_row_perlengkapanRumahTangga['ukuran']); ?>"
                    data-harga="<?php echo $harga; ?>"
                    data-stok="<?php echo $stok; ?>"
                    autocomplete="off" required>
                <label class="btn btn-outline-success me-2" for="<?php echo $unique_id; ?>"><?php echo htmlspecialchars($ukuran_row_perlengkapanRumahTangga['ukuran']); ?></label>
        <?php
            }
            echo '</div>';
        }
        ?>
        <br>
        <!-- Placeholder untuk harga dan stok -->

        <?php
        $view_warna_perlengkapanRumahTangga = mysqli_query($conn, "SELECT warna FROM warna WHERE produk_id =" . $result['id']);
        if ($view_warna_perlengkapanRumahTangga && mysqli_num_rows($view_warna_perlengkapanRumahTangga)) {
        ?>
            <p>Warna:</p>
            <?php
            while ($row_warna_perlengkapanRumahTangga = mysqli_fetch_assoc($view_warna_perlengkapanRumahTangga)) {
                $unique_id = "warna-" . $row_warna_perlengkapanRumahTangga['warna'];
            ?>
                <input type="radio" class="btn-check" name="warna" id="<?php echo htmlspecialchars($unique_id); ?>" value="<?php echo htmlspecialchars($row_warna_perlengkapanRumahTangga['warna']); ?>" autocomplete="off" required>
                <label class="btn btn-outline-success me-2" for="<?php echo htmlspecialchars($unique_id); ?>"><?php echo htmlspecialchars($row_warna_perlengkapanRumahTangga['warna']); ?></label>
        <?php
            }
        }
        ?>
        <br>
        <br>
        <div id="harga-stok-info">
            <p>Stok: <span id="stok-info">Pilih ukuran terlebih dahulu</span></p>
            <h4>Harga: <span class="text-danger" id="harga-info">Pilih ukuran terlebih dahulu</span></h4>
        </div>
    <?php
    } else {
        echo "<p>Spesifikasi Perlengkapan Rumah Tangga tidak ada";
    }





    // Kesehatan dan Kecantikan
} elseif ($kategori_name === 'Kesehatan dan Kecantikan') {
    $view_kesehatan = mysqli_query($conn, "SELECT kdk.*, p.stok , p.harga
                                            FROM kesehatan_kecantikan kdk
                                            LEFT JOIN tbl_produk p ON kdk.produk_id = p.id
                                            WHERE kdk.produk_id =" . $result['id']);

    if ($view_kesehatan && mysqli_num_rows($view_kesehatan) > 0) {
        $row_kesehatan = mysqli_fetch_array($view_kesehatan);
    ?>
        <p>Kategori: <?php echo $row_kesehatan['kategori']; ?></p>
        <p>Merk: <?php echo $row_kesehatan['merk']; ?></p>
        <p>Jenis: <?php echo $row_kesehatan['jenis']; ?></p>
        <p>Jenis Vitamin: <?php echo $row_kesehatan['bahan_aktif']; ?></p>
        <p>Isi: <?php echo $row_kesehatan['volume']; ?></p>
        <p>Stok Barang: <?php echo $row_kesehatan['stok']; ?></p>
        <h4>Harga: <span class="text-danger">Rp.<?php echo number_format($row_kesehatan['harga'], 0, ',', '.'); ?></span></h4>
    <?php
    } else {
        echo "<p>Spesifikasi Kesehatan Dan Kecantikan tidak ada";
    }




    // Otomotif
} elseif ($kategori_name === 'Otomotif') {
    $view_otomotif = mysqli_query($conn, "SELECT o.*, p.harga, p.stok
                                          FROM otomotif o 
                                          LEFT JOIN tbl_produk p ON o.produk_id = p.id
                                          WHERE o.produk_id =" . $result['id']);

    if ($view_otomotif && mysqli_num_rows($view_otomotif) > 0) {
        $row_otomotif = mysqli_fetch_array($view_otomotif);
    ?>
        <p>Kategori: <?php echo $row_otomotif['jenis']; ?></p>
        <p>Merk: <?php echo $row_otomotif['merk']; ?></p>
        <p>Model: <?php echo $row_otomotif['model']; ?></p>
        <p>Jenis Kendaraan: <?php echo $row_otomotif['jenis_kendaraan']; ?></p>
        <p>Stok Barang: <?php echo $row_otomotif['stok']; ?></p>
        <h4>Harga: <span class="text-danger">Rp.<?php echo number_format($row_otomotif['harga'], 0, ',', '.'); ?></span></h4>
    <?php
    } else {
        echo "<p>Spesifikasi Otomotif tidak ada";
    }

    // alat_musik



    // Mainan dan Hobi
} elseif ($kategori_name === 'Mainan dan Hobi') {
    $view_mainan = mysqli_query($conn, "SELECT mh.*, p.harga, p.stok
                                        FROM  mainan_hobi mh 
                                        LEFT JOIN tbl_produk p ON mh.produk_id = p.id
                                        WHERE mh.produk_id =" . $result['id']);

    if ($view_mainan && mysqli_num_rows($view_mainan) > 0) {
        $row_mainan = mysqli_fetch_array($view_mainan);
    ?>
        <p>Kategori: <?php echo $row_mainan['kategori']; ?></p>
        <p>Merk: <?php echo $row_mainan['merk']; ?></p>
        <p>Jenis Mainan: <?php echo $row_mainan['jenis']; ?></p>
        <p>Bahan: <?php echo $row_mainan['bahan']; ?></p>
        <p>Stok Barang: <?php echo $row_mainan['stok']; ?></p>
        <input type="hidden" name="harga_satuan" value="<?php echo $row_mainan['harga']; ?>">
        <h4>Harga: <span class="text-danger">Rp.<?php echo number_format($row_mainan['harga'], 0, ',', '.'); ?></span></h4>
    <?php
    } else {
        echo "<p>Spesifikasi Mainan dan Hobi tidak ada";
    }





    // Makanan dan Minuman
} elseif ($kategori_name === 'Makanan dan Minuman') {
    $view_makanan = mysqli_query($conn, "SELECT m.*, p.stok , p.harga
                                 FROM makanan_minuman m
                                 LEFT JOIN tbl_produk p ON m.produk_id = p.id
                                 WHERE m.produk_id = " . $result['id']);

    if ($view_makanan && mysqli_num_rows($view_makanan) > 0) {
        $row_makanan = mysqli_fetch_array($view_makanan);
    ?>
        <p>Kategori: <?php echo $row_makanan['kategori']; ?></p>
        <p>Merk: <?php echo $row_makanan['merk']; ?></p>
        <p>Jenis: <?php echo $row_makanan['jenis']; ?></p>
        <p>Berat: <?php echo $row_makanan['berat_volume']; ?></p>
        <p>Tanggal Kadaluarsa: <?php echo $row_makanan['tanggal_kadaluarsa']; ?></p>
        <p>Stok: <?php echo $row_makanan['stok']; ?></p>
        <p>Harga: <?php echo $row_makanan['harga']; ?></p>
    <?php
    } else {
        echo "<p>Spesifikasi Makanan dan Minuman tidak ada";
    }





    // Perhiasan
} elseif ($kategori_name === 'Perhiasan') {
    $view_perhiasan = mysqli_query($conn, "SELECT prs.*, p.stok , p.harga
                                              FROM perhiasan prs
                                              LEFT JOIN tbl_produk p ON prs.produk_id = p.id
                                              WHERE prs.produk_id = " . $result['id']);
    if ($view_perhiasan && mysqli_num_rows($view_perhiasan) > 0) {
        $row_perhiasan = mysqli_fetch_array($view_perhiasan);
    ?>

        <p>Kategori: <?php echo $row_perhiasan['kategori']; ?></p>
        <p>Merk: <?php echo $row_perhiasan['merk']; ?></p>
        <p>Bahan: <?php echo $row_perhiasan['bahan']; ?></p>
        <p>Jenis Batu:<?php echo $row_perhiasan['jenis_batu']; ?></p>

        <?php

        // Query untuk mendapatkan ukuran
        $view_ukuran_perhiasan = mysqli_query($conn, "SELECT * FROM ukuran WHERE produk_id = " . $result['id']);

        if (!$view_ukuran_perhiasan) {
            die("Query gagal: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($view_ukuran_perhiasan) > 0) {
            echo '<div id="ukuran-options">';
            while ($ukuran_row_perhiasan = mysqli_fetch_assoc($view_ukuran_perhiasan)) {
                $unique_id = "ukuran-" . htmlspecialchars($ukuran_row_perhiasan['ukuran']);
                $harga = htmlspecialchars($ukuran_row_perhiasan['harga']);
                $stok = htmlspecialchars($ukuran_row_perhiasan['stok']);
        ?>
                <input type="radio" class="btn-check" name="ukuran" id="<?php echo $unique_id; ?>"
                    value="<?php echo htmlspecialchars($ukuran_row_perhiasan['ukuran']); ?>"
                    data-harga="<?php echo $harga; ?>"
                    data-stok="<?php echo $stok; ?>"
                    autocomplete="off" required>
                <label class="btn btn-outline-success me-2" for="<?php echo $unique_id; ?>"><?php echo htmlspecialchars($ukuran_row_perhiasan['ukuran']); ?></label>

        <?php
            }
            echo '</div>';
        }
        ?>
        <br>

        <!-- Placeholder untuk harga dan stok -->
        <div id="harga-stok-info">
            <p>Stok: <span id="stok-info">Pilih ukuran terlebih dahulu</span></p>
            <h4>Harga: <span class="text-danger" id="harga-info">Pilih ukuran terlebih dahulu</span></h4>
        </div>
    <?php
    } else {
        echo "<p>Spesifikasi Perhiasan tidak ada";
    }
} elseif ($kategori_name === 'Alat Musik') {
    $view_alat = mysqli_query($conn, "SELECT amk.*, p.harga, p.stok
                                      FROM alat_musik amk
                                      LEFT JOIN tbl_produk p ON amk.produk_id = p.id
                                      WHERE amk.produk_id =" . $result['id']);

    if ($view_alat && mysqli_num_rows($view_alat) > 0) {
        $row_alat = mysqli_fetch_array($view_alat);
    ?>
        <p>Kategori: <?php echo $row_alat['kategori']; ?></p>
        <p>Merk: <?php echo $row_alat['merk']; ?></p>
        <p>Model: <?php echo $row_alat['model']; ?> </p>
        <p>Jenis: <?php echo $row_alat['jenis']; ?></p>
        <p>Stok: <?php echo $row_alat['stok']; ?></p>
        <h4>Harga: <span class="text-danger">Rp.<?php echo number_format($row_alat['harga'], 0, ',', '.'); ?></span></h4>
    <?php
    } else {
        echo "<p>Spesifikasi Alat Musik tidak ada";
    }









    // furniture

} elseif ($kategori_name === 'Furniture') {
    $view_furniture = mysqli_query($conn, "SELECT f.*, p.harga, p.stok
                                           FROM furniture f
                                           LEFT JOIN tbl_produk p ON f.produk_id = p.id
                                           WHERE f.produk_id = " . $result['id']);
    if ($view_furniture && mysqli_num_rows($view_furniture)) {
        $row_furniture = mysqli_fetch_array($view_furniture);
    ?>

        <p>Kategori: <?php echo $row_furniture['kategori']; ?></p>
        <p>Merk: <?php echo $row_furniture['merk']; ?></p>
        <p>Bahan: <?php echo $row_furniture['bahan']; ?></p>

        <?php

        // Query untuk mendapatkan ukuran
        $view_ukuran_furniture = mysqli_query($conn, "SELECT * FROM ukuran WHERE produk_id = " . $result['id']);

        if (!$view_ukuran_furniture) {
            die("Query gagal: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($view_ukuran_furniture) > 0) {
            echo '<div id="ukuran-options">';
            while ($ukuran_row_furniture = mysqli_fetch_assoc($view_ukuran_furniture)) {
                $unique_id = "ukuran-" . htmlspecialchars($ukuran_row_furniture['ukuran']);
                $harga = htmlspecialchars($ukuran_row_furniture['harga']);
                $stok = htmlspecialchars($ukuran_row_furniture['stok']);
        ?>
                <input type="radio" class="btn-check" name="ukuran" id="<?php echo $unique_id; ?>"
                    value="<?php echo htmlspecialchars($ukuran_row_furniture['ukuran']); ?>"
                    data-harga="<?php echo $harga; ?>"
                    data-stok="<?php echo $stok; ?>"
                    autocomplete="off" required>
                <label class="btn btn-outline-success me-2" for="<?php echo $unique_id; ?>"><?php echo htmlspecialchars($ukuran_row_furniture['ukuran']); ?></label>
        <?php
            }
            echo '</div>';
        }
        ?>
        <br>

        <!-- Warna -->
        <?php
        $view_warna_funiture = mysqli_query($conn, "SELECT warna FROM warna WHERE produk_id =" . $result['id']);
        if ($view_warna_funiture && mysqli_num_rows($view_warna_funiture)) {
        ?>
            <p>Warna:</p>
            <?php
            while ($row_warna_furniture = mysqli_fetch_assoc($view_warna_funiture)) {
                $unique_id = "warna-" . $row_warna_furniture['warna'];
            ?>
                <input type="radio" class="btn-check" name="warna" id="<?php echo htmlspecialchars($unique_id); ?>" value="<?php echo htmlspecialchars($row_warna_furniture['warna']); ?>" autocomplete="off" required>
                <label class="btn btn-outline-success me-2" for="<?php echo htmlspecialchars($unique_id); ?>"><?php echo htmlspecialchars($row_warna_furniture['warna']); ?></label>
        <?php
            }
        }
        ?>
        <br>
        <br>
        <div id="harga-stok-info">
            <p>Stok: <span id="stok-info">Pilih ukuran terlebih dahulu</span></p>
            <h4>Harga: <span class="text-danger" id="harga-info">Pilih ukuran terlebih dahulu</span></h4>
        </div>
        <br>
        <br>
    <?php
    } else {
        echo "<p>Spesifikasi Furniture tidak ada";
    }









    // Buku_media
} elseif ($kategori_name === 'Buku dan Media') {
    $view_buku = mysqli_query($conn, "SELECT bm.*, p.harga, p.stok
                                      FROM buku_media bm
                                      LEFT JOIN tbl_produk p ON bm.produk_id = p.id
                                      WHERE bm.produk_id = " . $result['id']);

    if ($view_buku && mysqli_num_rows($view_buku) > 0) {
        $row_buku = mysqli_fetch_array($view_buku);
    ?>

        <p>Kategori: <?php echo $row_buku['kategori']; ?></p>
        <p>Penulis: <?php echo $row_buku['penulis']; ?></p>
        <p>Penerbit: <?php echo $row_buku['penerbit']; ?></p>
        <p>Tahun Terbit: <?php echo $row_buku['tahun_terbit']; ?></p>
        <p>ISBN: <?php echo $row_buku['isbn']; ?></p>
        <p>Stok: <?php echo $row_buku['stok']; ?> </p>
        <h4>Harga: <span class="text-danger">Rp.<?php echo number_format($row_buku['harga'], 0, ',', '.'); ?></span></h4>

        <?php
    } else {
        echo "<p>Spesifikasi Buku dan Media tidak ada";
    }





    // Lain-Lain
} elseif ($kategori_name === 'Lain-Lain') {
    $view_lain = mysqli_query($conn, "SELECT ukuran FROM ukuran WHERE produk_id =" . $result['id']);
    if (!$view_ukuran_furniture) {
        die("Query gagal: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($view_ukuran_furniture) > 0) {
        echo '<div id="ukuran-options">';
        while ($ukuran_row_furniture = mysqli_fetch_assoc($view_ukuran_furniture)) {
            $unique_id = "ukuran-" . htmlspecialchars($ukuran_row_furniture['ukuran']);
            $harga = htmlspecialchars($ukuran_row_furniture['harga']);
            $stok = htmlspecialchars($ukuran_row_furniture['stok']);
        ?>
            <input type="radio" class="btn-check" name="ukuran" id="<?php echo $unique_id; ?>"
                value="<?php echo htmlspecialchars($ukuran_row_furniture['ukuran']); ?>"
                data-harga="<?php echo $harga; ?>"
                data-stok="<?php echo $stok; ?>"
                autocomplete="off" required>
            <label class="btn btn-outline-success me-2" for="<?php echo $unique_id; ?>"><?php echo htmlspecialchars($ukuran_row_furniture['ukuran']); ?></label>
    <?php
        }
        echo '</div>';
    }
    ?>
    <br>

    <!-- Warna -->
    <?php
    $view_warna_funiture = mysqli_query($conn, "SELECT warna FROM warna WHERE produk_id =" . $result['id']);
    if ($view_warna_funiture && mysqli_num_rows($view_warna_funiture)) {
    ?>
        <p>Warna:</p>
        <?php
        while ($row_warna_furniture = mysqli_fetch_assoc($view_warna_funiture)) {
            $unique_id = "warna-" . $row_warna_furniture['warna'];
        ?>
            <input type="radio" class="btn-check" name="warna" id="<?php echo htmlspecialchars($unique_id); ?>" value="<?php echo htmlspecialchars($row_warna_furniture['warna']); ?>" autocomplete="off" required>
            <label class="btn btn-outline-success me-2" for="<?php echo htmlspecialchars($unique_id); ?>"><?php echo htmlspecialchars($row_warna_furniture['warna']); ?></label>
    <?php
        }
    }
    ?>
    <br>
    <br>
    <div id="harga-stok-info">
        <p>Stok: <span id="stok-info">Pilih ukuran terlebih dahulu</span></p>
        <h4>Harga: <span class="text-danger" id="harga-info">Pilih ukuran terlebih dahulu</span></h4>
    </div>
    <br>
    <br>
<?php



}
?>