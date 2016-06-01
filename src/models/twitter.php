<?php

namespace SocialHelper\Twitter;

class Twitter
{
    private $db;
    private $config;
    private $key;
    private $secret;
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

    private function ifTwitterLoginEchoResults()
    {
        foreach ($this->config->testsVars->twitterLoginEchoResults->query as $key => $value) {
            if (!isset($_GET[$key]) || $value != $_GET[$key]) {
                return false;
            }
        }

        return true;
    }

    private function isBrowserSync()
    {
        if (!$this->config->dev) {
            return false;
        }

        $browsersync_header = 'HTTP_' . $this->config->browsersync->header;

        if (!isset($_SERVER[$browsersync_header])) {
            return false;
        }

        $browsersync_port = $config->browsersync->port;

        if ($_SERVER[$browsersync_header] != $browsersync_port) {
            return false;
        }
    }

    public function __construct($config, $db)
    {
        $this->db = $db;
        $this->config = $config;
        $this->key = $config->twitter->key;
        $this->secret = $config->twitter->secret;
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

        if ($this->isBrowserSync()) {
            $callback = 'http://localhost:' . $this->config->browsersync->port;
        } else {
            $callback = $this->config->localhost;
        }

        $callback .= $this->config->twitter->callback;

        if ($this->ifTwitterLoginEchoResults()) {
            $callback_append = $this->config->testsVars->twitterLoginEchoResults->callbackAppendUrl;
            $callback = $callback . '/' . $callback_append;
        }

        try {
            $temporary_credentials = $this->app_connection->oauth(
                'oauth/request_token',
                array(
                    'oauth_callback' => $callback
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
        if (!isset($tokens['oauth_token'])) {
            return false;
        }

        if (!isset($tokens['oauth_token_secret'])) {
            return false;
        }

        if (!isset($tokens['user_id'])) {
            return false;
        }

        if (!isset($tokens['screen_name'])) {
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
