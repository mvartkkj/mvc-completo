import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Cores principais do sistema
                background: '#ffffff',
                foreground: '#0a0a0a',
                
                card: '#ffffff',
                'card-foreground': '#0a0a0a',
                
                primary: {
                    DEFAULT: '#ea580c',  // Laranja vibrante (mude aqui!)
                    foreground: '#ffffff',
                },
                
                secondary: {
                    DEFAULT: '#f97316',
                    foreground: '#ffffff',
                },
                
                accent: {
                    DEFAULT: '#ea580c',
                    foreground: '#ffffff',
                },
                
                muted: {
                    DEFAULT: '#f5f5f5',
                    foreground: '#737373',
                },
                
                border: '#e5e5e5',
            }
        },
    },
    plugins: [],
};