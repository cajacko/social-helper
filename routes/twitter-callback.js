/**
 * Authenticate a Facebook login request
 */

var express = require('express');
var router = express.Router();
var passport = require('passport');
// var user = require('../models/user');

router.get('/', passport.authenticate('twitter', {failureRedirect: '/login/twitter'}), function(req, res) {
    // Get the user/register user if they do not already exist
    res.redirect('/');

    // user.getUser(req, function(user) {
    //     // If the request has been successful then redirect to the home page, otherwise return an error
    //     if (user) {
    //         res.redirect('/');
    //     } else {
    //         // Error saving/logging in user
    //         res.send('Error logging in/registering user');
    //     }
    // });
});

module.exports = router;
