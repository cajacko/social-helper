var config = require('../config.json');
var login = require('./login');

var tag = 'tag' + Date.now();
var id = '#TrackingTags-tag--' + tag;

describe('User logs in', function() {
  this.timeout(10000);

  var browser;

  before(function(done) {
    login(function(newBrowser) {
      browser = newBrowser;
      done();
    });
  });

  it('successfully', function() {
    browser.assert.success();
  });

  describe('adds tag', function() {
    before(function(done) {
      browser
        .fill('#TrackingTags-input', tag)
        .pressButton('#TrackingTags-submit', function() {
          setTimeout(function() {
            done();
          }, 1000);
        });
    });

    it('should be displayed in the list', function() {
      browser.assert.element(id);
    });

    describe('refreshes page', function() {
      before(function(done) {
        browser.visit(config.localhost, done);
      });

      it('should be displayed in the list', function() {
        browser.assert.element(id);
      });
    });
  });
});
