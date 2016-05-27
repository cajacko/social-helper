<?php

// src/public/index.php
namespace SocialHelper\DB;

class DatabaseTest extends \PHPUnit_Framework_TestCase
{
    private $config;

    public function setUp()
    {
        $config = new \SocialHelper\Config\Config;
        $this->config = $config->getConfig();
    }

    public function testDBClassExists()
    {
        new Database($this->config);
    }

    /**
     * @depends testDBClassExists
     */
    public function testDBConnection()
    {
        $db = new Database($this->config);
        $db = $db->connect();
        $error = $db->connect_error;
    }
}
