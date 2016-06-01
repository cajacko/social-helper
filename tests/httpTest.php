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
          'base_uri' => $this->config->localhost,
          'exceptions' => false
        ]);
    }

    public function testLoggedOutUserRedirect()
    {
        $response = $this->client->get('/');
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test404()
    {
        $response = $this->client->get('/fiufroiurho');
        $this->assertEquals(404, $response->getStatusCode());
    }
}
