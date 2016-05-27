/**
 * Run the php unit tests
 */
var config = require('../config.json');
var exec = require('child_process').exec;

module.exports = function(gulp) {
  gulp.task(config.gulpTasks.phpunit, function() {
    exec('phpunit --bootstrap src/autoload.php --colors=always ' + config.php.testsDir, function(error, stdout) {
      console.log(stdout);
    });
  });
};
