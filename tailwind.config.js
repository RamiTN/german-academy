import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                accent: {
                    DEFAULT: '#D4A843',
                    hover: '#B8922F',
                    subtle: '#FBF5E6',
                },
                dark: {
                    DEFAULT: '#0A0A0A',
                    surface: '#1A1A1A',
                },
                live: '#EF4444',
            },
        },
    },

    plugins: [forms],
};
