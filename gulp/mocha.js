/**
 * Run the mocha tests
 */
var config = require('../config.json');
var mocha = require('gulp-mocha');

module.exports = function(gulp) {
  gulp.task(config.gulpTasks.mocha, function() {
    return gulp
      .src('./' + config.js.testsDir + '/**/*.js', {read: false})
      .pipe(mocha({
        reporter: 'nyan',
        timeout: 5000,
      }))
      .on('end', function() {
        process.exit(1);
      });
  });
};
