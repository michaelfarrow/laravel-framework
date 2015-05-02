var elixir = require('laravel-elixir'),
    gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    minify = require('gulp-minify-css'),
    bower = require('gulp-bower'),
    composer = require('gulp-composer'),
    modernizr = require('gulp-modernizr'),
    _ = require('underscore'),
    through2 = require('through2'),
    rjs = require('gulp-requirejs-optimize'),
    utilities = require('laravel-elixir/ingredients/commands/Utilities'),
    notification = require('laravel-elixir/ingredients/commands/Notification');


/*
 |--------------------------------------------------------------------------
 | Require.js
 |--------------------------------------------------------------------------
 */

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

      // .pipe(through2.obj(function (file, enc, next) {
      //  this.push(file);
      //  this.end();
      //  next();
      // }))
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

