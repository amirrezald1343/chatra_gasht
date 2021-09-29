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
    .js('resources/js/adminVue.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/adminStyles.scss', 'public/css')


/*
mix.scripts([
    'resources/alljs/adminVue.js',
    'resources/alljs/app.js',
    'resources/alljs/bootstrap.min.js',
    'resources/alljs/bootstrap-slider.min.js',
    'resources/alljs/carousel.js',
    'resources/alljs/cookies.js',
    'resources/alljs/fontawesome-all.min.js',
    'resources/alljs/imagesloaded.js',
    'resources/alljs/jquery.daterangepicker.min.js',
    'resources/alljs/jquery.min.js',
    'resources/alljs/jquery.sticky-kit.min.js',
    'resources/alljs/jquery.viewbox.min.js',
    'resources/alljs/jquery.waypoints.min.js',
    'resources/alljs/jqueryvalidation.js',
    'resources/alljs/jscolor.js',
    'resources/alljs/main.js',
    'resources/alljs/maplace.js',
    'resources/alljs/masonry.min.js',
    'resources/alljs/modernizr.js',
    'resources/alljs/moment.js',
    'resources/alljs/navigation.js',
    'resources/alljs/owl.carousel.min.js',
    'resources/alljs/settings.js',
], 'public/js/allJsFiles.js');

*/

mix.styles([
    'resources/allcss/animate.css',
    'resources/allcss/bootstrap.min.css',
    'resources/allcss/bootstrap-rtl.css',
    'resources/allcss/bootstrap-slider.min.css',
    'resources/allcss/daterangepicker.min.css',
    'resources/allcss/detail.css',
    'resources/allcss/font-awesome.css',
    'resources/allcss/index.css',
    'resources/allcss/layout.css',
    'resources/allcss/owl.carousel.css',
    'resources/allcss/owl.carousel.min.css',
    'resources/allcss/owl.theme.default.css',
    'resources/allcss/owl.theme.default.min.css',
    'resources/allcss/schemes.css',
    'resources/allcss/themify-icons.css',
    'resources/allcss/tourDetails.css',
    'resources/allcss/tourList.css',
    'resources/allcss/viewbox.css',
    'resources/allcss/custom.css',
    'resources/allcss/main.css',
], 'public/css/allCssFilesNew.css');
