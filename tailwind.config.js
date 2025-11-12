import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import flowbite from "flowbite/plugin";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", "Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
    primary: {
        50:  "#E6EEF7",
        100: "#CDDEF0",
        200: "#9BBCE1",
        300: "#699BD2",
        400: "#2C73B2", // light blue accent
        500: "#205294", // accent utama
        600: "#18477F",
        700: "#144171", // secondary
        800: "#0A2646", // dominan
        900: "#071C35",
        950: "#041A27",
    },
},



        },
    },

    plugins: [forms, flowbite],
};
