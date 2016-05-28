<?php

namespace SocialHelper\Twitter;

class Twitter
{
    private $db;
    private $key;
    private $secret;
    private $callback;
    private $app_connection;
    private $user_connection;

    private function setTwitterAppConnection()
    {
        try {
            $this->app_connection = new \Abraham\TwitterOAuth\TwitterOAuth($this->key, $this->secret);
        } catch (Exception $e) {
            $this->app_connection = false;
        }

        return $this->app_connection;
    }

    public function __construct($config, $db)
    {
        $this->db = $db;
        $this->key = $config->twitter->key;
        $this->secret = $config->twitter->secret;
        $this->callback = $config->twitter->callback;
        $this->setTwitterAppConnection();
    }

    public function getAppConnection()
    {
        return $this->app_connection;
    }

    public function getLoginUrl()
    {
        if (!$this->app_connection) {
            return false;
        }

        try {
            $temporary_credentials = $this->app_connection->oauth(
                'oauth/request_token',
                array(
                    'oauth_callback' => $this->callback
                )
            );

            $url = $this->app_connection->url(
                'oauth/authorize',
                array(
                    'oauth_token' => $temporary_credentials['oauth_token']
                )
            );
        } catch (\Abraham\TwitterOAuth\TwitterOAuthException $e) {
            return false;
        }

        $url = filter_var($url, FILTER_VALIDATE_URL);

        if ($url) {
            return $url;
        }

        return false;
    }

    private function twitterValidateTokens($tokens)
    {
        if(!isset($tokens['oauth_token'])) {
            return false;
        }

        if(!isset($tokens['oauth_token_secret'])) {
            return false;
        }

        if(!isset($tokens['user_id'])) {
            return false;
        }

        if(!isset($tokens['screen_name'])) {
            return false;
        }

        return true;
    }

    public function twitterLogin()
    {
        if (!isset($_GET['oauth_token'], $_GET['oauth_verifier'])) {
            $error = new \SocialHelper\Error\Error(3);
            return $error->getError();
        }

        $this->user_connection = $this->app_connection;

        $params = array(
            "oauth_verifier" => $_GET['oauth_verifier'], 
            "oauth_token" => $_GET['oauth_token']
        );

        try {
            $tokens = $this->user_connection->oauth("oauth/access_token", $params);
        } catch (\Abraham\TwitterOAuth\TwitterOAuthException $e) {
            $error = new \SocialHelper\Error\Error(4);
            return $error->getError();
        }

        if (!$this->twitterValidateTokens($tokens)) {
            $error = new \SocialHelper\Error\Error(6);
            return $error->getError();
        }

        return $tokens;
    }
}
