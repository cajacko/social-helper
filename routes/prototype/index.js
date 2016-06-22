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

module.exports = router;
