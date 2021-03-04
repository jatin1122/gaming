const mix = require('laravel-mix');
const SVGSpritemapPlugin = require('svg-spritemap-webpack-plugin');

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
const SVGSpritemapPluginConfig = new SVGSpritemapPlugin('resources/assets/icons/*.svg', {
        output: {
            filename: 'icon-sprite.svg',
            svg4everybody: true,
            chunk: {
                keep: true,
                name: 'chunk-fix'
            }
        },
        sprite: {
            prefix: false,
        }
    })


mix.js('resources/assets/js/app.js', 'public/js').version()
   .sass('resources/assets/sass/app.scss', 'public/css').version()
   .copyDirectory('resources/assets/images', 'public/images')
   .webpackConfig({
        plugins: [
            SVGSpritemapPluginConfig
        ]
    })
    .disableNotifications();