document.addEventListener("DOMContentLoaded", function () {
  const kategoriSelect = document.getElementById("kategori");
  const formAtribut = document.getElementById("additionalFields");

  kategoriSelect.addEventListener("change", function () {
    const kategori = this.value;
    let formHTML = "";

    switch (kategori) {
      case "1": // Elektronik
        formHTML = `
                    <div class="form-group">
                        <label for="brand">Brand</label>
                        <input type="text" class="form-control" name="brand" id="brand" placeholder="Masukkan Brand">
                    </div>
                    <div class="form-group mt-3">
                        <label for="model">Model</label>
                        <input type="text" class="form-control" name="model" id="model" placeholder="Masukkan Model">
                    </div>
                    <div class="form-group mt-3">
                        <label for="screen_size">Ukuran Layar</label>
                        <input type="text" class="form-control" name="screen_size" id="screen_size" placeholder="Masukkan Ukuran Layar">
                    </div>
                    <div class="form-group mt-3">
                        <label for="resolution">Resolusi</label>
                        <input type="text" class="form-control" name="resolution" id="resolution" placeholder="Masukkan Resolusi">
                    </div>
                    <div id="variations" class="form-group mt-3">
                        <label for="tambah-ukuran" class="form-label d-flex justify-content-center">Tambah Penyimpanan</label>
                        <div id="variationContainer">
                            <div class="variation-group" data-index="${variationIndex}">
                                <div class="input-group mb-3">
                                    <input type="text" id="placeukuran" name="size[]"  maxlength="20" placeholder="Penyimpanan (Batas 20 karakter)" oninput="getValue()" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                                    <button type="button" class="btn btn-danger" onclick="removeVariation(${variationIndex})">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" onclick="addVariation()">Tambah Penyimpanan</button>
                        <label for="tambah-harga" class="form-label d-flex justify-content-center pt-3">Tambah Harga Variasi</label>
                        <div id="priceContainer">
                            <div class="price-group" data-index="${variationIndex}">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="hasil"></span>
                                    <input type="text" name="harga[]" placeholder="Harga" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                                    <input type="number" name="stok[]" placeholder="Stok" class="form-control" style="display: inline-block;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="battery_type">Tipe Baterai</label>
                        <input type="text" class="form-control" name="battery_type" id="battery_type" placeholder="Masukkan Tipe Baterai">
                    </div>
                    <div id="pilihwarna" class="form-group mt-3">
                        <label for="tambah-warna" class="form-label d-flex justify-content-center">Tambah Warna</label>
                            <div class="input-warna">
                                <label for="Warna">Warna</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="warna[]" placeholder="Warna" class="form-control">
                                    <button type="button" class="btn btn-danger pr-3" onclick="removeWarna(this)">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <div id="warna" class="form-group mt-3"></div>
                        <button type="button" class="btn btn-success" onclick="addWarna()">Tambahkan Pilihan</button>
                    </div>
                    <div class="form-group mt-3">
                        <label for="operating_system">Sistem Operasi</label>
                        <input type="text" class="form-control" name="operating_system" id="operating_system" placeholder="Masukkan Sistem Operasi">
                    </div>
                    <div class="form-group mt-3">
                        <label for="special_features">Fitur Khusus</label>
                        <textarea class="form-control" name="special_features" id="special_features" rows="3" placeholder="Masukkan Fitur Khusus"></textarea>
                    </div>
                `;
        break;

      case "2": // Pakaian
        formHTML = `
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="Nama" placeholder="Nama">
                    </div>
                    <div id="variasi" class="form-group mt-3">
                        <label for="tambah-ukuran" class="form-label d-flex justify-content-center">Tambah Ukuran</label>
                        <div id="variasiContainer">
                            <div class="variation-group" data-index="${variasiIndex}">
                                <div class="input-group mb-3">
                                    <input type="text" id="placeukuran" name="size[]"  maxlength="20" placeholder="Ukuran (Batas 20 karakter)" oninput="getHasil()" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                                    <button type="button" class="btn btn-danger" onclick="removeVariasi(${variasiIndex})">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" onclick="tambahHarga()">Tambah Ukuran</button>
                        <label for="tambah-harga" class="form-label d-flex justify-content-center pt-3">Tambah Harga Variasi</label>
                        <div id="hargaContainer">
                            <div class="price-group" data-index="${variasiIndex}">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="hasilnya"></span>
                                    <input type="text" name="harga[]" placeholder="Harga" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                                    <input type="number" name="stok[]" placeholder="Stok" class="form-control" style="display: inline-block;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="bahan">Bahan</label>
                        <input type="text" class="form-control" name="bahan" id="bahan" placeholder="Masukkan Bahan">
                    </div>

                    <div id="pilihwarna" class="form-group mt-3">
                        <label for="tambah-warna" class="form-label d-flex justify-content-center">Tambah Warna</label>
                            <div class="input-warna">
                                <label for="Warna">Warna</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="warna[]" placeholder="Warna" class="form-control">
                                    <button type="button" class="btn btn-danger pr-3" onclick="removeWarna(this)">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <div id="warna" class="form-group mt-3"></div>
                        <button type="button" class="btn btn-success" onclick="addWarna()">Tambahkan Pilihan</button>
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="perawatan">Instruksi Perawatan</label>
                        <input type="text" class="form-control" name="perawatan" id="Perawatan" placeholder="Masukkan Perawatan">
                    </div>
                `;
        break;

      case "3": // Perlengkapan Rumah Tangga
        formHTML = `
                    <div class="form-group">
                        <label for="nama">Jenis</label>
                        <input type="text" class="form-control" name="jenis" id="jenis" placeholder="Misal Kebersihan/Dapur">
                    </div>
                    <div class="form-group">
                        <label for="nama">Merk</label>
                        <input type="text" class="form-control" name="merk" id="Merek" placeholder="Misal Cosmos/Philip">
                    </div>
                    <div id="variasi" class="form-group mt-3">
                        <label for="tambah-ukuran" class="form-label d-flex justify-content-center">Tambah Ukuran</label>
                        <div id="variasiContainer">
                            <div class="variation-group" data-index="${variasiIndex}">
                                <div class="input-group mb-3">
                                    <input type="text" id="placeukuran" name="size[]"  maxlength="20" placeholder="Standar/besar (Batas 20 karakter)" oninput="getHasil()" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                                    <button type="button" class="btn btn-danger" onclick="removeVariasi(${variasiIndex})">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" onclick="tambahHarga()">Tambah Ukuran</button>
                        <label for="tambah-harga" class="form-label d-flex justify-content-center pt-3">Tambah Harga Variasi</label>
                        <div id="hargaContainer">
                            <div class="price-group" data-index="${variasiIndex}">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="hasilnya"></span>
                                    <input type="text" name="harga[]" placeholder="Harga" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                                    <input type="number" name="stok[]" placeholder="Stok" class="form-control" style="display: inline-block;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="pilihwarna" class="form-group mt-3">
                        <label for="tambah-warna" class="form-label d-flex justify-content-center">Tambah Warna</label>
                            <div class="input-warna">
                                <label for="Warna">Warna</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="warna[]" placeholder="Warna" class="form-control">
                                    <button type="button" class="btn btn-danger pr-3" onclick="removeWarna(this)">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <div id="warna" class="form-group mt-3"></div>
                        <button type="button" class="btn btn-success" onclick="addWarna()">Tambahkan Pilihan</button>
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="bahan">Bahan</label>
                        <input type="text" class="form-control" name="bahanPerlengkapan" id="bahan" placeholder="Misal bahan terbuat dari alumunium/besi">
                    </div>
                    
                `;
        break;

      case "4": // Kesehatan dan kecantikan
        formHTML = `
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" name="kategori_kesehatan" id="kategori" placeholder="Misal Kosmetik/Suplemen">
                    </div>

                    <div class="form-group mt-3">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" name="harga_barang" id="harga" placeholder="Masukan harga">
                    </div>

                    <div class="form-group">
                        <label for="merk">Merk</label>
                        <input type="text" class="form-control" name="merk" id="Merek" placeholder="Misal L'Oréal/Nature’s Way">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="jenis">Jenis</label>
                        <input type="text" class="form-control" name="jenis" id="jenis" placeholder="Misal Serum/Tablet">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="jenisVitamin">Jenis Vitamin</label>
                        <input type="text" class="form-control" name="vitamin" id="vitamin" placeholder="Misal Vitamin A/ Vitamin c">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="isi">Isi</label>
                        <input type="text" class="form-control" name="isi" id="isi" placeholder="Misal 50 tablet">
                    </div>

                    <div class="form-group mt-3">
                        <label for="stok">Stok Barang</label>
                        <input type="number" class="form-control" name="stok_barang" id="stok" placeholder="Masukan Stok Barang">
                    </div>
                `;
        break;

      case "5": // Otomotif
        formHTML = `
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" name="kategori_otomotif" id="kategori" placeholder="Misal Suku cadang/Aksesori">
                    </div>

                    <div class="form-group mt-3">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" name="harga_barang" id="harga" placeholder="Masukan harga">
                    </div>

                    <div class="form-group">
                        <label for="merk">Merk</label>
                        <input type="text" class="form-control" name="merk" id="Merek" placeholder="Misal Bridgestone/Tamiya">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="model">Model</label>
                        <input type="text" class="form-control" name="model" id="model" placeholder="Misal Turanza T005/TT-01">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="jenisKendaraan">Jenis Kendaraan</label>
                        <input type="text" class="form-control" name="jenis" id="jenis" placeholder="Misal Motor/Mobil">
                    </div>

                    <div class="form-group mt-3">
                        <label for="stok">Stok Barang</label>
                        <input type="number" class="form-control" name="stok_barang" id="stok" placeholder="Masukan Stok Barang">
                    </div>
                    
                `;
        break;

      case "6": // Mainan dan Hobi
        formHTML = `
                    <div class="form-group mt-3">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" name="kategori_mainan" id="kategori" placeholder="Misal Mainan Edukasi/Kreatif">
                    </div>

                    <div class="form-group mt-3">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" name="harga_barang" id="harga" placeholder="Masukan harga">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="merk">Merk</label>
                        <input type="text" class="form-control" name="merk" id="Merek" placeholder="Misal Lego/Tamiya">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="jenis">Jenis</label>
                        <input type="text" class="form-control" name="jenis" id="jenis" placeholder="Misal puzzle/set bangunan ">
                    </div>

                    <div class="form-group mt-3">
                        <label for="bahan">Bahan</label>
                        <input type="text" class="form-control" name="bahan" id="bahan" placeholder="Misal Plastik/besi">
                    </div>

                    <div class="form-group mt-3">
                        <label for="stok">Stok Barang</label>
                        <input type="number" class="form-control" name="stok_barang" id="stok" placeholder="Masukan Stok Barang">
                    </div>
                    
                `;
        break;

      case "7": // Makanan dan Minuman
        formHTML = `
                    <div class="form-group mt-3">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" name="kategori_makanan" id="kategori_makanan" placeholder="Misal Minuman/Makanan">
                    </div>

                    <div class="form-group mt-3">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" name="harga_barang" id="harga" placeholder="Masukan harga">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="merk">Merk</label>
                        <input type="text" class="form-control" name="merk" id="Merek" placeholder="Misal Kopiko/Indomie">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="jenis">Jenis</label>
                        <input type="text" class="form-control" name="jenis" id="jenis" placeholder="Misal permen/makanan berat ">
                    </div>

                    <div class="form-group mt-3">
                        <label for="berat">Berat</label>
                        <input type="text" class="form-control" name="berat" id="berat" placeholder="20gr/500gr">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="tanggal">Tanggal Kadaluarsa</label>
                        <input type="date" class="form-control" name="tanggalkadaluarsa" id="tanggal" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="stok">Stok Barang</label>
                        <input type="number" class="form-control" name="stok_barang" id="stok" placeholder="Masukan Stok Barang">
                    </div>
                    
                `;
        break;

      case "8": // Perhiasan
        formHTML = `
                    <div class="form-group mt-3">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" name="kategori_perhiasan" id="kategori_perhiasan" placeholder="Misal Kalung/Cincin">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="merk">Merk</label>
                        <input type="text" class="form-control" name="merk" id="Merek" placeholder="Misal Tiffany & Co/Cartier">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="Bahan">Bahan</label>
                        <input type="text" class="form-control" name="bahan" id="bahan" placeholder="Misal Emas18K/Emas24K ">
                    </div>

                    <div class="form-group mt-3">
                        <label for="jenisbatu">Jenis Batu</label>
                        <input type="text" class="form-control" name="jenisbatu" id="jenisbatu" placeholder="Berlian/Platinum">
                    </div>
                    
                    <div id="variasi" class="form-group mt-3">
                        <label for="tambah-ukuran" class="form-label d-flex justify-content-center">Tambah Berat</label>
                        <div id="variasiContainer">
                            <div class="variation-group" data-index="${variasiIndex}">
                                <div class="input-group mb-3">
                                    <input type="text" id="placeukuran" name="size[]"  maxlength="20" placeholder="berat 1gr (Batas 20 karakter)" oninput="getHasil()" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                                    <button type="button" class="btn btn-danger" onclick="removeVariasi(${variasiIndex})">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" onclick="tambahHarga()">Tambah Berat</button>
                        <label for="tambah-harga" class="form-label d-flex justify-content-center pt-3">Tambah Harga Variasi</label>
                        <div id="hargaContainer">
                            <div class="price-group" data-index="${variasiIndex}">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="hasilnya"></span>
                                    <input type="text" name="harga[]" placeholder="Harga" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                                    <input type="number" name="stok[]" placeholder="Stok" class="form-control" style="display: inline-block;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                `;
        break;

      case "9": // Alat Musik
        formHTML = `
                    <div class="form-group mt-3">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" name="kategori_alat" id="kategori_alat" placeholder="Misal Gitar/Piano">
                    </div>

                    <div class="form-group mt-3">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" name="harga_barang" id="harga" placeholder="Masukan harga">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="merk">Merk</label>
                        <input type="text" class="form-control" name="merk" id="Merek" placeholder="Misal Yamaha/Casio">
                    </div>

                    <div class="form-group mt-3">
                        <label for="model">Model</label>
                        <input type="text" class="form-control" name="model" id="model" placeholder="Misal FG800/PX-160 ">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="jenis">Jenis</label>
                        <input type="text" class="form-control" name="jenis" id="jenis" placeholder="Misal Akustik/Digital ">
                    </div>

                    <div class="form-group mt-3">
                        <label for="stok">Stok Barang</label>
                        <input type="number" class="form-control" name="stok_barang" id="stok" placeholder="Masukan Stok Barang">
                    </div>
                    
                `;
        break;

      case "10": // Furtniture
        formHTML = `
                    <div class="form-group mt-3">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" name="kategori_furniture" id="kategori_furniture" placeholder="Misal Meja/Kursi">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="merk">Merk</label>
                        <input type="text" class="form-control" name="merk" id="Merek" placeholder="Misal Ikea/....">
                    </div>

                    <div class="form-group mt-3">
                        <label for="Bahan">Bahan</label>
                        <input type="text" class="form-control" name="bahan" id="bahan" placeholder="Misal Kayu/Kulit">
                    </div>
                    
                    <div id="variasi" class="form-group mt-3">
                        <label for="tambah-ukuran" class="form-label d-flex justify-content-center">Tambah Ukuran</label>
                        <div id="variasiContainer">
                            <div class="variation-group" data-index="${variasiIndex}">
                                <div class="input-group mb-3">
                                    <input type="text" id="placeukuran" name="size[]"  maxlength="20" placeholder="Ukuran (Batas 20 karakter)" oninput="getHasil()" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                                    <button type="button" class="btn btn-danger" onclick="removeVariasi(${variasiIndex})">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" onclick="tambahHarga()">Tambah Ukuran</button>
                        <label for="tambah-harga" class="form-label d-flex justify-content-center pt-3">Tambah Harga Variasi</label>
                        <div id="hargaContainer">
                            <div class="price-group" data-index="${variasiIndex}">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="hasilnya"></span>
                                    <input type="text" name="harga[]" placeholder="Harga" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                                    <input type="number" name="stok[]" placeholder="Stok" class="form-control" style="display: inline-block;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="pilihwarna" class="form-group mt-3">
                        <label for="tambah-warna" class="form-label d-flex justify-content-center">Tambah Warna</label>
                            <div class="input-warna">
                                <label for="Warna">Warna</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="warna[]" placeholder="Warna" class="form-control">
                                    <button type="button" class="btn btn-danger pr-3" onclick="removeWarna(this)">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <div id="warna" class="form-group mt-3"></div>
                        <button type="button" class="btn btn-success" onclick="addWarna()">Tambahkan Pilihan</button>
                    </div>
                    
                `;
        break;

      case "12": // Buku dan Media
        formHTML = `
                    <div class="form-group mt-3">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" name="kategori_buku" id="kategori_buku" placeholder="Misal Buku Pengembala">
                    </div>

                    <div class="form-group mt-3">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" name="harga_barang" id="harga" placeholder="Masukan harga">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="penulis">Penulis</label>
                        <input type="text" class="form-control" name="penulis" id="penulis" placeholder="Masukan Nama penulis buku">
                    </div>

                    <div class="form-group mt-3">
                        <label for="penerbit">Penerbit</label>
                        <input type="text" class="form-control" name="penerbit" id="penerbit" placeholder="Masukan penerbit">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="tanggal">Tanggal Terbit</label>
                        <input type="date" class="form-control" name="tanggalterbit" id="terbit" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="isbn">ISBN</label>
                        <input type="text" class="form-control" name="isbn" id="isbn" placeholder="Masukan ISBN">
                    </div>

                    <div class="form-group mt-3">
                        <label for="stok">Stok Barang</label>
                        <input type="number" class="form-control" name="stok_barang" id="stok" placeholder="Masukan Stok Barang">
                    </div>
                    
                `;
        break;

      case "13": // Lain-Lain
        formHTML = `
                    <div id="variasi" class="form-group mt-3">
                        <label for="tambah-ukuran" class="form-label d-flex justify-content-center">Tambah Ukuran</label>
                        <div id="variasiContainer">
                            <div class="variation-group" data-index="${variasiIndex}">
                                <div class="input-group mb-3">
                                    <input type="text" id="placeukuran" name="size[]"  maxlength="20" placeholder="Ukuran (Batas 20 karakter)" oninput="getHasil()" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                                    <button type="button" class="btn btn-danger" onclick="removeVariasi(${variasiIndex})">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" onclick="tambahHarga()">Tambah Ukuran</button>
                        <label for="tambah-harga" class="form-label d-flex justify-content-center pt-3">Tambah Harga Variasi</label>
                        <div id="hargaContainer">
                            <div class="price-group" data-index="${variasiIndex}">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="hasilnya"></span>
                                    <input type="text" name="harga[]" placeholder="Harga" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                                    <input type="number" name="stok[]" placeholder="Stok" class="form-control" style="display: inline-block;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="pilihwarna" class="form-group mt-3">
                        <label for="tambah-warna" class="form-label d-flex justify-content-center">Tambah Warna</label>
                            <div class="input-warna">
                                <label for="Warna">Warna</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="warna[]" placeholder="Warna" class="form-control">
                                    <button type="button" class="btn btn-danger pr-3" onclick="removeWarna(this)">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <div id="warna" class="form-group mt-3"></div>
                        <button type="button" class="btn btn-success" onclick="addWarna()">Tambahkan Pilihan</button>
                    </div>
                    
                `;
        break;

      // Tambahkan case untuk kategori lain jika diperlukan

      default:
        formHTML = `
                    <p> Tidak ada dalam Kategori </p>
                `;
        break;
    }

    formAtribut.innerHTML = formHTML;
  });
});
