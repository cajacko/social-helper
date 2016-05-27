<?php

// src/models/user
namespace SocialHelper\User;

class LoggedInTest extends \PHPUnit_Framework_TestCase
{
    public function testHasUserClass()
    {
        new User;
    }

    public function testUserLoggedOut()
    {
        $user = new User;
        $this->assertFalse($user->isLoggedIn());
    }
}
