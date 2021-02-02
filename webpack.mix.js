const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    //Assets - Admin css
    .styles('resources/views/admin/assets/css/style.css', 'public/backend/assets/css/style.css')
    .styles('resources/views/admin/assets/css/root.css', 'public/backend/assets/css/root.css')
    .styles('resources/views/admin/assets/css/dataTables.bootstrap4.min.css', 'public/backend/assets/css/dataTables.bootstrap4.min.css')
    .styles('resources/views/admin/assets/css/responsive.bootstrap4.min.css', 'public/backend/assets/css/responsive.bootstrap4.min.css')
    .styles('resources/views/admin/assets/css/adminlte.min.css', 'public/backend/assets/css/adminlte.min.css')
    .styles('resources/views/admin/assets/fontawesome-free/css/all.min.css', 'public/backend/assets/fontawesome-free/css/all.min.css')

    .scripts('resources/views/admin/assets/js/adminlte.min.js', 'public/backend/assets/js/adminlte.min.js')
    .scripts('resources/views/admin/assets/js/bootstrap.bundle.min.js', 'public/backend/assets/js/bootstrap.bundle.min.js')
    .scripts('resources/views/admin/assets/js/jquery.min.js', 'public/backend/assets/js/jquery.min.js')
    .scripts('resources/views/admin/assets/js/jquery.mask.js', 'public/backend/assets/js/jquery.mask.js')
    .scripts('resources/views/admin/assets/js/scripts.js', 'public/backend/assets/js/scripts.js')
    .scripts('resources/views/admin/assets/js/dataTables.bootstrap4.min.js', 'public/backend/assets/js/dataTables.bootstrap4.min.js')
    .scripts('resources/views/admin/assets/js/dataTables.responsive.min.js', 'public/backend/assets/js/dataTables.responsive.min.js')
    .scripts('resources/views/admin/assets/js/responsive.bootstrap4.min.js', 'public/backend/assets/js/responsive.bootstrap4.min.js')
    .scripts('resources/views/admin/assets/js/jquery.dataTables.min.js', 'public/backend/assets/js/jquery.dataTables.min.js')

    .copyDirectory('resources/views/admin/assets/img', 'public/backend/assets/img')
    .copyDirectory('resources/views/admin/assets/fontawesome-free/webfonts', 'public/backend/assets/fontawesome-free/webfonts')

    .options({
        processCssUrls: false
    })

    .version();

;
