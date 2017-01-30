var gulp = require('gulp')
var nodemon = require('gulp-nodemon')
var babel = require('gulp-babel')
var Cache = require('gulp-file-cache')
var browserSync = require('browser-sync')
var webpack = require('gulp-webpack')

var cache = new Cache();

gulp.task('compile', function () {
  var stream = gulp
    .src('./app/server/**/*.js') // your ES2015 code
    .pipe(cache.filter()) // remember files
    .pipe(babel()) // compile new ones
    .pipe(cache.cache()) // cache them
    .pipe(gulp.dest('./app/dist')) // write them

  return stream // important for gulp-nodemon to wait for completion
})

gulp.task('webpack', function() {
  return gulp.src('./app/views/index.jsx')
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(gulp.dest('./public/scripts/'))
});

gulp.task('watch', ['compile'], function () {
  browserSync.init(null, {
    proxy: "http://localhost:1337"
  })

  var stream = nodemon({
    script: './app/dist/server.js',
    watch: './app/server',
    tasks: ['compile']
  }).on('start', function () {
    console.log('reload in timeout')
    setTimeout(function() {
      console.log('reload')
      browserSync.reload()
    }, 3000)
  })

  return stream
})

// var gulp = require('gulp');
// var browserSync = require('browser-sync');
// var nodemon = require('gulp-nodemon');
//
// gulp.task('default', ['browser-sync']);
//
// gulp.task('browser-sync', function() {
//   browserSync.init(null, {
//     proxy: "http://localhost:1337",
//     ws: true,
//     ghostMode: false
//         // files: ["public/**/*.*"],
//         // browser: "google chrome",
//         // port: 7000,
//   });
// });
//
// gulp.task('nodemon', function (cb) {
//
//   var started = false;
//
//   return nodemon({
//     script: './app/server/server.js'
//   }).on('start', function () {
//     // to avoid nodemon being started multiple times
//     // thanks @matthisk
//     if (!started) {
//       cb();
//       started = true;
//     }
//   });
// });
