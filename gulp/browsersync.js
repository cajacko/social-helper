var config = require('../config.json');
var browserSync = require('browser-sync');

module.exports = function(gulp) {
  gulp.task(config.gulpTasks.browsersync, function() {
    var header = {};
    header[config.browsersync.header] = config.browsersync.port;

    browserSync.init(null, {
      proxy: {
        target: config.localhost,
        reqHeaders: header
      },
      port: config.browsersync.port,
      files: ['.' + config.publicDir + '**/*.*'],
    });
  });
};
