var config = require('../config.json');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var browserify = require('browserify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');

module.exports = function(gulp) {
  var javascriptsExport = '.' + config.js.export;

  gulp.task(config.gulpTasks.scripts, function() {
    return browserify('.' + config.js.import)
      .bundle()
      .on('error', function(err) {
        console.log(err.message);
        this.emit('end');
      })
      .pipe(source(config.js.main)) //Pass desired output filename to vinyl-source-stream
      .pipe(gulp.dest(javascriptsExport)) // Output the file
      .pipe(buffer()) // convert from streaming to buffered vinyl file object
      .pipe(rename(config.js.min)) // Rename the minified version
      .pipe(uglify()) // Minify the file
      .pipe(gulp.dest(javascriptsExport)); // Output the minified file
  });
};
