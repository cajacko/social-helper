/**
 * Authenticate a Facebook login request
 */

var express = require('express');
var router = express.Router();
var user = require('../models/user');

router.post('/', function(req, res) {
    if (req.body && req.body.accountID && req.body.query && req.user && req.user.socialHelper && req.user.socialHelper.userID) {
        user.addTrackingQuery('twitter', req.body.query, req.body.accountID, function(result) {
            if (result) {
                res.redirect('/');
            } else {
                res.send('error saving');
            }
        });
    } else {
        res.send('error');
    }
});

module.exports = router;
