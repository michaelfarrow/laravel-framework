var elixir = require('laravel-elixir');
var gulp = require('gulp');
var uglify = require('gulp-uglify');
var minify = require('gulp-minify-css');
var bower = require('gulp-bower');

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
 
    gulp.src(src)
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
 
    gulp.src(src)
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
 
    gulp.src(src)
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
 
 
elixir.extend('bower', function(src, outputDir, options) {
 
  src = src || null;
 
  outputDir = outputDir || 'lib/'; 
 
  options = _.extend({directory: src}, options);
 
  gulp.task('bower', function() {
 
    bower(options);

  });
 
  return this.queueTask('bower');

});

