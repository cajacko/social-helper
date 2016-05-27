<?php

namespace SocialHelper\Config;

class Config
{
    private $config;

    public function __construct()
    {
        $config = file_get_contents('config.json', true);
        $this->config = json_decode($config);
        $this->adjustConfigForTDD();
    }

    public function adjustConfigForTDD()
    {
        if (!isset($this->config->dev) || !$this->config->dev) {
            return false;
        }

        if (!isset($_GET['action']) || 'tdd' != $_GET['action']) {
            return false;
        }

        if (isset($_GET['error']) && is_numeric($_GET['error'])) {
            $error = $_GET['error'];
        } else {
            return false;
        }

        switch ($error) {
            case 1:
                $this->config->twitter->key = 'dfouhgroiuroirhoir';
                break;
        }

        return $this->config;
    }

    public function getConfig()
    {
        return $this->config;
    }
}
