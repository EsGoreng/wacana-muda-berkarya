import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbite from 'flowbite/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './node_modules/flowbite/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: 'oklch(0.97 0.03 265.31)',
                    100: 'oklch(0.85 0.08 265.31)',
                    200: 'oklch(0.65 0.13 265.31)',
                    300: 'oklch(0.50 0.14 265.31)',
                    400: 'oklch(0.38 0.13 265.31)',
                    500: 'oklch(0.2701 0.1121 265.31)',
                    600: 'oklch(0.23 0.10 265.31)',
                    700: 'oklch(0.20 0.09 265.31)',
                    800: 'oklch(0.17 0.08 265.31)',
                    900: 'oklch(0.14 0.07 265.31)',
                    950: 'oklch(0.11 0.05 265.31)',
                },
            },
        },
    },

    plugins: [forms, flowbite],
};
    