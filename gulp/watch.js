/**
 * Run any ongoing taks for use in development
 */
var config = require('../config.json');

module.exports = function(gulp) {
  gulp.task(config.gulpTasks.watch, function() {
    gulp.watch(['./' + config.php.testsDir + '/**/*.php', './' + config.src.dir + '/**/*.php'], [config.gulpTasks.phpunit]);
  });
};
