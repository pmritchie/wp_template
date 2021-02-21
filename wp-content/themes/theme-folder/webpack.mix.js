const mix = require('laravel-mix')
require('@tinypixelco/laravel-mix-wp-blocks')
require('laravel-mix-purgecss')
require('laravel-mix-copy-watched')
require('intersection-observer')
require('autoprefixer')




mix.webpackConfig({
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      vue$: 'vue/dist/vue.esm.js',
      '@': __dirname + '/resources/js/components',
    },
  },
})


mix.browserSync({
  proxy: 'https://website-title.test',
  host: 'localhost',
  open: 'external',
  https: {
    key: '/Users/patrickritchie/.config/valet/Certificates/website-title.test.key',
    cert: '/Users/patrickritchie/.config/valet/Certificates/website-title.test.crt',
  },
  files: ['*.*'],
})


mix
.setPublicPath('/')
.sass('resources/styles/main.scss', 'css/style.css')
.options({
  processCssUrls: false,
})
  .js('resources/scripts/app.js', 'js/app.js')
  .js('resources/scripts/customizer.js', 'dist/js')
  .blocks('resources/scripts/editor.js', 'dist/js')
  .extract()

mix
  .copyWatched('resources/images/**', 'dist/images')
  .copyWatched('resources/fonts/**', 'dist/fonts')

mix.autoload({
  jquery: ['$', 'window.jQuery'],
})


mix.sourceMaps(true, 'source-map').version()

