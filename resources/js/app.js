// resources/js/app.js
import './bootstrap';
import 'flowbite';
import Alpine from 'alpinejs';
import Quill from 'quill';

// ... (Kode Quill) ...

// --- DINONAKTIFKAN SEMENTARA ---
// import * as FilePond from 'filepond';

// // Cek apakah ada input file
// const inputElement = document.querySelector('input[type="file"]');

// if (inputElement) {
//     // Inisialisasi FilePond
//     FilePond.create(inputElement, {
//         // ... (opsi-opsi) ...
//     });
    
//     // Atur server untuk upload (SANGAT PENTING)
//     FilePond.setOptions({
//         // ... (opsi server) ...
//     });
// }
// --- AKHIR DARI KODE NONAKTIF ---


window.Alpine = Alpine;
Alpine.start();