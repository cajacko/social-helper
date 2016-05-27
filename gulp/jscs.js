/**
 * Check all js to make sure the coding styles are consistent
 */
var config = require('../config.json');
var jscs = require('gulp-jscs');

module.exports = function(gulp, jsLintDirs) {
  gulp.task(config.gulpTasks.jscs, function() {
    return gulp.src(jsLintDirs)
      .pipe(jscs())
      .pipe(jscs.reporter());
  });
};
