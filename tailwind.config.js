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
            colors: {
                background: '#fcf9f8',
                surface: '#fcf9f8',
                'surface-container-lowest': '#ffffff',
                'surface-container-low': '#f6f3f2',
                'surface-container': '#f0eded',
                'surface-container-high': '#eae7e7',
                'surface-variant': '#e5e2e1',
                'on-surface': '#1c1b1b',
                'on-surface-variant': '#444651',
                primary: '#002d71',
                'primary-container': '#21448b',
                'primary-fixed': '#dae2ff',
                'on-primary': '#ffffff',
                secondary: '#bb0013',
                'secondary-container': '#e71520',
                'secondary-fixed': '#ffdad6',
                'on-secondary': '#ffffff',
                outline: '#747782',
                'outline-variant': '#c4c6d2',
                error: '#ba1a1a',
            },
            fontFamily: {
                sans: ['Work Sans', ...defaultTheme.fontFamily.sans],
                headline: ['Manrope', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                civic: '0 10px 40px rgba(33, 68, 139, 0.08)',
                'civic-lg': '0 20px 70px rgba(33, 68, 139, 0.12)',
            },
            maxWidth: {
                'campaign': '1200px',
            },
        },
    },

    plugins: [forms],
};
