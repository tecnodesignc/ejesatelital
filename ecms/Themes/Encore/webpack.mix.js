const mix = require('laravel-mix');
const WebpackShellPlugin = require('webpack-shell-plugin');
const themeInfo = require('./theme.json');

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


mix.js('resources/js/app.js', 'assets/js')
    .vue();

/**
 * Publishing the assets
 */
mix.webpackConfig({
  plugins: [
    new WebpackShellPlugin({onBuildEnd:['php ../../artisan stylist:publish ' + themeInfo.name]})
  ]
});
