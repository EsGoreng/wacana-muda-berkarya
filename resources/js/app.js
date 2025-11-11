import "./bootstrap";
import "flowbite";
import Alpine from "alpinejs";
import Quill from "quill";
import * as FilePond from "filepond";

// --- IMPORT PLUGIN BARU ---
import FilePondPluginFileEncode from 'filepond-plugin-file-encode';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginImageEdit from 'filepond-plugin-image-edit';

// Register plugins BEFORE creating any FilePond instances
FilePond.registerPlugin(
    FilePondPluginFileEncode,
    FilePondPluginImagePreview,
    FilePondPluginImageExifOrientation,
    FilePondPluginFileValidateSize,
    FilePondPluginImageEdit
);

// Initialize FilePond for all matching file inputs (image/avatar)
const inputElements = document.querySelectorAll(
    'input[type="file"][name="image"], input[type="file"][name="avatar"]'
);

if (inputElements.length) {
    inputElements.forEach((inputElement) => {
        FilePond.create(inputElement, {
            allowMultiple: false,
            acceptedFileTypes: ['image/*'],
            // You can add other options here (e.g. maxFileSize, labelIdle, etc.)
        });
    });
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

// Dark Mode Toggle (works with button toggle)
document.addEventListener('DOMContentLoaded', function() {
    const html = document.documentElement;
    const darkToggle = document.getElementById('dark-toggle');
    const lightIcon = document.getElementById('light-icon');
    const darkIcon = document.getElementById('dark-icon');

    const updateIcons = (isDark) => {
        if (lightIcon && darkIcon) {
            if (isDark) {
                lightIcon.classList.remove('hidden');
                darkIcon.classList.add('hidden');
            } else {
                lightIcon.classList.add('hidden');
                darkIcon.classList.remove('hidden');
            }
        }
    };

    // Initialize theme from localStorage or system preference
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        html.classList.add('dark');
        updateIcons(true);
        if (darkToggle) {
            darkToggle.setAttribute('aria-pressed', 'true');
            darkToggle.setAttribute('aria-label', 'Switch to light mode');
        }
    } else {
        html.classList.remove('dark');
        updateIcons(false);
        if (darkToggle) {
            darkToggle.setAttribute('aria-pressed', 'false');
            darkToggle.setAttribute('aria-label', 'Switch to dark mode');
        }
    }

    // Toggle dark mode on button click
    if (darkToggle) {
        darkToggle.addEventListener('click', function() {
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateIcons(isDark);
            if (darkToggle) {
                darkToggle.setAttribute('aria-pressed', isDark ? 'true' : 'false');
                darkToggle.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
            }
        });
    }
});

window.Alpine = Alpine;
Alpine.start();