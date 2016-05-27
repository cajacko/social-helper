/**
 * Check the php for code styling standards
 */

var config = require('../config.json');
var phpcs = require('gulp-phpcs');

module.exports = function(gulp, phpLintDirs) {
  gulp.task(config.gulpTasks.phpcs, function() {
    return gulp.src(phpLintDirs)
      // Validate files using PHP Code Sniffer
      .pipe(phpcs({
        bin: './' + config.libs.composer.dir + '/bin/phpcs',
        standard: 'PSR2',
        warningSeverity: 0
      }))
      // Log all problems that was found
      .pipe(phpcs.reporter('log'));
  });
};
