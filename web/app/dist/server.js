'use strict';

var _fs = require('fs');

var _fs2 = _interopRequireDefault(_fs);

var _express = require('express');

var _express2 = _interopRequireDefault(_express);

var _http = require('http');

var _http2 = _interopRequireDefault(_http);

var _bodyParser = require('body-parser');

var _bodyParser2 = _interopRequireDefault(_bodyParser);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var app = (0, _express2.default)();
var server = _http2.default.Server(app);

app.use(_express2.default.static(__dirname + '/../public'));

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