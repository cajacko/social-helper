var Browser = require('zombie');
var config = require('../config.json');

module.exports = function(cb) {
  var browser = new Browser();
  browser.visit(config.localhost, function() {
    browser
        .fill('#username_or_email', config.twitter.testAccount.user)
        .fill('#password', config.twitter.testAccount.password)
        .pressButton('#allow', function() {
          cb(browser);
        });
  });
};
