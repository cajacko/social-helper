<?php

// src/public/index.php
namespace SocialHelper\Homepage;

class HomePage extends \PHPUnit_Framework_TestCase
{
    private $client;
    private $config;

    public function setUp()
    {
        $config = new \SocialHelper\Config\Config;
        $this->config = $config->getConfig();

        $this->client = new \GuzzleHttp\Client([
          'allow_redirects' => false,
          'base_uri' => $this->config->localhost
        ]);
    }

    public function testLoggedOutUserRedirect()
    {
        $response = $this->client->get('/');
        $this->assertEquals(302, $response->getStatusCode());
    }
}
