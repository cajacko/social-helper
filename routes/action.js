/**
 * Authenticate a Facebook login request
 */

var express = require('express');
var router = express.Router();
// var user = require('../models/user');

router.get('/', function(req, res) {
    // Get the user/register user if they do not already exist
    res.send('hello');
});

module.exports = router;
