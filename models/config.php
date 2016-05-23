<?php

date_default_timezone_set('Europe/London');

class Config {
    public $config;

    public function get_json() {
        $config = file_get_contents('config.json', true);
        return $config;
    }

    public function json_to_object() {
        $config = $this->get_json();
        return json_decode($config);
    }

    public function __construct() {
        $config = $this->json_to_object();
        $this->config = $config;
    }
}
