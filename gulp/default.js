var config = require('../config.json');

module.exports = function(gulp) {
  gulp.task('default',[config.gulpTasks.watch, config.gulpTasks.browsersync]);
};
