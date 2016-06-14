/**
 * Process all the interactions with the database that involve users
 */

/*
Tweet
Retweet
Like
Follow
Save
*/

var db = require('../models/db'); // Load the database connection
// var config = require('../config');

exports.getObjects = function(next) {
    var query = '';
    query += 'SELECT * FROM userObjects LIMIT 10;';

    db.query(query, function(err, rows) {
        // If there was a MySQL error the return false
        if (err) {
            next(false);
        } else {
            next(rows);
        }
    });
};

exports.getTrackingQueries = function(userID, next) {
    var query = '';
    query += 'SELECT * FROM userTrackingQueries WHERE userID = ?;';
    var values = [userID];

    db.query(query, values, function(err, rows) {
        // If there was a MySQL error the return false
        if (err) {
            next(false);
        } else {
            next(rows);
        }
    });
};

exports.getTrackingQueries = function(userID, next) {
    var query = '';
    query += 'SELECT * FROM userTrackingQueries WHERE userID = ?;';
    var values = [userID];

    db.query(query, values, function(err, rows) {
        // If there was a MySQL error the return false
        if (err) {
            next(false);
        } else {
            next(rows);
        }
    });
};

exports.addTrackingQuery = function(trackingType, trackingQuery, accountID, next) {
    var query = '';
    query += 'CALL addTrackingQuery(?, ?, ?);';
    var values = [trackingType, trackingQuery, accountID];

    db.beginTransaction(function(err) {
        if (err) {
            console.log('1');
            next(false);
        } else {
            // No user was found with that facebook id, so add them
            db.query(query, values, function(err) {
                // If there was a MySQL error the return false
                if (err) {
                    console.log(err);

                    db.rollback(function() {
                        console.log('2');
                        next(false);
                    });
                } else {
                    db.commit(function(err) {
                        if (err) {
                            db.rollback(function() {
                                console.log('3');
                                next(false);
                            });
                        } else {
                            next(true);
                        }
                    });
                }
            });
        }
    });
};

exports.getUserAccounts = function(userID, next) {
    var query = '';
    query += 'SELECT accountID, metaValue as accountName, type FROM userAccountsMeta WHERE metaKey = "accountName" AND accountID = ?;';
    var values = [userID];

    db.query(query, values, function(err, rows) {
        // If there was a MySQL error the return false
        if (err) {
            next(false);
        } else {
            next(rows);
        }
    });
};

function insertUser(email, password, next) {
    var query = '';
    query += 'INSERT INTO users (primaryEmail, password, dateAdded, dateUpdated) ';
    query += 'VALUES (?, ?, ?, ?)';
    query += 'ON DUPLICATE KEY UPDATE dateUpdated = ?';
    var date = '2016-01-01 00:00:00';
    var values = [email, password, date, date, date];

    db.beginTransaction(function(err) {
        if (err) {
            next(false);
        } else {
            // No user was found with that facebook id, so add them
            db.query(query, values, function(err) {
                // If there was a MySQL error the return false
                if (err) {
                    db.rollback(function() {
                        next(false);
                    });
                } else {
                    db.commit(function(err) {
                        if (err) {
                            db.rollback(function() {
                                next(false);
                            });
                        } else {
                            // Insert was successful so return user
                            var user = 1;
                            next(user);
                        }
                    });
                }
            });
        }
    });
}

function addTwitterAccount(userID, twitterID, secret, token, screenName, next) {
    var query = '';
    query += 'CALL addTwitterAccount(?, ?, ?, ?, ?);';
    var values = [userID, twitterID, secret, token, screenName];

    db.beginTransaction(function(err) {
        if (err) {
            next(false);
        } else {
            // No user was found with that facebook id, so add them
            db.query(query, values, function(err) {
                // If there was a MySQL error the return false
                if (err) {
                    db.rollback(function() {
                        next(false);
                    });
                } else {
                    db.commit(function(err) {
                        if (err) {
                            db.rollback(function() {
                                next(false);
                            });
                        } else {
                            next(true);
                        }
                    });
                }
            });
        }
    });
}

function updateUser(token, tokenSecret, profile, cb) {
    if (profile.id == '53987352') {
        // Define the query
        insertUser('test@example.com', 'password', function(userID) {
            if (userID) {
                addTwitterAccount(userID, profile.id, tokenSecret, token, profile.username, function(successful) {
                    if (successful) {
                        if (!profile.socialHelper) {
                            profile.socialHelper = {};
                        }

                        profile.socialHelper.userID = userID;
                        cb(null, profile);
                    } else {
                        cb();
                    }
                });
            } else {
                cb();
            }
        });
    } else {
        cb();
    }
}

exports.updateUser = function(token, tokenSecret, profile, cb) {
    updateUser(token, tokenSecret, profile, cb);
};

// Get the current user
exports.getUser = function(req, next) {
    /**
     * If there is a user in the request then set them up. This
     * req.user gets set up by passbook-facebook when someone
     * is logged in with their facebook id.
     *
     * If there isn't a user then perform the callback whilst
     * passing false
     */
    if (req.user) {

        console.log(req.user);
        // // Define the query
        // var query = '';
        // query += 'SELECT * ';
        // query += 'FROM users ';
        // query += 'WHERE facebook_id = ?';

        // // Get the user based off their facebook id
        // db.query(query, [req.user._json.id], function(err, rows) {
        //     // If there is a query user then return false
        //     if (err) {
        //         next(false);
        //     }
        //     // If a user was found then return the user details
        //     else if (rows.length) {
        //         // Set up user details
        //         var user = {
        //             id: rows[0].id,
        //             facebookId: rows[0].facebook_id,
        //             displayName: rows[0].display_name,
        //             firstName: rows[0].first_name,
        //             lastName: rows[0].last_name,
        //             email: rows[0].email
        //         };

        //         next(user);
        //     } else {
        //         // Define the query
        //         var query = '';
        //         query += 'INSERT INTO users (facebook_id, display_name, first_name, last_name, email) ';
        //         query += 'VALUES (?, ?, ?, ?, ?)';

        //         var values = [req.user._json.id, req.user._json.name, req.user._json.first_name, req.user._json.last_name, req.user._json.email];

        //         // No user was found with that facebook id, so add them
        //         db.query(query, values, function(err, result) {
        //             // If there was a MySQL error the return false
        //             if (err) {
        //                 next(false);
        //             } else {
        //                 // Insert was successful so return user
        //                 var user = {
        //                     id: result.insertId,
        //                     facebookId: req.user._json.id,
        //                     displayName: req.user._json.name,
        //                     firstName: req.user._json.first_name,
        //                     lastName: req.user._json.last_name,
        //                     email: req.user._json.email
        //                 };

        //                 next(user);
        //             }
        //         });
        //     }
        // });
    } else {
        next(false);
    }
};
