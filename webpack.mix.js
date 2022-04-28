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

/*mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);*/
mix.js([
    'resources/js/admin/scripts.js',
], 'public/themes/default/js/admin/app.min.js')
    .postCss(
        'resources/css/admin/adminltev3.css',
        'public/themes/default/css/admin/adminltev3.css')
    .postCss('resources/css/admin/app.css',
        'public/themes/default/css/admin/app.css')
    .postCss('resources/css/admin/custom.css',
        'public/themes/default/css/admin/custom.css')
    .postCss('resources/css/admin/style.css',
    'public/themes/default/css/admin/style.css');

mix.copyDirectory( 'resources/vendor', 'public/vendor');
mix.copyDirectory( 'resources/ckeditor', 'public/ckeditor');

