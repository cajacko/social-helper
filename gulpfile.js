var gulp = require('gulp');
var sass = require('gulp-sass');
var rename = require('gulp-rename');
var minifyCss = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var modernizr = require('gulp-modernizr');
var browserSync = require('browser-sync');
var autoprefixer = require('gulp-autoprefixer');
var browserify = require('browserify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var ini = require('ini');
var fs = require('fs');
var config = require('./config.json');
var sassImportJson = require('gulp-sass-import-json');
var svgstore = require('gulp-svgstore');
var svgmin = require('gulp-svgmin');
var replace = require('gulp-replace');
var validator = require('html-validator');
var request = require('request');
var sitemap = require('sitemapper');

/********************************************************
* SETUP BROWSER SYNC                                    *
********************************************************/
gulp.task('browsersync', function() {
  browserSync.init(null, {
    proxy: 'social-helper.local.com',
    files: ['./public/**/*.*'],
  });
});

/********************************************************
* DEFAULT TASKS                                         *
********************************************************/
gulp.task('default',['browsersync']);
