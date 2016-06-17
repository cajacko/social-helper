/**
 * Define all the routes and which scripts control them.
 *
 * Display the home page
 */

var express = require('express');
var router = express.Router();
var user = require('../models/user');
// var story = require('../models/story');
var passport = require('passport');
// var Strategy = require('passport-twitter').Strategy;

router.get('/login/twitter', passport.authenticate('twitter'));
router.use('/login/twitter/callback', require('./twitter-callback')); // Facebook login redirect
router.use('/action', require('./action')); // Save an entry

// Display the home page
router.get('/', function(req, res) {
    if (req.user && req.user.socialHelper && req.user.socialHelper.userID) {
        var userID = req.user.socialHelper.userID;

        user.getUserAccounts(userID, function(userAccounts) {
            if (userAccounts) {
                user.getTrackingQueries(userID, function(userTrackingQueries) {
                    if (userTrackingQueries) {
                        user.getObjects(function(objects) {
                            if (objects) {
                                res.render('pages/dashboard', {
                                    vars: {
                                        trackingQueries: false,
                                        userAccounts: userAccounts,
                                        userTrackingQueries: userTrackingQueries,
                                        objects: objects
                                    }
                                });
                            } else {
                                res.send('error');
                            }
                        });
                    } else {
                        res.send('error');
                    }
                });
            } else {
                res.send('error');
            }
        });
    } else {
        res.redirect('/login/twitter');
    }
});

module.exports = router;
