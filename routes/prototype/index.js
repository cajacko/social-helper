/**
 * Authenticate a Facebook login request
 */

var express = require('express');
var router = express.Router();

router.get('/', function(req, res) {
    res.render('pages/home', {
        vars: {
            title: 'Social Helper',
            mantra: 'The easy way to make social media work for you',
            loginForm: {
                emailLabel: 'Email address',
                emailPlaceholder: 'Email',
                passwordLabel: 'Password',
                passwordPlaceholder: 'Password',
                registerText: 'Don\'t have an account yet?',
                registerButtonText: 'Register'
            },
            registerForm: {
                emailLabel: 'Email address',
                emailPlaceholder: 'Email',
                passwordLabel: 'Password',
                passwordPlaceholder: 'Password',
                passwordConfirmLabel: 'Password Confirmation',
                passwordConfirmPlaceholder: 'Password Confirmation',
                loginText: 'Already have an account?',
                loginButtonText: 'Login'
            }
        }
    });
});

router.get('/dashboard', function(req, res) {
    res.render('pages/dashboard', {
        vars: {
            
        }
    });
});

router.post('/action/get-objects', function(req, res) {
    var json = {
        success: true,
        objects: [
            {
                type: 'link',
                link: 'http://apple.com/'
            },
            {
                type: 'link',
                link: 'http://apple.com/'
            },
            {
                type: 'link',
                link: 'http://apple.com/'
            }
        ]
    };

    res.setHeader('Content-Type', 'application/json');
    res.send(JSON.stringify(json, null, 3));
});

module.exports = router;
