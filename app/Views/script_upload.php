<div class="kotak"
    data-max-width="345"
    data-quality="0.85"
    data-threshold="100">

    <div class="spinner" style="display:none;">
        ⏳ <span class="ml-2">Memproses gambar...</span>
    </div>

    <label for="gambar_input">Upload Gambar</label>
    <img id="gambar_preview" class="img-thumbnail my-2 p-2" src="#" alt="Preview">
    <input type="file" id="gambar_input" name="gambar_input" accept=".jpg,.jpeg,.png" class="form-control-file">
    <div id="gambar_info" class="mt-1"><small>maksimal ukuran gambar 1 MB</small></div>
</div>

<script>
    const config = {
        inputId: 'foto_profil',
        previewId: 'profil_preview',
        infoId: 'profil_info'
    };
</script>
<script src="<?= base_url('page/upload_gambar.js') ?>"></script>


<script>
    document.getElementById('gambar_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file || !file.type.match(/image.*/)) return;

        const kotak = e.target.closest('.kotak');
        const spinner = kotak.querySelector('.spinner');
        const preview = kotak.querySelector('#gambar_preview');
        const info = kotak.querySelector('#gambar_info');

        const reader = new FileReader();
        reader.onload = function(event) {
            const img = new Image();
            img.onload = function() {
                // Ambil konfigurasi dari data-* atau fallback default
                const maxWidth = kotak.dataset.maxWidth ? parseInt(kotak.dataset.maxWidth) : img.width;
                const quality = kotak.dataset.quality ? parseFloat(kotak.dataset.quality) : 0.85;
                const thresholdKB = kotak.dataset.threshold ? parseInt(kotak.dataset.threshold) : 100;

                // Skip resize & kompresi jika ukuran kecil
                if (file.size <= thresholdKB * 1024) {
                    preview.src = URL.createObjectURL(file);
                    info.innerHTML = `<small>Dimensi asli: ${img.width}x${img.height} px<br>Ukuran asli: ${(file.size / 1024).toFixed(1)} KB</small>`;
                    return;
                }

                spinner.style.display = 'inline-block';

                const canvas = document.createElement('canvas');
                const scale = Math.min(maxWidth / img.width, 1);
                canvas.width = img.width * scale;
                canvas.height = img.height * scale;

                pica().resize(img, canvas)
                    .then(() => pica().toBlob(canvas, 'image/jpeg', quality))
                    .then(blob => {
                        spinner.style.display = 'none';
                        preview.src = URL.createObjectURL(blob);

                        const width = canvas.width;
                        const height = canvas.height;
                        const sizeKB = (blob.size / 1024).toFixed(1);
                        info.innerHTML = `<small>Dimensi gambar: ${width}x${height} px<br>Ukuran setelah proses: ${sizeKB} KB</small>`;

                        const newFile = new File([blob], file.name, {
                            type: blob.type
                        });
                        const dt = new DataTransfer();
                        dt.items.add(newFile);
                        e.target.files = dt.files;
                    });
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    });
</script>

multi upload beda gambar
<div class="kotak" 
     data-max-width="345" 
     data-quality="0.85" 
     data-threshold="100">
  <div class="spinner" style="display:none;">⏳ <span class="ml-2">Memproses gambar...</span></div>
  <label for="foto_profil">Foto Profil</label>
  <img id="preview_foto_profil" src="#" class="img-thumbnail my-2 p-2">
  <input type="file" id="foto_profil" name="foto_profil" accept=".jpg,.jpeg,.png">
  <div id="info_foto_profil"><small>maksimal ukuran gambar 1 MB</small></div>
</div>

<div class="kotak" 
     data-max-width="600" 
     data-quality="0.8" 
     data-threshold="150">
  <div class="spinner" style="display:none;">⏳ <span class="ml-2">Memproses gambar...</span></div>
  <label for="banner_utama">Banner Utama</label>
  <img id="preview_banner_utama" src="#" class="img-thumbnail my-2 p-2">
  <input type="file" id="banner_utama" name="banner_utama" accept=".jpg,.jpeg,.png">
  <div id="info_banner_utama"><small>maksimal ukuran gambar 2 MB</small></div>
</div>
