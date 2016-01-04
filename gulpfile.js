var dir, elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

dir = {
  asset: {
    css: 'public/css',
    img: 'public/img',
    js: 'public/js'
  },
  vendor: 'vendor/bower_components'
};

elixir(function(mix) {
  mix.copy('resources/assets/css/', 'public/css/')
      .copy('resources/assets/img/', 'public/img/')
      .copy('resources/assets/js/', 'public/js/')
      .copy('resources/assets/libs/', 'public/assets/');
});
