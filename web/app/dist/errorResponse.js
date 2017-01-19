"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});

exports.default = function (code, message, data) {
  return {
    error: true,
    code: code,
    message: message,
    data: data
  };
};