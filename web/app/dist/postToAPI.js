'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
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

    if (endpoint == 'user/login') {
      data = (0, _filterLoginResponse2.default)(body, req);
    }

    if (endpoint == 'user/logout') {
      req.session.destroy();
    }

    res.json(data);
  });
}

function postToAPI(endpoint, data, req, errorCallback, successCallback) {
  if (req.session.auth) {
    data.auth = req.session.auth;
  }

  var options = {
    url: process.env.API_DOMAIN + endpoint,
    json: data
  };

  console.log(options);

  _request2.default.post(options, function (error, response, body) {
    if (error) {
      return errorCallback((0, _errorResponse2.default)(6, 'API returned an error', error));
    }

    if (response.statusCode != 200) {
      return errorCallback((0, _errorResponse2.default)(7, 'API did not return 200 status code', response));
    }

    successCallback(body);
  });
}