module.exports = {
    important: true,

    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Vazir'],
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('tailwindcss-rtl'),
        require('tailwindcss-tables')(),
    ],
}
