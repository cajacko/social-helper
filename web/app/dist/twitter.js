'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.twitter = undefined;

var _nodeTwitterApi = require('node-twitter-api');

var _nodeTwitterApi2 = _interopRequireDefault(_nodeTwitterApi);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var twitter = exports.twitter = new _nodeTwitterApi2.default({
  consumerKey: process.env.CONSUMER_KEY,
  consumerSecret: process.env.CONSUMER_SECRET,
  callback: process.env.CALLBACK_DOMAIN + 'auth/twitter/callback'
});