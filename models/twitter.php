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
    private $connection_type = false;

    public function __construct($config) {
        $this->key = $config->twitter->key;
        $this->secret = $config->twitter->secret;
        $this->callback = $config->twitter->callback;
        $this->connection = new TwitterOAuth($this->key, $this->secret);
        $this->connection_type = 'temp';
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

            return $this->connection->oauth("oauth/access_token", $params);
        } else {
            return false;
        }
    }

    public function set_user_connection() {
        if('user' == $this->connection_type) {
            return true;
        } else {
            $this->connection = new TwitterOAuth(
                $this->key, 
                $this->secret, 
                $_SESSION['oauth_token'], 
                $_SESSION['oauth_token_secret']
            );

            $this->connection_type = 'user';
            return true;
        }
    }

    public function set_app_connection() {
        if('app' == $this->connection_type) {
            return true;
        } else {
            $result = $this->connection->oauth2('oauth2/token', array('grant_type' => 'client_credentials'));
            $this->connection_type = 'app';
            return true;
        }
    }

    public function get_tweets() {
        $this->set_app_connection();

        $tweet_response = $this->connection->get( "search/tweets", array( 
            'q' => '#iot filter:links -filter:retweets', 
            "count" => 10, 
            'exclude_replies' => TRUE,
            'lang' => 'en',
            'result_type' => 'recent',
        ));   

        print_r($tweet_response); exit;

    }
}
