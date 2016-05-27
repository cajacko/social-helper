<?php

namespace SocialHelper\Config;

class Config
{
    public function getConfig()
    {
        $config = file_get_contents('config.json', true);
        return json_decode($config);
    }
}
