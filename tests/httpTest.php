<?php

// src/public/index.php
namespace SocialHelper\Homepage;

class HomePage extends \PHPUnit_Framework_TestCase
{
    private $client;

    public function setUp()
    {
        $this->client = new \GuzzleHttp\Client([
          'allow_redirects' => false,
          'base_uri' => 'http://social-helper.local.com'
        ]);
    }

    public function testValidHomePageResponse()
    {
        $response = $this->client->get('/');
        $this->assertEquals(200, $response->getStatusCode());
    }

    // public function testLoggedOutUserRedirect()
    // {
    //     $this->client = new \GuzzleHttp\Client;
    // }
}
