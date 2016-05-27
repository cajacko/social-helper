/**
 * Run the php unit tests
 */
var config = require('../config.json');
var util = require('util');
var exec = require('child_process').exec;

module.exports = function(gulp) {
  gulp.task(config.gulpTasks.phpunit, function() {
    exec('phpunit ' + config.php.testsDir + '/init.php', function(error, stdout) {
      util.puts(stdout);
    });
  });
};
