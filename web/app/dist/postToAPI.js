'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

exports.postFromFrontEnd = postFromFrontEnd;
exports.postToAPI = postToAPI;

var _request = require('request');

var _request2 = _interopRequireDefault(_request);

var _errorResponse = require('./errorResponse');

var _errorResponse2 = _interopRequireDefault(_errorResponse);

var _filterLoginResponse = require('./filterLoginResponse');

var _filterLoginResponse2 = _interopRequireDefault(_filterLoginResponse);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function postFromFrontEnd(req, res) {
  var endpoint = req.params.controller + '/' + req.params.endpoint;

  postToAPI(endpoint, req.body, req, function (response) {
    res.json(response);
    res.end();
  }, function (body) {
    var data = body;

    switch (endpoint) {
      case 'user/login':
      case 'user/create':
        data = (0, _filterLoginResponse2.default)(body, req);
        break;

      case 'user/logout':
        req.session.destroy();
    }

    res.json(data);
  });
}

function postToAPI(endpoint, data, req, errorCallback, successCallback) {
  if (req.session.auth) {
    data.auth = req.session.auth;
  }

  if (process.env.APP_AUTH) {
    data.appAuth = process.env.APP_AUTH;
  }

  var options = {
    url: process.env.API_DOMAIN + endpoint,
    body: data,
    method: 'post',
    json: true
  };

  console.log("\n");
  console.log('POST');
  console.log(options);
  console.log(data);
  console.log("\n");

  _request2.default.post(options, function (error, response, body) {
    console.log("\n");
    console.log('POST RECIEVE');
    console.log(body);
    console.log("\n");

    if (error) {
      return errorCallback((0, _errorResponse2.default)(6, error));
    }

    if (response.statusCode != 200) {
      return errorCallback((0, _errorResponse2.default)(7, response));
    }

    if ((typeof body === 'undefined' ? 'undefined' : _typeof(body)) !== 'object') {
      return errorCallback((0, _errorResponse2.default)(20, response));
    }

    successCallback(body);
  });
}