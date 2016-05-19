<?php

require_once('../vendor/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter {
    private $key;
    private $secret;
    private $callback;
    private $connection;
    private $db;
    private $token;
    private $token_secret;

    public function __construct($config) {
        $this->key = $config->twitter->key;
        $this->secret = $config->twitter->secret;
        $this->callback = $config->twitter->callback;
        $this->connection = new TwitterOAuth($this->key, $this->secret);
    }

    public function login_url() {
        $temporary_credentials = $this->connection->oauth('oauth/request_token', array("oauth_callback" => $this->callback));
        $_SESSION['oauth_token'] = $temporary_credentials['oauth_token'];       
        $_SESSION['oauth_token_secret'] = $temporary_credentials['oauth_token_secret'];
        return $this->connection->url("oauth/authorize", array("oauth_token" => $temporary_credentials['oauth_token']));       
    }

    public function login() {
        $url = $this->login_url();
        header('Location: ' . $url); 
        exit;
    }

    public function get_tokens() {
        if(isset($_GET['oauth_verifier'], $_GET['oauth_token'])) {
            $params = array(
                "oauth_verifier" => $_GET['oauth_verifier'], 
                "oauth_token" => $_GET['oauth_token']
            );

            $access_token = $this->connection->oauth("oauth/access_token", $params);
            $this->token = $access_token['oauth_token'];
            $this->token_secret = $access_token['oauth_token_secret'];

            $_SESSION['oauth_token'] = $this->token;
            $_SESSION['oauth_token_secret'] = $this->token_secret;
        } elseif(isset($_SESSION['oauth_token'], $_SESSION['oauth_token_secret'])) {
            $access_token = array(
                'oauth_token' => $_SESSION['oauth_token'], 
                'oauth_token_secret' => $_SESSION['oauth_token_secret']
            );

            $this->token = $_SESSION['oauth_token'];
            $this->token_secret = $_SESSION['oauth_token_secret'];
        } else {
            return false;
        }

        $this->connection = new TwitterOAuth(
            $this->key, $this->secret, 
            $this->token, 
            $this->token_secret
        );

        return $access_token;
    }

    public function get_user() {        
        $content = $this->connection->get("account/verify_credentials");
        return $content;
    }

    public function get_twitter_user() {
        $tokens = $this->get_tokens();

        if($tokens) {
            return $this->get_user();
        } else {
            return false;
        }
    }
}
