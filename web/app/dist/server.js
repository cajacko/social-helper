'use strict';

var _environment = require('./environment');

var _environment2 = _interopRequireDefault(_environment);

var _express = require('express');

var _express2 = _interopRequireDefault(_express);

var _http = require('http');

var _http2 = _interopRequireDefault(_http);

var _bodyParser = require('body-parser');

var _bodyParser2 = _interopRequireDefault(_bodyParser);

var _expressSession = require('express-session');

var _expressSession2 = _interopRequireDefault(_expressSession);

var _postToAPI = require('./postToAPI');

var _serveHTML = require('./serveHTML');

var _serveHTML2 = _interopRequireDefault(_serveHTML);

var _twitterLogin = require('./twitterLogin');

var _twitterLogin2 = _interopRequireDefault(_twitterLogin);

var _twitterCallback = require('./twitterCallback');

var _twitterCallback2 = _interopRequireDefault(_twitterCallback);

var _sessionFileStore = require('session-file-store');

var _sessionFileStore2 = _interopRequireDefault(_sessionFileStore);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

// Initialise
var app = (0, _express2.default)();
var server = _http2.default.Server(app);
var FileStore = (0, _sessionFileStore2.default)(_expressSession2.default);

// Middleware
app.use(_express2.default.static(__dirname + '/../public'));

app.use((0, _expressSession2.default)({
  secret: process.env.SESSION_SECRET,
  store: new FileStore()
}));

app.use(_bodyParser2.default.json());

// Routes
app.get('/', _serveHTML2.default);
app.get('/auth/twitter/login', _twitterLogin2.default);
app.get('/auth/twitter/callback', _twitterCallback2.default);
app.post('/data/:controller/:endpoint', _postToAPI.postFromFrontEnd);

// Listen
server.listen(1337);