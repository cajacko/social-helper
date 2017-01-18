'use strict';

var _fs = require('fs');

var _fs2 = _interopRequireDefault(_fs);

var _express = require('express');

var _express2 = _interopRequireDefault(_express);

var _http = require('http');

var _http2 = _interopRequireDefault(_http);

var _bodyParser = require('body-parser');

var _bodyParser2 = _interopRequireDefault(_bodyParser);

var _nodeTwitterApi = require('node-twitter-api');

var _nodeTwitterApi2 = _interopRequireDefault(_nodeTwitterApi);

var _expressSession = require('express-session');

var _expressSession2 = _interopRequireDefault(_expressSession);

var _dotenv = require('dotenv');

var _dotenv2 = _interopRequireDefault(_dotenv);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

_dotenv2.default.config({
  path: __dirname + '/../../../.env'
});

var app = (0, _express2.default)();
var server = _http2.default.Server(app);

app.use(_express2.default.static(__dirname + '/../public'));
app.use((0, _expressSession2.default)({ secret: process.env.SESSION_SECRET }));
app.use(_bodyParser2.default.json());

app.get('/', function (req, res) {
  _fs2.default.readFile(__dirname + '/../public/index.html', function (err, data) {
    if (err) {
      res.writeHead(500);
      return res.end('Error loading index.html');
    }

    res.writeHead(200);
    res.end(data);
  });
});

var twitter = new _nodeTwitterApi2.default({
  consumerKey: process.env.CONSUMER_KEY,
  consumerSecret: process.env.CONSUMER_SECRET,
  callback: process.env.CALLBACK_DOMAIN + 'auth/twitter/callback'
});

var sess = void 0;

app.get('/auth/twitter/login', function (req, res) {
  sess = req.session;

  twitter.getRequestToken(function (error, requestToken, requestTokenSecret, results) {
    if (error) {
      console.log("Error getting OAuth request token : " + error);
      res.json({ hi: 'Error' });
    } else {
      //store token and tokenSecret somewhere, you'll need them later; redirect user

      sess.requestToken = requestToken;
      sess.requestTokenSecret = requestTokenSecret;

      var url = 'https://twitter.com/oauth/authorize?oauth_token=' + requestToken;

      res.redirect(url);
    }
  });
});

app.get('/auth/twitter/callback', function (req, res) {
  sess = req.session;

  twitter.getAccessToken(sess.requestToken, sess.requestTokenSecret, req.query.oauth_verifier, function (error, accessToken, accessTokenSecret, results) {
    if (error) {
      console.log(error);
      res.json({ hi: 'Error' });
    } else {
      console.log(accessToken, accessTokenSecret);

      twitter.verifyCredentials(accessToken, accessTokenSecret, function (error, data, response) {
        if (error) {
          console.log(error);
          res.json({ hi: 'Error' });
        } else {
          console.log(data["screen_name"]);
          res.redirect('/');
        }
      });
    }
  });
});

var defaultResponse = {
  cron: '5,10,30,55 7,8,9,11,12,13,16,17,18 * * *',
  accounts: [{
    id: '3986309467',
    username: 'charliejackson',
    queries: [{
      id: '234564',
      query: '#iot'
    }, {
      id: '48790957-u',
      query: '#smarthome'
    }]
  }],
  loggedIn: true
};

app.post('/data/user/login', function (req, res) {
  res.json(defaultResponse);
});

app.post('/data/user/create', function (req, res) {
  res.json(defaultResponse);
});

app.post('/data/user/read', function (req, res) {
  res.json(defaultResponse);
});

app.post('/data/user/logout', function (req, res) {
  res.json({
    loggedIn: false
  });
});

app.post('/data/query/create', function (req, res) {
  res.json(defaultResponse);
});

app.post('/data/query/update', function (req, res) {
  res.json(defaultResponse);
});

app.post('/data/query/delete', function (req, res) {
  res.json(defaultResponse);
});

app.post('/data/account/delete', function (req, res) {
  res.json(defaultResponse);
});

app.post('/data/account/create', function (req, res) {
  res.json(defaultResponse);
});

app.post('/data/cron/update', function (req, res) {
  res.json(defaultResponse);
});

server.listen(1337, function () {
  console.log('Example app listening on port 1337!');
});