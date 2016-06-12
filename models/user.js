/**
 * Process all the interactions with the database that involve users
 */

var db = require('../models/db'); // Load the database connection
var config = require('../config');

function updateUser(token, tokenSecret, userID, cb) {

    cb();
}

exports.updateUser = function(token, tokenSecret, userID, cb) {
    updateUser(token, tokenSecret, userID, cb);
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
