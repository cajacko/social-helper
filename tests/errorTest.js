var Browser = require('zombie');
var config = require('../config.json');

describe('Visiting error test page', function() {
  this.timeout(10000);

  var browser = new Browser();

  before(function(done) {
    browser.visit(config.localhost + '/?action=tdd&error=1', done);
  });

  it('should be successful', function() {
    browser.assert.success();
  });

  it('should show an error', function() {
    browser.assert.element('.Error-code');
    browser.assert.element('.Error-group');
    browser.assert.element('.Error-title');
    browser.assert.element('.Error-message');
  });

  it('should have the correct error code', function() {
    browser.assert.text('.Error-code', '1');
  });
});
