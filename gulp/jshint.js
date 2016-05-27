/**
 * Check all js files to make sure the integrity is good
 */
var config = require('../config.json');
var jshint  = require('gulp-jshint');

module.exports = function(gulp, jsLintDirs) {
  gulp.task(config.gulpTasks.jshint, function() {
    return gulp.src(jsLintDirs)
      .pipe(jshint())
      .pipe(jshint.reporter('default'));
  });
};
