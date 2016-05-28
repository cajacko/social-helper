var Browser = require('zombie');
var config = require('../config.json');
var chai = require('chai');
var assert = chai.assert;

describe('User visits twitter login', function() {
  this.timeout(10000);

  var browser = new Browser();

  before(function(done) {
    browser.visit(config.localhost, done);
  });

  describe('denies access', function() {

    before(function(done) {
      browser.pressButton('#cancel', function() {
        browser.clickLink('.button.maintain-context', done);
      });
    });

    it('should be successful', function() {
      browser.assert.success();
    });

    it('should return error', function() {
      var html = browser.html();
      html = html.replace('<html><head></head><body>', '');
      html = html.replace('</body></html>', '');
      var json = JSON.parse(html);

      assert.equal(json.error, true);
    });
  });
});

// Do a test with the ressponse echoes out in json via twitter/callback/tdd/
// Do another test to check redirect works via twitter/callback/tdd
describe('User visits twitter login', function() {
  this.timeout(10000);

  var browser = new Browser();

  before(function(done) {
    browser.visit(config.localhost, done);
  });

  describe('gives access', function() {

    before(function(done) {
      browser
        .fill('#username_or_email', config.twitter.testAccount.user)
        .fill('#password', config.twitter.testAccount.password)
        .pressButton('#allow', done);
    });

    it('should be successful', function() {
      browser.assert.success();
    });

    it('should redirect to logged in home', function() {
      browser.assert.status(200);
      browser.assert.url({ pathname: '/' });
    });
  });
});

var url = config.localhost + '?';
var queryParams = config.testsVars.twitterLoginEchoResults.query;

for (var k in queryParams) {
  url += k + '=' + queryParams[k] + '&';
}

url = url.slice(0, -1);

describe('User visits twitter login', function() {
  this.timeout(10000);

  var browser = new Browser();

  before(function(done) {
    browser.visit(url, done);
  });

  describe('gives access', function() {

    before(function(done) {
      browser
        .fill('#username_or_email', config.twitter.testAccount.user)
        .fill('#password', config.twitter.testAccount.password)
        .pressButton('#allow', done);
    });

    it('should be successful', function() {
      browser.assert.success();
    });

    it('should respond with valid session data', function() {
      var html = browser.html();
      html = html.replace('<html><head></head><body>', '');
      html = html.replace('</body></html>', '');
      var json = JSON.parse(html);

      assert.equal(json.loggedIn, true);
    });
  });
});
