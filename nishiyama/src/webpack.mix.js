const mix = require('laravel-mix');


mix.js('resources/js/appRoot.js', 'public/js').react()
    .sass('resources/sass/app.scss', 'public/css')
    .babelConfig({
      "presets": [
        "@babel/preset-env"
      ],
      "plugins": [
        "@babel/plugin-proposal-class-properties"
      ],
  },
);

if (mix.inProduction()) {
    mix.version();
}