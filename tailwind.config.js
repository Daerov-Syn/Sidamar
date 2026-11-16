import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                // Design tokens SiDamar
                primary: {
                    50: '#E3F2FD',
                    100: '#BBDEFB',
                    200: '#90CAF9',
                    300: '#64B5F6',
                    400: '#42A5F5',
                    500: '#2196F3',
                    600: '#1E88E5',
                    700: '#1565C0',
                    800: '#0D47A1',
                    900: '#0A3476',
                    950: '#071E4A',
                },
                accent: {
                    yellow: '#FFC107',
                    orange: '#FF9800',
                },
                status: {
                    baru: '#EF4444',       // red
                    ditinjau: '#F59E0B',   // amber/orange
                    selesai: '#22C55E',    // green
                },
                surface: {
                    light: '#E3F2FD',
                    card: '#FFFFFF',
                    sidebar: '#0D47A1',
                },
            },
            fontFamily: {
                heading: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                body: ['Inter', ...defaultTheme.fontFamily.sans],
                mono: ['"JetBrains Mono"', ...defaultTheme.fontFamily.mono],
            },
            borderRadius: {
                'card': '1rem',
                'badge': '9999px',
            },
            boxShadow: {
                'card': '0 1px 3px 0 rgba(0, 0, 0, 0.08), 0 1px 2px -1px rgba(0, 0, 0, 0.08)',
                'card-hover': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1)',
            },
        },
    },
    plugins: [],
};
