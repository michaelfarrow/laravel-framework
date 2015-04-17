var elixir = require('laravel-elixir');
var gulp = require('gulp');
var uglify = require('gulp-uglify');
var minify = require('gulp-minify-css');
var bower = require('gulp-bower');
var composer = require('gulp-composer');

var _ = require('underscore');
 
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

