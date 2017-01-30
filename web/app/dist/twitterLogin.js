'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

exports.default = function (req, res) {
  var sess = req.session;

  _twitter.twitter.getRequestToken(function (error, requestToken, requestTokenSecret, results) {
    if (error) {
      res.json((0, _errorResponse2.default)(2, error));
    } else {
      sess.requestToken = requestToken;
      sess.requestTokenSecret = requestTokenSecret;

      var url = 'https://twitter.com/oauth/authorize?oauth_token=' + requestToken;

      res.redirect(url);
    }
  });
};

var _twitter = require('./twitter');

var _errorResponse = require('./errorResponse');

var _errorResponse2 = _interopRequireDefault(_errorResponse);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }