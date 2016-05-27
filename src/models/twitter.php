<?php

namespace SocialHelper\Twitter;

class Twitter
{
    private $db;
    private $key;
    private $secret;
    private $callback;
    private $app_connection;

    public function __construct($config, $db)
    {
        $this->db = $db;
        $this->key = $config->twitter->key;
        $this->secret = $config->twitter->secret;
        $this->callback = $config->twitter->callback;
        $this->app_connection = new \Abraham\TwitterOAuth\TwitterOAuth($this->key, $this->secret);
    }

    public function getAppConnection()
    {
        return $this->app_connection;
    }

    public function loginUrl()
    {
        $temporary_credentials = $this->app_connection->oauth(
            'oauth/request_token',
            array(
                'oauth_callback' => $this->callback
            )
        );

        return $this->app_connection->url(
            'oauth/authorize',
            array(
                'oauth_token' => $temporary_credentials['oauth_token']
            )
        );
    }
}
