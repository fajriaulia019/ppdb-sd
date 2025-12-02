document.addEventListener('DOMContentLoaded', function() {
    const fotoSiswaInput = document.getElementById('foto_siswa');
    const photoPreview = document.getElementById('photoPreview');
    const cameraIcon = document.getElementById('cameraIcon');

    // Fungsi untuk mengelola visibilitas preview foto dan ikon kamera
    function updatePhotoDisplay(isPhotoPresent) {
        if (isPhotoPresent) {
            photoPreview.style.display = 'block'; // Tampilkan gambar
            cameraIcon.style.display = 'none';    // Sembunyikan ikon kamera
        } else {
            photoPreview.style.display = 'none'; // Sembunyikan gambar
            photoPreview.src = '';               // Kosongkan src gambar
            cameraIcon.style.display = 'block';  // Tampilkan ikon kamera
        }
    }

    // Event listener saat user memilih file
    fotoSiswaInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
                updatePhotoDisplay(true); // Tampilkan foto yang baru dipilih
            };
            reader.readAsDataURL(file);
        } else {
            // Jika file dibatalkan atau dihapus, kembali ke status 'tidak ada foto'
            updatePhotoDisplay(false); 
        }
    });

    // Catatan: Inisialisasi awal saat halaman dimuat sudah ditangani oleh PHP Blade
    // sehingga tidak perlu ada logika inisialisasi awal di JavaScript di sini lagi.
    // Jika ada foto, PHP sudah set display: block untuk img dan display: none untuk i.
    // Jika tidak ada foto, PHP sudah set display: none untuk img dan display: block untuk i.
});