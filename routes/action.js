/**
 * Authenticate a Facebook login request
 */

var express = require('express');
var router = express.Router();
var user = require('../models/user');
var res;

function callback(response) {
    var json;

    if (response) {
        json = {err: false, success: true};
    } else {
        json = {err: true, success: false};
    }

    res.send(json);
}

router.all('/', function(req, response) {
    res = response;
    var json = {err: true, success: false};
    json = JSON.stringify(json, null, 3);

    if (!req.user || !req.user.socialHelper || !req.user.socialHelper.userID) {
        res.send(json);
        return false;
    }

    var userID = req.user.socialHelper.userID;
    var action;

    if (req.body.action) {
        action = req.body.action;
    } else if (req.query.action) {
        action = req.query.action;
    } else {
        res.send(json);
        return false;
    }

    var objectID;

    if (req.body.objectID) {
        objectID = req.body.objectID;
    } else if (req.query.objectID) {
        objectID = req.query.objectID;
    } else {
        switch (action) {
            case 'addTrackingQuery':
                if (req.body && req.body.accountID && req.body.query) {
                    user.addTrackingQuery('twitter', req.body.query, req.body.accountID, function(result) {
                        if (result) {
                            res.redirect('/');
                        } else {
                            res.send(json);
                        }
                    });
                } else {
                    res.send(json);
                }

                return;
            default:
                res.send(json);
                return;
        }
    }

    switch (action) {
        case 'remove':
            user.actionOnAllAccounts(action, objectID, userID, function(response) {
                callback(response);
            });

            return;
        case 'tweet':
            user.actionOnSpecifiedAccounts(action, objectID, userID, req.body['account[]'], function(response) {
                callback(response);
            });

            return;
        case 'retweet':
            user.actionOnSpecifiedAccounts(action, objectID, userID, req.body['account[]'], function(response) {
                callback(response);
            });

            return;
        case 'like':
            user.actionOnSpecifiedAccounts(action, objectID, userID, req.body['account[]'], function(response) {
                callback(response);
            });

            return;
        case 'save':
            user.actionOnAllAccounts(action, objectID, userID, function(response) {
                callback(response);
            });

            return;
        case 'follow':
            user.actionOnSpecifiedAccounts(action, objectID, userID, req.body['account[]'], function(response) {
                callback(response);
            });

            return;
        case 'similar':
            user.actionOnSpecifiedAccounts(action, objectID, userID, req.body['account[]'], function(response) {
                callback(response);
            });

            return;
        default:
            res.send(json);
            return;
    }

    res.send(json);
    return;
});

module.exports = router;
