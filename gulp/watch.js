/**
 * Run any ongoing tasks for use in development
 */
var config = require('../config.json');
var browserSync = require('browser-sync');

module.exports = function(gulp) {
  gulp.task(config.gulpTasks.watch, function() {
    gulp.watch(['./' + config.php.testsDir + '/**/*.php', './' + config.src.dir + '/**/*.php'], [config.gulpTasks.phpunit]);
    gulp.watch(['./' + config.js.watch + '**/*.js'], [config.gulpTasks.scripts]);

    gulp.watch([
      '.' + config.publicDir + '/**/*',
      './src/**/*.php',
      './config.json'
    ]).on('change', browserSync.reload);
  });
};
