/**
 * Check the code before committing to git
 */
var config = require('../config.json');

module.exports = function(gulp) {
  gulp.task(config.gulpTasks.preCommit, [
    config.gulpTasks.jscs,
    config.gulpTasks.jshint,
    config.gulpTasks.phpunit,
  ]);
};
