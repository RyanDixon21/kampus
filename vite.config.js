import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        // Minify CSS and JavaScript for production
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true, // Remove console.log in production
                drop_debugger: true,
            },
        },
        // Optimize chunk size
        rollupOptions: {
            output: {
                manualChunks: {
                    // Split vendor code into separate chunk
                    vendor: ['alpinejs', 'axios'],
                },
            },
        },
        // Enable CSS code splitting
        cssCodeSplit: true,
        // Set chunk size warning limit
        chunkSizeWarningLimit: 1000,
        // Optimize assets
        assetsInlineLimit: 4096, // Inline assets smaller than 4kb
    },
    // CSS optimization
    css: {
        devSourcemap: true,
    },
});
