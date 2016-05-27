<?php

namespace SocialHelper\User;

class User
{
    private $logged_in = false;

    public function isLoggedIn()
    {
        return $this->logged_in;
    }
}
