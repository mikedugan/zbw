var gulp = require('gulp');
var rimraf = require('rimraf');
var less = require('gulp-less');
var concat = require('gulp-concat');
var prefixer = require('gulp-autoprefixer');
var cssmin = require('gulp-minify-css');
var jsmin = require('gulp-uglify');
var watch = require('gulp-watch');
var util = require('gulp-util');
var rename = require('gulp-rename');
var imgmin = require('gulp-imagemin');
var optipng = require('imagemin-optipng');
var jpgtran = require('imagemin-jpegtran');
var svgo = require('imagemin-svgo');

var paths = {
    js: 'public/js/',
    images: 'public/images/',
    styles: 'public/styles/',
    dist: 'public/dist/'
}

var files = {
    js: ['public/js/bootstrap.js', 'public/js/datetimepicker.js', 'public/js/redactor.js', 'public/js/raptor.js', 'public/js/slide.js', 'public/js/fileinput.js', 'public/js/functions.js', 'public/js/events.js', 'public/js/custom.js'],
    images: paths.images + '**/*',
    css: paths.styles + '*.css',
    less: paths.styles + '*.less',
    png: paths.images + '**/*.png',
    jpg: paths.images + '**/*.jpg',
    svg: paths.images + '**/*.svg'
}

gulp.task('default', ['clean', 'jsmin', 'imgmin', 'less-min']);

gulp.task('imgmin', ['jpgmin', 'pngmin', 'svgmin']);

gulp.task('watch', function() {
    gulp.src(files.less)
      .pipe(watch(function(files) {
          gulp.src(paths.styles + 'bootstrap.less').pipe(less())
            .pipe(prefixer("last 2 versions", "ie 10", "ie 9", "ie 11"))
            .pipe(cssmin({keepBreaks: false}))
            .pipe(gulp.dest(paths.dist)
          )
      }));
})

gulp.task('clean', function(cb) {
    rimraf(paths.dist, cb)
});

gulp.task('jsmin', function() {
    gulp.src(files.js)
      .pipe(concat('zbw.min.js'))
      .pipe(jsmin())
      .pipe(gulp.dest(paths.dist))
});

gulp.task('less-compile', function() {
    gulp.src(paths.styles + 'bootstrap.less')
      .pipe(less())
      .pipe(rename({
          basename: 'zbw',
          extname: '.css'
      }))
      .pipe(gulp.dest(paths.dist))
});

gulp.task('less-min', function(){
    return gulp.src(paths.styles + 'bootstrap.less')
      .pipe(less())
      .pipe(prefixer("last 2 versions", "ie 10", "ie 9", "ie 11"))
      .pipe(cssmin({keepBreaks: false}))
      .pipe(rename({
          basename: 'zbw.min',
          extname: '.css'
      }))
      .pipe(gulp.dest(paths.dist))
});

gulp.task('pngmin', function() {
    gulp.src(files.png)
      .pipe(imgmin({
          use: [optipng({optimizationLevel:3})]
      }))
      .pipe(gulp.dest(paths.dist + 'images'))
});

gulp.task('jpgmin', function() {
    gulp.src(files.jpg)
      .pipe(imgmin({
          progressive: true,
          use: [jpgtran()]
      }))
      .pipe(gulp.dest(paths.dist + 'images'))
});

gulp.task('svgmin', function() {
   gulp.src(files.svg)
     .pipe(gulp.dest(paths.dist + 'images/glyphicons'))
});
