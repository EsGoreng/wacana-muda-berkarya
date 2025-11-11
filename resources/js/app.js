// resources/js/app.js
import './bootstrap';
import 'flowbite';
import Alpine from 'alpinejs';
import Quill from 'quill';
import * as FilePond from 'filepond';

// Cek apakah ada input file dengan 'name="image"' atau 'name="avatar"'
const inputElement = document.querySelector('input[type="file"][name="image"], input[type="file"][name="avatar"]');

if (inputElement) {
    // Inisialisasi FilePond
    FilePond.create(inputElement, {
        // Opsi styling
        stylePanelLayout: 'integrated',
        styleLoadIndicatorPosition: 'center bottom',
        styleProgressIndicatorPosition: 'right bottom',
        styleButtonRemoveItemPosition: 'left bottom',
        styleButtonProcessItemPosition: 'right bottom',
    });

    // !!!!! PENTING !!!!!
    // JANGAN TAMBAHKAN 'FilePond.setOptions({ server: ... })' DI SINI.
    // Dengan menghapusnya, Filepond akan kembali ke mode 'non-async'
    // dan mengirimkan file bersamaan dengan form submit,
    // yang sesuai dengan controller Laravel Anda.
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