const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/login.js', 'public/js')
    .copy('resources/assets/js/perfect-scrollbar.min.js', 'public/js/perfect-scrollbar.min.js')
    .copy('resources/assets/js/custom/charts/dashboard-crypto.js', 'public/js/custom/charts/dashboard-crypto.js')
    .copy('resources/js/datatables.bundle.js', 'public/js/datatables.bundle.js')
    .copy('resources/js/script.js', 'public/js/script.js')
    .copy('resources/js/custome.js', 'public/js/custome.js')
    .copy('resources/js/spartan-multi-image-picker-min.js', 'public/js/spartan-multi-image-picker-min.js')
    .copy('resources/js/sweetalert2.all.min.js', 'public/js/sweetalert2.all.min.js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/assets/css/login.scss', 'public/css')
    .copyDirectory('resources/assets/css/gaxon-icon/fonts', 'public/css/fonts')
    .copyDirectory('resources/assets/fonts/noir-pro', 'public/fonts/noir-pro')
    .sourceMaps();
