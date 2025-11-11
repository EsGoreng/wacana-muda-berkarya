import "./bootstrap";
import "flowbite";
import Alpine from "alpinejs";
import Quill from "quill";
import * as FilePond from "filepond";

// FilePond + plugins + CSS
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
// (optional) image edit plugin - include only if installed in your project
// image-edit plugin removed to avoid extra server/process requirements

// Quill CSS
import 'quill/dist/quill.snow.css';

// Initialize FilePond: register plugins first, then create instances for all matching inputs
try {

    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginImageExifOrientation,
        FilePondPluginFileValidateSize
    );

    // Find all file inputs with name 'image' or 'avatar' and create a FilePond instance for each
    const fileInputs = document.querySelectorAll('input[type="file"][name="image"], input[type="file"][name="avatar"]');

    fileInputs.forEach((inputElement) => {
        FilePond.create(inputElement, {
            // Styling / behavior options
            stylePanelLayout: 'integrated',
            styleLoadIndicatorPosition: 'center bottom',
            styleProgressIndicatorPosition: 'right bottom',
            styleButtonRemoveItemPosition: 'left bottom',
            styleButtonProcessItemPosition: 'right bottom',
            allowMultiple: false,
            // Do not perform async uploads — submit the file with the form as a normal file input
            allowProcess: false,
            // Ensure FilePond writes the selected file back to the original input so
            // the browser includes it in the multipart/form-data submit
            storeAsFile: true,
            maxFileSize: '2MB',
            credits: {
                label: ''
            }
        });
    });
} catch (e) {
    // If plugin import/registration fails, log so developer can check install
    // Do not throw to avoid breaking other scripts (Quill/Alpine)
    // eslint-disable-next-line no-console
    console.error('FilePond plugin registration failed:', e);
}

const editorElement = document.getElementById('editor');

if (editorElement) {
    // Inisialisasi Quill dengan toolbar
    const quill = new Quill(editorElement, {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['blockquote', 'code-block'],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // Ambil form dan input tersembunyi dari dalam form yang sama
    const form = editorElement.closest('form'); // cari form terdekat
    const hiddenInput = form ? form.querySelector('input[name="body"]') : null;

    if (form && hiddenInput) {
        // Copy content to hidden input before submit
        form.addEventListener('submit', function () {
            hiddenInput.value = quill.root.innerHTML;
        });
    } else {
        // eslint-disable-next-line no-console
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