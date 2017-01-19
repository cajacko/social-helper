"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});

exports.default = function (response, req) {
  var data = response;

  var auth = data.auth;
  req.session.auth = auth;

  delete data.auth;

  return data;
};