<?php

namespace SocialHelper\Error;

class Error
{
    public function __construct()
    {
        $json = array('error' => true);
        echo json_encode($json);
    }
}
