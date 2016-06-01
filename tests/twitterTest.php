<?php

// src/models/twitter.php
namespace SocialHelper\Twitter;

class TwitterTest extends \PHPUnit_Framework_TestCase
{
    private $config;
    private $db;

    public function setUp()
    {
        $config = new \SocialHelper\Config\Config;
        $this->config = $config->getConfig();

        $config = new \SocialHelper\DB\Database($this->config);
        $this->db = $config->connect();
    }

    public function testGetTwitterClass()
    {
        new Twitter($this->config, $this->db);
    }

    /**
     * @depends testGetTwitterClass
     */
    public function testSetupTwitterConnection()
    {
        $twitter = new Twitter($this->config, $this->db);
        $connection = $twitter->getAppConnection();
        $this->assertInternalType('object', $connection);
    }

    /**
     * @depends testSetupTwitterConnection
     */
    public function testTwitterAppConnection()
    {
        $twitter = new Twitter($this->config, $this->db);
        $connection = $twitter->getAppConnection();
        $statuses = $connection->get('search/tweets', ['q' => 'tech', 'count' => 1]);

        if (isset($statuses->statuses)) {
            $app_connection = true;
        } else {
            $app_connection = false;
        }

        $this->assertTrue($app_connection);
    }

    /**
     * @depends testGetTwitterClass
     */
    public function testGetTwitterLoginUrl()
    {
        $twitter = new Twitter($this->config, $this->db);
        $url = $twitter->getLoginUrl();
        $url = filter_var($url, FILTER_VALIDATE_URL);

        if ($url) {
            $is_url = true;
        } else {
            $is_url = false;
        }

        $this->assertTrue($is_url);
    }

    public function testTwitterLoginMethod()
    {
        $twitter = new Twitter($this->config, $this->db);

        $this->assertTrue(
            method_exists($twitter, 'twitterLogin'), 
            'Class does not have method myFunction'
        );
    }

    /**
     * @depends testTwitterLoginMethod
     */
    public function testTwitterLoginNoGet()
    {
        $twitter = new Twitter($this->config, $this->db);
        $response = $twitter->twitterLogin();

        if (isset($response['error'])) {
            $is_error = true;
        } else {
            $is_error = false;
        }

        $this->assertTrue($is_error);
    }
}
