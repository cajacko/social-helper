'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

exports.default = function (req, res) {
  var sess = req.session;

  _twitter.twitter.getAccessToken(sess.requestToken, sess.requestTokenSecret, req.query.oauth_verifier, function (error, accessToken, accessTokenSecret, results) {
    if (error) {
      res.json((0, _errorResponse2.default)(3, error));
    } else {
      _twitter.twitter.verifyCredentials(accessToken, accessTokenSecret, function (error, data, response) {
        if (error) {
          res.json((0, _errorResponse2.default)(4, error));
        } else {
          var postData = {
            username: data["screen_name"],
            twitter_id: data["id_str"],
            accessToken: accessToken,
            accessTokenSecret: accessTokenSecret
          };

          console.log(postData);

          (0, _postToAPI.postToAPI)('account/create', postData, req, function (response) {
            console.log(response);
            res.redirect('/error');
          }, function (body) {
            console.log(body);

            if (body.error) {
              return res.redirect('/error');
            }

            res.redirect('/');
          });
        }
      });
    }
  });
};

var _twitter = require('./twitter');

var _errorResponse = require('./errorResponse');

var _errorResponse2 = _interopRequireDefault(_errorResponse);

var _postToAPI = require('./postToAPI');

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }