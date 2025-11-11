import "./bootstrap";
import "flowbite";
import Alpine from "alpinejs";
import Quill from "quill";
import * as FilePond from "filepond";

// --- IMPORT PLUGIN BARU ---
import FilePondPluginFileEncode from 'filepond-plugin-file-encode';

// ... (Plugin lain yang sudah ada)
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
// ...

// Cek apakah ada input file
const inputElement = document.querySelector(
    'input[type="file"][name="image"], input[type="file"][name="avatar"]'
);

if (inputElement) {
    FilePond.create(inputElement, {
        // ... (Opsi styling Anda)
    });

    FilePond.registerPlugin(
        // --- DAFTARKAN PLUGIN BARU DI SINI ---
        FilePondPluginFileEncode,
        
        // ... (Plugin lain yang sudah ada)
        FilePondPluginImagePreview,
        FilePondPluginImageExifOrientation,
        FilePondPluginFileValidateSize,
        FilePondPluginImageEdit
    );
}

const editorElement = document.getElementById('editor');

if (editorElement) {
    
    // Inisialisasi Quill
    const quill = new Quill(editorElement, {
        theme: 'snow' // Tema 'snow' adalah yang standar
    });

    // Ambil form dan input tersembunyi
    const form = editorElement.closest('form'); // <- LEBIH BAIK: Cari form terdekat
    const hiddenInput = document.querySelector('input[name="body"]'); // <- LEBIH BAIK: Cari berdasarkan nama

    // Pastikan kita menemukan keduanya
    if (form && hiddenInput) {
        // Saat form di-submit...
        form.addEventListener('submit', function () {
            // Salin konten HTML dari editor Quill ke input tersembunyi
            hiddenInput.value = quill.root.innerHTML;
        });
    } else {
        console.error('Quill editor could not find its parent form or hidden "body" input.');
    }
}


window.Alpine = Alpine;
Alpine.start();