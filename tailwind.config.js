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
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // 60% Dominant Colors (White - Background & Atmosphere)
                primary: {
                    50: '#ffffff',   // Pure white
                    100: '#ffffff',  // Pure white
                    200: '#ffffff',  // Pure white
                    300: '#ffffff',  // Pure white
                    400: '#ffffff',  // Pure white
                    500: '#ffffff',  // Main white (60% usage)
                    600: '#ffffff',  // Pure white
                    700: '#ffffff',  // Pure white
                    800: '#ffffff',  // Pure white
                    900: '#ffffff',  // Pure white
                },
                // 30% Secondary Colors (Black/Gray - Support & Contrast)
                secondary: {
                    50: '#f9f9f9',   // Very light gray
                    100: '#f4f4f4',  // Light gray
                    200: '#e4e4e4',  // Border gray
                    300: '#d1d1d1',  // Subtle gray
                    400: '#a3a3a3',  // Medium gray
                    500: '#737373',  // Text gray
                    600: '#525252',  // Dark gray
                    700: '#404040',  // Darker gray
                    800: '#262626',  // Very dark gray
                    900: '#000000',  // Pure black (30% usage)
                },
                // 10% Accent Colors (Orange - Focus Points & Details)
                accent: {
                    50: '#fff7ed',   // Very light orange
                    100: '#ffedd5',  // Light orange
                    200: '#fed7aa',  // Soft orange
                    300: '#fdba74',  // Medium orange
                    400: '#fb923c',  // Bright orange
                    500: '#f97316',  // Main orange (10% usage)
                    600: '#ea580c',  // Dark orange
                    700: '#c2410c',  // Darker orange
                    800: '#9a3412',  // Very dark orange
                    900: '#7c2d12',  // Deep orange
                },
            },
            boxShadow: {
                'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                'medium': '0 4px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                'large': '0 10px 40px -10px rgba(0, 0, 0, 0.15), 0 20px 25px -5px rgba(0, 0, 0, 0.1)',
            },
            padding: {
                'safe': 'env(safe-area-inset-bottom)',
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-up': 'slideUp 0.3s ease-out',
                'bounce-subtle': 'bounceSubtle 0.6s ease-in-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(10px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                bounceSubtle: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-5px)' },
                },
            },
        },
    },

    plugins: [forms],
};