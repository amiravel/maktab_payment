module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
    ],
    plugins: [
        require('@tailwindcss/forms'),
        require('tailwindcss-rtl'),
    ],
}
