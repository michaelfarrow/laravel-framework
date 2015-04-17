var elixir = require('laravel-elixir'),
	paths = {
		'bootstrap': 'resources/assets/vendor/bootstrap-sass-official/assets/',
	}

require('laravel-elixir-sass-compass');
require('./elixir-custom-tasks');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

	// Install FE deps
	mix.bower('resources/assets/vendor')
		.bower_prune()

		// Copy Bootstrap assets
		.copy(paths.bootstrap + 'fonts/bootstrap/', "public/fonts/bootstrap/")

		// Compile compass
		.compass()

		// Minify CSS files for build
		.minify(null, elixir.config.cssOutput + '/compiled')

		// Uglify JS files for build
		.uglify(null, elixir.config.jsOutput + '/compiled');

	// Copy environment file
	mix.copy('.env.example', '.env')

		// Run composer
		.composer();

});
