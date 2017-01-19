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

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function postFromFrontEnd(req, res) {
  var endpoint = req.params.controller + '/' + req.params.endpoint;

  postToAPI(endpoint, req.body, function (response) {
    res.json(response);
  }, function (body) {
    res.json(body);
  });
}

function postToAPI(endpoint, data, error, success) {
  var options = {
    url: process.env.API_DOMAIN + endpoint,
    headers: {},
    json: data
  };

  _request2.default.post(options, function (error, response, body) {
    if (error) {
      return error((0, _errorResponse2.default)(6, 'API returned an error', error));
    }

    if (response.statusCode != 200) {
      return error((0, _errorResponse2.default)(7, 'API did not return 200 status code', response));
    }

    success(body);
  });
}