<?php

class Tags {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function get_user_tags() {
        return array(
            array('tag' => 'iot', 'id' => 234),
            array('tag' => 'internetofthings', 'id' => 152),
            array('tag' => 'entrepreneurship', 'id' => 456),
            array('tag' => 'startup', 'id' => 223),
            array('tag' => 'improv', 'id' => 789),
        );
    }
}