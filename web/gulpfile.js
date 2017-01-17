var gulp = require('gulp');
var browserSync = require('browser-sync');
var nodemon = require('gulp-nodemon');

gulp.task('default', ['browser-sync']);

gulp.task('browser-sync', function() {
  browserSync.init(null, {
    proxy: "http://localhost:1337",
    ws: true,
    ghostMode: false
        // files: ["public/**/*.*"],
        // browser: "google chrome",
        // port: 7000,
  });
});

gulp.task('nodemon', function (cb) {

  var started = false;

  return nodemon({
    script: './app/server/server.js'
  }).on('start', function () {
    // to avoid nodemon being started multiple times
    // thanks @matthisk
    if (!started) {
      cb();
      started = true;
    }
  });
});
