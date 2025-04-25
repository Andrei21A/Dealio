/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./storage/framework/views/**/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", "sans-serif"],
                playful: ["Poetsen One", "sans-serif"],
                display: ["Montserrat", "sans-serif"],
                body: ["Poppins", "sans-serif"],
                subtle: ["Poppins", "sans-serif"],
                accent: ["Montserrat", "sans-serif"],
            },
        },
    },
    plugins: [],
};
