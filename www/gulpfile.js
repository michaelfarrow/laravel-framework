var elixir = require('laravel-elixir'),
	paths = {
		'bootstrap': 'public/vendor/bootstrap-sass-official/assets',
		'requirejs': 'public/vendor/requirejs',
		'bower_libs': 'public/vendor'
	}

// require('laravel-elixir-compass');
require('./resources/elixir/elixir-custom-tasks');

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
	// mix.bower(paths.bower_libs)

		// Prune FE deps
		// .bower_prune()

		// Copy requirejs
		mix.copy(paths.requirejs + '/require.js', 'public/js/.compiled/require.js')

		// Copy Bootstrap assets
		.copy(paths.bootstrap + '/fonts/bootstrap', "public/fonts/bootstrap/")

		// Compile compass
		.compass(null,  'public/css/.compiled')

		// Build Custom Modernizr
		// .modernizr([
		// 		elixir.config.cssOutput + '/.compiled/*.css',
		// 		elixir.config.jsOutput + '/*.js',
		// 	],
		// 	elixir.config.jsOutput + '/.compiled', {
		// 		excludeTests: ['hidden'],
		// 		options: [
		// 			"setClasses",
		// 			"addTest",
		// 			"html5printshiv",
		// 			"testProp",
		// 			"fnBind"
		// 		],
		// 	}
		// )

		// Build JS bundle
		// .requirejs([
		// 	elixir.config.jsOutput + '/main.app.js',
		// 	elixir.config.jsOutput + '/main.admin.js'
		// ], elixir.config.jsOutput + '/.compiled', {
		// 	baseUrl: paths.bower_libs,
		// 	name: '../vendor/almond/almond',
		// 	mainConfigFile: elixir.config.jsOutput + '/config.js',
		// })

		// Minify CSS files for build
		// .minify(
		// 	elixir.config.cssOutput + '/.compiled/*.css',
		// 	elixir.config.cssOutput + '/.minified'
		// )

		// Uglify JS files for build
		// .uglify([
		// 	elixir.config.jsOutput + '/.compiled/*.js',
		// 	elixir.config.jsOutput + '/game.js',
		// 	elixir.config.jsOutput + '/vendor/modernizr.js',
		// 	elixir.config.jsOutput + '/modernizr/highres.js',
		// ], elixir.config.jsOutput + '/.minified')

		// Version files
		// .version([
		// 	elixir.config.jsOutput + '/.minified/*.js',
		// 	elixir.config.cssOutput + '/.minified/*.css',
		// ]);

	// Run composer
	// mix.composer();

});
