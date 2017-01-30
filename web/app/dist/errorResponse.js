'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

exports.default = function (code) {
  var data = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

  var error;

  if (!_errors2.default) {
    error = {
      status: 200,
      code: 0,
      message: 'Could not load errors',
      data: {
        code: code,
        data: data
      }
    };
  } else if (!code) {
    error = {
      code: 0,
      status: 200,
      message: 'No error code given',
      data: data
    };
  } else if (!_errors2.default[code]) {
    error = {
      code: 0,
      status: 200,
      message: 'Error code does not exist',
      data: {
        code: code,
        data: data
      }
    };
  } else {
    error = _errors2.default[code];
    error.data = data;
  }

  error.error = true;

  return error;
};

var _errors = require('./errors');

var _errors2 = _interopRequireDefault(_errors);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }