/**
 * Define config details not be saved in version control
 */

var config = {};

config.MySql = {
    host: 'localhost',
    user: 'root',
    password: 'root',
    database: 'socialhelper'
};

config.twitter = {
    consumerKey: '',
    consumerSecret: ''
};

config.email = {
    host: '',
    port: '',
    secure: '', // use SSL
    auth: {
        user: '',
        pass: ''
    }
};

module.exports = config;
