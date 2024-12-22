let variationIndex = 0;

function addVariation() {
  const variationContainer = document.getElementById("variationContainer");
  const priceContainer = document.getElementById("priceContainer");

  // Menambahkan variasi
  const variationHtml = `
        <div class="variation-group" data-index="${variationIndex}">
            <div class="input-group mb-3">
                <input id="placeukuran-${variationIndex}" type="text" name="size[]" oninput="getValuedynamic(${variationIndex})" placeholder="Penyimpanan" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                <button type="button" class="btn btn-danger" onclick="removeVariation(${variationIndex})">Hapus</button>
            </div>
        </div>`;
  variationContainer.insertAdjacentHTML("beforeend", variationHtml);

  // Menambahkan harga yang sesuai
  const priceHtml = `
        <div class="price-group" data-index="${variationIndex}">
            <div class="input-group mb-3">
                <span id="hasil-${variationIndex}" class="input-group-text"></span>
                <input type="text" name="harga[]" placeholder="Harga" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                <input type="number" name="stok[]" placeholder="Stok" class="form-control" style="display: inline-block;">
            </div>
        </div>`;
  priceContainer.insertAdjacentHTML("beforeend", priceHtml);

  variationIndex++;
}

function removeVariation(index) {
  const variationContainer = document.getElementById("variationContainer");
  const priceContainer = document.getElementById("priceContainer");

  // Menghapus variasi
  const variationToRemove = variationContainer.querySelector(
    `.variation-group[data-index="${index}"]`
  );
  if (variationToRemove) {
    variationToRemove.remove();
  }

  // Menghapus harga yang terkait
  const priceToRemove = priceContainer.querySelector(
    `.price-group[data-index="${index}"]`
  );
  if (priceToRemove) {
    priceToRemove.remove();
  }
}

function removePrice(index) {
  removeVariation(index);
}

function addWarna() {
  const container = document.getElementById("pilihwarna");
  const html = `
        <div class="input-warna input-group mb-3">
            <input type="text" name="warna[]" placeholder="Warna" class="form-control" style="width: calc(100% - 100px); display: inline-block;">
            <button type="button" class="btn btn-danger" onclick="removeWarna(this)">Hapus</button>
        </div>`;
  container.insertAdjacentHTML("beforeend", html);
}

function removeWarna(button) {
  button.parentElement.remove();
}

function getValue() {
  let placeukuran = document.getElementById("placeukuran");
  let placeukuranhasil = placeukuran.value;

  let hasil = document.getElementById("hasil");
  hasil.innerText = placeukuranhasil;
}


function getValuedynamic(index) {
  let placeukuran = document.getElementById(`placeukuran-${index}`);
  let placeukuranhasil = placeukuran.value;

  let hasil = document.getElementById(`hasil-${index}`);
  hasil.innerText = placeukuranhasil;
}




// Berbeda beda



let variasiIndex = 0;

function tambahHarga() {
  const variasiContainer = document.getElementById("variasiContainer");
  const hargaContainer = document.getElementById("hargaContainer");

  // Menambahkan variasi
  const variasiHTML = `
        <div class="variation-group" data-index="${variasiIndex}">
            <div class="input-group mb-3">
                <input id="placeukuran-${variasiIndex}" type="text" name="size[]" maxlength="20" oninput="getHasilDynamic(${variasiIndex})" placeholder="Ukuran (Batas 20 karakter)" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                <button type="button" class="btn btn-danger" onclick="removeVariasi(${variasiIndex})">Hapus</button>
            </div>
        </div>`;
  variasiContainer.insertAdjacentHTML("beforeend", variasiHTML);

  // Menambahkan harga yang sesuai
  const hargaHTML = `
        <div class="price-group" data-index="${variasiIndex}">
            <div class="input-group mb-3">
                <span id="hasilnya-${variasiIndex}" class="input-group-text"></span>
                <input type="text" name="harga[]" placeholder="Harga" class="form-control" style="width: calc(50% - 60px); display: inline-block;">
                <input type="number" name="stok[]" placeholder="Stok" class="form-control" style="display: inline-block;">
            </div>
        </div>`;
  hargaContainer.insertAdjacentHTML("beforeend", hargaHTML);

  variasiIndex++;
}

function removeVariasi(index) {
  const variasiContainer = document.getElementById("variasiContainer");
  const hargaContainer = document.getElementById("hargaContainer");

  // Menghapus variasi
  const variationToRemove = variasiContainer.querySelector(
    `.variation-group[data-index="${index}"]`
  );
  if (variationToRemove) {
    variationToRemove.remove();
  }

  // Menghapus harga yang terkait
  const priceToRemove = hargaContainer.querySelector(
    `.price-group[data-index="${index}"]`
  );
  if (priceToRemove) {
    priceToRemove.remove();
  }
}

function getHasil() {
  let placeukuran = document.getElementById("placeukuran");
  let placeukuranhasil = placeukuran.value;

  let hasil = document.getElementById("hasilnya");
  hasil.innerText = placeukuranhasil;
}

function getHasilDynamic(index) {
  const placeukuran = document.getElementById(`placeukuran-${index}`);
  const placeukuranhasil = placeukuran.value;

  const hasil = document.getElementById(`hasilnya-${index}`);
  hasil.innerText = placeukuranhasil;
}




