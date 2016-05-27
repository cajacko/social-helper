<?php

namespace Application\Tests;

class TestSetup extends PHPUnit_Framework_TestCase
{
    private $composer_file = '../composer.json';

    public function testComposerExists()
    {
        $this->assertFileExists($this->composer_file);
    }

    public function testComposerValid()
    {
        $composer = file_get_contents($this->composer_file);
        $json = json_decode($composer);

        if ($json) {
            $response = true;
        } else {
            $response = false;
        }

        $this->assertTrue($response);
    }
}
