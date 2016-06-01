<?php

// src/models/tags.php
namespace SocialHelper\Tags;

class TagsTest extends \PHPUnit_Framework_TestCase
{
    private $client;
    private $config;
    private $db;

    public function setUp()
    {
        $config = new \SocialHelper\Config\Config;
        $this->config = $config->getConfig();

        $db = new \SocialHelper\DB\Database($this->config);
        $this->db = $db->connect();

        $this->client = new \GuzzleHttp\Client([
          'allow_redirects' => false,
          'base_uri' => $this->config->localhost,
          'exceptions' => false
        ]);
    }

    public function testTagClassExists()
    {
        new Tag($this->config, $this->db);
    }

    public function testAddTagMethodExists()
    {
        $tag = new Tag($this->config, $this->db);

        $this->assertTrue(
            method_exists($tag, 'addTag'),
            'Class does not have method addTag'
        );
    }

    public function testAddTagFailsWithNoPostData()
    {
        $tag = new Tag($this->config, $this->db);
        $json = $tag->addTag();
        $this->assertTrue($json['error']);
    }

    public function testAddTagFailsWithBlankTag()
    {
        $request = $this->client->request('POST', '/action/add-tracking-tag', [
            'form_params' => [
                'tag' => ''
            ]
        ]);

        $body = (string) $request->getBody();
        $json = json_decode($body);
        $this->assertTrue($json->error);
    }

    public function testAddTagFailsWithNoLoggedInUser()
    {
        $request = $this->client->request('POST', '/action/add-tracking-tag', [
            'form_params' => [
                'tag' => 'figglechief'
            ]
        ]);

        $body = (string) $request->getBody();
        $json = json_decode($body);
        $this->assertTrue($json->error);
    }
}
