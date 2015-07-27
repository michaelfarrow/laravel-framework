var elixir = require('laravel-elixir'),
    gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    minify = require('gulp-minify-css'),
    compass = require('gulp-compass'),
    bower = require('gulp-bower'),
    composer = require('gulp-composer'),
    modernizr = require('gulp-modernizr'),
    _ = require('underscore'),
    rjs = require('gulp-requirejs-optimize');

/*
 |--------------------------------------------------------------------------
 | Require.js
 |--------------------------------------------------------------------------
 */

elixir.extend("compass", function(src, outputDir, options) {

    var config = this,
        publicDir = './public/',
        defaultOptions = {
            config_file: false,
            sourcemap:   false,
            modules:     false,
            style:       config.production ? "compressed" : "expanded",
            image:       publicDir + 'images',
            font:        publicDir + 'fonts',
            sass:        config.assetsDir + 'scss',
            css:         outputDir || config.cssOutput,
            js:          config.jsOutput
        };

    options = _.extend(defaultOptions, options);

    paths = new elixir.GulpPaths().src(src, options.sass, '**/*.scss');

    src = src || elixir.config.publicPath + '/' + elixir.config.js.folder + '/*.js';

    var onError = function(e) {
        new elixir.notification('Compass Compilation Failed!');
        this.emit('end');
    };

    gulp.task('compass', function() {
        return gulp.src(src)
            .pipe(compass({
                require: options.modules,
                config_file: options.config_file,
                style: options.style,
                css: options.css,
                sass: options.sass,
                font: options.font,
                image: options.image,
                javascript: options.js,
                sourcemap: options.sourcemap
            })).on('error', onError)
            .pipe(new elixir.notification('Compass Compiled!'));
    });

    this.registerWatcher('compass', options.sass + '/**/*.scss');
    return this.queueTask("compass");
});

elixir.extend('requirejs', function (src, dest, options) {

  var config = this,
    defaultOptions = {
      debug:  ! config.production,
      srcDir: config.assetsDir + 'js',
      output: config.jsOutput,
      optimize: 'none',
      useStrict: true,
      findNestedDependencies: true,
      wrap: true
    };

  options = _.extend(defaultOptions, options);

  gulp.task('requirejs', function () {

    return gulp.src(src)
      .pipe(rjs(function(file) {
        var filename = file.relative,
            name = filename.substring(0, filename.length -3);

        return _.extend({
          include: name
        }, options);
      })).pipe(gulp.dest(dest));
  });

  this.registerWatcher('requirejs', options.srcDir + '/**/*.js');

  return this.queueTask('requirejs');

});
 
/*
 |--------------------------------------------------------------------------
 | Uglify Task
 |--------------------------------------------------------------------------
 */
 
elixir.extend('uglify', function(src, outputDir, options) {
 
  src = src || elixir.config.jsOutput + '/*.js';
 
  outputDir = outputDir || elixir.config.jsOutput; 
 
  options = _.extend({}, options);
 
  gulp.task('uglify', function() {
 
    return gulp.src(src)
        .pipe(uglify(options))
        .pipe(gulp.dest(outputDir));
        
  });
 
  return this.queueTask('uglify');
 
});
 
/*
 |--------------------------------------------------------------------------
 | Minify Task
 |--------------------------------------------------------------------------
 */
 
 
elixir.extend('minify', function(src, outputDir, options) {
 
  src = src || elixir.config.cssOutput + '/*.css';
 
  outputDir = outputDir || elixir.config.cssOutput; 
 
  options = _.extend({keepSpecialComments: 0}, options);
 
  gulp.task('minify', function() {
 
    return gulp.src(src)
        .pipe(minify(options))
        .pipe(gulp.dest(outputDir));
        
  });
 
  return this.queueTask('minify');
 
});

/*
 |--------------------------------------------------------------------------
 | Modernizr Task
 |--------------------------------------------------------------------------
 */
 
 
elixir.extend('modernizr', function(src, outputDir, options) {
 
  src = src || [
    elixir.config.cssOutput + '/*.css',
    elixir.config.jsOutput + '/*.js',
  ];
 
  outputDir = outputDir || elixir.config.jsOutput; 
 
  options = _.extend({keepSpecialComments: 0}, options);
 
  gulp.task('modernizr', function() {
 
    return gulp.src(src)
        .pipe(modernizr(options))
        .pipe(gulp.dest(outputDir));
        
  });
 
  return this.queueTask('modernizr');
 
});


/*
 |--------------------------------------------------------------------------
 | Bower Task
 |--------------------------------------------------------------------------
 */
 
 
elixir.extend('bower', function(outputDir, options) {
  
  outputDir = outputDir || 'lib/'; 
 
  options = _.extend({}, options);
 
  gulp.task('bower', function() {
 
    return bower(options)
      .pipe(gulp.dest(outputDir));

  });

  // gulp.watch('bower.json', ['bower']);
 
  return this.queueTask('bower');

});

elixir.extend('bower_prune', function() {
  
  gulp.task('bower_prune', function() {
 
    return bower({ cmd: 'prune'});

  });

  // gulp.watch('bower.json', ['bower_prune']);
 
  return this.queueTask('bower_prune');

});



/*
 |--------------------------------------------------------------------------
 | Composer Task
 |--------------------------------------------------------------------------
 */
 
 
elixir.extend('composer', function(options) {
 
  gulp.task('composer', function() {
 
    return composer(options);
    
  });
 
  return this.queueTask('composer');
 
});

