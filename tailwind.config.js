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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Ocean Blue Theme
                ocean: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0077B6', // Primary ocean blue
                    600: '#005f8a',
                    700: '#004d73',
                    800: '#003d5c',
                    900: '#002b42',
                },
                // Cloud Blue
                cloud: {
                    50: '#CAF0F8', // Light cloud
                    100: '#E8F4F8',
                    200: '#90E0EF',
                    300: '#00B4D8', // Accent cloud blue
                    400: '#0096c7',
                    500: '#0077b6',
                },
                // Grass Green
                grass: {
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#95D5B2',
                    400: '#52B788', // Primary grass green
                    500: '#40916C',
                    600: '#2D6A4F', // Deep grass
                    700: '#245a42',
                    800: '#1e4a37',
                    900: '#173829',
                },
                // Tree Green
                tree: {
                    50: '#ecfdf5',
                    100: '#D1FAE5',
                    200: '#74C69D',
                    300: '#40916C',
                    400: '#2D6A4F',
                    500: '#1b5e3b',
                },
                // Nature gradients
                nature: {
                    start: '#0077B6', // Ocean blue
                    end: '#2D6A4F',   // Grass green
                },
            },
        },
    },

    plugins: [forms],
};
