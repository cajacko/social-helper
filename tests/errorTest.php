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

    public function doesJsonValueExist($json, $key)
    {
        if (isset($json->$key)) {
            $value = true;
        } else {
            $value = false;
        }

        return $value;
    }
}
