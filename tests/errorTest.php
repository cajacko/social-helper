<?php

// src/helpers/error
namespace SocialHelper\Error;

class ErrorTest extends \PHPUnit_Framework_TestCase
{
    private $config;

    public function setUp()
    {
        $config = new \SocialHelper\Config\Config;
        $this->config = $config->getConfig();
    }

    public function testHasClass()
    {
        new Error;
    }

    public function testErrorCode1BadTwitterRedirect()
    {
        $this->client = new \GuzzleHttp\Client([
          'allow_redirects' => false,
          'base_uri' => $this->config->localhost
        ]);
        $response = $this->client->get('/?action=tdd&error=1');
        $body = $response->getBody();
        $json = json_decode($body);
        $this->assertTrue($json->error);
    }
}
